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

	$('#no_telefono').keyup(function(){
		adddashes(this);
	});

});

function adddashes(el){
	let val = $(el).val().split(' ').join('');      //remove all dashes (-)
	if(val.length < 9){
		let finalVal = val.match(/.{1,3}/g).join(' ');//add dash (-) after every 3rd char.
		$(el).val(finalVal);
	}
}

$(function () {

	$("#forma-registrar").validate({
		rules: {
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
			"pais": {
				required: true
			},
			"estado": {
				required: true
			},
			"ciudad": {
				required: true
			},
			
		},
		messages: {
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
			"pais": {
				required: "Se requiere un País de residencia válido"
			},
			"estado": {
				required: "Se requiere un Estado de residencia válido"
			},
			"ciudad": {
				required: "Se requiere un Ciudad de residencia válido"
			},
		},
		errorClass: "has-error"
	});
});
