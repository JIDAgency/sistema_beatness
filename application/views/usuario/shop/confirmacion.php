<section class="seccion-texto b3-ux-v2-fondo">

    <div class="container p-t-20">
    <?php $this->load->view('_comun/mensajes_alerta'); ?>
        <div class="row p-b-20">
        
                <div class="col-6 offset-3 text-center">
                <img class="img-fluid" src="<?php echo base_url(); ?>almacenamiento/logos/logo-b3.png" width="200">
                    <h1 class="p-t-20">¡Compra realizada con éxito!</h1>
                    <h3>Tu plan "<strong><?php echo $asignacion->nombre; ?></strong>" se ha activado <strong>(<?php echo date('d/m/Y',strtotime($asignacion->fecha_activacion)); ?>).</strong></h3>
                    <h5 class="text-muted">Recuerda, tiene una vigencia de <strong><?php echo $asignacion->vigencia_en_dias; ?></strong> días.</h5>
                    <!--h3>Ahora tienes acceso al contenido de las clases online, ¡continúa tu entrenamiento!.</h3-->
                    <br><br>
                    <a href="<?php echo site_url('usuario/clases'); ?>" class="btn btn-outline-blue">Ir a Clases</a>
                </div>

        </div>

    </div>

</section>



