<div class="app-content container center-layout mt-2">
	<div class="content-wrapper">
		<div class="content-body">
			<section id="social-cards">
				<!-- Título y descripción -->
				<div class="row">
					<div class="col-12 mt-3 mb-1">
						<h4 class="text-uppercase">Nueva venta</h4>
						<p>Por favor llene correctamente todos los campos requeridos hasta completar la ficha de venta.</p>
					</div>
				</div>
				<div class="row mt-2">
					<!-- Panel de Información de venta -->
					<div class="col-md-4 order-md-2 mb-4">
						<h4 class="d-flex justify-content-between align-items-center mb-3">
							<span class="text-muted">Información de venta</span>
						</h4>
						<ul class="list-group mb-3">
							<li class="list-group-item d-flex justify-content-between align-items-center">
								<span><strong>Sucursal</strong></span>
								<span id="ficha_sucursal" class="text-muted"></span>
							</li>
							<li class="list-group-item d-flex justify-content-between align-items-center">
								<span><strong>Comprador</strong></span>
								<span id="ficha_nombre_compador" class="text-muted"></span>
							</li>
							<li class="list-group-item d-flex justify-content-between align-items-center">
								<span><strong>Producto</strong></span>
								<span id="ficha_nombre_producto" class="text-muted"></span>
							</li>
							<li class="list-group-item d-flex justify-content-between align-items-center">
								<span><strong>Costo unitario</strong></span>
								<span id="ficha_costo_unitario" class="text-muted"></span>
							</li>
							<li class="list-group-item d-flex justify-content-between align-items-center">
								<span><strong>Cantidad</strong></span>
								<span id="ficha_cantidad_a_vender" class="text-muted"></span>
							</li>
							<li class="list-group-item d-flex justify-content-between align-items-center">
								<span><strong>Total (MXN)</strong></span>
								<strong id="ficha_precio_total"></strong>
							</li>
							<li class="list-group-item d-flex justify-content-between align-items-center">
								<span><strong>Método de pago</strong></span>
								<span id="ficha_metodo_pago" class="text-muted"></span>
							</li>
							<li class="list-group-item d-flex justify-content-between align-items-center">
								<span><strong>Vendedor</strong></span>
								<span id="ficha_nombre_vendedor" class="text-muted"><?php echo $this->session->userdata('nombre_completo'); ?></span>
							</li>
						</ul>
					</div>
					<!-- Formulario de venta -->
					<div class="col-md-8 order-md-1">
						<h4 class="mb-3">Ficha de venta</h4>
						<?php echo form_open('ventas/crear', array('class' => 'needs-validation p-3 bg-white', 'id' => 'forma-crear-ventas', 'novalidate' => '')); ?>
						<?php if (validation_errors()) : ?>
							<div class="alert alert-danger alert-dismissible mb-2" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
								<?php echo validation_errors(); ?>
							</div>
						<?php endif; ?>

						<!-- Seleccionar Sucursal -->
						<div class="form-group">
							<label for="seleccionar_sucursal">Sucursal donde se registrará la venta. <span class="text-danger">*</span></label>
							<select name="seleccionar_sucursal" id="seleccionar_sucursal" class="select2 form-control" required>
								<option value="">Seleccionar una sucursal...</option>
								<?php
								$sucursal_asignada = $this->session->userdata('sucursal_asignada');
								foreach ($sucursales_list as $sucursal_row) :
									// Si hay sucursal asignada, se muestran solo las opciones que coincidan.
									if ($sucursal_asignada !== NULL && $sucursal_row->id != $sucursal_asignada) {
										continue;
									}
									// Se preselecciona la sucursal asignada.
									$selected = ($sucursal_asignada !== NULL && $sucursal_row->id == $sucursal_asignada)
										? 'selected'
										: set_select('seleccionar_sucursal', $sucursal_row->id);
								?>
									<option value="<?php echo $sucursal_row->id; ?>" data-sucursal="<?php echo $sucursal_row->nombre . ' [' . $sucursal_row->locacion . ']'; ?>" <?php echo $selected; ?>>
										<?php echo $sucursal_row->nombre . ' [' . $sucursal_row->locacion . ']'; ?>
									</option>
								<?php endforeach; ?>
							</select>
							<div class="invalid-feedback">Por favor seleccione una sucursal.</div>
						</div>


						<!-- Seleccionar Cliente -->
						<div class="form-group">
							<label for="seleccionar_cliente">Cliente al que se le realizará la venta <span class="text-danger">*</span></label>
							<select name="seleccionar_cliente" id="seleccionar_cliente" class="select2 form-control" required>
								<option value="">Seleccionar un cliente...</option>
								<?php foreach ($usuarios->result() as $usuario_row) : ?>
									<?php
									// Si el usuario tiene asignada una sucursal, mostrar solo los clientes de esa sucursal
									// if ($this->session->userdata('sucursal_asignada') !== NULL && $usuario_row->sucursal_id != $this->session->userdata('sucursal_asignada')) {
									// 	continue;
									// }
									?>
									<option value="<?php echo $usuario_row->id; ?>" data-nombre_completo="<?php echo $usuario_row->nombre_completo . ' ' . $usuario_row->apellido_paterno; ?>" <?php echo set_select('seleccionar_cliente', $usuario_row->id); ?>>
										<?php echo $usuario_row->id . ' - ' . $usuario_row->nombre_completo . ' ' . $usuario_row->apellido_paterno . ' ' . $usuario_row->apellido_materno . ' - ' . $usuario_row->correo . ' - ' . preg_replace('/[^0-9]/', '', $usuario_row->no_telefono); ?>
									</option>
								<?php endforeach; ?>
							</select>
							<div class="invalid-feedback">Por favor seleccione un cliente.</div>
						</div>

						<!-- Seleccionar Plan -->
						<div class="form-group">
							<label for="seleccionar_plan">Plan a vender <span class="text-danger">*</span></label>
							<select name="seleccionar_plan" id="seleccionar_plan" class="select2 form-control" required>
								<option value="">Seleccionar un plan a vender...</option>
								<?php foreach ($planes->result() as $plan_row) : ?>
									<?php
									// Filtrar planes según sucursal asignada, si la hay
									if ($this->session->userdata('sucursal_asignada') !== NULL && $plan_row->sucursal_id != $this->session->userdata('sucursal_asignada')) {
										continue;
									}
									?>
									<option value="<?php echo $plan_row->id; ?>" data-nombre="<?php echo $plan_row->nombre; ?>" data-costo="<?php echo $plan_row->costo; ?>" <?php echo set_select('seleccionar_plan', $plan_row->id); ?>>
										<?php echo $plan_row->id . ' - $' . $plan_row->costo . ' - ' . $plan_row->nombre; ?>
									</option>
								<?php endforeach; ?>
							</select>
							<div class="invalid-feedback">Por favor seleccione un plan.</div>
						</div>

						<hr class="mb-3">
						<!-- Método de pago en tres columnas -->
						<h4 class="mb-1">Método de pago <span class="text-danger">*</span></h4>
						<div class="row">
							<?php foreach ($metodos_pago->result() as $metodo) : ?>
								<div class="col-md-4">
									<div class="custom-control custom-radio">
										<input id="<?php echo $metodo->nombre; ?>" onchange="getRating(this)" data-metodos_pago="<?php echo $metodo->nombre; ?>" name="metodo_pago" value="<?php echo $metodo->id; ?>" type="radio" class="custom-control-input" required <?php echo set_radio('metodo_pago', $metodo->id); ?>>
										<label class="custom-control-label" for="<?php echo $metodo->nombre; ?>"><?php echo $metodo->nombre; ?></label>
									</div>
								</div>
							<?php endforeach; ?>
						</div>

						<hr class="mb-3">
						<!-- Activación del plan -->
						<div class="row">
							<div class="col-md-6 form-group">
								<label for="inicia_date">Fecha de activación del plan</label>
								<input type="date" class="form-control" name="inicia_date" id="inicia_date" value="<?php echo date('Y-m-d'); ?>" required>
								<div class="invalid-feedback">Seleccione una fecha válida.</div>
							</div>
							<div class="col-md-6 form-group">
								<label for="inicia_time">Hora de activación del plan</label>
								<input type="time" class="form-control" name="inicia_time" id="inicia_time" value="<?php echo date('H:i'); ?>" required>
								<div class="invalid-feedback">Seleccione una hora válida.</div>
							</div>
						</div>

						<?php if (es_administrador() or es_superadministrador()) : ?>
							<!-- Campos editables para administradores -->
							<div class="row">
								<div class="col-md-6 form-group">
									<label for="fecha_venta_date">Fecha de venta</label>
									<input type="date" class="form-control" name="fecha_venta_date" id="fecha_venta_date" value="<?php echo date('Y-m-d'); ?>" required>
									<div class="invalid-feedback">Seleccione una fecha válida.</div>
								</div>
								<div class="col-md-6 form-group">
									<label for="fecha_venta_time">Hora de venta</label>
									<input type="time" class="form-control" name="fecha_venta_time" id="fecha_venta_time" value="<?php echo date('H:i'); ?>" required>
									<div class="invalid-feedback">Seleccione una hora válida.</div>
								</div>
							</div>
						<?php else : ?>
							<!-- Campos de solo lectura para usuarios no administradores -->
							<div class="row">
								<div class="col-md-6 form-group">
									<label for="fecha_venta_date">Fecha de venta</label>
									<input type="date" class="form-control" name="fecha_venta_date" id="fecha_venta_date" value="<?php echo date('Y-m-d'); ?>" readonly>
								</div>
								<div class="col-md-6 form-group">
									<label for="fecha_venta_time">Hora de venta</label>
									<input type="time" class="form-control" name="fecha_venta_time" id="fecha_venta_time" value="<?php echo date('H:i'); ?>" readonly>
								</div>
							</div>
						<?php endif; ?>

						<!-- Acciones -->
						<div class="text-right">
							<a href="<?php echo site_url('ventas/index'); ?>" class="btn btn-secondary btn-sm">Regresar</a>
							<button type="submit" class="btn btn-success btn-sm">Vender</button>
						</div>
						<?php echo form_close(); ?>
					</div>
				</div>
			</section>
		</div>
	</div>
</div>