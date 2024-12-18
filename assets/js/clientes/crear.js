// ============================================================
// FUNCIÓN: Mostrar/ocultar vigencia estudiante según selección
// ============================================================
document.addEventListener('DOMContentLoaded', function () {
	var estudianteSelect = document.getElementById('es_estudiante');
	var vigenciaRow = document.getElementById('vigencia_estudiante_row');

	function toggleVigencia() {
		if (estudianteSelect.value === 'si') {
			vigenciaRow.style.display = 'block';
		} else {
			vigenciaRow.style.display = 'none';
		}
	}

	estudianteSelect.addEventListener('change', toggleVigencia);
	// Verificar el valor inicial al cargar la página
	toggleVigencia();
});

// ============================================================
// FUNCIÓN: Inicialización con jQuery
// ============================================================
$(function () {
	// Aplicar máscara a campos de teléfono si fuera necesario (ejemplo)
	$('.tel-inputmask').inputmask("(999) 999-9999");

	// Inicializar dateDropper (asumiendo que la librería está incluida)
	$('.date-dropper').dateDropper({
		dropWidth: 200,
		animate: false,
		format: "d/m/Y",
		lang: 'es'
	});

	// Validaciones del formulario
	$("#forma-crear-cliente").validate({
		rules: {
			"contrasena": { required: true },
			"rol_id": { required: true },
			"correo": { required: true, email: true },
			"nombre_completo": { required: true },
			"apellido_paterno": { required: true }
		},
		messages: {
			"contrasena": { required: "La contraseña es requerida" },
			"rol_id": { required: "Debe seleccionar un rol" },
			"correo": {
				required: "El correo es requerido",
				email: "Debe ser una dirección de email correcta"
			},
			"nombre_completo": { required: "Por favor escriba un nombre" },
			"apellido_paterno": { required: "Este campo es requerido" }
		},
		errorClass: "has-error"
	});
});

// ============================================================
// FUNCIÓN: Previsualizar imagen al cargar desde archivo
// ============================================================
var cargar_imagen = function (event) {
	var reader = new FileReader();
	reader.onload = function () {
		var output = document.getElementById('preview');
		output.src = reader.result;
	};
	reader.readAsDataURL(event.target.files[0]);
};

// Si se necesita otra función para INE (no mostrada en el formulario actual, pero se deja tal cual)
var cargar_imagen_ine = function (event) {
	var reader = new FileReader();
	reader.onload = function () {
		var output = document.getElementById('preview_ine');
		output.src = reader.result;
	};
	reader.readAsDataURL(event.target.files[0]);
};

// ============================================================
// LÓGICA DE CÁMARA Y CAPTURA DE FOTO
// (Este código asume que existen elementos como #camera-select, #video, #capture-btn, #guardar-btn, etc.)
// Si no existen en el formulario actual, omitir o adaptar.
// ============================================================

// NOTA: Debes definir la variable guardarFotoUrl en el HTML antes de este script:
// <script>var guardarFotoUrl = '<?php echo base_url('clientes/guardar_foto'); ?>';</script>

// Variables de la cámara
var cameraSelect = document.getElementById('camera-select');
var video = document.getElementById('video');
var captureBtn = document.getElementById('capture-btn');
var guardarBtn = document.getElementById('guardar-btn');
var nombreFotoInput = document.getElementById('nombre-foto');
var canvas = document.getElementById('canvas');
var ctx = canvas.getContext('2d');
var capturedPhoto = document.getElementById('captured-photo');
var localStorageKey = 'capturedPhoto';

async function getAvailableCameras() {
	try {
		const devices = await navigator.mediaDevices.enumerateDevices();
		const videoDevices = devices.filter(device => device.kind === 'videoinput');

		videoDevices.forEach((device, index) => {
			const option = document.createElement('option');
			option.value = index;
			option.text = device.label || `Cámara ${index + 1}`;
			cameraSelect.appendChild(option);
		});

		await initCamera();
	} catch (err) {
		console.error('Error al obtener la lista de cámaras: ', err);
	}
}

function restoreCapturedPhoto() {
	const photoDataURL = localStorage.getItem(localStorageKey);
	if (photoDataURL) {
		capturedPhoto.src = photoDataURL;
		capturedPhoto.style.display = 'block';
	}
}

async function initCamera() {
	const selectedCameraIndex = cameraSelect.value;
	const devices = await navigator.mediaDevices.enumerateDevices();
	const videoDevices = devices.filter(device => device.kind === 'videoinput');
	const selectedCamera = videoDevices[selectedCameraIndex];

	try {
		const stream = await navigator.mediaDevices.getUserMedia({
			video: {
				deviceId: selectedCamera.deviceId
			}
		});
		video.srcObject = stream;
	} catch (err) {
		console.error('Error al acceder a la webcam: ', err);
	}
}

function capturePhoto() {
	ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
	capturedPhoto.src = canvas.toDataURL('image/png');
	capturedPhoto.style.display = 'block';

	// Guardar la foto en localStorage
	localStorage.setItem(localStorageKey, capturedPhoto.src);
}

function guardarFoto() {
	const nombreFoto = nombreFotoInput.value;
	if (nombreFoto.trim() == '') {
		return;
	}

	const imageDataURL = canvas.toDataURL('image/png');

	$.ajax({
		type: 'POST',
		url: guardarFotoUrl, // Debes definir guardarFotoUrl antes.
		data: {
			nombre_foto: nombreFoto,
			imagen_data: imageDataURL
		},
		success: function () {
			console.log('Foto guardada correctamente.');
		},
		error: function () {
			console.log('Error al guardar la foto.');
		}
	});
}

// Event listeners de la cámara (si los elementos existen)
if (cameraSelect && video && captureBtn && guardarBtn && capturedPhoto && canvas && nombreFotoInput) {
	cameraSelect.addEventListener('change', initCamera);
	captureBtn.addEventListener('click', capturePhoto);
	guardarBtn.addEventListener('click', guardarFoto);

	getAvailableCameras();
	restoreCapturedPhoto();
}
