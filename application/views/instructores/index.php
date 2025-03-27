<div class="app-content content center-layout mt-2">
	<div class="content-wrapper">
		<div class="content-header row">
			<div class="content-header-left col-md-6 col-12 mb-2">
				<div class="row breadcrumbs-top">
					<div class="breadcrumb-wrapper col-12">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php echo site_url('inicio/index') ?>">Inicio</a></li>
							<li class="breadcrumb-item active">Instructores</li>
						</ol>
					</div>
				</div>
			</div>
			<div class="content-header-right col-md-6 col-12 mb-2">
				<div class="form-group float-md-right">
					<a class="btn btn-outline-secondary btn-min-width mr-1 mb-1" href="<?php echo site_url('instructores/crear') ?>">
						<i class="ft-plus"></i> Nuevo Instructor
					</a>
					<div class="btn-group mr-1 mb-1">
						<button type="button" class="btn btn-outline-secondary btn-min-width dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="ft-settings icon-left"></i>&nbsp;Opciones</button>
						<div class="dropdown-menu">
							<a class="dropdown-item" href="<?php echo site_url('clientes/crear') ?>">+ Nuevo Cliente</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="<?php echo site_url('clases/crear') ?>">+ Nueva Clase</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="<?php echo site_url('ventas/crear') ?>">+ Nueva Venta</a>
							<a class="dropdown-item" href="<?php echo site_url('ventas/crear_personalizada') ?>">+ Nueva Venta Personalizada</a>
						</div>
					</div>
					<div class="form-group float-md-left mr-1">
						<div id="buttons"></div>
					</div>
				</div>
			</div>
		</div>
		<div class="content-body">
			<section>
				<div class="row">
					<div class="col-12">
						<div class="card no-border">
							<div class="card-header">
								<h4 class="card-title">Instructores registrados</h4>
							</div>
							<div class="card-content p_dt">
								<div class="card-body">
									<?php $this->load->view('_comun/mensajes_alerta');
									$i = 1; ?>
									<table name="tabla" id="tabla" class="table display nowrap table-striped table-bordered scroll-horizontal table-hover w-100" cellspacing="0">
										<thead>
											<tr>
												<th>Opciones</th>
												<th>ID</th>
												<th>Nombre</th>
												<th>Correo</th>
												<th>Teléfono</th>
												<th>RFC</th>
												<th>Genero</th>
												<th>Dirección</th>
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

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="deleteModalLabel">Confirmar eliminación</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				¿Está seguro de que desea eliminar esta cuenta de usuario?
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-danger" id="confirmDelete">Eliminar</button>
			</div>
		</div>
	</div>
</div>