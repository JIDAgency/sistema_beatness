<div class="app-content content center-layout mt-2">
    <div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo site_url('inicio/index') ?>">Inicio</a>
                </li>
                <li class="breadcrumb-item active">Historial de reservaciones</a>
                </li>
            </ol>
            </div>
        </div>
        <h3 class="content-header-title mb-0">Listado de reservaciones</h3>
        </div>
    </div>
    <section id="show-hidden">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Reservaciones de clientes</h4>
                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                            <!--li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li-->
                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                            <!--li><a data-action="close"><i class="ft-x"></i></a></li-->
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body card-dashboard">
                            <?php $this->load->view('_comun/mensajes_alerta');?>

                            <div class="row">
                                <div class="col-xl-3 col-lg-12">
                                    <div class="form-group">
                                        <h5 class="card-titlel"><i class="ft-filter"></i> Estatus del cliente</h5>
                                        <select id="mes_a_consultar" name="mes_a_consultar" class="select2 form-control">
                                            
                                            <?php foreach ($period as $dt): ?>
                                                <?php 
                                                    $date = DateTime::createFromFormat("Y-m", $dt->format("Y-m"));
                                                ?>
                                                <option value="<?php echo $dt->format("Y-m"); ?>" <?php echo set_select('mes_a_consultar', $dt->format("Y-m") , set_value('mes_a_consultar') ? false : $dt->format("Y-m") == date('Y-m'));?>><?php echo ucfirst(strftime("%B de %Y",$date->getTimestamp())); ?></option>
                                            <?php endforeach;?>

                                        </select>                                    
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="content-header-right col-md-12 col-12">
                                    
                                    <div class="form-group float-md-right">
                                        <div id="buttons"></div>
                                    </div>

                                </div>
                            </div>

                            <table id="tabla-historial-reservaciones" class="table table-striped table-bordered dataex-res-immediately table-striped">
                                <thead>
                                    <th>ID</th>
                                    <th>Clase</th>
                                    <th>Usuario</th>
                                    <th>Disciplina</th>
                                    <th>Lugar</th>
                                    <th>asistencia</th>
                                    <th>Fecha</th>
                                    <th>Estatus</th>
                                    <th>Opciones</th>
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