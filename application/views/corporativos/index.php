<div class="app-content content center-layout mt-2">
	<div class="content-wrapper">
		<div class="content-header row">
			<div class="content-header-left col-md-6 col-12 mb-2">
				<div class="row breadcrumbs-top">
					<div class="breadcrumb-wrapper col-12">
						<ol class="breadcrumb">
							<li class="breadcrumb-item active">Corporativos</li>
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
									<h4 class="card-title">Usuarios Corporativos</h4>
									<div class="heading-elements">
									</div>
								</div>
								<div class="card-content p_dt">
									<div class="card-body">
										<?php $this->load->view('_comun/mensajes_alerta'); ?>
										<table name="tabla" id="tabla" class="table display nowrap table-striped table-bordered scroll-horizontal table-hover w-100" cellspacing="0">
											<thead>
												<tr>
													<th>ID</th>
													<th>Usuario</th>
													<th>Nombre</th>
													<th>Opciones</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($corporativos_list as $corporativo_row) : ?>
													<tr>
														<td>
															<?php echo $corporativo_row->id; ?>
														</td>
														<td>
															<?php echo $corporativo_row->correo; ?>
														</td>
														<td>
															<?php echo $corporativo_row->nombre; ?>
														</td>
														<td>
															<a href="<?php echo site_url("corporativos/ver/" . $corporativo_row->id); ?>"><i class="fa fa-eye"></i></a>
														</td>
													<tr>
													<?php endforeach; ?>
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