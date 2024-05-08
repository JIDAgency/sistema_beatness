<div class="app-content content center-layout mt-2">
	<div class="content-wrapper">
		<div class="content-header row">
			<div class="content-header-left col-md-6 col-12 mb-2">
				<div class="row breadcrumbs-top">
					<div class="breadcrumb-wrapper col-12">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php echo site_url('inicio/index') ?>">Inicio</a></li>
							<li class="breadcrumb-item active">Disciplinas-Categorias</li>
						</ol>
					</div>
				</div>
			</div>
		</div>
		<?php $this->load->view('_templates/mensajes_alerta.tpl.php'); ?>
		<div class="content-wrapper">
			<div class="content-body">
				<section>
					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title">Categorias disponibles</h4>
									<div class="heading-elements">
										<a href="<?php echo site_url('planes_categorias/crear') ?>" class="btn btn-outline-secondary btn-min-width">
											<i class="ft-plus"></i> Agregar
										</a>
									</div>
								</div>
								<div class="card-content p_dt">
									<div class="card-body">
										<table id="table" class="table display nowrap table-striped table-bordered scroll-horizontal table-hover">
											<thead>
												<tr>
													<th>ID</th>
													<th>Identificador</th>
													<th>Nombre</th>
													<th>Orden</th>
													<th>Fecha de registro</th>
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