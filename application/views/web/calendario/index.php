<!DOCTYPE html>
<html class="loading" lang="es" data-textdirection="ltr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

    <meta name="description" content="<?php echo descripcion(); ?>">
    <meta name="keywords" content="<?php echo palabras_clave(); ?>">
    <meta name="author" content="<?php echo autor(); ?>">

    <!-- Open Graph Tags -->
    <meta property="og:title" content="<?php echo isset($pagina_titulo) ? $pagina_titulo . " | " : ""; ?><?php echo titulo() ? titulo() : ""; ?>">
    <meta property="og:description" content="<?php echo descripcion(); ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo base_url(); ?>">
    <meta property="og:image" content="<?php echo base_url(); ?>almacenamiento/logos/logo.jpg">
    <!-- Fin de Open Graph Tags -->

    <title><?php echo isset($pagina_titulo) ? $pagina_titulo . " | " : ""; ?><?php echo titulo() ? titulo() : ""; ?></title>

    <link rel="apple-touch-icon" href="<?php echo base_url(); ?>almacenamiento/logos/logo.jpg">
    <link rel=" shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>almacenamiento/logos/logo.jpg">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i%7CMuli:300,400,500,700" rel="stylesheet">
    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/vendors.css">
    <!-- END VENDOR CSS-->
    <!-- BEGIN ROBUST CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/app.css">
    <!-- END ROBUST CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/core/menu/menu-types/horizontal-menu.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/core/colors/palette-gradient.css">
    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style.css">
    <!-- END Custom CSS-->

    <?php if (isset($styles) && is_array($styles)) : ?>
        <?php foreach ($styles as $style) : ?>
            <link rel="stylesheet" type="text/css" href="<?php echo !$style['es_rel'] ? $style['href'] : base_url() . 'assets/css/' . $style['href']; ?>">
        <?php endforeach; ?>
    <?php endif; ?>

</head>

