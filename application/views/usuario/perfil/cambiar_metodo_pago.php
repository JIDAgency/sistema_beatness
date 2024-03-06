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
                                <?php echo form_open($controlador, array('class' => 'form form-horizontal needs-validation card-form p-2 bg-white card', 'id' => 'cambiar-metodo-pago', 'novalidate' => '')); ?>

                                    <div class="row">
                                    
                                        <div class="col-12">

                                            <h4 class="text-uppercase  mb-3"><strong>Mi suscripción</strong></h4>

                                            <div class="row match-height">

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

                                                </div>

                                                <div class="col-lg-6 col-md-12">

                                                    <h4 class="text-uppercase  mb-1"><strong>Actualiza tu suscripción</strong></h4>
                                                    
                                                    <?php if ($tarjetas_registradas_list->num_rows() != 0): ?>

                                                        <div class="d-block my-2">

                                                            <p class="text-justify">Seleccione el método de pago para la suscripción: <span>*</span></p>

                                                            <input type="hidden" class="form-control" name="suscripcion_id" id="suscripcion_id" placeholder="" value="<?php echo $data_suscripcion_row->openpay_suscripcion_id; ?>" required="" readonly="readonly">

                                                            <?php foreach ($tarjetas_registradas_list->result() as $tarjeta_registrada_row): ?>
                                                                <div class="custom-control custom-radio mb-1">
                                                                    <input id="metodo_pago_<?php echo $tarjeta_registrada_row->id; ?>" name="metodo_pago" type="radio" class="custom-control-input" <?php echo set_radio('metodo_pago', $tarjeta_registrada_row->id, $tarjeta_registrada_row->openpay_tarjeta_id == $data_suscripcion_row->openpay_tarjeta_id); ?> value="<?php echo $tarjeta_registrada_row->id; ?>" required="">
                                                                    <label class="custom-control-label" for="metodo_pago_<?php echo $tarjeta_registrada_row->id; ?>">Tarjeta con terminación <?php echo $tarjeta_registrada_row->terminacion_card_number; ?>
                                                                        <span class="tab"><?php echo $tarjeta_registrada_row->openpay_expiration_month.' / '.$tarjeta_registrada_row->openpay_expiration_year; ?></span>
                                                                        <br><?php echo $tarjeta_registrada_row->openpay_holder_name; ?>
                                                                    </label>
                                                                    <div class="invalid-feedback">
                                                                        Es necesario seleccionar un método de pago válido.
                                                                    </div>
                                                                </div>
                                                            <?php endforeach; ?>
                                                        </div>

                                                    <?php endif; ?>

                                                    <p class="text-justify text-muted font-small-2 "><em></em></p>
                                                    <br>
                                                    <p class="text-justify text-muted font-small-2 "><em><a href="<?php echo site_url('usuario/perfil/metodos_pago'); ?>"><i class="fa fa-plus-circle"></i> Agregar método de pago.</a></em></p>
                                                    
                                                </div>

                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-actions text-right right">
                                        <a href="<?php echo site_url($regresar_a); ?>" class="btn btn-secondary border-transparent square btn-min-width text-center text-uppercase mr-1 mb-1"><strong><em>Atrás</em></strong></a>
                                        <button type="submit" class="btn btn-cyan btn-accent-2 border-cyan border-accent-2 black square btn-min-width btn-glow text-center text-uppercase mr-1 mb-1"><strong><em>Guardar</em></strong></button>
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