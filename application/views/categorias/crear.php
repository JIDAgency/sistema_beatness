<div class="app-content container center-layout mt-2">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo site_url('inicio/index') ?>">Inicio</a>
                    </li>
                    <li class="breadcrumb-item"><a href="<?php echo site_url('categorias/index') ?>">Categorias</a>
                    </li>
                    <li class="breadcrumb-item active">Crear nueva categoria
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
                                <h4 class="card-title">Nueva categoria</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <?php echo form_open('categorias/crear', array('class' => 'form form-horizontal', 'id' => 'forma-crear-categoria')); ?>
                                    <div class="form-body">
                                        <?php if (validation_errors()) : ?>
                                            <div class="alert bg-danger alert-icon-left alert-dismissible mb-2 font-small-3" role="alert">
                                                <span class="alert-icon"><i class="fa fa-thumbs-o-down"></i></span>
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                                <?php echo validation_errors(); ?>
                                            </div>
                                        <?php endif ?>
                                        <h4 class="form-section">Datos de la categoria</h4>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">

                                                <div class="form-group">
                                                    <label for="nombre" class="label-control">Nombre <span class="red">*</span></label>
                                                    <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre" value="<?php echo set_value('nombre'); ?>">
                                                </div>

                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="descripcion" class="label-control">Descripcion<span class="red">*</span></label>
                                                    <textarea type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Describe la categoria" value="<?php echo set_value('descripcion'); ?>"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="notas" class="label-control">Nota <span class="red">*</span></label>
                                                    <textarea type="text" class="form-control" id="notas" name="notas" placeholder="Nota" value="<?php echo set_value('notas'); ?>"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="reservable">Reservable <span class="red">*</span></label>
                                                    <select name="reservable" id="reservable" class="form-control">
                                                        <option value="">Seleccione una sucursal</option>
                                                        <option value="true">Si</option>
                                                        <option value="false">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="visible">Visible <span class="red">*</span></label>
                                                    <select name="visible" id="visible" class="form-control">
                                                        <option value="">Seleccione una sucursal</option>
                                                        <option value="true">Si</option>
                                                        <option value="false">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="virtual">Virtual <span class="red">*</span></label>
                                                    <select name="virtual" id="virtual" class="form-control">
                                                        <option value="">Seleccione una sucursal</option>
                                                        <option value="true">Si</option>
                                                        <option value="false">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="diciplina_id">Disciplina
                                                        para la clase <span class="red">*</span> </label>
                                                    <select id="mySelect" name="disciplina_id" class="form-control">
                                                        <option value="">Seleccione la disciplina</option>
                                                        <?php foreach ($disciplinas->result() as $disciplina) : ?>
                                                            <?php if ($disciplina->id != 1) : ?>
                                                                <option value="<?php echo $disciplina->id; ?>" <?php echo set_select('disciplina_id', $disciplina->id); ?>>
                                                                    <?php echo $disciplina->nombre; ?>
                                                                </option>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-actions right">
                                            <a href="<?php echo site_url('categorias/index'); ?>" class="btn btn-secondary btn-sm">Cancelar</a>
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