<div class="app-content content center-layout">
    <div class="content-wrapper">
        <div class="content-header row px-1 my-1">
            <div class="content-header-left col-md-6 col-12">

                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo site_url('inicio'); ?>">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo site_url('gympass'); ?>">Wellhub</a></li>
                            <li class="breadcrumb-item active"><?php echo $pagina_titulo; ?></li>
                        </ol>
                    </div>
                </div>

            </div>

            <div class="content-header-right col-md-6 col-12">

                <div class="media float-right">

                    <div class="form-group">
                        <!-- Outline button group with icons and text. -->
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a class="btn btn-outline-grey btn-outline-lighten-1 btn-min-width mr-1" href="<?php echo site_url($regresar_a); ?>"><i class="fa fa-arrow-circle-left"></i>&nbsp;Volver</a>
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

                                    <table name="table" id="table" class="table display nowrap table-striped table-bordered scroll-horizontal table-hover">
                                        <thead>
                                            <tr>
                                                <th>Opciones</th>
                                                <th>#</th>
                                                <th>Nombre</th>
                                                <th>Disciplina</th>
                                                <th>Gympass Gym ID</th>
                                                <th>Gympass Product ID</th>
                                                <th>Gympass Class ID</th>
                                                <th>Descripción</th>
                                                <th>Nota</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($categorias_list as $categoria_key => $categoria_value) : ?>
                                                <?php
                                                if (empty($categoria_value->gympass_class_id)) {
                                                    $opciones = '<a href="javascript:registrar(' . $categoria_value->id . ')">Registrar</a>';
                                                } else {
                                                    $opciones = '<a href="javascript:actualizar(' . $categoria_value->id . ')">Actualizar</a>';
                                                    $opciones .= ' | ';
                                                    $opciones .= '<a href="javascript:eliminar(' . $categoria_value->id . ')">Eliminar</a>';
                                                }
                                                ?>
                                                <tr>
                                                    <td><?php echo $opciones; ?></td>
                                                    <td><?php echo $categoria_key + 1; ?></td>
                                                    <td><?php echo $categoria_value->nombre; ?></td>
                                                    <td><?php echo $categoria_value->disciplinas_nombre; ?></td>
                                                    <td><a href="<?php echo site_url('gympass/disciplinas'); ?>"><?php echo $categoria_value->disciplinas_gympass_gym_id; ?></a></td>
                                                    <td><a href="<?php echo site_url('gympass/disciplinas'); ?>"><?php echo $categoria_value->disciplinas_gympass_product_id; ?></a></td>
                                                    <td><?php echo $categoria_value->gympass_class_id; ?></td>
                                                    <td><?php echo $categoria_value->descripcion; ?></td>
                                                    <td><?php echo $categoria_value->nota; ?></td>
                                                </tr>

                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>

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