<!-- Modal -->
<div class="modal fade text-left" name="modal_registrar_clase" id="modal_registrar_clase" tabindex="-1" role="dialog" aria-labelledby="seccion_registrar_clase" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modal-title text-text-bold-600" id="seccion_registrar_clase">Registrarse Clase en Gympass</label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="form_registrar_clase" action="<?php echo site_url('gympass/registrar_clase'); ?>">
                <div class="modal-body">
                    <div class="row match-height">
                        <div class="col-xl-6 col-md-6 col-sm-12">
                            <p><b>SKU:</b></p>
                        </div>
                        <div class="col-xl-6 col-md-6 col-sm-12 text-right">
                            <p id="identificador"></p>
                        </div>

                        <div class="col-xl-6 col-md-6 col-sm-12">
                            <p><b>Disciplina:</b></p>
                        </div>
                        <div class="col-xl-6 col-md-6 col-sm-12 text-right">
                            <p id="disciplinas_nombre"></p>
                        </div>

                        <div class="col-xl-6 col-md-6 col-sm-12">
                            <p><b>Categoría:</b></p>
                        </div>
                        <div class="col-xl-6 col-md-6 col-sm-12 text-right">
                            <p id="dificultad"></p>
                        </div>

                        <div class="col-xl-6 col-md-6 col-sm-12">
                            <p><b>Fecha:</b></p>
                        </div>
                        <div class="col-xl-6 col-md-6 col-sm-12 text-right">
                            <p id="fecha"></p>
                        </div>

                        <div class="col-xl-6 col-md-6 col-sm-12">
                            <p><b>Horario:</b></p>
                        </div>
                        <div class="col-xl-6 col-md-6 col-sm-12 text-right">
                            <p id="horario"></p>
                        </div>

                        <div class="col-xl-6 col-md-6 col-sm-12">
                            <p><b>Coach:</b></p>
                        </div>
                        <div class="col-xl-6 col-md-6 col-sm-12 text-right">
                            <p id="instructores_nombre"></p>
                        </div>

                        <div class="col-xl-6 col-md-6 col-sm-12">
                            <p><b>Sucursal:</b></p>
                        </div>
                        <div class="col-xl-6 col-md-6 col-sm-12 text-right">
                            <p id="sucursales_locacion"></p>
                        </div>

                        <div class="col-xl-6 col-md-6 col-sm-12">
                            <p><b>Aforo:</b></p>
                        </div>
                        <div class="col-xl-6 col-md-6 col-sm-12 text-right">
                            <p id="cupos"></p>
                        </div>
                    </div>
                    <label>Categorías de Gympass</label>
                    <input type="hidden" class="form-control" name="id" id="id" value="" readonly>
                    <div class="form-group">
                        <select id="categoria" name="categoria" class="form-control custom-select" required>
                            <option value="" <?php echo set_select('categoria', '', set_value('categoria') ? false : '' == $this->session->flashdata('categoria')); ?>>Seleccione una categoría…</option>
                            <?php foreach ($categorias_list as $categoria_key => $categoria_value) : ?>
                                <?php if (!empty($categoria_value->gympass_id) and !empty($categoria_value->disciplinas_gympass_product_id)) : ?>
                                    <option value="<?php echo $categoria_value->id; ?>" <?php echo set_select('categoria', $categoria_value->id, set_value('categoria') ? false : $categoria_value->id == $this->session->flashdata('categoria')); ?>><?php echo trim($categoria_value->nombre . ' - ' . $categoria_value->disciplinas_nombre); ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-outline-grey" data-dismiss="modal"><i class="fa fa-times-circle"></i>&nbsp;Atrás</button>
                    <button type="submit" class="btn btn-outline-secondary"><i class="fa fa-check-circle"></i>&nbsp;Registrar</button>
                </div>
            </form>
        </div>
    </div>
</div>