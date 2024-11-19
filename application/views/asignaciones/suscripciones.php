<div class="app-content content center-layout mt-2">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo site_url('inicio/index') ?>">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo site_url('asignaciones') ?>">Planes de clientes</a></li>
                            <li class="breadcrumb-item active">Sucripciones</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-wrapper">
            <div class="content-body">
                <section>
                    <div class="row">
                        <div class="col-12">
                            <div class="card no-border">
                                <div class="card-header">
                                    <h4 class="card-title">Suscripciones</h4>
                                    <div class="heading-elements">
                                    </div>
                                </div>
                                <div class="card-content p_dt">
                                    <div class="card-body">
                                        <?php $this->load->view('_comun/mensajes_alerta'); ?>
                                        <table name="tabla" id="tabla" class="table display nowrap table-striped table-bordered scroll-horizontal table-hover w-100" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Plan ID</th>
                                                    <th>Nombre</th>
                                                    <th>Cliente</th>
                                                    <th>Suscripcion ID</th>
                                                    <th>Cliente ID</th>
                                                    <th>Usuario</th>
                                                    <th>Fecha activación</th>
                                                    <th>Ultima actualización</th>
                                                    <th>Estatus del pago</th>
                                                    <th>Estatus</th>
                                                    <th>Opciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($suscripciones_list as $suscripcion_row) : ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $suscripcion_row->id; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $suscripcion_row->plan_id; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $suscripcion_row->nombre; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $suscripcion_row->cliente_nombre; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $suscripcion_row->openpay_suscripcion_id; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $suscripcion_row->openpay_cliente_id; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo trim($suscripcion_row->cliente_correo . ' #' . $suscripcion_row->usuario_id); ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $suscripcion_row->fecha_activacion; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $suscripcion_row->suscripcion_fecha_de_actualizacion; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $suscripcion_row->suscripcion_estatus_del_pago; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $suscripcion_row->estatus; ?>
                                                        </td>
                                                        <td>
                                                            <br>
                                                            <a href="<?php echo site_url('asignaciones/suscripcion_activar/' . $suscripcion_row->id); ?>"><i class="fa fa-check"></i> Activar</a>
                                                            <br>
                                                            <a href="<?php echo site_url('asignaciones/suscripcion_suspender/' . $suscripcion_row->id); ?>"><i class="fa fa-trash"></i> Suspender</a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
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
</div>