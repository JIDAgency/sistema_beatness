$(function () {
	// Inicializar el plugin del select
	$(".select2-disciplinas").select2({
		placeholder: "Selecciona una o más disciplinas"
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
