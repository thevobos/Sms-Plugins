
<?php $balance = $balance::getBalance()->balance; ?>


<div class="row">

    <div class="col-md-4" >
        <img src="/App/Main/Plugin/iletimerkezi/Assets/ileti-merkezi-logo.webp" width="80%" style="margin: 0px 0px 14px 0px;" alt="">


        <div class="card">
            <div class="card-body">
                <h5 class="header-title mb-4" >KALAN BAKİYE BİLGİSİ</h5>
                <div class="media">
                    <div class="media-body">
                        <p class="text-muted mb-2">Bakiye</p>
                        <h4><?php echo $balance->amount; ?> ₺</h4>
                    </div>
                </div>
                <hr>
                <div class="media">
                    <div class="media-body">
                        <p class="text-muted">Sms (Adet)</p>
                        <h5 class="mb-0"> <?php echo $balance->sms; ?> </h5>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">


        <form action="" class="smsSend" onsubmit="return false;">

            <div class="card">
                <div class="card-body">


                    <h4 class="header-title">Sms Gönderi Formu</h4>
                    <p class="card-title-desc">Tek yada çoklu fazla SMS atabilirsiniz.</p>


                    <!-- Nav tabs -->
                    <div class="form-group row">
                        <label for="numbers" class="col-md-3 col-form-label">Numara Giriniz</label>
                        <div class="col-md-9">
                            <input required minlength="10" class="tagsIn" type="text" placeholder="Numara Giriniz..." name="numbers" id="numbers">
                        </div>
                    </div>

                    <!-- Nav tabs -->
                    <div class="form-group row">
                        <label  class="col-md-3 col-form-label">Mesaj</label>
                        <div class="col-md-9">
                            <textarea required minlength="3" name="message" id="textarea" class="form-control" rows="3" placeholder="Buraya göndermek istediğiniz mesajı giriniz..."></textarea>
                        </div>
                    </div>

                    <div class="col-md-12 " style="text-align: right;">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Sms Gönder</button>
                    </div>

                </div>
            </div>

        </form>

    </div>



</div>

<style>
    .selectize-input.items.not-full {
        padding: 10px 11px 7px 10px !important;
    }

    .selectize-control.multi .selectize-input > div {
        font-size: 15px;
        letter-spacing: 1px;
    }

    .selectize-control.multi .selectize-input > div {
        background: #3051d3;
        color: white;
    }
</style>