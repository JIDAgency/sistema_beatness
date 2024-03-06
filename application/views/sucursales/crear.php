<div class="app-content container center-layout mt-2">

	<div class="content-header-left col-md-6 col-12 mb-2">
		<div class="row breadcrumbs-top">
			<div class="breadcrumb-wrapper col-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo site_url('inicio/index') ?>">Inicio</a>
					</li>
					<li class="breadcrumb-item"><a href="<?php echo site_url('sucursales/index') ?>">Sucursales</a>
					</li>
					<li class="breadcrumb-item active">Crear sucursal
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
								<h4 class="card-title">Crear información de sucursal</h4>
							</div>
							<div class="card-content">
								<div class="card-body">

									<?php echo form_open('sucursales/crear', array('class' => 'form form-horizontal', 'id' => 'forma-crear-sucursales')); ?>

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
                                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre de la sucursal" value="<?php echo set_value('nombre'); ?>">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="locacion">Locación de la sucursal</label>
                                                <input type="text" class="form-control" name="locacion" id="locacion" placeholder="Locación" value="<?php echo set_value('locacion'); ?>">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="descripcion">Descripción de sucursal</label>
                                                <textarea class="form-control" name="descripcion" id="descripcion" rows="3" placeholder="Descripción"><?php echo set_value('descripcion'); ?></textarea>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="direccion">Dirección de la sucursal</label>
                                                <input type="text" class="form-control" name="direccion" id="direccion" placeholder="Dirección" value="<?php echo set_value('direccion'); ?>">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="url">URL de la marca</label>
                                                <input type="text" class="form-control" name="url" id="url" placeholder="URL" value="<?php echo set_value('url'); ?>">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="url_whatsapp">URL para contacto de Whatsapp</label>
                                                <input type="text" class="form-control" name="url_whatsapp" id="url_whatsapp" placeholder="Whatsapp" value="<?php echo set_value('url_whatsapp'); ?>">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="url_ubicacion">URL de Google Maps</label>
                                                <input type="text" class="form-control" name="url_ubicacion" id="url_ubicacion" placeholder="Ubicación" value="<?php echo set_value('url_ubicacion'); ?>">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="url_logo">URL del Logotipo</label>
                                                <input type="text" class="form-control" name="url_logo" id="url_logo" placeholder="Logotipo" value="<?php echo set_value('url_logo'); ?>">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="url_banner">URL del Banner</label>
                                                <input type="text" class="form-control" name="url_banner" id="url_banner" placeholder="Banner" value="<?php echo set_value('url_banner'); ?>">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-2 mb-3">
                                                <label for="orden_mostrar">Mostrar en este orden</label>
                                                <input type="number" class="form-control" name="orden_mostrar" id="orden_mostrar" placeholder="Orden" value="<?php echo set_value('orden_mostrar'); ?>">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="estatus">Estatus de la sucursal</label>
                                                <select name="estatus" id="estatus" class="form-control">
                                                    <option value="" <?php echo set_select('estatus', '' ); ?>>Seleccione un estatus…</option>
                                                    <option value="activo" <?php echo set_select('estatus', 'activo' ); ?>>Activo</option>
                                                    <option value="inactivo" <?php echo set_select('estatus', 'inactivo' ); ?>>Inactivo</option>
                                                </select>
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
