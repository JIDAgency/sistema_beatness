document.addEventListener('DOMContentLoaded', function() {
	var estudianteSelect = document.getElementById('es_estudiante');
	var vigenciaRow = document.getElementById('vigencia_estudiante_row');

	estudianteSelect.addEventListener('change', function() {
		console.log(this.value);
		console.log(estudianteSelect.value);
		if (estudianteSelect.value === 'si') { // Ajusta este valor según corresponda al valor de "si" en tu select
			vigenciaRow.style.display = 'block';
		} else {
			vigenciaRow.style.display = 'none';
		}
	});

	// Verificar el valor inicial al cargar la página
	if (estudianteSelect.value === 'si') { // Ajusta este valor según corresponda al valor de "si" en tu select
		vigenciaRow.style.display = 'block';
	}
});

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
	$("#forma-crear-cliente").validate({
		rules: {
			"contrasena": {
				required: true
			},
			"rol_id": {
				required: true
			},
			"correo": {
				required: true,
				email: true
			},
			"nombre_completo": {
				required: true
			},
			"apellido_paterno": {
				required: true
			}

		},
		messages: {
			"contrasena": {
				required: "La contraseña es requerida"
			},
			"rol_id": {
				required: "Debe seleccionar un rol"
			},
			"correo": {
				required: "El correo es requerido",
				email: "Debe ser una dirección de email correcta"
			},
			"nombre_completo": {
				required: "Por favor escriba un nombre"
			},
			"apellido_paterno": {
				required: "Es requerido"
			}
		},
		errorClass: "has-error"
	});

});

var cargar_imagen = function(event) {
    var reader = new FileReader();
    reader.onload = function(){
      var output = document.getElementById('preview');
      output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
};

var cargar_imagen_ine = function(event) {
    var reader = new FileReader();
    reader.onload = function(){
      var output = document.getElementById('preview_ine');
      output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
};

// Obtener acceso a la webcam y mostrar el video en el elemento <video>
// navigator.mediaDevices.getUserMedia({ video: true })
// 	.then(function(stream) {
// 		var video = document.getElementById('video');
// 		video.srcObject = stream;
// 		video.play();
// 	})
// 	.catch(function(error) {
// 		console.log('Error al acceder a la webcam: ', error);
// 	});

// // Capturar la foto cuando se hace clic en el botón "Capturar foto"
// var captureBtn = document.getElementById('captureBtn');
// captureBtn.addEventListener('click', function() {
// 	var video = document.getElementById('video');
// 	var canvas = document.getElementById('canvas');
// 	var photo = document.getElementById('photo');
	
// 	// Capturar imagen del video y mostrarla en el elemento <img>
// 	canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
// 	var dataURL = canvas.toDataURL('image/png');
// 	photo.setAttribute('src', dataURL);
	
// 	var xhr = new XMLHttpRequest();
// 	// xhr.open('POST', '<?php echo base_url('clientes/guardarFoto'); ?>', true);
//   xhr.open('POST', '../clientes/guardarFoto', true);
// 	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
// 	xhr.onreadystatechange = function() {
// 		if (xhr.readyState === 4 && xhr.status === 200) {
// 			// Aquí puedes manejar la respuesta del controlador si es necesario
// 			console.log('Imagen guardada correctamente');
// 		}
// 	};
// 	xhr.send('imagen=' + encodeURIComponent(dataURL));
// });