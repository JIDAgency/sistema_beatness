<div class="app-content container center-layout mt-2">
	<div class="content-wrapper">

		<div class="content-header row">

			<div class="content-header-left col-md-6 col-12 mb-2">
				<div class="row breadcrumbs-top">
					<div class="breadcrumb-wrapper col-12">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php echo site_url("inicio"); ?>">Inicio</a></li>
							<li class="breadcrumb-item active">Suscripciones</li>
						</ol>
					</div>
				</div>
			</div>

			<!--div class="content-header-right col-md-6 col-12">
				<div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">   
					<button class="btn btn-info round dropdown-toggle dropdown-menu-right px-2" id="btnGroupDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ft-settings icon-left"></i> Settings</button>
					<div class="dropdown-menu" aria-labelledby="btnGroupDrop1"><a class="dropdown-item" href="card-bootstrap.html">Cards</a><a class="dropdown-item" href="component-buttons-extended.html">Buttons</a></div>
				</div>
			</div-->

		</div>

		<div class="content-body">
			<section id="configuration">
				<div class="row">
					<div class="col-12">
						<div class="card no-border">
							<div class="card-header">
								<h4 class="card-title">Lista de suscripciones</h4>
							</div>
							<div class="card-content collapse show">
								<div class="card-body card-dashboard">
									<!--p class="card-text"></p-->
									<table name="tabla" id="tabla" class="table display nowrap table-striped table-bordered scroll-horizontal table-hover">
										<thead>
											<tr>
												<th>ID</th>
												<th>Nombre del cliente</th>
												<th>Categoría</th>
												<th>Fecha activación</th>
												<th>Fecha actualización</th>
												<th>Estatus</th>
												<th>Suscripción ID</th>
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
