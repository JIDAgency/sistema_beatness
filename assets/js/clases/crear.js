$(function () {
	// Inicializar date dropper

	// Establecer validaciones
	$("#forma-crear-clase").validate({
		rules: {
			"identificador": {
				required: true
			},
			"instructor_id": {
				required: true
			},
			/*"dificultad": {
				required: true
			},*/
			"intervalo_horas": {
				required: true,
				number: true
			},
			"disciplina_id": {
				required: true
			},
			"cupo": {
				required: true
			}
		},
		messages: {
			"identificador": {
				required: "Este campo es requerido"
			},
			"instructor_id": {
				required: "Debe seleccionar un instructor"
			},
			/*"dificultad": {
				required: "Este campo es requerido"
			},*/

			"intervalo_horas": {
				required: "Este campo es requerido",
				number: "Debe ser un valor numerico"
			},
			"disciplina_id": {
				required: "Por favor seleccione una disciplina"
			},
			"cupo": {
				required: "Debe establecer el cupo"
			}
		},
		errorClass: "has-error"
	});
});
