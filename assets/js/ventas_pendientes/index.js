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
				.columns([5])
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
				.columns([19])
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
		table.column(5).search(search, true, false).draw();
	});

	$("#sucursal").on("change", function () {
		var search = [];

		$.each($("#sucursal option:selected"), function () {
			search.push($(this).val());
		});

		search = search.join("|");
		table.column(19).search(search, true, false).draw();
	});

	$("#filter_button").on("click", function () {
		table.ajax.reload();
		table.draw();
	});
});

async function validar(id, button) {
	// Deshabilitar el botón y mostrar mensaje de "Espere..."
	const originalText = button.innerHTML;
	button.disabled = true;
	button.innerHTML =
		'<span class="spinner-border spinner-border-sm text-warning" role="status" aria-hidden="true"></span> Cargando...';

	let data;

	try {
		const response = await fetch(`${baseUrl}/validar`, {
			method: "POST",
			headers: {
				"Content-Type": "application/json",
			},
			body: JSON.stringify({ id }),
		});

		if (!response.ok) {
			const errorText = await response.text();
			throw new Error(
				`Error al validar: ${response.statusText} - ${errorText}`
			);
		}

		data = await response.json();

		if (data.status === "success") {
			table.ajax.reload(null, false);
		} else {
			alert(`Error al validar: ${data.message}`);
		}
	} catch (error) {
		console.error("Error al validar:", error);
		alert(`Error al validar: ${error.message}`);
	} finally {
		// Restaurar el estado original del botón solo si la operación falla
		if (!data || data.status !== "success") {
			button.disabled = false;
			button.innerHTML = originalText;
		}
	}
}
