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

                                        <h4 class="text-uppercase  mb-3"><strong>Mi suscripción</strong></h4>
                                        
                                        <?php if (!$data_suscripcion_row AND !$data_suscripcion_fd_row): ?>
                                                
                                            <div class="text-center center">
                                                <p class="text-muted"><em>Aún no cuentas con una suscripción,  ¡Adquierela ahora!. Haga clic en <a href="<? echo site_url('usuario/shop'); ?>" class=""><strong><u><i class="fa fa-shopping-bag"></i> Comprar.</u></strong></a></em></p>
                                            </div>

                                        <?php elseif($data_suscripcion_row): ?>

                                            <div class="row match-height">

                                                <div class="col-lg-3 col-md-12">
                                                </div>

                                                <div class="col-lg-6 col-md-12">
                                                    
                                                    <h4 class="card-title"><strong><em><?php echo $data_suscripcion_row->nombre; ?></em></strong></h4>
                                                    <ul class="list-group">
                                                        <li class="list-group-item">
                                                            <span class="float-right"><strong><em>****<?php echo $data_suscripcion_row->terminacion_tarjeta.'&nbsp; &nbsp;'.$data_suscripcion_row->mes_expiracion.'/'.$data_suscripcion_row->anio_expiracion; ?></em></strong></span>
                                                            Método de pago
                                                        </li>
                                                        <li class="list-group-item">
                                                            <span class="float-right"><strong><em><?php echo $data_suscripcion_row->suscripcion_fecha_de_actualizacion != '0000-00-00 00:00:00' ? $data_suscripcion_row->suscripcion_fecha_de_actualizacion : ''; ?></em></strong></span>
                                                            Última renovación
                                                        </li>
                                                        <li class="list-group-item">
                                                            <?php if($data_suscripcion_row->suscripcion_estatus_del_pago == 'prueba'): ?>
                                                                <span class="badge badge-warning badge-pill float-right"><strong><em>7 días de prueba</em></strong></span>
                                                            <?php elseif($data_suscripcion_row->suscripcion_estatus_del_pago == 'pagado'): ?>
                                                                <span class="badge badge-success badge-pill float-right"><strong><em>Activo</em></strong></span>
                                                            <?php elseif($data_suscripcion_row->suscripcion_estatus_del_pago == 'rechazado'): ?>
                                                                <span class="red float-right"><strong><em>Renueve su método de pago</em></strong></span>
                                                            <?php endif; ?>
                                                            Estatus
                                                        </li>
                                                        <li class="list-group-item">
                                                            <span class="badge badge-secondary badge-pill float-right"><strong><em><?php echo $data_suscripcion_row->clases_usadas; ?></em></strong></span>
                                                            Clases vistas
                                                        </li>
                                                        <li class="list-group-item">
                                                            <span class="float-right"><strong><em>Bike, Body, Funcional y Yoga</em></strong></span>
                                                            Disciplinas incluidas
                                                        </li>
                                                        <li class="list-group-item">
                                                            <span class="float-right"><strong><em><?php echo date('d/m/Y', strtotime($data_suscripcion_row->fecha_activacion)); ?></em></strong></span>
                                                            Fecha de activación
                                                        </li>
                                                    </ul>
                                                    <div class="form-actions mt-2 text-center center">
                                                        <a href="<?php echo site_url('usuario/perfil/cambiar_metodo_pago/'.$data_suscripcion_row->openpay_suscripcion_id); ?>" class="btn btn-cyan btn-accent-2 border-cyan border-accent-2 black square btn-min-width btn-glow text-center text-uppercase mr-1 mb-1"><strong><em>Editar</em></strong></a>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-md-12">
                                                </div>


                                            </div>

                                        <?php elseif($data_suscripcion_fd_row): ?>
                                            <div class="row match-height mb-3">

                                                <div class="col-lg-3 col-md-12">
                                                </div>

                                                <div class="col-lg-6 col-md-12">
                                                    
                                                    <h4 class="card-title"><strong><em><?php echo $data_suscripcion_fd_row->nombre; ?></em></strong></h4>
                                                    <ul class="list-group">
                                                        <li class="list-group-item">
                                                            <span class="float-right"><strong><em>FrontDesk</em></strong></span>
                                                            Método de pago
                                                        </li>
                                                        <li class="list-group-item">
                                                            <span class="float-right"><strong><em><?php echo $data_suscripcion_fd_row->modalidad ?></em></strong></span>
                                                            Modalidad
                                                        </li>
                                                        <li class="list-group-item">
                                                            <?php if($data_suscripcion_fd_row->suscripcion_estatus_del_pago == 'prueba'): ?>
                                                                <span class="badge badge-warning badge-pill float-right"><strong><em>7 días de prueba</em></strong></span>
                                                            <?php elseif($data_suscripcion_fd_row->suscripcion_estatus_del_pago == 'pagado'): ?>
                                                                <span class="badge badge-success badge-pill float-right"><strong><em>Activo</em></strong></span>
                                                            <?php elseif($data_suscripcion_fd_row->suscripcion_estatus_del_pago == 'rechazado'): ?>
                                                                <span class="red float-right"><strong><em>Renueve su método de pago</em></strong></span>
                                                            <?php endif; ?>
                                                            Estatus
                                                        </li>
                                                        <li class="list-group-item">
                                                            <span class="badge badge-secondary badge-pill float-right"><strong><em><?php echo $data_suscripcion_fd_row->clases_usadas; ?></em></strong></span>
                                                            Clases vistas
                                                        </li>
                                                        <li class="list-group-item">
                                                            <span class="float-right"><strong><em>Bike, Body, Funcional y Yoga</em></strong></span>
                                                            Disciplinas incluidas
                                                        </li>
                                                        <li class="list-group-item">
                                                            <span class="float-right"><strong><em><?php echo date('d/m/Y', strtotime($data_suscripcion_fd_row->fecha_activacion)); ?></em></strong></span>
                                                            Fecha de activación
                                                        </li>
                                                    </ul>
                                                    <div class="mt-2 text-center center">
                                                        <p class='text-muted'><small><em>Esta es una suscripción de cortesía, para más información consulte en <strong>FrontDesk</strong>.</em></small></p>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-md-12">
                                                </div>


                                            </div>
                                        <?php endif; ?>

                                    </div>

                                </div>

                                <hr>

                                    <div class="form-actions text-right right">
                                        <a href="<?php echo site_url($regresar_a); ?>" class="btn btn-secondary border-transparent square btn-min-width text-center text-uppercase mr-1 mb-1"><strong><em>Atrás</em></strong></a>
                                    </div>

                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>