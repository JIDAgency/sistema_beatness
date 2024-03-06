<div class="app-content container center-layout mt-2">
    <div class="content-wrapper">

        <!--div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                    </div>
                </div>
            </div>
        </div-->

        <div class="content-body">

            <!-- User Profile Cards with Cover Image -->
                <section id="user-profile-cards-with-cover-image" class="row mt-2">

                    <div class="col-xl-4 col-md-6 col-12">
                        <div class="card profile-card-with-cover">
                            <div class="card-img-top img-fluid bg-cover height-200" style="background: url('<?php echo base_url(); ?>almacenamiento/img/bg.jpg');"></div>
                            <div class="card-profile-image">
                                <img src="<?php echo base_url(); ?>/subidas/perfil/<?php echo $this->session->userdata('nombre_imagen_avatar'); ?>" class="rounded-circle img-border box-shadow-1" alt="Card image"  width="120px">
                            </div>
                            <div class="profile-card-with-cover-content text-center">
                                <div class="card-body">
                                    <h4 class="card-title"><?php echo $datos_usuario->nombre_completo; ?></h4>
                                    <ul class="list-inline list-inline-pipe">
                                        <li>Top de Actividad</li>
                                        <li><strong>#<?php echo $top_de_actividad_reservaciones; ?></strong></li>
                                    </ul>
                                    <h6 class="card-subtitle text-muted">Miembro desde: <?php echo date('d/m/Y',strtotime($datos_usuario->fecha_registro)); ?></h6>
                                </div>
                                <!--div class="text-center">
                                    <a href="#" class="btn btn-social-icon mr-1 mb-1 btn-outline-facebook"><span class="fa fa-facebook"></span></a>
                                    <a href="#" class="btn btn-social-icon mr-1 mb-1 btn-outline-twitter"><span class="fa fa-twitter"></span></a>
                                    <a href="#" class="btn btn-social-icon mr-1 mb-1 btn-outline-linkedin"><span class="fa fa-linkedin font-medium-4"></span></a>
                                    <a href="#" class="btn btn-social-icon mb-1 btn-outline-github"><span class="fa fa-github font-medium-4"></span></a>
                                </div-->
                            </div>
                        </div>

                        <!-- <?php echo $last_instagram_post->url; ?>-->
                    </div>

                    <div class="col-xl-8 col-md-6 col-12">
                        <div class="card">
                            <div class="card-head">
                                <div class="card-header">
                                    <h4 class="card-title">B3 Active</h4>
                                    <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                    <!--div class="heading-elements">
                                        <span class="badge badge-default badge-warning">B.Bike</span>
                                        <span class="badge badge-default badge-success">B.Box</span>
                                        <span class="badge badge-default badge-info">B.Body</span>
                                        <span class="badge badge-default badge-primary">B.Godín</span>
                                    </div-->
                                </div>

                                <!-- project-info
                                <div id="project-info" class="card-body row">

                                    <div class="project-info-count col-lg-4 col-md-12">
                                        <div class="project-info-icon">
                                            <h2><?php echo $clases_de_la_semana; ?></h2>
                                            <div class="project-info-sub-icon">
                                            <span class="fa fa-calendar"></span>
                                            </div>
                                        </div>
                                        <div class="project-info-text pt-1">
                                            <h5>Clases Disponibles esta Semana</h5>
                                        </div>
                                    </div>

                                    <div class="project-info-count col-lg-4 col-md-12">
                                        <div class="project-info-icon">
                                            <h2><?php echo $top_de_actividad_reservaciones; ?></h2>
                                            <div class="project-info-sub-icon">
                                            <span class="fa fa-users"></span>
                                            </div>
                                        </div>
                                        <div class="project-info-text pt-1">
                                            <h5>Top de Actividad</h5>
                                        </div>
                                    </div>
                                    
                                    <div class="project-info-count col-lg-4 col-md-12">
                                        <div class="project-info-icon">
                                            <h2><?php echo $reservaciones_de_la_semana; ?></h2>
                                            <div class="project-info-sub-icon">
                                            <span class="fa fa-bicycle"></span>
                                            </div>
                                        </div>
                                        <div class="project-info-text pt-1">
                                            <h5>Mis Reservaciones de la Semana</h5>
                                        </div>
                                    </div>

                                </div> -->
                                
                                <div class="card-subtitle line-on-side text-muted text-center font-small-3 mx-2 my-1">
                                    <span>Mis Planes <a href="comprar_planes" class="text-muted" data-toggle="tooltip" data-placement="bottom" title="¡Adquiere un plan!"><i class="icon-bag"></i></a></span>
                                </div>

                                <div class="px-1">
                                        <?php foreach ($planes->result() as $plan): ?>
                                            <?php if ($plan->plan_id == 15): ?>
                                                <ul class="list-inline list-inline-pipe text-center p-1 border-bottom-grey border-bottom-lighten-3">
                                                    <li class=""><?php echo $plan->nombre; ?></li>
                                                    <li>Usadas: <span class="text-muted"><?php echo $plan->clases_usadas?></span></li>
                                                    <li>Caduca: <span class="text-muted"><?php echo date('d/m/Y', strtotime("+".$plan->vigencia_en_dias." days", strtotime($plan->fecha_activacion)))?></span></li>                                            
                                                </ul>
                                            <?php else: ?>
                                                <ul class="list-inline list-inline-pipe text-center p-1 border-bottom-grey border-bottom-lighten-3">
                                                    <li><?php echo $plan->nombre; ?></li>
                                                    <li>Clases: <span class="text-muted"><?php echo $plan->clases_incluidas - $plan->clases_usadas?></span></li>
                                                    <li>Incluidas: <span class="text-muted"><?php echo $plan->clases_incluidas?></span></li>
                                                    <li>Usadas: <span class="text-muted"><?php echo $plan->clases_usadas?></span></li>
                                                    <li>Caduca: <span class="text-muted"><?php echo date('d/m/Y', strtotime("+".$plan->vigencia_en_dias." days", strtotime($plan->fecha_activacion)))?></span></li>                                            
                                                </ul>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                </div>
                            </div>
                            
                            <div class="card-body">
                                <div class="card-subtitle line-on-side text-muted text-center font-small-3 mx-2 my-1">
                                    <span>Mis Clases Reservadas</span>
                                </div>
                                    <?php $time_set = 0; foreach($obtener_reservacion_por_cliente as $clases_row): ?>

                                        <?php if($time_set != $clases_row->horario): ?>
                                            <h5><?php echo mb_strtoupper(strftime('%A',strtotime($clases_row->horario))).' - '.date('[d/m]',strtotime($clases_row->horario)); ?></h5>
                                            <div class="row">
                                        <?php endif; ?>
                                        
                                            <div class="col-lg-12 col-md-12">
                                                <ul class="list-inline list-inline-pipe text-center p-1 border-bottom-grey border-bottom-lighten-3">
                                                    <li><strong><?php echo $clases_row->subdisciplina_id != 0 ? $clases_row->disciplina.' & GODÍN' : $clases_row->disciplina; ?></strong></li>
                                                    <li>Fecha: <span class="text-muted"><?php echo date('d/m/Y',strtotime($clases_row->horario)); ?></span></li>
                                                    <li>Horario: <span class="text-muted"><?php echo date('H:i',strtotime($clases_row->horario)); ?></span></li>
                                                    <li>Instructor: <span class="text-muted"><?php echo date('H:i',strtotime($clases_row->instructor)); ?></span></li>
                                                    <?php if($clases_row->dificultad): ?>
                                                        <li>Dificultad: <span class="text-muted"><?php echo $clases_row->dificultad; ?></span></li>
                                                    <?php endif; ?>
                                                    <li>Lugar: <span class="text-muted"><?php echo $clases_row->no_lugar; ?></span></li>
                                                </ul>
                                            </div>

                                        <?php if($time_set != $clases_row->horario): ?>
                                            </div>
                                        <?php endif; $time_set = $clases_row->horario;?>
                                            
                                    <?php endforeach; ?>                                                           
                            </div>
                        </div>
                    </div>

                </section>
            <!--/ User Profile Cards with Cover Image -->

        </div>
    </div>
</div>
<!-- ////////////////////////////////////////////////////////////////////////////-->
