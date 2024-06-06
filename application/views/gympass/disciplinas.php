<div class="app-content content center-layout">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title"><?php echo $pagina_titulo; ?></h3>
            </div>
        </div>
        <div class="content-body">

            <div class="row match-height">

                <div class="col-xl-8 col-md-8 col-sm-12">
                    <h4>Disciplinas internas</h4>
                    <table name="table" id="table" class="table display nowrap table-striped table-bordered scroll-horizontal table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Gympass Product ID</th>
                                <th>Estatus</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($disciplinas_list as $disciplina) : ?>
                                <tr>
                                    <td><?php echo $disciplina->id; ?></td>
                                    <td><?php echo $disciplina->nombre; ?></td>
                                    <td>
                                        <select class="form-control" id="select-<?php echo $disciplina->id; ?>" onchange="actualizar_disciplina(<?php echo $disciplina->id; ?>, this.value)">
                                            <option value="0">Aún no asignado</option>
                                            <?php foreach ($list_products['products'] as $product) : ?>
                                                <option value="<?php echo $product['product_id']; ?>" <?php echo ($product['product_id'] == $disciplina->gympass_product_id) ? 'selected' : ''; ?>><?php echo $product['name'] . ' (ID: ' . $product['product_id'] . ')'; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <td><?php echo mb_strtoupper($disciplina->estatus); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="col-xl-4 col-md-4 col-sm-12">
                    <h4>Disciplinas en Gympass</h4>
                    <table name="table_2" id="table_2" class="table display nowrap table-striped table-bordered scroll-horizontal table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($list_products['products'] as $product) : ?>
                                <tr>
                                    <td><?php echo $product['product_id']; ?></td>
                                    <td><?php echo $product['name']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
</div>