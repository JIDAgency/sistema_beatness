<div class="app-content container center-layout mt-2 b3-ux-v2-fondo">
    <div class="content-wrapper">
        <div class="content-header row">
        </div>

        <div class="content-body">

            <!-- Basic form layout section start -->
            <section id="basic-form-layouts">
                    
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
                                <a class="btn mr-1 mb-1 btn-secondary btn-sm" href="<?php echo site_url("usuario/corporativo/editar/".$usuario_row->id); ?>"><i class="fa fa-pencil-square-o"></i> Editar</a>
                                <a class="btn mr-1 mb-1 btn-secondary btn-sm" href="<?php echo site_url("usuario/corporativo/password/".$usuario_row->id); ?>"><i class="fa fa-unlock-alt"></i> Contraseña</a>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>

            </section>
            <!-- // Basic form layout section end -->
            
        </div>
    </div>
</div>
<!-- ////////////////////////////////////////////////////////////////////////////-->