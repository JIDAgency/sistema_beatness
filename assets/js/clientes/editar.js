document.addEventListener('DOMContentLoaded', function() {
	var estudianteSelect = document.getElementById('es_estudiante');
	var vigenciaRow = document.getElementById('vigencia_estudiante_row');

	estudianteSelect.addEventListener('change', function() {
		console.log(this.value);
		console.log(estudianteSelect.value);
		if (estudianteSelect.value === 'si') { // Ajusta este valor según corresponda al valor de "si" en tu select
			vigenciaRow.style.display = 'block';
		} else {
			vigenciaRow.style.display = 'none';
		}
	});

	// Verificar el valor inicial al cargar la página
	if (estudianteSelect.value === 'si') { // Ajusta este valor según corresponda al valor de "si" en tu select
		vigenciaRow.style.display = 'block';
	}
});
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
	$("#forma-editar-clientes").validate({
		rules: {
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

var cargar_imagen_ine = function(event) {
    var reader = new FileReader();
    reader.onload = function(){
      var output = document.getElementById('preview_ine');
      output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
};
