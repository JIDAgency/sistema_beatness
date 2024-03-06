

<style>
@charset "US-ASCII";
@import "https://fonts.googleapis.com/css?family=Lato:300,400,700";

body {
    max-width:100%;
    overflow-x:hidden;
}
* {
    color: #444;
    font-family: Lato;
    font-size: 16px;
    font-weight: 300;
}
::-webkit-input-placeholder {
   font-style: italic;
}
:-moz-placeholder {
   font-style: italic;
}
::-moz-placeholder {
   font-style: italic;
}
:-ms-input-placeholder {
   font-style: italic;
}

body {
    float: left;
    margin: 0;
    padding: 0;
    width: 100%;
}
strong {
	font-weight: 700;
}
a {
    cursor: pointer;
    display: block;
    text-decoration: none;
}
a.button {
    border-radius: 5px 5px 5px 5px;
    -webkit-border-radius: 5px 5px 5px 5px;
    -moz-border-radius: 5px 5px 5px 5px;
    text-align: center;
    font-size: 21px;
    font-weight: 400;
    padding: 12px 0;
    width: 100%;
    display: table;
    background: #E51F04;
    background: -moz-linear-gradient(top,  #E51F04 0%, #A60000 100%);
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#E51F04), color-stop(100%,#A60000));
    background: -webkit-linear-gradient(top,  #E51F04 0%,#A60000 100%);
    background: -o-linear-gradient(top,  #E51F04 0%,#A60000 100%);
    background: -ms-linear-gradient(top,  #E51F04 0%,#A60000 100%);
    background: linear-gradient(top,  #E51F04 0%,#A60000 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#E51F04', endColorstr='#A60000',GradientType=0 );
}
a.button i {
    margin-right: 10px;
}
a.button.disabled {
    background: none repeat scroll 0 0 #ccc;
    cursor: default;
}
.bkng-tb-cntnt {
    float: left;
    width: 100%;
}
.bkng-tb-cntnt a.button {
    color: #fff;
    float: left;
    font-size: 18px;
    padding: 5px 80px;
    width: auto;
}
.bkng-tb-cntnt a.button.o {
    background: none repeat scroll 0 0 rgba(0, 0, 0, 0);
    color: #e51f04;
    border: 1px solid #e51f04;
}
.bkng-tb-cntnt a.button i {
    color: #fff;
}
.bkng-tb-cntnt a.button.o i {
    color: #e51f04;
}
.bkng-tb-cntnt a.button.right i {
    float: right;
    margin: 2px 0 0 10px;
}
.bkng-tb-cntnt a.button.left {
    float: left;
}
.bkng-tb-cntnt a.button.disabled.o {
    border-color: #ccc;
    color: #ccc;
}
.bkng-tb-cntnt a.button.disabled.o i {
    color: #ccc;
}
.pymnts {
    float: left;
    width: 100%;
}
.pymnts * {
    float: left;
}

.sctn-row {
    margin-bottom: 35px;
    width: 100%;
}
.sctn-col {
    width: 375px;
}
.sctn-col.l {
    width: 425px;
}
.sctn-col input {
    border: 1px solid #ccc;
    font-size: 18px;
    line-height: 24px;
    padding: 10px 12px;
    width: 333px;
}
.sctn-col label {
    font-size: 24px;
    line-height: 24px;
    margin-bottom: 10px;
    width: 100%;
}
.sctn-col.x3 {
    width: 300px;
}
.sctn-col.x3.last {
    width: 200px;
}
.sctn-col.x3 input {
    width: 210px;
}
.sctn-col.x3 a {
    float: right;
}
.pymnts-sctn {
    width: 100%;
}
.pymnt-itm {
    margin: 0 0 3px;
    width: 100%;
}
.pymnt-itm h2 {
    background-color: #e9e9e9;
    font-size: 24px;
    line-height: 24px;
    margin: 0;
    padding: 28px 0 28px 20px;
    width: 100%;
}
.pymnt-itm.active h2 {
    background-color: #2E3192;
    color: #fff;
    cursor: default;
}
.pymnt-itm div.pymnt-cntnt {
    display: none;
}
.pymnt-itm.active div.pymnt-cntnt {
    background-color: #f7f7f7;
    display: block;
    padding: 0 0 30px;
    width: 100%;
}

.pymnt-cntnt div.sctn-row {
    margin: 20px 30px 0;
    width: 740px;
}
.pymnt-cntnt div.sctn-row div.sctn-col {
    /*width: 345px;*/
}
.pymnt-cntnt div.sctn-row div.sctn-col.l {
    width: 395px;
}
.pymnt-cntnt div.sctn-row div.sctn-col input {
    width: 303px;
}
.pymnt-cntnt div.sctn-row div.sctn-col.half {
    width: 155px;
}
.pymnt-cntnt div.sctn-row div.sctn-col.half.l {
    float: left;
    width: 190px;
}
.pymnt-cntnt div.sctn-row div.sctn-col.half input {
    width: 113px;
}
.pymnt-cntnt div.sctn-row div.sctn-col.cvv {
    background-image: url("<?php echo base_url(); ?>app-assets/images/openpay/cvv.png");
    background-position: 156px center;
    background-repeat: no-repeat;
    padding-bottom: 30px;
}
.pymnt-cntnt div.sctn-row div.sctn-col.cvv div.sctn-col.half input {
    width: 110px;
}
.openpay {
    float: left;
    height: 60px;
    margin: 10px 30px 0 0;
    width: 435px;
}
.openpay div.logo {
    background-image: url("<?php echo base_url(); ?>app-assets/images/openpay/openpay.png");
    background-position: left bottom;
    background-repeat: no-repeat;
    border-right: 1px solid #ccc;
    font-size: 12px;
    font-weight: 400;
    height: 70px;
    padding: 15px 20px 0 0;
}
.openpay div.shield {
    background-image: url("<?php echo base_url(); ?>app-assets/images/openpay/security.png");
    background-position: left bottom;
    background-repeat: no-repeat;
    font-size: 12px;
    font-weight: 400;
    margin-left: 20px;
    padding: 20px 0 0 40px;
    width: 200px;
}
.card-expl {
    float: left;
    padding-left: 34px;
    height: 120px;
    margin: 20px 0;
    width: 100%;
}
.card-expl div {
    background-position: left 45px;
    background-repeat: no-repeat;
    height: 70px;
    padding-top: 10px;
}
.card-expl div.debit {
    background-image: url("<?php echo base_url(); ?>app-assets/images/openpay/cards2.png");
    background-size:100%;
    margin-left: 20px;
    width: 30%;
}
.card-expl div.credit {
    background-image: url("<?php echo base_url(); ?>app-assets/images/openpay/cards1.png");
    background-size:100%;
    border-right: 1px solid #ccc;
    margin-left: 30px;
    width: 20%;
}
.card-expl h4 {
    font-weight: 400;
    margin: 0;
}
</style>


<section class="seccion-texto">


<div class="container p-t-20">

    <div class="row p-b-20">

            <div class="col-xl-4 col-12">
                <?php foreach ($planes as $plan): ?>
                <div class="card" style="">
                    <div class="card-content">
                        <div class="card-body">
                            <h4 class="card-title"><?php echo $plan->nombre ?></h4>
                            <p class="card-text">Incluye <?php echo $plan->clases_incluidas ?> clases. (Vigencia <?php echo $plan->vigencia_en_dias ?> días).</p>
                            <h2>MNX $<?php echo number_format($plan->costo); ?></h2>
                            <p><?php echo $plan->descripcion; ?></p>
                            <p>Disciplina: B.BOX, B.BIKE, B.BODY</p>
                            <p><?php echo $plan->terminos_condiciones; ?></p>
                        </div>
                    </div>
                </div>
                <a href="<?php echo site_url('usuario/comprar_planes'); ?>" class="btn btn-outline-blue m-b-20">Seleccionar otro plan</a>
                <?php endforeach;?>
            </div>




            <div class="col-xl-8 col-12">

            <div class="bkng-tb-cntnt">
                    <div class="pymnts">
                        <form action="<?php echo site_url('usuario/comprar_planes_pagoopenpay') ?>" method="POST" id="payment-form">
                            <input type="hidden" name="token_id" id="token_id">
                            <input type="hidden" name="plan_id" id="plan_id" value="<?php echo $plan_id; ?>">
                            <div class="pymnt-itm card active">
                                <h2>Tarjeta de crédito o débito</h2>
                                <div class="pymnt-cntnt">
                                    <div class="card-expl">
                                        <div><p>Tarjetas de crédito</p><br>
                                        <img class="img-fluid" src="<?php echo base_url(); ?>app-assets/images/openpay/cards2.png" width="300"><br>
                                        <p>Tarjetas de débito</p><br>
                                        <img class="img-fluid" src="<?php echo base_url(); ?>app-assets/images/openpay/cards1.png" width="200"></div><br>
                                    </div>
                                    <div class="sctn-row">
                                        <div class="sctn-col l">
                                            <label>Nombre del titular</label><input name="tarjetaviente" id="tarjetaviente" type="text" placeholder="Como aparece en la tarjeta" autocomplete="off" data-openpay-card="holder_name">
                                        </div>
                                        <div class="sctn-col">
                                            <label>Número de tarjeta</label><input class="validanumericos" type="text" maxlength="16" placeholder="Como aparece en la tarjeta" autocomplete="off" data-openpay-card="card_number"></div>
                                        </div>
                                        <div class="sctn-row">
                                            <div class="sctn-col l">
                                                <label>Fecha de expiración</label>
                                                <div class="sctn-col half l"><input class="validanumericos2" type="text" maxlength="2" placeholder="Mes" data-openpay-card="expiration_month"></div>
                                                <div class="sctn-col half l"><input class="validanumericos3" type="text" maxlength="2" placeholder="Año" data-openpay-card="expiration_year"></div>
                                            </div>
                                            <div class="sctn-col cvv"><label>Código de seguridad</label>
                                                <div class="sctn-col half l"><input class="validanumericos4" type="text" maxlength="4" placeholder="CVV" autocomplete="off" data-openpay-card="cvv2"></div>
                                            </div>
                                        </div>
                                        <div class="openpay"><div class="logo">Transacciones realizadas vía:</div>
                                        <div class="shield">Tus pagos se realizan de forma segura con encriptación de 256 bits</div>
                                    </div>
                                    <div class="sctn-row m-t-20">
                                            <a class="button rght" id="pay-button">Pagar</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
    </div>
</div>

</section>

<script>
    onload = function(){ 
        var ele = document.querySelectorAll('.validanumericos')[0];
        ele.onkeypress = function(e) {
            if(isNaN(this.value+String.fromCharCode(e.charCode)))
                return false;
        }
        ele.onpaste = function(e){
            e.preventDefault();
        }
        var ele = document.querySelectorAll('.validanumericos2')[0];
        ele.onkeypress = function(e) {
            if(isNaN(this.value+String.fromCharCode(e.charCode)))
                return false;
        }
        ele.onpaste = function(e){
            e.preventDefault();
        }
        var ele = document.querySelectorAll('.validanumericos3')[0];
        ele.onkeypress = function(e) {
            if(isNaN(this.value+String.fromCharCode(e.charCode)))
                return false;
        }
        ele.onpaste = function(e){
            e.preventDefault();
        }
        var ele = document.querySelectorAll('.validanumericos4')[0];
        ele.onkeypress = function(e) {
            if(isNaN(this.value+String.fromCharCode(e.charCode)))
                return false;
        }
        ele.onpaste = function(e){
            e.preventDefault();
        }
    }
</script>