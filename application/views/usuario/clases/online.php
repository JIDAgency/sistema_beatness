<div class="app-content container center-layout mt-2 b3-ux-v2-fondo">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo site_url('usuario/inicio')?>">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo site_url('usuario/clases')?>">Disciplinas</a></li>
                            <li class="breadcrumb-item active">Clases Online</li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="content-header-right col-md-6 col-12">
            </div>
        </div>
        <div class="content-body">
            <?php $this->load->view('_comun/mensajes_alerta'); ?>

            <!-- Shopping cards section start -->
            <section id="shopping-cards">
                <div class="row">
                    <div class="col-sm-3 col-6">
                        <h4 class="text-uppercase"><?php echo $disciplina_seleccionada; ?> - Clases Disponibles</h4>
                    </div>
                </div>
                
                <div class="row">
                    <?php foreach ($clases_por_streaming_list as $clase_por_streaming_row): ?>
                        <div class="col-xl-3 col-6 mb-2">
                                <div class="m-0 p-0 text-center">
                                    <?php if ($clase_por_streaming_row->url_preview): ?>
                                        <a href="<?php echo site_url('usuario/clases/ver/'.$clase_por_streaming_row->id.'/'.$parametro_de_la_vista_anterior); ?>" class="">
                                            <img class="img-fluid" src="<?php echo site_url('subidas/b3-clases-online-portadas/portadas-clases/'.$clase_por_streaming_row->url_preview); ?>" alt="B3 Class Preview..." class="img-fluid">
                                        </a>
                                    <?php else: ?>
                                        <h3 class="text-uppercase"><?php echo $clase_por_streaming_row->descripcion; ?></h3>
                                        <h5 class="text-uppercase text-muted"><i class="fa fa-eye"></i> <?php echo $clase_por_streaming_row->reservados; ?></h5>
                                        <h5 class="text-uppercase text-muted"><?php echo $clase_por_streaming_row->tematica; ?></h5>
                                        <small class="text-uppercase"><?php echo date('d/m/Y', strtotime($clase_por_streaming_row->fecha_clase)); ?></small>
                                        <small class="text-uppercase"><?php echo date('H:i',strtotime($clase_por_streaming_row->fecha_clase)); ?></small><!--Este dato no se si es necesario-->
                                    <?php endif; ?>
                                    
                                    <?php 
                                        $cupos_lugares_list = json_decode($clase_por_streaming_row->cupo_lugares);

                                        $comparacion_cupo = array();

                                        foreach ($cupos_lugares_list as $cupo_lugar_row) {
                                            array_push($comparacion_cupo, $cupo_lugar_row->id_usuario);
                                        }
                                    ?>

                                    <?php if (in_array($this->session->userdata('id'), $comparacion_cupo)): ?>
                                        <a href="<?php echo site_url('usuario/clases/ver/'.$clase_por_streaming_row->id.'/'.$parametro_de_la_vista_anterior); ?>" class="btn btn-cyan btn-accent-2 border-cyan border-accent-2 black square btn-min-width btn-block btn-glow text-left text-uppercase mr-1 mb-1"><strong><em>Ver otravez</em></strong></a>
                                    <?php else: ?>
                                        <a href="<?php echo site_url('usuario/clases/ver/'.$clase_por_streaming_row->id.'/'.$parametro_de_la_vista_anterior); ?>" class="btn btn-cyan btn-accent-2 border-cyan border-accent-2 black square btn-min-width btn-block btn-glow text-left text-uppercase mr-1 mb-1"><strong><em>Ver clase</em></strong></a>
                                    <?php endif; ?>
                                </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
            <!-- // Shopping cards section end -->
            
        </div>
    </div>
    <p><?php echo $abrir_modal; ?></p>

</div>

<?php if ($this->session->flashdata('MENSAJE_ERROR')): ?>
    <script>
        window.addEventListener('load', function() {
            $('#modal_suscripciones').modal('show');
        })
    </script>
<?php endif; ?>

<!-- Modal -->
<div class="modal fade text-left" id="modal_suscripciones" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel1">Comienza tu entrenamiento</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <h5><?php echo branding(); ?> Online Access</h5>
                <p>Adquiere una suscripción de 30 días para disfrutar de todo el contenido en línea de <?php echo branding(); ?>.</p>
                <p>Las clases están a tu alcance, revisa nuestro contenido diario. Puedes ver todas las clases disponibles sin límite, no te quedes sin el ejercicio que tu cuerpo necesita.</p>
                <hr>
                <h5>Selecciona tu suscripción y entrena hoy mismo.</h5>
                <?php if (sizeof($planes_para_clases_online) > 0): ?>
                    <?php foreach ($planes_para_clases_online as $plan_online): ?>
                        <div class="row text-center">
                            <div class="col">
                                <a href="<?php echo site_url('usuario/shop/seleccionar_metodo/'); ?><?php echo $plan_online->id; ?>" class="">
                                    <img src="<?php echo $plan_online->url_infoventa_movil; ?>" alt="" width="500px" class="img-fluid p-2">
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-red" data-dismiss="modal">Atras</button>
                <a href="<?php echo site_url('usuario/shop/'); ?>" class="btn btn-outline-secondary">Tienda</a>
            </div>
        </div>
    </div>
</div>
