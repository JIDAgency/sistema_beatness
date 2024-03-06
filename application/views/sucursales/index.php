<div class="app-content container center-layout mt-2">
	<div class="content-header row">
		<div class="content-header-left col-md-6 col-12 mb-2">
			<div class="row breadcrumbs-top">
				<div class="breadcrumb-wrapper col-12">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?php echo site_url('inicio/index') ?>">Inicio</a></li>
						<li class="breadcrumb-item active">Sucursales</li>
					</ol>
				</div>
			</div>
		</div>
		<div class="content-header-right  col-md-6 col-12">
			<div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">   
				<button class="btn btn-secondary round dropdown-toggle dropdown-menu-right px-2" id="btnGroupDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ft-settings icon-left"></i> Nuevo</button>
				<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
					<a class="dropdown-item" href="<?php echo site_url('clientes/crear') ?>">+ Nuevo Cliente</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="<?php echo site_url('clases/crear') ?>">+ Nueva Clase</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="<?php echo site_url('ventas/crear') ?>">+ Nueva Venta</a>
					<a class="dropdown-item" href="<?php echo site_url('ventas/crear_personalizada') ?>">+ Nueva Venta Personalizada</a>
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
								<h4 class="card-title">Registro de sucursales</h4>
								<div class="heading-elements">
									<a href="<?php echo site_url('sucursales/crear') ?>" class="btn btn-secondary btn-sm">
										<i class="ft-plus white"></i> Nueva sucursal
									</a>
								</div>
							</div>
							<div class="card-content p_dt">
								<div class="card-body">
									<?php $this->load->view('_comun/mensajes_alerta'); ?>
									<div class="table-responsive">
										<table id="tabla-sucursales" class="table table-striped table-bordered compact" cellspacing="0">
											<thead>
												<tr>
													<th>ID</th>
													<th>Sucursal</th>
													<th>Mostrar</th>
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
				</div>
			</section>
		</div>
	</div>
</div>
