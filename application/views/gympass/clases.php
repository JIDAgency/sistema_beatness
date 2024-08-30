<?php $this->load->view('modals/gympass/registrar_clase'); ?>

<div class="app-content content center-layout">
    <div class="content-wrapper">
        <div class="content-header row px-1 my-1">

            <div class="content-header-left col-md-6 col-12">

                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo site_url('inicio'); ?>">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo site_url('gympass'); ?>">GymPass</a></li>
                            <li class="breadcrumb-item active"><?php echo $pagina_titulo; ?></li>
                        </ol>
                    </div>
                </div>

            </div>

            <div class="content-header-right col-md-6 col-12">

                <div class="media float-right">

                    <div class="form-group">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a class="btn btn-outline-grey btn-outline-lighten-1 btn-min-width" href="<?php echo site_url($regresar_a); ?>"><i class="fa fa-arrow-circle-left"></i>&nbsp;Volver</a>
                            <a class="btn btn-outline-secondary btn-min-width" href="<?php echo site_url('gympass/disciplinas'); ?>">Disciplinas</a>
                            <a class="btn btn-outline-secondary btn-min-width mr-1" href="<?php echo site_url('gympass/categorias'); ?>">Categorias</a>
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

                                    <p name="mensaje_en_pantalla" id="mensaje_en_pantalla"></p>

                                    <div class="row match-height">
                                        <div class="col-xl-12 col-md-12 col-sm-12">

                                            <table name="table" id="table" class="table display nowrap table-striped table-bordered scroll-horizontal table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Opciones</th>
                                                        <th>#</th>
                                                        <th>Gympass</th>
                                                        <th>SKU</th>
                                                        <th>Disciplina</th>
                                                        <th>Grupo muscular</th>
                                                        <th>Fecha</th>
                                                        <th>Horario</th>
                                                        <th>Coach</th>
                                                        <th>Sucursal</th>
                                                        <th>Cupos</th>
                                                        <th>Estatus</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($clases_list as $clase_key => $clase_value) : ?>
                                                        <tr>
                                                            <td>
                                                                <?php
                                                                if (!empty($clase_value->gympass_slot_id)) {
                                                                    echo '<a href="javascript:actualizar_clase(' . $clase_value->id . ');">Actualizar</a>';
                                                                    echo ' | ';
                                                                    echo '<a href="javascript:eliminar_clase(' . $clase_value->id . ');">Eliminar</a>';
                                                                    echo ' | ';
                                                                    echo '<a href="javascript:reservacion_clase(' . $clase_value->id . ');">Simular reservación</a>';
                                                                } else {
                                                                    echo '<a href="javascript:modal_registrar_clase(' . $clase_value->id . ', ' . htmlspecialchars(json_encode(array(
                                                                        'identificador' => $clase_value->identificador,
                                                                        'disciplina_id' => $clase_value->disciplina_id,
                                                                        'disciplinas_nombre' => $clase_value->disciplinas_nombre,
                                                                        'dificultad' => $clase_value->dificultad,
                                                                        'disciplinas_gympass_gym_id' => $clase_value->disciplinas_gympass_gym_id,
                                                                        'disciplinas_gympass_product_id' => $clase_value->disciplinas_gympass_product_id,
                                                                        'gympass_slot_id' => $clase_value->gympass_slot_id,
                                                                        'fecha' => date('Y-m-d', strtotime($clase_value->inicia)),
                                                                        'horario' => date('h:iA', strtotime($clase_value->inicia)),
                                                                        'instructores_nombre' => $clase_value->instructores_nombre,
                                                                        'sucursales_locacion' => $clase_value->sucursales_locacion,
                                                                        'cupos' => $clase_value->reservado . '/' . $clase_value->cupo,
                                                                    )), ENT_QUOTES, 'UTF-8') . ');">Registrar</a>';
                                                                }
                                                                ?>
                                                            </td>
                                                            <td><?php echo $clase_value->id; ?></td>
                                                            <td><?php echo !empty($clase_value->gympass_slot_id) ? '<span class="text-success">Registrada</span>' : '<span class="text-warning">Sin registro</span>'; ?></td>
                                                            <td><?php echo $clase_value->identificador; ?></td>
                                                            <td><?php echo $clase_value->disciplinas_nombre; ?></td>
                                                            <td><?php echo $clase_value->dificultad; ?></td>
                                                            <td><?php echo date('Y-m-d', strtotime($clase_value->inicia)); ?></td>
                                                            <td><?php echo date('h:iA', strtotime($clase_value->inicia)); ?></td>
                                                            <td><?php echo $clase_value->instructores_nombre; ?></td>
                                                            <td><?php echo $clase_value->sucursales_locacion; ?></td>
                                                            <td><?php echo $clase_value->reservado . '/' . $clase_value->cupo; ?></td>
                                                            <td><?php echo $clase_value->estatus; ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
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