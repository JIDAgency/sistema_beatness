<div class="app-content container center-layout mt-2 b3-ux-v2-fondo">
    <div class="content-wrapper">

        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo site_url('usuario/inicio'); ?>">Inicio</a></li>
                            <li class="breadcrumb-item active">Comprar</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-body">
            <?php $this->load->view('_comun/mensajes_alerta'); ?>
            <!-- Contenido -->
            <div class="row">
                <div class="col-12 mt-1 mb-1">
                    <h4 class="text-uppercase">Selecciona y adquiere una <strong>suscripción mensual</strong> <?php echo branding(); ?> Online Access</h4>
                    <p class="text-muted">Suscribete para tener acceso a todo el contenido de <?php echo branding(); ?> y mantente en movimiento con sus Clases Online.</p>
                </div>
            </div>
            <div class="row">
                <?php foreach ($suscripciones_list as $suscripcion_row): ?>
                    <div class="col-xl-12 col-md-6 col-12 mb-2">
                        <a href="<?php echo site_url('usuario/shop/seleccionar_metodo/'.$suscripcion_row->id); ?>">
                            <img src="<?php echo $suscripcion_row->url_infoventa; ?>" alt="Haga clic para proceder con la compra de <?php echo $suscripcion_row->nombre?>." width="100%" class="img-fluid text-center d-none d-sm-block">
                            <img src="<?php echo $suscripcion_row->url_infoventa_movil; ?>" alt="Haga clic para proceder con la compra de <?php echo $suscripcion_row->nombre?>." width="100%" class="img-fluid text-center d-block d-sm-none">
                        </a>
                    </div>
                <?php endforeach;?>
            </div>

            <!--div class="row mt-2">
                <div class="col-12 mt-1 mb-1">
                    <h4 class="text-uppercase">Selecciona y adquiere un <strong>paquete de clases</strong></h4>
                    <p class="text-muted">Ten acceso a las instalaciones de <?php echo branding(); ?>, asiste a nuestras clases presenciales y reserva a través de tu App.</p>
                </div>
            </div>
            <div class="row">
                <?php //foreach ($planes_list as $plan_list): ?>
                    <div class="col-xl-4 col-md-6 col-12 mb-2">
                        <a href="<?php //echo site_url('usuario/comprar_planes_pagoopenpay/index/'.$plan_list->id); ?>">
                            <img src="<?php //echo $plan_list->url_infoventa; ?>" alt="Haga clic para proceder con la compra de <?php //echo $plan_list->nombre?>." width="100%" class="img-fluid text-center">
                        </a>
                    </div>
                <?php //endforeach;?>
            </div-->
            <!-- / Contenido -->
        </div>
    </div>
</div>