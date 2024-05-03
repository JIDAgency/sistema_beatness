<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

    <meta name="description" content="<?php echo description(); ?>">
    <meta name="keywords" content="<?php echo keywords(); ?>">
    <meta name="author" content="<?php echo author(); ?>">

    <title><?php echo isset($pagina_titulo) ? $pagina_titulo : ''; ?> | <?php echo titulo(); ?></title>

    <link rel="apple-touch-icon" href="<?php echo base_url(); ?>almacenamiento/logos/open-graph.jpg">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>almacenamiento/logos/logo.jpg">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Muli:300,400,500,700">
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

<body class="horizontal-layout horizontal-menu horizontal-menu-padding 2-columns menu-expanded" data-open="hover" data-menu="horizontal-menu" data-col="2-columns">

    <nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-static-top navbar-light navbar-border navbar-brand-center">
        <div class="navbar-wrapper">
            <div class="navbar-header">
                <ul class="nav navbar-nav flex-row">

                    <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>

                    <li class="nav-item">
                        <a class="navbar-brand" href="<?php base_url(); ?>">
                            <img class="img-responsive" width="50" alt="Logo" src="<?php echo base_url(); ?>almacenamiento/logos/logo.png">
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
                                <span><?php date_default_timezone_set('America/Mexico_City');
                                        setlocale(LC_TIME, "es_ES.UTF-8");
                                        echo strftime("%a-%d-%b-%Y"); ?></span>
                            </a>
                        </li>

                        <li class="dropdown dropdown-user nav-item">
                            <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                                <span class="avatar avatar-online"><img src="<?php echo base_url(); ?>/subidas/perfil/<?php echo $this->session->userdata['nombre_imagen_avatar']; ?>" alt="avatar"><i></i></span>
                                <span class="user-name"><?php echo isset($nombre_completo) ? $nombre_completo : ''; ?> <?php echo $this->session->userdata("nombre") ?></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="<?php echo site_url('usuarios/perfil'); ?>"><i class="ft-user"></i> Mi perfil</a>
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
                <?php if (es_superadministrador()) : ?>

                    <li class="nav-item"><a class="nav-link <?php echo isset($menu_inicio_activo) ? 'active' : ''; ?>" href="<?php echo site_url('inicio'); ?>"><i class="icon-home"></i><span>Inicio</span></a></li>

                    <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link <?php echo isset($menu_clientes_activo) ? 'active' : ''; ?>" href="#"><i class="ft-users"></i><span data-i18n="nav.dash.main">Clientes <i class="ft-chevron-down"></i></span></a>
                        <ul class="dropdown-menu">
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('clientes'); ?>" data-toggle="dropdown">Clientes</a></li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('clientes/suspendidos'); ?>" data-toggle="dropdown">Clientes suspendidos</a></li>
                        </ul>
                    </li>

                    <li class="nav-item"><a class="nav-link <?php echo isset($menu_sucursales_activo) ? 'active' : ''; ?>" href="<?php echo site_url('sucursales'); ?>"><i class="ft-map"></i><span>Sucursales</span></a></li>

                    <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link <?php echo isset($menu_disciplinas_activo) ? 'active' : ''; ?>" href="#" data-toggle="dropdown"><i class="icon-notebook"></i><span data-i18n="nav.dash.main">Disciplinas<i class="ft-chevron-down"></i></span></a>
                        <ul class="dropdown-menu">
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('disciplinas'); ?>" data-toggle="dropdown">Disciplinas</a></li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('planes_categorias'); ?>" data-toggle="dropdown">Planes - Categorias</a></li>
                        </ul>
                    </li>

                    <li class="nav-item"><a class="nav-link <?php echo isset($menu_planes_activo) ? 'active' : ''; ?>" href="<?php echo site_url('planes'); ?>"><i class="icon-trophy"></i><span>Planes</span></a></li>

                    <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link <?php echo isset($menu_historial_reservaciones_activo) ? 'active' : ''; ?> <?php echo isset($menu_reportes_clases_activo) ? 'active' : ''; ?> <?php echo isset($menu_asignaciones_activo) ? 'active' : ''; ?> <?php echo isset($menu_reservaciones_activo) ? 'active' : ''; ?> <?php echo isset($menu_clases_activo) ? 'active' : ''; ?> <?php echo isset($pagina_menu_reportes) ? 'active' : ''; ?>" href="#" data-toggle="dropdown"><i class="icon-notebook"></i><span data-i18n="nav.dash.main">Gestión <i class="ft-chevron-down"></i></span></a>
                        <ul class="dropdown-menu">
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('clases'); ?>" data-toggle="dropdown">Clases presenciales</a></li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('categorias'); ?>" data-toggle="dropdown">Disciplinas - Categorias</a></li>
                            <!-- <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('categorias'); ?>" data-toggle="dropdown">Planes - Categorias</a></li> -->
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('notificaciones'); ?>" data-toggle="dropdown">Notificaciones</a></li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('reservaciones'); ?>" data-toggle="dropdown">Reservaciones activas</a></li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('asignaciones'); ?>" data-toggle="dropdown">Planes de clientes</a></li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('asignaciones/control'); ?>" data-toggle="dropdown">Control de planes de clientes</a></li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('asignaciones/suscripciones'); ?>" data-toggle="dropdown">Suscripciones</a></li>
                            <li class="dropdown-divider"></li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('codigos'); ?>" data-toggle="dropdown">Códigos</a></li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('reportes/reporte_instructores'); ?>" data-toggle="dropdown">Reporte de instructores</a></li>
                            <li class="dropdown-divider"></li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('corporativos'); ?>" data-toggle="dropdown">Usuarios corporativos</a></li>
                            <li class="dropdown-divider"></li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('anuncios'); ?>" data-toggle="dropdown">Anuncios</a></li>
                            <li class="dropdown-divider"></li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('reportes_clases'); ?>" data-toggle="dropdown">Registro de clases presenciales</a></li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('historial_reservaciones'); ?>" data-toggle="dropdown">Registro de reservaciones</a></li>
                            <li class="dropdown-divider"></li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('reportes'); ?>" data-toggle="dropdown">Reportes</a></li>
                        </ul>
                    </li>

                    <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link <?php echo isset($menu_ventas_activo) ? 'active' : ''; ?> <?php echo isset($menu_reportes_ventas_activo) ? 'active' : ''; ?>" href="#" data-toggle="dropdown"><i class="icon-wallet"></i><span data-i18n="nav.dash.main">Ventas <i class="ft-chevron-down"></i></span></a>
                        <ul class="dropdown-menu">
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('ventas'); ?>" data-toggle="dropdown">Ventas</a></li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('ventas/frontdesk'); ?>" data-toggle="dropdown">Ventas del día</a></li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('ventas/suscripciones'); ?>" data-toggle="dropdown">Suscripciones</a></li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('reportes_ventas'); ?>" data-toggle="dropdown">Registros de ventas</a></li>
                        </ul>
                    </li>

                    <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link <?php echo isset($menu_instructores_activo) ? 'active' : ''; ?> <?php echo isset($menu_usuarios_activo) ? 'active' : ''; ?>" href="#" data-toggle="dropdown"><i class="icon-star"></i><span data-i18n="nav.dash.main">Sistema <i class="ft-chevron-down"></i></span></a>
                        <ul class="dropdown-menu">
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('configuraciones'); ?>" data-toggle="dropdown">Configuraciones</a></li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('instructores'); ?>" data-toggle="dropdown">Instructores</a></li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('usuarios'); ?>" data-toggle="dropdown">Administradores</a></li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if (es_administrador()) : ?>
                    <li class="nav-item"><a class="nav-link <?php echo isset($menu_inicio_activo) ? 'active' : ''; ?>" href="<?php echo site_url('inicio'); ?>"><i class="icon-home"></i><span>Inicio</span></a></li>
                    <li class="nav-item"><a class="nav-link <?php echo isset($menu_clientes_activo) ? 'active' : ''; ?>" href="<?php echo site_url('clientes'); ?>"><i class="icon-people"></i><span>Clientes</span></a></li>

                    <li class="nav-item"><a class="nav-link <?php echo isset($menu_sucursales_activo) ? 'active' : ''; ?>" href="<?php echo site_url('sucursales'); ?>"><i class="ft-map"></i><span>Sucursales</span></a></li>
                    <li class="nav-item"><a class="nav-link <?php echo isset($menu_disciplinas_activo) ? 'active' : ''; ?>" href="<?php echo site_url('disciplinas'); ?>"><i class="icon-grid"></i><span>Disciplinas</span></a></li>
                    <li class="nav-item"><a class="nav-link <?php echo isset($menu_planes_activo) ? 'active' : ''; ?>" href="<?php echo site_url('planes'); ?>"><i class="icon-trophy"></i><span>Planes</span></a></li>

                    <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link <?php echo isset($menu_historial_reservaciones_activo) ? 'active' : ''; ?> <?php echo isset($menu_reportes_clases_activo) ? 'active' : ''; ?> <?php echo isset($menu_asignaciones_activo) ? 'active' : ''; ?> <?php echo isset($menu_reservaciones_activo) ? 'active' : ''; ?> <?php echo isset($menu_clases_activo) ? 'active' : ''; ?> <?php echo isset($pagina_menu_reportes) ? 'active' : ''; ?>" href="#" data-toggle="dropdown"><i class="icon-notebook"></i><span data-i18n="nav.dash.main">Gestión <i class="ft-chevron-down"></i></span></a>
                        <ul class="dropdown-menu">
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('clases'); ?>" data-toggle="dropdown">Clases presenciales</a></li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('categorias'); ?>" data-toggle="dropdown">Disciplinas - Categorias</a></li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('notificaciones'); ?>" data-toggle="dropdown">Notificaciones</a></li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('reservaciones'); ?>" data-toggle="dropdown">Reservaciones activas</a></li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('asignaciones'); ?>" data-toggle="dropdown">Planes de clientes</a></li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('asignaciones/control'); ?>" data-toggle="dropdown">Control de planes de clientes</a></li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('asignaciones/suscripciones'); ?>" data-toggle="dropdown">Suscripciones</a></li>
                            <li class="dropdown-divider"></li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('codigos'); ?>" data-toggle="dropdown">Códigos</a></li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('reportes/reporte_instructores'); ?>" data-toggle="dropdown">Reporte de instructores</a></li>
                            <li class="dropdown-divider"></li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('corporativos'); ?>" data-toggle="dropdown">Usuarios corporativos</a></li>
                            <li class="dropdown-divider"></li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('anuncios'); ?>" data-toggle="dropdown">Anuncios</a></li>
                            <li class="dropdown-divider"></li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('reportes_clases'); ?>" data-toggle="dropdown">Registro de clases presenciales</a></li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('historial_reservaciones'); ?>" data-toggle="dropdown">Registro de reservaciones</a></li>
                            <li class="dropdown-divider"></li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('reportes'); ?>" data-toggle="dropdown">Reportes</a></li>
                        </ul>
                    </li>

                    <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link <?php echo isset($menu_ventas_activo) ? 'active' : ''; ?> <?php echo isset($menu_reportes_ventas_activo) ? 'active' : ''; ?>" href="#" data-toggle="dropdown"><i class="icon-wallet"></i><span data-i18n="nav.dash.main">Ventas <i class="ft-chevron-down"></i></span></a>
                        <ul class="dropdown-menu">
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('ventas'); ?>" data-toggle="dropdown">Ventas</a></li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('ventas/frontdesk'); ?>" data-toggle="dropdown">Ventas del día</a></li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('ventas/suscripciones'); ?>" data-toggle="dropdown">Suscripciones</a></li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('reportes_ventas'); ?>" data-toggle="dropdown">Registros de ventas</a></li>
                        </ul>
                    </li>

                    <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link <?php echo isset($menu_instructores_activo) ? 'active' : ''; ?> <?php echo isset($menu_usuarios_activo) ? 'active' : ''; ?>" href="#" data-toggle="dropdown"><i class="icon-star"></i><span data-i18n="nav.dash.main">Sistema <i class="ft-chevron-down"></i></span></a>
                        <ul class="dropdown-menu">
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('configuraciones'); ?>" data-toggle="dropdown">Configuraciones</a></li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('instructores'); ?>" data-toggle="dropdown">Instructores</a></li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('usuarios'); ?>" data-toggle="dropdown">Administradores</a></li>
                        </ul>
                    </li>
                    <!--
                            <li class="nav-item"><a class="nav-link <?php //echo isset($menu_inicio_activo) ? 'active' : ''; 
                                                                    ?>" href="<?php //echo site_url('inicio'); 
                                                                                                                                        ?>"><i class="icon-home"></i><span>Inicio</span></a></li>
                            <li class="nav-item"><a class="nav-link <?php //echo isset($menu_clientes_activo) ? 'active' : ''; 
                                                                    ?>" href="<?php //echo site_url('clientes'); 
                                                                                                                                            ?>"><i class="icon-people"></i><span>Clientes</span></a></li>
                            <li class="nav-item"><a class="nav-link <?php //echo isset($menu_clases_activo) ? 'active' : ''; 
                                                                    ?>" href="<?php //echo site_url('clases'); 
                                                                                                                                        ?>"><i class="icon-calendar"></i><span>Clases</span></a></li>
                            <li class="nav-item"><a class="nav-link <?php //echo isset($menu_reservaciones_activo) ? 'active' : ''; 
                                                                    ?>" href="<?php //echo site_url('reservaciones'); 
                                                                                                                                                ?>"><i class="icon-event"></i><span>Reservaciones</span></a></li>
                            <li class="nav-item"><a class="nav-link <?php //echo isset($menu_historial_reservaciones_activo) ? 'active' : ''; 
                                                                    ?>" href="<?php //echo site_url('historial_reservaciones'); 
                                                                                                                                                        ?>"><i class="icon-notebook"></i><span>Historial de reservaciones</span></a></li>
                            <li class="nav-item"><a class="nav-link <?php //echo isset($menu_asignaciones_activo) ? 'active' : ''; 
                                                                    ?>" href="<?php //echo site_url('asignaciones'); 
                                                                                                                                                ?>"><i class="icon-list"></i><span>Asignaciones</span></a></li>
                            <li class="nav-item"><a class="nav-link <?php //echo isset($menu_ventas_activo) ? 'active' : ''; 
                                                                    ?>" href="<?php //echo site_url('ventas'); 
                                                                                                                                        ?>"><i class="icon-wallet"></i><span>Ventas</span></a></li>
                        -->
                <?php endif; ?>

                <?php if (es_operaciones()) : ?>
                    <li class="nav-item"><a class="nav-link <?php echo isset($menu_inicio_activo) ? 'active' : ''; ?>" href="<?php echo site_url('inicio'); ?>"><i class="icon-home"></i><span>Inicio</span></a></li>
                    <li class="nav-item"><a class="nav-link <?php echo isset($menu_clientes_activo) ? 'active' : ''; ?>" href="<?php echo site_url('clientes'); ?>"><i class="icon-people"></i><span>Clientes</span></a></li>

                    <li class="nav-item"><a class="nav-link <?php echo isset($menu_sucursales_activo) ? 'active' : ''; ?>" href="<?php echo site_url('sucursales'); ?>"><i class="ft-map"></i><span>Sucursales</span></a></li>
                    <li class="nav-item"><a class="nav-link <?php echo isset($menu_disciplinas_activo) ? 'active' : ''; ?>" href="<?php echo site_url('disciplinas'); ?>"><i class="icon-grid"></i><span>Disciplinas</span></a></li>
                    <li class="nav-item"><a class="nav-link <?php echo isset($menu_planes_activo) ? 'active' : ''; ?>" href="<?php echo site_url('planes'); ?>"><i class="icon-trophy"></i><span>Planes</span></a></li>

                    <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link <?php echo isset($menu_historial_reservaciones_activo) ? 'active' : ''; ?> <?php echo isset($menu_reportes_clases_activo) ? 'active' : ''; ?> <?php echo isset($menu_asignaciones_activo) ? 'active' : ''; ?> <?php echo isset($menu_reservaciones_activo) ? 'active' : ''; ?> <?php echo isset($menu_clases_activo) ? 'active' : ''; ?> <?php echo isset($pagina_menu_reportes) ? 'active' : ''; ?>" href="#" data-toggle="dropdown"><i class="icon-notebook"></i><span data-i18n="nav.dash.main">Gestión <i class="ft-chevron-down"></i></span></a>
                        <ul class="dropdown-menu">
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('clases'); ?>" data-toggle="dropdown">Clases presenciales</a></li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('categorias'); ?>" data-toggle="dropdown">Disciplinas - Categorias</a></li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('clases/index_clases_en_linea'); ?>" data-toggle="dropdown">Clases en línea</a></li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('reservaciones'); ?>" data-toggle="dropdown">Reservaciones activas</a></li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('asignaciones'); ?>" data-toggle="dropdown">Planes de clientes</a></li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('asignaciones/control'); ?>" data-toggle="dropdown">Control de planes de clientes</a></li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('asignaciones/suscripciones'); ?>" data-toggle="dropdown">Suscripciones</a></li>
                            <li class="dropdown-divider"></li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('reportes/reporte_instructores'); ?>" data-toggle="dropdown">Reporte de instructores</a></li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('corporativos'); ?>" data-toggle="dropdown">Usuarios corporativos</a></li>
                            <li class="dropdown-divider"></li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('anuncios'); ?>" data-toggle="dropdown">Anuncios</a></li>
                            <li class="dropdown-divider"></li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('reportes_clases'); ?>" data-toggle="dropdown">Registro de clases presenciales</a></li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('historial_reservaciones'); ?>" data-toggle="dropdown">Registro de reservaciones</a></li>
                            <li class="dropdown-divider"></li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('reportes'); ?>" data-toggle="dropdown">Reportes</a></li>
                        </ul>
                    </li>

                    <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link <?php echo isset($menu_ventas_activo) ? 'active' : ''; ?> <?php echo isset($menu_reportes_ventas_activo) ? 'active' : ''; ?>" href="#" data-toggle="dropdown"><i class="icon-wallet"></i><span data-i18n="nav.dash.main">Ventas <i class="ft-chevron-down"></i></span></a>
                        <ul class="dropdown-menu">
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('ventas/frontdesk'); ?>" data-toggle="dropdown">Ventas del día</a></li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('ventas/suscripciones'); ?>" data-toggle="dropdown">Suscripciones</a></li>
                        </ul>
                    </li>

                    <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link <?php echo isset($menu_instructores_activo) ? 'active' : ''; ?> <?php echo isset($menu_usuarios_activo) ? 'active' : ''; ?>" href="#" data-toggle="dropdown"><i class="icon-star"></i><span data-i18n="nav.dash.main">Sistema <i class="ft-chevron-down"></i></span></a>
                        <ul class="dropdown-menu">
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('instructores'); ?>" data-toggle="dropdown">Instructores</a></li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if (es_frontdesk()) : ?>
                    <li class="nav-item"><a class="nav-link <?php echo isset($menu_inicio_activo) ? 'active' : ''; ?>" href="<?php echo site_url('inicio'); ?>"><i class="icon-home"></i><span>Inicio</span></a></li>
                    <li class="nav-item"><a class="nav-link <?php echo isset($menu_clientes_activo) ? 'active' : ''; ?>" href="<?php echo site_url('clientes'); ?>"><i class="icon-people"></i><span>Clientes</span></a></li>
                    <li class="nav-item"><a class="nav-link <?php echo isset($menu_clases_activo) ? 'active' : ''; ?>" href="<?php echo site_url('clases'); ?>"><i class="icon-calendar"></i><span>Clases</span></a></li>
                    <li class="nav-item"><a class="nav-link <?php echo isset($menu_reservaciones_activo) ? 'active' : ''; ?>" href="<?php echo site_url('reservaciones'); ?>"><i class="icon-event"></i><span>Reservaciones</span></a></li>
                    <li class="nav-item"><a class="nav-link <?php echo isset($menu_historial_reservaciones_activo) ? 'active' : ''; ?>" href="<?php echo site_url('historial_reservaciones'); ?>"><i class="icon-notebook"></i><span>Historial de reservaciones</span></a></li>
                    <li class="nav-item"><a class="nav-link <?php echo isset($menu_asignaciones_activo) ? 'active' : ''; ?>" href="<?php echo site_url('asignaciones'); ?>"><i class="icon-list"></i><span>Asignaciones</span></a></li>
                    <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link <?php echo isset($menu_ventas_activo) ? 'active' : ''; ?> <?php echo isset($menu_reportes_ventas_activo) ? 'active' : ''; ?>" href="#" data-toggle="dropdown"><i class="icon-wallet"></i><span data-i18n="nav.dash.main">Ventas <i class="ft-chevron-down"></i></span></a>
                        <ul class="dropdown-menu">
                            <?php if ($this->session->userdata('sucursal_asignada') == 2) : ?>
                                <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('ventas/frontdesk'); ?>" data-toggle="dropdown"><i class="icon-wallet"></i> Ventas FD</a></li>
                            <?php endif; ?>
                            <?php if ($this->session->userdata('sucursal_asignada') == 3) : ?>
                                <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('ventas/frontdesk'); ?>" data-toggle="dropdown"><i class="icon-wallet"></i> Ventas FD</a></li>
                            <?php endif; ?>
                            <?php if ($this->session->userdata('sucursal_asignada') == 5) : ?>
                                <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('ventas/frontdesk'); ?>" data-toggle="dropdown"><i class="icon-wallet"></i> Ventas FD</a></li>
                            <?php endif; ?>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo site_url('ventas'); ?>" data-toggle="dropdown"><i class="fa fa-history"></i> Ventas del mes</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>