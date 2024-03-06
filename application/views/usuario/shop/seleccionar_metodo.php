<div class="app-content container center-layout mt-2 b3-ux-v2-fondo">
    <div class="content-wrapper">

        <?php
            if ($tiene_suscripcion_activa == 'activo') {
                $this->session->set_flashdata('MENSAJE_INFO', 'Ya cuentas con una suscripción activa.');
                redirect('usuario/inicio');
            } elseif ($tiene_suscripcion_activa == 'rechazado') {
                $this->session->set_flashdata('MENSAJE_ERROR', 'Es necesario actualizar tu método de pago.');
                redirect('usuario/inicio');
            }
        ?>

        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo site_url('usuario/inicio'); ?>">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo site_url($regresar_a); ?>">Comprar</a></li>
                            <li class="breadcrumb-item active">Seleccionar método de pago</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-body">

            <?php echo form_open($controlador, array('class' => 'form form-horizontal needs-validation card-form p-2 bg-white card', 'id' => 'payment-form', 'novalidate' => '')); ?>
                <?php $this->load->view('_comun/mensajes_alerta'); ?>
                <?php if (validation_errors()): ?>
                    <div class="alert bg-danger alert-icon-left alert-dismissible mb-2 font-small-3" role="alert">
                        <span class="alert-icon"><i class="fa fa-thumbs-o-down"></i></span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <?php echo validation_errors(); ?>
                    </div>
                <?php endif?>
                <!-- Contenido -->

                <!--div class="row">
                    <div class="col-12 mt-1 mb-3">
                        <h4 class="text-uppercase">Adquiere <?php echo $suscripcion_row->nombre; ?></h4>
                        <p class="text-muted">Seleccionar método de pago</p>
                    </div>
                </div-->

                <div class="row">
                    <div class="col-xl-4 col-md-6 col-12 mb-2">
                        <!--h4 class="text-uppercase mb-1"><strong><?php echo $suscripcion_row->nombre; ?></strong></h4>
                        <p class="text-justify"><?php echo $suscripcion_row->descripcion; ?></p>
                        <p class="font-small-3"><em>Mensualidad: $<?php echo $suscripcion_row->costo; ?></em></p-->

                        <img src="<?php echo base_url(); ?>assets/img/banners/b3-home-info-plan.jpg" class="img-fluid">
                    </div>

                    <div class="col-xl-4 col-md-6 col-12 mb-2">
                        <h4 class="text-uppercase mb-1"><strong>Registra un método de pago</strong></h4>

                        <?php if ($tarjetas_registradas_list->num_rows() != 0): ?>

                            <div class="text-center mb-2">
                            <?php if ($tarjetas_registradas_list->num_rows() == 1): ?>
                                <p>Usted ya tiene <strong><?php echo $tarjetas_registradas_list->num_rows(); ?></strong> tarjeta registrada</p>
                            <?php else: ?>        
                                <p>Usted ya tiene <strong><?php echo $tarjetas_registradas_list->num_rows(); ?></strong> tarjetas registradas</p>
                            <?php endif; ?>
                            <a href="<?php echo site_url('usuario/shop/proceder_pago/'.$suscripcion_row->id); ?>"><u>Ir a seleccionar</u></a>
                            </div>

                            <?php if ($tarjetas_registradas_list->num_rows() < 3): ?>

                                <h6 class="card-subtitle line-on-side text-muted text-center font-small-3">
                                    <span>ó</span>
                                </h6>

                            <?php endif; ?>

                        <?php endif; ?>

                        <input type="hidden" readonly class="form-control" name="token_id" id="token_id">

                        <input type="hidden" readonly class="form-control" name="id" id="id" placeholder="Plan seleccionado" value="<?php echo $suscripcion_row->id; ?>" readonly="readonly" required="">
                        
                        

                        <?php if ($tarjetas_registradas_list->num_rows() < 3): ?>

                        <div class="mb-2">
                            <div class='card-wrapper'></div>
                        </div>

                        <div class="mb-2">
                            <div class="form-group row">
                                <label for="nombre_tarjeta" class="col-md-4">Nombre en la tarjeta <span class="red">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control card-name" name="name" id="nombre_tarjeta" placeholder="Nombre" value="<?php echo set_value('nombre_tarjeta'); ?>" data-openpay-card="holder_name" required="">
                                    <div class="invalid-feedback">
                                        Ingrese el nombre que aparece impreso en la tarjeta.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-2">
                            <div class="form-group row">
                                <label for="numero_tarjeta" class="col-md-4">Número de tarjeta <span class="red">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control card-number" name="number" id="numero_tarjeta" placeholder="XXXX XXXX XXXX XXXX" value="<?php echo set_value('numero_tarjeta'); ?>" maxLength="19" required="">
                                    <input type="hidden" readonly class="form-control" name="no_tarjeta" id="no_tarjeta"  data-openpay-card="card_number">
                                    <div class="invalid-feedback">
                                        Se requiere un número de tarjeta válido.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-2">
                            <div class="form-group row">
                                <label for="codigo_verificacion" class="col-md-4">Código de verificación <span class="red">*</span></label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control card-cvc" name="cvc" id="codigo_verificacion" placeholder="cvc/cvv2" value="<?php echo set_value('codigo_verificacion'); ?>" maxLength="4" data-openpay-card="cvv2" srequired="">
                                    <div class="invalid-feedback">
                                        Se requiere un código de verificación válido.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-2">
                            <div class="form-group row">
                                <label for="fecha_expiracion" class="col-md-4">Fecha de vencimiento <span class="red">*</span></label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control card-expiry" name="expiry" id="fecha_expiracion" placeholder="mm / aa" value="<?php echo set_value('fecha_expiracion'); ?>" maxLength="7" required="">
                                    <input type="hidden" readonly class="form-control" name="mes_expiracion" id="mes_expiracion" data-openpay-card="expiration_month">
                                    <input type="hidden" readonly class="form-control" name="anio_expiracion" id="anio_expiracion" data-openpay-card="expiration_year">
                                    <div class="invalid-feedback">
                                        Se requiere un fecha de vencimiento válido.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-2 text-center">
                            <img src="<?php echo base_url(); ?>/assets/img/openpay/openpay.png" alt="">
                            <img src="<?php echo base_url(); ?>/assets/img/openpay/cards1.png" alt="">
                            <br>
                        </div>

                        <div class="form-actions center">
                            <button id="pay-button" class="btn btn-info btn-min-width mr-1 mb-1">Guardar</button>
                        </div>

                        <?php endif; ?>

                    </div>
                    
                    <div class="col-xl-4 col-md-6 col-12 mb-2">
                        <h4 class="text-uppercase grey lighten-2 mb-1"><strong>¡Activa tu plan ahora!</strong></h4>
                        
                        <?php if ($tarjetas_registradas_list->num_rows() != 0): ?>

                            <div class="d-block my-2">

                                <p class="text-justify grey lighten-2">Seleccionar tarjeta: <span>*</span></p>

                                <?php foreach ($tarjetas_registradas_list->result() as $tarjeta_registrada_row): ?>
                                    <div class="custom-control custom-radio">
                                        <input id="null" name="paymentMethod" type="radio" class="custom-control-input" disabled>
                                        <label class="custom-control-label grey lighten-2" for="null">Tarjeta con terminación <?php echo $tarjeta_registrada_row->terminacion_card_number; ?></label>
                                        <span class="grey lighten-2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $tarjeta_registrada_row->openpay_expiration_month; ?> / <?php echo $tarjeta_registrada_row->openpay_expiration_year; ?></span>
                                        <p class="grey lighten-2"><?php echo $tarjeta_registrada_row->openpay_holder_name; ?> </p>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                        <?php endif; ?>

                        <p class="text-justify grey lighten-2"><?php echo branding(); ?> usa una proveedor de servicios para pagos online de OpenPay el cual realizará una autorización temporal para verificar tu tarjeta, solo se trata de una autorización y NO de un cargo. Es posible que tu banco te notifique de esta autorización.</p>
                        <p class="text-justify grey lighten-2"><?php echo branding(); ?> a través del proveedor de servicios para pagos online de OpenPay te cobrará de forma automática la mensualidad de tu suscripción hasta ser cancelada. El cargo se realizará una vez concluido el periodo de prueba.</p>
                        <p class="text-justify grey lighten-2">Consulta los términos y condiciones a través de este enlace: <a href="//<?php echo terminos_y_condiciones(); ?>" target="_blank" rel="noopener noreferrer">Terminos y condiciones</a>. Si necesitas ayuda o quieres realizar una cancelación comunícate al <?php echo contacto_soporte_numero(); ?>.</p>
                        <p class="text-justify font-small-2 grey lighten-2"><em>Al hacer clic acepto que estoy de acuerdo con la recopilación de mis datos financieros por parte de <?php echo branding(); ?> y OpenPay para uso en los propósitos previamente expresados. Tales propósitos se encuentran detallados en la política de privacidad de <?php echo branding(); ?>.</em></p>
                    </div>
                </div>

                <!-- / Contenido -->

                <?php print_r($card); ?>
            <?php echo form_close(); ?>

        </div>
    </div>
</div>
