$(function () {

	// Inicializar máscaras
	$('.tel-inputmask').inputmask("(999) 999-9999");

	// Inicializar date dropper
	$('.date-dropper').dateDropper({
		dropWidth: 200,
		animate: false,
		format: "d/m/Y",
		lang: 'es'
	});

	// Establecer validaciones
	$("#forma-editar-usuario").validate({
		rules: {
			"nombre_usuario": {
				required: true
			},
			"rol_id": {
				required: true
			},
			"correo": {
				required: true,
				email: true
			},
			"nombre_completo": {
				required: true
			},
			"apellido_paterno": {
				required: true
			}

		},
		messages: {
			"nombre_usuario": {
				required: "El usuario es requerido"
			},
			"rol_id": {
				required: "Debe seleccionar un rol"
			},
			"correo": {
				required: "El correo es requerido",
				email: "Debe ser una dirección de email correcta"
			},
			"nombre_completo": {
				required: "Por favor escriba un nombre"
			},
			"apellido_paterno": {
				required: "Es requerido"
			}
		},
		errorClass: "has-error",
	});

});

var cargar_imagen = function(event) {
	var reader = new FileReader();
	reader.onload = function(){
	  var output = document.getElementById('preview');
	  output.src = reader.result;
	};
	reader.readAsDataURL(event.target.files[0]);
};
