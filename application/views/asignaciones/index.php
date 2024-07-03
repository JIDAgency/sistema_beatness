<div class="app-content content center-layout mt-2">
    <div class="content-wrapper">

        <div class="content-header row">

            <div class="content-header-left col-md-6 col-12 mb-2">

                <h3 class="content-header-title mb-0"><?php echo $pagina_titulo; ?></h3>

                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo site_url('site/inicio'); ?>">Inicio</a></li>
                            <li class="breadcrumb-item active"><?php echo $pagina_titulo; ?></li>
                        </ol>
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

                                    <div class="row">

                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <label for="table"><b>Planes vigentes</b></label>
                                            <div class="form-group float-md-right mr-1">
                                                <div id="buttons"></div>
                                            </div>
                                            <table class="table display nowrap table-striped table-bordered scroll-horizontal table-hover" name="table" id="table">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Usuario</th>
                                                        <th>Nombre</th>
                                                        <th>Planes</th>
                                                        <th>Estatus</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <label for="table2"><b>Planes por vencer</b></label>
                                            <div class="form-group float-md-right mr-1">
                                                <div id="buttons2"></div>
                                            </div>
                                            <table class="table display nowrap table-striped table-bordered scroll-horizontal table-hover" name="table2" id="table2">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Usuario</th>
                                                        <th>Nombre</th>
                                                        <th>Planes</th>
                                                        <th>Estatus</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <label for="table3"><b>Planes vencidos</b></label>
                                            <div class="form-group float-md-right mr-1">
                                                <div id="buttons3"></div>
                                            </div>
                                            <table class="table display nowrap table-striped table-bordered scroll-horizontal table-hover" name="table3" id="table3">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Usuario</th>
                                                        <th>Nombre</th>
                                                        <th>Planes</th>
                                                        <th>Estatus</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
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