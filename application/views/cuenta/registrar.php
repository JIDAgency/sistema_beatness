<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
  <head>
  	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<meta name="description" content="<?php echo description();?>">
	<meta name="keywords" content="<?php echo keywords();?>">
	<meta name="author" content="<?php echo author();?>">
	<title>Registrarse | <?php echo titulo(); ?></title>
	<link rel="apple-touch-icon" href="<?php echo base_url(); ?>almacenamiento/logos/open-graph.jpg">
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>almacenamiento/logos/logo.jpg">
	<!-- <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>app-assets/images/ico/favicon.ico"> -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Muli:300,400,500,700"
	 rel="stylesheet">
	<!-- INICIA VENDOR CSS-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/vendors.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/vendors/css/forms/icheck/icheck.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/vendors/css/forms/icheck/custom.css">
	<!-- TERMINA VENDOR CSS-->
	<!-- INICIA ROBUST CSS-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/app.css">
	<!-- TERMINA ROBUST CSS-->
	<!-- INICIA Page Level CSS-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/core/menu/menu-types/horizontal-menu.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/core/colors/palette-gradient.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/pages/login-register.css">
	<!-- TERMINA Page Level CSS-->
	<!-- INICIA Custom CSS-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style.css">
	<!-- TERMINA Custom CSS-->
	<?php if($this->config->item('recaptcha_activar','b3studio')): ?>
	<!-- INICIA reCAPTCJA -->
	<script src='https://www.google.com/recaptcha/api.js'></script>
	<!-- TERMINA reCAPTCJA -->
	<?php endif ?>
  </head>

  <body class="horizontal-layout horizontal-menu horizontal-menu-padding 1-column  bg-full-screen-image menu-expanded blank-page blank-page" data-open="hover" data-menu="horizontal-menu" data-col="1-column">
    <!-- ////////////////////////////////////////////////////////////////////////////-->
    <div class="app-content container center-layout mt-2">
      <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
			<section class="flexbox-container">
				<div class="col-12 d-flex align-items-center justify-content-center">
					<div class="col-md-4 col-10 box-shadow-2 p-0">

						<div class="card border-grey border-lighten-3 m-0">
						
							<br class="d-block d-sm-none">
							<br class="d-block d-sm-none">
							<br class="d-block d-sm-none">
							<br class="d-block d-sm-none">
							<br class="d-block d-sm-none">
							<br class="d-block d-sm-none">

							<div class="embed-responsive embed-responsive-item embed-responsive-16by9">
								<!--iframe class="gallery-thumbnail" src="https://player.vimeo.com/video/450211386?title=0&byline=0&autoplay=1" allowfullscreen frameborder="0" allow="autoplay; fullscreen"></iframe-->
							</div>

							<div class="card-content px-1 py-1 mt-3">

								<?php echo form_open('cuenta/registrar', array('id' =>'forma-registrar','class' => 'form-horizontal')); ?>

									<div class="card-title text-center">
									<img class="img-fluid" src="<?php echo base_url(); ?>almacenamiento/logos/logo.jpg" width="200" alt="branding logo">
									</div>

									<p class="card-subtitle line-on-side text-muted text-center font-small-3 mt-2 mx-2 my-1"><span>Registrate ahora</span></p>

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

									<div class="card-body">

										<fieldset class="form-group position-relative has-icon-left">
											<input autocomplete="tel" id="no_telefono" name="no_telefono" type="text" class="form-control" value="<?php echo set_value('no_telefono'); ?>" placeholder="No. de teléfono">
											<div class="form-control-position">
												<i class="ft-phone"></i>
											</div>
										</fieldset>

										<fieldset class="form-group position-relative has-icon-left">
											<input autocomplete="email" id="r_correo" name="correo" type="email" class="form-control" value="<?php echo set_value('correo'); ?>"
											placeholder="E-mail" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toLowerCase()">
											<div class="form-control-position">
												<i class="ft-mail"></i>
											</div>
										</fieldset>

										<fieldset class="form-group position-relative has-icon-left">
											<input autocomplete="new-password" id="r_contrasena" name="contrasena" type="password" class="form-control"
											placeholder="Contraseña">
											<div class="form-control-position">
												<i class="fa fa-key"></i>
											</div>
										</fieldset>

										<fieldset class="form-group position-relative has-icon-left">
											<input autocomplete="nombre_completo" id="r_nombre_completo" name="nombre_completo" type="text" class="form-control"
											value="<?php echo set_value('nombre_completo'); ?>" placeholder="Nombre">
											<div class="form-control-position">
												<i class="ft-user"></i>
											</div>
										</fieldset>

										<fieldset class="form-group position-relative has-icon-left">
											<input autocomplete="apellido_paterno" id="r_apellido_paterno" name="apellido_paterno" type="text" class="form-control"
											value="<?php echo set_value('apellido_paterno'); ?>" placeholder="Apellido paterno">
											<div class="form-control-position">
												<i class="ft-user"></i>
											</div>
										</fieldset>

										<fieldset class="form-group position-relative has-icon-left">
											<input autocomplete="apellido_materno" id="r_apellido_materno" name="apellido_materno" type="text" class="form-control"
											value="<?php echo set_value('apellido_materno'); ?>" placeholder="Apellido materno">
											<div class="form-control-position">
												<i class="ft-user"></i>
											</div>
										</fieldset>

										<fieldset class="form-group position-relative has-icon-left">
											<input type="date" id="r_fecha_nacimiento" name="fecha_nacimiento" class="form-control" id="date" value="<?php echo set_value('fecha_nacimiento') == false ? date('Y-m-d') : date('Y-m-d', strtotime(set_value('fecha_nacimiento'))); ?>">
											<div class="form-control-position">
												<i class="fa fa-birthday-cake"></i>
											</div>
										</fieldset>

										<fieldset class="form-group position-relative has-icon-left">
											<select id="genero" name="genero" class="form-control">
												<option value="">Seleccione el género con el que se identifica…</option>
												<option value="M" <?php echo set_select('genero', 'M'); ?>>Mujer</option>
												<option value="H" <?php echo set_select('genero', 'H'); ?>>Hombre</option>
											</select>
											<div class="form-control-position">
												<i class="ft-users"></i>
											</div>
										</fieldset>
														
										<style>
										.g-recaptcha {
											transform:scale(0.77);
											transform-origin:0 0;
										}
										</style>
										
										<fieldset class="form-group">
											<?php if($this->config->item('recaptcha_activar','b3studio')): ?>
												<div class="justify-content-center mb-1">
													<div class="g-recaptcha" data-sitekey="6LdhKWokAAAAAD1R8HF1yEt5wBOFU48pj3BVlUEP" data-callback="captchaExitoso"
													data-expired-callback="captchaExpirado" data-error-callback="captchaFallido"></div>
												</div>
											<?php endif ?>
										</fieldset>

										<div class="form-group row">
											<div class="col-md-12 col-12 text-center font-small-3">
												<a href="<?php echo site_url('cuenta/olvido_contrasena') ?>" class="card-link">¿Olvidó su contraseña?</a>
											</div>
										</div>

										<button id="btn-registrar" <?php echo $this->config->item('recaptcha_activar','b3studio')? 'disabled': ''; ?> type="submit" class="btn btn-cyan btn-accent-2 border-cyan border-accent-2 black square btn-min-width btn-block btn-glow text-center text-uppercase"><strong><em><i class="ft-unlock"></i> Registrarme</em></strong></button>
										<!--button type="submit" class="btn btn-outline-info btn-block"><i class="ft-unlock"></i> Registrarse</button-->
										<p class="card-subtitle line-on-side text-muted text-center font-small-3 mb-2 mt-2 mx-2 my-1">
											<span>¿Ya eres parte?</span>
										</p>
										
										<a href="<?php echo site_url('cuenta/iniciar_sesion') ?>" class="btn btn-secondary border-secondary square btn-min-width btn-block btn-glow text-center text-uppercase"><strong><em><i class="ft-user"></i> Inicia sesión</em></strong></a>
									
									</div>

								<?php echo form_close(); ?>

							</div>

						</div>
					</div>
				</div>
			</section>
        </div>
      </div>
    </div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->

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
	<script src="<?php echo base_url(); ?>assets/js/cuenta/registrar.js" type="text/javascript"></script>
	<!-- TERMINA PAGE LEVEL JS-->
  </body>
</html>
