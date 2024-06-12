<div class="app-content container center-layout mt-2">
	<div class="content-header-left col-md-6 col-12 mb-2">
		<div class="row breadcrumbs-top">
			<div class="breadcrumb-wrapper col-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo site_url('inicio/index') ?>">Inicio</a>
					</li>
					<li class="breadcrumb-item"><a href="<?php echo site_url('disciplinas/index') ?>">Disciplinas</a>
					</li>
					<li class="breadcrumb-item active">Crear nueva disciplina
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
								<h4 class="card-title">Nueva disciplina</h4>
							</div>
							<div class="card-content">
								<div class="card-body">
									<?php echo form_open('disciplinas/crear', array('class' => 'form form-horizontal', 'id' => 'forma-crear-disciplina')); ?>
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
										<h4 class="form-section">Datos de la disciplina</h4>
										<div class="row">
											<div class="col-md-6 mb-3">

												<div class="form-group">
													<label for="nombre" class="label-control">Nombre <span class="red">*</span></label>
													<input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre" value="<?php echo set_value('nombre'); ?>">
												</div>

											</div>
										</div>

										<div class="row">
											<div class="col-md-6 mb-3">
												<div class="form-group">
													<label for="url_banner" class="label-control">Url del Banner <span class="red">*</span></label>
													<input type="text" class="form-control" id="url_banner" name="url_banner" placeholder="Banner" value="<?php echo set_value('url_banner'); ?>">
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-6 mb-3">
												<div class="form-group">
													<label for="url_titulo" class="label-control">Url Titulo <span class="red">*</span></label>
													<input type="text" class="form-control" id="url_titulo" name="url_titulo" placeholder="Titulo" value="<?php echo set_value('url_titulo'); ?>">
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-6 mb-3">
												<div class="form-group">
													<label for="url_logo" class="label-control">Url del Logotipo <span class="red">*</span></label>
													<input type="text" class="form-control" id="url_logo" name="url_logo" placeholder="Logotipo" value="<?php echo set_value('url_logo'); ?>">
												</div>
											</div>
										</div>

										<!-- <div class="row">
											<div class="col-md-6 mb-3">
												<div class="form-group">
													<label for="sucursal_id">Sucursal <span class="red">*</span></label>
													<select name="sucursal_id" id="sucursal_id" class="form-control">
														<option value="" <?php echo set_select('sucursal_id', ''); ?>>Seleccione una sucursal</option>
														<option value="4" <?php echo set_select('sucursal_id', '4'); ?>>BEATNESS [CDMX Origami]</option>
														<option value="3" <?php echo set_select('sucursal_id', '3'); ?>>BEATNESS [CDMX Polanco]</option>
														<option value="2" <?php echo set_select('sucursal_id', '2'); ?>>BEATNESS [Puebla Paseo del Sur]</option>
													</select>
												</div>
											</div>
										</div> -->

										<div class="row">
											<div class="col-md-6 mb-3">
												<div class="form-group">
													<label for="sucursal_id">Sucursal <span class="red">*</span></label>
													<select name="sucursal_id" id="sucursal_id" class="form-control">
														<option value="" <?php echo set_select('sucursal_id', ''); ?>>Seleccione una sucursal</option>
														<?php foreach ($sucursales_list as $key => $sucursales_row) : ?>
															<?php if ($sucursales_row->id != 1) : ?>
																<option value="<?php echo $sucursales_row->id ?>"><?php echo $sucursales_row->nombre . ' - ' . $sucursales_row->locacion ?></option>
															<?php endif; ?>
														<?php endforeach;  ?>
													</select>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-6 mb-3">
												<div class="form-group">
													<label for="estatus">Estatus de la sucursal <span class="red">*</span></label>
													<select name="estatus" id="estatus" class="form-control">
														<option value="" <?php echo set_select('estatus', ''); ?>>Seleccione un estatus…</option>
														<option value="activo" <?php echo set_select('estatus', 'activo'); ?>>Activo</option>
														<option value="inactivo" <?php echo set_select('estatus', 'inactivo'); ?>>Inactivo</option>
													</select>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-6 mb-3">
												<div class="form-group">
													<label for="ilimitado">Es ilimitado <span class="red">*</span></label>
													<select name="ilimitado" id="ilimitado" class="form-control">
														<option value="" <?php echo set_select('es_ilimitado', '', set_value('es_ilimitado') ? false : '' == $this->session->flashdata('es_ilimitado')); ?>>Seleccione una opcion…</option>
														<?php foreach (select_mostrar() as $mostrar_key => $mostrar_row) : ?>
															<option value="<?php echo $mostrar_row->valor; ?>" <?php echo $mostrar_row->activo == false ? '' : 'selected'; ?> <?php echo set_select('es_ilimitado', $mostrar_row->valor, set_value('es_ilimitado') ? false : $mostrar_row->valor == $this->session->flashdata('es_ilimitado')); ?>><?php echo trim($mostrar_row->nombre); ?></option>
														<?php endforeach; ?>
													</select>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-6 mb-3">
												<div class="form-group">
													<label for="mostrar_app">Mostrar en app <span class="red">*</span></label>
													<select name="mostrar_app" id="mostrar_app" class="form-control">
														<option value="" <?php echo set_select('mostrar_en_app', '', set_value('mostrar_en_app') ? false : '' == $this->session->flashdata('mostrar_en_app')); ?>>Seleccione una opcion…</option>
														<?php foreach (select_mostrar() as $mostrar_key => $mostrar_row) : ?>
															<option value="<?php echo $mostrar_row->valor; ?>" <?php echo $mostrar_row->activo == false ? '' : 'selected'; ?> <?php echo set_select('mostrar_en_app', $mostrar_row->valor, set_value('mostrar_en_app') ? false : $mostrar_row->valor == $this->session->flashdata('mostrar_en_app')); ?>><?php echo trim($mostrar_row->nombre); ?></option>
														<?php endforeach; ?>
													</select>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-6 mb-3">
												<div class="form-group">
													<label for="mostrar_web">Mostrar en web <span class="red">*</span></label>
													<select name="mostrar_web" id="mostrar_web" class="form-control">
														<option value="" <?php echo set_select('mostrar_en_web', '', set_value('mostrar_en_web') ? false : '' == $this->session->flashdata('mostrar_en_web')); ?>>Seleccione una opcion…</option>
														<?php foreach (select_mostrar() as $mostrar_key => $mostrar_row) : ?>
															<option value="<?php echo $mostrar_row->valor; ?>" <?php echo $mostrar_row->activo == false ? '' : 'selected'; ?> <?php echo set_select('mostrar_en_web', $mostrar_row->valor, set_value('mostrar_en_web') ? false : $mostrar_row->valor == $this->session->flashdata('mostrar_en_web')); ?>><?php echo trim($mostrar_row->nombre); ?></option>
														<?php endforeach; ?>
													</select>
												</div>
											</div>
										</div>	
										
										<div class="row">
											<div class="col-md-6 mb-3">
												<div class="form-group">
													<label for="formato">Como mostrar clase <span class="red">*</span></label>
													<select name="formato" id="formato" class="form-control">
														<option value="" <?php echo set_select('formato', '', set_value('formato') ? false : '' == $this->session->flashdata('formato')); ?>>Seleccione una opcion…</option>
														<?php foreach (select_mostrar_clase() as $mostrar_key => $mostrar_row) : ?>
															<option value="<?php echo $mostrar_row->valor; ?>" <?php echo $mostrar_row->activo == false ? '' : 'selected'; ?> <?php echo set_select('formato', $mostrar_row->valor, set_value('formato') ? false : $mostrar_row->valor == $this->session->flashdata('formato')); ?>><?php echo trim($mostrar_row->nombre); ?></option>
														<?php endforeach; ?>
													</select>
												</div>
											</div>
										</div>	
										
										<div class="row">
											<div class="col-md-6 mb-3">
												<div class="form-group">
													<label for="gympass_product_id" class="label-control">Gympass Product id</label>
													<input type="number" class="form-control" id="gympass_product_id" name="gympass_product_id" placeholder="Gympass product id" value="<?php echo set_value('gympass_product_id'); ?>">
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