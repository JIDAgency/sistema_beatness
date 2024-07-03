<div class="app-content content center-layout mt-2">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
				<div class="row breadcrumbs-top">
					<div class="breadcrumb-wrapper col-12">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php echo site_url('inicio/index') ?>">Inicio</a>
							</li>
							<li class="breadcrumb-item active">Administradores
							</li>
						</ol>
					</div>
				</div>
			</div>
			<div class="content-header-right col-md-6 col-12 mb-2">
				<div class="form-group float-md-right">
					<a class="btn btn-outline-secondary btn-min-width mr-1 mb-1" href="<?php echo site_url('usuarios/crear_usuario') ?>">
						<i class="ft-plus"></i> Nuevo Usuario
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
						<div class="card">
							<div class="card-header">
								<h4 class="card-title">Administradores registrados</h4>
							</div>
							<div class="card-content p_dt">
								<div class="card-body">
									<?php $this->load->view('_comun/mensajes_alerta'); ?>
									<table id="tabla-clientes" class="table display nowrap table-striped table-bordered scroll-horizontal table-hover" cellspacing="0">
										<thead>
											<tr>
												<th>ID</th>
												<th>Nombre Completo</th>
												<th>Correo Electronico</th>
												<th>Telefono Cel.</th>
												<th>Rol</th>
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
