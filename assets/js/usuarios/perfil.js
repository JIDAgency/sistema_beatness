$(function () {

	// Inicializar máscaras
	$('.tel-inputmask').inputmask("(999) 999-9999");

	// Inicializar date dropper
	$('.date-dropper').dateDropper({
		dropWidth: 200,
		animate: false,
		format: "d/m/Y",
		lang: 'es'
	});

	// Establecer validaciones
	$("#forma-actualizar-datos").validate({
		rules: {
			"nombre_usuario": {
				required: true
			},
			"nombre_completo": {
				required: true
			},
			"apellido_paterno": {
				required: true
			}

		},
		messages: {
			"nombre_usuario": {
				required: "El usuario es requerido"
			},
			"nombre_completo": {
				required: "Por favor escriba un nombre"
			},
			"apellido_paterno": {
				required: "Es requerido"
			}
		},
		errorClass: "has-error",
	});

	$("#forma-cambiar-contrasena").validate({
		rules: {
			"contrasena_actual": {
				required: true
			},
			"contrasena_nueva": {
				required: true
			},
			"confirmar_contrasena": {
				required: true,
				equalTo: "#contrasena_nueva"
			}

		},
		messages: {
			"contrasena_actual": {
				required: "La contraseña actual es requerida"
			},
			"contrasena_nueva": {
				required: "Por favor escriba una contraseña nueva"
			},
			"confirmar_contrasena": {
				required: "Confirme por favor la contraseña nueva",
				equalTo: "Las contraseñas deben coincidir"

			}
		},
		errorClass: "has-error",
	});

	// Sección subir de foto de perfil
	var avatarCabecera = document.getElementById('img-avatar-header');
	var avatar = document.getElementById('perfil-avatar');
	var imagen = document.getElementById('img-perfil-cropper');
	var input = document.getElementById('img-perfil');
	var cropper = new Cropper(imagen, {
		viewMode: 1,
		restore: false,
		minContainerWidth: 800,
		minContainerHeight: 400,
		zoomOnWheel: false
	});

	var nombreArchivo = "";


	input.addEventListener('change', function (e) {
		var files = e.target.files;
		var done = function (url) {
			input.value = '';
			imagen.src = url;
			cropper.replace(url);
		};
		var reader;
		var file;

		if (files && files.length > 0) {
			file = files[0];
			nombreArchivo = file.name;
			if (URL) {
				done(URL.createObjectURL(file));
			} else if (FileReader) {
				reader = new FileReader();
				reader.onload = function (e) {
					done(reader.result);
				};
				reader.readAsDataURL(file);
			}
		}
	});



	$("#subir-imagen").on('click', function () {
		var avatarURLInicial;
		var canvas;
		var that = $(this);
		$("#subir-imagen").LoadingOverlay("show");
		if (cropper) {
			canvas = cropper.getCroppedCanvas({
				width: 160,
				height: 160,
			});
			avatarURLInicial = avatar.src;
			avatar.src = canvas.toDataURL();
			avatarCabecera.src = canvas.toDataURL();
			// Inhabilitar botón para no permitir otra subida mientras la actual se está efectuando
			that.prop('disabled', true);
			canvas.toBlob(function (blob) {
				var formData = new FormData();

				formData.append('img_perfil', blob, nombreArchivo);
				$.ajax('http://localhost:8888/proyecto_b3/usuarios/subir_imagen', {
					method: 'POST',
					data: formData,
					processData: false,
					contentType: false,

					success: function () {

						toastr.success('La imagen se ha subido exitosamente', 'Imagen cargada', {
							positionClass: 'toast-bottom-full-width',
							containerId: 'toast-bottom-full-width'
						});

					},

					error: function (jqXHR) {
						avatar.src = avatarURLInicial;
						avatarCabecera.src = avatarURLInicial;
						toastr.error(jqXHR.responseJSON.error, 'Imagen no cargada', {
							positionClass: 'toast-bottom-full-width',
							containerId: 'toast-bottom-full-width'
						});

					},

					complete: function () {
						that.prop('disabled', false);
						$("#subir-imagen").LoadingOverlay("hide");
					}
				});
			});
		}
	});
});
