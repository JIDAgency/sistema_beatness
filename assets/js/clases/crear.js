// Variables
var table;
var actual_url = document.URL;
var method_call = "";
var url;
var flag_editando = false;
var select_disciplina = [];
var select_instructor = [];
var select_dificultad = [];

// Configuraciones
(actual_url.indexOf("index") < 0) ? method_call = "" : method_call = "";
$.fn.dataTable.ext.errMode = 'throw'; // Configuración de manejo de errores de DataTables

$(document).ready(function () {
	url = method_call + "obtener_calendario_crear"

	// Inicializar
	table = $('#table').DataTable({
		"scrollX": true,
		"deferRender": true,
		'processing': true,
		"order": [[0, "asc"]],
		"lengthMenu": [[25, 50, 100, 250, 500, -1], [25, 50, 100, 250, 500, "Todos"]],
		"ajax": {
			"url": url,
			"type": 'POST'
		},
		"columns": [
			{ "data": "hora" },
			{ "data": "clase_lunes" },
			{ "data": "clase_martes" },
			{ "data": "clase_miercoles" },
			{ "data": "clase_jueves" },
			{ "data": "clase_viernes" },
			{ "data": "clase_sabado" },
			{ "data": "clase_domingo" }
		],
		'language': {
			'sProcessing': '<div class="loader-wrapper"><div class="loader"></div></div>',
			"sLengthMenu": "Mostrar _MENU_",
			"sZeroRecords": "No se encontraron resultados",
			"sEmptyTable": "Ningún dato disponible en esta tabla =(",
			"sInfo": "Mostrando del _START_ al _END_ de _TOTAL_",
			"sInfoEmpty": "Mostrando del 0 al 0 de 0",
			"sInfoFiltered": "(filtrado _MAX_)",
			"sInfoPostFix": "",
			"sSearch": "Buscar:",
			"sUrl": "",
			"sInfoThousands": ",",
			"sLoadingRecords": "&nbsp;",
			"oPaginate": {
				"sFirst": "Primero",
				"sLast": "Último",
				"sNext": ">",
				"sPrevious": "<"
			},
			"oAria": {
				"sSortAscending": ": Activar para ordenar la columna de manera ascendente",
				"sSortDescending": ": Activar para ordenar la columna de manera descendente"
			}
		},
		"dom": '<"top"lfi>rt<"bottom"p><"clear">',

	});
	// Establecer validaciones
	$("#forma-crear-clase").validate({
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

	$('#filtro_clase_sucursal').change(function () {
		var sucursalSeleccionada = $(this).val();
		$.ajax({
			url: method_call + "guardar_seleccion",
			method: 'POST',
			data: {
				filtro_clase_sucursal: sucursalSeleccionada
			},
			success: function (response) {
				console.log(sucursalSeleccionada + ' Sucursal guardada en la sesión');
				table.ajax.reload();

				// Nueva solicitud AJAX para obtener las disciplinas de la sucursal seleccionada
				$.ajax({
					url: method_call + "obtener_disciplinas",
					method: 'GET',
					data: {
						sucursal_id: sucursalSeleccionada // enviar el ID de la sucursal seleccionada
					},
					dataType: 'json',
					success: function (data) {
						var disciplinas = data; // Asumiendo que response.disciplinas contiene las disciplinas
						var $disciplinaSelect = $('#filtro_clase_disciplina');

						// Limpiar el select de disciplinas
						$disciplinaSelect.empty();
						$disciplinaSelect.append('<option value="0">Todas las disciplinas</option>');

						// Agregar las nuevas opciones
						if (Array.isArray(disciplinas)) {
							$.each(disciplinas, function (index, disciplina) {
								$disciplinaSelect.append('<option value="' + disciplina.id + '">' + disciplina.nombre + '</option>');
							});
						} else {
							console.error('La respuesta no es un array');
						}

						// Actualizar el select2
						$disciplinaSelect.select2();
					},
					error: function (jqXHR, textStatus, errorThrown) {
						console.error('Error al obtener disciplinas: ' + textStatus, errorThrown);
					}
				});
			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.error('Error al guardar la sucursal: ' + textStatus, errorThrown);
			}
		});
	});

	$('#filtro_clase_disciplina').change(function () {
		var disciplinaSeleccionada = $(this).val();
		$.ajax({
			url: method_call + "guardar_seleccion_disciplina",
			method: 'POST',
			data: {
				filtro_clase_disciplina: disciplinaSeleccionada
			},
			success: function (response) {
				console.log(disciplinaSeleccionada + ' Disciplina guardada en la sesión');
				table.ajax.reload();
			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.error('Error al guardar la disciplina: ' + textStatus, errorThrown);
			}
		});
	});

	// Manejar el cambio de disciplina y actualizar las dificultades
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
					$('#dificultad').empty(); // Limpia el select de dificultad
					$('#dificultad').append('<option value="">Seleccione un grupo muscular…</option>');

					$.each(response, function (index, value) {
						$('#dificultad').append('<option value="' + value.id + '|' + value.nombre + '">' + value.nombre + '</option>');
					});
				}
			});
		}
	});
});