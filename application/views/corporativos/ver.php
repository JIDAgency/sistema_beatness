<div class="app-content container center-layout mt-2">
    <div class="content-wrapper">
        <div class="content-body">
            <!-- Basic form layout section start -->
            <section id="basic-form-layouts">

                <?php echo form_open($controlador, array('class' => 'needs-validation p-2', 'id' => 'forma-'.$controlador, 'novalidate' => '', 'method' => 'post')); ?>
                    
                    <?php $this->load->view('_comun/mensajes_alerta');?>

                    <?php if (validation_errors()): ?>
                        <div class="alert bg-danger alert-icon-left alert-dismissible mb-2 font-small-3" role="alert">
                            <span class="alert-icon"><i class="fa fa-thumbs-o-down"></i></span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            <?php echo validation_errors(); ?>
                        </div>
                    <?php endif?>

                    <div class="row match-height">
                        <div class="col-md-3">
                            <h5 class="card-title">Empresa</h5>
                            <p><?php echo $corporativo_row->nombre; ?></p>
                        </div>
                        <div class="col-md-3">
                            <h5 class="card-title">Plan</h5>
                            <p><?php echo $suscripcion_row->nombre; ?></p>
                        </div>
                        <div class="col-md-3">
                            <h5 class="card-title">No. usuarios contratados</h5>
                            <p><?php echo count((array)$usuarios_list); ?></p>
                        </div>
                        <div class="col-md-3">
                            <h5 class="card-title">Vigencia del plan</h5>
                            <p><?php echo date('d/m/Y', strtotime($suscripcion_row->fecha_activacion.' + '.$suscripcion_row->vigencia_en_dias.' days'));; ?></p>
                        </div>
                    </div>

                    <br>
                    <hr>
                    <br>

                    <div class="match-height mt-2">
                        <h4 class="card-title" id="basic-layout-form">Usuarios vinculados</h4>

                            <div class="row mt-1">
                                <div class="col-md-1">
                                    <h5 class="card-title">ID</h5>
                                </div>
                                <div class="col-md-3">
                                    <h5 class="card-title">Nombre</h5>
                                </div>
                                <div class="col-md-3">
                                    <h5 class="card-title">Usuario</h5>
                                </div>
                                <div class="col-md-3">
                                    <h5 class="card-title">Opciones</h5>
                                </div>
                            </div>

                        <?php foreach ($usuarios_list as $usuario_row): ?>
                            <div class="row mt-1">
                                <div class="col-md-1">
                                    <p>#<?php echo $usuario_row->id; ?></p>
                                </div>
                                <div class="col-md-3">
                                    <p><?php echo $usuario_row->nombre; ?></p>
                                </div>
                                <div class="col-md-3">
                                    <p><?php echo $usuario_row->correo; ?></p>
                                </div>
                                <div class="col-md-3">
                                    <a class="btn mr-1 mb-1 btn-secondary btn-sm" href="<?php echo site_url("corporativos/editar/".$usuario_row->id); ?>"><i class="fa fa-pencil-square-o"></i> Editar</a>
                                    <a class="btn mr-1 mb-1 btn-secondary btn-sm" href="<?php echo site_url("corporativos/password/".$usuario_row->id); ?>"><i class="fa fa-unlock-alt"></i> Contraseña</a>
                                </div>
                            </div>
                        <?php endforeach; ?>

                    </div>

                    <br>
                    <hr>
                    <br>

                    <h4 class="form-section">Datos de acceso</h4>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="correo" class="col-md-3 label-control">Email <span class="red">*</span></label>
                                <div class="col-md-9">
                                    <input type="email" name="correo" id="correo" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toLowerCase()" class="form-control" placeholder="Correo Electrónico" value="<?php echo set_value('correo') == false ? $corporativo_row->correo : set_value('correo'); ?>">
                                    <?php echo form_error('correo', '<span class="text-danger">','</span>'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 text-center align-center center">
                            <a class="btn mr-1 mb-1 btn-secondary btn-sm" href="<?php echo site_url("corporativos/password/".$corporativo_row->id); ?>"><i class="fa fa-unlock-alt"></i> Contraseña</a>
                        </div>
                    </div>

                    <h4 class="form-section">Datos de contacto</h4>
                    <input type="hidden" name="id" id="id" value="<?php echo $corporativo_row->id; ?>">

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="nombre_completo" class="col-md-3 label-control">Nombre <span class="red">*</span></label>
                                <div class="col-md-9">
                                    <input type="text" name="nombre_completo" class="form-control" placeholder="Nombre Completo" value="<?php echo set_value('nombre_completo') == false ? $corporativo_row->nombre_completo : set_value('nombre_completo'); ?>" >
                                    <?php echo form_error('nombre_completo', '<span class="text-danger">','</span>'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="apellido_paterno" class="col-md-3 label-control">Apellido paterno <span class="red">*</span></label>
                                <div class="col-md-9">
                                    <input type="text" name="apellido_paterno" class="form-control" placeholder="Apellido Paterno" value="<?php echo set_value('apellido_paterno') == false ? $corporativo_row->apellido_paterno : set_value('apellido_paterno'); ?>" >
                                    <?php echo form_error('apellido_paterno', '<span class="text-danger">','</span>'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="apellido_materno" class="col-md-3 label-control">Apellido materno</label>
                                <div class="col-md-9">
                                    <input type="text" name="apellido_materno" class="form-control" placeholder="Apellido Materno" value="<?php echo set_value('apellido_materno') == false ? $corporativo_row->apellido_materno : set_value('apellido_materno'); ?>">
                                    <?php echo form_error('apellido_materno', '<span class="text-danger">','</span>'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="no_telefono" class="col-md-3 label-control">Télefono</label>
                                <div class="col-md-5">
                                    <input autocomplete="off" type="text" class="form-control" name="no_telefono" placeholder="No. de Teléfono" value="<?php echo set_value('no_telefono') == false ? $corporativo_row->no_telefono : set_value('no_telefono'); ?>">
                                    <?php echo form_error('no_telefono', '<span class="text-danger">','</span>'); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions right">
                        <a class="btn btn-secondary btn-sm mr-1" href="<?php echo site_url($regresar_a); ?>">Regresar</a>
                        <button type="submit" class="btn btn-secondary btn-sm">Guardar</button>
                    </div>

                <?php echo form_close(); ?>

            </section>
            <!-- // Basic form layout section end -->
        </div>
    </div>
</div>
