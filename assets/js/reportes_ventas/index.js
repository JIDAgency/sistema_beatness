var table;

const methodCall = window.location.href.includes("index")
	? ""
	: "reportes_ventas/";

/**
 * Esta línea desactiva los mensajes de error de DataTables.
 */
$.fn.dataTable.ext.errMode = "throw";

$(document).ready(function () {
	// Declaramos la tabla como constante, ya que se inicializa una sola vez.
	table = $("#table").DataTable({
		scrollX: true, // Descomenta si necesitas scroll horizontal
		deferRender: true,
		processing: true,
		order: [[0, "asc"]],
		lengthMenu: [
			[25, 50, 100, 250, 500, -1],
			[25, 50, 100, 250, 500, "Todos"],
		],
		ajax: {
			url: methodCall + "obtener_tabla_index",
			type: "POST",
		},
		columns: [
			{ data: "id" }, // ID de la venta
			{ data: "concepto" }, // Producto: ejemplo "1 CLASE CDMX #1"
			{ data: "producto" }, // Producto: ejemplo "1 CLASE CDMX #1"
			{ data: "cliente" }, // Cliente: nombre y número
			{ data: "fecha_venta" }, // Fecha de venta (formateada)
			{ data: "total" }, // Total de la venta
			{ data: "metodo" }, // Método de pago
			{ data: "sucursales_locacion" }, // Ubicación de la sucursal
			{ data: "vendedor" }, // Vendedor
			{ data: "estatus" }, // Estatus de la venta
			{ data: "cantidad" }, // Cantidad (número de productos o clases vendidos)
			{ data: "clases" }, // Columna combinada: clases usadas/incluidas (ej: "10/30")
			{ data: "vigencia_en_dias" }, // Vigencia del plan en días
			{ data: "fecha_activacion" }, // Fecha de activación del plan
		],
		language: {
			sProcessing: '<i class="fa fa-spinner spinner"></i> Cargando...',
			sLengthMenu: "Mostrar _MENU_",
			sZeroRecords: "No se encontraron resultados",
			sEmptyTable: "Ningún dato disponible en esta tabla =(",
			sInfo: "Mostrando del _START_ al _END_ de _TOTAL_",
			sInfoEmpty: "Mostrando del 0 al 0 de 0",
			sInfoFiltered: "(filtrado _MAX_)",
			sInfoPostFix: "",
			sSearch: "Buscar:",
			sUrl: "",
			sInfoThousands: ",",
			sLoadingRecords: "&nbsp;",
			oPaginate: {
				sFirst: "Primero",
				sLast: "Último",
				sNext: ">",
				sPrevious: "<",
			},
			oAria: {
				sSortAscending:
					": Activar para ordenar la columna de manera ascendente",
				sSortDescending:
					": Activar para ordenar la columna de manera descendente",
			},
		},
	});

	// Inicialización y adición de los botones de exportación
	const buttons = new $.fn.dataTable.Buttons(table, {
		buttons: ["excelHtml5"],
	})
		.container()
		.appendTo($("#buttons"));
});
