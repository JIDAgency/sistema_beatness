<div class="app-content container center-layout mt-2">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo site_url('inicio/index') ?>">Inicio</a>
                    </li>
                    <li class="breadcrumb-item"><a href="<?php echo site_url('clases_categorias/index') ?>">Clases</a>
                    </li>
                    <li class="breadcrumb-item active">Editar categoria de clase
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
                                <h4 class="card-title">Editar categoria de clase</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <?php echo form_open('clases_categorias/editar', array('class' => 'form form-horizontal', 'id' => 'forma-editar-clase')); ?>
                                    <input type="hidden" name="id" value="<?php echo $clase_a_editar->id; ?>">
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
                                        <?php $this->load->view('_comun/mensajes_alerta'); ?>
                                        <h4 class="form-section">Datos de la clase</h4>
                                        <div class="row">
                                            <input type="hidden" readonly="true" id="identificador" class="form-control" name="identificador" placeholder="Identificador" value="<?php echo set_value('identificador'); ?>">
                                            <div class="col-md-8">
                                                <div class="form-group row">
                                                    <label for="disciplina_id" class="col-md-3 label-control"><span class="red">*</span> Disciplina
                                                        para la clase</label>
                                                    <div class="col-md-9">
                                                        <select id="mySelect" name="disciplina_id" class="form-control">
                                                            <option value="">Seleccione la disciplina</option>
                                                            <?php foreach ($disciplinas->result() as $disciplina) : ?>
                                                                <?php
                                                                if ($clase_a_editar->subdisciplina_id > 0) {
                                                                    $disciplina_que_se_editara = $clase_a_editar->subdisciplina_id;
                                                                } else {
                                                                    $disciplina_que_se_editara = $clase_a_editar->disciplina_id;
                                                                }
                                                                ?>
                                                                <?php if ($disciplina->id != 1) : ?>
                                                                    <option value="<?php echo $disciplina->id; ?>" <?php echo set_select('disciplina_id', $disciplina_que_se_editara, set_value('disciplina_id') ? false : $disciplina->id == $disciplina_que_se_editara); ?>>
                                                                        <?php echo $disciplina->nombre; ?>
                                                                    </option>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group row">
                                                    <label for="nombre" class="col-md-3 label-control"><span class="red">*</span> Nombre</label>
                                                    <div class="col-md-5">
                                                        <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre" value="<?php echo set_value('nombre') == false ? ($clase_a_editar->nombre) : (set_value('nombre')); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group row">
                                                    <label for="descripcion" class="col-md-3 label-control"><span class="red">*</span> Descripción</label>
                                                    <div class="col-md-5">
                                                        <textarea id="descripcion" name="descripcion" class="form-control" rows="5" placeholder="Descripción" value=""><?php echo set_value('descripcion') == false ? ($clase_a_editar->descripcion) : set_value('descripcion'); ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group row">
                                                    <label for="nota" class="col-md-3 label-control"><span class="red">*</span> Nota</label>
                                                    <div class="col-md-5">
                                                        <textarea id="nota" name="nota" class="form-control" rows="5" placeholder="Nota" value=""><?php echo set_value('nota') == false ? ($clase_a_editar->nota) : set_value('nota'); ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group row">
                                                    <label for="estatus" class="col-md-3 label-control">Estatus</label>
                                                    <div class="col-md-5">
                                                        <select id="estatus" name="estatus" class="form-control" required>
                                                            <option value="">Seleccione un estatus...</option>
                                                            <option value="activo" <?php echo set_select('estatus', 'activo', set_value('estatus') ? false : 'activo' == $clase_a_editar->estatus); ?>>Activo
                                                            </option>
                                                            <option value="suspendido" <?php echo set_select('estatus', 'suspendido', set_value('estatus') ? false : 'suspendido' == $clase_a_editar->estatus); ?>>Suspendido
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-actions right">
                                            <a href="<?php echo site_url('clases_categorias/index'); ?>" class="btn btn-secondary btn-sm">Cancelar</a>
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