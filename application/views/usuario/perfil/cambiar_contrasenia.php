<div class="app-content container center-layout mt-2 b3-ux-v2-fondo">
    <div class="content-wrapper">
        <div class="content-body">

            <?php $this->load->view('_comun/mensajes_alerta'); ?>
            <?php if (validation_errors() || isset($validation_errors)): ?>
                <div class="alert bg-danger alert-icon-left alert-dismissible mb-2 font-small-3" role="alert">
                    <span class="alert-icon"><i class="fa fa-thumbs-o-down"></i></span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <?php echo validation_errors() ? validation_errors() : $validation_errors; ?>
                </div>
            <?php endif?>

            <div id="user-profile">

                <div class="row">
                    <div class="col-12">
                        <div class="card border-transparent profile-with-cover bg-transparent shadow-none">

                            <div class="card-img-top img-fluid bg-cover height-300" style="background: url('<?php echo base_url().'subidas/banner/banner-b3.jpg'; ?>') no-repeat center; background-size:cover;"></div>
                            
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

                                <?php echo form_open($controlador, array('class' => 'form form-horizontal needs-validation card-form p-2 bg-white card', 'id' => 'mi-informacion', 'novalidate' => '')); ?>

                                    <h4 class="text-uppercase mb-3"><strong>Cambiar contraseña</strong></h4>

                                    <div class="row">

                                        <div class="col-xl-7 col-md-6 col-12 mb-2">

                                            <div class="mb-3">
                                                <label for="contrasena_actual">Contraseña actual <span class="text-muted red">*</span></label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control" name="contrasena_actual" id="contrasena_actual" placeholder="Contraseña actual" value="<?php echo set_value('contrasena_actual'); ?>" required="">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-secondary" type="button" onclick="mostrar_contrasena_actual()"><i class="fa fa-eye"></i></button>
                                                    </div>
                                                    <div class="invalid-feedback">
                                                        Se requiere una contraseña actual válida.
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-2">
                                                <label for="contrasena_nueva">Nueva contraseña <span class="text-muted red">*</span></label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control" name="contrasena_nueva" id="contrasena_nueva" placeholder="Nueva contraseña" value="<?php echo set_value('contrasena_nueva'); ?>" required="">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-secondary" type="button" onclick="mostrar_contrasena_nueva()"><i class="fa fa-eye"></i></button>
                                                    </div>
                                                    <div class="invalid-feedback">
                                                        Se requiere una nueva contraseña actual válida.
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-2">
                                                <label for="confirmar_contrasena">Confirmar nueva contraseña <span class="text-muted red">*</span></label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control" name="confirmar_contrasena" id="confirmar_contrasena" placeholder="Confirmar nueva contraseña" value="<?php echo set_value('confirmar_contrasena'); ?>" required="">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-secondary" type="button"  onclick="mostrar_confirmar_contrasena()"><i class="fa fa-eye"></i></button>
                                                    </div>
                                                    <div class="invalid-feedback">
                                                        Se requiere confirmar una nueva contraseña válida.
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-xl-5 col-md-6 col-12 mb-2">
                                    </div>

                                    <div class="form-actions center">
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