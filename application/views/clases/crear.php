<div class="app-content container center-layout mt-2">
	<div class="content-header-left col-md-6 col-12 mb-2">
		<div class="row breadcrumbs-top">
			<div class="breadcrumb-wrapper col-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo site_url('inicio/index') ?>">Inicio</a>
					</li>
					<li class="breadcrumb-item"><a href="<?php echo site_url('clases/index') ?>">Clases</a>
					</li>
					<li class="breadcrumb-item active">Crear nueva clase
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
								<h4 class="card-title">Nueva clase</h4>
							</div>
							<div class="card-content">
								<div class="card-body">
									<?php echo form_open('clases/crear', array('class' => 'form form-horizontal', 'id' => 'forma-crear-clase')); ?>
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
											<div class="col-md-6">
												<div class="form-group row">
													<label for="terminos_condiciones" class="col-md-3 label-control"><span class="red">*</span> Disciplina
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
											<div class="col-md-6">
												<div class="form-group row">
													<label for="terminos_condiciones" class="col-md-3 label-control"><span class="red">*</span> Instructor
														para la clase</label>
													<div class="col-md-9">
														<select id="mySelect2" name="instructor_id" class="select2 form-control info">
															<option value="">Seleccione el instructor de esta clase</option>
															<?php foreach ($instructores->result() as $instructor) : ?>
																<option value="<?php echo $instructor->id; ?>" <?php echo set_select('instructor_id', $instructor->id); ?>>
																	<?php echo $instructor->nombre_completo . ' ' . $instructor->apellido_paterno . ' ' . $instructor->apellido_materno; ?>
																</option>
															<?php endforeach; ?>
														</select>
													</div>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-6">
												<div class="form-group row">
													<label for="inicia" class="col-md-3 label-control"><span class="red">*</span> Fecha y hora de inicio</label>
													<div class="col-md-5">
														<input type="date" id="mySelect3" name="inicia_date" class="form-control" placeholder="Indique la fecha" value="<?php echo set_value('inicia_date') == false ? date('Y-m-d') : set_value('inicia_date'); ?>">
													</div>
													<div class="col-md-4">
														<input type="time" id="mySelect4" name="inicia_time" class="form-control" placeholder="Indique la hora" value="<?php echo set_value('inicia_time') == false ? date('H:i') : set_value('inicia_time'); ?>">
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group row">
													<label for="clases_incluidas" class="col-md-3 label-control"><span class="red">*</span> Seleccione la
														dificultad</label>
													<div class="col-md-9">
														<select name="dificultad" class="form-control">
															<option value="" <?php echo set_select('dificultad', '', set_value('dificultad') ? false : '' == $this->session->flashdata('dificultad')); ?>>Seleccione una dificultad…</option>
															<?php foreach (select_dificultad() as $mostrar_key => $mostrar_row) : ?>
																<option value="<?php echo $mostrar_row->valor; ?>" <?php echo $mostrar_row->activo == false ? '' : 'selected'; ?> <?php echo set_select('dificultad', $mostrar_row->valor, set_value('dificultad') ? false : $mostrar_row->valor == $this->session->flashdata('dificultad')); ?>><?php echo trim($mostrar_row->nombre); ?></option>
															<?php endforeach; ?>
														</select>
													</div>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-6">
												<div class="form-group row">
													<label for="cupo" class="col-md-3 label-control"><span class="red">*</span> Cupo</label>
													<div class="col-md-4">
														<input type="number" min="0" pattern="^[0-9]+" class="form-control" name="cupo" placeholder="Cupo" value="<?php echo set_value('cupo') == false ? 20 : set_value('cupo'); ?>">
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group row">
													<label for="distribucion_imagen" class="col-md-3 label-control"><span class="red">*</span> Seleccione una locación de clase</label>
													<div class="col-md-9">
														<select name="distribucion_imagen" class="form-control">
															<option value="">Seleccione una locación de clase...</option>
															<option value="https://b3studio.mx/app_imgs/clases/clase-top-escenario.jpg" selected>Salon</option>
															<option value="https://b3studio.mx/app_imgs/clases/clase-top-playa.jpg">Playa</option>
															<option value="https://b3studio.mx/app_imgs/clases/clase-top-rooftop.jpg">RoofTop</option>
														</select>
													</div>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-6">
												<div class="form-group row">
													<label for="distribucion_lugares" class="col-md-3 label-control"><span class="red">*</span> Seleccione la distribución de lugares por fila...</label>
													<div class="col-md-9">
														<select name="distribucion_lugares" class="form-control">
															<option value="">Seleccione la distribución de lugares por fila...</option>
															<option value="child-2">2</option>
															<option value="child-3">3</option>
															<option value="child-4">4</option>
															<option value="child-5">5</option>
															<option value="child-6">6</option>
															<option value="child-7">7</option>
															<option value="child-8">8</option>
															<option value="child-9">9</option>
															<option value="child-10" selected>10</option>
															<option value="child-11">11</option>
															<option value="child-12">12</option>
														</select>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group row">
													<label for="intervalo_horas" class="col-md-3 label-control"><span class="red">*</span> Clases a consumir del plan</label>
													<div class="col-md-4">
														<input type="number" min="0" pattern="^[0-9]+" name="intervalo_horas" class="form-control" placeholder="Clases a consumir" value="<?php echo set_value('intervalo_horas') == false ? 1 : set_value('intervalo_horas'); ?>">
													</div>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-6">
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

									<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

									<script>
										var valor = "#";
										var valor2 = "#";
										var valor3 = "#";
										var valor4 = "#";
										var ids = "#";
										var numero = "#";
										$(function() {
											$(document).on('keyup keypress blur change', '#mySelect', function() { //detectamos el evento change
												valor = $(this).val(); //sacamos el valor del select
												if (valor == "2") {
													valor = "BK";
												}
												if (valor == "3") {
													valor = "BX";
												}
												if (valor == "4") {
													valor = "BD";
												}
												if (valor == "5") {
													valor = "BKG";
												}
												if (valor == "6") {
													valor = "BXG";
												}
												if (valor == "7") {
													valor = "BDG";
												}
												ids = valor + valor2 + valor3 + valor4;
												$('#myInput').val(ids); //le agregamos el valor al input (notese que el input debe tener un ID para que le caiga el valor)
											});
											$(document).on('keyup keypress blur change', '#mySelect2', function() { //detectamos el evento change
												valor2 = $(this).children("option").filter(":selected").text(); //sacamos el valor del select
												valor2 = valor2.replace(/(á|é|í|ó|ú|ñ|ä|ë|ï|ö|\.|ü)/gi, '');
												valor2 = valor2.replace(/[A-Za-z]+/g, function(match) {
													return (match.trim()[0]);
												}).toUpperCase();
												valor2 = valor2.replace(/\s/g, '')

												ids = valor + valor2 + valor3 + valor4;
												$('#myInput').val(ids); //le agregamos el valor al input (notese que el input debe tener un ID para que le caiga el valor)
											});

											$(document).on('keyup keypress blur change', '#mySelect3', function() { //detectamos el evento change
												valor3 = $(this).val(); //sacamos el valor del select
												valor3 = valor3.replace(/\D/g, '');
												ids = valor + valor2 + valor3 + valor4;
												numero = valor3 + valor4;
												$('#myInput').val(ids); //le agregamos el valor al input (notese que el input debe tener un ID para que le caiga el valor)
												$('#inicia_numero').val(numero);
											});
											$(document).on('keyup keypress blur change', '#mySelect4', function() { //detectamos el evento change
												valor4 = $(this).val(); //sacamos el valor del select
												valor4 = valor4.replace(/\D/g, '');
												ids = valor + valor2 + valor3 + valor4;
												numero = valor3 + valor4;
												$('#myInput').val(ids); //le agregamos el valor al input (notese que el input debe tener un ID para que le caiga el valor)
												$('#inicia_numero').val(numero);
											});
										});
									</script>

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