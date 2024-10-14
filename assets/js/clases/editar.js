// Variables
var table;
var actual_url = document.URL;
var method_call = "";
var url;

// Configuraciones
(actual_url.indexOf("index") < 0) ? method_call = "" : method_call = "";

$(function () {
	// Inicializar date dropper
	$('.date-dropper').dateDropper({
		dropWidth: 200,
		animate: false,
		format: "d/m/Y",
		lock: 'from',
		lang: 'es'
	});

	$('.time-dropper').timeDropper({
		format: 'HH:mm',
		init_animation: 'dropDown',
		setCurrentTime: false
	});

	// Establecer validaciones
	$("#forma-editar-clase").validate({
		rules: {
			"identificador": {
				required: true
			},
			"instructor_id": {
				required: true
			},
			/*"dificultad": {
				required: true
			},*/
			"intervalo_horas": {
				required: true,
				number: true
			},
			"disciplina_id": {
				required: true
			},
			"cupo": {
				required: true
			}
		},
		messages: {
			"identificador": {
				required: "Este campo es requerido"
			},
			"instructor_id": {
				required: "Debe seleccionar un instructor"
			},
			/*"dificultad": {
				required: "Este campo es requerido"
			},*/

			"intervalo_horas": {
				required: "Este campo es requerido",
				number: "Debe ser un valor numerico"
			},
			"disciplina_id": {
				required: "Por favor seleccione una disciplina"
			},
			"cupo": {
				required: "Debe establecer el cupo"
			}
		},
		errorClass: "has-error"
	});

	// SELECT DE DISCIPLINA Y DIFICULTAD INICIO
	$('#disciplina_id').change(function () {
		var disciplina_id = $(this).val();

		if (disciplina_id === "") {
			// Si no se selecciona una disciplina válida, muestra un mensaje predeterminado
			$('#dificultad').empty();
			$('#dificultad').append('<option value="">Primero seleccione una disciplina</option>');
		} else {
			// Solicitud AJAX para obtener las dificultades basadas en la disciplina seleccionada
			$.ajax({
				url: method_call + 'obtener_dificultades_por_disciplina',
				method: 'POST',
				data: { disciplina_id: disciplina_id },
				dataType: 'json',
				success: function (response) {
					var dificultad_seleccionada = '<?php echo $clase_a_editar->dificultad; ?>';
					$('#dificultad').empty(); // Limpia el select de dificultad
					$('#dificultad').append('<option value="">Seleccione un grupo muscular…</option>');

					$.each(response, function (index, value) {
						var selected = (value.id == dificultad_seleccionada) ? 'selected' : '';
						$('#dificultad').append('<option value="' + value.id + '" ' + selected + '>' + value.nombre + '</option>');
					});
				}
			});
		}
	});
	// SELECT DE DISCIPLINA Y DIFICULTAD FIN
});
