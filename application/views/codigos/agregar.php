<div class="app-content content center-layout mt-2">
    <div class="content-wrapper">
        
        <div class="content-header row">

            <div class="content-header-left col-md-6 col-12 mb-2">

                <h3 class="content-header-title mb-0"><?php echo $pagina_titulo; ?></h3>

                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo site_url('inicio'); ?>">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo site_url('codigos'); ?>">Códigos</a></li>
                            <li class="breadcrumb-item active"><?php echo $pagina_titulo; ?></li>
                        </ol>
                    </div>
                </div>

            </div>

			<div class="content-header-right col-md-6 col-12 mb-2">

				<div class="media width-250 float-right">

					<div class="form-group">
						<!-- Outline button group with icons and text. -->
						<div class="btn-group" role="group" aria-label="Basic example">
						</div>
					</div>

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
            <section id="section">

				<?php $this->load->view('_templates/mensajes_alerta.tpl.php');?>

                <div class="row">
                    <div class="col-12">
                        <div class="card no-border">

                            <div class="card-header">
                                <h4 class="card-title"><?php echo $pagina_titulo; ?></h4>
                            </div>

                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard">

									<?php echo form_open_multipart(uri_string(), array('class' => 'needs-validation p-2', 'id' => 'form', 'novalidate' => '', 'method' => 'post')); ?>

                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="col-lg-12">Código&nbsp;<span class="red">*</span></label>
                                                        <div class="col-lg-12">
                                                            <input type="text" class="form-control" name="codigo" id="codigo" placeholder="Código" value="<?php echo set_value('codigo') == false ? $this->session->flashdata('codigo') : set_value('codigo'); ?>" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="col-lg-12">Tipo&nbsp;<span class="red">*</span></label>
                                                        <div class="col-lg-12">
                                                            <select id="tipo" name="tipo" class="form-control select2 custom-select" required>
                                                                <option value="">Seleccione un tipo...</option>
                                                                <option value="desbloquear" selected <?php echo set_select('tipo', 'desbloquear', set_value('tipo') ? false : 'desbloquear' == $this->session->flashdata('tipo')); ?>>Desbloquear</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="col-lg-12">Estatus&nbsp;<span class="red">*</span></label>
                                                        <div class="col-lg-12">
                                                            <select id="estatus" name="estatus" class="form-control select2 custom-select" required>
                                                                <option value="">Seleccione un estatus...</option>
                                                                <option value="activo" selected <?php echo set_select('estatus', 'activo', set_value('estatus') ? false : 'activo' == $this->session->flashdata('estatus')); ?>>Activo</option>
                                                                <option value="suspendido" <?php echo set_select('estatus', 'suspendido', set_value('estatus') ? false : 'suspendido' == $this->session->flashdata('estatus')); ?>>Suspendido</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

										<div class="row mt-3">
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
