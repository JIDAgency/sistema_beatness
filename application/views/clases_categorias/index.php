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

									<div class="heading-elements">
										<a href="<?php echo site_url('clases_categorias/crear') ?>" class="btn btn-outline-secondary btn-min-width">
											<i class="ft-plus"></i> Nueva clase
										</a>
										<div class="form-group float-md-left mr-1">
											<div id="buttons"></div>
										</div>
									</div>
								</div>
								<div class="card-content p_dt">
									<div class="card-body">
										<table id="table" class="table display nowrap table-striped table-bordered scroll-horizontal table-hover">
											<thead>
												<tr>
													<th>ID</th>
													<th>Nombre</th>
													<th>Disciplina</th>
													<th>GYMPASS</th>
													<th>Descripción</th>
													<th>Nota</th>
													<th>Estatus</th>
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