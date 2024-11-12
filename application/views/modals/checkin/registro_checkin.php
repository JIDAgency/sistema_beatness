<!-- Modal -->

<style>
    .modal-content {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .modal-body {
        flex: 1 1 auto;
        overflow-y: auto;
    }

    .modal-footer {
        flex-shrink: 0;
    }
</style>
<div class="modal fade text-left" id="modal_registrar_checkin" tabindex="-1" role="dialog" aria-labelledby="seccion_registrar_clase" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content d-flex flex-column">
            <div class="modal-header">
                <label class="modal-title text-text-bold-600" id="seccion_registrar_clase">Registrar clase a la que asistió por Checkin</label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="form_registrar_clase" action="<?php echo site_url('checkin/rigistrar_checkin'); ?>">
                <div class="modal-body">
                    <div class="row match-height">
                        <div class="col-lg-6 col-md-6 col-sm-12 este">
                            <input type="search" name="buscador_clase" id="buscador_clase" placeholder="Buscar clase..." class="form-control mb-2">
                            <ul name="disciplinas" id="disciplinas" class="list-group"></ul>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div name="detalles_contenedor" id="detalles_contenedor" class="text-justify">
                                <p>Selecciona una clase para ver los detalles.</p>
                            </div>
                        </div>
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