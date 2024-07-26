<div class="app-content content center-layout mt-2">
    <div class="content-wrapper">

        <div class="content-header row">

            <div class="content-header-left col-md-6 col-12 mb-2">

                <h3 class="content-header-title mb-0"><?php echo $pagina_titulo; ?></h3>

                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo site_url('site/inicio'); ?>">Inicio</a></li>
                            <li class="breadcrumb-item active"><?php echo $pagina_titulo; ?></li>
                        </ol>
                    </div>
                </div>

            </div>

            <div class="content-header-right col-md-6 col-12 mb-2">

                <div class="media float-right">

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

                            <div class="content-header-right  col-md-12 col-12">
                                <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
                                    <button class="btn btn-outline-secondary btn-min-width dropdown-toggle" id="btnGroupDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">+ Reportes</button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                        <a class="dropdown-item" href="<?php echo site_url('reportes/reservaciones') ?>">Reservaciones</a>
                                        <a class="dropdown-item" href="<?php echo site_url('reportes/reporte_ventas') ?>">Ventas</a>
                                        <a class="dropdown-item" href="<?php echo site_url('reportes/vendedores') ?>">Vendedores</a>
                                        <a class="dropdown-item" href="<?php echo site_url('reportes/reservaciones_por_cliente') ?>">Reservaciones por cliente</a>
                                        <a class="dropdown-item" href="<?php echo site_url('reportes/reporte_instructores'); ?>">Reporte de instructores</a>
                                    </div>
                                </div>
                                <div class="form-group float-right">
                                    <div id="buttons"></div>
                                </div>
                            </div>

                            <div class="card-content collapse show">

                                <div class="card-body card-dashboard">

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-content">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-sm-12 border-right-blue-grey border-right-lighten-5">
                                                                <div class="pb-1">
                                                                    <div class="clearfix mb-1">
                                                                        <i class="icon-user font-large-1 blue-grey float-left mt-1"></i>
                                                                        <span class="font-large-2 text-bold-300 info float-right"><?php print_r($reporte_2); ?></span>
                                                                    </div>
                                                                    <div class="clearfix">
                                                                        <span class="text-muted">Clientes</span>
                                                                        <!-- <span class="info float-right"><i class="ft-arrow-up info"></i> 16.89%</span> -->
                                                                    </div>
                                                                </div>
                                                                <div class="progress mb-0" style="height: 7px;">
                                                                    <div class="progress-bar bg-info" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-sm-12 border-right-blue-grey border-right-lighten-5">
                                                                <div class="pb-1">
                                                                    <div class="clearfix mb-1">
                                                                        <i class="icon-user font-large-1 blue-grey float-left mt-1"></i>
                                                                        <span class="font-large-2 text-bold-300 danger float-right"><?php print_r($reporte_3); ?></span>
                                                                    </div>
                                                                    <div class="clearfix">
                                                                        <span class="text-muted">Clientes registrados por Gympass</span>
                                                                        <!-- <span class="danger float-right"><i class="ft-arrow-up danger"></i> 5.14%</span> -->
                                                                    </div>
                                                                </div>
                                                                <div class="progress mb-0" style="height: 7px;">
                                                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 45%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-sm-12 border-right-blue-grey border-right-lighten-5">
                                                                <div class="pb-1">
                                                                    <div class="clearfix mb-1">
                                                                        <i class="icon-user font-large-1 blue-grey float-left mt-1"></i>
                                                                        <span class="font-large-2 text-bold-300 success float-right"><?php print_r($reporte_4); ?></span>
                                                                    </div>
                                                                    <div class="clearfix">
                                                                        <span class="text-muted">Clientes registrados por Beatness</span>
                                                                    </div>
                                                                </div>
                                                                <div class="progress mb-0" style="height: 7px;">
                                                                    <div class="progress-bar bg-success" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
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
                    </div>
                </div>

            </section>
        </div>

    </div>
</div>