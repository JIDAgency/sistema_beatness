<div class="app-content container center-layout mt-2">
	<div class="content-header-left col-md-6 col-12 mb-2">
		<div class="row breadcrumbs-top">
			<div class="breadcrumb-wrapper col-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo site_url('inicio/index') ?>">Inicio</a>
					</li>
					<li class="breadcrumb-item"><a href="<?php echo site_url('planes/index') ?>">Planes</a>
					</li>
					<li class="breadcrumb-item active">Editar plan
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
								<h4 class="card-title">Editar plan</h4>
							</div>
							<div class="card-content">
								<div class="card-body">
									<?php echo form_open_multipart(uri_string(), array('class' => 'form form-horizontal', 'id' => 'forma-editar-plan')); ?>

									<input type="hidden" class="form-control" name="id" id="id" value="<?php echo $plan_a_editar->id; ?>" readonly="">

									<div class="form-body">

										<?php $this->load->view('_templates/mensajes_alerta.tpl.php'); ?>

										<h4 class="form-section">Datos del plan</h4>

										<div class="row">
											<div class="col-lg-6 col-md-6 col-sm-12">
												<div class="row">
													<div class="form-group row col-lg-12 col-md-12 col-sm-12">
														<label for="nombre" class="col-md-12">Nombre&nbsp;<span class="red">*</span></label>
														<div class="col-md-12">
															<input type="text" class="form-control" name="nombre" placeholder="Nombre" value="<?php echo set_value('nombre') == false ? $plan_a_editar->nombre : set_value('nombre'); ?>">
														</div>
													</div>
													<div class="form-group row col-lg-12 col-md-12 col-sm-12">
														<label for="sku" class="col-md-12">SKU&nbsp;<span class="red">*</span></label>
														<div class="col-md-12">
															<input type="text" class="form-control" name="sku" placeholder="SKU" value="<?php echo set_value('sku') == false ? $plan_a_editar->sku : set_value('sku'); ?>">
														</div>
													</div>
													<div class="form-group row col-lg-12 col-md-12 col-sm-12">
														<label for="clases_incluidas" class="col-md-12">Clases incluidas&nbsp;<span class="red">*</span></label>
														<div class="col-md-12">
															<input type="text" name="clases_incluidas" class="form-control" placeholder="Clases incluidas" value="<?php echo set_value('clases_incluidas') == false ? $plan_a_editar->clases_incluidas : set_value('clases_incluidas'); ?>">
														</div>
													</div>
													<div class="form-group row col-lg-12 col-md-12 col-sm-12">
														<label for="vigencia_en_dias" class="col-md-12">Vigencia en días&nbsp;<span class="red">*</span></label>
														<div class="col-md-12">
															<input type="text" name="vigencia_en_dias" class="form-control" placeholder="Vigencia en días" value="<?php echo set_value('vigencia_en_dias') == false ? $plan_a_editar->vigencia_en_dias : set_value('vigencia_en_dias'); ?>">
														</div>
													</div>
													<div class="form-group row col-lg-12 col-md-12 col-sm-12">
														<label for="costo" class="col-md-12">Costo&nbsp;<span class="red">*</span></label>
														<div class="col-md-12">
															<input type="text" class="form-control" name="costo" placeholder="Costo" value="<?php echo set_value('costo') == false ? $plan_a_editar->costo : set_value('costo'); ?>">
														</div>
													</div>
													<div class="form-group row col-lg-12 col-md-12 col-sm-12">
														<label for="orden_venta" class="col-md-12">Orden de venta&nbsp;<span class="red">*</span></label>
														<label for="orden_venta" class="col-md-12"><small class="text-muted"><em>(Ordenar del 1 al …, el 5 es la posición normal de venta)</em></small></label>
														<div class="col-md-12">
															<input type="number" class="form-control" name="orden_venta" placeholder="Orden" value="<?php echo set_value('orden_venta') == false ? ($plan_a_editar->orden_venta ? $plan_a_editar->orden_venta : 5) : set_value('orden_venta'); ?>">
														</div>
													</div>

													<div class="form-group row col-lg-12 col-md-12 col-sm-12">
														<label for="ilimitado" class="col-md-12">Es ilimitado <span class="red">*</span></label>
														<div class="col-md-12">
															<select name="ilimitado" id="ilimitado" class="form-control">
																<option value="" <?php echo set_select('es_ilimitado', '', set_value('es_ilimitado') ? false : '' == (!empty($this->session->flashdata('es_ilimitado')) ? $this->session->flashdata('es_ilimitado') : (!empty($plan_a_editar->es_ilimitado) ? $plan_a_editar->es_ilimitado : set_value('es_ilimitado')))); ?>>Seleccione una opcion…</option>
																<?php foreach (select_mostrar() as $key => $mostrar_row) : ?>
																	<option value="<?php echo $mostrar_row->valor; ?>" <?php echo set_select('es_ilimitado', $mostrar_row->valor, set_value('es_ilimitado') ? false : $mostrar_row->valor == (!empty($this->session->flashdata('es_ilimitado')) ? $this->session->flashdata('es_ilimitado') : (!empty($plan_a_editar->es_ilimitado) ? $plan_a_editar->es_ilimitado : set_value('es_ilimitado')))); ?>><?php echo trim($mostrar_row->nombre); ?></option>
																<?php endforeach; ?>
															</select>
														</div>
													</div>

													<div class="form-group row col-lg-12 col-md-12 col-sm-12">
														<label for="es_primera" class="col-md-12">Es primera <span class="red">*</span></label>
														<div class="col-md-12">
															<select name="es_primera" id="es_primera" class="form-control">
																<option value="" <?php echo set_select('es_primera', '', set_value('es_primera') ? false : '' == (!empty($this->session->flashdata('es_primera')) ? $this->session->flashdata('es_primera') : (!empty($plan_a_editar->es_primera) ? $plan_a_editar->es_primera : set_value('es_primera')))); ?>>Seleccione una opcion…</option>
																<?php foreach (select_mostrar() as $key => $mostrar_row) : ?>
																	<option value="<?php echo $mostrar_row->valor; ?>" <?php echo set_select('es_primera', $mostrar_row->valor, set_value('es_primera') ? false : $mostrar_row->valor == (!empty($this->session->flashdata('es_primera')) ? $this->session->flashdata('es_primera') : (!empty($plan_a_editar->es_primera) ? $plan_a_editar->es_primera : set_value('es_primera')))); ?>><?php echo trim($mostrar_row->nombre); ?></option>
																<?php endforeach; ?>
															</select>
														</div>
													</div>

													<div class="form-group row col-lg-12 col-md-12 col-sm-12">
														<label for="es_estudiante" class="col-md-12">Es estudiante <span class="red">*</span></label>
														<div class="col-md-12">
															<select name="es_estudiante" id="es_estudiante" class="form-control">
																<option value="" <?php echo set_select('es_estudiante', '', set_value('es_estudiante') ? false : '' == (!empty($this->session->flashdata('es_estudiante')) ? $this->session->flashdata('es_estudiante') : (!empty($plan_a_editar->es_estudiante) ? $plan_a_editar->es_estudiante : set_value('es_estudiante')))); ?>>Seleccione una opcion…</option>
																<?php foreach (select_mostrar() as $key => $mostrar_row) : ?>
																	<option value="<?php echo $mostrar_row->valor; ?>" <?php echo set_select('es_estudiante', $mostrar_row->valor, set_value('es_estudiante') ? false : $mostrar_row->valor == (!empty($this->session->flashdata('es_estudiante')) ? $this->session->flashdata('es_estudiante') : (!empty($plan_a_editar->es_estudiante) ? $plan_a_editar->es_estudiante : set_value('es_estudiante')))); ?>><?php echo trim($mostrar_row->nombre); ?></option>
																<?php endforeach; ?>
															</select>
														</div>
													</div>

													<div class="form-group row col-lg-12 col-md-12 col-sm-12">
														<label for="activado" class="col-md-12">Activo <span class="red">*</span></label>
														<div class="col-md-12">
															<select name="activado" id="activado" class="form-control">
																<option value="" <?php echo set_select('activado', '', set_value('activado') ? false : '' == (!empty($this->session->flashdata('activado')) ? $this->session->flashdata('activado') : (!empty($plan_a_editar->activado) ? $plan_a_editar->activado : set_value('activado')))); ?>>Seleccione una opcion…</option>
																<?php foreach (select_activo() as $key => $mostrar_row) : ?>
																	<option value="<?php echo $mostrar_row->valor; ?>" <?php echo set_select('activado', $mostrar_row->valor, set_value('activado') ? false : $mostrar_row->valor == (!empty($this->session->flashdata('activado')) ? $this->session->flashdata('activado') : (!empty($plan_a_editar->activado) ? $plan_a_editar->activado : set_value('activado')))); ?>><?php echo trim($mostrar_row->nombre); ?></option>
																<?php endforeach; ?>
															</select>
														</div>
													</div>

													<div class="form-group row col-lg-12 col-md-12 col-sm-12">
														<label for="ilimitado" class="col-md-12">Es ilimitado <span class="red">*</span></label>
														<div class="col-md-12">
															<select name="ilimitado" id="ilimitado" class="form-control">
																<option value="" <?php echo set_select('es_ilimitado', '', set_value('es_ilimitado') ? false : '' == (!empty($this->session->flashdata('es_ilimitado')) ? $this->session->flashdata('es_ilimitado') : (!empty($plan_a_editar->es_ilimitado) ? $plan_a_editar->es_ilimitado : set_value('es_ilimitado')))); ?>>Seleccione una opcion…</option>
																<?php foreach (select_mostrar() as $key => $mostrar_row) : ?>
																	<option value="<?php echo $mostrar_row->valor; ?>" <?php echo set_select('es_ilimitado', $mostrar_row->valor, set_value('es_ilimitado') ? false : $mostrar_row->valor == (!empty($this->session->flashdata('es_ilimitado')) ? $this->session->flashdata('es_ilimitado') : (!empty($plan_a_editar->es_ilimitado) ? $plan_a_editar->es_ilimitado : set_value('es_ilimitado')))); ?>><?php echo trim($mostrar_row->nombre); ?></option>
																<?php endforeach; ?>
															</select>
														</div>
													</div>

													<div class="form-group row col-lg-12 col-md-12 col-sm-12">
														<label class="col-lg-12">Vincular a código</label>
														<div class="col-lg-12">
															<select id="codigo" name="codigo" class="form-control select2 custom-select">
																<option value="" <?php echo set_select('codigo', '', set_value('codigo') ? false : '' == $this->session->flashdata('codigo')); ?>>Seleccione un código</option>
																<?php foreach ($codigos_list->result() as $key => $codigo_row) : ?>
																	<option value="<?php echo $codigo_row->codigo; ?>" <?php echo set_select('codigo', $codigo_row->codigo, set_value('codigo') ? false : $codigo_row->codigo == $plan_a_editar->codigo); ?>><?php echo trim(mb_strtoupper($codigo_row->codigo)); ?></option>
																<?php endforeach; ?>
															</select>
															<div class="invalid-feedback">
																Se requiere un código válido.
															</div>
														</div>
													</div>

													<div class="form-group row col-lg-12 col-md-12 col-sm-12">
														<label for="clases_incluidas" class="col-md-12">Seleccione las disciplinas&nbsp;<span class="red">*</span></label>
														<div class="col-md-12">
															<select class="select2-disciplinas form-control" name="disciplinas[]" multiple>

																<?php foreach ($disciplinas as $amenidades_key => $disciplina) : ?>
																	<?php if ($disciplina->id != 1) : ?>
																		<option value="<?php echo $disciplina->id; ?>" <?php foreach ($disciplinas_seleccionadas as $disciplina_seleccionada) {
																															echo $disciplina->id == $disciplina_seleccionada->disciplina_id ? 'selected' : '';
																														} ?>><?php echo trim(mb_strtoupper($disciplina->nombre)); ?></option>
																	<?php endif; ?>
																<?php endforeach; ?>
															</select>
														</div>
													</div>

													<div class="form-group row col-lg-12 col-md-12 col-sm-12">
														<label for="categorias" class="col-md-12">Seleccione las categorias de venta&nbsp;<span class="red">*</span></label>
														<div class="col-md-12">
															<select class="select2-categorias form-control" name="categorias[]" multiple>

																<?php foreach ($categorias as $amenidades_key => $categoria) : ?>
																	<option value="<?php echo $categoria->id; ?>" <?php foreach ($categorias_seleccionadas as $categoria_seleccionada) {
																														echo $categoria->id == $categoria_seleccionada->categoria_id ? 'selected' : '';
																													} ?>><?php echo trim(mb_strtoupper($categoria->nombre)); ?></option>
																<?php endforeach; ?>
															</select>
														</div>
													</div>

													<div class="form-group row col-lg-12 col-md-12 col-sm-12">
														<label for="terminos_condiciones" class="col-md-12">Términos y condiciones</label>
														<div class="col-md-12">
															<textarea class="form-control" name="terminos_condiciones" rows="5"><?php echo set_value('terminos_condiciones') == false ? $plan_a_editar->terminos_condiciones : set_value('terminos_condiciones'); ?></textarea>
														</div>
													</div>
													<div class="form-group row col-lg-12 col-md-12 col-sm-12">
														<label for="descripcion" class="col-md-12">Descripción</label>
														<div class="col-md-12">
															<textarea class="form-control" name="descripcion" rows="5"><?php echo set_value('descripcion') == false ? $plan_a_editar->descripcion : set_value('descripcion'); ?></textarea>
														</div>
													</div>
												</div>
											</div>
											<div class="col-lg-6 col-md-6 col-sm-12">
												<div class="form-group">
													<div class="row mt-2 mb-2">

														<label class="col-sm-12"><b>Imagen</b></label>

														<div class="col-sm-6">
															<?php if ($plan_a_editar->url_infoventa != 'https://beatness.com.mx/almacenamiento/planes/default.jpg') : ?>
																<img class="img-fluid border" name="preview_url_infoventa" id="preview_url_infoventa" src="<?php echo $plan_a_editar->url_infoventa; ?>" style="width: 100%;">
															<?php endif; ?>
														</div>

														<div class="col-sm-6">
															<p><b>Formato:&nbsp;</b>JPG</p>
															<p><b>Tamaño máximo:&nbsp;</b>400 Kb</p>
															<input type="file" name="url_infoventa" id="url_infoventa" placeholder="Imagen" value="<?php echo set_value('url_infoventa') == false ? $plan_a_editar->url_infoventa : set_value('url_infoventa'); ?>" onchange="cargar_imagen(event)">
														</div>

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