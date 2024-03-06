<div class="app-content container center-layout mt-2">
	<div class="content-header-left col-md-6 col-12 mb-2">
		<div class="row breadcrumbs-top">
			<div class="breadcrumb-wrapper col-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo site_url('inicio/index') ?>">Inicio</a>
					</li>
					<li class="breadcrumb-item"><a href="<?php echo site_url('disciplinas/index') ?>">Disciplinas</a>
					</li>
					<li class="breadcrumb-item active">Editar disciplina
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
								<h4 class="card-title">Editar disciplina</h4>
							</div>
							<div class="card-content">
								<div class="card-body">
									<?php echo form_open('disciplinas/editar', array('class' => 'form form-horizontal', 'id' => 'forma-editar-disciplina')); ?>
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
										<h4 class="form-section">Datos de la disciplina</h4>

										<div class="row">
											<div class="col-md-6 mb-3">	
												<div class="form-group">
													<label for="nombre" class="label-control">Nombre <span class="red">*</span></label>
													<input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre" value="<?php echo set_value('nombre') == false ? $disciplina_a_editar_row->nombre : set_value('nombre'); ?>">
													<input type="hidden" class="form-control" id="id" name="id" placeholder="" value="<?php echo set_value('id') == false ? $disciplina_a_editar_row->id : set_value('id'); ?>" readonly>

												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-6 mb-3">
												<div class="form-group">
													<label for="url_banner" class="label-control">Url del Banner <span class="red">*</span></label>
													<input type="text" class="form-control" id="url_banner" name="url_banner" placeholder="Banner" value="<?php echo set_value('url_banner') == false ? $disciplina_a_editar_row->url_banner : set_value('url_banner'); ?>">
												</div>
											</div>
										</div>


										<div class="row">
											<div class="col-md-6 mb-3">
												<div class="form-group">
													<label for="url_titulo" class="label-control">Url Titulo <span class="red">*</span></label>		
													<input type="text" class="form-control" id="url_titulo" name="url_titulo" placeholder="Titulo" value="<?php echo set_value('url_titulo') == false ? $disciplina_a_editar_row->url_titulo : set_value('url_titulo'); ?>">
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-6 mb-3">
												<div class="form-group">
													<label for="url_logo" class="label-control">Url del Logotipo <span class="red">*</span></label>
													<input type="text" class="form-control" id="url_logo" name="url_logo" placeholder="Logotipo" value="<?php echo set_value('url_logo') == false ? $disciplina_a_editar_row->url_logo : set_value('url_logo'); ?>">
												</div>
											</div>
										</div>


										<div class="row">
                                            <div class="col-md-6 mb-3">
												<div class="form-group">
													<label for="sucursal_id">Sucursal <span class="red">*</span></label>
													<select name="sucursal_id" id="sucursal_id" class="form-control">
														<option value="" <?php echo set_select('sucursal_id', '' ); ?>>Seleccione una sucursal</option>
														<option value="5"<?php echo set_select('sucursal_id', "5" , set_value('sucursal_id') ? false : "5"==$disciplina_a_editar_row->sucursal_id);?>>Sucursal 5</option>
														<option value="4"<?php echo set_select('sucursal_id', "4" , set_value('sucursal_id') ? false : "4"==$disciplina_a_editar_row->sucursal_id);?>>Sucursal 4</option>
														<option value="3"<?php echo set_select('sucursal_id', "3" , set_value('sucursal_id') ? false : "3"==$disciplina_a_editar_row->sucursal_id);?>>Sucursal 3</option>
														<option value="2" <?php echo set_select('sucursal_id', "2" , set_value('sucursal_id') ? false : "2"==$disciplina_a_editar_row->sucursal_id);?>>Sucursal 2</option>
													</select>
												</div>	
                                            </div>
                                        </div>

										<div class="row">
                                            <div class="col-md-6 mb-3">
												<div class="form-group">
													<label for="estatus">Estatus de la sucursal <span class="red">*</span></label>
													<select name="estatus" id="estatus" class="form-control">
														<option value="" <?php echo set_select('estatus', '' ); ?>>Seleccione un estatus…</option>
														<option value="activo"<?php echo set_select('estatus', "activo" , set_value('estatus') ? false : "activo"==$disciplina_a_editar_row->estatus);?>>Activo</option>
														<option value="desactivado" <?php echo set_select('estatus', "desactivado" , set_value('estatus') ? false : "desactivado"==$disciplina_a_editar_row->estatus);?>>Desactivado</option>
													</select>
												</div>
                                            </div>
                                        </div>


										<div class="form-actions right">
											<a href="<?php echo site_url('disciplinas/index'); ?>" class="btn btn-secondary btn-sm">Cancelar</a>
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
