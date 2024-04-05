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
			<li><a href="<?php echo site_url('disciplinas/index') ?>">Disciplinas</a></li>
		</ul>
	</header>

	<!-- Contents -->
	<section class="content">
		<div class="content__inner">
			<header class="content__title">
				<h1>Main heading</h1>
				<small>Sub heading contents</small>
				<a href="<?php echo site_url('sucursal/crear'); ?>">Crear nueva sucursal</a>
			</header>

			<!-- Page Contents -->
			<div class="card">
				<div class="card-body">
					<h4 class="card-title">Sucursales</h4>
					<h6 class="card-subtitle">Sucursales registradas en el sistema</h6>

					<table class="table display nowrap table-striped table-bordered scroll-horizontal table-hover">
						<thead>
						<tr>
							<th>#</th>
							<th>Nombre</th>
							<th>Gerente</th>
							<th>Teléfono</th>
							<th>Acciones</th>
						</tr>
						</thead>
						<tbody>
						<?php if($sucursales->num_rows() > 0): ?>
							<?php foreach ($sucursales->result() as $sucursal): ?>
								<tr>
									<th scope="row"><?php echo $sucursal->id ?></th>
									<td><?php echo $sucursal->nombre ?></td>
									<td><?php echo $sucursal->gerente ?></td>
									<td><?php echo $sucursal->telefono ?></td>
									<td><?php echo anchor('sucursal/editar/' . $sucursal->id, 'Editar'); ?></td>
								</tr>
							<?php endforeach; ?>
						<?php else:; ?>
						<tr>
							<td colspan="5" class="text-center">No hay sucursales disponibles | <a href="<?php echo site_url('sucursal/crear'); ?>">Crear nueva sucursal</a></td>
						</tr>
						<?php endif; ?>
						</tbody>
					</table>
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

