<div class="app-content container center-layout mt-2">
	<div class="content-wrapper">
		<div class="content-header row">
			<div class="content-header-left col-md-6 col-12 mb-2">
				<div class="row breadcrumbs-top">
					<div class="breadcrumb-wrapper col-12">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>usuario/inicio">Inicio</a>
							</li>
							<li class="breadcrumb-item active">Planes Disponibles
							</li>
						</ol>
					</div>
				</div>
			</div>
		</div>
		<div class="content-body">
        	<?php $this->load->view('_comun/mensajes_alerta'); ?>

			<!-- input groups start --> 
				<section class="input-groups" id="input-groups">
					<h4 class="content-header-title mb-0">Adquiere tu plan B3 ¡Ahora! y entrena con los mejores</h4>
					<br>

					<!--div class="row match-height">

						<?php if (sizeof($planes_normales) > 0): ?>
							<?php foreach ($planes_normales as $plan_normal): ?>
								<?php if ($plan_normal->subscripcion == 0): ?>
									<div class="col-xl-4 col-lg-6">
										<div class="card">
											<div class="card-content">
												<div class="card-img text-center">
													<a href="comprar_planes_pagoopenpay/index/<?php echo $plan_normal->id; ?>" class="">
														<img src="<?php echo $plan_normal->url_infoventa; ?>" alt="" width="400px" class="img-fluid p-2">
													</a>
												</div>
											</div>
										</div>
									</div>

								<?php endif; ?>
							<?php endforeach; ?>
						<?php endif; ?>

					</div-->

					<div class="text-center">
						<span class="text-center fa fa-arrow-circle-o-down"></span>
					</div>

					<hr>
					<h4 class="content-header-title mb-0">Manten el ritmo desde casa</h4>
					<br>

					<div class="row match-height">

						<?php if (sizeof($planes_online) > 0): ?>
							<?php foreach ($planes_online as $plan_online): ?>
								<?php if ($plan_online->subscripcion == 1): ?>
							
									<div class="col-xl-4 col-lg-6">
										<div class="card">
											<div class="card-content">
												<div class="card-img text-center">
													<a href="comprar_planes_pagoopenpay/index/<?php echo $plan_online->id; ?>" class="">
														<img src="<?php echo $plan_online->url_infoventa; ?>" alt="" width="400px" class="img-fluid p-2">
													</a>
												</div>
											</div>
										</div>
									</div>

								<?php endif; ?>
							<?php endforeach; ?>
						<?php endif; ?>

					</div>

					<div class="text-center">
						<span class="text-center fa fa-arrow-circle-o-down"></span>
					</div>

					<hr>
					<h4 class="content-header-title mb-0">¿Mucho trabajo?, mantente enfocado con nuestros planes Godín y aprovecha tu tiempo.</h4>
					<br>

					<!--div class="row match-height">

						<?php if (sizeof($planes_godinez) > 0): ?>
							<?php foreach ($planes_godinez as $plan_godin): ?>
							
								<div class="col-xl-4 col-lg-6">
									<div class="card">
										<div class="card-content">
											<div class="card-img text-center">
												<a href="comprar_planes_pagoopenpay/index/<?php echo $plan_godin->id; ?>" class="">
													<img src="<?php echo $plan_godin->url_infoventa; ?>" alt="" width="400px" class="img-fluid p-2">
												</a>
											</div>
										</div>
									</div>
								</div>

							<?php endforeach; ?>
						<?php endif; ?>
					
					</div-->
					
				</section>
			<!-- input groups end -->

		</div>
	</div>
</div>
