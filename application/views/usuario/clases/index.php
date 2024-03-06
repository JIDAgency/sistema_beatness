<div class="app-content container center-layout mt-2 b3-ux-v2-fondo">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo site_url('usuario/inicio'); ?>">Inicio</a></li>
                            <li class="breadcrumb-item active">Disciplinas</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-body">
            <?php $this->load->view('_comun/mensajes_alerta'); ?>

            <!-- Shopping cards section start -->
            <section id="shopping-cards">
                <div class="row">
                    <div class="col-12 mt-3 mb-1">
                        <h4 class="text-uppercase">Disciplinas Online</h4>
                    </div>
                </div>

                <div class="row match-height">

                    <?php foreach ($disciplinas_online_list as $disciplina_online_row): ?>

                        <div class="col-sm-3 col-6 mb-2">

                            <div class="text-center">
                                <a href="<?php echo site_url('usuario/clases/online/'.$disciplina_online_row->id); ?>">
                                    <img class="card-img img-fluid" src="<?php echo site_url('subidas/b3-clases-online-portadas/'.$disciplina_online_row->url_banner); ?>" alt="<?php echo $disciplina_online_row->nombre; ?>..." width="250px" class="img-fluid p-2">
                                </a>
                            </div>
                            
                        </div>

                    <?php endforeach; ?>

                </div>

            </section>
            <!-- // Shopping cards section end -->

        </div>
    </div>
</div>
<!-- ////////////////////////////////////////////////////////////////////////////-->