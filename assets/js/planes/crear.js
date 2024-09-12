document.addEventListener('DOMContentLoaded', function() {
	var pagarEnSelect = document.getElementById('pagar_en');
	var urlPago = document.getElementById('urlPago');

	pagarEnSelect.addEventListener('change', function() {
		console.log(this.value);
		console.log(pagarEnSelect.value);
		if (pagarEnSelect.value === 'url') { // Ajusta este valor según corresponda al valor de "si" en tu select
			urlPago.style.display = 'block';
		} else {
			urlPago.style.display = 'none';
		}
	});

	// Verificar el valor inicial al cargar la página
	if (pagarEnSelect.value === 'url') { // Ajusta este valor según corresponda al valor de "si" en tu select
		urlPago.style.display = 'block';
	}
});

$(function () {
	// Inicializar el plugin del select
	$(".select2-disciplinas").select2({
		placeholder: "Selecciona una o más disciplinas"
	});

	// Inicializar el plugin del select
	$(".select2-categorias").select2({
		placeholder: "Selecciona las categorías de venta"
	});

	// Establecer validaciones
	$("#forma-crear-plan").validate({
		rules: {
			"sku": {
				required: true
			},
			"nombre": {
				required: true
			},
			"clases_incluidas": {
				required: true
			},
			"vigencia_en_dias": {
				required: true
			},
			"costo": {
				required: true,
				number: true
			}

		},
		messages: {
			"sku": {
				required: "El sku es requerido"
			},
			"nombre": {
				required: "El nombre es requerido"
			},
			"clases_incluidas": {
				required: "Debe establecer el número de clases incluidas en este plan"
			},
			"vigencia_en_dias": {
				required: "Por favor indique la vigencia"
			},
			"costo": {
				required: "El costo es requerido",
				number: "Debe ser un valor númerico"
			}
		},
		errorClass: "has-error"
	});
});
