<div class="app-content container center-layout mt-2">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo site_url('inicio'); ?>">Inicio</a></li>
                            <li class="breadcrumb-item active">Clases en línea</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-body">
            <!-- card actions section start -->
            <section id="configuration">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="content-header row mb-2">
                                    <div class="content-header-left col-md-6 col-12">
                                        <h4 class="card-title">Administrar clases en línea</h4>
                                    </div>
                                    <div class="content-header-right col-md-6 col-12">
                                        <div class="form-group float-md-right">
                                            <div class="btn-group mr-1 mb-1">
                                                <a href="<?php echo site_url('clases/nueva_clase_streaming') ?>" class="btn btn-secondary"><i class="icon-note"></i> Nueva</a>
                                                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="<?php echo site_url('clases/nueva_clase_streaming') ?>">Nueva clase en línea</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard">

                                    <?php $this->load->view('_comun/mensajes_alerta'); ?>

                                    <div class="table-responsive">

                                        <table id="tabla-clases-streaming" class="table display nowrap table-striped table-bordered scroll-horizontal table-hover">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Identificador</th>
                                                    <th>Disciplina</th>
                                                    <th>Temática</th>
                                                    <th>Instructor</th>
                                                    <th>F. de clase</th>
                                                    <th>Estatus</th>
                                                    <th>Opciones</th>
                                                    <th>Descripción</th>
                                                    <th>Preview</th>
                                                    <th>Video</th>
                                                    <th>Duración</th>
                                                    <th>Vistas</th>
                                                    <th>Fecha de registro</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Identificador</th>
                                                    <th>Disciplina</th>
                                                    <th>Temática</th>
                                                    <th>Instructor</th>
                                                    <th>F. de clase</th>
                                                    <th>Estatus</th>
                                                    <th>Opciones</th>
                                                    <th>Descripción</th>
                                                    <th>Preview</th>
                                                    <th>Video</th>
                                                    <th>Duración</th>
                                                    <th>Vistas</th>
                                                    <th>Fecha de registro</th>

                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- // card-actions section end -->
        </div>
    </div>
</div>
