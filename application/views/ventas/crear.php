<div class="app-content container center-layout mt-2">
	<div class="content-wrapper">
		<div class="content-body">

			<section id="social-cards">
				<div class="row">
					<div class="col-12 mt-3 mb-1">
						<h4 class="text-uppercase">Nueva venta</h4>
						<p>Por favor llene correctamente todos los campos requeridos hasta completar la ficha de venta.</p>
					</div>
				</div>
				<div class="row mt-2">
					<div class="col-md-4 order-md-2 mb-4">
						<h4 class="d-flex justify-content-between align-items-center mb-3">
							<span class="text-muted">Información de venta</span>
							<!--span class="badge badge-danger badge-pill">3</span-->
						</h4>
						<ul class="list-group mb-3 card">
							<li class="list-group-item d-flex justify-content-between lh-condensed">
								<div>
									<h6 class="my-0">Sucursal</h6>
								</div>
								<span name="ficha_sucursal" id="ficha_sucursal" class="text-muted"></span>
							</li>
							<li class="list-group-item d-flex justify-content-between lh-condensed">
								<div>
									<h6 class="my-0">Comprador</h6>
								</div>
								<span name="ficha_nombre_compador" id="ficha_nombre_compador" class="text-muted"></span>
							</li>
							<li class="list-group-item d-flex justify-content-between lh-condensed">
								<div>
									<h6 class="my-0">Producto</h6>
								</div>
								<span name="ficha_nombre_producto" id="ficha_nombre_producto" class="text-muted"></span>
							</li>
							<li class="list-group-item d-flex justify-content-between lh-condensed">
								<div>
									<h6 class="my-0">Costo unitario</h6>
								</div>
								<span name="ficha_costo_unitario" id="ficha_costo_unitario" class="text-muted"></span>
							</li>
							<li class="list-group-item d-flex justify-content-between lh-condensed">
								<div>
									<h6 class="my-0">Cantidad</h6>
								</div>
								<span name="ficha_cantidad_a_vender" id="ficha_cantidad_a_vender" class="text-muted"></span>
							</li>
							<li class="list-group-item d-flex justify-content-between">
								<span>Total (MXNºº)</span>
								<strong name="ficha_precio_total" id="ficha_precio_total"></strong>
							</li>
							<li class="list-group-item d-flex justify-content-between lh-condensed">
								<div>
									<h6 class="my-0">Método de pago</h6>
								</div>
								<span name="ficha_metodo_pago" id="ficha_metodo_pago" class="text-muted"></span>
							</li>
							<li class="list-group-item d-flex justify-content-between lh-condensed">
								<div>
									<h6 class="my-0">Nombre del vendedor</h6>
								</div>
								<span name="ficha_nombre_vendedor" id="ficha_nombre_vendedor" class="text-muted"><?php echo $this->session->userdata('nombre_completo'); ?></span>
							</li>
						</ul>

						<!--form class="card p-2">
							<div class="input-group">
								<input type="text" class="form-control" placeholder="Promo code">
								<div class="input-group-append">
									<button type="submit" class="btn btn-secondary">Redeem</button>
								</div>
							</div>
						</form-->
					</div>
					<div class="col-md-8 order-md-1">
						<h4 class="mb-3">Ficha de venta</h4>
						<?php echo form_open('ventas/crear', array('class' => 'needs-validation p-2 bg-white card', 'id' => 'forma-crear-ventas', 'novalidate' => '')); ?>
						<?php if (validation_errors()) : ?>
							<div class="alert bg-danger alert-icon-left alert-dismissible mb-2 font-small-3" role="alert">
								<span class="alert-icon"><i class="fa fa-thumbs-o-down"></i></span>
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">×</span>
								</button>
								<?php echo validation_errors(); ?>
							</div>
						<?php endif ?>

						<div class="mb-3">
							<label for="seleccionar_sucursal">Sucursal donde se registrará la venta. <span class="red">*</span></label>
							<select name="seleccionar_sucursal" id="seleccionar_sucursal" class="select2 form-control" required="">
								<option value="">Seleccionar una sucursal...</option>

								<?php foreach ($sucursales_list as $sucursal_row) : ?>

									<?php if ($this->session->userdata('sucursal_asignada') == NULL) : ?>
										<option value="<?php echo $sucursal_row->id; ?>" data-sucursal="<?php echo $sucursal_row->nombre . ' [' . $sucursal_row->locacion . ']'; ?>" <?php echo set_select('seleccionar_sucursal', $sucursal_row->id); ?>><?php echo $sucursal_row->nombre . ' [' . $sucursal_row->locacion . ']'; ?></option>
									<?php else : ?>
										<?php if ($this->session->userdata('sucursal_asignada') == $sucursal_row->id) : ?>
											<option value="<?php echo $sucursal_row->id; ?>" data-sucursal="<?php echo $sucursal_row->nombre . ' [' . $sucursal_row->locacion . ']'; ?>" <?php echo set_select('seleccionar_sucursal', $sucursal_row->id); ?>><?php echo $sucursal_row->nombre . ' [' . $sucursal_row->locacion . ']'; ?></option>
										<?php endif; ?>
									<?php endif; ?>

								<?php endforeach; ?>

							</select>
							<div class="invalid-feedback">
								Por favor seleccione una sucursal válido para proceder con la venta.
							</div>
						</div>

						<div class="mb-3">
							<label for="seleccionar_cliente">Cliente al que se le realizará la venta <span class="red">*</span></label>
							<select name="seleccionar_cliente" id="seleccionar_cliente" class="select2 form-control" required="">
								<option value="">Seleccionar un cliente...</option>
								<?php foreach ($usuarios->result() as $usuario_row) : ?>
									<option value="<?php echo $usuario_row->id; ?>" data-nombre_completo="<?php echo $usuario_row->nombre_completo . ' ' . $usuario_row->apellido_paterno; ?>" <?php echo set_select('seleccionar_cliente', $usuario_row->id); ?>><?php echo $usuario_row->id . ' - ' . $usuario_row->nombre_completo . ' ' . $usuario_row->apellido_paterno . ' ' . $usuario_row->apellido_materno . ' - ' . $usuario_row->correo . ' - ' . preg_replace('/[^0-9]/', '', $usuario_row->no_telefono); ?></option>
								<?php endforeach; ?>
							</select>
							<div class="invalid-feedback">
								Por favor seleccione un usuario válido para proceder con la venta.
							</div>
						</div>

						<div class="mb-3">
							<label for="seleccionar_plan">Plan a vender <span class="red">*</span></label>
							<select name="seleccionar_plan" id="seleccionar_plan" class="select2 form-control" required="">
								<option value="">Seleccionar un plan a vender...</option>
								<?php foreach ($planes->result() as $plan_row) : ?>
									<option value="<?php echo $plan_row->id; ?>" data-nombre="<?php echo $plan_row->nombre; ?>" data-costo="<?php echo $plan_row->costo; ?>" <?php echo set_select('seleccionar_plan', $plan_row->id); ?>><?php echo $plan_row->id . ' - $' . $plan_row->costo . ' - ' . $plan_row->nombre; ?></option>
								<?php endforeach; ?>
							</select>
							<div class="invalid-feedback">
								Por favor seleccione un plan válido para proceder con la venta.
							</div>
						</div>

						<hr class="mb-4">
						<h4 class="mb-1">Método de pago <span class="red">*</span></h4>

						<div class="d-block my-2">
							<?php foreach ($metodos_pago->result() as $metodo) : ?>
								<div class="custom-control custom-radio">
									<input id="<?php echo $metodo->nombre; ?>" onchange="getRating(this)" data-metodos_pago="<?php echo $metodo->nombre; ?>" name="metodo_pago" value="<?php echo $metodo->id; ?>" type="radio" class="custom-control-input" required="" <?php echo set_radio('metodo_pago', $metodo->id); ?>>
									<label class="custom-control-label" for="<?php echo $metodo->nombre; ?>"><?php echo $metodo->nombre; ?></label>
								</div>
							<?php endforeach; ?>
						</div>

						<hr class="mb-4">

						<div class="row">
							<div class="col-md-5 mb-3">
								<label for="inicia_date">Fecha de activación del plan</label>
								<input type="date" class="form-control" name="inicia_date" id="inicia_date" placeholder="" value="<?php echo date('Y-m-d'); ?>" required="">
								<div class="invalid-feedback">
									Por favor seleccione una fecha de activación del plan válida para proceder con la venta.
								</div>
							</div>
							<div class="col-md-5 mb-3">
								<label for="inicia_time">Hora de activación del plan</label>
								<input type="time" class="form-control" name="inicia_time" id="inicia_time" placeholder="" value="<?php echo date('H:i'); ?>" required="">
								<div class="invalid-feedback">
									Por favor seleccione una hora de activación del plan válida para proceder con la venta.
								</div>
							</div>
						</div>

						<div class="form-actions right">
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

<script>
	// Example starter JavaScript for disabling form submissions if there are invalid fields
	(function() {
		'use strict';

		window.addEventListener('load', function() {
			// Fetch all the forms we want to apply custom Bootstrap validation styles to
			var forms = document.getElementsByClassName('needs-validation');

			// Loop over them and prevent submission
			var validation = Array.prototype.filter.call(forms, function(form) {
				form.addEventListener('submit', function(event) {
					if (form.checkValidity() === false) {
						event.preventDefault();
						event.stopPropagation();
					}
					form.classList.add('was-validated');
				}, false);
			});
		}, false);
	})();
</script>