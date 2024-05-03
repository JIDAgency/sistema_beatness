<div class="app-content container center-layout mt-2">
	<div class="content-header-left col-md-6 col-12 mb-2">
		<div class="row breadcrumbs-top">
			<div class="breadcrumb-wrapper col-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo site_url('inicio/index') ?>">Inicio</a>
					</li>
					<li class="breadcrumb-item"><a href="<?php echo site_url('planes_categorias/index') ?>">Planes - categorias</a>
					</li>
					<li class="breadcrumb-item active">Editar plan - categoria
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
								<h4 class="card-title">Editar plan - categoria</h4>
							</div>
							<div class="card-content">
								<div class="card-body">
									<?php echo form_open_multipart('planes_categorias/editar', array('class' => 'form form-horizontal', 'id' => 'forma-editar-categoria')); ?>
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
										<div class="row">
											<div class="col-lg-6 col-md-6 col-sm-12">
												<h4 class="form-section">Datos de la categoria</h4>

												<div class="row">
													<div class="col-md-6 mb-3">
														<div class="form-group">
															<label for="nombre" class="label-control">Nombre <span class="red">*</span></label>
															<input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre" value="<?php echo set_value('nombre') == false ? $plan_categoria_a_editar_row->nombre : set_value('nombre'); ?>">
															<input type="hidden" class="form-control" id="id" name="id" placeholder="" value="<?php echo set_value('id') == false ? $plan_categoria_a_editar_row->id : set_value('id'); ?>" readonly>

														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-md-6 mb-3">
														<div class="form-group">
															<label for="orden" class="label-control">Orden <span class="red">*</span></label>
															<input type="text" class="form-control" id="orden" name="orden" placeholder="Orden" value="<?php echo set_value('orden') == false ? $plan_categoria_a_editar_row->orden : set_value('orden'); ?>">
														</div>
													</div>
												</div>
											</div>

											<div class="col-lg-6 col-md-6 col-sm-12">
												<h4 class="form-section">Foto</h4>
												<div class="row">
													<div class="col-lg-6 col-md-6 col-sm-12">
														<img src="<?php echo site_url("almacenamiento/planes/" . $plan_categoria_a_editar_row->url_banner); ?>" name="preview" id="preview" style="width: 200px; height: 200px;">
													</div>
													<div class="col-lg-6 col-md-6 col-sm-12">
														<p><b>Formato: </b>JPG</p>
														<p><b>Ancho: </b>1200</p>
														<p><b>Altura: </b>1200</p>
														<p><b>Tamaño máximo (Kb): </b>600</p>
														<input type="file" name="url_banner" id="url_banner" placeholder="Miniatura" value="<?php echo set_value('url_banner') == false ? $plan_categoria_a_editar_row->url_banner : set_value('url_banner'); ?>" onchange="cargar_imagen(event)">
													</div>
												</div>
											</div>
										</div>

										<div class="form-actions right">
											<a href="<?php echo site_url('planes_categorias/index'); ?>" class="btn btn-secondary btn-sm">Cancelar</a>
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