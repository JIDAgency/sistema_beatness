(function() {
    'use strict';

    window.addEventListener('load', function() {
    var forms = document.getElementsByClassName('needs-validation');

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
    
})();

function mostrar_contrasena_actual() {
    var x = document.getElementById("contrasena_actual");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}

function mostrar_contrasena_nueva() {
    var x = document.getElementById("contrasena_nueva");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}

function mostrar_confirmar_contrasena() {
    var x = document.getElementById("confirmar_contrasena");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}