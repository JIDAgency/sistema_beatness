<div class="app-content container center-layout mt-2">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo site_url('inicio') ?>">Inicio</a>
                    </li>
                    <li class="breadcrumb-item"><a href="<?php echo site_url('planes_categorias') ?>">Categorías de planes</a>
                    </li>
                    <li class="breadcrumb-item active">Agregar
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
                                <h4 class="card-title">Nueva categoría de panes</h4>
                            </div>

                            <div class="card-content">
                                <div class="card-body">
                                    <?php echo form_open_multipart('planes_categorias/crear', array('class' => 'form form-horizontal', 'id' => 'forma-crear-categoria')); ?>
                                    <div class="form-body">
                                        <?php $this->load->view('_templates/mensajes_alerta.tpl.php'); ?>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-12">

                                                <h4 class="form-section">Datos de la categoria</h4>

                                                <div class="row">
                                                    <div class="col-md-12 mb-2">
                                                        <div class="form-group">
                                                            <label for="nombre" class="label-control">Nombre <span class="red">*</span></label>
                                                            <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre" value="<?php echo set_value('nombre'); ?>">
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12 mb-2">
                                                        <div class="form-group">
                                                            <label for="orden">Mostrar en este orden</label>
                                                            <input type="number" class="form-control" name="orden" id="orden" placeholder="Orden" value="<?php echo set_value('orden'); ?>">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12 mb-2">
                                                        <label for="estatus">Estatus de la sucursal</label>
                                                        <select name="estatus" id="estatus" class="form-control">
                                                            <option value="" <?php echo set_select('estatus', ''); ?>>Seleccione un estatus…</option>
                                                            <option value="activo" <?php echo set_select('estatus', 'activo'); ?>>Activo</option>
                                                            <option value="suspendido" <?php echo set_select('estatus', 'suspendido'); ?>>Suspendido</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <h4 class="form-section">Imagen</h4>
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <img src="<?php echo site_url("almacenamiento/planes/default.jpg"); ?>" name="preview" id="preview" style="width: 300px; height: 200px;">
                                                        <br>
                                                        <br>
                                                        <p><b>Formato: </b>JPG</p>
                                                        <p><b>Ancho: </b>1200</p>
                                                        <p><b>Altura: </b>1200</p>
                                                        <p><b>Tamaño máximo (Kb): </b>600</p>
                                                        <input type="file" name="url_banner" id="url_banner" placeholder="Miniatura" value="<?php echo set_value('url_banner') == false ? 'default.jpg' : set_value('url_banner'); ?>" onchange="cargar_imagen(event)">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-actions right">
                                            <a href="<?php echo site_url('planes_categorias'); ?>" class="btn btn-secondary btn-sm">Atrás</a>
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