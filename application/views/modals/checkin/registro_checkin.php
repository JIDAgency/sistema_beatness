<!-- Modal -->
<div class="modal fade text-left" id="modal_registrar_checkin" tabindex="-1" role="dialog" aria-labelledby="seccion_registrar_clase" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modal-title text-text-bold-600" id="seccion_registrar_clase">Registrar checkin</label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="form_registrar_clase" action="<?php echo site_url('checkin/rigistrar_checkin'); ?>">
                <div class="modal-body">
                    <div class="row match-height">
                        <div class="col-lg-5 col-md-5 col-sm-12 este">
                            <!-- Contenedor de clases estilo tabs -->
                            <ul id="disciplinas" class="list-group"></ul>
                        </div>
                        <div class="col-lg-7 col-md-7 col-sm-12">
                            <!-- Contenedor para mostrar detalles de la clase seleccionada -->
                            <div id="claseDetalles" class="text-center">
                                <p>Selecciona una clase para ver los detalles.</p>
                            </div>

                            <div class="modal-footer">
                                <button type="reset" class="btn btn-outline-grey" data-dismiss="modal"><i class="fa fa-times-circle"></i>&nbsp;Atrás</button>
                                <button type="submit" class="btn btn-outline-secondary"><i class="fa fa-check-circle"></i>&nbsp;Registrar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>  