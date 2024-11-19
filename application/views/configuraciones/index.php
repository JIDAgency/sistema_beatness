<div class="app-content content center-layout mt-2">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo site_url('inicio/index') ?>">Inicio</a>
                            </li>
                            <li class="breadcrumb-item active">Configuraciones
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
                                    <h4 class="card-title">Configuraciones de sistema</h4>
                                    <div class="heading-elements">
                                    </div>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <?php echo form_open($controlador, array('class' => 'needs-validation p-2 bg-white card', 'id' => 'form-configuraciones', 'novalidate' => '')); ?>

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

                                        <style>
                                            input::-webkit-outer-spin-button,
                                            input::-webkit-inner-spin-button {
                                                /* display: none; <- Crashes Chrome on hover */
                                                -webkit-appearance: none;
                                                margin: 0;
                                                /* <-- Apparently some margin are still there even though it's hidden */
                                            }

                                            input[type=number] {
                                                -moz-appearance: textfield;
                                                /* Firefox */
                                            }
                                        </style>

                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <span class="float-left">
                                                    <i class="fa fa-clock-o mr-1"></i>
                                                </span>
                                                <span class="float-right">
                                                    <fieldset class="form-group">
                                                        <small class="text-muted"><i>Valor en horas</i></small>
                                                        <div class="input-group">
                                                            <input type="number" class="form-control" name="app_cancelar_reservacion_hrs" id="app_cancelar_reservacion_hrs" placeholder="hrs." value="<?php echo set_value('app_cancelar_reservacion_hrs') == false ? $app_cancelar_reservacion_hrs->valor_1 : set_value('app_cancelar_reservacion_hrs'); ?>" maxlength="2" readonly="readonly" autocomplete="off" required="">
                                                            <div class="input-group-append">
                                                                <button class="btn btn-secondary" name="app_cancelar_reservacion_hrs_readonly" id="app_cancelar_reservacion_hrs_readonly" type="button"><i class="fa fa-pencil"></i></button>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </span>
                                                <strong><?php echo $app_cancelar_reservacion_hrs->nombre; ?></strong>
                                                <br>
                                                <small><em><?php echo $app_cancelar_reservacion_hrs->descripcion; ?></em></small>
                                            </li>

                                            <li class="list-group-item">
                                                <span class="float-left">
                                                    <i class="fa fa-clock-o mr-1"></i>
                                                </span>
                                                <span class="float-right">
                                                    <fieldset class="form-group">
                                                        <small class="text-muted"><i>Estatus de la configuración</i></small>
                                                        <div class="input-group">
                                                            <select class="form-control custom-select" name="app_prevenir_cancelacion_hrs_estatus" id="app_prevenir_cancelacion_hrs_estatus" required="">
                                                                <option value="">Seleccione un estatus...</option>
                                                                <option value="activo" <?php echo set_select('app_prevenir_cancelacion_hrs_estatus', $app_prevenir_cancelacion_hrs->estatus_1, set_value('app_prevenir_cancelacion_hrs_estatus') ? false : "activo" == $app_prevenir_cancelacion_hrs->estatus_1); ?>>Activo</option>
                                                                <option value="suspendido" <?php echo set_select('app_prevenir_cancelacion_hrs_estatus', $app_prevenir_cancelacion_hrs->estatus_1, set_value('app_prevenir_cancelacion_hrs_estatus') ? false : "suspendido" == $app_prevenir_cancelacion_hrs->estatus_1); ?>>Suspendido</option>
                                                            </select>
                                                            <div class="input-group-append">
                                                                <button class="btn btn-secondary" name="app_prevenir_cancelacion_hrs_readonly" id="app_prevenir_cancelacion_hrs_readonly" type="button"><i class="fa fa-pencil"></i></button>
                                                            </div>
                                                        </div>
                                                        <small class="text-muted"><i>Hora de inicio</i></small>
                                                        <div class="input-group">
                                                            <input type="time" class="form-control" name="app_prevenir_cancelacion_hrs_valor_1" id="app_prevenir_cancelacion_hrs_valor_1" placeholder="hrs." value="<?php echo set_value('app_prevenir_cancelacion_hrs_valor_1') == false ? $app_prevenir_cancelacion_hrs->valor_1 : set_value('app_prevenir_cancelacion_hrs_valor_1'); ?>" maxlength="2" readonly="readonly" autocomplete="off" required="">
                                                        </div>
                                                        <small class="text-muted"><i>Hora de fin</i></small>
                                                        <div class="input-group">
                                                            <input type="time" class="form-control" name="app_prevenir_cancelacion_hrs_valor_2" id="app_prevenir_cancelacion_hrs_valor_2" placeholder="hrs." value="<?php echo set_value('app_prevenir_cancelacion_hrs_valor_2') == false ? $app_prevenir_cancelacion_hrs->valor_2 : set_value('app_prevenir_cancelacion_hrs_valor_2'); ?>" maxlength="2" readonly="readonly" autocomplete="off" required="">
                                                        </div>
                                                    </fieldset>
                                                </span>
                                                <strong><?php echo $app_prevenir_cancelacion_hrs->nombre; ?></strong>
                                                <br>
                                                <small><em><?php echo $app_prevenir_cancelacion_hrs->descripcion; ?></em></small>
                                            </li>
                                        </ul>

                                        <div class="form-actions right">
                                            <a href="<?php echo site_url('clases/index'); ?>" class="btn btn-secondary btn-sm">Cancelar</a>
                                            <button type="submit" class="btn btn-secondary btn-sm">Guardar</button>
                                        </div>

                                        <?php echo form_close(); ?>

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