<div class="app-content content center-layout">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title"><?php echo $pagina_titulo; ?></h3>
            </div>
        </div>
        <div class="content-body">

            <div class="row match-height">

                <div class="col-xl-12 col-md-12 col-sm-12">
                    <h4><?php echo $pagina_subtitulo; ?></h4>

                    <table name="table" id="table" class="table display nowrap table-striped table-bordered scroll-horizontal table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Disciplina</th>
                                <th>Descripción</th>
                                <th>Nota</th>
                                <th>Gympass ID</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categorias_list as $categoria_key => $categoria_value) : ?>
                                <?php
                                if (empty($categoria_value->gympass_id)) {
                                    $opciones = '<a href="javascript:registrar(' . $categoria_value->id . ')">Registrar</a>';
                                } else {
                                    $opciones = '<a href="javascript:actualizar(' . $categoria_value->id . ')">Actualizar</a>';
                                }
                                ?>
                                <tr>
                                    <td><?php echo $categoria_value->id; ?></td>
                                    <td><?php echo $categoria_value->nombre; ?></td>
                                    <td><?php echo $categoria_value->disciplinas_nombre; ?></td>
                                    <td><?php echo $categoria_value->descripcion; ?></td>
                                    <td><?php echo $categoria_value->nota; ?></td>
                                    <td><?php echo $categoria_value->gympass_id; ?></td>
                                    <td><?php echo $opciones; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                </div>

            </div>

        </div>
    </div>
</div>