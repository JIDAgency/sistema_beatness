<div class="app-content container center-layout mt-2">
	<div class="content-header-left col-md-6 col-12 mb-2">
		<div class="row breadcrumbs-top">
			<div class="breadcrumb-wrapper col-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo site_url('inicio/index') ?>">Inicio</a>
					</li>
					<li class="breadcrumb-item active">Ventas
					</li>
				</ol>
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
								<h4 class="card-title">Ventas</h4>
								<br>
								<!--h1>Total de ventas: &nbsp;
									<?php //echo '$' . number_format($total, 2) ?>
								</h1-->
								<h2>Ventas por busqueda: <span id = "ttl" name = "ttl">$0.00</span></h2>
								<div class="heading-elements">
									<a href="<?php echo site_url('ventas/crear') ?>" class="btn btn-secondary btn-sm">
										<i class="ft-plus white"></i> Nueva venta
									</a>
									<a href="<?php echo site_url('ventas/crear_personalizada') ?>" class="btn btn-secondary btn-sm">
										<i class="ft-plus white"></i> Nueva venta personalizada
									</a>
									<!--a href="<?php //echo site_url('ventas/genera_asignaciones_por_id_para_todas_las_ventas') ?>" class="btn btn-secondary btn-sm">
										<i class="ft-plus white"></i> Generar Asignaciones
									</a-->
								</div>
							</div>
							<div class="card-content p_dt">
								<div class="card-body">
									<?php $this->load->view('_comun/mensajes_alerta');?>
									<table id="tabla-ventas" class="table display nowrap table-striped table-bordered scroll-horizontal table-hover">
										<thead>
											<tr>
												<th>ID</th>
												<th>ID + Cliente</th>
												<th>Fecha de venta</th>
												<th>ID + Producto</th>
												<th>Metodo</th>
												<th>Costo</th>
												<th>Total</th>
												<th>Opciones</th>
												<th>Cant.</th>
												<th>Vendedor</th>
												<th>Estatus</th>
												<th>Clases Incluidas</th>
												<th>Clases Usadas</th>
												<th>Clases Restantes</th>
												<th>Vigencia en Días</th>
												<th>Fecha de Venta</th>
												<th>Fecha de Activación</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach ($ventas->result() as $venta): ?>
											<tr>
												<th scope="row">
													<?php echo $venta->id ?>
												</th>
												<td>
													<?php echo $venta->usuario_id ?> -- <?php echo $venta->usuario ?>
												</td>
												<td>
													<?php
														setlocale(LC_ALL,"es_ES");
														$fecha = strtotime($venta->fecha_venta);
														echo strftime("%d de %B del %Y<br>%T", $fecha);
													?>
												</td>
												<td>
												<?php echo $venta->asignacion_id ?> -- <?php echo $venta->concepto ?>
												</td>
												<td>
													<?php echo $venta->metodo ?>
												</td>
												<td>
													<?php echo '$' . number_format($venta->costo, 2) ?>
												</td>
												<td>
													<?php echo '$' . number_format($venta->total, 2) ?>
												</td>
												<td>
													<?php if ($venta->estatus == 'Cancelada') {
														echo 'Cancelada';
													} else {
														echo anchor('ventas/cancelar/'.$venta->id,'Cancelar');
													}
													?>
												</td>
												<td>
													<?php echo $venta->cantidad ?>
												</td>
												<td>
													<?php echo $venta->vendedor ?>
												</td>
												<td>
													<?php echo $venta->estatus ?>
												</td>
												<td>
													<?php echo $venta->clases_incluidas ?>
												</td>
												<td>
													<?php echo $venta->clases_usadas ?>
												</td>
												<td>
													<?php echo $venta->clases_incluidas - $venta->clases_usadas ?>
												</td>
												<td>
													<?php echo $venta->vigencia_en_dias ?>
												</td>
												<td>
													<?php echo $venta->fecha_venta ?>
												</td>
												<td>
													<?php
														setlocale(LC_ALL,"es_ES");
														$fecha = strtotime($venta->fecha_activacion);
														echo strftime("%d de %B del %Y<br>%T", $fecha);
													?>
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
