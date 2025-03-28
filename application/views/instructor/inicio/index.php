<div class="app-content content center-layout mt-2">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">Inicio</li>
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
                                <h4 class="card-title">Calendario de clases</h4>
                            </div>
                            <div class="card-content p_dt">
                                <div class="card-body">
                                    <?php $this->load->view('_comun/mensajes_alerta'); ?>
                                    <!-- Tabla sin cuerpo: DataTables la cargará vía AJAX -->
                                    <table id="tabla" class="table display nowrap table-striped table-bordered scroll-horizontal table-hover">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Estatus</th>
                                                <th>Disciplina</th>
                                                <th>Dificultad</th>
                                                <th>Fecha</th>
                                                <th>Horario</th>
                                                <th>Cupos</th>
                                                <th>Reservaciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>