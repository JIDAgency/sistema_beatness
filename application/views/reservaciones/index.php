<div class="app-content content center-layout mt-2">
	<div class="content-wrapper">
		<div class="conten-header row">
			<div class="content-header-left col-md-6 col-12 mb-2">
				<div class="row breadcrumbs-top">
					<div class="breadcrumb-wrapper col-12">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php echo site_url('inicio/index') ?>">Inicio</a>
							</li>
							<li class="breadcrumb-item active">Reservaciones
							</li>
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
									<h4 class="card-title">Reservaciones</h4>
									<div class="heading-elements">
									</div>
								</div>
								<div class="card-content p_dt">
									<div class="card-body">
										<?php $this->load->view('_comun/mensajes_alerta'); ?>
										<table id="tabla-reservaciones" class="table display nowrap table-striped table-bordered scroll-horizontal table-hover">
											<thead>
												<tr>
													<th>ID</th>
													<th>Clase reservada</th>
													<th>ID + Plan usado</th>
													<th>ID + Cliente</th>
													<th>Disciplina</th>
													<th>Lugar</th>
													<th>Horario</th>
													<th>Opciones</th>
													<th>Fecha</th>
													<th>Asistencia</th>
													<th>Estatus</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($reservaciones->result() as $reservacion) : ?>
													<tr>
														<th scope="row">
															<?php echo $reservacion->id ?>
														</th>
														<td>
															<?php echo $reservacion->clase ?>-<?php echo $reservacion->usuario_id ?>
														</td>
														<td>
															<?php echo $reservacion->asignaciones_id ?> - <?php echo $reservacion->asignaciones_nombre ?>
														</td>
														<td>
															<?php echo $reservacion->usuario_id ?> -- <?php echo $reservacion->cliente_nombre ?>
														</td>
														<td>
															<?php echo $reservacion->disciplina ?>
														</td>
														<td>
															<?php echo $reservacion->no_lugar ?>
														</td>
														<td>
															<?php
															setlocale(LC_ALL, "es_ES");
															$fecha = strtotime($reservacion->horario);
															$fecha_espaniol = strftime("%d de %B del %Y<br>%T", $fecha);
															echo ucfirst($fecha_espaniol);
															?>
														</td>
														<td>
															<?php
															if ($reservacion->estatus == 'Activa') {
																if (strtotime('now') < strtotime('+48 hours', strtotime($reservacion->horario)) and $reservacion->asistencia == 'asistencia') {
																	echo anchor('reservaciones/cancelar/' . $reservacion->id, '<span style="color: red;">Cancelar</span>');
																	echo '|' . anchor('reservaciones/retirar_reservacion/' . $reservacion->id, '<span style="color: red;">Inasistencia</span>');
																} elseif ($reservacion->asistencia == 'inasistencia') {
																	echo 'Retirada por inasistencia';
																} else {
																	echo $reservacion->estatus;
																}
															} else {
																echo $reservacion->estatus;
															}
															?>
														</td>
														<td>
															<?php echo $reservacion->horario ?>
														</td>
														<td>
															<?php echo ucfirst($reservacion->asistencia) ?>
														</td>
														<td>
															<?php echo $reservacion->estatus ?>
														</td>
													</tr>
												<?php endforeach; ?>
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