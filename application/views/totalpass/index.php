<div class="app-content content center-layout">
    <div class="content-wrapper">
        <div class="content-header row px-1 my-1">

            <div class="content-header-left col-md-6 col-12">

                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo site_url('inicio'); ?>">Inicio</a></li>
                            <li class="breadcrumb-item active"><?php echo $pagina_titulo; ?></li>
                        </ol>
                    </div>
                </div>

            </div>

            <div class="content-header-right col-md-6 col-12">

                <div class="media float-right">

                    <div class="form-group">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a class="btn btn-outline-grey btn-outline-lighten-1 btn-min-width mr-1" href="<?php echo site_url($regresar_a); ?>"><i class="fa fa-arrow-circle-left"></i>&nbsp;Volver</a>
                        </div>
                    </div>

                </div>

            </div>

        </div>

        <div class="content-body">
            <section id="section">

                <?php $this->load->view('_templates/mensajes_alerta.tpl.php'); ?>

                <div class="row">
                    <div class="col-12">
                        <div class="card no-border">

                            <div class="card-header">
                                <h4 class="card-title"><?php echo $pagina_subtitulo; ?></h4>
                            </div>

                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard">

                                    <div class="row match-height">
                                        <div class="col-xl-12 col-md-12 col-sm-12">

                                            <div class="row match-height row-contenedor">

                                                <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                                                    <a href="<?php echo site_url('totalpass/disciplinas'); ?>">
                                                        <div class="card black bg-reportes h-100">
                                                            <div class="card-content">
                                                                <div class="card-body">
                                                                    <h3 class="black mt-3 mb-2 text-center">Disciplinas</h3>
                                                                    <p class="card-text">Ver las <b>disciplinas</b> vinculadas con <b><span class="success">TOTAL</span>PASS</b></p>
                                                                    <button class="btn btn-info btn-block">Ver</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>

                                                <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                                                    <a href="<?php echo site_url('totalpass/clases'); ?>">
                                                        <div class="card black bg-reportes h-100">
                                                            <div class="card-content">
                                                                <div class="card-body">
                                                                    <h3 class="black mt-3 mb-2 text-center">Clases</h3>
                                                                    <p class="card-text">Administrar las <b>clases</b> registradas en <b><span class="success">TOTAL</span>PASS</b></p>
                                                                    <button class="btn btn-info btn-block">Ver</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>

                                            </div>

                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <div class="form-group float-md-right">
                                                <a class="btn btn-outline-grey btn-outline-lighten-1 btn-min-width mr-1" href="<?php echo site_url($regresar_a); ?>"><i class="fa fa-arrow-circle-left"></i>&nbsp;Volver</a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </section>
        </div>

    </div>
</div>