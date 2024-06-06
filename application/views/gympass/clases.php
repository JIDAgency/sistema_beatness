<?php $this->load->view('modals/gympass/registrar_clase'); ?>

<div class="app-content content center-layout">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title"><?php echo $pagina_titulo; ?></h3>
            </div>
        </div>
        <div class="content-body">
            <?php $this->load->view('_templates/mensajes_alerta.tpl.php'); ?>

            <div class="row match-height">

                <div class="col-xl-12 col-md-12 col-sm-12">
                    <?php print_r($clases_list[0]); ?>

                    <h4>Clases activas</h4>
                    <table name="table" id="table" class="table display nowrap table-striped table-bordered scroll-horizontal table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>SKU</th>
                                <th>Disciplina</th>
                                <th>Grupo muscular</th>
                                <th>Fecha</th>
                                <th>Horario</th>
                                <th>Coach</th>
                                <th>Sucursal</th>
                                <th>Cupos</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($clases_list as $clase_key => $clase_value) : ?>
                                <tr>
                                    <td><?php echo $clase_value->id; ?></td>
                                    <td><?php echo $clase_value->identificador; ?></td>
                                    <td><?php echo $clase_value->disciplinas_nombre; ?></td>
                                    <td><?php echo $clase_value->dificultad; ?></td>
                                    <td><?php echo date('Y-m-d', strtotime($clase_value->inicia)); ?></td>
                                    <td><?php echo date('h:iA', strtotime($clase_value->inicia)); ?></td>
                                    <td><?php echo $clase_value->instructores_nombre; ?></td>
                                    <td><?php echo $clase_value->sucursales_locacion; ?></td>
                                    <td><?php echo $clase_value->reservado . '/' . $clase_value->cupo; ?></td>
                                    <td>
                                        <?php
                                        echo '<a href="javascript:modal_registrar_clase(' . $clase_value->id . ', ' . htmlspecialchars(json_encode(array(
                                            'identificador' => $clase_value->identificador,
                                            'disciplinas_nombre' => $clase_value->disciplinas_nombre,
                                            'dificultad' => $clase_value->dificultad,
                                            'fecha' => date('Y-m-d', strtotime($clase_value->inicia)),
                                            'horario' => date('h:iA', strtotime($clase_value->inicia)),
                                            'instructores_nombre' => $clase_value->instructores_nombre,
                                            'sucursales_locacion' => $clase_value->sucursales_locacion,
                                            'cupos' => $clase_value->reservado . '/' . $clase_value->cupo,
                                        )), ENT_QUOTES, 'UTF-8') . ');">Registrar</a>';
                                        ?>
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