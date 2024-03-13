<!DOCTYPE html>
<html class="loading" lang="es" data-textdirection="ltr">

<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
	
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<meta name="description" content="<?php echo description();?>">
	<meta name="keywords" content="<?php echo keywords();?>">
	<meta name="author" content="<?php echo author();?>">
	<meta name="facebook-domain-verification" content="hmo3j2doq28l4psfujdxqkw4g3b0uc" />

	<title><?php echo isset($pagina_titulo) ? $pagina_titulo : ''; ?> | <?php echo titulo(); ?></title>
	<link rel="apple-touch-icon" href="https://Beatness.mx/almacenamiento/logos/open-graph.jpg">
	<!-- <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>app-assets/images/ico/favicon.ico"> -->
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>almacenamiento/logos/logo.jpg">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Muli:300,400,500,700"
	 rel="stylesheet">
	<!-- INICIA VENDOR CSS-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/vendors.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/vendors/css/ui/prism.min.css">
	<!-- TERMINA VENDOR CSS-->
	<!-- INICIA ROBUST CSS-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/app.css">
	<!-- TERMINA ROBUST CSS-->
	<!-- INICIA Page Level CSS-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/core/menu/menu-types/horizontal-menu.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/core/colors/palette-gradient.css">

	<?php if (isset($styles) && is_array($styles)): ?>
	<?php foreach ($styles as $style): ?>
		<link rel="stylesheet" type="text/css" href="<?php echo !$style['es_rel'] ? $style['href'] : base_url() . 'assets/css/' . $style['href']; ?>">
    <?php endforeach;?>
    <?php endif;?>

	<!-- TERMINA Page Level CSS-->

	<!-- INICIA Custom CSS-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style.css">
	<!-- TERMINA Custom CSS-->

	<!-- Meta Pixel Code -->
	<script>
		!function(f,b,e,v,n,t,s)
		{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
		n.callMethod.apply(n,arguments):n.queue.push(arguments)};
		if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
		n.queue=[];t=b.createElement(e);t.async=!0;
		t.src=v;s=b.getElementsByTagName(e)[0];
		s.parentNode.insertBefore(t,s)}(window, document,'script',
		'https://connect.facebook.net/en_US/fbevents.js');
		fbq('init', '1230227784598664');
		fbq('track', 'PageView');
		</script>
		<noscript><img height="1" width="1" style="display:none"
		src="https://www.facebook.com/tr?id=1230227784598664&ev=PageView&noscript=1"
		/></noscript>
	<!-- End Meta Pixel Code -->
    
</head>

<body class="horizontal-layout horizontal-menu horizontal-menu-padding 2-columns   menu-expanded" data-open="hover" data-menu="horizontal-menu" data-col="2-columns">
	<!-- fixed-top-->
	<nav class="header-navbar navbar-expand-sm navbar navbar-with-menu navbar-dark navbar-border">
		<div class="navbar-wrapper">
			<div class="navbar-header">
				<ul class="nav navbar-nav mr-auto">
					<li class="nav-item mobile-menu d-md-none float-left">
						<button class="nav-link menu-toggle hamburger hamburger--arrow js-hamburger is-active"><span class="hamburger-box"></span><span
							 class="hamburger-inner"></span></button>
					</li>
					<li class="nav-item">
						<a href="index.html" class="navbar-brand nav-link"><img src="<?php echo base_url(); ?>almacenamiento/logos/logo-light.png"></a>
					</li>
					<li class="nav-item d-md-none float-right"><a data-toggle="collapse" data-target="#navbar-mobile" class="nav-link open-navbar-container collapsed"
						 aria-expanded="false"><i class="ft-ellipsis-h pe-2x icon-rotate-right"></i></a></li>
				</ul>
			</div>
			<div class="navbar-container content">
				<div id="navbar-mobile" class="collapse navbar-collapse">
					<ul class="nav navbar-nav mr-auto float-right"></ul>
					<ul class="nav navbar-nav float-left">
						<li class="dropdown dropdown-user nav-item">
							<a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
								<span class="avatar avatar-online">
									<img id="img-avatar-header" src="<?php echo base_url(); ?>/subidas/perfil/<?php echo $this->session->userdata['nombre_imagen_avatar']; ?>" alt="avatar"><i></i></span>
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
	<!--/ fixed-top-->
	<div class="header-navbar navbar-expand-sm navbar navbar-horizontal navbar-fixed navbar-dark navbar-without-dd-arrow navbar-shadow"
	 role="navigation" data-menu="menu-wrapper">
		<div class="navbar-container main-menu-content container center-layout" data-menu="menu-container">
			<ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">
				<li class="nav-item"><a class="nav-link <?php echo isset($menu_inicio_activo) ? 'active' : ''; ?>" href="<?php echo site_url('inicio/index'); ?>">Inicio</a></li>
				<li class="nav-item"><a class="nav-link <?php echo isset($menu_clientes_activo) ? 'active' : ''; ?>" href="<?php echo site_url('clientes/index'); ?>">Clientes</a></li>
				<li class="nav-item"><a class="nav-link <?php echo isset($menu_instructores_activo) ? 'active' : ''; ?>" href="<?php echo site_url('instructores/index'); ?>">Instructores</a></li>
				<li class="nav-item"><a class="nav-link <?php echo isset($menu_disciplinas_activo) ? 'active' : ''; ?>" href="<?php echo site_url('disciplinas/index'); ?>">Disciplinas</a></li>
				<li class="nav-item"><a class="nav-link <?php echo isset($menu_planes_activo) ? 'active' : ''; ?>" href="<?php echo site_url('planes/index'); ?>">Planes</a></li>
				<li class="nav-item"><a class="nav-link <?php echo isset($menu_clases_activo) ? 'active' : ''; ?>" href="<?php echo site_url('clases/index'); ?>">Clases</a></li>
				<li class="nav-item"><a class="nav-link <?php echo isset($menu_reservaciones_activo) ? 'active' : ''; ?>" href="<?php echo site_url('reservaciones/index'); ?>">Reservaciones</a></li>
				<!--<li class="nav-item"><a class="nav-link <?php echo isset($menu_membresias_activo) ? 'active' : ''; ?>" href="<?php echo site_url('membresias/index'); ?>">Membresías</a></li>-->
				<?php if (es_superadministrador()): ?>
					<li class="nav-item"><a class="nav-link <?php echo isset($menu_usuarios_activo) ? 'active' : ''; ?>" href="<?php echo site_url('usuarios/index'); ?>">Administradores</a></li>
				<?php endif;?>
				<li class="nav-item"><a class="nav-link <?php echo isset($menu_ventas_activo) ? 'active' : ''; ?>" href="<?php echo site_url('ventas/index'); ?>">Ventas</a></li>
			</ul>
		</div>
	</div>
	
    <?php 
        if (es_cliente()){
            redirect('usuario/inicio');
        } 
    ?>
