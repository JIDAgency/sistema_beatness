<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Vendor styles -->
	<link rel="stylesheet"
		  href="<?php echo base_url(); ?>assets/vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendors/bower_components/animate.css/animate.min.css">

	<!-- App styles -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/app.min.css">
</head>

<body data-ma-theme="green">
<div class="m-5">
	<?php echo validation_errors('<p class="text-danger text-center m-0">', '</p>'); ?>
</div>

<div class="login">

	<!-- Inicio de sesión -->
	<div class="login__block  <?php echo $vista == 'iniciar_sesion' ? 'active' : ''; ?>" id="l-login">
		<div class="login__block__header">
			<i class="zmdi zmdi-account-circle"></i>
			Hola, por favor inicia sesión

			<div class="actions actions--inverse login__block__actions">
				<div class="dropdown">
					<i data-toggle="dropdown" class="zmdi zmdi-more-vert actions__item"></i>

					<div class="dropdown-menu dropdown-menu-right">
						<a class="dropdown-item" data-ma-action="login-switch" data-ma-target="#l-register" href="">Crear una nueva cuenta</a>
						<a class="dropdown-item" data-ma-action="login-switch" data-ma-target="#l-forget-password" href="">¿Olvidaste tu contraseña?</a>
					</div>
				</div>
			</div>
		</div>

		<div class="login__block__body">
			<?php echo form_open('cuenta/iniciar_sesion'); ?>
			<div class="form-group form-group--float form-group--centered">
				<input autocomplete="username" id="is_nombre_usuario" name="nombre_usuario" type="text"
					   class="form-control">
				<label for="is_nombre_usuario">Usuario</label>
				<i class="form-group__bar"></i>
			</div>

			<div class="form-group form-group--float form-group--centered">
				<input autocomplete="current-password" id="is_contrasena" name="contrasena" type="password"
					   class="form-control">
				<label for="is_contrasena">Contraseña</label>
				<i class="form-group__bar"></i>
			</div>

			<button type="submit" class="btn btn--icon login__block__btn"><i class="zmdi zmdi-long-arrow-right"></i>
			</button>
			<a href="<?php echo $this->facebook->login_url(); ?>">Login</a>
			<?php echo form_close(); ?>
		</div>
	</div>

	<!-- Registro -->
	<div class="login__block <?php echo $vista == 'registrar' ? 'active' : ''; ?>" id="l-register">
		<div class="login__block__header palette-Blue bg">
			<i class="zmdi zmdi-account-circle"></i>
			Crea una cuenta nueva

			<div class="actions actions--inverse login__block__actions">
				<div class="dropdown">
					<i data-toggle="dropdown" class="zmdi zmdi-more-vert actions__item"></i>

					<div class="dropdown-menu dropdown-menu-right">
						<a class="dropdown-item" data-ma-action="login-switch" data-ma-target="#l-login" href="">¿Ya
							estás registrado?</a>
						<a class="dropdown-item" data-ma-action="login-switch" data-ma-target="#l-forget-password"
						   href="">¿Olvidaste tu contraseña?</a>
					</div>
				</div>
			</div>
		</div>

		<div class="login__block__body">
			<?php echo form_open('cuenta/registrar'); ?>
			<div class="form-group form-group--float form-group--centered">
				<input autocomplete="username" id="r_nombre_usuario" name="nombre_usuario" type="text"
					   class="form-control" value="<?php echo set_value('nombre_usuario'); ?>">
				<label for="r_nombre_usuario">Usuario</label>
				<i class="form-group__bar"></i>
			</div>

			<div class="form-group form-group--float form-group--centered">
				<input autocomplete="email" id="r_correo" name="correo" type="email" class="form-control" value="<?php echo set_value('correo'); ?>">
				<label for="r_correo">Correo Electrónico</label>
				<i class="form-group__bar"></i>
			</div>

			<div class="form-group form-group--float form-group--centered">
				<input autocomplete="new-password" id="r_contrasena" name="contrasena" type="password"
					   class="form-control">
				<label for="r_contrasena">Contraseña</label>
				<i class="form-group__bar"></i>
			</div>

			<div class="form-group">
				<label class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input">
					<span class="custom-control-indicator"></span>
					<span class="custom-control-description">Al dar click en el botón de enviar
						acepta nuestras políticas de privacidad </span>
				</label>
			</div>

			<button type="submit" class="btn btn--icon login__block__btn"><i class="zmdi zmdi-check"></i></button>
			<?php echo form_close(); ?>
		</div>

	</div>

	<!-- Recuperación de contraseña -->
	<div class="login__block" id="l-forget-password">
		<div class="login__block__header palette-Purple bg">
			<i class="zmdi zmdi-account-circle"></i>
			¿Olvidaste tu contraseña?

			<div class="actions actions--inverse login__block__actions">
				<div class="dropdown">
					<i data-toggle="dropdown" class="zmdi zmdi-more-vert actions__item"></i>

					<div class="dropdown-menu dropdown-menu-right">
						<a class="dropdown-item" data-ma-action="login-switch" data-ma-target="#l-login" href="">¿Olvidaste
							tu contraseña?</a>
						<a class="dropdown-item" data-ma-action="login-switch" data-ma-target="#l-register" href="">Crear
							una nueva cuenta</a>
					</div>
				</div>
			</div>
		</div>

		<div class="login__block__body">
			<p class="mt-4">Por favor ingresa el correo con el que te registraste y da click en el botón de enviar,
				en breve recibirás un correo electrónico con un enlace para restablecer tu contraseña</p>

			<div class="form-group form-group--float form-group--centered">
				<input id="rc_correo" name="correo" type="text" class="form-control">
				<label for="rc_correo">Correo Electrónico</label>
				<i class="form-group__bar"></i>
			</div>

			<button type="submit" class="btn btn--icon login__block__btn"><i class="zmdi zmdi-check"></i></button>
		</div>
	</div>
</div>

<!-- Javascript -->
<!-- Vendors -->
<script src="<?php echo base_url(); ?>assets/vendors/bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendors/bower_components/popper.js/dist/umd/popper.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- App functions and actions -->
<script src="<?php echo base_url(); ?>assets/js/app.min.js"></script>
</body>
</html>
