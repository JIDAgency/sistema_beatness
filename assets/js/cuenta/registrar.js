// Funciones callbacks para la funcionalidad de reCAPTCHA
var captchaExitoso = function () {
	var submitButton = document.getElementById("btn-registrar");
	submitButton.disabled = false;
}

var captchaExpirado = function () {
	var submitButton = document.getElementById("btn-registrar");
	submitButton.disabled = true;
};

var captchaFallido = function () {
	var submitButton = document.getElementById("btn-registrar");
	submitButton.disabled = true;
};

$(function(){
    $('[type="date"]').prop('max', function(){
        return new Date().toJSON().split('T')[0];
    });
});


$(function () {

	$("#forma-registrar").validate({
		rules: {
			"no_telefono": {
				required: true,
				number: true,
				minlength: 10,
				maxlength: 10
			},
			"correo": {
				required: true,
				email: true,
				maxlength: 100
			},
			"contrasena": {
				required: true
			},
			"nombre_completo": {
				required: true,
				maxlength: 50
			},
			"apellido_paterno": {
				required: true,
				maxlength: 50

			},
			"apellido_materno": {
				maxlength: 50
			},
			"fecha_nacimiento": {
				required: true
			},
			"genero": {
				required: true
			}
		},
		messages: {
			"no_telefono": {
				required: "El no. de teléfono es requerido",
				number: "El no. de teléfono solo acepta números",
				minlength: "No debe ser menor de 10 caracteres",
				maxlength: "No debe pasar de 10 caracteres"
			},
			"correo": {
				required: "El correo es requerido",
				email: "Debe ser una dirección de email correcta",
				maxlength: "No debe pasar de 100 caracteres"
			},
			"contrasena": {
				required: "La contraseña es requerida"
			},
			"nombre_completo": {
				required: "Por favor escriba un nombre",
				maxlength: "No debe pasar de 50 caracteres"
			},
			"apellido_paterno": {
				required: "Es requerido",
				maxlength: "No debe pasar de 50 caracteres"
			},
			"apellido_materno": {
				maxlength: "No debe pasar de 50 caracteres"
			},
			"fecha_nacimiento": {
				required: "Se requiere una Fecha de nacimiento válida"
			},
			"genero": {
				required: "Se requiere un género válido"
			}
		},
		errorClass: "has-error"
	});
});
