<!-- Modal -->
<div class="modal fade text-left" name="modal_enviar_notificacion_segmento_usuarios_sin_compras_hace_dos_meses" id="modal_enviar_notificacion_segmento_usuarios_sin_compras_hace_dos_meses" tabindex="-1" role="dialog" aria-labelledby="seccion_enviar_notificacion_segmento_usuarios_sin_compras_hace_dos_meses" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modal-title text-text-bold-600" id="seccion_enviar_notificacion_segmento_usuarios_sin_compras_hace_dos_meses">Enviar notificación</label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="form_enviar_notificacion_segmento_usuarios_sin_compras_hace_dos_meses" action="<?php echo site_url('notificaciones/enviar_notificacion_segmento_usuarios_sin_compras_hace_dos_meses'); ?>">
                <div class="modal-body">
                    <label>Se enviará la notificación a todo el segmento de usuarios sin compras hace dos meses</label>
                    <input type="text" class="form-control" name="id_2" id="id_2" value="" readonly>

                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-outline-grey" data-dismiss="modal"><i class="fa fa-times-circle"></i>&nbsp;Atrás</button>
                    <button type="submit" class="btn btn-outline-secondary"><i class="fa fa-check-circle"></i>&nbsp;Enviar</button>
                </div>
            </form>
        </div>
    </div>
</div>
