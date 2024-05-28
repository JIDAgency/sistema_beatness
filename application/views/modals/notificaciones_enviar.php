<!-- Modal -->
<div class="modal fade text-left" name="modal_notificaciones_enviar" id="modal_notificaciones_enviar" tabindex="-1" role="dialog" aria-labelledby="seccion_notificaciones_enviar" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modal-title text-text-bold-600" id="seccion_notificaciones_enviar">Enviar notificación</label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="form_notificaciones_enviar" action="<?php echo site_url('notificaciones/enviar'); ?>">
                <div class="modal-body">
                    <label>Seleccione el segmento al que se enviará la notificación: </label>
                    <div class="form-group">
                        <select id="segmento" name="segmento" class="form-control select2 custom-select" required>
                            <option value="Total Subscriptions" <?php echo set_select('segmento', 'Total Subscriptions', set_value('segmento') ? false : 'Total Subscriptions' == $this->session->flashdata('segmento')); ?> selected>Todos</option>
                            <option value="Active Subscriptions" <?php echo set_select('segmento', 'Active Subscriptions', set_value('segmento') ? false : 'Active Subscriptions' == $this->session->flashdata('segmento')); ?>>Activos</option>
                            <option value="Inactive Subscriptions" <?php echo set_select('segmento', 'Inactive Subscriptions', set_value('segmento') ? false : 'Inactive Subscriptions' == $this->session->flashdata('segmento')); ?>>Inactivos</option>
                        </select>
                        <input type="hidden" class="form-control" name="id" id="id" value="" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-outline-grey" data-dismiss="modal"><i class="fa fa-times-circle"></i>&nbsp;Atrás</button>
                    <button type="submit" class="btn btn-outline-secondary"><i class="fa fa-check-circle"></i>&nbsp;Enviar</button>
                </div>
            </form>
        </div>
    </div>
</div>