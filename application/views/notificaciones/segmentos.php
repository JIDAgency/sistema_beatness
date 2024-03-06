<?php $this->load->view('modals/notificaciones_enviar'); ?>

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
						</div>
					</div>
					
				</div>

			</div>

        </div>

        <div class="content-body">

            <?php if (validation_errors()): ?>
                <div class="alert bg-danger alert-icon-left alert-dismissible mb-2 font-small-3" role="alert">
                    <span class="alert-icon"><i class="fa fa-thumbs-o-down"></i></span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <?php echo validation_errors(); ?>
                </div>
            <?php endif?>
            <?php $this->load->view('_comun/mensajes_alerta'); ?>

            <section id="section">

                <div class="row">

                    <div class="col-xl-3 col-lg-12">
                        <a href="<?php echo site_url("notificaciones/segmento_usuarios_seleccionados_julio_2023"); ?>">
                            <div class="card white bg-grey text-center">
                                <div class="card-content">
                                    <div class="card-body py-3">
                                        <h4 class="white mt-3 mb-2">Usuarios seleccionados julio 2023</h4>
                                        <p class="card-text">Ver la lista y notificar a usuarios seleccionados.</p>
                                        <button class="btn btn-grey btn-darken-3">Ver</button>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-xl-3 col-lg-12">
                        <a href="<?php echo site_url("notificaciones/segmento_usuarios_sin_compras_hace_dos_meses"); ?>">
                            <div class="card white bg-grey text-center">
                                <div class="card-content">
                                    <div class="card-body py-3">
                                        <h4 class="white mt-3 mb-2">Usuarios sin compras hace dos meses</h4>
                                        <p class="card-text">Ver la lista y notificar a usuarios que no han comprado algún plan desde hace dos meses.</p>
                                        <button class="btn btn-grey btn-darken-3">Ver</button>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                </div>

            </section>
        </div>

    </div>
</div>
