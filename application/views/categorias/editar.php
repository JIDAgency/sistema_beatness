<div class="app-content container center-layout mt-2">
	<div class="content-header-left col-md-6 col-12 mb-2">
		<div class="row breadcrumbs-top">
			<div class="breadcrumb-wrapper col-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo site_url('inicio/index') ?>">Inicio</a>
					</li>
					<li class="breadcrumb-item"><a href="<?php echo site_url('categorias/index') ?>">Categorias</a>
					</li>
					<li class="breadcrumb-item active">Editar categoria
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
								<h4 class="card-title">Editar categoria</h4>
							</div>
							<div class="card-content">
								<div class="card-body">
									<?php echo form_open('categorias/editar', array('class' => 'form form-horizontal', 'id' => 'forma-editar-categoria')); ?>
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
										<h4 class="form-section">Datos de la categoria</h4>

										<div class="row">
											<div class="col-md-6 mb-3">
												<div class="form-group">
													<label for="nombre" class="label-control">Nombre <span class="red">*</span></label>
													<input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre" value="<?php echo set_value('nombre') == false ? $categoria_a_editar_row->nombre : set_value('nombre'); ?>">
													<input type="hidden" class="form-control" id="id" name="id" placeholder="" value="<?php echo set_value('id') == false ? $categoria_a_editar_row->id : set_value('id'); ?>" readonly>

												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-6 mb-3">
												<div class="form-group">
													<label for="descripcion" class="label-control">Descripción <span class="red">*</span></label>
													<input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Banner" value="<?php echo set_value('descripcion') == false ? $categoria_a_editar_row->descripcion : set_value('descripcion'); ?>">
												</div>
											</div>
										</div>


										<div class="row">
											<div class="col-md-6 mb-3">
												<div class="form-group">
													<label for="notas" class="label-control">Nota <span class="red">*</span></label>
													<input type="text" class="form-control" id="notas" name="notas" placeholder="Titulo" value="<?php echo set_value('notas') == false ? $categoria_a_editar_row->notas : set_value('notas'); ?>">
												</div>
											</div>
										</div>

										<div class="row">
                                            <div class="col-md-6 mb-3">
												<div class="form-group">
													<label for="reservable">Reservable <span class="red">*</span></label>
													<select name="reservable" id="reservable" class="form-control">
														<option value="" <?php echo set_select('reservable', ''); ?>>Seleccione una sucursal</option>
														<option value="true"<?php echo set_select('reservable', "true", set_value('reservable') ? false : "true" == $categoria_a_editar_row->reservable); ?>>Si</option>
														<option value="false"<?php echo set_select('reservable', "false", set_value('reservable') ? false : "false" == $categoria_a_editar_row->reservable); ?>>No</option>
													</select>
												</div>	
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
												<div class="form-group">
													<label for="visible">Visible <span class="red">*</span></label>
													<select name="visible" id="visible" class="form-control">
														<option value="" <?php echo set_select('visible', ''); ?>>Seleccione una sucursal</option>
														<option value="true"<?php echo set_select('visible', "true", set_value('visible') ? false : "true" == $categoria_a_editar_row->visible); ?>>Si</option>
														<option value="false"<?php echo set_select('visible', "false", set_value('visible') ? false : "false" == $categoria_a_editar_row->visible); ?>>No</option>
													</select>
												</div>	
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
												<div class="form-group">
													<label for="virtual">Visrtual <span class="red">*</span></label>
													<select name="virtual" id="virtual" class="form-control">
														<option value="" <?php echo set_select('virtual', ''); ?>>Seleccione una sucursal</option>
														<option value="true"<?php echo set_select('virtual', "true", set_value('virtual') ? false : "true" == $categoria_a_editar_row->virtual); ?>>Si</option>
														<option value="false"<?php echo set_select('virtual', "false", set_value('virtual') ? false : "false" == $categoria_a_editar_row->virtual); ?>>No</option>
													</select>
												</div>	
                                            </div>
                                        </div>

										<div class="form-actions right">
											<a href="<?php echo site_url('categorias/index'); ?>" class="btn btn-secondary btn-sm">Cancelar</a>
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