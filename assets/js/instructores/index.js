var table;
var actual_url = window.location.href;
var method_call = "";

actual_url.indexOf("index") < 0
	? (method_call = "instructores/")
	: (method_call = "");

$.fn.dataTable.ext.errMode = "throw";

table = $("#tabla").DataTable({
	scrollX: true,
	deferRender: true,
	processing: true,
	order: [[1, "desc"]],
	lengthMenu: [
		[25, 50, 100, 250, 500, -1],
		[25, 50, 100, 250, 500, "Todos"],
	],
	ajax: {
		url: method_call + "obtener_tabla_index",
		type: "GET",
		dataSrc: "data", // Cambiado para apuntar a la propiedad "data" del JSON
	},
	columns: [
		{ data: "opciones", orderable: false },
		{ data: "id" },
		{ data: "nombre" },
		{ data: "correo" },
		{ data: "telefono" },
		{ data: "rfc" },
		{ data: "genero" },
		{ data: "direccion" },
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
