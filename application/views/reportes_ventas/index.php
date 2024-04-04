<div class="app-content content center-layout mt-2">
    <div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?php echo site_url('inicio/index') ?>">Inicio</a>
				</li>
                <li class="breadcrumb-item active">Historial de ventas</a>
                </li>
            </ol>
            </div>
        </div>
        <h3 class="content-header-title mb-0">Historial de ventas</h3>
        </div>
    </div>
    <section id="show-hidden">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Ventas del sistema</h4>
                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                            <!--li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li-->
                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                            <!--li><a data-action="close"><i class="ft-x"></i></a></li-->
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body card-dashboard">
                            <?php $this->load->view('_comun/mensajes_alerta');?>
                            <h3><?php echo 'Total de ventas: $'.number_format($total_de_ventas, 2) ?></h3>
                            <h3>Ventas por busqueda: <span id = "ttl" name = "ttl">$0.00</span></h3>
							<br>
							<br>
							<table id="tabla-ventas" class="table table-striped table-bordered">
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
										<th>Sucursales</th>
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
									<?php foreach ($todas_las_ventas_registradas->result() as $venta): ?>
									<tr>
										<th scope="row">
											<?php echo $venta->id ?>
										</th>
										<td>
											<?php echo $venta->usuario ?> #<?php echo $venta->usuario_id ?>
										</td>
										<td>
											<?php
												setlocale(LC_ALL,"es_ES");
												$fecha = strtotime($venta->fecha_venta);
												echo strftime("%d de %B del %Y<br>%T", $fecha);
											?>
										</td>
										<td>
											<?php echo $venta->concepto ?> #<?php echo $venta->asignacion_id ?>
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
												echo anchor('reportes_ventas/cancelar/' . $venta->id, 'Cancelar');
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
											<?php echo $venta->sucursales_locacion ?>
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