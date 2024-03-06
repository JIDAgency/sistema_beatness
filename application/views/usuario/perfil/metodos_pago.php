<div class="app-content container center-layout mt-2 b3-ux-v2-fondo">
    <div class="content-wrapper">
        <div class="content-body">
        
        <?php $this->load->view('_comun/mensajes_alerta'); ?>

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

                                <div class="row">
                                
                                    <div class="col-12">

                                        <h4 class="text-uppercase  mb-3"><strong>Tus métodos de pago</strong></h4>

                                        <div class="row">
                                        
                                            <div class="col-xl-3 col-md-6 col-12">
                                            </div>

                                            <div class="col-xl-6 col-md-6 col-12">

                                                <div class="">
                                                    <div class="list-group">

                                                    <?php if ($tarjetas_registradas_list->num_rows() <= 0): ?>
                                                
                                                        <div class="text-center center">
                                                            <p class="text-muted"><em>Por favor añada un método de pago (Tarjeta de Crédito / Débito). Haga clic en <a href="<? echo site_url('usuario/perfil/nuevo_metodo_pago'); ?>" class=""><strong><u>Añadir.</u></strong></a></em></p>
                                                        </div>

                                                    <?php else: ?>
                                                        <?php foreach ($tarjetas_registradas_list->result() as $tarjeta_registrada_row): ?>

                                                            <div class="list-group-item list-group-item-action flex-column align-items-start <?php echo $tarjeta_registrada_row->openpay_tarjeta_id == $datos_asignacion_row->openpay_tarjeta_id ? 'active' : ''; ?>">
                                                                
                                                                <div class="d-flex w-100 justify-content-between">
                                                                    <h5 class="text-bold-600 <?php echo $tarjeta_registrada_row->openpay_tarjeta_id == $datos_asignacion_row->openpay_tarjeta_id ? 'white' : ''; ?>">Tarjeta con terminación ****<?php echo $tarjeta_registrada_row->terminacion_card_number; ?></h5>
                                                                    <small><?php echo $tarjeta_registrada_row->openpay_expiration_month.' / '.$tarjeta_registrada_row->openpay_expiration_year; ?></small>
                                                                </div>

                                                                <div class="d-flex w-100 justify-content-between">

                                                                    <p><?php echo $tarjeta_registrada_row->openpay_holder_name; ?></p>

                                                                    <?php if (isset($datos_asignacion_row)) : ?>
                                                                        <?php if ($tarjeta_registrada_row->openpay_tarjeta_id != $datos_asignacion_row->openpay_tarjeta_id) : ?>
                                                                            <div class="text-right right">
                                                                                <a href="<?php echo site_url('usuario/perfil/eliminar_metodo_pago/'.$tarjeta_registrada_row->openpay_tarjeta_id); ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></a>
                                                                            </div>
                                                                        <?php endif; ?>
                                                                    <?php else: ?>
                                                                        <div class="text-right right">
                                                                            <a href="<?php echo site_url('usuario/shop'); ?>" class="btn btn-warning btn-sm"><i class="fa fa-shopping-bag"></i></a>
                                                                            <a href="<?php echo site_url('usuario/perfil/eliminar_metodo_pago/'.$tarjeta_registrada_row->openpay_tarjeta_id); ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></a>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                    
                                                                </div>

                                                            </div>

                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                    <br>
                                                    <p class="text-center text-muted font-small-2 "><em><a href="<?php echo site_url('usuario/perfil/planes'); ?>"><i class="fa fa-arrow-circle-right"></i> Planes y suscripciones.</a></em></p>

                                                    </div>
                                                </div>
                                                
                                            </div>

                                            <div class="col-xl-3 col-md-6 col-12">
                                            </div>

                                        </div>

                                        <div class="form-group text-right right mt-5">
                                            <a href="<?php echo site_url($regresar_a); ?>" class="btn btn-secondary border-transparent square btn-min-width text-center text-uppercase mr-1 mb-1"><strong><em>Atrás</em></strong></a>
                                            <a href="<?php echo site_url('usuario/perfil/nuevo_metodo_pago'); ?>" class="btn btn-cyan btn-accent-2 border-cyan border-accent-2 black square btn-min-width btn-glow text-center text-uppercase mr-1 mb-1"><strong><em>Añadir</em></strong></a>
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>