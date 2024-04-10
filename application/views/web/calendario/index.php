<!DOCTYPE html>
<html class="loading" lang="es" data-textdirection="ltr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Robust admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template.">
    <meta name="keywords" content="admin template, robust admin template, dashboard template, flat admin template, responsive admin template, web app, crypto dashboard, bitcoin dashboard">
    <meta name="author" content="BEATNESS STUDIO">
    <title>Tabs - Robust - Responsive Bootstrap 4 Admin Dashboard Template for Web Application</title>
    <link rel="apple-touch-icon" href="<?php echo base_url(); ?>app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>app-assets/images/ico/favicon.ico">
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

    <style>
        .nav {
            padding-left: 0 !important;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            color: #f0f0f0;

        }

        th,
        td {
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: rgba(240, 240, 240, 0.5);
            color: #f0f0f0;
        }

        th:first-child,
        td:first-child {
            text-align: left;
        }

        tr:first-child td {
            border-top: none;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .weekdays {
            margin-bottom: 20px;
        }
    </style>
</head>

<body class="horizontal-layout bg-calendario horizontal-menu horizontal-menu-padding 2-columns   menu-expanded" data-open="hover" data-menu="horizontal-menu" data-col="2-columns">

    <!-- ////////////////////////////////////////////////////////////////////////////-->

    <div class="app-content content center-layout mt-2">
        <div class="content-wrapper">

            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title text-white mb-0">CALENDARIOS</h3>
                </div>
                <div class="content-header-right col-md-6 col-12">
                </div>
            </div>

            <div class="content-body">

                <!-- Start -->
                <section id="basic-tabs-components">
                    <div class="row match-height">
                        <div class="col-xl-12 col-lg-12">
                            <div class="card card-transparent no-border">
                                <div class="card-header bg-transparent">
                                    <h4 class="card-title text-white" name="card_titulo" id="card_titulo">CLASES DE <span name="disciplina_titulo" id="disciplina_titulo"></span> </h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body bg-transparent">

                                        <div class="row match-height">
                                            <div class="col-xl-6 col-md-6 col-sm-12">

                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="col-lg-12 text-white"><b>+ DISCIPLINAS&nbsp;</b></label>
                                                        <div class="col-lg-12">
                                                            <select class="form-control select2 custom-select" name="disciplina_seleccionada" id="disciplina_seleccionada" required>
                                                                <?php foreach ($disciplinas_list as $disciplina_key => $disciplina_value) : ?>
                                                                    <?php if ($disciplina_key != 0) : ?>
                                                                        <option value="<?php echo $disciplina_value->id; ?>" <?php echo ($disciplina_key == 1) ? 'selected' : ''; ?> <?php echo set_select('disciplina_seleccionada', $disciplina_value->id, set_value('disciplina_seleccionada') ? false : $disciplina_value->id == $this->session->flashdata('disciplina_seleccionada')); ?>><?php echo trim(ucfirst($disciplina_value->nombre)); ?></option>
                                                                    <?php endif; ?>
                                                                <?php endforeach; ?>
                                                            </select>
                                                            <div class="invalid-feedback">
                                                                Se requiere seleccionar un servicio válido.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div name="contenido_semana" id="contenido_semana">
                                        </div>

                                        <div name="contenido_fin_de_semana" id="contenido_fin_de_semana">
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
    <script src="<?php echo base_url(); ?>assets/js/web/calendario/index.js"></script>

</body>

</html>