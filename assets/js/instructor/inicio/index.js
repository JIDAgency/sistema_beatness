var table;

var actual_url = document.URL;
var method_call = "";

if (actual_url.indexOf("index") < 0) {
	method_call = "inicio/";
}

/**
 * Este línea desactiva los mensajes de error de DataTables();
 */
$.fn.dataTable.ext.errMode = "throw";

$(document).ready(function () {
	$("#tabla").DataTable({
		//scrollX: true,
		deferRender: true,
		processing: true,
		ajax: {
			url: method_call + "obtener_tabla_index", // Asegúrate de tener definida la variable base_url o usar la ruta completa
			type: "GET",
			dataSrc: "", // Si el JSON retornado es un array
		},
		columns: [
			{ data: "id" },
			{ data: "estatus" },
			{ data: "disciplina" },
			{ data: "dificultad" },
			{ data: "fecha" },
			{ data: "horario" },
			{ data: "cupos" },
			{ data: "reservaciones" },
		],
		order: [[0, "desc"]],
		lengthMenu: [
			[25, 50, 100, 250, 500, -1],
			[25, 50, 100, 250, 500, "Todos"],
		],
		language: {
			sProcessing: '<i class="fa fa-spinner spinner"></i> Cargando...',
			sLengthMenu: "Mostrar _MENU_",
			sZeroRecords: "No se encontraron resultados",
			sEmptyTable: "Ningún dato disponible en esta tabla =(",
			sInfo: "Mostrando del _START_ al _END_ de _TOTAL_",
			sInfoEmpty: "Mostrando del 0 al 0 de 0",
			sInfoFiltered: "(filtrado _MAX_)",
			sSearch: "Buscar:",
			oPaginate: {
				sFirst: "Primero",
				sLast: "Último",
				sNext: ">",
				sPrevious: "<",
			},
		},
	});
});
