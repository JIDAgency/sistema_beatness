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
									<?php echo form_open('planes/crear', array('class' => 'form form-horizontal', 'id' => 'forma-crear-plan')); ?>
									<div class="form-body">

										<?php if (validation_errors()): ?>
										<div class="alert bg-danger alert-icon-left alert-dismissible mb-2 font-small-3" role="alert">
											<span class="alert-icon"><i class="fa fa-thumbs-o-down"></i></span>
											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
												<span aria-hidden="true">×</span>
											</button>
											<?php echo validation_errors(); ?>
										</div>
										<?php endif?>

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
													<div class="row">
														<label class="col-lg-12">Vincular a código</label>
														<div class="col-lg-12">
															<select id="codigo" name="codigo" class="form-control select2-disciplinas custom-select">
																<option value="" <?php echo set_select('codigo', '', set_value('codigo') ? false : '' == $this->session->flashdata('codigo')); ?>>Seleccione un código</option>
																<?php foreach ($codigos_list->result() as $key => $codigo_row): ?>
																	<option value="<?php echo $codigo_row->codigo; ?>" <?php echo set_select('codigo', $codigo_row->codigo, set_value('codigo') ? false : $codigo_row->codigo == $this->session->flashdata('codigo')); ?>><?php echo trim(mb_strtoupper($codigo_row->codigo)); ?></option>
																<?php endforeach; ?>
															</select>
															<div class="invalid-feedback">
																Se requiere un código válido.
															</div>
														</div>
													</div>
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group row">
													<label for="disciplinas" class="col-md-12">Seleccione las disciplinas</label>
													<div class="col-md-12">
														<select class="select2-disciplinas form-control" name="disciplinas[]" multiple readonly>
															<?php foreach ($disciplinas->result() as $disciplina): ?>
    															<?php if ($disciplina->id != 1): ?>
        															<option value="<?php echo $disciplina->id; ?>" selected="selected">
        																<?php echo $disciplina->nombre; ?>
        															</option>
    															<?php endif; ?>
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
