<div class="app-content container center-layout mt-2">

	<div class="content-header-left col-md-6 col-12 mb-2">
		<div class="row breadcrumbs-top">
			<div class="breadcrumb-wrapper col-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo site_url('inicio/index') ?>">Inicio</a>
					</li>
					<li class="breadcrumb-item"><a href="<?php echo site_url('sucursales/index') ?>">Sucursales</a>
					</li>
					<li class="breadcrumb-item active">Editar sucursal
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
								<h4 class="card-title">Editar información de sucursal</h4>
							</div>
							<div class="card-content">
								<div class="card-body">

									<?php echo form_open('sucursales/editar', array('class' => 'form form-horizontal', 'id' => 'forma-editar-sucursales')); ?>

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

										<h4 class="form-section">Datos de la sucursal</h4>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="nombre">Nombre de la sucursal</label>
                                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre de la sucursal" value="<?php echo set_value('nombre') == false ? $sucursal_a_editar_row->nombre : set_value('nombre'); ?>">
                                                <input type="hidden" class="form-control" id="id" name="id" placeholder="" value="<?php echo set_value('id') == false ? $sucursal_a_editar_row->id : set_value('id'); ?>" readonly>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="locacion">Locación de la sucursal</label>
                                                <input type="text" class="form-control" name="locacion" id="locacion" placeholder="Locación" value="<?php echo set_value('locacion') == false ? $sucursal_a_editar_row->locacion : set_value('locacion'); ?>">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="descripcion">Descripción de sucursal</label>
                                                <input type="text" class="form-control" name="descripcion" id="descripcion" rows="3" placeholder="Descripción" value="<?php echo set_value('descripcion') == false ? $sucursal_a_editar_row->descripcion : set_value('descripcion'); ?>"></textarea>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="direccion">Dirección de la sucursal</label>
                                                <input type="text" class="form-control" name="direccion" id="direccion" placeholder="Dirección" value="<?php echo set_value('direccion') == false ? $sucursal_a_editar_row->direccion : set_value('direccion'); ?>">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="url">URL de la marca</label>
                                                <input type="text" class="form-control" name="url" id="url" placeholder="URL" value="<?php echo set_value('url') == false ? $sucursal_a_editar_row->url : set_value('url'); ?>">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="url_whatsapp">URL para contacto de Whatsapp</label>
                                                <input type="text" class="form-control" name="url_whatsapp" id="url_whatsapp" placeholder="Whatsapp" value="<?php echo set_value('url_whatsapp') == false ? $sucursal_a_editar_row->url_whatsapp : set_value('url_whatsapp'); ?>">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="url_ubicacion">URL de Google Maps</label>
                                                <input type="text" class="form-control" name="url_ubicacion" id="url_ubicacion" placeholder="Ubicación" value="<?php echo set_value('url_ubicacion') == false ? $sucursal_a_editar_row->url_ubicacion : set_value('url_ubicacion'); ?>">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="url_logo">URL del Logotipo</label>
                                                <input type="text" class="form-control" name="url_logo" id="url_logo" placeholder="Logotipo" value="<?php echo set_value('url_logo') == false ? $sucursal_a_editar_row->url_logo : set_value('url_logo'); ?>">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="url_banner">URL del Banner</label>
                                                <input type="text" class="form-control" name="url_banner" id="url_banner" placeholder="Banner" value="<?php echo set_value('url_banner') == false ? $sucursal_a_editar_row->url_banner : set_value('url_banner'); ?>">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-2 mb-3">
                                                <label for="orden_mostrar">Mostrar en este orden</label>
                                                <input type="number" class="form-control" name="orden_mostrar" id="orden_mostrar" placeholder="Orden" value="<?php echo set_value('orden_mostrar') == false ? $sucursal_a_editar_row->orden_mostrar : set_value('orden_mostrar'); ?>">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="estatus">Estatus de la sucursal</label>
                                                <select name="estatus" id="estatus" class="form-control">
                                                    <option value="" <?php echo set_select('estatus', '' ); ?>>Seleccione un estatus…</option>
                                                    <option value="activo" <?php echo set_select('estatus', "activo" , set_value('estatus') ? false : "activo"==$sucursal_a_editar_row->estatus);?>>Activo</option>
                                                    <option value="inactivo"<?php echo set_select('estatus', "inactivo" , set_value('estatus') ? false : "inactivo"==$sucursal_a_editar_row->estatus);?>>Inactivo</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label for="gympass_gym_id">GYMPASS GYM ID</label>
                                                <input type="number" class="form-control" name="gympass_gym_id" id="gympass_gym_id" placeholder="Gympass Gym ID" value="<?php echo set_value('gympass_gym_id') == false ? $sucursal_a_editar_row->gympass_gym_id : set_value('gympass_gym_id'); ?>">
                                            </div>
                                        </div>

                                        <hr class="mb-4">

										<div class="form-actions right">
											<a href="<?php echo site_url('sucursales/index'); ?>" class="btn btn-secondary btn-sm">Cancelar</a>
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
