let table;

// Construir URL dinámica
var baseUrl =
	window.location.origin + window.location.pathname.replace(/\/index$/, "");
var apiUrl = baseUrl + "/obtener_tabla_index";

// Configuración de manejo de errores de DataTables
$.fn.dataTable.ext.errMode = "throw";

document.addEventListener("DOMContentLoaded", function () {
	$(".select2").select2();

	table = $("#table").DataTable({
		searching: true,
		scrollX: true,
		deferRender: true,
		processing: true,
		order: [[1, "desc"]],
		lengthMenu: [
			[25, 50, 100, 250, 500, -1],
			[25, 50, 100, 250, 500, "Todos"],
		],
		ajax: {
			url: apiUrl,
			type: "POST",
			data: function (d) {
				d.start_date = $("#start_date").val();
				d.end_date = $("#end_date").val();
			},
		},
		columns: [
			{ data: "opciones" },
			{ data: "id" },
			{
				data: "estatus_validacion",
				createdCell: function (td, cellData, rowData, row, col) {
					if (cellData === "PENDIENTE") {
						$(td).addClass("bg-warning");
					} else if (cellData === "RECHAZADO") {
						$(td).addClass("bg-danger");
					} else if (cellData === "APROBADO") {
						$(td).addClass("bg-success");
					}
				},
			},
			{ data: "concepto" },
			{ data: "venta_id" },
			{ data: "metodo_de_pago" },
			{ data: "comprador" },
			{ data: "categoria" },
			{ data: "estatus" },
			{ data: "costo" },
			{ data: "cantidad" },
			{ data: "total" },
			{ data: "fecha_venta" },
			{ data: "usuario_id" },
			{ data: "comprador_correo" },
			{ data: "comprador_nombre_completo" },
			{ data: "asignacion_id" },
			{ data: "asignacion" },
			{ data: "asignacion_vigencia_en_dias" },
			{ data: "asignacion_clases_del_plan" },
			{ data: "sucursal" },
			{ data: "vendedor" },
		],
		columnDefs: [
			{ orderable: false, targets: 0 }, // Deshabilitar ordenación en la primera columna (opciones)
		],
		language: {
			url: "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json",
		},
		dom: '<"top"lfB>rt<"bottom"ip><"clear">', // Elementos de la tabla (l: longitud de página, f: filtro, B: botones, r: procesamiento, t: tabla, i: información, p: paginación)
		buttons: ["csv", "excel"],
		initComplete: function () {
			this.api()
				.columns([2])
				.every(function () {
					var column = this;
					var select = $("#estatus");
					column
						.data()
						.unique()
						.sort()
						.each(function (d, j) {
							select.append('<option value="' + d + '">' + d + "</option>");
						});
				});
			this.api()
				.columns([6])
				.every(function () {
					var column = this;
					var select = $("#cliente");
					column
						.data()
						.unique()
						.sort()
						.each(function (d, j) {
							select.append('<option value="' + d + '">' + d + "</option>");
						});
				});
			this.api()
				.columns([20])
				.every(function () {
					var column = this;
					var select = $("#sucursal");
					column
						.data()
						.unique()
						.sort()
						.each(function (d, j) {
							select.append('<option value="' + d + '">' + d + "</option>");
						});
				});
		},
	});

	$("#estatus").on("change", function () {
		var search = [];

		$.each($("#estatus option:selected"), function () {
			search.push($(this).val());
		});

		search = search.join("|");
		table.column(2).search(search, true, false).draw();
	});

	$("#cliente").on("change", function () {
		var search = [];

		$.each($("#cliente option:selected"), function () {
			search.push($(this).val());
		});

		search = search.join("|");
		table.column(6).search(search, true, false).draw();
	});

	$("#sucursal").on("change", function () {
		var search = [];

		$.each($("#sucursal option:selected"), function () {
			search.push($(this).val());
		});

		search = search.join("|");
		table.column(20).search(search, true, false).draw();
	});

	$("#filter_button").on("click", function () {
		table.ajax.reload();
		table.draw();
	});
});

