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

			<div class="content-header-right  col-md-6 col-12">
				<div class="heading-elements float-right mx-1">
					<a href="<?php echo site_url('planes_categorias/crear') ?>" class="btn btn-outline-secondary btn-min-width">
						<i class="ft-plus"></i> Agregar
					</a>
				</div>
				<div class="form-group float-md-right">
					<div id="buttons"></div>
				</div>

				<div class=" heading-elements float-right mx-1">
					<a href="#suspendidos" class="btn btn-outline-secondary btn-min-width smooth-scroll">
						Planes suspendidos
					</a>
				</div>

				<div class="heading-elements float-right">
					<a href="#disponibles" class="btn btn-outline-secondary btn-min-width smooth-scroll">
						Planes activos
					</a>
				</div>
			</div>
		</div>
		<?php $this->load->view('_templates/mensajes_alerta.tpl.php'); ?>
		<div class="content-wrapper">
			<div class="content-body">
				<section>
					<div class="row">
						<div class="col-12">
							<div class="card no-border">
								<div class="card-header">
									<h4 class="card-title">Categorías disponibles</h4>
								</div>
								<div class="card-content p_dt">
									<div class="card-body" id="disponibles">
										<table id="table" class="table display nowrap table-striped table-bordered scroll-horizontal table-hover w-100" cellspacing="0">
											<thead>
												<tr>
													<th>Opciones</th>
													<th>ID</th>
													<th>Imagen</th>
													<th>Orden</th>
													<th>Nombre</th>
													<th>Identificador</th>
													<th>Estatus</th>
													<th>Fecha de registro</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
									</div>
									<div class="card-body" id="suspendidos">
										<h4 class="card-title">Categorías suspendidas</h4>

										<table id="table_suspendidos" class="table display nowrap table-striped table-bordered scroll-horizontal table-hover w-100" cellspacing="0">
											<thead>
												<tr>
													<th>Opciones</th>
													<th>ID</th>
													<th>Imagen</th>
													<th>Orden</th>
													<th>Nombre</th>
													<th>Identificador</th>
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