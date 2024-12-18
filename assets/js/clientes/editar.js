// ============================================================
// FUNCIÓN: Mostrar/ocultar vigencia estudiante según selección
// ============================================================
document.addEventListener('DOMContentLoaded', function () {
	var estudianteSelect = document.getElementById('es_estudiante');
	var vigenciaRow = document.getElementById('vigencia_estudiante_row');

	function toggleVigencia() {
		if (estudianteSelect.value === 'si') {
			vigenciaRow.style.display = 'block';
		} else {
			vigenciaRow.style.display = 'none';
		}
	}

	estudianteSelect.addEventListener('change', toggleVigencia);
	// Verificar el valor inicial al cargar la página
	toggleVigencia();
});

// ============================================================
// FUNCIÓN: Inicializaciones con jQuery al cargar la página
// ============================================================
$(function () {
	// Validación del formulario
	$("#forma-editar-cliente").validate({
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
		errorClass: "has-error"
	});
});

// ============================================================
// FUNCIÓN: Previsualizar imagen al cargar desde archivo
// ============================================================
var cargar_imagen = function (event) {
	var reader = new FileReader();
	reader.onload = function () {
		var output = document.getElementById('preview');
		output.src = reader.result;
	};
	reader.readAsDataURL(event.target.files[0]);
};

// Si se necesita otra función para INE (no mostrada actualmente en el formulario editado, pero se deja):
var cargar_imagen_ine = function (event) {
	var reader = new FileReader();
	reader.onload = function () {
		var output = document.getElementById('preview_ine');
		output.src = reader.result;
	};
	reader.readAsDataURL(event.target.files[0]);
};
