<div class="app-content content center-layout">
	<div class="content-wrapper">
		<div class="content-header row px-1 my-1">

			<div class="content-header-left col-md-6 col-12">

				<div class="row breadcrumbs-top">
					<div class="breadcrumb-wrapper col-12">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php echo site_url('inicio'); ?>">Inicio</a></li>
							<li class="breadcrumb-item"><a href="<?php echo site_url('clases'); ?>">Clases</a></li>
							<li class="breadcrumb-item active"><?php echo $pagina_titulo; ?></li>
						</ol>
					</div>
				</div>

			</div>

			<div class="content-header-right col-md-6 col-12">

				<div class="media float-right">

					<div class="form-group">
						<div class="btn-group" role="group" aria-label="Basic example">
							<a class="btn btn-outline-grey btn-outline-lighten-1 btn-min-width" href="<?php echo site_url($regresar_a); ?>"><i class="fa fa-arrow-circle-left"></i>&nbsp;Volver</a>
						</div>
					</div>

				</div>

			</div>
		</div>

		<div class="content-body">
			<section id="section">

				<?php $this->load->view('_templates/mensajes_alerta.tpl.php'); ?>

				<div class="row">
					<div class="col-12">
						<div class="card no-border">

							<div class="card-header">
								<h4 class="card-title"><?php echo $pagina_subtitulo; ?></h4>
							</div>

							<div class="card-content collapse show">
								<div class="card-body card-dashboard">


									<div class="row match-height">
										<div class="col-xl-6 col-md-6 col-sm-6">
											<?php foreach ($clases_list as $clase_key => $clase_value) : ?>
												<p><?php echo $clase_value->id; ?></p>
											<?php endforeach; ?>
										</div>

										<div class="col-xl-6 col-md-6 col-sm-6">

											<?php echo form_open(uri_string(), array('class' => 'form form-horizontal', 'id' => 'forma-crear-clase')); ?>

											<div class="form-body">
												<h4 class="form-section">Datos de la clase</h4>
												<div class="row">
													<div class="col-xl-12 col-md-12 col-sm-12">

														<div class="form-group">
															<div class="row">
																<label class="col-lg-12" for="disciplina_id">Disciplina <span class="red">*</span></label>
																<div class="col-lg-12">
																	<select id="disciplina_id" name="disciplina_id" class="form-control select2 custom-select" required>
																		<option value="" <?php echo set_select('disciplina_id', '', set_value('disciplina_id') ? false : '' == $this->session->flashdata('disciplina_id')); ?>>Seleccione una disciplina…</option>
																		<?php foreach ($disciplinas->result() as $disciplina_key => $disciplina_value) : ?>
																			<?php if ($disciplina_value->id != 1) : ?>
																				<option value="<?php echo $disciplina_value->id; ?>" <?php echo set_select('disciplina_id', $disciplina_value->id, set_value('disciplina_id') ? false : $disciplina_value->id == $this->session->flashdata('disciplina_id')); ?>><?php echo trim($disciplina_value->nombre); ?></option>
																			<?php endif; ?>
																		<?php endforeach; ?>
																	</select>
																	<div class="invalid-feedback">
																		Se requiere una disciplina válida.
																	</div>
																</div>
															</div>
														</div>

													</div>

													<div class="col-xl-12 col-md-12 col-sm-12">

														<div class="form-group">
															<div class="row">
																<label class="col-lg-12" for="instructor_id">Coach <span class="red">*</span></label>
																<div class="col-lg-12">
																	<select id="instructor_id" name="instructor_id" class="form-control select2 custom-select" required>
																		<option value="" <?php echo set_select('instructor_id', '', set_value('instructor_id') ? false : '' == $this->session->flashdata('instructor_id')); ?>>Seleccione una coach…</option>
																		<?php foreach ($instructores->result() as $instructor_key => $instructor_value) : ?>
																			<option value="<?php echo $instructor_value->id; ?>" <?php echo set_select('instructor_id', $instructor_value->id, set_value('instructor_id') ? false : $instructor_value->id == $this->session->flashdata('instructor_id')); ?>><?php echo trim('#' . $instructor_value->id . ' - ' . $instructor_value->nombre_completo . ' ' . $instructor_value->apellido_paterno . ' ' . $instructor_value->apellido_materno . ' - ' . $instructor_value->correo); ?></option>
																		<?php endforeach; ?>
																	</select>
																	<div class="invalid-feedback">
																		Se requiere una coach válida.
																	</div>
																</div>
															</div>
														</div>

													</div>

													<div class="col-xl-12 col-md-12 col-sm-12">

														<div class="form-group">
															<div class="row">
																<label class="col-lg-12" for="dificultad">Grupo muscular <span class="red">*</span> <small class="text-muted">(Primero seleccione una disciplina)</small></label>
																<div class="col-lg-12">
																	<select id="dificultad" name="dificultad" class="form-control select2 custom-select" required>
																		<option value="" <?php echo set_select('dificultad', '', set_value('dificultad') ? false : '' == $this->session->flashdata('dificultad')); ?> class="text-warning">Seleccione un grupo muscular…</option>
																	</select>
																	<div class="invalid-feedback">
																		Se requiere un grupo muscular válido.
																	</div>
																</div>
															</div>
														</div>

													</div>

													<div class="col-xl-6 col-md-6 col-sm-6">

														<div class="form-group">
															<div class="row">
																<label class="col-lg-12 required-field" for="inicia_date">Fecha de clase</label>
																<div class="col-lg-8">
																	<input type="date" class="form-control" name="inicia_date" id="inicia_date" placeholder="Fecha de clase" value="<?php echo set_value('inicia_date') == false ? ($this->session->flashdata('inicia_date') ? $this->session->flashdata('inicia_date') : date('Y-m-d')) : set_value('inicia_date'); ?>" required>
																	<div class="invalid-feedback">
																		Se requiere una fecha de clase válida.
																	</div>
																</div>
																<div class="col-lg-4">
																	<input type="time" class="form-control" name="inicia_time" id="inicia_time" placeholder="Fecha de clase" value="<?php echo set_value('inicia_time') == false ? ($this->session->flashdata('inicia_time') ? $this->session->flashdata('inicia_time') : date('H:i')) : set_value('inicia_time'); ?>" required>
																	<div class="invalid-feedback">
																		Se requiere una fecha de clase válida.
																	</div>
																</div>
															</div>
														</div>

													</div>

													<div class="col-xl-6 col-md-6 col-sm-6">

														<div class="form-group">
															<div class="row">
																<label class="col-lg-12 required-field" for="cupo">Cupo de clase</label>
																<div class="col-lg-12">
																	<input type="number" min="0" pattern="^[0-9]+" class="form-control" name="cupo" id="cupo" placeholder="Cupo de clase" value="<?php echo set_value('cupo') == false ? ($this->session->flashdata('cupo') ? $this->session->flashdata('cupo') : 20) : set_value('cupo'); ?>" required>
																	<div class="invalid-feedback">
																		Se requiere un cupo de clase válido.
																	</div>
																</div>
															</div>
														</div>

													</div>

													<div class="col-xl-6 col-md-6 col-sm-6">

														<div class="form-group">
															<div class="row">
																<label class="col-lg-12" for="distribucion_imagen">Locación <span class="red">*</span></label>
																<div class="col-lg-12">
																	<select id="distribucion_imagen" name="distribucion_imagen" class="form-control select2 custom-select" required>
																		<option value="<?php echo 'https://b3studio.mx/app_imgs/clases/clase-top-escenario.jpg'; ?>" selected <?php echo set_select('distribucion_imagen', 'https://b3studio.mx/app_imgs/clases/clase-top-escenario.jpg', set_value('distribucion_imagen') ? false : 'https://b3studio.mx/app_imgs/clases/clase-top-escenario.jpg' == $this->session->flashdata('distribucion_imagen')); ?>>Salón</option>
																		<option value="<?php echo 'https://b3studio.mx/app_imgs/clases/clase-top-playa.jpg'; ?>" <?php echo set_select('distribucion_imagen', 'https://b3studio.mx/app_imgs/clases/clase-top-playa.jpg', set_value('distribucion_imagen') ? false : 'https://b3studio.mx/app_imgs/clases/clase-top-playa.jpg' == $this->session->flashdata('distribucion_imagen')); ?>>Playa</option>
																		<option value="<?php echo 'https://b3studio.mx/app_imgs/clases/clase-top-rooftop.jpg'; ?>" <?php echo set_select('distribucion_imagen', 'https://b3studio.mx/app_imgs/clases/clase-top-rooftop.jpg', set_value('distribucion_imagen') ? false : 'https://b3studio.mx/app_imgs/clases/clase-top-rooftop.jpg' == $this->session->flashdata('distribucion_imagen')); ?>>RoofTop</option>
																	</select>
																	<div class="invalid-feedback">
																		Se requiere una locación válida.
																	</div>
																</div>
															</div>
														</div>

													</div>

													<div class="col-xl-6 col-md-6 col-sm-6">

														<div class="form-group">
															<div class="row">
																<label class="col-lg-12" for="distribucion_lugares">Distribución <span class="red">*</span></label>
																<div class="col-lg-12">
																	<select id="distribucion_lugares" name="distribucion_lugares" class="form-control select2 custom-select" required>
																		<option value="<?php echo 'child-2'; ?>" <?php echo set_select('distribucion_lugares', 'child-2', set_value('distribucion_lugares') ? false : 'child-2' == $this->session->flashdata('distribucion_lugares')); ?>>Fila de 2</option>
																		<option value="<?php echo 'child-3'; ?>" <?php echo set_select('distribucion_lugares', 'child-3', set_value('distribucion_lugares') ? false : 'child-3' == $this->session->flashdata('distribucion_lugares')); ?>>Fila de 3</option>
																		<option value="<?php echo 'child-4'; ?>" <?php echo set_select('distribucion_lugares', 'child-4', set_value('distribucion_lugares') ? false : 'child-4' == $this->session->flashdata('distribucion_lugares')); ?>>Fila de 4</option>
																		<option value="<?php echo 'child-5'; ?>" <?php echo set_select('distribucion_lugares', 'child-5', set_value('distribucion_lugares') ? false : 'child-5' == $this->session->flashdata('distribucion_lugares')); ?>>Fila de 5</option>
																		<option value="<?php echo 'child-6'; ?>" <?php echo set_select('distribucion_lugares', 'child-6', set_value('distribucion_lugares') ? false : 'child-6' == $this->session->flashdata('distribucion_lugares')); ?>>Fila de 6</option>
																		<option value="<?php echo 'child-7'; ?>" <?php echo set_select('distribucion_lugares', 'child-7', set_value('distribucion_lugares') ? false : 'child-7' == $this->session->flashdata('distribucion_lugares')); ?>>Fila de 7</option>
																		<option value="<?php echo 'child-8'; ?>" <?php echo set_select('distribucion_lugares', 'child-8', set_value('distribucion_lugares') ? false : 'child-8' == $this->session->flashdata('distribucion_lugares')); ?>>Fila de 8</option>
																		<option value="<?php echo 'child-9'; ?>" <?php echo set_select('distribucion_lugares', 'child-9', set_value('distribucion_lugares') ? false : 'child-9' == $this->session->flashdata('distribucion_lugares')); ?>>Fila de 9</option>
																		<option value="<?php echo 'child-10'; ?>" selected <?php echo set_select('distribucion_lugares', 'child-10', set_value('distribucion_lugares') ? false : 'child-10' == $this->session->flashdata('distribucion_lugares')); ?>>Fila de 10</option>
																		<option value="<?php echo 'child-11'; ?>" <?php echo set_select('distribucion_lugares', 'child-11', set_value('distribucion_lugares') ? false : 'child-11' == $this->session->flashdata('distribucion_lugares')); ?>>Fila de 11</option>
																		<option value="<?php echo 'child-12'; ?>" <?php echo set_select('distribucion_lugares', 'child-12', set_value('distribucion_lugares') ? false : 'child-12' == $this->session->flashdata('distribucion_lugares')); ?>>Fila de 12</option>
																	</select>
																	<div class="invalid-feedback">
																		Se requiere una distribución válida.
																	</div>
																</div>
															</div>
														</div>

													</div>

													<div class="col-xl-6 col-md-6 col-sm-6">

														<div class="form-group">
															<div class="row">
																<label class="col-lg-12 required-field" for="intervalo_horas">No. de clases a consumir del plan</label>
																<div class="col-lg-12">
																	<input type="number" min="0" pattern="^[0-9]+" class="form-control" name="intervalo_horas" id="intervalo_horas" placeholder="No. de clases a consumir del plan" value="<?php echo set_value('intervalo_horas') == false ? ($this->session->flashdata('intervalo_horas') ? $this->session->flashdata('intervalo_horas') : 1) : set_value('intervalo_horas'); ?>" required>
																	<div class="invalid-feedback">
																		Se requiere un no. de clases a consumir del plan válido.
																	</div>
																</div>
															</div>
														</div>

													</div>

												</div>

											</div>

											<div class="row mt-3">
												<div class="col-12">
													<div class="form-group float-md-right">
														<a class="btn btn-outline-grey btn-outline-lighten-1 btn-min-width mr-1" href="<?php echo site_url($regresar_a); ?>"><i class="fa fa-arrow-circle-left"></i>&nbsp;Volver</a>
														<button class="btn btn-outline-secondary btn-min-width mr-1" type="submit">Guardar</button>
													</div>
												</div>
											</div>

											<?php echo form_close(); ?>

										</div>

									</div>

								</div>
							</div>

						</div>
					</div>
				</div>

			</section>
		</div>

	</div>
</div>