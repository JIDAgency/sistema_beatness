<!DOCTYPE html>
<html class="loading" lang="es" data-textdirection="ltr">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<meta name="description" content="<?php echo description();?>">
	<meta name="keywords" content="<?php echo keywords();?>">
	<meta name="author" content="<?php echo author();?>">
		<title><?php echo $pagina_titulo; ?> | <?php echo titulo(); ?></title>
		<link rel="apple-touch-icon" href="<?php echo base_url(); ?>app-assets/images/ico/apple-icon-120.png">
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
		<!-- TERMINA Page Level CSS-->
		<!-- INICIA Custom CSS-->
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style.css">
		<!-- TERMINA Custom CSS-->
</head>

<body class="horizontal-layout horizontal-menu horizontal-menu-padding 2-columns   menu-expanded" data-open="hover"
 data-menu="horizontal-menu" data-col="2-columns">
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
					<ul class="nav navbar-nav mr-auto">
						<li class="nav-item"><a class="nav-link active" href="#">Active</a></li>
					</ul>
					<ul class="nav navbar-nav">
						<li class="nav-item"><a class="nav-link" href="#">Link</a></li>
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
				<li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>html/ltr/horizontal-menu-template/index.html"><i
						 class="icon-home"></i><span data-i18n="nav.dash.main">Dashboard</span></a></li>
				<li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i
						 class="icon-bulb"></i><span data-i18n="nav.starter_kit.main">Starter kit</span></a>
					<ul class="dropdown-menu">
						<li data-menu=""><a class="dropdown-item" href="horizontal-layout-1-column.html" data-toggle="dropdown">1 column</a>
						</li>
						<li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#"
							 data-toggle="dropdown">Content Det. Sidebar</a>
							<ul class="dropdown-menu">
								<li data-menu=""><a class="dropdown-item" href="layout-content-detached-left-sidebar.html" data-toggle="dropdown">Detached
										left sidebar</a>
								</li>
								<li data-menu=""><a class="dropdown-item" href="layout-content-detached-left-sticky-sidebar.html" data-toggle="dropdown">Detached
										sticky left sidebar</a>
								</li>
								<li data-menu=""><a class="dropdown-item" href="layout-content-detached-right-sidebar.html" data-toggle="dropdown">Detached
										right sidebar</a>
								</li>
								<li data-menu=""><a class="dropdown-item" href="layout-content-detached-right-sticky-sidebar.html" data-toggle="dropdown">Detached
										sticky right sidebar</a>
								</li>
							</ul>
						</li>
						<li class="dropdown-divider"></li>
						<li data-menu=""><a class="dropdown-item" href="layout-fixed-navigation.html" data-toggle="dropdown">Fixed
								navigation</a>
						</li>
						<li class="dropdown-divider"></li>
						<li data-menu=""><a class="dropdown-item" href="layout-fixed.html" data-toggle="dropdown">Fixed layout</a>
						</li>
						<li data-menu=""><a class="dropdown-item" href="layout-boxed.html" data-toggle="dropdown">Boxed layout</a>
						</li>
						<li data-menu=""><a class="dropdown-item" href="layout-static.html" data-toggle="dropdown">Static layout</a>
						</li>
						<li class="dropdown-divider"></li>
						<li data-menu=""><a class="dropdown-item" href="layout-light.html" data-toggle="dropdown">Light layout</a>
						</li>
						<li data-menu=""><a class="dropdown-item" href="layout-dark.html" data-toggle="dropdown">Dark layout</a>
						</li>
					</ul>
				</li>
				<li class="nav-item"><a class="nav-link" href="changelog.html"><i class="icon-docs"></i><span data-i18n="nav.changelog.main">Changelog</span></a></li>
				<li class="nav-item"><a class="nav-link" href="https://pixinvent.ticksy.com/"><i class="icon-support"></i><span>Raise
							Support</span></a></li>
				<li class="nav-item"><a class="nav-link" href="https://pixinvent.com/bootstrap-admin-template/robust/documentation"><i
						 class="icon-notebook"></i><span>Documentation</span></a></li>
			</ul>
		</div>
	</div>

	<div class="app-content container center-layout mt-2">
		<div class="content-wrapper">
			<div class="content-body">
			</div>
		</div>
	</div>

	<footer class="footer footer-static footer-light navbar-shadow">
		<p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2 container center-layout">
			<span class="float-md-left d-block d-md-inline-block">Copyright &copy; <?php echo date("Y")." ".branding(); ?> | Todos los derechos
				reservados</span>
		</p>
	</footer>
	<!-- INICIA VENDOR JS-->
	<script src="<?php echo base_url(); ?>app-assets/vendors/js/vendors.min.js" type="text/javascript"></script>
	<!-- TERMINA VENDOR JS-->
	<!-- INICIA PAGE VENDOR JS-->
	<script type="text/javascript" src="<?php echo base_url(); ?>app-assets/vendors/js/ui/jquery.sticky.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>app-assets/vendors/js/ui/prism.min.js"></script>
	<!-- TERMINA PAGE VENDOR JS-->
	<!-- INICIA ROBUST JS-->
	<script src="<?php echo base_url(); ?>app-assets/js/core/app-menu.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>app-assets/js/core/app.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>app-assets/js/scripts/customizer.js" type="text/javascript"></script>
	<!-- TERMINA ROBUST JS-->
	<!-- BEGIN PAGE LEVEL JS-->
	<!-- END PAGE LEVEL JS-->
</body>

</html>
