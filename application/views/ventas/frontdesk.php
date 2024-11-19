<div class="app-content content center-layout mt-2">
    <div class="content-wrapper">

        <div class="content-header row">

            <div class="content-header-left col-md-6 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php base_url(); ?>/inicio">Inicio</a>
                            </li>
                            <li class="breadcrumb-item active">Ventas
                            </li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="content-header-right  col-md-6 col-12">
                <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
                    <button class="btn btn-outline-secondary btn-min-width dropdown-toggle" id="btnGroupDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ft-settings icon-left"></i> Nuevo</button>
                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                        <a class="dropdown-item" href="<?php echo site_url('clientes/crear') ?>">+ Nuevo Cliente</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?php echo site_url('clases/crear') ?>">+ Nueva Clase</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?php echo site_url('ventas/crear') ?>">+ Nueva Venta</a>
                        <a class="dropdown-item" href="<?php echo site_url('ventas/crear_personalizada') ?>">+ Nueva Venta Personalizada</a>
                    </div>
                </div>
                <div class="form-group float-right">
                    <div id="buttons"></div>
                </div>
            </div>

        </div>

        <div class="content-body">
            <section class="card no-border">
                <div id="invoice-template" class="card-body">
                    <?php $this->load->view('_comun/mensajes_alerta'); ?>

                    <h2>Reporte de ventas del <span name="mes_reportado" id="mes_reportado"><?php echo date('d/m/Y', strtotime($resultados_mes_actual['data']['mes_reportado'])); ?></span></h2>

                    <div class="row mt-2">
                        <div class="col-xl-3 col-lg-12">
                            <div class="form-group">
                                <h5 class="card-titlel"><i class="ft-filter"></i> Periodo a consultar:</h5>
                                <select id="mes_a_consultar" name="mes_a_consultar" class="select2 form-control">

                                    <?php foreach ($period as $dt) : ?>
                                        <?php
                                        $date = DateTime::createFromFormat("Y-m-d", $dt->format("Y-m-d"));
                                        ?>
                                        <option value="<?php echo $dt->format("Y-m-d"); ?>" <?php echo set_select('mes_a_consultar', $dt->format("Y-m-d"), set_value('mes_a_consultar') ? false : $dt->format("Y-m-d") == date('Y-m-d')); ?>><?php echo ucfirst(strftime("%e de %B de %Y", $date->getTimestamp())); ?></option>
                                    <?php endforeach; ?>

                                </select>
                            </div>
                        </div>
                    </div>

                    <!--div class="row mt-2">
                        <?php if ((es_superadministrador() or es_administrador()) or (es_frontdesk())) : ?>
                            <div class="col-xl-3 col-md-6 col-12">
                                <h5><strong>Total de ventas Global</strong></h5>
                                <br>
                                <p><small><em>Número de ventas Global:</em></small><br><strong><span name="no_ventas" id="no_ventas"><?php echo $resultados_mes_actual['data']['no_ventas']; ?></span></strong></p>
                                <p><small><em>Total de ventas Global:</em></small><br><strong><span name="ventas_total" id="ventas_total"><?php echo $resultados_mes_actual['data']['ventas_total']; ?></span></strong></p>
                                <br>
                                <p><small><em>Número de ventas Canceladas Global:</em></small><br><strong><span name="no_ventas_canceladas_total" id="no_ventas_canceladas_total"><?php echo $resultados_mes_actual['data']['no_ventas_canceladas_total']; ?></span></strong></p>

                                <p><small><em>Número de ventas Global Efectivo:</em></small><br><strong><span name="no_ventas_efectivo" id="no_ventas_efectivo"><?php echo $resultados_mes_actual['data']['no_ventas_efectivo']; ?></span></strong></p>
                                <p><small><em>Total de ventas Global Efectivo:</em></small><br><strong><span name="ventas_efectivo" id="ventas_efectivo"><?php echo $resultados_mes_actual['data']['ventas_efectivo']; ?></span></strong></p>
                                <br>
                                <p><small><em>Número de ventas Global Tarjeta:</em></small><br><strong><span name="no_ventas_tarjeta" id="no_ventas_tarjeta"><?php echo $resultados_mes_actual['data']['no_ventas_tarjeta']; ?></span></strong></p>
                                <p><small><em>Total de ventas Global Tarjeta:</em></small><br><strong><span name="ventas_tarjeta" id="ventas_tarjeta"><?php echo $resultados_mes_actual['data']['ventas_tarjeta']; ?></span></strong></p>
                                <br>
                                <p><small><em>Número de ventas Global Family:</em></small><br><strong><span name="no_ventas_b3family" id="no_ventas_b3family"><?php echo $resultados_mes_actual['data']['no_ventas_b3family']; ?></span></strong></p>
                                <p><small><em>Total de ventas Global Family:</em></small><br><strong><span name="ventas_b3family" id="ventas_b3family"><?php echo $resultados_mes_actual['data']['ventas_b3family']; ?></span></strong></p>
                            </div>
                        <?php endif; ?>

                        <?php if ((es_superadministrador() or es_administrador())) : ?>
                            <div class="col-xl-3 col-md-6 col-12">
                                <h5><strong>Total de ventas b3</strong></h5>
                                <br>
                                <p><small><em>Número de ventas:</em></small><br><strong><span name="b3_no_ventas_total" id="b3_no_ventas_total"><?php echo $resultados_mes_actual['data']['b3_no_ventas_total']; ?></span></strong></p>
                                <p><small><em>Total de ventas:</em></small><br><strong><span name="b3_ventas_total" id="b3_ventas_total"><?php echo $resultados_mes_actual['data']['b3_ventas_total']; ?></span></strong></p>
                                <br>
                                <p><small><em>Número de ventas Efectivo:</em></small><br><strong><span name="b3_no_ventas_efectivo" id="b3_no_ventas_efectivo"><?php echo $resultados_mes_actual['data']['b3_no_ventas_efectivo']; ?></span></strong></p>
                                <p><small><em>Total de ventas Efectivo:</em></small><br><strong><span name="b3_ventas_efectivo" id="b3_ventas_efectivo"><?php echo $resultados_mes_actual['data']['b3_ventas_efectivo']; ?></span></strong></p>
                                <br>
                                <p><small><em>Número de ventas Tarjeta:</em></small><br><strong><span name="b3_no_ventas_tarjeta" id="b3_no_ventas_tarjeta"><?php echo $resultados_mes_actual['data']['b3_no_ventas_tarjeta']; ?></span></strong></p>
                                <p><small><em>Total de ventasB3 Tarjeta:</em></small><br><strong><span name="b3_ventas_tarjeta" id="b3_ventas_tarjeta"><?php echo $resultados_mes_actual['data']['b3_ventas_tarjeta']; ?></span></strong></p>
                                <br>
                                <p><small><em>Número de ventas Family:</em></small><br><strong><span name="b3_no_ventas_b3family" id="b3_no_ventas_b3family"><?php echo $resultados_mes_actual['data']['b3_no_ventas_b3family']; ?></span></strong></p>
                                <p><small><em>Total de ventas Family:</em></small><br><strong><span name="b3_ventas_b3family" id="b3_ventas_b3family"><?php echo $resultados_mes_actual['data']['b3_ventas_b3family']; ?></span></strong></p>
                            </div>
                        <?php endif; ?>

                        <?php if ((es_superadministrador() or es_administrador()) or (es_frontdesk() and $this->session->userdata('sucursal_asignada') == 2)) : ?>
                            <div class="col-xl-3 col-md-6 col-12">
                                <h5><strong>Total de ventas Vela</strong></h5>
                                <br>
                                <p><small><em>Número de ventas Sucursal 2:</em></small><br><strong><span name="vela_no_ventas_total" id="vela_no_ventas_total"><?php echo $resultados_mes_actual['data']['vela_no_ventas_total']; ?></span></strong></p>
                                <p><small><em>Total de ventas  Sucursal 2:</em></small><br><strong><span name="vela_ventas_total" id="vela_ventas_total"><?php echo $resultados_mes_actual['data']['vela_ventas_total']; ?></span></strong></p>
                                <br>
                                <p><small><em>Número de ventas  Sucursal 2 Efectivo:</em></small><br><strong><span name="vela_no_ventas_efectivo" id="vela_no_ventas_efectivo"><?php echo $resultados_mes_actual['data']['vela_no_ventas_efectivo']; ?></span></strong></p>
                                <p><small><em>Total de ventas  Sucursal 2 Efectivo:</em></small><br><strong><span name="vela_ventas_efectivo" id="vela_ventas_efectivo"><?php echo $resultados_mes_actual['data']['vela_ventas_efectivo']; ?></span></strong></p>
                                <br>
                                <p><small><em>Número de ventas  Sucursal 2 Tarjeta:</em></small><br><strong><span name=" vela_no_ventas_tarjeta" id="vela_no_ventas_tarjeta"><?php echo $resultados_mes_actual['data']['vela_no_ventas_tarjeta']; ?></span></strong></p>
                                <p><small><em>Total de ventas  Sucursal 2 Tarjeta:</em></small><br><strong><span name="vela_ventas_tarjeta" id="vela_ventas_tarjeta"><?php echo $resultados_mes_actual['data']['vela_ventas_tarjeta']; ?></span></strong></p>
                                <br>
                                <p><small><em>Número de ventas  Sucursal 2 Family:</em></small><br><strong><span name="vela_no_ventas_b3family" id="vela_no_ventas_b3family"><?php echo $resultados_mes_actual['data']['vela_no_ventas_b3family']; ?></span></strong></p>
                                <p><small><em>Total de ventas  Sucursal 2 Family:</em></small><br><strong><span name="vela_ventas_b3family" id="vela_ventas_b3family"><?php echo $resultados_mes_actual['data']['vela_ventas_b3family']; ?></span></strong></p>
                            </div>
                        <?php endif; ?>

                        <?php if ((es_superadministrador() or es_administrador()) or (es_frontdesk() and $this->session->userdata('sucursal_asignada') == 3)) : ?>
                            <div class="col-xl-3 col-md-6 col-12">
                                <h5><strong>Total de ventas  Sucursal 3</strong></h5>
                                <br>
                                <p><small><em>Número de ventas  Sucursal 3:</em></small><br><strong><span name="dorado_no_ventas_total" id="dorado_no_ventas_total"><?php echo $resultados_mes_actual['data']['dorado_no_ventas_total']; ?></span></strong></p>
                                <p><small><em>Total de ventas  Sucursal 3:</em></small><br><strong><span name="dorado_ventas_total" id="dorado_ventas_total"><?php echo $resultados_mes_actual['data']['dorado_ventas_total']; ?></span></strong></p>
                                <br>
                                <p><small><em>Número de ventas  Sucursal 3 Efectivo:</em></small><br><strong><span name="dorado_no_ventas_efectivo" id="dorado_no_ventas_efectivo"><?php echo $resultados_mes_actual['data']['dorado_no_ventas_efectivo']; ?></span></strong></p>
                                <p><small><em>Total de ventas Dor Sucursal 3ado Efectivo:</em></small><br><strong><span name="dorado_ventas_efectivo" id="dorado_ventas_efectivo"><?php echo $resultados_mes_actual['data']['dorado_ventas_efectivo']; ?></span></strong></p>
                                <br>
                                <p><small><em>Número de ventas  Sucursal 3 Tarjeta:</em></small><br><strong><span name="dorado_no_ventas_tarjeta" id="dorado_no_ventas_tarjeta"><?php echo $resultados_mes_actual['data']['dorado_no_ventas_tarjeta']; ?></span></strong></p>
                                <p><small><em>Total de ventas  Sucursal 3 Tarjeta:</em></small><br><strong><span name="dorado_ventas_tarjeta" id="dorado_ventas_tarjeta"><?php echo $resultados_mes_actual['data']['dorado_ventas_tarjeta']; ?></span></strong></p>
                                <br>
                                <p><small><em>Número de ventas  Sucursal 3 Family:</em></small><br><strong><span name="dorado_no_ventas_b3family" id="dorado_no_ventas_b3family"><?php echo $resultados_mes_actual['data']['dorado_no_ventas_b3family']; ?></span></strong></p>
                                <p><small><em>Total de ventas  Sucursal 3 Family:</em></small><br><strong><span name="dorado_ventas_b3family" id="dorado_ventas_b3family"><?php echo $resultados_mes_actual['data']['dorado_ventas_b3family']; ?></span></strong></p>
                            </div>
                        <?php endif; ?>

                        <?php if ((es_superadministrador() or es_administrador()) or (es_frontdesk() and $this->session->userdata('sucursal_asignada') == 5)) : ?>
                            <div class="col-xl-3 col-md-6 col-12">
                                <h5><strong>Total de ventas  Sucursal 4</strong></h5>
                                <br>
                                <p><small><em>Número de ventas  Sucursal 4:</em></small><br><strong><span name="insan3_no_ventas_total" id="insan3_no_ventas_total"><?php echo $resultados_mes_actual['data']['insan3_no_ventas_total']; ?></span></strong></p>
                                <p><small><em>Total de ventas insan3:</em></small><br><strong><span name="insan3_ventas_total" id="insan3_ventas_total"><?php echo $resultados_mes_actual['data']['insan3_ventas_total']; ?></span></strong></p>
                                <br>
                                <p><small><em>Número de ventas  Sucursal 4 Efectivo:</em></small><br><strong><span name="insan3_no_ventas_efectivo" id="insan3_no_ventas_efectivo"><?php echo $resultados_mes_actual['data']['insan3_no_ventas_efectivo']; ?></span></strong></p>
                                <p><small><em>Total de ventas  Sucursal 4 Efectivo:</em></small><br><strong><span name="insan3_ventas_efectivo" id="insan3_ventas_efectivo"><?php echo $resultados_mes_actual['data']['insan3_ventas_efectivo']; ?></span></strong></p>
                                <br>
                                <p><small><em>Número de ventas  Sucursal 4 Tarjeta:</em></small><br><strong><span name="insan3_no_ventas_tarjeta" id="insan3_no_ventas_tarjeta"><?php echo $resultados_mes_actual['data']['insan3_no_ventas_tarjeta']; ?></span></strong></p>
                                <p><small><em>Total de ventas  Sucursal 4 Tarjeta:</em></small><br><strong><span name="insan3_ventas_tarjeta" id="insan3_ventas_tarjeta"><?php echo $resultados_mes_actual['data']['insan3_ventas_tarjeta']; ?></span></strong></p>
                                <br>
                                <p><small><em>Número de ventas  Sucursal 4 Family:</em></small><br><strong><span name="insan3_no_ventas_b3family" id="insan3_no_ventas_b3family"><?php echo $resultados_mes_actual['data']['insan3_no_ventas_b3family']; ?></span></strong></p>
                                <p><small><em>Total de ventas  Sucursal 4 Family:</em></small><br><strong><span name="insan3_ventas_b3family" id="insan3_ventas_b3family"><?php echo $resultados_mes_actual['data']['insan3_ventas_b3family']; ?></span></strong></p>
                            </div>
                        <?php endif; ?>

                        <?php if ((es_superadministrador() or es_administrador()) or es_frontdesk()) : ?>
                            <div class="col-xl-3 col-md-6 col-12">
                                <h5><strong>Total de ventas en línea</strong></h5>
                                <br>
                                <h6><strong><em>Total de ventas Packs OpenPay</em></strong></h6>
                                <p><small><em>Número de ventas OpenPay:</em></small><br><strong><span name="no_ventas_openpay" id="no_ventas_openpay"><?php echo $resultados_mes_actual['data']['no_ventas_openpay']; ?></span></strong></p>
                                <p><small><em>Total de ventas OpenPay:</em></small><br><strong><span name="ventas_openpay" id="ventas_openpay"><?php echo $resultados_mes_actual['data']['ventas_openpay']; ?></span></strong></p>
                                <?php if ((es_superadministrador() or es_administrador()) or (es_frontdesk() and ($this->session->userdata('sucursal_asignada') == 2)) or (es_frontdesk() and ($this->session->userdata('sucursal_asignada') == 3))) : ?>
                                <br>
                                <h6><strong><em>Total de ventas Packs OpenPay</em></strong></h6>
                                <p><small><em>Número de ventas OpenPay:</em></small><br><strong><span name="no_ventas_openpay_b3" id="no_ventas_openpay_b3"><?php echo $resultados_mes_actual['data']['no_ventas_openpay_b3']; ?></span></strong></p>
                                <p><small><em>Total de ventas OpenPay:</em></small><br><strong><span name="ventas_openpay_b3" id="ventas_openpay_b3"><?php echo $resultados_mes_actual['data']['ventas_openpay_b3']; ?></span></strong></p>
                                <?php endif; ?>
                                <?php if ((es_superadministrador() or es_administrador()) or (es_frontdesk() and $this->session->userdata('sucursal_asignada') == 5)) : ?>
                                <br>
                                <h6><strong><em>Total de ventas Packs OpenPay sucursal 5</em></strong></h6>
                                <p><small><em>Número de ventas OpenPay sucursal 5:</em></small><br><strong><span name="no_ventas_openpay_insan3" id="no_ventas_openpay_insan3"><?php echo $resultados_mes_actual['data']['no_ventas_openpay_insan3']; ?></span></strong></p>
                                <p><small><em>Total de ventas OpenPay Insan3:</em></small><br><strong><span name="ventas_openpay_insan3" id="ventas_openpay_insan3"><?php echo $resultados_mes_actual['data']['ventas_openpay_insan3']; ?></span></strong></p>
                                <?php endif; ?>
                                <?php if ((es_superadministrador() or es_administrador())) : ?>
                                        <br>
                                        <h6><strong><em>Total de ventas Suscripciones</em></strong></h6>
                                        <p><small><em>Número de ventas Packs Suscripciones:</em></small><br><strong><span name="no_ventas_suscripcion" id="no_ventas_suscripcion"><?php echo $resultados_mes_actual['data']['no_ventas_suscripcion']; ?></span></strong></p>
                                        <p><small><em>Total de ventas Packs Suscripciones:</em></small><br><strong><span name="ventas_suscripcion" id="ventas_suscripcion"><?php echo $resultados_mes_actual['data']['ventas_suscripcion']; ?></span></strong></p>
                                        <br>
                                        <h6><strong><em>Total de periodos de prueba Suscripciones</em></strong></h6>
                                        <p><small><em>Número de periodos de prueba Packs Suscripciones:</em></small><br><strong><span name="no_periodos_prueba_suscripcion" id="no_periodos_prueba_suscripcion"><?php echo $resultados_mes_actual['data']['no_periodos_prueba_suscripcion']; ?></span></strong></p>
                                        <p><small><em>Total de periodos de prueba Packs Suscripciones:</em></small><br><strong><span name="periodos_prueba_suscripcion" id="periodos_prueba_suscripcion"><?php echo $resultados_mes_actual['data']['periodos_prueba_suscripcion']; ?></span></strong></p>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div-->

                    <div id="invoice-items-details" class="pt-2">
                        <div class="row">
                            <div class="table-responsive col-sm-12">

                                <div class="row mt-2">
                                    <div class="col-12">
                                        <!-- <div class="form-group float-md-right">
                                            <div id="buttons"></div>
                                        </div> -->
                                    </div>
                                </div>

                                <br>
                                <table name="tabla" id="tabla" class="table display nowrap table-striped table-bordered scroll-horizontal table-hover w-100" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Concepto Venta</th>
                                            <th scope="col">Método</th>
                                            <th scope="col">Comprador</th>
                                            <th scope="col">Categoría</th>
                                            <th scope="col">Estatus</th>
                                            <th scope="col">Costo</th>
                                            <th scope="col">Cant.</th>
                                            <th scope="col">Total</th>
                                            <th scope="col">Fecha Venta</th>
                                            <th scope="col">Comprador ID</th>
                                            <th scope="col">Usuario</th>
                                            <th scope="col">Nombre Completo</th>
                                            <th scope="col">Plan de Cliente ID</th>
                                            <th scope="col">Plan de Lista</th>
                                            <th scope="col">Días de vigencia</th>
                                            <th scope="col">Clases del Plan</th>
                                            <th scope="col">OpenPay Suscripción ID</th>
                                            <th scope="col">OpenPay Cliente ID</th>
                                            <th scope="col">Estatus Suscripción</th>
                                            <th scope="col">Última Actualización Suscripción</th>
                                            <th scope="col">Sucursal</th>
                                            <th scope="col">Vendedor</th>
                                            <th scope="col">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
        </div>
    </div>
</div>