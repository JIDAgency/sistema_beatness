<div class="app-content container center-layout mt-2">
	<div class="content-header-left col-md-6 col-12 mb-2">
		<div class="row breadcrumbs-top">
			<div class="breadcrumb-wrapper col-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo site_url('inicio') ?>">Inicio</a></li>
					<li class="breadcrumb-item"><a href="<?php echo site_url('ventas') ?>">Ventas</a></li>
					<li class="breadcrumb-item active">Cambiar fecha</li>
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
								<h4 class="card-title">Cambiar fecha de venta</h4>
							</div>
							<div class="card-content">
								<div class="card-body">
									<?php echo form_open($controlador, array('class' => 'form form-horizontal', 'id' => 'forma-editar-cliente')); ?>

										
                                        <div class="form-body">

                                            <?php if (validation_errors()): ?>
                                                <div class="alert bg-danger alert-icon-left alert-dismissible mb-2 font-small-3" role="alert">
                                                    <span class="alert-icon"><i class="fa fa-thumbs-o-down"></i></span>
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                    <?php echo validation_errors(); ?>
                                                </div>
                                            <?php endif?>

                                            <?php $this->load->view('_comun/mensajes_alerta'); ?>
                                            <input type="hidden" name="id" id="id" value="<?php echo $venta_row->id; ?>">

                                            <h4>Validar cambio como administrador</h4>

                                            <div class="row mt-2">
                                                <div class="col-md-6 mb-3">
                                                    <label for="correo">Correo electrónico de administrador <span class="red">*</span></label>
                                                    <div class="input-group">
                                                        <input type="email" class="form-control" name="correo" id="correo" placeholder="Correo electrónico" value="<?php echo set_value('correo'); ?>" required="">
                                                    </div>
                                                    <div class="invalid-feedback">
                                                        Por favor introduzca la contraseña válida.
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row mb-2">
                                                <div class="col-md-6 mb-3">
                                                    <label for="contrasena_hash">Contraseña <span class="red">*</span></label>
                                                    <div class="input-group">
                                                        <input type="password" class="form-control" name="contrasena_hash" id="contrasena_hash" placeholder="Contraseña" value="<?php echo set_value('password'); ?>" required="">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-secondary" type="button" onclick="mostrar_contraseña()"><i class="fa fa-eye"></i></button>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">
                                                        Por favor introduzca la contraseña válida.
                                                    </div>
                                                </div>
                                            </div>

                                            <h4>Datos de la venta a modificar</h4>
                                            
                                            <p class="mt-2"><b>ID: </b><?php echo $venta_row->id; ?></p>
                                            <p class=""><b>Concepto: </b><?php echo $venta_row->concepto; ?></p>
                                            <p class=""><b>Método: </b><?php echo $venta_row->metodo_pago_nombre; ?></p>
                                            <p class=""><b>Cliente: </b><?php echo $venta_row->usuario_nombre; ?></p>
                                            <p class=""><b>Total: </b><?php echo $venta_row->total; ?></p>

                                            <p class="mt-3"><b>Modificar fecha de venta</b></p>

                                            <div class="row mb-2">
                                                <div class="col-md-5 mb-3">
                                                    <label for="venta_date">Fecha de venta</label>
                                                    <input type="date" class="form-control" name="venta_date" id="venta_date" placeholder="" value="<?php echo date('Y-m-d', strtotime($venta_row->fecha_venta)); ?>" required="">
                                                    <div class="invalid-feedback">
                                                        Por favor seleccione una fecha de venta válida.
                                                    </div>
                                                </div>
                                                <div class="col-md-5 mb-3">
                                                    <label for="venta_time">Hora de venta</label>
                                                    <input type="time" class="form-control" name="venta_time" id="venta_time" placeholder="" value="<?php echo date('H:i', strtotime($venta_row->fecha_venta)); ?>" required="">
                                                    <div class="invalid-feedback">
                                                        Por favor seleccione una hora de venta válida.
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-actions right">
                                                <a href="<?php echo site_url($regresar_a); ?>" class="btn btn-secondary btn-sm">Atras</a>
                                                <button type="submit" class="btn btn-secondary btn-sm">Guardar</button>
                                            </div>

                                        </div>

									<?php echo form_close(); ?>

								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</div>
