// Variables
var table;
var actual_url = document.URL;
// Dividir la URL por 'clases/' y quedarte solo con esa parte
var nueva_url = actual_url.split('/clases/')[0] + '/clases/';
console.log(actual_url);
console.log(nueva_url);
var method_call = "";
var url;

// Configuraciones
(nueva_url.indexOf("index") < 0) ? method_call = "" : method_call = "";
$.fn.dataTable.ext.errMode = 'throw'; // Configuración de manejo de errores de DataTables

$(document).ready(function () {

	// SELECT DE DISCIPLINA Y DIFICULTAD INICIO
	$('#disciplina_id').change(function () {
		var disciplina_id = $(this).val();

		console.log('disciplina: ' + disciplina_id);

		if (disciplina_id === "") {
			// Si no se selecciona una disciplina válida, muestra un mensaje predeterminado
			$('#dificultad').empty();
			$('#dificultad').append('<option value="">Primero seleccione una disciplina</option>');
		} else {
			// Solicitud AJAX para obtener las dificultades basadas en la disciplina seleccionada
			console.log('Entre a else');
			console.log(nueva_url + 'obtener_dificultades_por_disciplina');
			$.ajax({
				url: nueva_url + 'obtener_dificultades_por_disciplina',
				method: 'POST',
				data: { disciplina_id: disciplina_id },
				dataType: 'json',
				success: function (response) {
					console.log('Entre a obtener dificultades');
					console.log(response);
					$('#dificultad').empty(); // Limpia el select de dificultad
					$('#dificultad').append('<option value="">Seleccione un grupo muscular…</option>');

					$.each(response, function (index, value) {
						$('#dificultad').append('<option value="' + value.id + '">' + value.nombre + '</option>');
					});
				}
			});
		}
	});
	// SELECT DE DISCIPLINA Y DIFICULTAD FIN
});