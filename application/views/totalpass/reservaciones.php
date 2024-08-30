<div class="app-content content center-layout">
    <div class="content-wrapper">
        <div class="content-header row px-1 my-1">

            <div class="content-header-left col-md-6 col-12">

                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo site_url('inicio'); ?>">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo site_url('totalpass'); ?>">TotalPass</a></li>
                            <li class="breadcrumb-item active"><?php echo $pagina_titulo; ?></li>
                        </ol>
                    </div>
                </div>

            </div>

            <div class="content-header-right col-md-6 col-12">

                <div class="media float-right">

                    <div class="form-group">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a class="btn btn-outline-grey btn-outline-lighten-1 btn-min-width" href="<?php echo site_url($regresar_a); ?>"><i class="fa fa-arrow-circle-left"></i>&nbsp;Volver</a>
                            <a class="btn btn-outline-secondary btn-min-width mr-1" href="<?php echo site_url('totalpass/disciplinas'); ?>">Disciplinas</a>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <div class="content-body">
            <section id="section">

                <?php $this->load->view('_templates/mensajes_alerta.tpl.php'); ?>

                <div class="row">
                    <div class="col-12">
                        <div class="card no-border">

                            <div class="card-header">
                                <h4 class="card-title"><?php echo $pagina_subtitulo; ?></h4>
                            </div>

                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard">

                                    <p name="mensaje_en_pantalla" id="mensaje_en_pantalla"></p>

                                    <div class="row match-height">
                                        <div class="col-xl-12 col-md-12 col-sm-12">

                                            <table name="table" id="table" class="table display nowrap table-striped table-bordered scroll-horizontal table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Clase reservada</th>
                                                        <th>ID + Plan usado</th>
                                                        <th>ID + Cliente</th>
                                                        <th>Disciplina</th>
                                                        <th>Lugar</th>
                                                        <th>Fecha de clase</th>
                                                        <th>Fecha de reservación</th>
                                                        <th>Asistencia</th>
                                                        <th>Estatus</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($reservaciones_list as $key => $reservacion) : ?>
                                                        <tr>
                                                            <th scope="row">
                                                                <?php echo $reservacion->id ?>
                                                            </th>
                                                            <td>
                                                                <?php echo $reservacion->clase ?>-<?php echo $reservacion->usuario_id ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $reservacion->asignaciones_id ?> - <?php echo $reservacion->asignaciones_nombre ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $reservacion->usuario_id ?> -- <?php echo $reservacion->cliente_nombre ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $reservacion->disciplina ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $reservacion->no_lugar ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $reservacion->horario ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $reservacion->fecha_creacion ?>
                                                            </td>
                                                            <td>
                                                                <?php echo ucfirst($reservacion->asistencia) ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $reservacion->estatus ?>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <div class="form-group float-md-right">
                                                <a class="btn btn-outline-grey btn-outline-lighten-1 btn-min-width mr-1" href="<?php echo site_url($regresar_a); ?>"><i class="fa fa-arrow-circle-left"></i>&nbsp;Volver</a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </section>
        </div>

    </div>
</div>