<body class="horizontal-layout bg-calendario horizontal-menu horizontal-menu-padding 2-columns   menu-expanded" data-open="hover" data-menu="horizontal-menu" data-col="2-columns">

    <!-- ////////////////////////////////////////////////////////////////////////////-->

    <div class="app-content content center-layout mt-2">
        <div class="content-wrapper">

            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title text-bold-600 text-white mb-0">CALENDARIO</h3>
                </div>
                <div class="content-header-right col-md-6 col-12">
                </div>
            </div>

            <div class="content-body">

                <!-- Start -->
                <section id="basic-tabs-components">

                    <div class="row match-height">
                        <div class="col-xl-6 col-md-6 col-sm-12">

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-12 text-white"><b>+ DISCIPLINAS</b></label>
                                    <div class="col-lg-8">
                                        <select class="form-control select2 custom-select tp-select" name="disciplina_seleccionada" id="disciplina_seleccionada" required>
                                            <option value="" <?php echo set_select('disciplina_seleccionada', '', set_value('disciplina_seleccionada') ? false : '' == $this->session->flashdata('disciplina_seleccionada')); ?>>Seleccione una disciplina…</option>
                                            <?php foreach ($disciplinas_list as $disciplina_key => $disciplina_value) : ?>
                                                <?php if ($disciplina_key != 0 and $disciplina_value->estatus == 'activo' and $disciplina_value->mostrar_en_app == 'si') : ?>
                                                    <option value="<?php echo $disciplina_value->id; ?>" <?php // echo ($disciplina_key == 1) ? 'selected' : ''; 
                                                                                                            ?> <?php echo set_select('disciplina_seleccionada', $disciplina_value->id, set_value('disciplina_seleccionada') ? false : $disciplina_value->id == $this->session->flashdata('disciplina_seleccionada')); ?>>
                                                        <?php echo trim(ucfirst($disciplina_value->nombre)); ?>
                                                    </option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            Se requiere seleccionar una disciplina válida.
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 d-flex align-items-center">
                                        <a id="reload">
                                            <h3 class="white"><i class="ft-refresh-cw" id="loading"></i></h3>
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row match-height">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="card card-transparent no-border">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="base-tab1" data-toggle="tab" aria-controls="tab1" href="#tab1" aria-expanded="true">Semana actual <?php echo date('d/m/Y', strtotime($fecha_lunes)) . ' - ' . date('d/m/Y', strtotime($fecha_domingo)); ?></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2" href="#tab2" aria-expanded="false">Semana siguiente <?php echo date('d/m/Y', strtotime($fecha_lunes_siguente)) . ' - ' . date('d/m/Y', strtotime($fecha_domingo_siguente)); ?></a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="tab1" aria-expanded="true" aria-labelledby="base-tab1">
                                        <div class="card-header bg-transparent">
                                            <h4 class="card-title text-bold-600 text-white" name="card_titulo" id="card_titulo">
                                                <span name="disciplina_titulo" id="disciplina_titulo"></span>
                                            </h4>
                                        </div>

                                        <div class="card-content">
                                            <div class="card-body bg-transparent">

                                                <div name="contenido_semana" id="contenido_semana">
                                                </div>

                                                <br>
                                                <br>

                                                <div name="contenido_fin_de_semana" id="contenido_fin_de_semana">
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab2" aria-labelledby="base-tab2">

                                        <div class="card-header bg-transparent">
                                            <h4 class="card-title text-bold-600 text-white" name="card_titulo" id="card_titulo">
                                                <span name="disciplina_titulo_siguiente" id="disciplina_titulo_siguiente"></span>
                                            </h4>
                                        </div>

                                        <div class="card-content">
                                            <div class="card-body bg-transparent">

                                                <div name="contenido_semana_siguiente" id="contenido_semana_siguiente">
                                                </div>

                                                <br>
                                                <br>

                                                <div name="contenido_fin_de_semana_siguiente" id="contenido_fin_de_semana_siguiente">
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- End -->

            </div>
        </div>
    </div>

    <!-- ////////////////////////////////////////////////////////////////////////////-->


    <!-- <footer class="footer footer-static footer-light navbar-shadow">
        <p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2 container center-layout"><span class="float-md-left d-block d-md-inline-block">Copyright &copy; 2018 <a class="text-bold-800 grey darken-2" href="https://themeforest.net/user/pixinvent/portfolio?ref=pixinvent" target="_blank">PIXINVENT </a>, All rights reserved. </span><span class="float-md-right d-block d-md-inline-blockd-none d-lg-block">Hand-crafted & Made with <i class="ft-heart pink"></i></span></p>
    </footer> -->

    <!-- BEGIN VENDOR JS-->
    <script src="<?php echo base_url(); ?>app-assets/vendors/js/vendors.min.js"></script>
    <!-- BEGIN VENDOR JS-->
    <!-- BEGIN PAGE VENDOR JS-->
    <script src="<?php echo base_url(); ?>app-assets/vendors/js/ui/jquery.sticky.js"></script>
    <!-- END PAGE VENDOR JS-->
    <!-- BEGIN ROBUST JS-->
    <script src="<?php echo base_url(); ?>app-assets/js/core/app-menu.js"></script>
    <script src="<?php echo base_url(); ?>app-assets/js/core/app.js"></script>
    <!-- END ROBUST JS-->
    <!-- BEGIN PAGE LEVEL JS-->
    <script src="<?php echo base_url(); ?>app-assets/js/scripts/navs/navs.js"></script>
    <!-- END PAGE LEVEL JS-->
    <?php if (isset($scripts) && is_array($scripts)) : ?>
        <?php foreach ($scripts as $script) : ?>
            <script type="text/javascript" src="<?php echo !$script['es_rel'] ? $script['src'] : base_url() . 'assets/js/' . $script['src']; ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>

</body>

</html>