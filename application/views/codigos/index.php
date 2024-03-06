<?php $this->load->view('modals/notas'); ?>

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
							<a class="btn btn-outline-secondary" href="<?php echo site_url('codigos/lista'); ?>"><i class="fa fa-chevron-circle-left"></i>&nbsp;Lista</a>
						</div>
					</div>
					
				</div>

			</div>

        </div>

        <div class="content-body">
            <section id="section">

				<?php $this->load->view('_templates/mensajes_alerta.tpl.php');?>

                <div class="row">
                    <div class="col-12">
                        <div class="card no-border">

                            <div class="card-header">
                                <h4 class="card-title">Registro de <?php echo $pagina_titulo; ?></h4>
                            </div>

                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard">

                                    <div class="row">

                                        <?php $order = 1; foreach ($codigos_list->result() as $codigo_row): ?>
                                            <?php $cont = 0; ?>
                                            <?php foreach ($codigos_canejados_list->result() as $codigo_canjeado_row): ?>
                                                <?php if ($codigo_canjeado_row->codigo == $codigo_row->codigo):?>
                                                    <?php $cont = $cont + 1; ?>
                                                <?php endif; ?>
                                            <?php endforeach; ?>

                                            <div class="col-xl-3 col-lg-12">

                                                <?php echo $order; ?>
                                                
                                                <div class="card text-center">
                                                    <div class="card-content">
                                                        <div class="chart-title mb-1">
                                                            <h2><b><?php echo strtoupper($codigo_row->codigo); ?></b></h2>
                                                            <span class="text-muted">Configuración: <b><?php echo strtoupper($codigo_row->tipo); ?></b></span>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer">
                                                        <ul class="list-inline clearfix">
                                                            <li class="mr-2"><span class="text-muted">Usado</span><h2 class="block"><?php echo $cont; ?></h2></li>
                                                            <li class="mr-2"><span class="text-muted">Lote</span><h2 class="block"><?php echo $codigo_row->lote ? $codigo_row->lote : 'N/A'; ?></h2></li>
                                                            <li class="mr-2"><a href="javascript:cargar_modal_nota(<?php echo '\''.mb_strtoupper($codigo_row->codigo).'\''; ?>, <?php echo '\''.$codigo_row->identificador.'\''; ?>, <?php echo '\''.$codigo_row->nota.'\''; ?>);"><h1 class="info"><i class="fa fa-edit"></i></h1></a></li>
                                                            <li><a href="<?php echo site_url('codigos/eliminar/'.$codigo_row->identificador); ?>"><h1 class="info"><i class="fa fa-trash"></i></h1></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php $order++; ?>
                                        <?php endforeach; ?>

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
