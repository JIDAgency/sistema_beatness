<div class="app-content content center-layout mt-2">
	<div class="content-wrapper">
		<div class="content-header row">
			<div class="content-header-left col-md-6 col-12 mb-2">
				<div class="row breadcrumbs-top">
					<div class="breadcrumb-wrapper col-12">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php echo site_url('inicio/index') ?>">Inicio</a></li>
							<li class="breadcrumb-item active">Checkin</li>
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
							<div class="card no-border">
								<div class="card-header">
									<h4 class="card-title">Checkin</h4>
								</div>
								<div class="card-content p_dt">
									<div class="card-body">
										<table id="table" class="table display nowrap table-striped table-bordered scroll-horizontal table-hover">
											<thead>
												<tr>
													<th>Opciones</th>
													<th>ID</th>
													<th>Usuario</th>
													<th>Reservación</th>
													<th>Descripción</th>
													<th>Hora</th>
													<th>Estatus</th>
													<th>Fecha de registro</th>
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