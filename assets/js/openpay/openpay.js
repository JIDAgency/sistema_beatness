$(document).ready(function() {

    //Esta es la condiguracion de OpenPay Activa

    //OpenPay.setId('mwsb83jwreqy1gebwtgp');
    //OpenPay.setApiKey('pk_ec027ca2abfe4c828347be9b1e93556d');
    //OpenPay.setSandboxMode(true);

    //OpenPay.setId('mvpk3fqcwtremfqkzp5k');
    //OpenPay.setApiKey('pk_503c0a4161f141008cb5df54a13c2025');
    //OpenPay.setSandboxMode(false);

    /** ====== JID Agency SandBox ====== */
    /*
    OpenPay.setId('m8otpwxmarioccpdk4xa');
    OpenPay.setApiKey('pk_d3e14651379c452e9b0eb5b465eb1ee0');
    OpenPay.setSandboxMode(true);
    */

    /** ====== Sensoria Studio SandBox ====== */
    OpenPay.setId('m5jvrxzl04j0jassunr0');
    OpenPay.setApiKey('pk_8ddde35a101045cf954da36f62fed0c7');
    OpenPay.setSandboxMode(true);

    //Se genera el id de dispositivo
    var deviceSessionId = OpenPay.deviceData.setup("payment-form", "deviceIdHiddenFieldName");
    
    $('#pay-button').on('click', function(event) {

        var expiracion = document.getElementById("fecha_expiracion");
        $('#mes_expiracion').val(expiracion.value.slice(0, 2));
        $('#anio_expiracion').val(expiracion.value.slice(-2));

        var expiracion = document.getElementById("numero_tarjeta");
        $('#no_tarjeta').val(expiracion.value.replace(/ /g, ""));

        event.preventDefault();
        $("#pay-button").prop( "disabled", true);
        OpenPay.token.extractFormAndCreate('payment-form', sucess_callbak, error_callbak);                
    });

    var sucess_callbak = function(response) {
    var token_id = response.data.id;
    $('#token_id').val(token_id);
    $('#payment-form').submit();
    };

    var error_callbak = function(response) {
        var desc = response.data.description != undefined ? response.data.description : response.message;
        alert("ERROR [" + response.status + "] " + desc);
        $("#pay-button").prop("disabled", false);
    };

});