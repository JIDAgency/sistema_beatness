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
                    <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
                        <button class="btn btn-outline-secondary btn-min-width dropdown-toggle" id="btnGroupDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Reportes</button>
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


                                    <div class="row">

                                        <div class="col-xl-6 col-lg-6 col-md-12">
                                            <div class="card no-border">
                                                <div class="card-content">
                                                    <div class="card-body text-center">

                                                        <div class="card-header mb-2">
                                                            <span class="success">Reservaciones de clases</span>
                                                            <h3 class="font-large-2 grey darken-1 text-bold-200">
                                                                <?php echo number_format($reservaciones_numero_total); ?>
                                                            </h3>
                                                        </div>

                                                        <div class="card-content">
                                                            <input type="text" value="<?php echo number_format(100 - ($reservaciones_numero_canceladas * 100) / ($reservaciones_numero_total + $reservaciones_numero_canceladas), 02); ?>" class="knob hide-value responsive angle-offset" data-angleOffset="0" data-thickness=".15" data-linecap="round" data-width="150" data-height="150" data-inputColor="#e1e1e1" data-readOnly="true" data-fgColor="#28D094" data-knob-icon="ft-trending-up">
                                                            <p class="mt-1"><b>Reservaciones:</b></p>
                                                            <p class="">
                                                                <b><?php echo number_format(100 - ($reservaciones_numero_canceladas * 100) / ($reservaciones_numero_total + $reservaciones_numero_canceladas), 02); ?>%</b>
                                                            </p>
                                                            <ul class="list-inline clearfix mt-2 mb-0">
                                                                <li class="border-right-grey border-right-lighten-2 pr-1">
                                                                    <h2 class="grey darken-1 text-bold-400">
                                                                        <?php echo number_format($reservaciones_numero_terminadas); ?>
                                                                    </h2>
                                                                    <span class="info"><i class="fa fa-caret-right"></i>
                                                                        Terminadas</span>
                                                                </li>
                                                                <li class="border-right-grey border-right-lighten-2 pr-1">
                                                                    <h2 class="grey darken-1 text-bold-400">
                                                                        <?php echo number_format($reservaciones_numero_activas); ?>
                                                                    </h2>
                                                                    <span class="success"><i class="fa fa-caret-up"></i>
                                                                        Activas</span>
                                                                </li>
                                                                <li class="pl-1">
                                                                    <h2 class="grey darken-1 text-bold-400">
                                                                        <?php echo number_format($reservaciones_numero_canceladas); ?>
                                                                    </h2>
                                                                    <span class="danger"><i class="fa fa-caret-down"></i>
                                                                        Canceladas</span>
                                                                </li>
                                                            </ul>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-12 col-md-12">

                                            <div class="card no-border mt-2">
                                                <div class="card-content">
                                                    <div class="card-body">
                                                        <div class="media">
                                                            <div class="media-body text-left">
                                                                <h3 class="info">
                                                                    <?php echo number_format(100 - (($reservaciones_numero_activas + $reservaciones_numero_canceladas) * 100) / ($reservaciones_numero_total + $reservaciones_numero_canceladas), 02); ?>%
                                                                </h3>
                                                                <span>Reservaciones terminadas (Exitosas)</span>
                                                            </div>
                                                            <div class="media-right media-middle">
                                                                <i class="ft-check-square info font-large-2 float-right"></i>
                                                            </div>
                                                        </div>
                                                        <div class="progress mt-1 mb-0" style="height: 7px;">
                                                            <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo number_format(100 - (($reservaciones_numero_activas + $reservaciones_numero_canceladas) * 100) / ($reservaciones_numero_total + $reservaciones_numero_canceladas), 02); ?>%" aria-valuenow="<?php echo number_format(100 - (($reservaciones_numero_activas + $reservaciones_numero_canceladas) * 100) / ($reservaciones_numero_total + $reservaciones_numero_canceladas), 02); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card no-border mt-2">
                                                <div class="card-content">
                                                    <div class="card-body">
                                                        <div class="media">
                                                            <div class="media-body text-left">
                                                                <h3 class="success">
                                                                    <?php echo number_format((($reservaciones_numero_activas) * 100) / ($reservaciones_numero_total + $reservaciones_numero_canceladas), 02); ?>%
                                                                </h3>
                                                                <span>Reservaciones activas</span>
                                                            </div>
                                                            <div class="media-right media-middle">
                                                                <i class="ft-users success font-large-2 float-right"></i>
                                                            </div>
                                                        </div>
                                                        <div class="progress mt-1 mb-0" style="height: 7px;">
                                                            <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo number_format((($reservaciones_numero_activas) * 100) / ($reservaciones_numero_total + $reservaciones_numero_canceladas), 02); ?>%" aria-valuenow="<?php echo number_format((($reservaciones_numero_activas) * 100) / ($reservaciones_numero_total + $reservaciones_numero_canceladas), 02); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card no-border mt-2">
                                                <div class="card-content">
                                                    <div class="card-body">
                                                        <div class="media">
                                                            <div class="media-body text-left">
                                                                <h3 class="warning">
                                                                    <?php echo number_format((($reservaciones_numero_canceladas) * 100) / ($reservaciones_numero_total + $reservaciones_numero_canceladas), 02); ?>%
                                                                </h3>
                                                                <span>Reservaciones canceladas</span>
                                                            </div>
                                                            <div class="media-right media-middle">
                                                                <i class="ft-x-square warning font-large-2 float-right"></i>
                                                            </div>
                                                        </div>
                                                        <div class="progress mt-1 mb-0" style="height: 7px;">
                                                            <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo number_format((($reservaciones_numero_canceladas) * 100) / ($reservaciones_numero_total + $reservaciones_numero_canceladas), 02); ?>%" aria-valuenow="<?php echo number_format((($reservaciones_numero_canceladas) * 100) / ($reservaciones_numero_total + $reservaciones_numero_canceladas), 02); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

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

                                    <div class="row d-flex align-items-stretch">
                                        <div class="col-lg-3 col-md-3 col-sm-12 mt-2">
                                            <a href="<?php echo site_url('reportes/reservaciones') ?>">
                                                <div class="card black bg-reportes text-center h-100">
                                                    <div class="card-content">
                                                        <div class="card-body py-3">
                                                            <h3 class="black mt-3 mb-2"><b>Reservaciones
                                                                </b></h3>
                                                            <p class="card-text"><b>Ver gráfica de reservaciones partiendo de la fecha de apertura de BEATNESS.</b></p>
                                                            <button class="btn btn-darken-3 btn-reportes">Ver</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>

                                        <div class="col-lg-3 col-md-3 col-sm-12 mt-2">
                                            <a href="<?php echo site_url("reportes/reporte_ventas"); ?>">
                                                <div class="card black bg-reportes text-center h-100">
                                                    <div class="card-content">
                                                        <div class="card-body py-3">
                                                            <h3 class="black mt-3 mb-2"><b>Ventas </b></h3>
                                                            <p class="card-text"><b>Ver gráfica de venas partiendo de la fecha de apertura de BEATNESS.</b></p>
                                                            <button class="btn btn-darken-3 btn-reportes">Ver</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>

                                        <div class="col-lg-3 col-md-3 col-sm-12 mt-2">
                                            <a href="<?php echo site_url("reportes/vendedores"); ?>">
                                                <div class="card black bg-reportes text-center h-100">
                                                    <div class="card-content">
                                                        <div class="card-body py-3">
                                                            <h3 class="black mt-3 mb-2"><b>Vendedores</b></h3>
                                                            <p class="card-text"><b>Ver gráfica de ventas de vendedores por mes partiendo de la fecha de apertura de BEATNESS.</b></p>
                                                            <button class="btn btn-darken-3 btn-reportes">Ver</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>

                                        <div class="col-lg-3 col-md-3 col-sm-12 mt-2">
                                            <a href="<?php echo site_url("reportes/reservaciones_por_cliente"); ?>">
                                                <div class="card black bg-reportes text-center h-100">
                                                    <div class="card-content">
                                                        <div class="card-body py-3">
                                                            <h3 class="black mt-3 mb-2"><b>⁠Reservaciones por cliente</b></h3>
                                                            <p class="card-text"><b>Ver gráfica de reservaciones por cliente en el periodo a seleccionar.</b></p>
                                                            <button class="btn btn-darken-3 btn-reportes">Ver</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>

                                        <div class="col-lg-3 col-md-3 col-sm-12 mt-2">
                                            <a href="<?php echo site_url("reportes/reporte_instructores"); ?>">
                                                <div class="card black bg-reportes text-center h-100">
                                                    <div class="card-content">
                                                        <div class="card-body py-3">
                                                            <h3 class="black mt-3 mb-2"><b>Reporte de instructores</b></h3>
                                                            <p class="card-text"><b>Ver gráfica de clases impartidas y cupos reservados por instructores en el periodo a seleccionar.</b></p>
                                                            <button class="btn btn-darken-3 btn-reportes">Ver</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
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