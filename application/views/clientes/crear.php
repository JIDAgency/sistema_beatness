<div class="app-content content center-layout mt-2">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
				<div class="row breadcrumbs-top">
					<div class="breadcrumb-wrapper col-12">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php echo site_url('inicio/index') ?>">Inicio</a>
							</li>
							<li class="breadcrumb-item"><a href="<?php echo site_url('clientes/index') ?>">Clientes</a>
							</li>
							<li class="breadcrumb-item active">Crear nuevo cliente
							</li>
						</ol>
					</div>
				</div>
			</div>
		</div>
		<div class="content-body">
			<section>
				<div class="row">
					<div class="col-12">
						<div class="card">
							<div class="card-header">
								<h4 class="card-title">Nuevo cliente</h4>
							</div>
							<div class="card-content">
								<div class="card-body">

									<?php echo form_open_multipart(site_url('clientes/crear'), array('class' => 'needs-validation p-2', 'id' => 'forma-crear-cliente', 'method' => 'post')); ?>
									<?php $this->load->view('_templates/mensajes_alerta.tpl.php'); ?>

											<h4 class="form-section">Foto de perfil</h4>
											<div class="row">
												<div class="col-sm-3">
													<input type="text" id="nombre-foto" placeholder="Nombre de la foto" style="display: none;">
													<br>
													<br>
													<canvas id="canvas" width="300" height=200" style="display: none; clip-path: circle(120px at center);"></canvas>
													<img id="captured-photo" width="300" height="200">
												</div>
												<div class="col-sm-9">
    												<video id="video" height="254" style="clip-path: circle(120px at center);" autoplay></video>
													<h2>Seleccionar webcam</h2>
													<div class="row">
														<select id="camera-select"></select>
														<a id="capture-btn" class="btn btn-secondary white" style="font-size: 20px;"><i class="ft-camera"></i> Tomar foto</a>
													</div>
												</div>
											</div>

											<h4 class="form-section">Datos de acceso</h4>

											<div class="row">
												<div class="col-md-6">
													<div class="form-group row">
														<label for="correo" class="col-md-3 label-control"><span class="red">*</span> Email</label>
														<div class="col-md-9">
															<input type="email" name="correo" id="correo" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toLowerCase()" class="form-control" placeholder="Email" value="<?php echo set_value('correo'); ?>">
														</div>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group row">
														<label for="contrasena" class="col-md-3 label-control"><span class="red">*</span> Contraseña</label>
														<div class="col-md-9">
															<input type="password" name="contrasena" class="form-control" placeholder="Contraseña">
														</div>
													</div>
												</div>
											</div>

											<h4 class="form-section">Datos de contacto</h4>

											<div class="row">
												<div class="col-md-6">
													<div class="form-group row">
														<label for="nombre_completo" class="col-md-3 label-control"><span class="red">*</span> Nombre/s</label>
														<div class="col-md-9">
															<input type="text" name="nombre_completo" class="form-control" placeholder="Nombre/s" value="<?php echo set_value('nombre_completo'); ?>">
														</div>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group row">
														<label for="apellido_paterno" class="col-md-3 label-control"><span class="red">*</span> Apellido paterno</label>
														<div class="col-md-9">
															<input type="text" name="apellido_paterno" class="form-control" placeholder="Apellido Paterno" value="<?php echo set_value('apellido_paterno'); ?>">
														</div>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-md-6">
													<div class="form-group row">
														<label for="apellido_materno" class="col-md-3 label-control">Apellido materno</label>
														<div class="col-md-9">
															<input type="text" name="apellido_materno" class="form-control" placeholder="Apellido Materno" value="<?php echo set_value('apellido_materno'); ?>">
														</div>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group row">
														<label for="no_telefono" class="col-md-3 label-control">Télefono</label>
														<div class="col-md-5">
															<input autocomplete="off" type="text" class="form-control tel-inputmask" name="no_telefono" placeholder="No. de Teléfono"
															value="<?php echo set_value('no_telefono'); ?>">
														</div>
													</div>
												</div>
											</div>

											<h4 class="form-section">Datos personales</h4>

											<div class="row">
												<div class="col-md-6">
													<div class="form-group row">
														<label for="fecha_nacimiento" class="col-md-3 label-control">Fecha de nacimiento</label>
														<div class="col-md-9">
														<input type="text" name="fecha_nacimiento" class="date-dropper form-control" placeholder="Seleccione una fecha" value="<?php echo set_value('fecha_nacimiento'); ?>">
														</div>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group row">
														<label for="rfc" class="col-md-3 label-control">RFC</label>
														<div class="col-md-9">
															<input type="text" name="rfc" class="form-control" placeholder="RFC" value="<?php echo set_value('rfc'); ?>">
														</div>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-md-6">
													<div class="form-group row">
														<label for="genero" class="col-md-3 label-control">Género</label>
														<div class="col-md-3">
															<select name="genero" class="form-control">
																<option value="H" value="<?php echo set_select('genero', 'H'); ?>">Hombre</option>
																<option value="M" value="<?php echo set_select('genero', 'M'); ?>">Mujer</option>
															</select>
														</div>
													</div>
												</div>
											</div>

											<h4 class="form-section">Domicilio</h4>

											<div class="row">
												<div class="col-md-6">
													<div class="form-group row">
														<label for="pais" class="col-md-3 label-control">País</label>
														<div class="col-md-9">
															<input type="text" name="pais" class="form-control" placeholder="País" value="México" value="<?php echo set_value('pais'); ?>">
														</div>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group row">
														<label for="estado" class="col-md-3 label-control">Estado</label>
														<div class="col-md-9">
															<input type="text" name="estado" class="form-control" placeholder="Estado" value="<?php echo set_value('estado'); ?>">
														</div>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-md-6">
													<div class="form-group row">
														<label for="ciudad" class="col-md-3 label-control">Ciudad</label>
														<div class="col-md-9">
															<input type="text" name="ciudad" class="form-control" placeholder="Ciudad" value="<?php echo set_value('ciudad'); ?>">
														</div>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group row">
														<label for="colonia" class="col-md-3 label-control">Colonia</label>
														<div class="col-md-9">
															<input type="text" name="colonia" class="form-control" placeholder="Colonia" value="<?php echo set_value('colonia'); ?>">
														</div>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-md-6">
													<div class="form-group row">
														<label for="calle" class="col-md-3 label-control">Calle</label>
														<div class="col-md-9">
															<input type="text" name="calle" class="form-control" placeholder="Calle" value="<?php echo set_value('calle'); ?>">
														</div>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group row">
														<label for="numero" class="col-md-3 label-control">Número</label>
														<div class="col-md-3">
															<input type="text" name="numero" class="form-control" placeholder="Número" value="<?php echo set_value('numero'); ?>">
														</div>
													</div>
												</div>
											</div>

											<div class="form-actions right">
												<a href="<?php echo site_url('clientes/index'); ?>" class="btn btn-secondary btn-sm">Cancelar</a>
												<button id="guardar-btn" type="submit" class="btn btn-secondary btn-sm">Guardar</button>
											</div>
										</div>

									<?php echo form_close(); ?>

									<!-- con estos scripts accedemos, capturamos, y obtenemos nombre de foto con la camara web,  -->
									<!-- y enviamos los datos de la foto con ayuda del ajax al controlador clientes -->
									<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
									<script>
										const cameraSelect = document.getElementById('camera-select');
										const video = document.getElementById('video');
										const captureBtn = document.getElementById('capture-btn');
										const guardarBtn = document.getElementById('guardar-btn');
										const nombreFotoInput = document.getElementById('nombre-foto');
										const canvas = document.getElementById('canvas');
										const ctx = canvas.getContext('2d');
										const capturedPhoto = document.getElementById('captured-photo');
										const localStorageKey = 'capturedPhoto';

										// Obtener la lista de cámaras disponibles
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

											// Recuperar la foto capturada anterior, si existe
											// const previousCapturedPhoto = localStorage.getItem(localStorageKey);
											// if (previousCapturedPhoto) {
											// capturedPhoto.src = previousCapturedPhoto;
											// capturedPhoto.style.display = 'block';
											// downloadBtn.style.display = 'inline-block';
											// }

											// Iniciar la webcam con la primera cámara disponible
											await initCamera();
										} catch (err) {
											console.error('Error al obtener la lista de cámaras: ', err);
										}
										}

										 // Obtener la foto capturada previamente, si existe
    									function restoreCapturedPhoto() {
    									  const photoDataURL = localStorage.getItem(localStorageKey);
    									  if (photoDataURL) {
    									    capturedPhoto.src = photoDataURL;
    									    capturedPhoto.style.display = 'block';
    									    // downloadBtn.style.display = 'inline-block';
    									  }
    									}

										// Iniciar la webcam con la cámara seleccionada
										async function initCamera() {
										const selectedCameraIndex = cameraSelect.value;
										const devices = await navigator.mediaDevices.enumerateDevices();
										const videoDevices = devices.filter(device => device.kind === 'videoinput');
										const selectedCamera = videoDevices[selectedCameraIndex];

										try {
											const stream = await navigator.mediaDevices.getUserMedia({
											video: {
												deviceId: selectedCamera.deviceId,
											}
											});
											video.srcObject = stream;
										} catch (err) {
											console.error('Error al acceder a la webcam: ', err);
										}
										}

										// Capturar foto y mostrarla en el canvas
										function capturePhoto() {
										ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
										capturedPhoto.src = canvas.toDataURL('image/png');

										// canvas.style.display = 'block';
										video.style.display = 'block';
										// captureBtn.style.display = 'block';
										// guardarBtn.style.display = 'inline-block';
										capturedPhoto.style.display = 'block';

										// Guardar la foto capturada en el localStorage
      									localStorage.setItem(localStorageKey, capturedPhoto.src);
										}

										// Guardar la foto con el nombre ingresado en el input
										function guardarFoto() {
										const nombreFoto = nombreFotoInput.value;
										if (nombreFoto.trim() != '') {
											return;
										}

										const imageDataURL = canvas.toDataURL('image/png');

										$.ajax({
											type: 'POST',
											url: '<?php echo base_url('clientes/guardar_foto'); ?>',
											data: {
											nombre_foto: nombreFoto,
											imagen_data: imageDataURL
											},

											// Lineas de código para mandar mensaje dependiendo de la situación al guardar foto
											// success: function(response) {
											// alert('Foto guardada con éxito.');
											// },
											// error: function(xhr, status, error) {
											// console.error('Error al guardar la foto: ', error);
											// }
										});
										}

										// Event listeners
										cameraSelect.addEventListener('change', initCamera);
										captureBtn.addEventListener('click', capturePhoto);
										guardarBtn.addEventListener('click', guardarFoto);

										// Obtener la lista de cámaras disponibles al cargar la página
    									getAvailableCameras();
										restoreCapturedPhoto();
									</script>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</div>
