$(function () {
	$("#forma-olvido-contrasena").validate({
		rules: {
			"correo": {
				required: true,
				email: false
			}
		},
		messages: {
			"correo": {
				required: "El correo es requerido"
			}
		},
		errorClass: "has-error"
	});
});
