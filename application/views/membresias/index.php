<div class="app-content container center-layout mt-2">
	<div class="content-wrapper">
		<div class="content-body">
			<section>
				<div class="row">
					<div class="col-12">
						<div class="card">
							<div class="card-header">
								<h4 class="card-title">Membresías disponibles</h4>
								<div class="heading-elements">
									<a href="<?php echo site_url('membresias/crear') ?>" class="btn btn-secondary btn-sm">
										<i class="ft-plus white"></i> Nueva membresía
									</a>
								</div>
							</div>
							<div class="card-content">
								<div class="card-body">
									<?php $this->load->view('_comun/mensajes_alerta'); $i = 1; ?>
									<table id="tabla-membresias" class="table display nowrap table-striped table-bordered scroll-horizontal table-hover">
										<thead>
											<tr>
												<th>#</th>
												<th>Nombre de la membresía</th>
												<th>Costo</th>
												<th>Descripción</th>
												<th>Clases incluidas</th>
												<th>Acciones</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach ($membresias->result() as $membresia): ?>
											<tr>
												<th>
													<?php echo $i++; ?>
												</th>
												<td>
													<?php echo $membresia->nombre; ?>
												</td>
												<td>
													<?php echo $membresia->costo; ?>
												</td>
												<td>
													<?php echo $membresia->descripcion; ?>
												</td>
												<td>
													<?php echo $membresia->clases_incluidas; ?>
												</td>
												<td>
													<?php echo anchor('membresias/editar/' . $membresia->id, 'Editar'); ?>
												</td>
											</tr>
											<?php endforeach;?>
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
