<div class="app-content container center-layout mt-2">
	<div class="content-wrapper">
		<div class="content-body">
			<section>
				<div class="row">
					<div class="col-12">
						<div class="card">
							<div class="card-header">
								<h4 class="card-title">Editar membresía</h4>
							</div>
							<div class="card-content">
								<div class="card-body">
									<div class="card-text">
										<p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Autem iste accusantium dolores doloribus cum
											labore deserunt perferendis, quibusdam officia facilis distinctio dicta voluptatibus rem dolorum ut
											molestias velit iusto in.</p>
									</div>
									<?php echo form_open('membresias/editar', array('class' => 'form form-horizontal', 'id' => 'forma-editar-membresia')); ?>
									<input type="hidden" name="id" value="<?php echo $membresia_a_editar->id; ?>">
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
										<h4 class="form-section">Datos de la membresía</h4>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group row">
													<label for="nombre" class="col-md-3 label-control"><span class="red">*</span> Nombre</label>
													<div class="col-md-9">
														<input type="text" class="form-control" name="nombre" placeholder="Nombre" value="<?php echo set_value('nombre') == FALSE ? $membresia_a_editar->nombre : set_value('nombre'); ?>">
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group row">
													<label for="tipo" class="col-md-3 label-control">Tipo</label>
													<div class="col-md-5">
														<input type="text" name="tipo" class="form-control" placeholder="Tipo" value="<?php echo set_value('tipo') == FALSE ? $membresia_a_editar->tipo : set_value('tipo'); ?>">
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group row">
													<label for="nombre_usuario" class="col-md-3 label-control">Descripción</label>
													<div class="col-md-9">
														<textarea class="form-control" name="descripcion" rows="5"><?php echo set_value('descripcion') == FALSE ? $membresia_a_editar->descripcion : set_value('descripcion'); ?></textarea>
													</div>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-6">
												<div class="form-group row">
													<label for="costo" class="col-md-3 label-control"><span class="red">*</span> Costo</label>
													<div class="col-md-4">
														<input type="text" class="form-control" name="costo" placeholder="Costo" value="<?php echo set_value('costo') == FALSE ? $membresia_a_editar->costo : set_value('costo'); ?>">
													</div>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-6">
												<div class="form-group row">
													<label for="clases_incluidas" class="col-md-3 label-control">Clases incluidas</label>
													<div class="col-md-4">
														<input type="text" name="clases_incluidas" class="form-control" placeholder="Clases incluidas" value="<?php echo set_value('clases_incluidas') == FALSE ? $membresia_a_editar->clases_incluidas : set_value('clases_incluidas'); ?>">
													</div>
												</div>
											</div>
										</div>

										<div class="form-actions right">
											<a href="<?php echo site_url('membresias/index'); ?>" class="btn btn-secondary btn-sm">Cancelar</a>
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
