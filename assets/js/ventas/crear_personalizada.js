$(document).ready(function () {
	// Actualizar Sucursal en la ficha
	$("#seleccionar_sucursal").on("change", function () {
		const sucursal = $(this).find("option:selected").data("sucursal");
		$("#ficha_sucursal").html(sucursal);
	});

	// Evitar que el mousewheel modifique los inputs numéricos o de costo
	$(
		"#plan_personalizado_costo_plan, #plan_personalizado_clases_incluidas, #plan_personalizado_vigencia_en_dias"
	).on("mousewheel", function (event) {
		$(this).blur();
	});

	// Actualizar Comprador en la ficha
	$("#seleccionar_cliente").on("change", function () {
		const nombreCompleto = $(this)
			.find("option:selected")
			.data("nombre_completo");
		$("#ficha_nombre_compador").html(nombreCompleto);
	});

	// Actualizar el nombre del plan personalizado en la ficha
	$("#plan_personalizado_nombre").on("keyup", function () {
		const nombre = $(this).val();
		$("#ficha_nombre_producto").html(nombre);
	});

	// Actualizar el costo del plan y el total en la ficha
	$("#plan_personalizado_costo_plan").on("keyup", function () {
		const costo = $(this).val();
		$("#ficha_costo_unitario").html(costo);
		$("#ficha_cantidad_a_vender").html(1);
		$("#ficha_precio_total").html(costo);
	});
});

// Actualiza el resumen del Método de Pago
function getRating(el) {
	const metodoPago = $(el).data("metodos_pago");
	let mensaje = metodoPago;
	if (metodoPago === "Cortesía") {
		mensaje +=
			'<br><small class="text-danger">(El total será de $0.00)</small>';
	}
	$("#ficha_metodo_pago").html(mensaje);
}

(function () {
	"use strict";
	window.addEventListener(
		"load",
		function () {
			const forms = document.getElementsByClassName("needs-validation");
			Array.prototype.filter.call(forms, function (form) {
				form.addEventListener(
					"submit",
					function (event) {
						if (form.checkValidity() === false) {
							event.preventDefault();
							event.stopPropagation();
						}
						form.classList.add("was-validated");
					},
					false
				);
			});
		},
		false
	);
})();
