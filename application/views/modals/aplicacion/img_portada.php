<!-- Modal -->
<div class="modal fade text-left" name="modal_img_portada" id="modal_img_portada" tabindex="-1" role="dialog" aria-labelledby="seccion_img_portada" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modal-title text-text-bold-600" id="seccion_img_portada"><b>Cambiar imagen</b></label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" enctype="multipart/form-data" id="form_img_portada" action="<?php echo site_url('aplicacion/img_portada'); ?>">
                <div class="modal-body">
                    <label>Imagen de portada: </label>
                    <div class="form-group">
                            
                        <div class="row p-2">

                            <div class="col-sm-12 mb-2">
                                <img class="img-fluid border" name="preview_img_portada" id="preview_img_portada" src="<?php echo base_url('almacenamiento/img_app/portada/'.$img_portada_row->url); ?>" style="width: 100%;">
                            </div>

                            <div class="col-sm-12">
                                <p><b>Formato: </b>JPG</p>
                                <p><b>Tamaño máximo (Kb): </b>400 Kb</p>
                                <fieldset class="form-group">
                                    <div class="custom-file">
                                        <label class="custom-file-label" for="img_portada">Cargar</label>
                                        <input type="file" class="custom-file-input" name="img_portada" id="img_portada" placeholder="archivo" value="<?php echo set_value('img_portada'); ?>" onchange="cargar_img_portada(event)">
                                        <div class="invalid-feedback">
                                            Se requiere un archivo válido.
                                        </div>
                                    </div>
                                </fieldset>
                            </div>

                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-outline-grey" data-dismiss="modal"><i class="fa fa-times-circle"></i>&nbsp;Atrás</button>
                    <button type="submit" class="btn btn-outline-secondary"><i class="fa fa-check-circle"></i>&nbsp;Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
