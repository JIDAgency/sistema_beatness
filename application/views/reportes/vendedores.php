<div class="app-content content center-layout mt-2">
    <div class="content-wrapper">

        <div class="content-header row px-1 my-1">
            <div class="content-header-left col-md-6 col-12">
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo site_url('inicio'); ?>">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo site_url('reportes'); ?>">Reportes</a></li>
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
            <!-- <div class="content-header-right col-md-6 col-12">
                <div class="media float-right">
                    <div class="form-group">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a class="btn btn-outline-secondary btn-min-width mr-1" href="<?php echo site_url('reportes/reservaciones'); ?>">Reservaciones por cliente</a>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>

        <div class="content-body">

            <!-- Basic tabs start -->
            <section id="basic-tabs-components">
                <div class="row match-height">
                    <div class="col-xl-12 col-lg-12">

                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Reportes de <?php echo branding(); ?></h4>
                            </div>
                            <div class="content-header-right  col-md-12 col-12">
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
                            <div class="card-content">
                                <div class="card-body">

                                    <!-- <p>Seleccione alguna de las siguientes pestañas.</p>
                                    <ul class="nav nav-tabs">

                                        <li class="nav-item">
                                            <a class="nav-link black active" id="base-tab1" data-toggle="tab" aria-controls="tab1" href="#tab1" aria-expanded="true">Reservaciones</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link black" id="base-tab2" data-toggle="tab" aria-controls="tab2" href="#tab2" aria-expanded="false">Ventas</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link black" id="base-tab3" data-toggle="tab" aria-controls="tab3" href="#tab3" aria-expanded="false">Vendedores</a>
                                        </li>

                                    </ul> -->
                                    <div class="tab-content px-1 pt-1">

                                        <!-- <div role="tabpanel" class="tab-pane active" id="tab1" aria-expanded="true" aria-labelledby="base-tab1">

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
                                                    <div class="card no-border">

                                                        <div class="card-header">
                                                            <h4 class="card-title">Gráfica de reservaciones</h4>
                                                        </div>

                                                        <div class="card-content collapse show">
                                                            <div class="card-body">
                                                                <canvas id="chart-reservaciones" height="400"></canvas>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>

                                        </div> -->

                                        <!-- <div class="tab-pane active" id="tab2" aria-labelledby="base-tab2">

                                            <div class="row">

                                                <div class="col-xl-6 col-lg-6 col-md-12">
                                                    <div class="card no-border">
                                                        <div class="card-content">
                                                            <div class="card-body text-center">

                                                                <div class="card-header mb-2">
                                                                    <span class="success">Número de ventas</span>
                                                                    <h3 class="font-large-2 grey darken-1 text-bold-200">
                                                                        <?php echo number_format($ventas_numero_total); ?>
                                                                    </h3>
                                                                </div>

                                                                <div class="card-content">
                                                                    <input type="text" value="<?php echo number_format(100 - ($ventas_numero_canceladas * 100) / ($ventas_numero_total + $ventas_numero_canceladas), 02); ?>" class="knob hide-value responsive angle-offset" data-angleOffset="0" data-thickness=".15" data-linecap="round" data-width="150" data-height="150" data-inputColor="#e1e1e1" data-readOnly="true" data-fgColor="#28D094" data-knob-icon="ft-trending-up">
                                                                    <p class="mt-1"><b>ventas:</b></p>
                                                                    <p class="">
                                                                        <b><?php echo number_format(100 - ($ventas_numero_canceladas * 100) / ($ventas_numero_total + $ventas_numero_canceladas), 02); ?>%</b>
                                                                    </p>
                                                                    <ul class="list-inline clearfix mt-2 mb-0">
                                                                        <li class="border-right-grey border-right-lighten-2 pr-1">
                                                                            <h2 class="grey darken-1 text-bold-400">
                                                                                <?php echo number_format($ventas_numero_vendidas); ?>
                                                                            </h2>
                                                                            <span class="info"><i class="fa fa-caret-right"></i>
                                                                                Vendido</span>
                                                                        </li>
                                                                        <li class="border-right-grey border-right-lighten-2 pr-1">
                                                                            <h2 class="grey darken-1 text-bold-400">
                                                                                <?php echo number_format($ventas_numero_pruebas); ?>
                                                                            </h2>
                                                                            <span class="success"><i class="fa fa-caret-up"></i> Periodo
                                                                                de prueba</span>
                                                                        </li>
                                                                        <li class="pl-1">
                                                                            <h2 class="grey darken-1 text-bold-400">
                                                                                <?php echo number_format($ventas_numero_canceladas); ?>
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
                                                                            <?php echo number_format(100 - (($ventas_numero_pruebas + $ventas_numero_canceladas) * 100) / ($ventas_numero_total + $ventas_numero_canceladas), 02); ?>%
                                                                        </h3>
                                                                        <span>Ventas (Exitosas)</span>
                                                                    </div>
                                                                    <div class="media-right media-middle">
                                                                        <i class="ft-check-square info font-large-2 float-right"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="progress mt-1 mb-0" style="height: 7px;">
                                                                    <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo number_format(100 - (($ventas_numero_pruebas + $ventas_numero_canceladas) * 100) / ($ventas_numero_total + $ventas_numero_canceladas), 02); ?>%" aria-valuenow="<?php echo number_format(100 - (($ventas_numero_pruebas + $ventas_numero_canceladas) * 100) / ($ventas_numero_total + $ventas_numero_canceladas), 02); ?>" aria-valuemin="0" aria-valuemax="100"></div>
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
                                                                            <?php echo number_format((($ventas_numero_pruebas) * 100) / ($ventas_numero_total + $ventas_numero_canceladas), 02); ?>%
                                                                        </h3>
                                                                        <span>Periodo de prueba</span>
                                                                    </div>
                                                                    <div class="media-right media-middle">
                                                                        <i class="ft-users success font-large-2 float-right"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="progress mt-1 mb-0" style="height: 7px;">
                                                                    <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo number_format((($ventas_numero_pruebas) * 100) / ($ventas_numero_total + $ventas_numero_canceladas), 02); ?>%" aria-valuenow="<?php echo number_format((($ventas_numero_pruebas) * 100) / ($ventas_numero_total + $ventas_numero_canceladas), 02); ?>" aria-valuemin="0" aria-valuemax="100"></div>
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
                                                                            <?php echo number_format((($ventas_numero_canceladas) * 100) / ($ventas_numero_total + $ventas_numero_canceladas), 02); ?>%
                                                                        </h3>
                                                                        <span>Ventas canceladas</span>
                                                                    </div>
                                                                    <div class="media-right media-middle">
                                                                        <i class="ft-x-square warning font-large-2 float-right"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="progress mt-1 mb-0" style="height: 7px;">
                                                                    <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo number_format((($ventas_numero_canceladas) * 100) / ($ventas_numero_total + $ventas_numero_canceladas), 02); ?>%" aria-valuenow="<?php echo number_format((($ventas_numero_canceladas) * 100) / ($ventas_numero_total + $ventas_numero_canceladas), 02); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>

                                            <div class="row">

                                                <div class="col-12">
                                                    <div class="card no-border">

                                                        <div class="card-header">
                                                            <h4 class="card-title">Gráfica de ventas</h4>
                                                        </div>

                                                        <div class="card-content collapse show">
                                                            <div class="card-body">
                                                                <canvas id="chart-ventas" height="400"></canvas>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>

                                        </div> -->

                                        <div class="tab-pane active" id="tab3" aria-labelledby="base-tab3">

                                            <div class="row">

                                                <div class="col-12">
                                                    <div class="card no-border">

                                                        <div class="card-header">
                                                            <h4 class="card-title">Gráfica de vendedores</h4>
                                                        </div>

                                                        <!-- <div class="card-content collapse show">
                                                            <div class="card-body">
                                                                <canvas id="chart-vendedor" height="3500"></canvas>
                                                            </div>
                                                        </div> -->

                                                        <div class="chart-container" style="position: relative; height: 100%; width: 100%;">
                                                            <canvas name="chart-vendedor" id="chart-vendedor"></canvas>
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
            <!-- Basic badge Input end -->

        </div>

    </div>
</div>