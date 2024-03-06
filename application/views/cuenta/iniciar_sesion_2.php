<!DOCTYPE html>
<html class="loading" lang="es" data-textdirection="ltr">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<meta name="description" content="<?php echo description();?>">
	<meta name="keywords" content="<?php echo keywords();?>">
	<meta name="author" content="<?php echo author();?>">
	<title>Iniciar Sesión | <?php echo titulo(); ?></title>
	<link rel="apple-touch-icon" href="<?php echo base_url(); ?>app-assets/images/ico/apple-icon-120.png">
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>app-assets/images/ico/favicon.ico">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Muli:300,400,500,700"
	 rel="stylesheet">
	<!-- BEGIN VENDOR CSS-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/vendors.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/vendors/css/forms/icheck/icheck.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/vendors/css/forms/icheck/custom.css">
	<!-- END VENDOR CSS-->
	<!-- BEGIN ROBUST CSS-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/app.css">
	<!-- END ROBUST CSS-->
	<!-- BEGIN Page Level CSS-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/core/menu/menu-types/horizontal-menu.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/core/colors/palette-gradient.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/pages/login-register.css">
	<!-- END Page Level CSS-->
	<!-- BEGIN Custom CSS-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style.css">
	<!-- END Custom CSS-->
</head>

<body class="horizontal-layout horizontal-menu horizontal-menu-padding 1-column  bg-full-screen-image menu-expanded blank-page blank-page"
 data-open="hover" data-menu="horizontal-menu" data-col="1-column">

	<div class="app-content container center-layout mt-2">
		<div class="content-wrapper">
			<div class="content-header row">
			</div>
			<div class="content-body">
				<section class="flexbox-container">
					<div class="col-12 d-flex align-items-center justify-content-center">
						<div class="col-md-4 col-10 box-shadow-2 p-0">
							<div class="card border-grey border-lighten-3 px-1 py-1 m-0">
								<div class="card-header border-0">
									<?php $this->load->view('_comun/mensajes_alerta');?>
									<?php if (validation_errors()): ?>
									<div class="alert bg-danger alert-icon-left alert-dismissible mb-2 font-small-3" role="alert">
										<span class="alert-icon"><i class="fa fa-thumbs-o-down"></i></span>
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">×</span>
										</button>
										<?php echo validation_errors(); ?>
									</div>
									<?php endif?>
									<div class="card-title text-center">
										<img class="img-fluid" src="<?php echo base_url(); ?>almacenamiento/logos/logo.png" width="200" alt="branding logo">
									</div>
									<h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2">
										<span>Ingresar</span>
									</h6>
								</div>
								<div class="card-content">
									<!--div class="text-center">
										<a href="<?php //echo $this->facebook->login_url(); ?>" class="btn btn-social width-200 mr-1 mb-1 btn-facebook">
											<span class="fa fa-facebook"></span>Ingresa con facebook</a>
									</div>
									<p class="card-subtitle line-on-side text-muted text-center font-small-3 mx-2 my-1">
										<span>O usando su cuenta</span>
									</p-->
									<div class="card-body">
										<?php echo form_open('cuenta/iniciar_sesion', array('id' => 'forma-iniciar-sesion', 'class' => 'form-horizontal')); ?>
										<fieldset class="form-group position-relative has-icon-left">
											<input autocomplete="email" id="r_correo" name="correo" type="email" class="form-control" value="<?php echo set_value('correo'); ?>" placeholder="e-mail" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toLowerCase()">
											<div class="form-control-position">
												<i class="ft-mail"></i>
											</div>
										</fieldset>
										<fieldset class="form-group position-relative has-icon-left">
											<input autocomplete="current-password" id="is_contrasena" name="contrasena" type="password" class="form-control"
											 placeholder="Contraseña">
											<div class="form-control-position">
												<i class="fa fa-key"></i>
											</div>
										</fieldset>
										<div class="form-group row">
											<div class="col-md-12 col-12 text-center font-small-3">
												<a href="<?php echo site_url('cuenta/olvido_contrasena') ?>" class="card-link">¿Olvidó su contraseña?</a>
											</div>
										</div>
										<button type="submit" class="btn btn-cyan btn-accent-2 border-cyan border-accent-2 black square btn-min-width btn-block btn-glow text-center text-uppercase"><strong><em><i class="ft-unlock"></i> Iniciar Sesión</em></strong></button>
										<?php echo form_close(); ?>
									</div>
									<p class="card-subtitle line-on-side text-muted text-center font-small-3 mx-2 my-1">
										<span>¿Primera vez?</span>
									</p>
									<div class="card-body">
										<a href="<?php echo site_url('cuenta/registrar') ?>" class="btn btn-secondary border-secondary square btn-min-width btn-block btn-glow text-center text-uppercase"><strong><em><i class="ft-user"></i> Registrate</em></strong></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
	</div>

	<!-- INICIA VENDOR JS-->
	<script src="<?php echo base_url(); ?>app-assets/vendors/js/vendors.min.js" type="text/javascript"></script>
	<!-- TERMINA VENDOR JS-->
	<!-- INICIA PAGE VENDOR JS-->
	<script type="text/javascript" src="<?php echo base_url(); ?>app-assets/vendors/js/ui/jquery.sticky.js"></script>
	<script src="<?php echo base_url(); ?>app-assets/vendors/js/forms/validation/jqBootstrapValidation.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>app-assets/vendors/js/forms/icheck/icheck.min.js" type="text/javascript"></script>
	<!-- TERMINA PAGE VENDOR JS-->
	<!-- INICIA ROBUST JS-->
	<script src="<?php echo base_url(); ?>app-assets/js/core/app-menu.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>app-assets/js/core/app.js" type="text/javascript"></script>
	<!-- TERMINA ROBUST JS-->
	<!-- INICIA PAGE LEVEL JS-->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/cuenta/iniciar_sesion.js" type="text/javascript"></script>
	<!-- TERMINA PAGE LEVEL JS-->
</body>

</html>
