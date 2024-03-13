<!DOCTYPE html>
<html class="loading" lang="es" data-textdirection="ltr">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gb18030">    
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<meta name="description" content="<?php echo description();?>">
	<meta name="keywords" content="<?php echo keywords();?>">
	<meta name="author" content="<?php echo author();?>">
	<title><?php echo isset($pagina_titulo) ? $pagina_titulo : ''; ?> | <?php echo titulo(); ?></title>
	<link rel="apple-touch-icon" href="<?php echo base_url(); ?>almacenamiento/logos/open-graph.jpg">
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>almacenamiento/logos/logo.jpg">
	<!-- <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>app-assets/images/ico/favicon.ico"> -->
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
	<!-- Facebook Pixel Code -->
</head>

<body class="b3-ux-v2" data-open="hover" data-menu="horizontal-menu" data-col="2-columns">

	<!--/ fixed-top-->

	<div class="container menu-principal d-none d-xl-block d-xl-block d-lg-none d-md-none d-lg-block d-sm-none d-md-block">
		<div class="row">
			<div class="col-2"><img src="<?php echo base_url(); ?>almacenamiento/logos/logo.jpg" width="100"></div>
				<div class="col-10">
					<ul class="list-inline pull-right d-none d-sm-none d-md-block d-lg-block">
						<li class="nav-item"><a class="nav-link <?php echo isset($menu_usuario_inicio_activo) ? 'nav-active' : ''; ?>" href="<?php echo site_url('usuario/inicio'); ?>">Inicio</a></li>
						<li class="nav-item"><a class="nav-link"  href="<?php echo site_url('cuenta/cerrar_sesion'); ?>">Cerrar sesion</a></li>
					</ul>
				</div>
			</div>
		</div>
	<div>
		
	<section class="seccion-boton  d-block d-sm-none d-none d-sm-block d-md-none">

		<div class="container">

			<div class="row">

				<div class="col-6">
					<a href="<?php echo site_url("inicio"); ?>"><img src="<?php echo base_url(); ?>almacenamiento/logos/logo.jpg" width="100"></a>
				</div>

				<div class="col-6 m-t-20">
					<a href="#" data-toggle="modal" data-target="#exampleModal"><img src="<?php echo base_url(); ?>assets/img/graficos/menu-movil.png" class="float-right" width="40"></strong></a>
				</div>

			</div>

		</div>

	</section>
	 <!-- Modal -->
	<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content-2">
		
				<div class="row">
					<div class="col">
						<ul class="navbar-light menu-movil mt-5">

						<img src="<?php echo base_url(); ?>almacenamiento/logos/logo.jpg" class="mb-5" width="100">

							<li class="nav-item">
								<a class="nav-link <?php echo isset($menu_usuario_inicio_activo) ? 'nav-active' : ''; ?>" href="<?php echo site_url('usuario/inicio'); ?>">Inicio</a>
							</li>

							<li class="nav-item">
								<a class="nav-link"  href="<?php echo site_url('cuenta/cerrar_sesion'); ?>">Cerrar sesion</a>
							</li>

							</br>

							<li><a href="#" class="btn btn-light square btn-min-width mr-1 mb-1" data-dismiss="modal" aria-label="Close"><strong>Cerrar</strong></a></li>
						
						</ul>
					</div>
				</div>
	
			</div>
		</div>
	</div>

	
</div>
