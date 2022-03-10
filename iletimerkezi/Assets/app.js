$(function () {

    const pleaseWait = () => {

        swal("İŞLEM YAPILIYOR","Lütfen Bekleyiniz","/assets/images/ajax-loader.gif", {
            buttons: {},
            closeOnClickOutside:false,
            closeOnEsc:false,
            showLoaderOnConfirm:true
        })

    };



    $(".smsSend").submit(function () {



        swal("İŞLEM ONAYI","sms göndermek İistiyor musunuz?","info", {
            buttons: {
                cancel: {
                    text: "Hayır",
                    value: false,
                    visible: true
                },
                yes: {
                    text: "Evet",
                    value: true
                }
            }
        }).then((x)=>{
            if(x){

                pleaseWait();

                $.ajax({
                    type: "POST",
                    url: "/app/plugin/iletimerkezi/send",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function (response) {

                        if(response.status === "success"){
                            swal(response.title,response.message,response.status, {
                                buttons: {
                                    cancel: {
                                        text: "Tamam",
                                        value: false,
                                        visible: true
                                    }
                                }
                            });

                            $("form")[0].reset();


                            var $select = $('.tagsIn').selectize();
                            var control = $select[0].selectize;
                            control.clear();

                        }else{
                            swal(response.title,response.message,response.status, {
                                buttons: {
                                    cancel: {
                                        text: "Tekar Dene",
                                        value: false,
                                        visible: true
                                    }
                                }
                            });
                        }

                    }
                });


            }
        });

    });


    $(".smsSetup").submit(function () {

        swal("İŞLEM ONAYI","bilgileri doğruluyor musunuz?","info", {
            buttons: {
                cancel: {
                    text: "Hayır",
                    value: false,
                    visible: true
                },
                yes: {
                    text: "Evet",
                    value: true
                }
            }
        }).then((x)=>{
            if(x){


                $.ajax({
                    type: "POST",
                    url: "/app/plugin/iletimerkezi/setup",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function (response) {

                        if(response.status === "success"){

                            location.reload();

                        }else{
                            swal(response.title,response.message,response.status, {
                                buttons: {
                                    cancel: {
                                        text: "Tekar Dene",
                                        value: false,
                                        visible: true
                                    }
                                }
                            });
                        }

                    }
                });


            }
        });

    });



    if($(".iletimerkeziWidget").length > 0){

        $.ajax({
            type: "POST",
            url: "/app/plugin/iletimerkezi/widget",
            data: {},
            success: function (response) {

                $(".iletimerkeziWidget").html(response);

            }
        });

    }


});