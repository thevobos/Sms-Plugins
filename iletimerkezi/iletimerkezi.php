<?php


namespace App\Main\Plugin\iletimerkezi;

use App\Main\Model\plugin;
use App\Main\Plugin\iletimerkezi\Controller\helper;


plugin::info([
    "title" => "İleti Merkezi SMS",
    "slug" => plugin::get_name(__DIR__)
]);

// Yönetici Oturum Kontrolü
if(isset($_SESSION["cms_auth_site"])){

    // Eklenti veri kontrolü
    $username   = plugin::get_tmp_storage($_SESSION["cms_auth_site"],"iletimerkezi_username");
    $password   = plugin::get_tmp_storage($_SESSION["cms_auth_site"],"iletimerkezi_password");
    $title      = plugin::get_tmp_storage($_SESSION["cms_auth_site"],"iletimerkezi_title");

    Plugin::add_menu([
        [
            "permission"    => "iletimerkezi_plugin",
            "title"         => "İleti Merkezi (SMS)",
            "url"           => "iletimerkezi@dashboard",
            "icon"          => "mail"
        ]
    ]);

    plugin::add_js([
        "/App/Main/Plugin/iletimerkezi/Assets/app.js"
    ]);

    plugin::add_user_permission([
        [
            "label" => "İleti Merkezi Gönderme",
            "value" => "iletimerkezi_plugin"
        ]
    ]);

    if($username && $password && $title){

        if(plugin::check_permission($_SESSION["cms_auth_uuid"],"iletimerkezi_plugin") or (plugin::check_type($_SESSION["cms_auth_uuid"],"admin") or plugin::check_type($_SESSION["cms_auth_uuid"],"root"))){

            plugin::action("dashboard@widget",function (){
                echo "<div class='iletimerkeziWidget col-md-2' style='margin-bottom: 20px;'></div>";
            },0);

            plugin::admin_view_render(
                "İleti Merkezi",
                [
                    "İleti Merkezi",
                    "Sms Gönderme"
                ],
                __DIR__,
                "dashboard",
                "sender",
                [
                    "balance" => helper::class
                ]
            );


            plugin::add_router_post("router@admin","/app/plugin/iletimerkezi/send",[helper::class,"send"]);

            plugin::add_router_post("router@admin","/app/plugin/iletimerkezi/widget",function (){

                plugin::view_render(
                    __DIR__,
                    "widget",
                    [
                        "balance" => helper::class
                    ]
                );

            });

        }


    }else{

        plugin::admin_view_render(
            "İleti Merkezi",
            [
                "İleti Merkezi",
                "Kurulum"
            ],
            __DIR__,
            "dashboard",
            "setup",
            []
        );

        plugin::add_router_post("router@admin","/app/plugin/iletimerkezi/setup",[helper::class,"setup"]);

    }

}
