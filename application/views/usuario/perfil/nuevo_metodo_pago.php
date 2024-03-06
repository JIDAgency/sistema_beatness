<div class="app-content container center-layout mt-2 b3-ux-v2-fondo">
    <div class="content-wrapper">
        <div class="content-body">
        
        <?php $this->load->view('_comun/mensajes_alerta'); ?>
        <?php if (validation_errors()): ?>
            <div class="alert bg-danger alert-icon-left alert-dismissible mb-2 font-small-3" role="alert">
                <span class="alert-icon"><i class="fa fa-thumbs-o-down"></i></span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <?php echo validation_errors(); ?>
            </div>
        <?php endif; ?>

            <div id="user-profile">

                <div class="row">
                    <div class="col-12">
                        <div class="card border-transparent profile-with-cover bg-transparent shadow-none">

                            <div class="card-img-top img-fluid bg-cover height-300" style="background: url('<?php echo base_url().'subidas/banner/banner-b3.jpg'; ?>') 50%;"></div>
                            
                            <div class="media profil-cover-details w-100">

                                <div class="media-left pl-2 pt-2">
                                    <a href="<?php echo site_url('usuario/perfil'); ?>" class="profile-image">
                                        <img src="<?php echo base_url().'subidas/perfil/'.$this->session->userdata('nombre_imagen_avatar'); ?>" class="rounded-circle img-border height-100" alt="Card image">
                                    </a>
                                </div>

                                <div class="media-body pt-3 px-2">
                                    <div class="row">
                                        <div class="col">
                                            <h3 class="card-title"><?php echo $this->session->userdata('nombre_completo'); ?></h3>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <nav class="navbar navbar-light navbar-profile align-self-end">

                                <button class="navbar-toggler d-sm-none" type="button" data-toggle="collapse" aria-expanded="false" aria-label="Toggle navigation"></button>
                                <nav class="navbar navbar-expand-lg">
                                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                        <ul class="navbar-nav mr-auto">
                                            <li class="nav-item">
                                                <a class="nav-link" href="<?php echo site_url('usuario/perfil'); ?>"><i class="fa fa-user"></i> Perfil</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="<?php echo site_url('usuario/perfil/planes'); ?>"><i class="fa fa-briefcase"></i> Planes</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="<?php echo site_url('usuario/perfil/metodos_pago'); ?>"><i class="fa fa-credit-card-alt"></i> Métodos de pago</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="<?php echo site_url('usuario/perfil/cambiar_contrasenia'); ?>"><i class="fa fa-unlock-alt"></i> Cambiar contraseña</a>
                                            </li>
                                        </ul>
                                    </div>
                                </nav>

                            </nav>


                            <div class="card-body border-top-blue-grey border-top-lighten-5">


                                <?php echo form_open($controlador, array('class' => 'form form-horizontal needs-validation card-form p-2 bg-white card', 'id' => 'payment-form', 'novalidate' => '')); ?>

                                    <h4 class="text-uppercase mb-3"><strong>Agregar un nuevo método de pago</strong></h4>

                                    <div class="row">

                                        <div class="col-xl-5 col-md-6 col-12 mb-2">
                                            <div class="mb-2">
                                                <div class='card-wrapper'></div>
                                            </div>

                                            <div class="mb-2 text-center">
                                                <img src="<?php echo base_url(); ?>/assets/img/openpay/openpay.png" alt="">
                                                <img src="<?php echo base_url(); ?>/assets/img/openpay/cards1.png" alt="">
                                                <br>
                                            </div>
                                        </div>

                                        <div class="col-xl-7 col-md-6 col-12 mb-2">

                                            <input type="hidden" readonly class="form-control" name="token_id" id="token_id">

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

                                        </div>

                                        
                                    </div>
                                    
                                    <div class="form-actions center">
                                        <a href="<?php echo site_url($regresar_a); ?>" class="btn btn-secondary border-transparent square btn-min-width text-center text-uppercase mr-1 mb-1"><strong><em>Atrás</em></strong></a>
                                        <button id="pay-button" class="btn btn-cyan btn-accent-2 border-cyan border-accent-2 black square btn-min-width btn-glow text-center text-uppercase mr-1 mb-1"><strong><em>Guardar</em></strong></button>
                                    </div>
                                <?php echo form_close(); ?>

                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>