function mostrarMensaje(tipo, mensaje) {
	const mensajeAlerta = $("#mensaje_en_pantalla");
	let clase = "";

	switch (tipo) {
		case "success":
			clase = "text-success";
			break;
		case "error":
			clase = "text-danger";
			break;
		case "warning":
			clase = "text-warning";
			break;
		default:
			clase = "text-info";
			break;
	}

	mensajeAlerta.html(`<span class="${clase}">${mensaje}</span>`);
	mensajeAlerta.show();
	// setTimeout(() => {
	// 	mensajeAlerta.hide();
	// }, 5000);
}

async function validar(id) {
	try {
		const response = await fetch(`${baseUrl}/obtener_datos_venta/${id}`);
		const data = await response.json();

		if (data.status === "success") {
			const venta = data.data;
			const precios = data.precios;
			const precio_asignado =
				data.precio_asignado && data.precio_asignado !== 0
					? data.precio_asignado
					: venta.costo;

			$("#texto_id").html(`#${venta.id}`);
			$("#texto_concepto").html(venta.concepto);
			$("#texto_comprador").html(`${venta.comprador} #${venta.usuario_id}`);
			$("#texto_sucursal").html(
				`${venta.sucursal_nombre} (${venta.sucursal_locacion})`
			);

			$("#venta_id").val(venta.id);
			$("#precio_original").val(venta.costo);
			$("#precio_modificado").val(data.precio_asignado);

			$("#precio_opcion1").val(precios["Cycling Polanco"]);
			$("#precio_opcion2").val(precios["Bootcamp y Cycling Puebla"]);
			$("#precio_opcion3").val(precios["Bootcamp Polanco"]);

			$("#validarModal").modal("show");
		} else {
			mostrarMensaje("error", data.message);
		}
	} catch (error) {
		console.error("Error al obtener los datos de la venta:", error);
		mostrarMensaje("error", "Error al obtener los datos de la venta");
	}
}

$("#guardarCambios").on("click", async function () {
	const id = $("#venta_id").val();
	const precio_modificado = $("#precio_modificado").val();

	const button = $(this);
	const originalText = button.html();
	button.prop("disabled", true);
	button.html(
		'<span class="spinner-border spinner-border-sm text-warning" role="status" aria-hidden="true"></span> Guardando...'
	);

	try {
		const response = await fetch(`${baseUrl}/validar`, {
			method: "POST",
			headers: {
				"Content-Type": "application/json",
			},
			body: JSON.stringify({ id, precio_modificado }),
		});

		const data = await response.json();

		if (data.status === "success") {
			$("#validarModal").modal("hide");
			table.ajax.reload(null, false);
			mostrarMensaje("success", "Validación exitosa");
		} else {
			mostrarMensaje("error", `Error al validar: ${data.message}`);
		}
	} catch (error) {
		console.error("Error al validar:", error);
		mostrarMensaje("error", `Error al validar: ${error.message}`);
	} finally {
		button.prop("disabled", false);
		button.html(originalText);
	}
});

$('input[name="precio_opcion"]').on("change", function () {
	$("#precio_modificado").val($(this).val());
});

async function rechazar(id) {
	if (confirm("¿Está seguro de que desea rechazar esta venta?")) {
		try {
			const response = await fetch(`${baseUrl}/rechazar`, {
				method: "POST",
				headers: {
					"Content-Type": "application/json",
				},
				body: JSON.stringify({ id }),
			});

			const data = await response.json();

			if (data.status === "success") {
				table.ajax.reload(null, false);
				mostrarMensaje("success", "Venta rechazada exitosamente");
			} else {
				mostrarMensaje("error", `Error al rechazar: ${data.message}`);
			}
		} catch (error) {
			console.error("Error al rechazar:", error);
			mostrarMensaje("error", `Error al rechazar: ${error.message}`);
		}
	}
}
