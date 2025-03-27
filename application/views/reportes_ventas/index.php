<div class="app-content content center-layout">
	<div class="content-wrapper">
		<div class="content-header row px-1 my-1">

			<div class="content-header-left col-md-6 col-12">

				<div class="row breadcrumbs-top">
					<div class="breadcrumb-wrapper col-12">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php echo site_url('site/inicio'); ?>">Inicio</a></li>
							<li class="breadcrumb-item active"><?php echo $pagina_titulo; ?></li>
						</ol>
					</div>
				</div>

			</div>

			<div class="content-header-right col-md-6 col-12">

				<div class="media float-right">

					<div class="form-group">
						<div class="btn-group" role="group" aria-label="Basic example">
							<a class="btn btn-outline-secondary" href="<?php echo site_url('site/cirugias/agregar'); ?>"><i class="fa fa-plus-circle"></i>&nbsp;Agregar</a>
						</div>
					</div>

				</div>

			</div>

		</div>

		<div class="content-body">
			<section id="section">

				<?php $this->load->view('_templates/mensajes_alerta.tpl.php'); ?>

				<div class="row">
					<div class="col-12">
						<div class="card no-border">

							<div class="card-header">
								<h4 class="card-title"><?php echo $pagina_subtitulo; ?></h4>
							</div>

							<div class="card-content collapse show">
								<div class="card-body card-dashboard">
									<table name="table" id="table" class="table display nowrap table-striped table-bordered scroll-horizontal table-hover">
										<thead>
											<tr>
												<th>ID</th>
												<th>Concepto</th>
												<th>Producto</th>
												<th>Cliente</th>
												<th>Fecha de Venta</th>
												<th>Total</th>
												<th>Método</th>
												<th>Sucursal</th>
												<th>Vendedor</th>
												<th>Estatus</th>
												<th>Cantidad</th>
												<th>Clases (Usadas/Inluidas)</th>
												<th>Vigencia (días)</th>
												<th>Fecha de Activación</th>
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