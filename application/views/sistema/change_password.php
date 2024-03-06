<div class="app-content container center-layout mt-2">
	<div class="content-header-left col-md-6 col-12 mb-2">
		<div class="row breadcrumbs-top">
			<div class="breadcrumb-wrapper col-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo site_url('inicio/index') ?>">Inicio</a>
					</li>
					<li class="breadcrumb-item"><a href="<?php echo site_url('clientes/index') ?>">Clientes</a>
					</li>
					<li class="breadcrumb-item active">Editar cliente
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
						<div class="card">
							<div class="card-header">
								<h4 class="card-title">Editar cliente</h4>
							</div>
							<div class="card-content">
								<div class="card-body">
									<?php echo form_open($controlador, array('class' => 'form form-horizontal', 'id' => 'forma-editar-cliente')); ?>

										
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

                                            <?php $this->load->view('_comun/mensajes_alerta'); ?>

                                            <h4>Datos del usuario</h4>
                                            <p><small>Nueva contraseña para: <strong><?php echo $usuario_row->correo.' #'.$usuario_row->id; ?></strong></small></p>
                                            <input type="hidden" name="id" id="id" value="<?php echo $usuario_row->id; ?>">

                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="contrasenia">Nueva contraseña <span class="red">*</span></label>
                                                    <div class="input-group">
                                                        <input type="password" class="form-control" name="contrasenia" id="contrasenia" placeholder="Nueva contraseña de usuario" value="<?php echo set_value('contrasenia'); ?>" required="">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-secondary" type="button" onclick="mostrar_contrasenia()"><i class="fa fa-eye"></i></button>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">
                                                        Por favor introduzca la contraseña nueva.
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mb-2">
                                                <div class="col-md-6 mb-3">
                                                    <label for="contrasenia_valida">Validar nueva contraseña <span class="red">*</span></label>
                                                    <div class="input-group">
                                                        <input type="password" class="form-control" name="contrasenia_valida" id="contrasenia_valida" placeholder="Validar nueva contraseña de usuario" value="<?php echo set_value('contrasenia_valida'); ?>" required="">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-secondary" type="button"  onclick="mostrar_contrasenia_valida()"><i class="fa fa-eye"></i></button>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">
                                                        Por favor introduzca la contraseña nueva para validar.
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-actions right">
                                                <a href="<?php echo site_url($regresar_a); ?>" class="btn btn-secondary btn-sm">Atras</a>
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
