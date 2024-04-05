<div class="app-content container center-layout mt-2">
	<div class="content-header row">
		<div class="content-header-left col-md-6 col-12 mb-2">
			<div class="row breadcrumbs-top">
				<div class="breadcrumb-wrapper col-12">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?php echo site_url('inicio/index') ?>">Inicio</a></li>
						<li class="breadcrumb-item"><a href="<?php echo site_url('clientes') ?>">Clientes</a></li>
						<li class="breadcrumb-item active">Reporte activos</li>
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
						<div class="card">
							<div class="card-header">
								<h4 class="card-title">Registro de clientes</h4>
							<div class="card-content p_dt">
								<div class="card-body">
									<?php $this->load->view('_comun/mensajes_alerta'); $i = 1;?>

                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <div class="form-group float-md-right">
                                                <div id="buttons"></div>
                                            </div>
                                        </div>
                                    </div>

									<table id="tabla" class="table display nowrap table-striped table-bordered scroll-horizontal table-hover" cellspacing="0">
										<thead>
											<tr>
												<th>ID</th>
												<th>Nombre Completo</th>
												<th>Correo Electronico</th>
												<th>Telefono Cel.</th>
												<th>Fecha de Registro</th>
											</tr>
										</thead>
										<tbody>
                                            <?php foreach ($clientes_list as $cliente_row): ?>
                                                <tr>
                                                    <td><?php echo $cliente_row->id; ?></td>
                                                    <td><?php echo trim($cliente_row->nombre_completo.' '.$cliente_row->apellido_paterno.' '.$cliente_row->apellido_materno); ?></td>
                                                    <td><?php echo $cliente_row->correo; ?></td>
                                                    <td><?php echo $cliente_row->no_telefono; ?></td>
                                                    <td><?php echo date("d/m/Y",strtotime($cliente_row->fecha_registro)); ?></td>
                                                </tr>
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
