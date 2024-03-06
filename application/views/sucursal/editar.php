<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Page Title</title>

	<!-- Vendor styles -->
	<link rel="stylesheet"
		  href="<?php echo base_url(); ?>assets/vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css">
	<link rel="stylesheet"
		  href="<?php echo base_url(); ?>assets/vendors/bower_components/jquery.scrollbar/jquery.scrollbar.css">

	<!-- App styles -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/app.min.css">
</head>

<body data-ma-theme="green">
<main class="main main--alt">

	<!-- Header -->
	<header class="header">
		<div class="navigation-trigger hidden-xl-up" data-ma-action="aside-open" data-ma-target=".sidebar">
			<div class="navigation-trigger__inner">
				<i class="navigation-trigger__line"></i>
				<i class="navigation-trigger__line"></i>
				<i class="navigation-trigger__line"></i>
			</div>
		</div>

		<div class="header__logo hidden-sm-down">
			<h1><a href="index.html"><?php echo branding(); ?></a></h1>
		</div>

		<!-- Other Header Contents -->
		<ul class="top-nav">
			<li>
				<?php echo anchor('cuenta/cerrar_sesion', '<i class="zmdi zmdi-power-off"></i>'); ?>
			</li>
		</ul>
		<ul class="top-menu">
			<li><a href="<?php echo site_url('usuarios/index') ?>">Usuarios</a></li>
			<li class="active"><a href="<?php echo site_url('sucursal/index') ?>">Sucursales</a></li>
			<li><a href="">Roles</a></li>
		</ul>
	</header>

	<!-- Contents -->
	<section class="content">
		<div class="content__inner">
			<header class="content__title">
				<h1>Main heading</h1>
				<small>Sub heading contents</small>
			</header>
			<div class="m-5">
				<?php echo validation_errors('<p class="text-danger text-center m-0">', '</p>'); ?>
			</div>
			<!-- Page Contents -->
			<div class="card">
				<div class="card-body">
					<h4 class="card-title">Sucursales</h4>
					<h6 class="card-subtitle">Editar Sucursal</h6>

					<?php echo form_open('sucursal/editar'); ?>
					<input type="hidden" name="id" value="<?php echo $sucursal_a_editar->id; ?>">
					<div class="form-row">
						<div class="col-md-6">
							<div class="form-group">
								<input type="text" class="form-control" name="nombre" placeholder="Nombre de la Sucursal"
									   value="<?php echo set_value('nombre') == FALSE ? $sucursal_a_editar->nombre : set_value('nombre'); ?>">
								<i class="form-group__bar"></i>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<div class="select">
									<select name="usuario_id" class="form-control">
										<option value="">Seleccione el gerente de esta sucursal</option>
										<?php foreach ($administradores->result() as $administador): ?>
											<option value="<?php echo $administador->id; ?>" <?php echo  set_select('usuario_id', $sucursal_a_editar->id, set_value('usuario_id')?FALSE: $administador->id == $sucursal_a_editar->usuario_id); ?>><?php echo $administador->nombre_completo; ?></option>
										<?php endforeach; ?>
									</select>
									<i class="form-group__bar"></i>
								</div>
							</div>
						</div>
					</div>

					<div class="form-row">
						<div class="col-md-6">
							<div class="form-group">
								<input type="text" name="telefono" class="form-control" placeholder="Teléfono"
									   value="<?php echo set_value('telefono') == FALSE ? $sucursal_a_editar->telefono : set_value('telefono'); ?>">
								<i class="form-group__bar"></i>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<input type="text" name="calle" class="form-control"
									   placeholder="Calle" value="<?php echo set_value('calle') == FALSE ? $sucursal_a_editar->calle : set_value('calle'); ?>">
								<i class="form-group__bar"></i>
							</div>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-6">
							<div class="form-group">
								<input type="text" name="numero" class="form-control" placeholder="Número Exterior"
									   value="<?php echo set_value('numero') == FALSE ? $sucursal_a_editar->numero : set_value('numero'); ?>">
								<i class="form-group__bar"></i>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<input type="text" name="colonia" class="form-control"
									   placeholder="Colonia"
									   value="<?php echo set_value('colonia') == FALSE ? $sucursal_a_editar->colonia : set_value('colonia'); ?>">
								<i class="form-group__bar"></i>
							</div>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-4">
							<div class="form-group">
								<input type="text" class="form-control" name="ciudad" placeholder="Ciudad"
									   value="<?php echo set_value('ciudad') == FALSE ? $sucursal_a_editar->ciudad : set_value('ciudad'); ?>">
								<i class="form-group__bar"></i>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<input type="text" class="form-control" name="estado" placeholder="Estado"
									   value="<?php echo set_value('estado') == FALSE ? $sucursal_a_editar->estado : set_value('estado'); ?>">
								<i class="form-group__bar"></i>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<input type="text" class="form-control" name="pais" placeholder="País"
									   value="<?php echo set_value('pais') == FALSE ? $sucursal_a_editar->pais : set_value('pais'); ?>">
								<i class="form-group__bar"></i>
							</div>
						</div>
					</div>

					<button type="submit" class="btn btn-primary">Editar Sucursal</button>
					<?php echo form_close(); ?>
				</div>
			</div>

			<!-- Footer -->
			<footer class="footer">
				<!-- Footer Contents -->
			</footer>
		</div>
	</section>
</main>


<!-- Javascript -->
<!-- Vendors -->
<script src="<?php echo base_url(); ?>assets/vendors/bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendors/bower_components/popper.js/dist/umd/popper.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script
	src="<?php echo base_url(); ?>assets/vendors/bower_components/jquery.scrollbar/jquery.scrollbar.min.js"></script>
<script
	src="<?php echo base_url(); ?>assets/vendors/bower_components/jquery-scrollLock/jquery-scrollLock.min.js"></script>

<!-- App functions -->
<script src="<?php echo base_url(); ?>assets/js/app.min.js"></script>
</body>
</html>

