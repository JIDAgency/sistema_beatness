<div class="app-content content center-layout mt-2">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
				<div class="row breadcrumbs-top">
					<div class="breadcrumb-wrapper col-12">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php echo site_url('inicio/index') ?>">Inicio</a>
							</li>
							<li class="breadcrumb-item active">Mi perfil
							</li>
						</ol>
					</div>
				</div>
			</div>
		</div>

		<div class="content-body">
			<h2>Hola, <?php echo $usuario_en_sesion->nombre_completo . ' ' . $usuario_en_sesion->apellido_paterno . ' ' . $usuario_en_sesion->apellido_materno?></h2>
			<div id="user-profile">
				<div class="row">
					<div class="col-12">
						<div class="card no-border">
							<div class="card-content">
								<div class="card-body">

									<?php $this->load->view('_comun/mensajes_alerta');?>
									<?php if (validation_errors() || isset($validation_errors)): ?>
										<div class="alert bg-danger alert-icon-left alert-dismissible mb-2 font-small-3" role="alert">
											<span class="alert-icon"><i class="fa fa-thumbs-o-down"></i></span>
											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
												<span aria-hidden="true">×</span>
											</button>
											<?php echo validation_errors() ? validation_errors() : $validation_errors; ?>
										</div>
									<?php endif?>

									<div class="tab-content px-1 pt-1">
										<div role="tabpanel" class="tab-pane <?php echo $pill_seleccionado == 1 ? 'active show' : ''; ?>" id="pillEle11"
										 aria-expanded="<?php echo $pill_seleccionado == 1 ? 'true' : 'false'; ?>" aria-labelledby="base-pillEle11">
											<?php echo form_open_multipart(site_url('usuarios/actualizar_datos_personales'), array('class' => 'form form-horizontal', 'id' => 'forma-actualizar-datos', 'method' => 'post')); ?>
											<div class="form-body">

												<h4 class="form-section">Foto</h4>
												<div class="form-group">
                                        		    <div class="row">
                                        		        <div class="col-sm-3">
															<img src="<?php echo site_url("subidas/perfil/".$usuario_en_sesion->nombre_imagen_avatar); ?>" alt="" style="width: 200px; height: 200px;">
                                        		        </div>
														<div class="col-sm-9">
															<p><b>Formato: </b>JPG</p>
															<p><b>Ancho: </b>1200</p>
															<p><b>Altura: </b>1200</p>
															<p><b>Tamaño máximo (Kb): </b>600</p>
															<input type="file" name="nombre_imagen_avatar" id="nombre_imagen_avatar" placeholder="Miniatura" value="<?php echo set_value('nombre_imagen_avatar') == false ? 'default.jpg' : set_value('nombre_imagen_avatar'); ?>" onchange="cargar_imagen(event)">
														</div>
                                        		    </div>
                                        		</div>

												<h4 class="form-section">Datos de contacto</h4>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group row">
															<label for="nombre_completo" class="col-md-3 label-control"><span class="red">*</span> Nombre completo</label>
															<div class="col-md-9">
																<input type="text" name="nombre_completo" class="form-control" placeholder="Nombre Completo" value="<?php echo $usuario_en_sesion->nombre_completo; ?>">
															</div>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group row">
															<label for="apellido_paterno" class="col-md-3 label-control"><span class="red">*</span> Apellido paterno</label>
															<div class="col-md-9">
																<input type="text" name="apellido_paterno" class="form-control" placeholder="Apellido Paterno" value="<?php echo $usuario_en_sesion->apellido_paterno; ?>">
															</div>
														</div>
													</div>
												</div>

												<div class="row">

													<div class="col-md-6">
														<div class="form-group row">
															<label for="apellido_materno" class="col-md-3 label-control">Apellido materno</label>
															<div class="col-md-9">
																<input type="text" name="apellido_materno" class="form-control" placeholder="Apellido Materno" value="<?php echo $usuario_en_sesion->apellido_materno; ?>">
															</div>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group row">
															<label for="no_telefono" class="col-md-3 label-control">Télefono</label>
															<div class="col-md-5">
																<input autocomplete="off" type="text" class="form-control tel-inputmask" name="no_telefono" placeholder="No. de Teléfono"
																 value="<?php echo $usuario_en_sesion->no_telefono; ?>">
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
																<input type="text" name="fecha_nacimiento" class="date-dropper form-control" placeholder="Seleccione una fecha"
																 value="<?php echo date('d/m/Y', strtotime($usuario_en_sesion->fecha_nacimiento)); ?>">
															</div>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group row">
															<label for="rfc" class="col-md-3 label-control">RFC</label>
															<div class="col-md-9">
																<input type="text" name="rfc" class="form-control" placeholder="RFC" value="<?php echo $usuario_en_sesion->rfc; ?>">
															</div>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group row">
															<label for="genero" class="col-md-3 label-control">Género</label>
															<div class="col-md-4">
																<select name="genero" class="form-control">
																	<option>Seleccione su genero</option>
																	<option value="H" <?php echo $usuario_en_sesion->genero == 'H' ? 'selected' : ''; ?>>Hombre</option>
																	<option value="M" <?php echo $usuario_en_sesion->genero == 'M' ? 'selected' : ''; ?>>Mujer</option>
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
																<input type="text" name="pais" class="form-control" placeholder="País" value="<?php echo $usuario_en_sesion->pais; ?>">
															</div>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group row">
															<label for="estado" class="col-md-3 label-control">Estado</label>
															<div class="col-md-9">
																<input type="text" name="estado" class="form-control" placeholder="Estado" value="<?php echo $usuario_en_sesion->estado; ?>">
															</div>
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-md-6">
														<div class="form-group row">
															<label for="ciudad" class="col-md-3 label-control">Ciudad</label>
															<div class="col-md-9">
																<input type="text" name="ciudad" class="form-control" placeholder="Ciudad" value="<?php echo $usuario_en_sesion->ciudad; ?>">
															</div>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group row">
															<label for="colonia" class="col-md-3 label-control">Colonia</label>
															<div class="col-md-9">
																<input type="text" name="colonia" class="form-control" placeholder="Colonia" value="<?php echo $usuario_en_sesion->colonia; ?>">
															</div>
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-md-6">
														<div class="form-group row">
															<label for="calle" class="col-md-3 label-control">Calle</label>
															<div class="col-md-9">
																<input type="text" name="calle" class="form-control" placeholder="Calle" value="<?php echo $usuario_en_sesion->calle; ?>">
															</div>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group row">
															<label for="numero" class="col-md-3 label-control">Número</label>
															<div class="col-md-3">
																<input type="text" name="numero" class="form-control" placeholder="Número" value="<?php echo $usuario_en_sesion->numero; ?>">
															</div>
														</div>
													</div>
												</div>

												<div class="form-actions right">
													<button type="submit" class="btn btn-secondary btn-sm">Guardar</button>
												</div>

											</div>

											<?php echo form_close(); ?>
										</div>
										<div class="tab-pane <?php echo $pill_seleccionado == 2 ? 'active show' : ''; ?>" id="pillEle12"
										 aria-labelledby="base-pillEle12" aria-expanded="<?php echo $pill_seleccionado == 2 ? 'true' : 'false'; ?>">
											<br>
											<fieldset class="form-group col-4 p-0">
												<div class="custom-file">
													<input type="file" class="custom-file-input" id="img-perfil" accept="image/*">
													<label class="custom-file-label" for="img-perfil">Seleccione una imagen</label>
												</div>
											</fieldset>
											<br>
											<div id="contenedor-cropper">
												<img id="img-perfil-cropper" src="<?php echo base_url(); ?>/subidas/perfil/<?php echo $this->session->userdata['nombre_imagen_avatar']; ?>"
												 alt="Picture">
											</div>
											<br>
											<div class="form-actions right">
												<button id="subir-imagen" class="btn btn-secondary btn-sm">Subir</button>
											</div>
										</div>
										<div class="tab-pane <?php echo $pill_seleccionado == 3 ? 'active show' : ''; ?>" id="pillEle13"
										 aria-labelledby="base-pillEle13" aria-expanded="<?php echo $pill_seleccionado == 3 ? 'true' : 'false'; ?>">
											<br>
											<br>
											<?php echo form_open('usuarios/cambiar_contrasena', array('class' => 'form form-horizontal', 'id' => 'forma-cambiar-contrasena')); ?>

											<div class="form-body">
												<div class="row">
													<div class="col-md-6">
														<div class="form-group row">
															<label for="correo" class="col-md-3 label-control"><span class="red">*</span> Contraseña actual</label>
															<div class="col-md-9">
																<input type="password" name="contrasena_actual" class="form-control" placeholder="Contraseña actual">
															</div>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group row">
															<label for="correo" class="col-md-3 label-control"><span class="red">*</span> Contraseña nueva</label>
															<div class="col-md-9">
																<input type="password" id="contrasena_nueva" name="contrasena_nueva" class="form-control" placeholder="Contraseña nueva">
															</div>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group row">
															<label for="correo" class="col-md-3 label-control"><span class="red">*</span> Confirmar contrasena nueva</label>
															<div class="col-md-9">
																<input type="password" name="confirmar_contrasena" class="form-control" placeholder="Confirmar contrasena">
															</div>
														</div>
													</div>
												</div>

												<div class="form-actions right">
													<button type="submit" class="btn btn-secondary btn-sm">Guardar</button>
												</div>

											</div>

											<?php echo form_close(); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<br>
				<br>
				<br>
			</div>
		</div>
	</div>
</div>
<!--<br><a class="btn btn-blue btn-sm">Cambiar contraseña</a>-->
<!--div>
	<ul>
		<li class="nav-item">
			<a class="nav-link <?php //echo $pill_seleccionado == 1 ? 'active' : ''; ?>" id="base-pillEle11" data-toggle="pill"
				href="#pillEle11" aria-expanded="<?php //echo $pill_seleccionado == 1 ? 'true' : 'false'; ?>">
				Datos personales <i class="ml-1 fa fa-user"></i>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link <?php //echo $pill_seleccionado == 3 ? 'active' : ''; ?>" id="base-pillEle13" data-toggle="pill"
				href="#pillEle13" aria-expanded="<?php //echo $pill_seleccionado == 3 ? 'true' : 'false'; ?>">
				Cambiar contraseña <i class="ml-1 fa fa-lock"></i>
			</a>
		</li>

	</ul>
</div-->