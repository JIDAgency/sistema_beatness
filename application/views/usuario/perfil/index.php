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

                                    <h4 class="text-uppercase mb-3"><strong>Información de la cuenta</strong></h4>

                                    <div class="row">

                                        <div class="col-xl-7 col-md-6 col-12 mb-2">

                                            <input type="hidden" readonly class="form-control" name="token_id" id="token_id">

                                            <div class="mb-2">
                                                <label for="correo">Correo electrónico <span class="text-muted red">*</span></label>
                                                <input type="email" class="form-control" name="correo" id="correo" placeholder="Correo" value="<?php echo set_value('correo') == false ? $data_usuario_row->correo : set_value('correo'); ?>" required="">
                                                <div class="invalid-feedback">
                                                    Se requiere un correo electrónico válido.
                                                </div>
                                            </div>

                                            <div class="row">

                                                <div class="col-md-6 mb-2">
                                                <label for="nombre">Nombre <span class="text-muted"><small>(Nombres)</small></span> <span class="text-muted red">*</span></label>
                                                    <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre" value="<?php echo set_value('nombre') == false ? $data_usuario_row->nombre_completo : set_value('nombre'); ?>" required="">
                                                    <div class="invalid-feedback">
                                                        Se requiere un nombre válido.
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb-2">
                                                    <label for="apellido_paterno">Apellido paterno <span class="text-muted red">*</span></label>
                                                    <input type="text" class="form-control" name="apellido_paterno" id="apellido_paterno" placeholder="Apellido paterno" value="<?php echo set_value('apellido_paterno') == false ? $data_usuario_row->apellido_paterno : set_value('apellido_paterno'); ?>" required="">
                                                    <div class="invalid-feedback">
                                                        Se requiere un apellido paterno válido.
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb-2">
                                                    <label for="apellido_materno">Apellido materno</label>
                                                    <input type="text" class="form-control" name="apellido_materno" id="apellido_materno" placeholder="Apellido materno" value="<?php echo set_value('apellido_materno') == false ? $data_usuario_row->apellido_materno : set_value('apellido_materno'); ?>">
                                                    <div class="invalid-feedback">
                                                        Se requiere un apellido materno válido.
                                                    </div>
                                                </div>
                                                
                                            </div>

                                            <div class="mb-2">
                                                <label for="no_telefono">Número celular <span class="text-muted red">*</span></label>
                                                <input type="text" class="form-control" name="no_telefono" id="no_telefono" placeholder="Número" value="<?php echo set_value('no_telefono') == false ? $data_usuario_row->no_telefono : set_value('no_telefono'); ?>" required="">
                                                <div class="invalid-feedback">
                                                    Se requiere un correo electrónico válido.
                                                </div>
                                            </div>

                                            <h5 class="">Género <span class="text-muted red">*</span></h5>
                                            <div class="d-block mb-2">

                                                <div class="custom-control custom-radio">
                                                    <input id="gener_h" name="genero" type="radio" class="custom-control-input" <?php echo set_radio('genero', 'H', $data_usuario_row->genero == 'H'); ?> value="H" required="">
                                                    <label class="custom-control-label" for="gener_h">Hombre</label>
                                                    <div class="invalid-feedback">
                                                        Se requiere seleccionar una genero válido.
                                                    </div>
                                                </div>
                                                
                                                <div class="custom-control custom-radio">
                                                    <input id="gener_m" name="genero" type="radio" class="custom-control-input" <?php echo set_radio('genero', 'M', $data_usuario_row->genero == 'M'); ?> value="M" required="">
                                                    <label class="custom-control-label" for="gener_m">Mujer</label>
                                                    <div class="invalid-feedback">
                                                        Se requiere seleccionar una genero válido.
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="mb-2">
                                                <label for="fecha_nacimiento">Fecha de nacimiento <span class="text-muted red">*</span></label>
                                                <input type="date" class="form-control" name="fecha_nacimiento" id="fecha_nacimiento" placeholder="Fecha" value="<?php echo set_value('fecha_nacimiento') == false ? date('Y-m-d', strtotime($data_usuario_row->fecha_nacimiento)) : set_value('fecha_nacimiento'); ?>" required="">
                                                <div class="invalid-feedback">
                                                    Se requiere una fecha de nacimiento válida.
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