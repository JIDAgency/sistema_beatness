<div class="app-content container center-layout mt-2">
	<div class="content-header-left col-md-6 col-12 mb-2">
		<div class="row breadcrumbs-top">
			<div class="breadcrumb-wrapper col-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo site_url('inicio/index') ?>">Inicio</a>
					</li>
					<li class="breadcrumb-item"><a href="<?php echo site_url('clases/index') ?>">Clases</a>
					</li>
					<li class="breadcrumb-item active">Editar clase
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
								<h4 class="card-title">Editar clase</h4>
							</div>
							<div class="card-content">
								<div class="card-body">
									<?php echo form_open('clases/editar', array('class' => 'form form-horizontal', 'id' => 'forma-editar-clase')); ?>
									<input type="hidden" name="id" value="<?php echo $clase_a_editar->id; ?>">
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
										<?php $this->load->view('_comun/mensajes_alerta'); ?>
										<h4 class="form-section">Datos de la clase</h4>
										<div class="row">
											<input type="hidden" readonly="true" id="identificador" class="form-control" name="identificador" placeholder="Identificador" value="<?php echo set_value('identificador'); ?>">
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group row">
													<label for="terminos_condiciones" class="col-md-3 label-control"><span class="red">*</span> Instructor
														para la clase</label>
													<div class="col-md-9">
														<select id="mySelect2" name="instructor_id" class="select2 form-control info">
															<option value="">Seleccione el instructor de esta clase</option>
															<?php foreach ($instructores->result() as $instructor) : ?>
																<option value="<?php echo $instructor->id; ?>" <?php echo set_select(
																													'instructor_id',
																													$clase_a_editar->id,
																													set_value('instructor_id') ? false : $instructor->id == $clase_a_editar->instructor_id
																												); ?>>
																	<?php echo $instructor->nombre_completo . ' ' . $instructor->apellido_paterno . ' ' . $instructor->apellido_materno; ?>
																</option>
															<?php endforeach; ?>
														</select>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group row">
													<label for="inicia" class="col-md-3 label-control"><span class="red">*</span> Fecha y hora de inicio</label>
													<div class="col-md-5">
														<input type="date" id="mySelect3" name="inicia_date" class="form-control" placeholder="Indique la fecha" value="<?php echo set_value('inicia') == false ? date('Y-m-d', strtotime($clase_a_editar->inicia)) : date('Y-m-d', strtotime(set_value('inicia'))); ?>">
													</div>
													<div class="col-md-4">
														<input type="time" id="mySelect4" name="inicia_time" class="form-control" value="<?php echo set_value('inicia') == false ? date('H:i', strtotime($clase_a_editar->inicia)) : date('H:i', strtotime(set_value('inicia'))); ?>">
													</div>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-6">
												<div class="form-group row">
													<label for="dificultad" class="col-md-3 label-control"><span class="red">*</span> Seleccione la
														dificultad</label>
													<div class="col-md-9">
														<select name="dificultad" class="form-control">
															<option value="" <?php echo set_select('dificultad', '', set_value('dificultad') ? false : '' == (!empty($this->session->flashdata('dificultad')) ? $this->session->flashdata('dificultad') : (!empty($clase_a_editar->dificultad) ? $clase_a_editar->dificultad : set_value('dificultad')))); ?>>Seleccione una opcion…</option>
															<?php foreach (select_dificultad() as $key => $mostrar_row) : ?>
																<option value="<?php echo $mostrar_row->valor; ?>" <?php echo set_select('dificultad', $mostrar_row->valor, set_value('dificultad') ? false : $mostrar_row->valor == (!empty($this->session->flashdata('dificultad')) ? $this->session->flashdata('dificultad') : (!empty($clase_a_editar->dificultad) ? $clase_a_editar->dificultad : set_value('dificultad')))); ?>><?php echo trim($mostrar_row->nombre); ?></option>
															<?php endforeach; ?>
														</select>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group row">
													<label for="cupo" class="col-md-3 label-control"><span class="red">*</span> Cupo</label>
													<div class="col-md-4">
														<input type="number" readonly="true" min="0" pattern="^[0-9]+" class="form-control" name="cupo" placeholder="Cupo" value="<?php echo set_value('cupo') == false ? $clase_a_editar->cupo : set_value('cupo'); ?>">
													</div>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-6">
												<div class="form-group row">
													<label for="distribucion_imagen" class="col-md-3 label-control"><span class="red">*</span> Seleccione una locación de clase</label>
													<div class="col-md-9">
														<select name="distribucion_imagen" class="form-control">
															<option value="">Seleccione una locación de clase...</option>
															<option value="https://b3studio.mx/app_imgs/clases/clase-top-escenario.jpg" <?php echo set_select('distribucion_imagen', 'https://b3studio.mx/app_imgs/clases/clase-top-escenario.jpg', set_value('distribucion_imagen') ? false : 'https://b3studio.mx/app_imgs/clases/clase-top-escenario.jpg' == $clase_a_editar->distribucion_imagen); ?>>Salon</option>
															<option value="https://b3studio.mx/app_imgs/clases/clase-top-playa.jpg" <?php echo set_select('distribucion_imagen', 'https://b3studio.mx/app_imgs/clases/clase-top-playa.jpg', set_value('distribucion_imagen') ? false : 'https://b3studio.mx/app_imgs/clases/clase-top-playa.jpg' == $clase_a_editar->distribucion_imagen); ?>>Playa</option>
															<option value="https://b3studio.mx/app_imgs/clases/clase-top-rooftop.jpg" <?php echo set_select('distribucion_imagen', 'https://www.b3studio.mx/app_imgs/clases/clase-top-rooftop.jpg', set_value('distribucion_imagen') ? false : 'https://www.b3studio.mx/app_imgs/clases/clase-top-rooftop.jpg' == $clase_a_editar->distribucion_imagen); ?>>RoofTop</option>
														</select>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group row">
													<label for="distribucion_lugares" class="col-md-3 label-control"><span class="red">*</span> Seleccione la distribución de lugares por fila...</label>
													<div class="col-md-9">
														<select name="distribucion_lugares" class="form-control">
															<option value="">Seleccione la distribución de lugares por fila...</option>
															<option value="child-2" <?php echo set_select('distribucion_lugares', 'child-2', set_value('distribucion_lugares') ? false : 'child-2' == $clase_a_editar->distribucion_lugares); ?>>2</option>
															<option value="child-3" <?php echo set_select('distribucion_lugares', 'child-3', set_value('distribucion_lugares') ? false : 'child-3' == $clase_a_editar->distribucion_lugares); ?>>3</option>
															<option value="child-4" <?php echo set_select('distribucion_lugares', 'child-4', set_value('distribucion_lugares') ? false : 'child-4' == $clase_a_editar->distribucion_lugares); ?>>4</option>
															<option value="child-5" <?php echo set_select('distribucion_lugares', 'child-5', set_value('distribucion_lugares') ? false : 'child-5' == $clase_a_editar->distribucion_lugares); ?>>5</option>
															<option value="child-6" <?php echo set_select('distribucion_lugares', 'child-6', set_value('distribucion_lugares') ? false : 'child-6' == $clase_a_editar->distribucion_lugares); ?>>6</option>
															<option value="child-7" <?php echo set_select('distribucion_lugares', 'child-7', set_value('distribucion_lugares') ? false : 'child-7' == $clase_a_editar->distribucion_lugares); ?>>7</option>
															<option value="child-8" <?php echo set_select('distribucion_lugares', 'child-8', set_value('distribucion_lugares') ? false : 'child-8' == $clase_a_editar->distribucion_lugares); ?>>8</option>
															<option value="child-9" <?php echo set_select('distribucion_lugares', 'child-9', set_value('distribucion_lugares') ? false : 'child-9' == $clase_a_editar->distribucion_lugares); ?>>9</option>
															<option value="child-10" <?php echo set_select('distribucion_lugares', 'child-10', set_value('distribucion_lugares') ? false : 'child-10' == $clase_a_editar->distribucion_lugares); ?>>10</option>
															<option value="child-11" <?php echo set_select('distribucion_lugares', 'child-11', set_value('distribucion_lugares') ? false : 'child-11' == $clase_a_editar->distribucion_lugares); ?>>11</option>
															<option value="child-12" <?php echo set_select('distribucion_lugares', 'child-12', set_value('distribucion_lugares') ? false : 'child-12' == $clase_a_editar->distribucion_lugares); ?>>12</option>
														</select>
													</div>
												</div>
											</div>
										</div>

										<div class="row mb-3">
											<div class="col-md-6">
												<div class="form-group row">
													<label for="intervalo_horas" class="col-md-3 label-control"><span class="red">*</span> Clases a consumir del plan</label>
													<div class="col-md-4">
														<input type="number" min="0" pattern="^[0-9]+" name="intervalo_horas" class="form-control" placeholder="Clases a consumir" value="<?php echo set_value('intervalo_horas') == false ? $clase_a_editar->intervalo_horas : set_value('intervalo_horas'); ?>">
													</div>
												</div>
											</div>
											<div>
												<?php
												$cupo_lugares = json_decode($clase_a_editar->cupo_lugares);
												echo '<br>';
												$i = 0;
												foreach ($cupo_lugares as $lugar) {
													$i++;
													if ($lugar->nombre_usuario) {

														foreach ($usuarios->result() as $usuario) {
															if ($lugar->nombre_usuario == $usuario->id) {
																echo $i . ' - Lugar: ' . $lugar->no_lugar . ' |  Cliente: ' . $lugar->nombre_usuario . ' - ' . $usuario->nombre_completo . ' ' . $usuario->apellido_paterno . ' ' . $usuario->apellido_materno;
																echo '<br>';
															}
														}
														if (!is_numeric($lugar->nombre_usuario)) {
															echo $i . ' - Lugar: ' . $lugar->no_lugar . ' |  Cliente: ' . $lugar->nombre_usuario;
															echo '<br>';
														}
													} else {
														echo $i . ' - Lugar: ' . $lugar->no_lugar . ' |  Cliente: ';
														echo '<br>';
													}
												}
												?>
											</div>
										</div>

										<div class="row">
											<div class="col-md-6">
											</div>
											<div class="col-md-6">
												<a href="<?php echo site_url('clases/agregar_cupo/' . $clase_a_editar->id); ?>" class="btn btn-secondary float-right btn-sm">Agregar un cupo</a>
											</div>
										</div>

										<div class="form-actions right">
											<a href="<?php echo site_url('clases/index'); ?>" class="btn btn-secondary btn-sm">Cancelar</a>
											<button type="submit" class="btn btn-secondary btn-sm">Guardar</button>
										</div>

									</div>

									<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
									<script>
										var troll = "<?php echo $clase_a_editar->identificador ?>";
										var valor = troll.substr(0, 2);
										var valor2 = troll.substr(2, 3);
										var valor3 = troll.substr(5, 8);
										var valor4 = troll.substr(13);
										console.log(valor);
										console.log(valor2);
										console.log(valor3);
										console.log(valor4);
										var ids = "#";
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
												valor2 = valor2.replace(/\s/g, '');

												ids = valor + valor2 + valor3 + valor4;
												$('#myInput').val(ids); //le agregamos el valor al input (notese que el input debe tener un ID para que le caiga el valor)
											});
											$(document).on('keyup keypress blur change', '#mySelect3', function() { //detectamos el evento change
												valor3 = $(this).val(); //sacamos el valor del select
												valor3 = valor3.replace(/\D/g, '');
												ids = valor + valor2 + valor3 + valor4;
												$('#myInput').val(ids); //le agregamos el valor al input (notese que el input debe tener un ID para que le caiga el valor)
											});
											$(document).on('keyup keypress blur change', '#mySelect4', function() { //detectamos el evento change
												valor4 = $(this).val(); //sacamos el valor del select
												valor4 = valor4.replace(/\D/g, '');
												ids = valor + valor2 + valor3 + valor4;
												$('#myInput').val(ids); //le agregamos el valor al input (notese que el input debe tener un ID para que le caiga el valor)
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