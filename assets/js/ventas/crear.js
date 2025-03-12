$(document).ready(function () {
	// Función auxiliar para actualizar elementos de la ficha
	const actualizarFicha = (id, valor) => {
		$("#" + id).html(valor);
	};

	// Actualizar Sucursal
	$("#seleccionar_sucursal").on("change", function () {
		const sucursal = $(this).find("option:selected").data("sucursal");
		actualizarFicha("ficha_sucursal", sucursal);
	});

	// Actualizar Comprador
	$("#seleccionar_cliente").on("change", function () {
		const nombreCompleto = $(this)
			.find("option:selected")
			.data("nombre_completo");
		actualizarFicha("ficha_nombre_compador", nombreCompleto);
	});

	// Actualizar datos del Plan
	$("#seleccionar_plan").on("change", function () {
		const $opcion = $(this).find("option:selected");
		const nombre = $opcion.data("nombre");
		const costo = $opcion.data("costo");
		actualizarFicha("ficha_nombre_producto", nombre);
		actualizarFicha("ficha_costo_unitario", costo);
		actualizarFicha("ficha_cantidad_a_vender", 1);
		actualizarFicha("ficha_precio_total", costo);
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
