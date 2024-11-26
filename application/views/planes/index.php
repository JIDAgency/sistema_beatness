<div class="app-content content center-layout mt-2">
	<div class="content-wrapper">
		<div class="content-header row">

			<div class="content-header-left col-md-6 col-12 mb-2">
				<div class="row breadcrumbs-top">
					<div class="breadcrumb-wrapper col-12">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php echo site_url('inicio') ?>">Inicio</a></li>
							<li class="breadcrumb-item active">Planes</li>
						</ol>
					</div>
				</div>
			</div>

			<div class="content-header-right  col-md-6 col-12">
				<div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
					<button class="btn btn-outline-secondary btn-min-width dropdown-toggle" id="btnGroupDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ft-settings icon-left"></i> Nuevo</button>
					<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
						<a class="dropdown-item" href="<?php echo site_url('clientes/crear') ?>">+ Nuevo Cliente</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="<?php echo site_url('clases/crear') ?>">+ Nueva Clase</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="<?php echo site_url('ventas/crear') ?>">+ Nueva Venta</a>
						<a class="dropdown-item" href="<?php echo site_url('ventas/crear_personalizada') ?>">+ Nueva Venta Personalizada</a>
					</div>
				</div>
				<div class="heading-elements float-right mx-1">
					<a href="<?php echo site_url('planes/crear') ?>" class="btn btn-outline-secondary btn-min-width">
						<i class="ft-plus"></i> Nuevo plan
					</a>
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
									<h4 class="card-title">Lista de planes</h4>

								</div>

								<div class="card-content p_dt">
									<div class="card-body">
										<?php $this->load->view('_comun/mensajes_alerta');
										$i = 1; ?>
										<div class="row">
											<div class="col-4">
												<div class="form-group">
													<label for="sucursal">Sucursal:</label>
													<select name="sucursal" id="sucursal" class="form-control">
														<option value="">Todas</option>
														<?php foreach ($sucursales_list as $key => $sucursal) : ?>
															<option value="<?php echo $sucursal->descripcion ?>"><?php echo $sucursal->descripcion ?></option>
														<?php endforeach; ?>
													</select>
												</div>
											</div>
										</div>
										<table id="tabla-planes" class="table display nowrap table-striped table-bordered scroll-horizontal table-hover w-100" cellspacing="0">
											<thead>
												<tr>
													<th>Opciones</th>
													<th>Imagenes</th>
													<th>ID</th>
													<th>Plan</th>
													<th>Orden venta</th>
													<th>Clases incluidas</th>
													<th>Vigencia</th>
													<th>Sucursal</th>
													<th>Código</th>
													<th>Costo</th>
													<th>Reservaciones ilimitadas</th>
													<th>Primera compra</th>
													<th>Solo estudiantes</th>
													<th>Solo empresarial</th>
													<th>Se pagara en</th>
													<th>Activo</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
										<br><br>
										<h4 class="card-title">Lista de planes suspendidos</h4>
										<div class="row">
											<div class="col-4">
												<div class="form-group">
													<label for="sucursal-suspendidos">Sucursal:</label>
													<select name="sucursal-suspendidos" id="sucursal-suspendidos" class="form-control">
														<option value="">Todas</option>
														<?php foreach ($sucursales_list as $key => $sucursal) : ?>
															<option value="<?php echo $sucursal->descripcion ?>"><?php echo $sucursal->descripcion ?></option>
														<?php endforeach; ?>
													</select>
												</div>
											</div>
										</div>
										<table id="tabla-planes-suspendidos" class="table display nowrap table-striped table-bordered scroll-horizontal table-hover w-100" cellspacing="0">
											<thead>
												<tr>
													<th>Opciones</th>
													<th>Imagenes</th>
													<th>ID</th>
													<th>Plan</th>
													<th>Orden venta</th>
													<th>Clases incluidas</th>
													<th>Vigencia</th>
													<th>Sucursal</th>
													<th>Código</th>
													<th>Costo</th>
													<th>Reservaciones ilimitadas</th>
													<th>Primera compra</th>
													<th>Solo estudiantes</th>
													<th>Solo empresarial</th>
													<th>Se pagara en</th>
													<th>Activo</th>
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