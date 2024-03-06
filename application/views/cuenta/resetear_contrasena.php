<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<meta name="description" content="<?php echo description(); ?>">
	<meta name="keywords" content="<?php echo keywords(); ?>">
	<meta name="author" content="<?php echo author(); ?>">
	<title>Resetear contraseña | <?php echo titulo(); ?></title>
	<link rel="apple-touch-icon" href="<?php echo base_url(); ?>app-assets/images/ico/apple-icon-120.png">
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>app-assets/images/ico/favicon.ico">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Muli:300,400,500,700" rel="stylesheet">
	<!-- INICIA VENDOR CSS-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/vendors.css">
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

<body class="horizontal-layout horizontal-menu horizontal-menu-padding 1-column menu-expanded blank-page blank-page bg-full-screen-image" data-open="hover" data-menu="horizontal-menu" data-col="1-column">
	<!-- ////////////////////////////////////////////////////////////////////////////-->
	<div class="app-content container center-layout mt-2">
		<div class="content-wrapper">
			<div class="content-header row">
			</div>
			<div class="content-body">
				<section class="flexbox-container">
					<div class="col-12 d-flex align-items-center justify-content-center">
						<div class="col-md-4 col-10 box-shadow-2 p-0">
							<div class="card border-grey border-lighten-3 px-2 py-2 m-0">
								<div class="card-header border-0 pb-0">
									<?php $this->load->view('_comun/mensajes_alerta'); ?>
									<?php if (validation_errors()) : ?>
										<div class="alert bg-danger alert-icon-left alert-dismissible mb-2 font-small-3" role="alert">
											<span class="alert-icon"><i class="fa fa-thumbs-o-down"></i></span>
											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
												<span aria-hidden="true">×</span>
											</button>
											<?php echo validation_errors(); ?>
										</div>
									<?php endif ?>
									<div class="card-title text-center">
										<img src="<?php echo base_url(); ?>almacenamiento/logos/logo.png" class="img-fluid" alt="branding logo">
									</div>
									<h6 class="card-subtitle text-muted line-on-side text-center font-small-3 pt-2">
										<span>Escriba su nueva contraseña</span>
									</h6>
								</div>
								<div class="card-content">
									<div class="card-body">
										<?php echo form_open('cuenta/resetear_contrasena/' . $codigo, array('id' => 'forma-resetear-contrasena', 'class' => 'form-horizontal')); ?>
										<input type="hidden" name="usuario_id" value="<?php echo $usuario_id; ?>">
										<fieldset class="form-group position-relative has-icon-left">
											<input name="contrasena_nueva" type="password" class="form-control" placeholder="Contraseña">
											<div class="form-control-position">
												<i class="fa fa-key"></i>
											</div>
										</fieldset>
										<fieldset class="form-group position-relative has-icon-left">
											<input name="confirmar_contrasena_nueva" type="password" class="form-control" placeholder="Confirme la contraseña">
											<div class="form-control-position">
												<i class="fa fa-key"></i>
											</div>
										</fieldset>
										<button type="submit" class="btn btn-outline-info btn-lg btn-block"><i class="ft-unlock"></i> Resetar
											contraseña</button>
										<?php echo form_close(); ?>
									</div>
								</div>
								<div class="card-footer border-0 font-small-3">
									<p class="float-sm-left text-center"><a href="<?php echo site_url('cuenta/iniciar_sesion'); ?>" class="card-link">Iniciar
											sesión</a></p>
									<p class="float-sm-right text-center text-muted">¿Es nuevo? <a href="<?php echo site_url('cuenta/registrar'); ?>" class="card-link">Cree
											una cuenta</a></p>
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
	</div>
	<!-- Start of  Zendesk Widget script -->
	<script id="ze-snippet" src="https://static.zdassets.com/ekr/snippet.js?key=e7795812-20a6-49e7-b081-14f1efaade65"> </script>
	<!-- End of  Zendesk Widget script -->
	<!-- ////////////////////////////////////////////////////////////////////////////-->
	<!-- INICIA VENDOR JS-->
	<script src="<?php echo base_url(); ?>app-assets/vendors/js/vendors.min.js" type="text/javascript"></script>
	<!-- INICIA VENDOR JS-->
	<!-- INICIA PAGE VENDOR JS-->
	<script type="text/javascript" src="<?php echo base_url(); ?>app-assets/vendors/js/ui/jquery.sticky.js"></script>
	<script src="<?php echo base_url(); ?>app-assets/vendors/js/forms/validation/jqBootstrapValidation.js" type="text/javascript"></script>
	<!-- TERMINA PAGE VENDOR JS-->
	<!-- INICIA ROBUST JS-->
	<script src="<?php echo base_url(); ?>app-assets/js/core/app-menu.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>app-assets/js/core/app.js" type="text/javascript"></script>
	<!-- TERMINA ROBUST JS-->
	<!-- INICIA PAGE LEVEL JS-->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/cuenta/olvido_contrasena.js" type="text/javascript"></script>
	<!-- TERMINA PAGE LEVEL JS-->
</body>

</html>