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
		<div id="alert-container"></div>
		<?php $this->load->view('_comun/mensajes_alerta'); ?>
		<div class="content-wrapper">
			<div class="content-body">
				<section>
					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title">Clases disponibles</h4>

									<?php if ($this->session->userdata('rol_id') != '5') : ?>
										<div class="row mt-2">
											<div class="col-lg-3 col-md-3 col-sm-12">
												<div class="form-group">
													<h5 class="card-titlel"><i class="ft-filter"></i> Sucursal:</h5>
													<select id="filtro_clase_sucursal" name="filtro_clase_sucursal" class="select2 form-control">
														<option value="0">Todas las sucursales</option>
														<?php foreach ($sucursales_list as $key => $sucursal_row) : ?>
															<option value="<?= $sucursal_row->id; ?>" <?= ($this->session->userdata('filtro_clase_sucursal') == $sucursal_row->id) ? 'selected' : '' ?>>
																<?= $sucursal_row->locacion; ?>
															</option>
														<?php endforeach; ?>
													</select>
												</div>
											</div>

											<div class="col-lg-3 col-md-3 col-sm-12">
												<div class="form-group">
													<h5 class="card-titlel"><i class="ft-filter"></i> Disciplina:</h5>
													<select id="filtro_clase_disciplina" name="filtro_clase_disciplina" class="select2 form-control">
														<option value="0">Todas las disciplinas</option>
														<?php foreach ($disciplinas_list as $key => $disciplina_row) : ?>
															<option value="<?= $disciplina_row->id; ?>" <?= ($this->session->userdata('filtro_clase_disciplina') == $disciplina_row->id) ? 'selected' : '' ?>>
																<?= $disciplina_row->nombre; ?>
															</option>
														<?php endforeach; ?>
													</select>
												</div>
											</div>
										</div>
									<?php endif; ?>

									<div class="heading-elements">
										<a href="<?php echo site_url('clases/crear') ?>" class="btn btn-outline-secondary btn-min-width">
											<i class="ft-plus"></i> Nueva clase
										</a>
										<div class="form-group float-md-left mr-1">
											<div id="buttons"></div>
										</div>
										<!--a href="<?php //echo site_url('clases/generar_horarios_ionic') 
													?>" class="btn btn-secondary btn-sm">
										<i class="ft-plus white"></i> Generar horas bonitas
									</a-->
									</div>
								</div>
								<div class="card-content p_dt">
									<div class="card-body">
										<table id="table" class="table display nowrap table-striped table-bordered scroll-horizontal table-hover">
											<thead>
												<tr>
													<th>ID</th>
													<th>SKU</th>
													<th>Disciplina</th>
													<th>Dificultad</th>
													<th>Horario</th>
													<th>Horario</th>
													<th>Instructor</th>
													<th>Cupo</th>
													<th>Estatus</th>
													<th>N. Horas</th>
													<th>Cupo restantes</th>
													<th>Cupo original</th>
													<th>Cupos reservados</th>
													<th>Inasistencias</th>
													<th>Sucursal</th>
													<th>Opciones</th>
												</tr>
											</thead>
											<tbody>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>