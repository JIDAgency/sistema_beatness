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
										<?php if (validation_errors()): ?>
										<div class="alert bg-danger alert-icon-left alert-dismissible mb-2 font-small-3" role="alert">
											<span class="alert-icon"><i class="fa fa-thumbs-o-down"></i></span>
											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
												<span aria-hidden="true">×</span>
											</button>
											<?php echo validation_errors(); ?>
										</div>
										<?php endif?>
										<h4 class="form-section">Datos de la clase</h4>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group row">
													<label for="identificador" class="col-md-3 label-control"><span class="red">*</span> Identificador único</label>
													<div class="col-md-9">
														<input type="text" id="myInput" readonly="true" class="form-control" name="identificador" placeholder="Identificador" value="<?php echo set_value('identificador') == false ? $clase_a_editar->identificador : set_value('identificador'); ?>">
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group row">
													<label for="terminos_condiciones" class="col-md-3 label-control"><span class="red">*</span> Disciplina
														para la clase</label>
													<div class="col-md-9">
														<select id="mySelect" name="disciplina_id" class="form-control">
															<option value="">Seleccione la disciplina</option>
															<?php foreach ($disciplinas->result() as $disciplina): ?>
																<?php if ($disciplina->id != 1): ?>
																	<option value="<?php echo $disciplina->id; ?>" <?php echo set_select('disciplina_id', $clase_a_editar->disciplina_id,
																		set_value('disciplina_id') ? false : $disciplina->id == $clase_a_editar->disciplina_id); ?>>
																		<?php echo $disciplina->nombre; ?>
																	</option>
																<?php endif;?>
															<?php endforeach;?>
														</select>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group row">
													<label for="terminos_condiciones" class="col-md-3 label-control"><span class="red">*</span> Instructor
														para la clase</label>
													<div class="col-md-9">
														<select id="mySelect2" name="instructor_id" class="form-control">
															<option value="">Seleccione el instructor de esta clase</option>
															<?php foreach ($instructores->result() as $instructor): ?>
																<option value="<?php echo $instructor->id; ?>" <?php echo set_select('instructor_id', $clase_a_editar->id,
																	set_value('instructor_id') ? false : $instructor->id == $clase_a_editar->instructor_id); ?>>
																	<?php echo $instructor->nombre_completo .' ' . $instructor->apellido_paterno .' ' . $instructor->apellido_materno; ?>
																</option>
															<?php endforeach;?>
														</select>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group row">
													<label for="inicia" class="col-md-3 label-control"><span class="red">*</span> Fecha y hora de inicio</label>
													<div class="col-md-5">
														<input type="date" id="mySelect3" name="inicia_date" class="form-control" placeholder="Indique la fecha"
														 value="<?php echo set_value('inicia') == false ? date('Y-m-d', strtotime($clase_a_editar->inicia)) : date('Y-m-d', strtotime(set_value('inicia'))); ?>">
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
													<label for="clases_incluidas" class="col-md-3 label-control"><span class="red">*</span> Seleccione la
														dificultad</label>
													<div class="col-md-9">
														<select name="dificultad" class="form-control">
															<option value="">Seleccione la dificultad</option>
															<option value="Outdoor Ride" <?php echo set_select('dificultad', 'Outdoor Ride' ); ?>>Outdoor Ride</option>
															<option value="Theme Ride" <?php echo set_select('dificultad', 'Theme Ride' ); ?>>Theme Ride</option>
															<option value="Double Ride" <?php echo set_select('dificultad', 'Double Ride' ); ?>>Double Ride</option>
															<option value="Upper Body" <?php echo set_select('dificultad', 'Upper Body' ); ?>>Upper Body</option>
															<option value="Lower Body" <?php echo set_select('dificultad', 'Lower Body' ); ?>>Lower Body</option>
															<option value="Full Body" <?php echo set_select('dificultad', 'Full Body' ); ?>>Full Body</option>
															<option value="High Performance" <?php echo set_select('dificultad', 'High Performance' ); ?>>High Performance</option>
															<option value="Ball" <?php echo set_select('dificultad', 'Ball' ); ?>>Ball</option>
															<option value="Stick" <?php echo set_select('dificultad', 'Stick' ); ?>>Stick</option>
															<option value="Resistance Bands" <?php echo set_select('dificultad', 'Resistance Bands' ); ?>>Resistance Bands</option>
															<option value="All in One" <?php echo set_select('dificultad', 'All in One' ); ?>>All in One</option>
															<option value="Básico" <?php echo set_select('dificultad', 'Básico' ); ?>>Básico</option>
															<option value="Intermedio" <?php echo set_select('dificultad', 'Intermedio' ); ?>>Intermedio</option>
															<option value="Avanzado" <?php echo set_select('dificultad', 'Avanzado' ); ?>>Avanzado</option>
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
													<div class="col-md-5">
													    <label>(Por el momento el cambio del cupo no esta disponible)</label>
													</div>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-6">
												<div class="form-group row">
													<label for="intervalo_horas" class="col-md-3 label-control"><span class="red">*</span> Duración de la
														clase en horas</label>
													<div class="col-md-4">
														<input type="number" min="0" pattern="^[0-9]+" name="intervalo_horas" class="form-control" placeholder="Intervalo en horas" value="<?php echo set_value('intervalo_horas') == false ? $clase_a_editar->intervalo_horas : set_value('intervalo_horas'); ?>">
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
										var troll = "<?php echo $clase_a_editar->identificador ?>";
										var valor = troll.substr(0,2);
										var valor2 = troll.substr(2,3);
										var valor3 = troll.substr(5,8);
										var valor4 = troll.substr(13);
										console.log(valor);
										console.log(valor2);
										console.log(valor3);
										console.log(valor4);
										var ids = "#";
										$(function(){
											$(document).on('keyup keypress blur change','#mySelect',function(){ //detectamos el evento change
												valor = $(this).val();//sacamos el valor del select
												if (valor == "2") {
													valor = "BK";
												}if(valor == "3") {
													valor = "BX";
												}if(valor == "4") {
													valor = "BD";
												}
												ids = valor+valor2+valor3+valor4;
											$('#myInput').val(ids);//le agregamos el valor al input (notese que el input debe tener un ID para que le caiga el valor)
											});
											$(document).on('keyup keypress blur change','#mySelect2',function(){ //detectamos el evento change
												valor2 = $(this).children("option").filter(":selected").text();//sacamos el valor del select
												valor2 = valor2.replace(/(á|é|í|ó|ú|ñ|ä|ë|ï|ö|\.|ü)/gi,'');
												valor2 = valor2.replace(/[A-Za-z]+/g, function(match){ return (match.trim()[0]);}).toUpperCase(); 
												valor2 = valor2.replace(/\s/g, '');

											ids = valor+valor2+valor3+valor4;
											$('#myInput').val(ids);//le agregamos el valor al input (notese que el input debe tener un ID para que le caiga el valor)
											});
											$(document).on('keyup keypress blur change','#mySelect3',function(){ //detectamos el evento change
												valor3 = $(this).val();//sacamos el valor del select
												valor3 = valor3.replace(/\D/g,'');
												ids = valor+valor2+valor3+valor4;
											$('#myInput').val(ids);//le agregamos el valor al input (notese que el input debe tener un ID para que le caiga el valor)
											});
											$(document).on('keyup keypress blur change','#mySelect4',function(){ //detectamos el evento change
												valor4 = $(this).val();//sacamos el valor del select
												valor4 = valor4.replace(/\D/g,'');
												ids = valor+valor2+valor3+valor4;
											$('#myInput').val(ids);//le agregamos el valor al input (notese que el input debe tener un ID para que le caiga el valor)
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
