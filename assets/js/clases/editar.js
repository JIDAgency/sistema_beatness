$(function () {
	// Inicializar date dropper
	$('.date-dropper').dateDropper({
		dropWidth: 200,
		animate: false,
		format: "d/m/Y",
		lock: 'from',
		lang: 'es'
	});

	$('.time-dropper').timeDropper({
		format: 'HH:mm',
		init_animation: 'dropDown',
		setCurrentTime: false
	});

	// Establecer validaciones
	$("#forma-editar-clase").validate({
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
