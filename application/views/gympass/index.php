<div class="app-content content center-layout">
    <div class="content-wrapper">

        <div class="row">
            <div class="col-12">
                <div class="card card-vista-titulos ">
                    <h3 class="text-white"><strong><?php echo $pagina_titulo; ?></strong></h3>
                </div>
            </div>
        </div>

        <div class="content-header row px-1 my-1">

            <div class="content-header-left col-md-6 col-12">

                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo site_url('site/inicio'); ?>">Inicio</a></li>
                            <li class="breadcrumb-item active"><?php echo $pagina_titulo; ?></li>
                        </ol>
                    </div>
                </div>

            </div>

            <div class="content-header-right col-md-6 col-12">

                <!-- <div class="media float-right">

                    <div class="form-group">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a class="btn btn-outline-secondary" href="<?php // echo site_url('site/roles/agregar'); 
                                                                        ?>"><i class="fa fa-plus-circle"></i>&nbsp;Agregar</a>
                        </div>
                    </div>

                </div> -->

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

                                    <?php print_r($list_products); ?>

                                    <br>
                                    <br>

                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nombre</th>
                                                <th>Última Actualización</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($list_products['products'] as $product) : ?>
                                                <tr>
                                                    <td><?php echo $product['product_id']; ?></td>
                                                    <td><?php echo $product['name']; ?></td>
                                                    <td><?php echo $product['updated_at']; ?></td>
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