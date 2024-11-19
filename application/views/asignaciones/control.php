<div class="app-content content center-layout mt-2">
	<div class="content-wrapper">
		<div class="content-header row">
			<div class="content-header-left col-md-6 col-12 mb-2">
				<div class="row breadcrumbs-top">
					<div class="breadcrumb-wrapper col-12">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php echo site_url('inicio/index') ?>">Inicio</a></li>
							<li class="breadcrumb-item"><a href="<?php echo site_url('asignaciones') ?>">Planes de clientes</a></li>
							<li class="breadcrumb-item active"><?php echo $pagina_titulo; ?></li>
						</ol>
					</div>
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
									<h4 class="card-title"><?php echo $pagina_subtitulo; ?></h4>
									<div class="heading-elements">
									</div>
									<div class="form-group float-md-right mr-1">
										<div id="buttons"></div>
									</div>
								</div>
								<div class="card-content p_dt">
									<div class="card-body">
										<?php $this->load->view('_comun/mensajes_alerta'); ?>
										<table name="tabla" id="tabla" class="table display nowrap table-striped table-bordered scroll-horizontal table-hover w-100" cellspacing="0">
											<thead>
												<tr>
													<th>ID</th>
													<th>Nombre plan</th>
													<th>Estatus</th>
													<th>Nombre cliente</th>
													<th>Usuario</th>
													<th>Clases</th>
													<th>Fecha inicio</th>
													<th>Días vigencia</th>
													<th>Fecha finalización</th>
													<th>Categoría</th>
													<th>Disciplinas incluidas</th>
													<th>Clases incluidas</th>
													<th>Clases usadas</th>
													<th>ID plan</th>
													<th>ID cliente</th>
												</tr>
											</thead>
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