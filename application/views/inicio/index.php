<img class="card-img-top img-fluid" src="<?php echo base_url(); ?>assets/img/banners/banner-sistema-front.jpg" alt="Bienvenida">

<div class="app-content content center-layout mt-2">
	<div class="content-wrapper">

		<div class="content-header row">
			<div class="content-header-left col-md-6 col-12 mb-2">
				<div class="row breadcrumbs-top">
					<div class="breadcrumb-wrapper col-12">
						<ol class="breadcrumb">
							<li class="breadcrumb-item active">Inicio</li>
						</ol>
					</div>
				</div>
			</div>
		</div>

		<divx class="content-body">
			<!-- -->
			<div class="row">
				<div class="col-12 row">
					<div class="col-7">

						<section id="minimal-statistics-bg">

							<div class="row">
								<div class="col-12 mt-3 mb-1">
									<h4 class="text-uppercase">Clientes</h4>
								</div>
							</div>

							<div class="row">


								<div class="col-xl-3 col-lg-12 col-12 d-flex align-items-stretch">
									<div class="card bg-info">
										<a href="<?php echo site_url("clientes"); ?>">
											<div class="card-content">
												<div class="card-body">
													<div class="media d-flex">
														<div class="media-body text-white text-center">
															<h3><i class="fa fa-users text-white"></i></h3>
															<span>Lista de clientes</span>
														</div>
													</div>
												</div>
											</div>
										</a>
									</div>
								</div>

								<div class="col-xl-3 col-lg-12 col-12 d-flex align-items-stretch">
									<div class="card bg-green">
										<a href="<?php echo site_url("clientes/crear"); ?>">
											<div class="card-content">
												<div class="card-body">
													<div class="media d-flex">
														<div class="media-body text-white text-center">
															<h3><i class="fa fa-plus text-white"></i></h3>
															<span>Registrar cliente</span>
														</div>
													</div>
												</div>
											</div>
										</a>
									</div>
								</div>

								<div class="col-xl-3 col-lg-12 col-12 d-flex align-items-stretch">
									<div class="card bg-warning">
										<a href="<?php echo site_url("clientes/suspendidos"); ?>">
											<div class="card-content">
												<div class="card-body">
													<div class="media d-flex">
														<div class="media-body text-white text-center">
															<h3><i class="fa fa-ban text-white"></i></h3>
															<span>Lista de clientes suspendidos</span>
														</div>
													</div>
												</div>
											</div>
										</a>
									</div>
								</div>

							</div>

						</section>
						<!-- -->

						<!-- -->
						<section id="minimal-statistics-bg">

							<div class="row">
								<div class="col-12 mt-3 mb-1">
									<h4 class="text-uppercase">Sucursales</h4>
								</div>
							</div>

							<div class="row">


								<div class="col-xl-3 col-lg-6 col-12 d-flex align-items-stretch">
									<div class="card bg-info">
										<a href="<?php echo site_url("sucursales"); ?>">
											<div class="card-content">
												<div class="card-body">
													<div class="media d-flex">
														<div class="media-body text-white text-center">
															<h3><i class="fa fa-users text-white"></i></h3>
															<span>Sucursales</span>
														</div>
													</div>
												</div>
											</div>
										</a>
									</div>
								</div>

								<div class="col-xl-3 col-lg-6 col-12 d-flex align-items-stretch">
									<div class="card bg-green">
										<a href="<?php echo site_url("sucursales/crear"); ?>">
											<div class="card-content">
												<div class="card-body">
													<div class="media d-flex">
														<div class="media-body text-white text-center">
															<h3><i class="fa fa-users text-white"></i></h3>
															<span>Registrar sucursal</span>
														</div>
													</div>
												</div>
											</div>
										</a>
									</div>
								</div>

							</div>

						</section>
					</div>
					<?php if (es_superadministrador() || es_administrador()) : ?>
						<div class="col-5">
							<section>
								<div class="form-group">
									<div class="col-xl-12 col-md-12 col-sm-12">
										<div class="row">
											<h4 class="form-section">Reseñas</h4>

											<div class="list-group">
												<?php foreach ($resenias as $nota_key => $resenia) : ?>
													<div class="list-group-item flex-column align-items-start">
														<div class="row">
															<div class="col-3 align-self-center text-center">
																<img src="<?php echo base_url('subidas/perfil/' . $resenia->coach_foto); ?>" class="img-fluid" width="70%" alt="coach" style="border-radius: 50%;"> <br>
																<small><?php echo $resenia->coach; ?></small>
															</div>
															<div class="col-9 align-self-center">
																<div class="d-flex w-100 justify-content-between">
																	<small><?php echo date('d M y H:i a', strtotime($resenia->fecha_registro)) ?></small>
																</div>
																<div class="row pl-1 mt-1">
																	<?php for ($i = 1; $i <= $resenia->calificacion; $i++) : ?>
																		<p style="font-size: large; margin: 0;">⭐️</p>
																	<?php endfor; ?>
																</div>
																<p><b><?php echo $resenia->nota; ?></b></p>

																<small><?php echo $resenia->nombre . ' ' . $resenia->dificultad . ' - ' . date('d/m/Y H:i:s', strtotime($resenia->inicia)); ?></small>
															</div>
														</div>
													</div>
												<?php endforeach; ?>
											</div>

										</div>
									</div>
								</div>
							</section>
						</div>
					<?php endif; ?>

				</div>
			</div>
			<!-- -->
	</div>
</div>
</div>