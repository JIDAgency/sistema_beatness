var table;

var actual_url = document.URL;
var method_call = "";

if(actual_url.indexOf("index") < 0){
    method_call = "configuraciones/";
}

(function() {
    'use strict';

    window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');

        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
            }, false);
        });
    }, false);

    document.getElementById('app_cancelar_reservacion_hrs_readonly').onclick = function() {
        if (document.getElementById('app_cancelar_reservacion_hrs').readOnly == true) {
            document.getElementById('app_cancelar_reservacion_hrs').readOnly = false;
        } else {
            document.getElementById('app_cancelar_reservacion_hrs').readOnly = true;
        }
    };

    document.getElementById('app_prevenir_cancelacion_hrs_readonly').onclick = function() {
        if (document.getElementById('app_prevenir_cancelacion_hrs_valor_1').readOnly == true) {
            document.getElementById("app_prevenir_cancelacion_hrs_estatus").removeAttribute("disabled");
            document.getElementById('app_prevenir_cancelacion_hrs_valor_1').readOnly = false;
            document.getElementById('app_prevenir_cancelacion_hrs_valor_2').readOnly = false;
        } else {
            document.getElementById("app_prevenir_cancelacion_hrs_estatus").setAttribute("disabled", "disabled");
            document.getElementById('app_prevenir_cancelacion_hrs_valor_1').readOnly = true;
            document.getElementById('app_prevenir_cancelacion_hrs_valor_2').readOnly = true;
        }
    };
    
})();

$(function() {
    $("#id_categoria").change( function() {
        if ($(this).val() === "1") {
            $("#id_input").prop("disabled", true);
        } else {
            $("#id_input").prop("disabled", false);
        }
    });
});