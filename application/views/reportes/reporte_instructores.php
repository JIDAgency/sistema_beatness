<div class="app-content content center-layout mt-2">
    <div class="content-wrapper">

        <div class="content-header row">

            <div class="content-header-left col-md-6 col-12 mb-2">

                <h3 class="content-header-title mb-0"><?php echo $pagina_titulo; ?></h3>

                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo site_url('site/inicio'); ?>">Inicio</a></li>
                            <li class="breadcrumb-item active"><?php echo $pagina_titulo; ?></li>
                        </ol>
                    </div>
                </div>

            </div>

            <div class="content-header-right col-md-6 col-12 mb-2">

                <div class="media float-right">

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

                                    <div class="row match-height">
                                        <div class="col-xl-3 col-md-3 col-sm-12 mt-2 mb-2">
                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-12"><i class="ft-filter"></i> Periodo a consultar:</label>
                                                    <div class="col-lg-12">
                                                        <select id="mes_a_consultar" name="mes_a_consultar" class="select2 form-control">

                                                            <?php foreach ($periodo as $periodo_mensual_row) : ?>
                                                                <?php
                                                                $date = DateTime::createFromFormat("Y-m", $periodo_mensual_row->format("Y-m"));
                                                                ?>
                                                                <option value="<?php echo $periodo_mensual_row->format("Y-m"); ?>" <?php echo set_select('mes_a_consultar', $periodo_mensual_row->format("Y-m"), set_value('mes_a_consultar') ? false : $periodo_mensual_row->format("Y-m") == date('Y-m')); ?>><?php echo ucfirst(strftime("%B de %Y", $date->getTimestamp())); ?></option>
                                                            <?php endforeach; ?>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <h4 class="form-section"><i class="ft-calendar"></i> Mensual</h4>
                                    <hr>
                                    <table class="table table-striped table-bordered" name="table" id="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Instructor</th>
                                                <th>Clases impartidas</th>
                                                <th>Cupos reservados</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <br><br>
                                    <div class="row">
                                        <div class="col-6">
                                            <h4 class="form-section"><i class="ft-calendar"></i> Primera quincena</h4>
                                            <hr>
                                            <table class="table table-striped table-bordered" name="table_primera_quincena" id="table_primera_quincena">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Instructor</th>
                                                        <th>Clases impartidas</th>
                                                        <th>Cupos reservados</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="col-6">
                                            <h4 class="form-section"><i class="ft-calendar"></i> Segunda quincena</h4>
                                            <hr>
                                            <table class="table table-striped table-bordered" name="table_segunda_quincena" id="table_segunda_quincena">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Instructor</th>
                                                        <th>Clases impartidas</th>
                                                        <th>Cupos reservados</th>
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
                    </div>
                </div>

            </section>
        </div>

    </div>
</div>