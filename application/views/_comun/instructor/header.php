<!DOCTYPE html>
    <html class="loading" lang="en" data-textdirection="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="<?php echo description();?>">
    <meta name="keywords" content="<?php echo keywords();?>">
    <meta name="author" content="<?php echo author();?>">

    <title><?php echo isset($pagina_titulo) ? $pagina_titulo : ''; ?> | <?php echo titulo(); ?></title>

    <link rel="apple-touch-icon" href="<?php echo base_url(); ?>app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Muli:300,400,500,700"
    rel="stylesheet">
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

    <?php if (isset($styles) && is_array($styles)): ?>
        <?php foreach ($styles as $style): ?>
            <link rel="stylesheet" type="text/css" href="<?php echo !$style['es_rel'] ? $style['href'] : base_url() . 'assets/css/' . $style['href']; ?>">
        <?php endforeach;?>
    <?php endif;?>
</head>

<body class="horizontal-layout horizontal-menu horizontal-menu-padding 2-columns menu-expanded" data-open="hover" data-menu="horizontal-menu" data-col="2-columns">
    <!-- fixed-top-->
    <nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-static-top navbar-dark navbar-border navbar-brand-center">
        <div class="navbar-wrapper">
            <div class="navbar-header">
                <ul class="nav navbar-nav flex-row">
                    <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
                    <li class="nav-item">
                        <a class="navbar-brand" href="<?php site_url("instructor/inicio"); ?>">
                            <img class="img-responsive" alt="Logo" src="<?php echo base_url(); ?>almacenamiento/logos/logo-light.png">
                        </a>
                    </li>
                    <li class="nav-item d-md-none">
                        <a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="fa fa-ellipsis-v"></i></a>
                    </li>
                </ul>
            </div>

            <div class="navbar-container container center-layout">
                <div class="collapse navbar-collapse" id="navbar-mobile">

                    <ul class="nav navbar-nav mr-auto float-left">
                        <li class="nav-item d-none d-md-block">
                            <a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu"></i></a>
                        </li>
                    </ul>

                    <ul class="nav navbar-nav float-right">
                    
                        <li class="dropdown dropdown-user nav-item">
                            <a class="nav-link" href="#" data-toggle="dropdown">
                                <span><?php 
                                    date_default_timezone_set('America/Mexico_City');
                                    setlocale(LC_TIME,"es_ES.UTF-8");
                                    echo strftime("%a-%d-%b-%Y");
                                ?></span>
                            </a>
                        </li>

                        <li class="dropdown dropdown-user nav-item">
                            <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                                <span class="avatar avatar-online"><img src="<?php echo base_url(); ?>/subidas/perfil/<?php echo $this->session->userdata['nombre_imagen_avatar']; ?>" alt="avatar"><i></i></span>
                                <span class="user-name"><?php echo isset($nombre_completo) ? $nombre_completo : ''; ?> <?php echo $this->session->userdata("nombre") ?></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <!--a class="dropdown-item" href="<?php //echo site_url('usuarios/perfil'); ?>"><i class="ft-user"></i> Mi perfil</a-->
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?php echo site_url('cuenta/cerrar_sesion'); ?>"><i class="ft-power"></i> Cerrar sesión</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="header-navbar navbar-expand-sm navbar navbar-horizontal navbar-fixed navbar-light navbar-without-dd-arrow navbar-shadow" role="navigation" data-menu="menu-wrapper">
        <div class="navbar-container main-menu-content container center-layout" data-menu="menu-container">
            <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">
                <li class="nav-item"><a class="nav-link <?php echo isset($menu_instructor_inicio) ? 'active' : ''; ?>" href="<?php echo site_url('instructor/inicio'); ?>"><i class="icon-home"></i><span>Inicio</span></a></li>
            </ul>
        </div>
    </div>