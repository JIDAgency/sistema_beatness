<div class="app-content content center-layout mt-2">
    <div class="content-wrapper">
        
        <div class="content-header row">

            <div class="content-header-left col-md-6 col-12 mb-2">

                <h3 class="content-header-title mb-0"><?php echo $pagina_titulo; ?></h3>

                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo site_url('inicio'); ?>">Inicio</a></li>
                            <li class="breadcrumb-item active"><?php echo $pagina_titulo; ?></li>
                        </ol>
                    </div>
                </div>

            </div>

			<div class="content-header-right col-md-6 col-12 mb-2">

				<div class="media width-400 float-right">

					<div class="form-group">
						<!-- Outline button group with icons and text. -->
						<div class="btn-group" role="group" aria-label="Basic example">
							<a class="btn btn-outline-secondary" href="<?php echo site_url('codigos/agregar'); ?>"><i class="fa fa-plus-circle"></i>&nbsp;Agregar</a>
							<a class="btn btn-outline-secondary" href="<?php echo site_url('codigos'); ?>"><i class="fa fa-chevron-circle-right"></i>&nbsp;Atrás</a>
                            <div class="ml-2" id="buttons"></div>
						</div>
					</div>

                    <!--
					<media-left class="media-middle">
						<div id="sp-bar-total-sales"></div>
					</media-left>
					
					<div class="media-body media-right text-right">
						<h3 class="m-0">$5,668</h3><span class="text-muted">Sales</span>
					</div>
                    -->
					
				</div>

			</div>

        </div>

        <div class="content-body">
            <section id="section">

				<?php $this->load->view('_templates/mensajes_alerta.tpl.php');?>

                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-header">
                                <h4 class="card-title">Registro de <?php echo $pagina_titulo; ?></h4>
                            </div>

                            

                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard">
                                    <table class="table table-striped table-bordered" name="table" id="table">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Código</th>
                                                <th>Plan vinculado</th>
                                                <th>Configuración</th>
                                                <th>Usados</th>
                                                <th>Lote</th>
                                                <th>Nota</th>
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
