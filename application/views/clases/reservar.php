<div class="app-content container center-layout mt-2">
	<div class="content-wrapper">
		<div class="content-body">
			<section>
				<div class="row">
					<div class="col-12">
						<div class="card">
							<div class="card-header">
								<h4 class="card-title">Nuevo ventas</h4>
							</div>
							<div class="card-content">
								<div class="card-body">
									<div class="card-text">
										
									</div>
									<?php echo form_open('clases/reservar', array('class' => 'form form-horizontal', 'id' => 'forma-reservar-clase')); ?>
									<input type="hidden" name="id" value="<?php echo $clase_a_reservar->id; ?>">
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

										<h4 class="form-section">¿Quien reserva?</h4>

										<div class="row">
											<div class="col-md-6">
												<div class="form-group row">
													<label for="terminos_condiciones" class="col-md-3 label-control"><span class="red">*</span> Nombre de Cliente</label>
                                                    <div class="col-md-6">

														<input type="text" placeholder="Buscar" name="buscar" id="buscar" list="lista" class="form-control"/>
														<datalist name="lista" id="lista">
															<?php foreach ($usuarios->result() as $usuario): ?>
																<option value="<?php echo $usuario->id; ?>">
																	<?php echo $usuario->nombre_completo; ?> <?php echo $usuario->apellido_paterno; ?> <?php echo $usuario->apellido_materno; ?> | <?php echo $usuario->correo; ?>
																</option>
															<?php endforeach;?>
														</datalist>
                                                        
														<select name="usuario_id" id="usuario_id" class="form-control">
															<option value="">Seleccione el Usuario</option>
															<?php foreach ($usuarios->result() as $usuario): ?>
																<option value="<?php echo $usuario->id; ?>" <?php echo set_select('usuario_id', $usuario->id); ?>>
																	<?php echo $usuario->id; ?> -- <?php echo $usuario->nombre_completo; ?> <?php echo $usuario->apellido_paterno; ?> <?php echo $usuario->apellido_materno; ?>
																</option>
															<?php endforeach;?>
														</select>
													</div>
												</div>
											</div>

											<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
											<script>
												$(document).on('change','#buscar', function() {
													var valor = $(this).val();//sacamos el valor del select
													var value = parseInt(valor);
													$('#usuario_id').val(value);
													$('#buscar').val('');
												});
											</script>

											<?php 
												$cupo_lugares = $clase_a_reservar->cupo_lugares;
												$cupo_lugares = json_decode($cupo_lugares);		
											?>
											<div class="col-md-6">
												<div class="form-group row">
													<label for="no_lugar" class="col-md-3 label-control"><span class="red">*</span> Lugar</label>
													<div class="col-md-6">
														<select name="no_lugar" id="no_lugar" class="form-control">
															<option value="">Seleccione el lugar disponible</option>
															<?php foreach ($cupo_lugares as $lugar): ?>
																<?php if(!$lugar->esta_reservado):?>
																	<option value="<?php echo $lugar->no_lugar; ?>" <?php echo set_select('no_lugar', $lugar->no_lugar); ?>>
																		<?php echo 'Lugar: '.$lugar->no_lugar; ?>
																	</option>
																<?php endif;?>
															<?php endforeach;?>
														</select>
													</div>
												</div>
											</div>
										</div>

										<input type="hidden" name="clase_id" id="clase_id" class="form-control" value="<?php echo $clase_a_reservar->id ?>" readonly>

                                        <h4 class="form-section">Datos de la clase a reservar</h4>
                                        
                                        <div class="row">

											<div class="col-md-6">
													<label for="identificador" class="label-control">Identificador de clase:</label>
                                                    <h3><?php echo $clase_a_reservar->identificador ?></h3>

													<label for="disciplina" class="label-control">Disciplina de la clase:</label>
                                                    <h3><?php echo $clase_a_reservar->disciplina ?></h3>

													<label for="instructor" class="label-control">Instructor:</label>
                                                    <h3><?php echo $clase_a_reservar->usuario ?></h3>			
													
													<label for="dificultad" class="label-control">Dificultad:</label>
                                                    <h3><?php echo $clase_a_reservar->dificultad ?></h3>													
													<label for="identificador" class="label-control">Hora de inicio:</label>
                                                    <h3><?php echo $clase_a_reservar->inicia ?></h3>			

													<label for="identificador" class="label-control">Intervalo de horas: <br>(Estas son las horas o clases que consumirá del plan)</label>
                                                    <h3><?php echo $clase_a_reservar->intervalo_horas ?></h3>						
													
												</div>												

                                            <div class="col-md-6">

											<div class="row">

											<div class="col-sm-4">
											<label for="identificador" class="label-control">Cupos restantes:</label>
                                                    <h3><?php echo $clase_a_reservar->cupo - $clase_a_reservar->reservado ?></h3>
													</div>

													<div class="col-sm-4">					
													<label for="identificador" class="label-control">Cupo original:</label>
                                                    <h3><?php echo $clase_a_reservar->cupo ?></h3>
													</div>

													<div class="col-sm-4">				
													<label for="identificador" class="label-control">Cupos reservados:</label>
                                                    <h3><?php echo $clase_a_reservar->reservado ?></h3>
													</div>
												</div>

												
											<div class="row">
											<div class="col-sm-12">
                                                <label for="identificador" class="label-control">Lugares:</label>
                                                <p><strong><?php 
                                                    $i=0;
                                                    foreach ($cupo_lugares as $lugar) {
                                                        $i++;
                                                        foreach ($usuarios->result() as $usuario){
                                                            if ($lugar->nombre_usuario == $usuario->id) {
                                                                echo $i. ' - Lugar: '.$lugar->no_lugar.' |  Cliente: '.$lugar->nombre_usuario.' - '.$usuario->nombre_completo.' '.$usuario->apellido_paterno.' '.$usuario->apellido_materno;
                                                                echo '<br>';
                                                            }
                                                        }
                                                        if (!is_numeric($lugar->nombre_usuario)) {
                                                            echo $i. ' - Lugar: '.$lugar->no_lugar.' |  Cliente: '.$lugar->nombre_usuario;
                                                            echo '<br>';
                                                        }
                                                    }
                                                ?></strong></p>	
											</div>
											</div>
																							
											</div>
                                        </div> 

									
										<div class="form-actions right">
											<a href="<?php echo site_url('clases/reservar'); ?>" class="btn btn-secondary btn-sm">Cancelar</a>
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
