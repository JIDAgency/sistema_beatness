<div class="app-content content center-layout mt-2">
	<div class="content-wrapper">

		<div class="content-header row">
			<div class="content-header-left col-md-6 col-12 mb-2">
				<div class="row breadcrumbs-top">
					<div class="breadcrumb-wrapper col-12">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php echo site_url('inicio') ?>">Inicio</a></li>
							<li class="breadcrumb-item"><a href="<?php echo site_url('clientes') ?>">Clientes</a></li>
							<li class="breadcrumb-item active">Suspendidos</li>
						</ol>
					</div>
				</div>
			</div>
			<div class="content-header-right  col-md-6 col-12">
				<div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
					<button class="btn btn-outline-secondary btn-min-width dropdown-toggle" id="btnGroupDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ft-settings icon-left"></i> Opciones</button>
					<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
						<a class="dropdown-item" href="<?php echo site_url('clientes/crear') ?>">+ Nuevo Cliente</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="<?php echo site_url('clases/crear') ?>">+ Nueva Clase</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="<?php echo site_url('ventas/crear') ?>">+ Nueva Venta</a>
						<a class="dropdown-item" href="<?php echo site_url('ventas/crear_personalizada') ?>">+ Nueva Venta Personalizada</a>
					</div>
				</div>
				<div class="form-group float-md-right">
					<div id="buttons"></div>
				</div>
			</div>
		</div>
		<div class="content-wrapper">
			<div class="content-body">
				<section>
					<div class="row">
						<div class="col-12">
							<div class="card no-border">
								<div class="card-header">
									<h4 class="card-title">Lista de clientes suspendidos</h4>
									<div class="card-content p_dt">
										<div class="card-body">

											<?php $this->load->view('_comun/mensajes_alerta');
											$i = 1; ?>

											<?php if (validation_errors()) : ?>
												<div class="alert bg-danger alert-icon-left alert-dismissible mb-2 font-small-3" role="alert">
													<span class="alert-icon"><i class="fa fa-thumbs-o-down"></i></span>
													<button type="button" class="close" data-dismiss="alert" aria-label="Close">
														<span aria-hidden="true">×</span>
													</button>
													<?php echo validation_errors(); ?>
												</div>
											<?php endif ?>

											<div name="mensaje-js" id="mensaje-js"></div>

											<div class="row">
												<div class="content-header-right col-md-12 col-12">



												</div>
											</div>
											<table id="tabla" class="table display nowrap table-striped table-bordered scroll-horizontal table-hover" cellspacing="0">
												<thead>
													<tr>
														<th>ID</th>
														<th>Nombre completo</th>
														<th>Correo electrónico</th>
														<th>Teléfono</th>
														<th>Registrado por</th>
														<th>Estatus</th>
														<th>Fecha de registro</th>
														<th>Recibir notificaciones</th>
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