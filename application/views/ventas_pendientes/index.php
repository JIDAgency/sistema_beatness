<div class="app-content content center-layout">
    <div class="content-wrapper">
        <div class="content-header row px-1 my-1">

            <div class="content-header-left col-md-6 col-12">

                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo site_url('site/inicio'); ?>">Inicio</a></li>
                            <li class="breadcrumb-item active"><?php echo $pagina_titulo; ?></li>
                        </ol>
                    </div>
                </div>

            </div>

            <div class="content-header-right col-md-6 col-12">

                <div class="media float-right">

                    <div class="form-group float-md-right mr-1 mb-1">
                        <div id="buttons"></div>
                    </div>

                    <div class="form-group">
                        <div class="btn-group mr-1 mb-1">
                            <a class="btn btn-outline-secondary" href="<?php echo site_url('site/clientes/agregar'); ?>"><i class="fa fa-plus-circle"></i>&nbsp;Agregar</a>
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

                                    <div class="row mb-3">
                                        <div class="col-md-2">
                                            <label for="start_date">Fecha de inicio:</label>
                                            <input type="date" id="start_date" class="form-control">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="end_date">Fecha de fin:</label>
                                            <input type="date" id="end_date" class="form-control">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="cliente">Cliente:</label>
                                            <select name="cliente" id="cliente" class="select2 form-control" multiple="multiple"></select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="estatus">Estatus:</label>
                                            <select name="estatus" id="estatus" class="select2 form-control" multiple="multiple"></select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="sucursal">Sucursal:</label>
                                            <select name="sucursal" id="sucursal" class="select2 form-control" multiple="multiple"></select>
                                        </div>
                                        <div class="col-md-2 mt-2">
                                            <button id="filter_button" class="btn btn-secondary btn-min-width mr-1 mb-1">Filtrar</button>
                                        </div>
                                    </div>

                                    <div>
                                        <p name="mensaje_en_pantalla" id="mensaje_en_pantalla" class="mb-3"></p>
                                    </div>

                                    <div class="table-responsive">

                                        <table name="table" id="table" class="table table-white-space table-bordered row-grouping display no-wrap icheck table-middle">
                                            <thead>
                                                <tr>
                                                    <th>Opciones</th>
                                                    <th>ID</th>
                                                    <th>Estatus de validación</th>
                                                    <th>Concepto</th>
                                                    <th>VentaID</th>
                                                    <th>Método de Pago</th>
                                                    <th>Comprador</th>
                                                    <th>Categoría</th>
                                                    <th>Estatus</th>
                                                    <th>Costo</th>
                                                    <th>Cantidad</th>
                                                    <th>Total</th>
                                                    <th>Fecha de Venta</th>
                                                    <th>Usuario ID</th>
                                                    <th>Correo del Comprador</th>
                                                    <th>Nombre Completo del Comprador</th>
                                                    <th>Asignación ID</th>
                                                    <th>Asignación</th>
                                                    <th>Vigencia en Días</th>
                                                    <th>Clases del Plan</th>
                                                    <th>Sucursal</th>
                                                    <th>Vendedor</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Aquí irán las filas de datos -->
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

<div class="modal fade text-left" id="validarModal" tabindex="-1" role="dialog" aria-labelledby="validarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="validarModalLabel">Validar venta pendiente</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="validarForm">
                    <input type="hidden" id="venta_id" name="venta_id">
                    <div class="form-group">
                        <div class="row match-height">
                            <div class="col-xl-6 col-md-6 col-sm-12">
                                <p><b>Venta ID:</b></p>
                            </div>
                            <div class="col-xl-6 col-md-6 col-sm-12 text-right">
                                <p id="texto_id"></p>
                            </div>

                            <div class="col-xl-6 col-md-6 col-sm-12">
                                <p><b>Concepto:</b></p>
                            </div>
                            <div class="col-xl-6 col-md-6 col-sm-12 text-right">
                                <p id="texto_concepto"></p>
                            </div>

                            <div class="col-xl-6 col-md-6 col-sm-12">
                                <p><b>Comprador:</b></p>
                            </div>
                            <div class="col-xl-6 col-md-6 col-sm-12 text-right">
                                <p id="texto_comprador"></p>
                            </div>

                            <div class="col-xl-6 col-md-6 col-sm-12">
                                <p><b>Sucursal:</b></p>
                            </div>
                            <div class="col-xl-6 col-md-6 col-sm-12 text-right">
                                <p id="texto_sucursal"></p>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="precio_original">Precio original</label>
                        <input type="text" class="form-control" id="precio_original" name="precio_original" readonly>
                    </div>
                    <div class="form-group">
                        <label for="precio_modificado">Precio modificado</label>
                        <input type="text" class="form-control" id="precio_modificado" name="precio_modificado">
                    </div>
                    <div class="form-group">
                        <label>Modificar precio</label>
                        <br>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-outline-secondary">
                                <input type="radio" name="precio_opcion" id="precio_opcion2" autocomplete="off"> Bootcamp y Cycling Puebla $220.28
                            </label>
                            <label class="btn btn-outline-secondary">
                                <input type="radio" name="precio_opcion" id="precio_opcion1" autocomplete="off"> Cycling Polanco $200
                            </label>
                            <label class="btn btn-outline-secondary">
                                <input type="radio" name="precio_opcion" id="precio_opcion3" autocomplete="off"> Bootcamp Polanco $218.54
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Atrás</button>
                <button type="button" class="btn btn-secondary" id="guardarCambios">Guardar</button>
            </div>
        </div>
    </div>
</div>