<div class="app-content container center-layout mt-2">
	<div class="content-header-left col-md-6 col-12 mb-2">
		<div class="row breadcrumbs-top">
			<div class="breadcrumb-wrapper col-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo site_url('inicio/index') ?>">Inicio</a>
					</li>
					<li class="breadcrumb-item"><a href="<?php echo site_url('clases_categorias/index') ?>">Clases</a>
					</li>
					<li class="breadcrumb-item active">Crear nueva categoria de clase
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
						<div class="card">
							<div class="card-header">
								<h4 class="card-title">Nueva categoria de clase</h4>
							</div>
							<div class="card-content">
								<div class="card-body">
									<?php echo form_open('clases_categorias/crear', array('class' => 'form form-horizontal', 'id' => 'forma-crear-clase')); ?>
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
										<h4 class="form-section">Datos de la clase</h4>
										<div class="row">
											<input type="hidden" readonly="true" id="identificador" class="form-control" name="identificador" placeholder="Identificador" value="<?php echo set_value('identificador'); ?>">
											<div class="col-md-8">
												<div class="form-group row">
													<label for="disciplina_id" class="col-md-3 label-control"><span class="red">*</span> Disciplina
														para la clase</label>
													<div class="col-md-9">
														<select id="mySelect" name="disciplina_id" class="form-control">
															<option value="">Seleccione la disciplina</option>
															<?php foreach ($disciplinas->result() as $disciplina) : ?>
																<?php if ($disciplina->id != 1) : ?>
																	<option value="<?php echo $disciplina->id; ?>" <?php echo set_select('disciplina_id', $disciplina->id); ?>>
																		<?php echo $disciplina->nombre; ?>
																	</option>
																<?php endif; ?>
															<?php endforeach; ?>
														</select>
													</div>
												</div>
											</div>
											<!-- <div class="col-md-8">
												<div class="form-group row">
													<label for="gympass_id" class="col-md-3 label-control"><span class="red">*</span> Gympass</label>
													<div class="col-md-9">
														<select id="gympass_id" name="gympass_id" class="form-control">
															<option value="">Seleccione gympass</option>
															<?php foreach ($gympass->result() as $gympass) : ?>
																<?php if ($gympass->id != 1) : ?>
																	<option value="<?php echo $gympass->id; ?>" <?php echo set_select('gympass_id', $gympass->id); ?>>
																		<?php echo $gympass->nombre; ?>
																	</option>
																<?php endif; ?>
															<?php endforeach; ?>
														</select>
													</div>
												</div>
											</div> -->
										</div>

										<div class="row">
											<div class="col-md-8">
												<div class="form-group row">
													<label for="nombre" class="col-md-3 label-control"><span class="red">*</span> Nombre</label>
													<div class="col-md-5">
														<input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre" value="<?php echo set_value('nombre') == false ? "" : set_value('nombre'); ?>">
													</div>
												</div>
											</div>
											<div class="col-md-8">
												<div class="form-group row">
													<label for="descripcion" class="col-md-3 label-control"><span class="red">*</span> Descripción</label>
													<div class="col-md-5">
														<textarea type="text" id="descripcion" name="descripcion" class="form-control" rows="5" placeholder="Descripción" value="<?php echo set_value('descripcion') == false ? "" : set_value('descripcion'); ?>"></textarea>
													</div>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-8">
												<div class="form-group row">
													<label for="nota" class="col-md-3 label-control"><span class="red">*</span> Nota</label>
													<div class="col-md-5">
														<textarea type="text" id="nota" name="nota" class="form-control" rows="5" placeholder="Nota" value="<?php echo set_value('nota') == false ? "" : set_value('nota'); ?>"></textarea>
													</div>
												</div>
											</div>
											<div class="col-md-8">
												<div class="form-group row">
														<label class="col-md-3 label-control"><span class="red">*</span> Estatus</label>
														<div class="col-md-5">
															<select id="estatus" name="estatus" class="form-control select2 custom-select" required>
																<option value="">Seleccione un estatus...</option>
																<option value="activo" selected <?php echo set_select('estatus', 'activo', set_value('estatus') ? false : 'activo' == $this->session->flashdata('estatus')); ?>>Activo</option>
																<option value="suspendido" <?php echo set_select('estatus', 'suspendido', set_value('estatus') ? false : 'suspendido' == $this->session->flashdata('estatus')); ?>>Suspendido</option>
															</select>
														</div>

												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-8">
												<div class="form-group row">
													<div class="col-md-4">
														<input type="hidden" readonly="true" name="inicia_numero" id="inicia_numero" class="form-control" value="<?php echo set_value('inicia_numero'); ?>">
													</div>
												</div>
											</div>
										</div>

										<div class="form-actions right">
											<a href="<?php echo site_url('clases/index'); ?>" class="btn btn-secondary btn-sm">Cancelar</a>
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