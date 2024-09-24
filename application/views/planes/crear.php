<div class="app-content container center-layout mt-2">
	<div class="content-header-left col-md-6 col-12 mb-2">
		<div class="row breadcrumbs-top">
			<div class="breadcrumb-wrapper col-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo site_url('inicio/index') ?>">Inicio</a>
					</li>
					<li class="breadcrumb-item"><a href="<?php echo site_url('planes/index') ?>">Planes</a>
					</li>
					<li class="breadcrumb-item active">Crear nuevo plan
					</li>
				</ol>
			</div>
		</div>
	</div>
	<div class="content-wrapper">
		<div class="content-body">
			<section>
				<div class="row">
					<div class="col-12">
						<div class="card no-border">
							<div class="card-header">
								<h4 class="card-title">Nuevo plan</h4>
							</div>
							<div class="card-content">
								<div class="card-body">
									<?php echo form_open_multipart('planes/crear', array('class' => 'form form-horizontal', 'id' => 'forma-crear-plan')); ?>
									<div class="form-body">

										<?php if (validation_errors()) : ?>
											<div class="alert bg-danger alert-icon-left alert-dismissible mb-2 font-small-3" role="alert">
												<span class="alert-icon"><i class="fa fa-thumbs-o-down"></i></span>
												<button type="button" class="close" data-dismiss="alert" aria-label="Close">
													<span aria-hidden="true">×</span>
												</button>
												<?php echo validation_errors(); ?>
											</div>
										<?php endif ?>

										<h4 class="form-section">Datos del plan</h4>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group row">
													<label for="nombre" class="col-md-12">Nombre&nbsp;<span class="red">*</span></label>
													<div class="col-md-12">
														<input type="text" class="form-control" name="nombre" placeholder="Nombre" value="<?php echo set_value('nombre'); ?>">
													</div>
												</div>
												<div class="form-group row">
													<label for="tipo" class="col-md-12">SKU&nbsp;<span class="red">*</span></label>
													<div class="col-md-12">
														<input type="text" name="sku" class="form-control" placeholder="SKU" value="<?php echo set_value('sku'); ?>">
													</div>
												</div>
												<div class="form-group row">
													<label for="clases_incluidas" class="col-md-12">Clases incluidas&nbsp;<span class="red">*</span></label>
													<div class="col-md-12">
														<input type="text" name="clases_incluidas" class="form-control" placeholder="Clases incluidas" value="<?php echo set_value('clases_incluidas'); ?>">
													</div>
												</div>
												<div class="form-group row">
													<label for="tipo" class="col-md-12">Vigencia en días&nbsp;<span class="red">*</span></label>
													<div class="col-md-12">
														<input type="text" name="vigencia_en_dias" class="form-control" placeholder="Vigencia en días" value="<?php echo set_value('vigencia_en_dias'); ?>">
													</div>
												</div>
												<div class="form-group row">
													<label for="costo" class="col-md-12">Costo&nbsp;<span class="red">*</span></label>
													<div class="col-md-12">
														<input type="text" class="form-control" name="costo" placeholder="Costo" value="<?php echo set_value('costo'); ?>">
													</div>
												</div>
												<div class="form-group row">
													<label for="orden_venta" class="col-md-12">Orden de venta&nbsp;<span class="red">*</span></label>
													<label for="orden_venta" class="col-md-12"><small class="text-muted"><em>(Ordenar del 1 al …, el 5 es la posición normal de venta)</em></small></label>
													<div class="col-md-12">
														<input type="number" class="form-control" name="orden_venta" placeholder="Orden" value="<?php echo set_value('orden_venta') == false ? 5 : set_value('orden_venta'); ?>">
													</div>
												</div>
												<div class="form-group">
													<label for="ilimitado">Es ilimitado <span class="red">*</span></label>
													<select name="ilimitado" id="ilimitado" class="form-control">
														<option value="" <?php echo set_select('es_ilimitado', '', set_value('es_ilimitado') ? false : '' == $this->session->flashdata('es_ilimitado')); ?>>Seleccione una opcion…</option>
														<?php foreach (select_mostrar() as $mostrar_key => $mostrar_row) : ?>
															<option value="<?php echo $mostrar_row->valor; ?>" <?php echo $mostrar_row->activo == false ? '' : 'selected'; ?> <?php echo set_select('es_ilimitado', $mostrar_row->valor, set_value('es_ilimitado') ? false : $mostrar_row->valor == $this->session->flashdata('es_ilimitado')); ?>><?php echo trim($mostrar_row->nombre); ?></option>
														<?php endforeach; ?>
													</select>
												</div>

												<div class="form-group">
													<label for="es_primera">Es primera <span class="red">*</span></label>
													<select name="es_primera" id="es_primera" class="form-control">
														<option value="" <?php echo set_select('es_primera', '', set_value('es_primera') ? false : '' == $this->session->flashdata('es_primera')); ?>>Seleccione una opcion…</option>
														<?php foreach (select_mostrar() as $mostrar_key => $mostrar_row) : ?>
															<option value="<?php echo $mostrar_row->valor; ?>" <?php echo $mostrar_row->activo == false ? '' : 'selected'; ?> <?php echo set_select('es_primera', $mostrar_row->valor, set_value('es_primera') ? false : $mostrar_row->valor == $this->session->flashdata('es_primera')); ?>><?php echo trim($mostrar_row->nombre); ?></option>
														<?php endforeach; ?>
													</select>
												</div>

												<div class="form-group">
													<label for="es_estudiante">Es estudiante <span class="red">*</span></label>
													<select name="es_estudiante" id="es_estudiante" class="form-control">
														<option value="" <?php echo set_select('es_estudiante', '', set_value('es_estudiante') ? false : '' == $this->session->flashdata('es_estudiante')); ?>>Seleccione una opcion…</option>
														<?php foreach (select_mostrar() as $mostrar_key => $mostrar_row) : ?>
															<option value="<?php echo $mostrar_row->valor; ?>" <?php echo $mostrar_row->activo == false ? '' : 'selected'; ?> <?php echo set_select('es_estudiante', $mostrar_row->valor, set_value('es_estudiante') ? false : $mostrar_row->valor == $this->session->flashdata('es_estudiante')); ?>><?php echo trim($mostrar_row->nombre); ?></option>
														<?php endforeach; ?>
													</select>
												</div>

												<div class="form-group">
													<label for="es_empresarial">¿Pertenece a una empresa? <span class="red">*</span></label>
													<select name="es_empresarial" id="es_empresarial" class="form-control">
														<option value="" <?php echo set_select('es_empresarial', '', set_value('es_empresarial') ? false : '' == $this->session->flashdata('es_empresarial')); ?>>Seleccione una opcion…</option>
														<?php foreach (select_es_empresarial() as $mostrar_key => $mostrar_row) : ?>
															<option value="<?php echo $mostrar_row->valor; ?>" <?php echo $mostrar_row->activo == false ? '' : 'selected'; ?> <?php echo set_select('es_empresarial', $mostrar_row->valor, set_value('es_empresarial') ? false : $mostrar_row->valor == $this->session->flashdata('es_empresarial')); ?>><?php echo trim($mostrar_row->nombre); ?></option>
														<?php endforeach; ?>
													</select>
												</div>

												<div class="form-group">
													<label for="pagar_en">Pagar en: <span class="red">*</span></label>
													<select name="pagar_en" id="pagar_en" class="form-control">
														<option value="" <?php echo set_select('pagar_en', '', set_value('pagar_en') ? false : '' == $this->session->flashdata('pagar_en')); ?>>Seleccione una opcion…</option>
														<?php foreach (select_pagar_en() as $mostrar_key => $mostrar_row) : ?>
															<option value="<?php echo $mostrar_row->valor; ?>" <?php echo $mostrar_row->activo == false ? '' : 'selected'; ?> <?php echo set_select('pagar_en', $mostrar_row->valor, set_value('pagar_en') ? false : $mostrar_row->valor == $this->session->flashdata('pagar_en')); ?>><?php echo trim($mostrar_row->nombre); ?></option>
														<?php endforeach; ?>
													</select>
												</div>

												<div class="form-group row" id="urlPago" style="display: none;">
													<label for="tipo" class="col-md-12">url de pago <span class="red">*</span></label>
													<div class="col-md-12">
														<input type="text" name="url_pago" class="form-control" placeholder="url de pago" value="<?php echo set_value('url_pago'); ?>">
													</div>
												</div>

												<div class="form-group">
													<label for="mostrar_en_app">Mostrar en APP <span class="red">*</span></label>
													<select name="mostrar_en_app" id="mostrar_en_app" class="form-control">
														<option value="" <?php echo set_select('mostrar_en_app', '', set_value('mostrar_en_app') ? false : '' == $this->session->flashdata('mostrar_en_app')); ?>>Seleccione una opcion…</option>
														<?php foreach (select_activo() as $mostrar_key => $mostrar_row) : ?>
															<option value="<?php echo $mostrar_row->valor; ?>" <?php echo $mostrar_row->activo == false ? '' : 'selected'; ?> <?php echo set_select('mostrar_en_app', $mostrar_row->valor, set_value('mostrar_en_app') ? false : $mostrar_row->valor == $this->session->flashdata('mostrar_en_app')); ?>><?php echo trim($mostrar_row->nombre); ?></option>
														<?php endforeach; ?>
													</select>
												</div>

												<div class="form-group">
													<label for="activado">Activado <span class="red">*</span></label>
													<select name="activado" id="activado" class="form-control">
														<option value="" <?php echo set_select('activado', '', set_value('activado') ? false : '' == $this->session->flashdata('activado')); ?>>Seleccione una opcion…</option>
														<?php foreach (select_activo() as $mostrar_key => $mostrar_row) : ?>
															<option value="<?php echo $mostrar_row->valor; ?>" <?php echo $mostrar_row->activo == false ? '' : 'selected'; ?> <?php echo set_select('activado', $mostrar_row->valor, set_value('activado') ? false : $mostrar_row->valor == $this->session->flashdata('activado')); ?>><?php echo trim($mostrar_row->nombre); ?></option>
														<?php endforeach; ?>
													</select>
												</div>
												<div class="form-group">
													<div class="row">
														<label class="col-lg-12">Vincular a código</label>
														<div class="col-lg-12">
															<select id="codigo" name="codigo" class="form-control select2-disciplinas custom-select">
																<option value="" <?php echo set_select('codigo', '', set_value('codigo') ? false : '' == $this->session->flashdata('codigo')); ?>>Seleccione un código</option>
																<?php foreach ($codigos_list->result() as $key => $codigo_row) : ?>
																	<option value="<?php echo $codigo_row->codigo; ?>" <?php echo set_select('codigo', $codigo_row->codigo, set_value('codigo') ? false : $codigo_row->codigo == $this->session->flashdata('codigo')); ?>><?php echo trim(mb_strtoupper($codigo_row->codigo)); ?></option>
																<?php endforeach; ?>
															</select>
															<div class="invalid-feedback">
																Se requiere un código válido.
															</div>
														</div>
													</div>
												</div>
												<div class="form-group row">
													<label for="disciplinas" class="col-md-12">Seleccione las disciplinas</label>
													<div class="col-md-12">
														<select class="select2-disciplinas form-control" name="disciplinas[]" multiple readonly>
															<?php foreach ($disciplinas as $disciplina) : ?>
																<?php if ($disciplina->id != 1) : ?>
																	<option value="<?php echo $disciplina->id; ?>">
																		<?php echo $disciplina->nombre; ?>
																	</option>
																<?php endif; ?>
															<?php endforeach; ?>
														</select>
													</div>
												</div>

												<div class="form-group row">
													<label for="categorias" class="col-md-12">Seleccione las categorias de venta</label>
													<div class="col-md-12">
														<select class="select2-categorias form-control" name="categorias[]" multiple readonly>
															<?php foreach ($categorias as $categoria) : ?>
																<option value="<?php echo $categoria->id; ?>">
																	<?php echo $categoria->nombre; ?>
																</option>
															<?php endforeach; ?>
														</select>
													</div>
												</div>

												<div class="form-group row">
													<label for="terminos_condiciones" class="col-md-12">Términos y condiciones</label>
													<div class="col-md-12">
														<textarea class="form-control" name="terminos_condiciones" rows="5"><?php echo set_value('terminos_condiciones'); ?></textarea>
													</div>
												</div>
												<div class="form-group row">
													<label for="descripcion" class="col-md-12">Descripción</label>
													<div class="col-md-12">
														<textarea class="form-control" name="descripcion" rows="5"><?php echo set_value('descripcion'); ?></textarea>
													</div>
												</div>
											</div>

											<div class="col-lg-6 col-md-6 col-sm-12">
												<div class="row">
													<div class="col-lg-6 col-md-6 col-sm-12">
														<img src="<?php echo site_url("almacenamiento/planes/default.jpg"); ?>" name="preview_url_infoventa" id="preview_url_infoventa" style="width: 200px; height: 200px;">
													</div>
													<div class="col-lg-6 col-md-6 col-sm-12">
														<p><b>Formato: </b>JPG</p>
														<p><b>Ancho: </b>1200</p>
														<p><b>Altura: </b>1200</p>
														<p><b>Tamaño máximo (Kb): </b>600</p>
														<input type="file" name="url_infoventa" id="url_infoventa" placeholder="Miniatura" value="<?php echo set_value('url_infoventa') == false ? $this->session->flashdata('url_infoventa') : set_value('url_infoventa'); ?>" onchange="cargar_imagen(event)">
													</div>
												</div>

											</div>
										</div>

										<div class="form-actions right">
											<a href="<?php echo site_url('planes/index'); ?>" class="btn btn-secondary btn-sm">Cancelar</a>
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