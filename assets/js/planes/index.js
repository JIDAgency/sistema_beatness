var table;
var table_suspendidos;

var actual_url = document.URL;
var method_call = "";

if (actual_url.indexOf("index") < 0) {
	method_call = "planes/";
}

/**
 * Este línea desactiva los mensajes de error de DataTables();
 */
$.fn.dataTable.ext.errMode = "throw";

$(function () {
	table = $("#tabla-planes").DataTable({
		scrollX: true,
		deferRender: true,
		processing: true,
		order: [[1, "desc"]],
		lengthMenu: [
			[25, 50, 100, 250, 500, -1],
			[25, 50, 100, 250, 500, "Todos"],
		],
		ajax: {
			url: method_call + "load_lista_de_todos_los_planes_para_datatable",
			type: "POST",
		},
		columns: [
			{ data: "listar_opciones" },
			{ data: "listar_id" },
			{ data: "listar_imagenes" },
			{ data: "listar_orden_venta" },
			{ data: "listar_nombre_completo" },
			{ data: "es_ilimitado" },
			{ data: "es_primera" },
			{ data: "es_estudiante" },
			{ data: "es_empresarial" },
			{ data: "pagar_en" },
			{ data: "sucursal" },
			{ data: "listar_clases_incluidas" },
			{ data: "listar_vigencia_en_dias" },
			{ data: "listar_costo", render: formato_moneda },
			{ data: "codigo" },
			{ data: "listar_activo" },
		],
		rowCallback: function (row, data, index) {
			if (data["es_ilimitado"] == "Si") {
				$(row).find("td:eq(5)").css("background-color", "#37BC9B");
				$(row).find("td:eq(5)").css("color", "white");
			} else if (data["es_ilimitado"] == "No") {
				$(row).find("td:eq(5)").css("background-color", "#f08383");
				$(row).find("td:eq(5)").css("color", "white");
			}

			if (data["es_primera"] == "Si") {
				$(row).find("td:eq(6)").css("background-color", "#37BC9B");
				$(row).find("td:eq(6)").css("color", "white");
			} else if (data["es_primera"] == "No") {
				$(row).find("td:eq(6)").css("background-color", "#f08383");
				$(row).find("td:eq(6)").css("color", "white");
			}

			if (data["es_estudiante"] == "Si") {
				$(row).find("td:eq(7)").css("background-color", "#37BC9B");
				$(row).find("td:eq(7)").css("color", "white");
			} else if (data["es_estudiante"] == "No") {
				$(row).find("td:eq(7)").css("background-color", "#f08383");
				$(row).find("td:eq(7)").css("color", "white");
			}

			if (data["es_empresarial"] == "Si") {
				$(row).find("td:eq(8)").css("background-color", "#37BC9B");
				$(row).find("td:eq(8)").css("color", "white");
			} else if (data["es_empresarial"] == "No") {
				$(row).find("td:eq(8)").css("background-color", "#f08383");
				$(row).find("td:eq(8)").css("color", "white");
			}

			if (data["pagar_en"] == "App") {
				$(row).find("td:eq(9)").css("background-color", "#37BC9B");
				$(row).find("td:eq(9)").css("color", "white");
			} else if (data["pagar_en"] == "Url") {
				$(row).find("td:eq(9)").css("background-color", "#F6BB42");
				$(row).find("td:eq(9)").css("color", "white");
			}

			if (data["sucursal"] == "Clases en linea") {
				$(row).find("td:eq(10)").css("background-color", "#F6BB42");
				$(row).find("td:eq(10)").css("color", "white");
			} else if (data["sucursal"] == "Puebla") {
				$(row).find("td:eq(10)").css("background-color", "#B3B3B3");
				$(row).find("td:eq(10)").css("color", "white");
			} else if (data["sucursal"] == "Polanco") {
				$(row).find("td:eq(10)").css("background-color", "#3BAFDA");
				$(row).find("td:eq(10)").css("color", "white");
			} else if (data["sucursal"] == "Origami") {
				$(row).find("td:eq(10)").css("background-color", "#B3B3B3");
				$(row).find("td:eq(10)").css("color", "white");
			}
		},
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
			buttons: {
				copy: "Copiar",
				colvis: "Visibilidad",
			},
		},
	});

	table_suspendidos = $("#tabla-planes-suspendidos").DataTable({
		scrollX: true,
		deferRender: true,
		processing: true,
		order: [[1, "desc"]],
		lengthMenu: [
			[25, 50, 100, 250, 500, -1],
			[25, 50, 100, 250, 500, "Todos"],
		],
		ajax: {
			url:
				method_call +
				"load_lista_de_todos_los_planes_suspendidos_para_datatable",
			type: "POST",
		},
		columns: [
			{ data: "listar_opciones" },
			{ data: "listar_id" },
			{ data: "listar_imagenes" },
			{ data: "listar_orden_venta" },
			{ data: "listar_nombre_completo" },
			{ data: "es_ilimitado" },
			{ data: "es_primera" },
			{ data: "es_estudiante" },
			{ data: "es_empresarial" },
			{ data: "pagar_en" },
			{ data: "sucursal" },
			{ data: "listar_clases_incluidas" },
			{ data: "listar_vigencia_en_dias" },
			{ data: "listar_costo", render: formato_moneda },
			{ data: "codigo" },
			{ data: "listar_activo" },
		],
		rowCallback: function (row, data, index) {
			if (data["es_ilimitado"] == "Si") {
				$(row).find("td:eq(5)").css("background-color", "#37BC9B");
				$(row).find("td:eq(5)").css("color", "white");
			} else if (data["es_ilimitado"] == "No") {
				$(row).find("td:eq(5)").css("background-color", "#f08383");
				$(row).find("td:eq(5)").css("color", "white");
			}

			if (data["es_primera"] == "Si") {
				$(row).find("td:eq(6)").css("background-color", "#37BC9B");
				$(row).find("td:eq(6)").css("color", "white");
			} else if (data["es_primera"] == "No") {
				$(row).find("td:eq(6)").css("background-color", "#f08383");
				$(row).find("td:eq(6)").css("color", "white");
			}

			if (data["es_estudiante"] == "Si") {
				$(row).find("td:eq(7)").css("background-color", "#37BC9B");
				$(row).find("td:eq(7)").css("color", "white");
			} else if (data["es_estudiante"] == "No") {
				$(row).find("td:eq(7)").css("background-color", "#f08383");
				$(row).find("td:eq(7)").css("color", "white");
			}

			if (data["es_empresarial"] == "Si") {
				$(row).find("td:eq(8)").css("background-color", "#37BC9B");
				$(row).find("td:eq(8)").css("color", "white");
			} else if (data["es_empresarial"] == "No") {
				$(row).find("td:eq(8)").css("background-color", "#f08383");
				$(row).find("td:eq(8)").css("color", "white");
			}

			if (data["pagar_en"] == "App") {
				$(row).find("td:eq(9)").css("background-color", "#37BC9B");
				$(row).find("td:eq(9)").css("color", "white");
			} else if (data["pagar_en"] == "Url") {
				$(row).find("td:eq(9)").css("background-color", "#F6BB42");
				$(row).find("td:eq(9)").css("color", "white");
			}

			if (data["sucursal"] == "Clases en linea") {
				$(row).find("td:eq(10)").css("background-color", "#F6BB42");
				$(row).find("td:eq(10)").css("color", "white");
			} else if (data["sucursal"] == "Puebla") {
				$(row).find("td:eq(10)").css("background-color", "#B3B3B3");
				$(row).find("td:eq(10)").css("color", "white");
			} else if (data["sucursal"] == "Polanco") {
				$(row).find("td:eq(10)").css("background-color", "#3BAFDA");
				$(row).find("td:eq(10)").css("color", "white");
			} else if (data["sucursal"] == "Origami") {
				$(row).find("td:eq(10)").css("background-color", "#B3B3B3");
				$(row).find("td:eq(10)").css("color", "white");
			}
		},
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
			buttons: {
				copy: "Copiar",
				colvis: "Visibilidad",
			},
		},
	});

	var buttons = new $.fn.dataTable.Buttons(table, {
		buttons: [
			{
				extend: "excelHtml5",
				className: "custom-button",
			},
		],
	})
		.container()
		.appendTo($("#buttons"));

	$("#sucursal").on("change", function () {
		var sucursal = $(this).val(); // Obtener el valor seleccionado
		if (sucursal) {
			table
				.column(10)
				.search("^" + sucursal + "$", true, false)
				.draw(); // Aplicar búsqueda exacta
		} else {
			table.column(10).search("").draw(); // Limpiar filtro
		}
	});

	$("#sucursal-suspendidos").on("change", function () {
		var sucursal = $(this).val(); // Obtener el valor seleccionado
		if (sucursal) {
			table_suspendidos
				.column(10)
				.search("^" + sucursal + "$", true, false)
				.draw(); // Aplicar búsqueda exacta
		} else {
			table_suspendidos.column(10).search("").draw(); // Limpiar filtro
		}
	});
});

document.querySelectorAll(".smooth-scroll").forEach((anchor) => {
	anchor.addEventListener("click", function (e) {
		e.preventDefault(); // Evita el comportamiento predeterminado
		const target = document.querySelector(this.getAttribute("href")); // Selecciona el ID del destino
		target.scrollIntoView({
			behavior: "smooth", // Desplazamiento suave
			block: "start", // Ajusta al inicio del elemento destino
		});
	});
});
