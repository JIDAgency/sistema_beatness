<div class="app-content content center-layout mt-2">
    <div class="content-wrapper">
        
        <div class="content-header row">

            <div class="content-header-left col-md-8 col-12 mb-2">

                <h3 class="content-header-title mb-0"><?php echo $pagina_titulo; ?></h3>

                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo site_url('inicio'); ?>">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo site_url('notificaciones'); ?>">Notificaciones</a></li>
                            <li class="breadcrumb-item active"><?php echo $pagina_titulo; ?></li>
                        </ol>
                    </div>
                </div>

            </div>

			<div class="content-header-right col-md-4 col-12 mb-2">

				<div class="media width-250 float-right">


                    <!--
					<media-left class="media-middle">
						<div id="sp-bar-total-sales"></div>
					</media-left>
					
					<div class="media-body media-right text-right">
						<h3 class="m-0">$5,668</h3><span class="text-muted">Sales</span>
					</div>
                    -->
					
				</div>

			</div>

        </div>

        <div class="content-body">

            <?php if (validation_errors()): ?>
                <div class="alert bg-danger alert-icon-left alert-dismissible mb-2 font-small-3" role="alert">
                    <span class="alert-icon"><i class="fa fa-thumbs-o-down"></i></span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <?php echo validation_errors(); ?>
                </div>
            <?php endif?>
            <?php $this->load->view('_comun/mensajes_alerta'); ?>
            
            <section id="section">

                <div class="row">
                    <div class="col-12">
                        <div class="card no-border">

                            <div class="card-header">
                                <h4 class="card-title">Agregar <?php echo $pagina_titulo; ?></h4>
                            </div>

                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard">

                                    <?php echo form_open_multipart(uri_string(), array('class' => 'needs-validation p-2', 'id' => 'form', 'novalidate' => '', 'method' => 'post')); ?>

                                        <div class="row match-height">
                                            <div class="col-xl-6 col-md-6 col-sm-12">

                                                <div class="form-group">
													<div class="row">
														<label class="col-lg-12" for="titulo"><b>Título&nbsp;</b><span class="red">*</span></label>
														<div class="col-lg-12">
															<input type="text" class="form-control" name="titulo" id="titulo" placeholder="Título" value="<?php echo set_value('titulo') == false ? $this->session->flashdata('titulo') : set_value('titulo'); ?>" required>
															<div class="invalid-feedback">
																Se requiere una título válido.
															</div>
														</div>
													</div>
												</div>

                                                <div class="form-group">
													<div class="row">
														<label class="col-lg-12" for="mensaje"><b>Mensaje&nbsp;</b><span class="red">*</span></label>
														<div class="col-lg-12">
															<textarea class="form-control" name="mensaje" id="mensaje" rows="8" maxlength="240" placeholder="Mensaje en un máximo de 240 caracteres" required><?php echo set_value('mensaje') == false ? $this->session->flashdata('mensaje') : set_value('mensaje'); ?></textarea>
															<div class="invalid-feedback">
																Se requiere una mensaje válido.
															</div>
														</div>
														<div class="col-lg-12 media-right float-right text-right">
															<small class="text-muted" name="mensaje-count" id="mensaje-count">0/240</small>
														</div>
													</div>
												</div>
                                                
                                            </div>
                                        </div>

                                        <div class="row match-height mt-3">
                                            <div class="col-12">
                                                <!--div class="form-group float-md-left">
                                                </div-->
                                                <div class="form-group float-md-right">
                                                    <a class="btn btn-outline-grey btn-outline-lighten-1 btn-min-width mr-1" href="<?php echo site_url($regresar_a); ?>"><i class="fa fa-times-circle"></i>&nbsp;Atrás</a>
                                                    <button type="submit" class="btn btn-outline-secondary btn-min-width mr-1"><i class="fa fa-check-circle"></i>&nbsp;Guardar</button>
                                                </div>
                                            </div>
                                        </div>

                                    <?php echo form_close(); ?>

                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>

            </section>
        </div>

    </div>
</div>
