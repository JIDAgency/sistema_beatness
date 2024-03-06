$(function () {
	$("#forma-iniciar-sesion").validate({
		rules: {
			"correo": {
                required: true,
                email: false
			},
			"contrasena": {
				required: true
			}
		},
		messages: {
			"correo": {
				required: "El correo es requerido"
			},
			"contrasena": {
				required: "La contraseña es requerida"
			}
		},
		errorClass: "has-error"
	});
});
