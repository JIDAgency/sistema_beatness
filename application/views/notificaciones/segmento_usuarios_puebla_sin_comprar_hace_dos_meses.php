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

                    <div class="form-group">
                        <div class="btn-group mr-1 mb-1">
                            <button type="button" class="btn btn-outline-secondary btn-min-width dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-plus-circle"></i>&nbsp;Agregar</button>
                            <div class="dropdown-menu">
                                <?php echo $menu_servicios; ?>
                            </div>
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
                        <div class="card">

                            <div class="card-header">
                                <h4 class="card-title">Registro de <?php echo $pagina_titulo; ?></h4>
                            </div>

                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard">

                                    <div class="row">

                                        <div class="col-xl-6 col-md-6 col-sm-12">

                                            <table class="table display nowrap table-striped table-bordered scroll-horizontal table-hover" name="table" id="table">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Correo electronico</th>
                                                        <th>Nombre</th>
                                                        <!-- <th>Vence</th> -->
                                                        <th>Sucursal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($lista_usuarios_que_no_han_comprado_los_ultimos_dos_meses as $usuario_key => $usuario_row) : ?>
                                                        
                                                        <tr>
                                                            <td><?php echo $usuario_row->id; ?></td>
                                                            <td><?php echo $usuario_row->correo; ?></td>
                                                            <td><?php echo $usuario_row->usuarios_nombre; ?></td>
                                                            <!-- <td><?php echo $usuario_row->correo; ?></td> -->
                                                            <td><?php echo $usuario_row->nombre_sucursal; ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>

                                        </div>

                                        <div class="col-xl-6 col-md-6 col-sm-12">
                                            <?php echo form_open(uri_string(), array('class' => 'needs-validation p-2', 'id' => 'form', 'novalidate' => '', 'method' => 'post')); ?>

                                            <div class="row match-height">
                                                <div class="col-xl-12 col-md-12 col-sm-12">

                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label class="col-lg-12" for="titulo"><b>Título&nbsp;</b><span class="red">*</span></label>
                                                            <div class="col-lg-12">
                                                                <input type="text" class="form-control" name="titulo" id="titulo" placeholder="Título" value="<?php echo set_value('titulo') == false ? $this->session->flashdata('titulo') : set_value('titulo'); ?>" required>
                                                                <div class="invalid-feedback">
                                                                    Se requiere una título válido.
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label class="col-lg-12" for="mensaje"><b>Mensaje&nbsp;</b><span class="red">*</span></label>
                                                            <div class="col-lg-12">
                                                                <textarea class="form-control" name="mensaje" id="mensaje" rows="8" maxlength="240" placeholder="Mensaje en un máximo de 240 caracteres" required><?php echo set_value('mensaje') == false ? $this->session->flashdata('mensaje') : set_value('mensaje'); ?></textarea>
                                                                <div class="invalid-feedback">
                                                                    Se requiere una mensaje válido.
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12 media-right float-right text-right">
                                                                <small class="text-muted" name="mensaje-count" id="mensaje-count">0/240</small>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="row match-height mt-2">
                                                <div class="col-12">
                                                    <!--div class="form-group float-md-left">
                                                        </div-->
                                                    <div class="form-group float-md-right">
                                                        <a class="btn btn-outline-grey btn-outline-lighten-1 btn-min-width mr-1" href="<?php echo site_url($regresar_a); ?>"><i class="fa fa-times-circle"></i>&nbsp;Atrás</a>
                                                        <button type="button" class="btn btn-outline-secondary btn-min-width mr-1" id="guardar-btn" data-toggle="modal" data-target="#confirmarModal"><i class="fa fa-play-circle"></i>&nbsp;Continuar</button>
                                                        <button type="submit" class="btn btn-outline-info btn-min-width mr-1" id="submit-btn" style="display: none;"><i class="fa fa-check-circle"></i>&nbsp;Enviar</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php echo form_close(); ?>
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

<!-- Modal de confirmación -->
<div class="modal fade" id="confirmarModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">¿Estás seguro de querer continuar con el envío de está notificación?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Si está seguro de querer continuar haga clic en “Si” y, luego en ”Enviar”.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-lighten-1" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-secondary" id="enviar-btn" data-dismiss="modal">Si</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('enviar-btn').addEventListener('click', function() {
        document.getElementById('submit-btn').style.display = 'inline-block';
        document.getElementById('guardar-btn').style.display = 'none';
    });
</script>