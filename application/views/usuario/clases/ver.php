<div class="app-content container center-layout mt-2 b3-ux-v2-fondo">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo site_url('usuario/inicio')?>">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo site_url('usuario/clases')?>">Disciplinas Online</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo site_url($regresar_a)?>">Clases</a></li>
                            <li class="breadcrumb-item active">Ver Clase</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <?php $this->load->view('_comun/mensajes_alerta'); ?>

            <!-- Zoom Image example section start -->
            <section id="zoom-img-example">
                <div class="row">
                
                    <div class="col-sm-4">
                        <div class="card">

                            <div class="card-header">
                                <h4 class="card-title"><?php echo $clase_por_streaming_row->descripcion; ?> [<?php echo $clase_por_streaming_row->tematica; ?>]</h4>
                                <!--<p class="text-uppercase text-muted"><i class="fa fa-eye"></i> <?php echo $clase_por_streaming_row->reservados; ?></p>-->
                                <img class="img-fluid mt-3" src="<?php echo site_url('subidas/b3-clases-online-portadas/portadas-clases/'.$clase_por_streaming_row->url_preview); ?>" alt="B3 Class Preview..." class="img-fluid">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-8">
                        <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="text-center pb-3"><iframe src="<?php echo $clase_por_streaming_row->url_video; ?>" width="100%" height="600" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </section>
            <!-- // Zoom Image example section end -->
        </div>
    </div>
</div>
<!-- ////////////////////////////////////////////////////////////////////////////-->
