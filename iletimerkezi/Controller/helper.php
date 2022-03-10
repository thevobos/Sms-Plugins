<?php
/**
 * Created by PhpStorm.
 * User: cengizakcan
 * Date: 4.05.2020
 * Time: 02:17
 */

namespace App\Main\Plugin\iletimerkezi\Controller;

use App\Main\Model\plugin;
use App\Main\Plugin\iletimerkezi\Model\api;
use Fix\Support\Header;


class helper {

    public function __construct(){

        // return $this->__construct();


    }

    public static function install($username = null, $password = null, $title = null){

        if(is_null($username) || is_null($password) || is_null($title)){

            return false;

        }

        if(!plugin::get_tmp_storage($_SESSION["cms_auth_site"],"iletimerkezi_username")){
            plugin::add_tmp_storage($_SESSION["cms_auth_site"],"iletimerkezi_username",$username);
        }


        if(!plugin::get_tmp_storage($_SESSION["cms_auth_site"],"iletimerkezi_password")){
            plugin::add_tmp_storage($_SESSION["cms_auth_site"],"iletimerkezi_password",$password);
        }


        if(!plugin::get_tmp_storage($_SESSION["cms_auth_site"],"iletimerkezi_title")){
            plugin::add_tmp_storage($_SESSION["cms_auth_site"],"iletimerkezi_title",$title);
        }


    }



    public static function getBalance(){

        $username   = plugin::get_tmp_storage($_SESSION["cms_auth_site"],"iletimerkezi_username");
        $password   = plugin::get_tmp_storage($_SESSION["cms_auth_site"],"iletimerkezi_password");
        $title      = plugin::get_tmp_storage($_SESSION["cms_auth_site"],"iletimerkezi_title");


        $api = new api();

        $result = $api->url("status")
            ->username($username)
            ->password($password)
            ->status()
            ->send();


        return json_decode(json_encode(($result)));

    }

    public static function send(){

        try{

            Header::checkParameter($_POST,["numbers","message"]);
            Header::checkValue($_POST,["numbers","message"]);


            $username   = plugin::get_tmp_storage($_SESSION["cms_auth_site"],"iletimerkezi_username");
            $password   = plugin::get_tmp_storage($_SESSION["cms_auth_site"],"iletimerkezi_password");
            $title      = plugin::get_tmp_storage($_SESSION["cms_auth_site"],"iletimerkezi_title");

            $api        = new api();

            $Sms = $api
                ->url("send")
                ->username($username)
                ->password($password)
                ->title($title)
                ->addnumber(explode(",",$_POST["numbers"]))
                ->text($_POST["message"])
                ->sms()
                ->send();

            if(json_decode(json_encode($Sms))->status->code !== "200"){
                throw new \Exception(json_decode(json_encode($Sms))->status->message);
            }

            Header::jsonResult("success","Başarılı","Mesaj gönderildi");

        }catch (\Exception $exception){

            Header::jsonResult("error","Hata",$exception->getMessage());
        }

    }

    public static function setup(){

        try{

            Header::checkParameter($_POST,["username","password","title","test"]);
            Header::checkValue($_POST,["username","password","title","test"]);

            $api        = new api();

            $result = $api->url("status")
                ->username($_POST["username"])
                ->password($_POST["password"])
                ->status()
                ->send();


            if(json_decode(json_encode($result))->status->code !== "200"){
                throw new \Exception(json_decode(json_encode($result))->status->message);
            }

            $Sms = $api
                ->url("send")
                ->username($_POST["username"])
                ->password($_POST["password"])
                ->title($_POST["title"])
                ->addnumber(explode(",",$_POST["test"]))
                ->text("Test")
                ->sms()
                ->send();

            if(json_decode(json_encode($Sms))->status->code !== "200"){
                throw new \Exception(json_decode(json_encode($Sms))->status->message);
            }

            plugin::add_tmp_storage($_SESSION["cms_auth_site"],"iletimerkezi_username",$_POST["username"]);
            plugin::add_tmp_storage($_SESSION["cms_auth_site"],"iletimerkezi_password",$_POST["password"]);
            plugin::add_tmp_storage($_SESSION["cms_auth_site"],"iletimerkezi_title",$_POST["title"]);

            Header::jsonResult("success","Başarılı","Veriler Kaydedildi");

        }catch (\Exception $exception){

            Header::jsonResult("error","Hata",$exception->getMessage());
        }

    }

}