<div class="app-content content center-layout mt-2">
    <div class="content-wrapper">

        <div class="content-header row">

            <div class="content-header-left col-md-6 col-12 mb-2">

                <h3 class="content-header-title mb-0"><?php echo $pagina_titulo; ?></h3>

                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo site_url('site/inicio'); ?>">Inicio</a></li>
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

                            <!-- <div class="content-header-right  col-md-12 col-12">
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
                            </div> -->

                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard">
                                    <div class="row">
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="fecha_inicio">Fecha de inicio:</label>
                                                <input type="date" name="fecha_inicio" id="fecha_inicio" value="<?php echo date('Y-m-d', strtotime('first day of this month')); ?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="fecha_fin">Fecha de fin:</label>
                                                <input type="date" name="fecha_fin" id="fecha_fin" value="<?php echo date('Y-m-d'); ?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="sucursal">Sucursal:</label>
                                                <select name="sucursal" id="sucursal" class="form-control">
                                                    <option value="-1" selected>Todas</option>
                                                    <option value="2">Puebla</option>
                                                    <option value="3">Polanco</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="disciplina_id">Disciplina:</label>
                                                <select name="disciplina_id" id="disciplina_id" class="form-control">
                                                    <option value="-1" selected>Todas</option>
                                                    <option value="2">INDOOR CYCLING PUEBLA</option>
                                                    <option value="3">BOOTCAMP PUEBLA</option>
                                                    <option value="4">BOX PUEBLA</option>
                                                    <option value="5">JUMP PUEBLA</option>
                                                    <option value="6">FUNCIONAL / CALISTENIA PUEBLA</option>
                                                    <option value="21">FISIOTERAPIA PUEBLA</option>
                                                    <option value="22">PILATES PUEBLA</option>
                                                    <option value="23">YOGA PUEBLA</option>
                                                    <option value="7">GYM PUEBLA</option>
                                                    <option value="8">SPECIAL EVENT PUEBLA</option>
                                                    <option value="10">BOOTCAMP POLANCO</option>
                                                    <option value="19">INDOOR CYCLING POLANCO</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group float-md-right">
                                                <button name="actualizar_grafica" id="actualizar_grafica" class="btn btn-secondary">Actualizar Gráfica</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="chart-container" style="position: relative; height: 400px; width: 100%;">
                                        <canvas name="canvas_grafica" id="canvas_grafica"></canvas>
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