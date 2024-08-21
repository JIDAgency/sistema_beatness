<div class="app-content content center-layout">
    <div class="content-wrapper">

        <div class="row">
            <div class="col-12">
                <div class="card card-vista-titulos">
                    <h3 class="text-white"><strong><?php echo $pagina_titulo; ?></strong></h3>
                </div>
            </div>
        </div>

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
                                                                    <option value="0,0">Aún no asignado</option>
                                                                    <?php foreach ($list_products as $product) : ?>
                                                                        <option value="<?php echo $product->product_id . ',' . $product->gym_id; ?>" <?php echo ($product->product_id == $disciplina->gympass_product_id) ? 'selected' : ''; ?>>
                                                                            <?php echo $product->name . ' (ID: ' . $product->product_id . ')'; ?>
                                                                        </option>
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
                                                        <th>Gym ID</th>
                                                        <th>Product ID</th>
                                                        <th>Nombre</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($list_products as $product) : ?>
                                                        <tr>
                                                            <td><?php echo $product->gym_id; ?></td>
                                                            <td><?php echo $product->product_id; ?></td>
                                                            <td><?php echo $product->name; ?></td>
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