<?php $this->load->view('modals/notificaciones_enviar'); ?>
<?php $this->load->view('modals/enviar_notificacion_segmento_usuarios_sin_compras_hace_dos_meses'); ?>

<div class="app-content content center-layout mt-2">
    <div class="content-wrapper">

        <div class="content-header row">

            <div class="content-header-left col-md-6 col-12 mb-2">

                <h3 class="content-header-title mb-0"><?php echo $pagina_titulo; ?></h3>

                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo site_url('inicio'); ?>">Inicio</a></li>
                            <li class="breadcrumb-item active"><?php echo $pagina_titulo; ?></li>
                        </ol>
                    </div>
                </div>

            </div>

            <div class="content-header-right col-md-6 col-12 mb-2">

                <div class="media width-250 float-right">

                    <div class="form-group">
                        <!-- Outline button group with icons and text. -->
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a class="btn btn-outline-secondary" href="<?php echo site_url('notificaciones/agregar'); ?>"><i class="fa fa-plus-circle"></i>&nbsp;Agregar</a>
                            <a class="btn btn-outline-secondary" href="<?php echo site_url('notificaciones/segmentos'); ?>"><i class="fa fa-users"></i>&nbsp;Segmentos</a>
                        </div>
                    </div>

                    <!--
					<media-left class="media-middle">
						<div id="sp-bar-total-sales"></div>
					</media-left>
					
					<div class="media-body media-right text-right">
						<h3 class="m-0">$5,668</h3><span class="text-muted">Sales</span>
					</div>
                    -->

                </div>

            </div>

        </div>

        <div class="content-body">

            <?php if (validation_errors()) : ?>
                <div class="alert bg-danger alert-icon-left alert-dismissible mb-2 font-small-3" role="alert">
                    <span class="alert-icon"><i class="fa fa-thumbs-o-down"></i></span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <?php echo validation_errors(); ?>
                </div>
            <?php endif ?>
            <?php $this->load->view('_comun/mensajes_alerta'); ?>

            <section id="section">

                <div class="row">
                    <div class="col-12">
                        <div class="card no-border">

                            <div class="card-header">
                                <h4 class="card-title">Registro de <?php echo $pagina_titulo; ?></h4>
                            </div>

                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard">
                                    <table name="table" id="table" class="table display nowrap table-striped table-bordered scroll-horizontal table-hover w-100" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Título</th>
                                                <th>Mensaje</th>
                                                <th>No. envios</th>
                                                <th>Estatus</th>
                                                <th>Fecha registro</th>
                                                <th>Fecha actualización</th>
                                                <th>Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </section>
        </div>

    </div>
</div>