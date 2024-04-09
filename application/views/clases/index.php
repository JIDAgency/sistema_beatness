<div class="app-content content center-layout mt-2">
	<div class="content-wrapper">
		<div class="content-header row">
			<div class="content-header-left col-md-6 col-12 mb-2">
				<div class="row breadcrumbs-top">
					<div class="breadcrumb-wrapper col-12">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php echo site_url('inicio/index') ?>">Inicio</a></li>
							<li class="breadcrumb-item active">Clases</li>
						</ol>
					</div>
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
									<h4 class="card-title">Clases disponibles</h4>
									<div class="heading-elements">
										<a href="<?php echo site_url('clases/crear') ?>" class="btn btn-secondary btn-sm">
											<i class="ft-plus white"></i> Nueva clase
										</a>
										<!--a href="<?php //echo site_url('clases/generar_horarios_ionic') 
													?>" class="btn btn-secondary btn-sm">
										<i class="ft-plus white"></i> Generar horas bonitas
									</a-->
									</div>
								</div>
								<div class="card-content p_dt">
									<div class="card-body">
										<?php $this->load->view('_comun/mensajes_alerta'); ?>
										<table id="table" class="table display nowrap table-striped table-bordered scroll-horizontal table-hover">
											<thead>
												<tr>
													<th>ID</th>
													<th>SKU</th>
													<th>Disciplina</th>
													<th>Cupo</th>
													<th>Sucursal</th>
													<th>Instructor</th>
													<th>Dificultad</th>
													<th>Horario</th>
													<th>Horario</th>
													<th>Estatus</th>
													<th>N. Horas</th>
													<th>Cupo restantes</th>
													<th>Cupo original</th>
													<th>Cupos reservados</th>
													<th>Inasistencias</th>
													<th>Lugares</th>
													<th>Opciones</th>
												</tr>
											</thead>
											<tbody>
												<!-- <?php foreach ($clases->result() as $clase) : $i = 0; ?>
													<tr>
														<td>
															<?php echo $clase->id; ?>
														</td>
														<td>
															<?php echo $clase->identificador; ?>
														</td>
														<td>
															<?php echo $clase->subdisciplina_id != 0 ? $clase->disciplina_nombre . ' | ' . $clase->disciplina_nombre . ' GODIN' : $clase->disciplina_nombre; ?>
														</td>
														<td>
															<?php echo $clase->cupo; ?>
														</td>
														<td>
															<?php echo $clase->sucursal_nombre . ' [' . $clase->sucursal_locacion . ']'; ?>
														</td>
														<td>
															<?php echo $clase->instructor_nombre; ?>
														</td>
														<td>
															<?php echo $clase->dificultad; ?>
														</td>
														<td>
															<?php echo $clase->inicia; ?>
														</td>
														<td>
															<?php
															setlocale(LC_ALL, "es_ES");
															$fecha = strtotime($clase->inicia);
															$fecha_espaniol = strftime("%d de %B del %Y<br>%T", $fecha);
															echo ucfirst($fecha_espaniol);
															?>
														</td>
														<td>
															<?php echo $clase->estatus ?>
														</td>
														<td>
															<?php if ($clase->intervalo_horas != 1) : ?>
																<?php echo $clase->intervalo_horas . " hrs."; ?>
															<?php else : ?>
																<?php echo $clase->intervalo_horas . " hr."; ?>
															<?php endif; ?>
														</td>
														<td>
															<?php echo $clase->cupo - $clase->reservado; ?>
														</td>
														<td>
															<?php echo $clase->cupo; ?>
														</td>
														<td>
															<?php echo $clase->reservado; ?>
														</td>
														<td>
															<?php echo $clase->inasistencias; ?>
														</td>
														<td>
															<?php
															$cupo_lugares = $clase->cupo_lugares;
															$cupo_lugares = json_decode($cupo_lugares);
															echo '<br>';
															foreach ($cupo_lugares as $lugar) {
																if ($lugar->nombre_usuario) {
																	$i++;
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
																}
															}
															?>
														</td>
														<td>
															<?php if ($clase->estatus != 'Cancelada') : ?>
																<?php
																$fecha_de_clase = $clase->inicia;
																$fecha_limite_de_clase = strtotime('+48 hours', strtotime($fecha_de_clase));

																if (strtotime('now') < $fecha_limite_de_clase) {
																	echo '<br>';
																	echo anchor('clases/reservar/' . $clase->id, 'Reservar');
																}
																?>

																<?php
																echo '<br>';
																echo anchor('clases/editar/' . $clase->id, 'Editar');
																?>
															<?php endif; ?>
															<?php if ($clase->reservado == 0 and $clase->estatus == 'Activa') : ?>
																<?php
																echo '<br>';
																echo anchor('clases/cancelar/' . $clase->id, '<span class="red">Cancelar</span>');
																?>
																<?php
																echo '<br>';
																echo anchor('clases/borrar/' . $clase->id, '<span class="red">Borrar</span>');
																?>
															<?php endif; ?>
														</td>
													</tr>
												<?php endforeach; ?> -->
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
	</div>
</div>