<div class="app-content container center-layout mt-2">
	<div class="content-header-left col-md-6 col-12 mb-2">
	</div>
	<div class="content-wrapper">
		<div class="content-body">
			<section>
				<div class="row">
					<div class="col-12">
						<div class="card">
							<div class="card-header">
								<h4 class="card-title">Editar usuario vinculado</h4>
							</div>
							<div class="card-content">
								<div class="card-body">
                                    <?php echo form_open($controlador, array('class' => 'needs-validation p-2', 'id' => 'forma-'.$controlador, 'novalidate' => '', 'method' => 'post')); ?>
									
                                        <input type="hidden" name="id" id="id" value="<?php echo $usuario_row->id; ?>">
                                        
                                        <div class="form-body">

                                            <?php $this->load->view('_comun/mensajes_alerta');?>

                                            <?php if (validation_errors()): ?>
                                                <div class="alert bg-danger alert-icon-left alert-dismissible mb-2 font-small-3" role="alert">
                                                    <span class="alert-icon"><i class="fa fa-thumbs-o-down"></i></span>
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                    <?php echo validation_errors(); ?>
                                                </div>
                                            <?php endif?>

                                            <h4 class="form-section">Datos de acceso</h4>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label for="correo" class="col-md-3 label-control"><span class="red">*</span> Email</label>
                                                        <div class="col-md-9">
                                                            <input type="email" name="correo" id="correo" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toLowerCase()" class="form-control" placeholder="Correo Electrónico" value="<?php echo set_value('correo') == false ? $usuario_row->correo : set_value('correo'); ?>">
                                                            <?php echo form_error('correo', '<span class="text-danger">','</span>'); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <h4 class="form-section">Datos de contacto</h4>

                                            <div class="row">

                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label for="nombre_completo" class="col-md-3 label-control"><span class="red">*</span> Nombre</label>
                                                        <div class="col-md-9">
                                                            <input type="text" name="nombre_completo" class="form-control" placeholder="Nombre Completo" value="<?php echo set_value('nombre_completo') == false ? $usuario_row->nombre_completo : set_value('nombre_completo'); ?>" >
                                                            <?php echo form_error('nombre_completo', '<span class="text-danger">','</span>'); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label for="apellido_paterno" class="col-md-3 label-control"><span class="red">*</span> Apellido paterno</label>
                                                        <div class="col-md-9">
                                                            <input type="text" name="apellido_paterno" class="form-control" placeholder="Apellido Paterno" value="<?php echo set_value('apellido_paterno') == false ? $usuario_row->apellido_paterno : set_value('apellido_paterno'); ?>" >
                                                            <?php echo form_error('apellido_paterno', '<span class="text-danger">','</span>'); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label for="apellido_materno" class="col-md-3 label-control">Apellido materno</label>
                                                        <div class="col-md-9">
                                                            <input type="text" name="apellido_materno" class="form-control" placeholder="Apellido Materno" value="<?php echo set_value('apellido_materno') == false ? $usuario_row->apellido_materno : set_value('apellido_materno'); ?>">
                                                            <?php echo form_error('apellido_materno', '<span class="text-danger">','</span>'); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label for="no_telefono" class="col-md-3 label-control">Télefono</label>
                                                        <div class="col-md-5">
                                                            <input autocomplete="off" type="text" class="form-control" name="no_telefono" placeholder="No. de Teléfono" value="<?php echo set_value('no_telefono') == false ? $usuario_row->no_telefono : set_value('no_telefono'); ?>">
                                                            <?php echo form_error('no_telefono', '<span class="text-danger">','</span>'); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-actions right">
                                                <a href="<?php echo site_url($regresar_a); ?>" class="btn btn-secondary btn-sm">Regresar</a>
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
