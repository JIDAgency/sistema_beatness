<div class="app-content container center-layout mt-2">
	<div class="content-header-left col-md-6 col-12 mb-2">
		<div class="row breadcrumbs-top">
			<div class="breadcrumb-wrapper col-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo site_url('inicio') ?>">Inicio</a>
					</li>
                    <li class="breadcrumb-item"><a href="<?php echo site_url('app') ?>">App</a>
					</li>
					<li class="breadcrumb-item active">Descubre
					</li>
				</ol>
			</div>
		</div>
	</div>
	<div class="content-wrapper">
		<div class="content-body">
			<section>
				<div class="row">
					<div class="col-12">
						<div class="card no-border">
							<div class="card-header">
								<h4 class="card-title">Configurar sección "Descubre"</h4>
							</div>
							<div class="card-content">
								<div class="card-body">

									<?php echo form_open_multipart('app/publicidad', array('class' => 'form form-horizontal', 'id' => 'forma-publicidad')); ?>
                                        
                                        <input type="hidden" name="id" id="id" value="<?php echo $publicidad_row->id; ?>">
                                        
                                        <?php $this->load->view('_comun/mensajes_alerta'); ?>

                                        <div class="form-body">

                                            <?php if (validation_errors()): ?>
                                                <div class="alert bg-danger alert-icon-left alert-dismissible mb-2 font-small-3" role="alert">
                                                    <span class="alert-icon"><i class="fa fa-thumbs-o-down"></i></span>
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                    <?php echo validation_errors(); ?>
                                                </div>
                                            <?php endif?>

                                            <div class="form-group">
                                                <div class="row mt-3">

                                                    <label class="col-sm-12"><b>Imagen botón home (App)</b></label>

                                                    <div class="col-sm-6">
                                                        <img class="img-fluid border" name="preview_url_imagen_boton" id="preview_url_imagen_boton" src="<?php echo base_url("almacenamiento/img_app/acerca/".$publicidad_row->url_imagen_boton); ?>" style="width: 100%;">
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <p><b>Formato: </b>jpg</p>
                                                        <p><b>Ancho: </b></p>
                                                        <p><b>Altura: </b></p>
                                                        <p><b>Tamaño máximo (Kb): </b></p>
                                                        <input type="file" name="url_imagen_boton" id="url_imagen_boton" placeholder="Botón de home (App)" value="<?php echo set_value('url_imagen_boton') == false ? $publicidad_row->url_imagen_boton : set_value('url_imagen_boton'); ?>" onchange="cargar_imagen_boton(event)">
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="row mt-3">
                                                <div class="col-md-10">
                                                    <div class="form-group row">
                                                        <label for="url_boton" class="col-md-10">Configurar URL para el botón del Home <br><small><em>(Dejar este campo vacío para que el botón lleve a la vista de descubre dentro de la APP)</em></small></label>
                                                        <div class="col-md-10">
                                                            <input type="text" name="url_boton" id="url_boton" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toLowerCase()" class="form-control" placeholder="URL botón del Home" value="<?php echo set_value('url_boton') == false ? $publicidad_row->url_boton : set_value('url_boton'); ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            
                                            <div class="form-group">
                                                <div class="row mt-3">

                                                    <label class="col-sm-12"><b>Imagen sección de descubre (App)</b></label>

                                                    <div class="col-sm-6">
                                                        <img class="img-fluid border" name="preview_url_imagen_page" id="preview_url_imagen_page" src="<?php echo base_url("almacenamiento/img_app/acerca/".$publicidad_row->url_imagen_page); ?>" style="width: 100%;">
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <p><b>Formato: </b>jpg</p>
                                                        <p><b>Ancho: </b></p>
                                                        <p><b>Altura: </b></p>
                                                        <p><b>Tamaño máximo (Kb): </b></p>
                                                        <input type="file" name="url_imagen_page" id="url_imagen_page" placeholder="Imagen sección de descubre (App)" value="<?php echo set_value('url_imagen_page') == false ? $publicidad_row->url_imagen_page : set_value('url_imagen_page'); ?>" onchange="cargar_imagen_page(event)">
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="row mt-3">
                                                <div class="col-md-10">
                                                    <div class="form-group row">
                                                        <label for="url_page" class="col-md-10">Configurar URL para la sección de descubre (App)<br><small><em>(Dejar este campo vacío para que la app no redireccione a ningún lugar)</em></small></label>
                                                        <div class="col-md-10">
                                                            <input type="text" name="url_page" id="url_page" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toLowerCase()" class="form-control" placeholder="URL sección de descubre" value="<?php echo set_value('url_page') == false ? $publicidad_row->url_page : set_value('url_page'); ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row mt-3">

                                                    <label class="col-sm-12"><b>Imagen vista (Web)</b></label>

                                                    <div class="col-sm-6">
                                                        <img class="img-fluid border" name="preview_url_imagen_vista" id="preview_url_imagen_vista" src="<?php echo base_url("almacenamiento/img_app/acerca/".$publicidad_row->url_imagen_vista); ?>" style="width: 100%;">
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <p><b>Formato: </b>jpg</p>
                                                        <p><b>Ancho: </b></p>
                                                        <p><b>Altura: </b></p>
                                                        <p><b>Tamaño máximo (Kb): </b></p>
                                                        <input type="file" name="url_imagen_vista" id="url_imagen_vista" placeholder="Imagen vista (Web)" value="<?php echo set_value('url_imagen_vista') == false ? $publicidad_row->url_imagen_vista : set_value('url_imagen_vista'); ?>" onchange="cargar_imagen_vista(event)">
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="row mt-3">
                                                <div class="col-md-10">
                                                    <div class="form-group row">
                                                        <label for="url_vista" class="col-md-10">Configurar URL para redireccionar (Web)<br><small><em>(Dejar este campo vacío para la página web no redireccionan a ningún lugar)</em></small></label>
                                                        <div class="col-md-10">
                                                            <input type="text" name="url_vista" id="url_vista" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toLowerCase()" class="form-control" placeholder="URL para redireccionar (Web)" value="<?php echo set_value('url_vista') == false ? $publicidad_row->url_vista : set_value('url_vista'); ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-3">
                                                <div class="col-md-10">
                                                    <div class="form-group row">
                                                        <label for="estatus" class="col-md-10">Estatus</em></small></label>
                                                        <div class="col-md-10">
                                                            <select name="estatus" class="form-control">
                                                                <option value="activo" <?php echo set_select('estatus', "activo" , set_value('estatus') ? false : "activo" == $publicidad_row->estatus); ?>>Activo</option>
                                                                <option value="suspendido" <?php echo set_select('estatus', "suspendido" , set_value('estatus') ? false : "suspendido" == $publicidad_row->estatus); ?>>Suspendido</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-actions right">
                                                <a href="<?php echo site_url('instructores/index'); ?>" class="btn btn-secondary btn-sm">Atrás</a>
                                                <button type="submit" class="btn btn-secondary btn-sm">Guardar</button>
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
