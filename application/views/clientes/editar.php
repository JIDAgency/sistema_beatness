<div class="app-content content center-layout mt-2">
	<div class="content-wrapper">
		<!-- ============================================================
             BARRA DE NAVEGACIÓN Y BREADCRUMB
        ============================================================= -->
		<div class="content-header row">
			<div class="content-header-left col-md-6 col-12 mb-2">
				<div class="row breadcrumbs-top">
					<div class="breadcrumb-wrapper col-12">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php echo site_url('inicio/index') ?>">Inicio</a></li>
							<li class="breadcrumb-item"><a href="<?php echo site_url('clientes/index') ?>">Clientes</a></li>
							<li class="breadcrumb-item active">Editar cliente</li>
						</ol>
					</div>
				</div>
			</div>
		</div>

		<!-- ============================================================
             CONTENIDO PRINCIPAL
        ============================================================= -->
		<div class="content-body">
			<section>
				<div class="row">
					<div class="col-12">

						<!-- Aplicar la clase no-border a la tarjeta -->
						<div class="card no-border">
							<div class="card-header">
								<h4 class="card-title">Editar cliente</h4>
							</div>

							<div class="card-content">
								<div class="card-body">
									<?php echo form_open_multipart(site_url('clientes/editar'), array('class' => 'needs-validation p-2', 'id' => 'forma-editar-cliente', 'method' => 'post')); ?>
									<input type="hidden" name="id" value="<?php echo $cliente_a_editar->id; ?>">

									<?php $this->load->view('_templates/mensajes_alerta.tpl.php'); ?>

									<div class="row">
										<!-- ============================================================
                                             COLUMNA IZQUIERDA: CAMPOS PRINCIPALES
                                        ============================================================= -->
										<div class="col-lg-8 col-md-12 col-sm-12">

											<!-- Datos de acceso -->
											<h5 class="mb-2">Datos de acceso</h5>
											<div class="form-group row">
												<label for="correo" class="col-md-3 label-control">
													<span class="red">*</span> Email
												</label>
												<div class="col-md-9">
													<input type="email" name="correo" id="correo" class="form-control" placeholder="Correo electrónico" value="<?php echo set_value('correo', $cliente_a_editar->correo); ?>" onkeyup="this.value = this.value.toLowerCase()">
												</div>
											</div>

											<!-- Datos personales básicos -->
											<h5 class="mt-3 mb-2">Datos personales</h5>
											<div class="form-group row">
												<label for="nombre_completo" class="col-md-3 label-control">
													<span class="red">*</span> Nombre(s)
												</label>
												<div class="col-md-9">
													<input type="text" name="nombre_completo" class="form-control" placeholder="Nombre(s)" value="<?php echo set_value('nombre_completo', $cliente_a_editar->nombre_completo); ?>">
												</div>
											</div>
											<div class="form-group row">
												<label for="apellido_paterno" class="col-md-3 label-control">
													<span class="red">*</span> Apellido paterno
												</label>
												<div class="col-md-9">
													<input type="text" name="apellido_paterno" class="form-control" placeholder="Apellido paterno" value="<?php echo set_value('apellido_paterno', $cliente_a_editar->apellido_paterno); ?>">
												</div>
											</div>
											<div class="form-group row">
												<label for="apellido_materno" class="col-md-3 label-control">Apellido materno</label>
												<div class="col-md-9">
													<input type="text" name="apellido_materno" class="form-control" placeholder="Apellido materno" value="<?php echo set_value('apellido_materno', $cliente_a_editar->apellido_materno); ?>">
												</div>
											</div>
											<div class="form-group row">
												<label for="no_telefono" class="col-md-3 label-control">Teléfono</label>
												<div class="col-md-9">
													<input type="text" name="no_telefono" class="form-control" placeholder="Número de teléfono" maxlength="10" value="<?php echo set_value('no_telefono', $cliente_a_editar->no_telefono); ?>">
												</div>
											</div>

											<!-- Datos académicos/empresariales y sucursal -->
											<h5 class="mt-3 mb-2">Información adicional</h5>
											<div class="form-group row">
												<label class="col-md-3 label-control" for="es_estudiante">
													¿Es estudiante? <span class="red">*</span>
												</label>
												<div class="col-md-9">
													<select id="es_estudiante" name="es_estudiante" class="form-control select2" required>
														<option value="">Seleccione…</option>
														<?php
														$valor_es_estudiante = set_value('es_estudiante', $cliente_a_editar->es_estudiante);
														foreach (select_es_estudiante() as $est) : ?>
															<option value="<?php echo $est->valor; ?>" <?php echo ($est->valor == $valor_es_estudiante) ? 'selected' : ''; ?>>
																<?php echo trim($est->nombre); ?>
															</option>
														<?php endforeach; ?>
													</select>
													<div class="invalid-feedback">Seleccione una opción</div>
												</div>
											</div>
											<div class="form-group row" id="vigencia_estudiante_row" style="display: none;">
												<label class="col-md-3 label-control" for="es_estudiante_vigencia">
													Vigencia estudiante <span class="red">*</span>
												</label>
												<div class="col-md-9">
													<input type="date" id="es_estudiante_vigencia" name="es_estudiante_vigencia" class="form-control" value="<?php echo set_value('es_estudiante_vigencia', date('Y-m-d', strtotime($cliente_a_editar->es_estudiante_vigencia))); ?>">
													<div class="invalid-feedback">Seleccione una fecha</div>
												</div>
											</div>

											<div class="form-group row">
												<label class="col-md-3 label-control" for="es_empresarial">
													¿Pertenece a una empresa? <span class="red">*</span>
												</label>
												<div class="col-md-9">
													<select id="es_empresarial" name="es_empresarial" class="form-control select2" required>
														<option value="">Seleccione…</option>
														<?php
														$valor_es_empresarial = set_value('es_empresarial', $cliente_a_editar->es_empresarial);
														foreach (select_es_empresarial() as $emp) : ?>
															<option value="<?php echo $emp->valor; ?>" <?php echo ($emp->valor == $valor_es_empresarial) ? 'selected' : ''; ?>>
																<?php echo trim($emp->nombre); ?>
															</option>
														<?php endforeach; ?>
													</select>
													<div class="invalid-feedback">Seleccione una opción</div>
												</div>
											</div>

											<div class="form-group row">
												<label class="col-md-3 label-control" for="sucursal_id">
													Sucursal favorita <span class="red">*</span>
												</label>
												<div class="col-md-9">
													<select id="sucursal_id" name="sucursal_id" class="form-control select2" required>
														<option value="">Seleccione una sucursal…</option>
														<?php
														$valor_sucursal = set_value('sucursal_id', $cliente_a_editar->sucursal_id);
														foreach ($sucursal_list as $s_row) : ?>
															<option value="<?php echo $s_row->id; ?>" <?php echo ($s_row->id == $valor_sucursal) ? 'selected' : ''; ?>>
																<?php echo trim($s_row->descripcion); ?>
															</option>
														<?php endforeach; ?>
													</select>
													<div class="invalid-feedback">Seleccione una opción</div>
												</div>
											</div>

											<!-- Datos complementarios -->
											<h5 class="mt-3 mb-2">Datos complementarios</h5>
											<div class="form-group row">
												<label for="fecha_nacimiento" class="col-md-3 label-control">
													Fecha nacimiento
												</label>
												<div class="col-md-9">
													<input type="date" name="fecha_nacimiento" class="form-control" placeholder="Seleccione una fecha" value="<?php echo set_value('fecha_nacimiento', date('Y-m-d', strtotime($cliente_a_editar->fecha_nacimiento))); ?>">
												</div>
											</div>
											<div class="form-group row">
												<label for="rfc" class="col-md-3 label-control">RFC</label>
												<div class="col-md-9">
													<input type="text" name="rfc" class="form-control" placeholder="RFC" value="<?php echo set_value('rfc', $cliente_a_editar->rfc); ?>">
												</div>
											</div>
											<div class="form-group row">
												<label for="genero" class="col-md-3 label-control">Género</label>
												<div class="col-md-9">
													<select name="genero" class="form-control">
														<option value="">Seleccione…</option>
														<option value="H" <?php echo set_select('genero', 'H', 'H' == $cliente_a_editar->genero); ?>>Hombre</option>
														<option value="M" <?php echo set_select('genero', 'M', 'M' == $cliente_a_editar->genero); ?>>Mujer</option>
													</select>
												</div>
											</div>

											<!-- Domicilio -->
											<h5 class="mt-3 mb-2">Domicilio</h5>
											<div class="form-group row">
												<label for="pais" class="col-md-3 label-control">País</label>
												<div class="col-md-9">
													<input type="text" name="pais" class="form-control" placeholder="País" value="<?php echo set_value('pais', $cliente_a_editar->pais); ?>">
												</div>
											</div>
											<div class="form-group row">
												<label for="estado" class="col-md-3 label-control">Estado</label>
												<div class="col-md-9">
													<input type="text" name="estado" class="form-control" placeholder="Estado" value="<?php echo set_value('estado', $cliente_a_editar->estado); ?>">
												</div>
											</div>
											<div class="form-group row">
												<label for="ciudad" class="col-md-3 label-control">Ciudad</label>
												<div class="col-md-9">
													<input type="text" name="ciudad" class="form-control" placeholder="Ciudad" value="<?php echo set_value('ciudad', $cliente_a_editar->ciudad); ?>">
												</div>
											</div>
											<div class="form-group row">
												<label for="colonia" class="col-md-3 label-control">Colonia</label>
												<div class="col-md-9">
													<input type="text" name="colonia" class="form-control" placeholder="Colonia" value="<?php echo set_value('colonia', $cliente_a_editar->colonia); ?>">
												</div>
											</div>
											<div class="form-group row">
												<label for="calle" class="col-md-3 label-control">Calle</label>
												<div class="col-md-9">
													<input type="text" name="calle" class="form-control" placeholder="Calle" value="<?php echo set_value('calle', $cliente_a_editar->calle); ?>">
												</div>
											</div>
											<div class="form-group row">
												<label for="numero" class="col-md-3 label-control">Número</label>
												<div class="col-md-9">
													<input type="text" name="numero" class="form-control" placeholder="Número" value="<?php echo set_value('numero', $cliente_a_editar->numero); ?>">
												</div>
											</div>

											<h5 class="mt-3 mb-2">Estatus</h5>
											<div class="form-group row">
												<label for="estatus" class="col-md-3 label-control">Estatus</label>
												<div class="col-md-9">
													<select id="estatus" name="estatus" class="form-control" required>
														<option value="">Seleccione un estatus...</option>
														<option value="activo" <?php echo set_select('estatus', 'activo', 'activo' == $cliente_a_editar->estatus); ?>>Activo</option>
														<option value="suspendido" <?php echo set_select('estatus', 'suspendido', 'suspendido' == $cliente_a_editar->estatus); ?>>Suspendido</option>
													</select>
												</div>
											</div>
										</div>

										<!-- ============================================================
                                             COLUMNA DERECHA: FOTO
                                        ============================================================= -->
										<div class="col-lg-4 col-md-12 col-sm-12">
											<h5 class="mb-2">Foto del cliente</h5>
											<div class="mb-2 text-center">
												<img src="<?php echo site_url("subidas/perfil/" . $cliente_a_editar->nombre_imagen_avatar); ?>" name="preview" id="preview" style="width: 200px; height: 200px;">
											</div>
											<p><b>Formato:</b> JPG</p>
											<p><b>Tamaño máximo (Kb):</b> 600</p>
											<input type="file" name="nombre_imagen_avatar" id="nombre_imagen_avatar" onchange="cargar_imagen(event)" value="<?php echo set_value('nombre_imagen_avatar', $cliente_a_editar->nombre_imagen_avatar); ?>">

										</div>
									</div>

									<!-- BOTONES DE ACCIÓN -->
									<div class="form-actions right mt-2">
										<a href="<?php echo site_url('clientes/index'); ?>" class="btn btn-outline-secondary">
											<i class="ft-arrow-left icon-left"></i> Atrás
										</a>
										<button id="guardar-btn" type="submit" class="btn btn-outline-secondary">
											<i class="ft-save icon-left"></i> Guardar
										</button>
									</div>

									<?php echo form_close(); ?>

									<!-- El script de la cámara y las validaciones se deben mover a un archivo JS externo, 
                                         siguiendo el estándar aplicado en 'crear'.
                                         Incluir aquí únicamente las variables globales o definiciones necesarias -->
								</div>
							</div>
						</div> <!-- fin card no-border -->
					</div>
				</div>
			</section>
		</div>
	</div>
</div>