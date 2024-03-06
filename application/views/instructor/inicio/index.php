<div class="app-content container center-layout mt-2">
	<div class="content-header-left col-md-6 col-12 mb-2">
		<div class="row breadcrumbs-top">
			<div class="breadcrumb-wrapper col-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item active">Inicio</li>
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
								<h4 class="card-title">Calendario de clases</h4>
								<div class="heading-elements">
								</div>
							</div>
							<div class="card-content p_dt">
								<div class="card-body">
									<?php $this->load->view('_comun/mensajes_alerta');?>
									<table id="tabla" class="table table-striped table-bordered">
										<thead>
											<tr>
                                                <th>Horario</th>
                                                <th>Instructor</th>
                                                <th>Disciplina</th>
												<th>Cupo</th>
												<th>Cupos restante</th>
												<th>Cupos reservados</th>
												<th>Dificultad</th>
												<th>No. de Inasistencias</th>
												<th>No. de Horas</th>

                                                <th>#</th>
												<th>ID</th>
												<th>Estatus</th>
                                                <th>Horario</th>
												<th>Lugares</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach ($clases->result() as $clase): $i = 0;?>
                                                <tr>
                                                    <td>
                                                        <?php echo date("d/m/Y H:i", strtotime($clase->inicia)); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $clase->instructor_nombre; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $clase->subdisciplina_id != 0 ? $clase->disciplina_nombre.' | '.$clase->disciplina_nombre.' GODIN' : $clase->disciplina_nombre; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $clase->cupo; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $clase->cupo - $clase->reservado; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $clase->reservado; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $clase->dificultad; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $clase->inasistencias; ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($clase->intervalo_horas != 1): ?>
                                                        <?php echo $clase->intervalo_horas . " hrs."; ?>
                                                        <?php else: ?>
                                                        <?php echo $clase->intervalo_horas . " hr."; ?>
                                                        <?php endif;?>
                                                    </td>
                                                    
                                                    <td>
                                                        <?php echo $clase->id; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $clase->identificador; ?>
                                                    </td>
                                                    
                                                    
                                                    <td>
                                                        <?php echo $clase->estatus ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                            setlocale(LC_ALL,"es_ES");
                                                            $fecha = strtotime($clase->inicia);
                                                            $fecha_espaniol = strftime("%d de %B del %Y - %R", $fecha);
                                                            echo ucfirst($fecha_espaniol);
                                                        ?>
                                                    </td>
                                                    
                                                    <td>
                                                        <?php 
                                                            $cupo_lugares = $clase->cupo_lugares;
                                                            $cupo_lugares = json_decode($cupo_lugares);
                                                            echo '<br>';
                                                            foreach ($cupo_lugares as $lugar) {
                                                                if ($lugar->nombre_usuario) {
                                                                    $i++;
                                                                    foreach ($usuarios->result() as $usuario){
                                                                        if ($lugar->nombre_usuario == $usuario->id) {
                                                                            echo $i. '-. Lugar: '.$lugar->no_lugar.' |  Cliente: '.$usuario->nombre_completo.' '.$usuario->apellido_paterno.' '.$usuario->apellido_materno.' #'.$lugar->nombre_usuario;
                                                                            echo '<br>';
                                                                        }
                                                                    }
                                                                    if (!is_numeric($lugar->nombre_usuario)) {
                                                                        echo $i. '-. Lugar: '.$lugar->no_lugar.' |  Cliente: #'.$lugar->nombre_usuario;
                                                                        echo '<br>';
                                                                    }
                                                                }
                                                            } 
                                                        ?>
                                                    </td>
                                                </tr>
											<?php endforeach;?>
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
