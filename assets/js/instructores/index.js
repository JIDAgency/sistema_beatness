var table;
var actual_url = window.location.href;
var method_call = "";

actual_url.indexOf("index") < 0
	? (method_call = "instructores/")
	: (method_call = "");

$.fn.dataTable.ext.errMode = "throw";

table = $("#tabla").DataTable({
	ajax: {
		url: method_call + "ajax_list",
		type: "GET",
	},
	columns: [
		{ data: 0, orderable: false },
		{ data: 1 },
		{ data: 2 },
		{ data: 3 },
		{ data: 4 },
		{ data: 5 },
		{ data: 6 },
		{ data: 7 },
	],
	scrollX: true,
	deferRender: true,
	processing: true,
	order: [[1, "desc"]],
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
		sLoadingRecords: "&nbsp;",
		oPaginate: {
			sFirst: "Primero",
			sLast: "Último",
			sNext: ">",
			sPrevious: "<",
		},
		buttons: {
			copy: "Copiar",
			colvis: "Visibilidad",
		},
	},
});

// Delegar el evento click para el botón de eliminar en la tabla
$("#tabla tbody").on("click", ".btn-delete", function () {
	var instructorId = $(this).data("id");
	// Guarda el ID en el modal y muestra el modal de confirmación
	$("#deleteModal").data("id", instructorId).modal("show");
});

// Al confirmar la eliminación en el modal
$("#confirmDelete").on("click", function () {
	var id = $("#deleteModal").data("id");
	$.ajax({
		url: method_call + "eliminar",
		type: "POST",
		data: { id: id },
		dataType: "json",
		success: function (response) {
			if (response.error === false) {
				// Recarga la tabla sin recargar la página completa
				table.ajax.reload(null, false);
				$("#deleteModal").modal("hide");
				alert(response.mensaje);
			} else {
				alert(response.mensaje);
			}
		},
		error: function () {
			alert("Error al eliminar el instructor.");
		},
	});
});
