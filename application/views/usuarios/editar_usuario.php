<div class="app-content content center-layout mt-2">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
				<div class="row breadcrumbs-top">
					<div class="breadcrumb-wrapper col-12">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php echo site_url('inicio/index') ?>">Inicio</a>
							</li>
							<li class="breadcrumb-item"><a href="<?php echo site_url('usuarios/index') ?>">Administradores</a>
							</li>
							<li class="breadcrumb-item active">Editar administrador
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
								<h4 class="card-title">Editar administrador</h4>
							</div>
							<div class="card-content">
								<div class="card-body">
									<?php echo form_open_multipart(site_url('usuarios/editar_usuario'), array('class' => 'form form-horizontal', 'id' => 'forma-editar-usuario', 'method' => 'post')); ?>
									<input type="hidden" name="id" value="<?php echo $usuario_a_editar->id; ?>">
									<div class="form-body">
									<?php $this->load->view('_templates/mensajes_alerta.tpl.php'); ?>

										<h4 class="form-section">Foto</h4>
                                        <div class="row">
                                            <div class="col-sm-3">
												<img src="<?php echo site_url("subidas/perfil/".$usuario_a_editar->nombre_imagen_avatar); ?>" name="preview" id="preview" style="width: 200px; height: 200px;">
                                            </div>
											<div class="col-sm-9">
												<p><b>Formato: </b>JPG</p>
												<p><b>Ancho: </b>1200</p>
												<p><b>Altura: </b>1200</p>
												<p><b>Tamaño máximo (Kb): </b>600</p>
												<input type="file" name="nombre_imagen_avatar" id="nombre_imagen_avatar" placeholder="Miniatura" value="<?php echo set_value('nombre_imagen_avatar') == false ? $usuario_a_editar->nombre_imagen_avatar : set_value('nombre_imagen_avatar'); ?>" onchange="cargar_imagen(event)">
											</div>
                                        </div>

										<h4 class="form-section">Datos de acceso</h4>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group row">
													<label for="correo" class="col-md-3 label-control"><span class="red">*</span> Email</label>
													<div class="col-md-9">
														<input type="email" name="correo" id="correo" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toLowerCase()" class="form-control" placeholder="Correo Electrónico" value="<?php echo set_value('correo') == false ? $usuario_a_editar->correo : set_value('correo'); ?>">
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group row">
													<label for="rol_id" class="col-md-3 label-control"><span class="red">*</span> Rol</label>
													<div class="col-md-7">
														<select name="rol_id" class="form-control">
															<option value="">Seleccione el tipo de rol</option>
															<?php foreach ($roles as $rol): ?>
															<option value="<?php echo $rol->id; ?>" <?php echo set_select('rol_id', $rol->id,
																set_value('rol_id') ? false : $rol->id == $usuario_a_editar->rol_id); ?>>
																<?php echo $rol->tipo; ?>
															</option>
															<?php endforeach;?>
														</select>
													</div>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-6">
												<div class="form-group row">
													<label for="sucursal_id" class="col-md-3 label-control"><span class="red">*</span> Sucursal (Solo FrontDesk)</label>
													<div class="col-md-7">
														<select name="sucursal_id" class="form-control">
															<option value="">Seleccione la sucursal asignada</option>
															<?php foreach ($sucursales as $sucursal): ?>
															<option value="<?php echo $sucursal->id; ?>" <?php echo set_select('sucursal_id', $sucursal->id,
																set_value('sucursal_id') ? false : $sucursal->id == $usuario_a_editar->sucursal_id); ?>>
																<?php echo $sucursal->locacion; ?>
															</option>
															<?php endforeach;?>
														</select>
													</div>
												</div>
											</div>
										</div>

										<h4 class="form-section">Datos de contacto</h4>
										<div class="row">

											<div class="col-md-6">
												<div class="form-group row">
													<label for="nombre_completo" class="col-md-3 label-control"><span class="red">*</span> Nombre completo</label>
													<div class="col-md-9">
														<input type="text" name="nombre_completo" class="form-control" placeholder="Nombre Completo" value="<?php echo set_value('nombre_completo') == false ? $usuario_a_editar->nombre_completo : set_value('nombre_completo'); ?>">
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group row">
													<label for="apellido_paterno" class="col-md-3 label-control"><span class="red">*</span> Apellido paterno</label>
													<div class="col-md-9">
														<input type="text" name="apellido_paterno" class="form-control" placeholder="Apellido Paterno" value="<?php echo set_value('apellido_paterno') == false ? $usuario_a_editar->apellido_paterno : set_value('apellido_paterno'); ?>">
													</div>
												</div>
											</div>
										</div>
										<div class="row">

											<div class="col-md-6">
												<div class="form-group row">
													<label for="apellido_materno" class="col-md-3 label-control">Apellido materno</label>
													<div class="col-md-9">
														<input type="text" name="apellido_materno" class="form-control" placeholder="Apellido Materno" value="<?php echo set_value('apellido_materno') == false ? $usuario_a_editar->apellido_materno : set_value('apellido_materno'); ?>">
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group row">
													<label for="no_telefono" class="col-md-3 label-control">Télefono</label>
													<div class="col-md-5">
														<input autocomplete="off" type="text" class="form-control tel-inputmask" name="no_telefono" placeholder="No. de Teléfono"
														 value="<?php echo set_value('no_telefono') == false ? $usuario_a_editar->no_telefono : set_value('no_telefono'); ?>">
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
														 value="<?php echo set_value('fecha_nacimiento') == false ? date('d/m/Y', strtotime($usuario_a_editar->fecha_nacimiento)) : date('d/m/Y', strtotime(set_value('fecha_nacimiento'))); ?>">
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group row">
													<label for="rfc" class="col-md-3 label-control">RFC</label>
													<div class="col-md-9">
														<input type="text" name="rfc" class="form-control" placeholder="RFC" value="<?php echo set_value('rfc') == false ? $usuario_a_editar->rfc : set_value('rfc'); ?>">
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
															<option value="H" <?php echo set_select('genero', "H" , set_value('genero') ? false : "H"==$usuario_a_editar->genero);
																?>>Hombre</option>
															<option value="M" <?php echo set_select('genero', "M" , set_value('genero') ? false : "M"==$usuario_a_editar->genero);
																?>>Mujer</option>
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
														<input type="text" name="pais" class="form-control" placeholder="País" value="<?php echo set_value('pais') == false ? $usuario_a_editar->pais : set_value('pais'); ?>">
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group row">
													<label for="estado" class="col-md-3 label-control">Estado</label>
													<div class="col-md-8">
														<input type="text" name="estado" class="form-control" placeholder="Estado" value="<?php echo set_value('estado') == false ? $usuario_a_editar->estado : set_value('estado'); ?>">
													</div>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-6">
												<div class="form-group row">
													<label for="ciudad" class="col-md-3 label-control">Ciudad</label>
													<div class="col-md-9">
														<input type="text" name="ciudad" class="form-control" placeholder="Ciudad" value="<?php echo set_value('ciudad') == false ? $usuario_a_editar->ciudad : set_value('colonia'); ?>">
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group row">
													<label for="colonia" class="col-md-3 label-control">Colonia</label>
													<div class="col-md-9">
														<input type="text" name="colonia" class="form-control" placeholder="Colonia" value="<?php echo set_value('colonia') == false ? $usuario_a_editar->colonia : set_value('colonia'); ?>">
													</div>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-6">
												<div class="form-group row">
													<label for="calle" class="col-md-3 label-control">Calle</label>
													<div class="col-md-9">
														<input type="text" name="calle" class="form-control" placeholder="Calle" value="<?php echo set_value('calle') == false ? $usuario_a_editar->calle : set_value('calle'); ?>">
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group row">
													<label for="numero" class="col-md-3 label-control">Número</label>
													<div class="col-md-3">
														<input type="text" name="numero" class="form-control" placeholder="Número" value="<?php echo set_value('numero') == false ? $usuario_a_editar->numero : set_value('numero'); ?>">
													</div>
												</div>
											</div>
										</div>

										<div class="form-actions right">
											<a href="<?php echo site_url('usuarios/index'); ?>" class="btn btn-secondary btn-sm">Cancelar</a>
											<button type="submit" class="btn btn-secondary btn-sm">Guardar</button>
										</div>

									</div>

									<?php echo form_close(); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</div>
