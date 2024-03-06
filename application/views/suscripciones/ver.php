<div class="app-content container center-layout mt-2">
	<div class="content-wrapper">

		<div class="content-header row">

			<div class="content-header-left col-md-6 col-12 mb-2">
				<div class="row breadcrumbs-top">
					<div class="breadcrumb-wrapper col-12">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php echo site_url("inicio"); ?>">Inicio</a></li>
							<li class="breadcrumb-item active">Suscripciones</li>
						</ol>
					</div>
				</div>
			</div>

			<!--div class="content-header-right col-md-6 col-12">
				<div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">   
					<button class="btn btn-info round dropdown-toggle dropdown-menu-right px-2" id="btnGroupDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ft-settings icon-left"></i> Settings</button>
					<div class="dropdown-menu" aria-labelledby="btnGroupDrop1"><a class="dropdown-item" href="card-bootstrap.html">Cards</a><a class="dropdown-item" href="component-buttons-extended.html">Buttons</a></div>
				</div>
			</div-->

		</div>

		<div class="content-body">
			<section id="configuration">
				<div class="row">
					<div class="col-12">
						<div class="card no-border">
							<div class="card-header">
								<h4 class="card-title">Lista de suscripciones</h4>
							</div>
							<div class="card-content collapse show">
								<div class="card-body card-dashboard">
									<!--p class="card-text"></p-->
                                    
                                    <a class="" href="<?php echo site_url("suscripciones/crear/".$suscripcion_row->id.""); ?>">Crear</a>
                                    <br>
                                    <br>
                                    <a class="" href="<?php echo site_url("suscripciones/cancelar/".$suscripcion_row->id.""); ?>">Cancelar</a>
                                    <br>
                                    <br>
                                    <p><b>ID: </b><?php echo $suscripcion_row->id; ?></p>
                                    <p><b>DB - Suscripción ID: </b><?php echo $suscripcion_row->openpay_suscripcion_id; ?></p>
                                    <p><b>DB - Cliente ID: </b><?php echo $suscripcion_row->openpay_cliente_id; ?></p>
                                    <p><b>DB - Tarjeta ID: </b><?php echo $suscripcion_row->openpay_tarjeta_id; ?></p>
                                    <p><b>DB - Plan ID: </b><?php echo $suscripcion_row->openpay_plan_id; ?></p>
                                    <p><b>DB - Estatus Sub: </b><?php echo $suscripcion_row->suscripcion_estatus_del_pago; ?></p>
                                    <p><b>OpenPay - Estatus Sub: </b><?php echo $resultado_openpay->status; ?></p>
                                    <p><?php print_r($resultado_openpay); ?></p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</div>
