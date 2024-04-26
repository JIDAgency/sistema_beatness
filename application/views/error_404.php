<!DOCTYPE html>
<html class="loading" lang="es" data-textdirection="ltr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">

    <title><?php echo isset($pagina_titulo) ? $pagina_titulo . " | " : ""; ?><?php echo titulo() ? titulo() : ""; ?></title>

    <link rel="apple-touch-icon" href="<?php echo base_url('almacenamiento/recursos/logos/og.jpg'); ?>">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>almacenamiento/favicon/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Muli:300,400,500,700" rel="stylesheet">
    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/vendors.css">
    <!-- END VENDOR CSS-->
    <!-- BEGIN ROBUST CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/app.css">
    <!-- END ROBUST CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/core/menu/menu-types/horizontal-menu.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/pages/error.css">
    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style.css">
    <!-- END Custom CSS-->
</head>

<body class="horizontal-layout horizontal-menu horizontal-menu-padding 1-column   menu-expanded blank-page blank-page" data-open="hover" data-menu="horizontal-menu" data-col="1-column">

    <!-- ////////////////////////////////////////////////////////////////////////////-->
    <div class="app-content content">
        <div class="content-wrapper">

            <div class="content-header row">
            </div>

            <div class="content-body">

                <section class="flexbox-container">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="col-md-4 col-10 p-0">

                            <div class="card-header bg-transparent border-0">
                                <h2 class="error-code text-center mb-2">404</h2>
                                <h3 class="text-uppercase text-center">¡Página no encontrada!</h3>
                            </div>

                            <div class="card-footer bg-transparent">
                                <div class="row">
                                    <p class="text-muted text-center col-12 py-1">Copyright &copy; <script>
                                            document.write(new Date().getFullYear())
                                        </script> <?php echo nombre_fiscal(); ?>, Todos los derechos reservados.</p>
                                    <div class="col-12 text-center">

                                        <?php if (facebook()) : ?>
                                            <a href="<?php echo facebook(); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-social-icon mr-1 mb-1 btn-outline-facebook">
                                                <span class="fa fa-facebook"></span>
                                            </a>
                                        <?php endif; ?>

                                        <?php if (instagram()) : ?>
                                            <a href="<?php echo instagram(); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-social-icon mr-1 mb-1 btn-outline-instagram">
                                                <span class="fa fa-instagram font-medium-4"></span>
                                            </a>
                                        <?php endif; ?>

                                        <?php if (linkedin()) : ?>
                                            <a href="<?php echo linkedin(); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-social-icon mr-1 mb-1 btn-outline-linkedin">
                                                <span class="fa fa-linkedin font-medium-4"></span>
                                            </a>
                                        <?php endif; ?>

                                        <?php if (twitter()) : ?>
                                            <a href="<?php echo twitter(); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-social-icon mr-1 mb-1 btn-outline-twitter">
                                                <span class="fa fa-twitter"></span>
                                            </a>
                                        <?php endif; ?>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>

    <!-- ////////////////////////////////////////////////////////////////////////////-->

    <!-- BEGIN VENDOR JS-->
    <script src="<?php echo base_url(); ?>app-assets/vendors/js/vendors.min.js" type="text/javascript"></script>
    <!-- BEGIN VENDOR JS-->
    <!-- BEGIN PAGE VENDOR JS-->
    <script type="text/javascript" src="<?php echo base_url(); ?>app-assets/vendors/js/ui/jquery.sticky.js"></script>
    <script src="<?php echo base_url(); ?>app-assets/vendors/js/forms/validation/jqBootstrapValidation.js" type="text/javascript"></script>
    <!-- END PAGE VENDOR JS-->
    <!-- BEGIN ROBUST JS-->
    <script src="<?php echo base_url(); ?>app-assets/js/core/app-menu.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>app-assets/js/core/app.js" type="text/javascript"></script>
    <!-- END ROBUST JS-->
    <!-- BEGIN PAGE LEVEL JS-->
    <script src="<?php echo base_url(); ?>app-assets/js/scripts/forms/form-login-register.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL JS-->
</body>

</html>