<div class="app-content content center-layout mt-2">
	<div class="content-wrapper">

		<!-- ============================================================
             CATEGORÍA: BARRA DE NAVEGACIÓN Y BREADCRUMB DE LA PÁGINA
        ============================================================= -->
		<div class="content-header row">
			<div class="content-header-left col-md-6 col-12 mb-2">
				<div class="row breadcrumbs-top">
					<div class="breadcrumb-wrapper col-12">
						<ol class="breadcrumb">
							<!-- Ruta de navegación -->
							<li class="breadcrumb-item"><a href="<?php echo site_url('inicio') ?>">Inicio</a></li>
							<li class="breadcrumb-item active">Clientes</li>
						</ol>
					</div>
				</div>
			</div>

			<!-- ============================================================
			CATEGORÍA: OPCIONES DE LA PÁGINA (BOTONES Y FILTROS)
			============================================================= -->
			<div class="content-header-right col-md-6 col-12">
				<!-- Grupo de botones en línea, todos con el mismo estilo outline -->
				<div class="btn-group float-md-right" role="group" aria-label="Opciones">
					<!-- Botón Nuevo Cliente -->
					<a href="<?php echo site_url('clientes/crear') ?>" class="btn btn-outline-secondary">
						<i class="ft-plus-circle icon-left"></i> Nuevo Cliente
					</a>

					<!-- Botón Nueva Clase -->
					<a href="<?php echo site_url('clases/crear') ?>" class="btn btn-outline-secondary">
						<i class="ft-plus-circle icon-left"></i> Nueva Clase
					</a>

					<!-- Botón Nueva Venta -->
					<a href="<?php echo site_url('ventas/crear') ?>" class="btn btn-outline-secondary">
						<i class="ft-plus-circle icon-left"></i> Nueva Venta
					</a>

					<!-- Botón Nueva Venta Personalizada -->
					<a href="<?php echo site_url('ventas/crear_personalizada') ?>" class="btn btn-outline-secondary">
						<i class="ft-plus-circle icon-left"></i> Nueva Venta Personalizada
					</a>
				</div>

				<!-- Contenedor para otros botones de funcionalidad (ej. exportar a Excel) -->
				<div class="form-group float-md-right">
					<div id="buttons" class="mr-1 mb-1"></div>
				</div>
			</div>
		</div>

		<!-- ============================================================
             CATEGORÍA: CONTENIDO PRINCIPAL (TABLA DE CLIENTES)
        ============================================================= -->
		<div class="content-body">
			<section>
				<div class="row">
					<div class="col-12">
						<div class="card no-border">
							<div class="card-header">
								<h4 class="card-title">Lista de clientes</h4>
								<div class="card-content p_dt">
									<div class="card-body">

										<!-- ============================================================
                                             CATEGORÍA: MENSAJES DE ALERTA (ERROR, EXITO, ETC.)
                                        ============================================================= -->
										<?php $this->load->view('_comun/mensajes_alerta'); ?>
										<?php $i = 1; ?>

										<!-- Mostrar validaciones de CodeIgniter -->
										<?php if (validation_errors()) : ?>
											<div class="alert bg-danger alert-icon-left alert-dismissible mb-2 font-small-3" role="alert">
												<span class="alert-icon"><i class="fa fa-thumbs-o-down"></i></span>
												<button type="button" class="close" data-dismiss="alert" aria-label="Close">
													<span aria-hidden="true">×</span>
												</button>
												<?php echo validation_errors(); ?>
											</div>
										<?php endif ?>

										<!-- Div para mostrar mensajes generados vía JS -->
										<div name="mensaje-js" id="mensaje-js"></div>

										<!-- ============================================================
                                             CATEGORÍA: TABLA DE CLIENTES
                                             Esta tabla se completa mediante AJAX y DataTables
                                        ============================================================= -->
										<table id="table" class="table display nowrap table-striped table-bordered scroll-horizontal table-hover" cellspacing="0">
											<thead>
												<tr>
													<th>Opciones</th>
													<th>ID</th>
													<th>Nombre completo</th>
													<th>Correo electrónico</th>
													<th>Teléfono</th>
													<th>Sucursal Favorita</th>
													<th>Fecha de registro</th>
													<th>Estudiante</th>
													<th>Vigencia de estudiante</th>
													<th>Pertenece a una empresa</th>
													<th>Registrado por</th>
													<th>Estatus</th>
												</tr>
											</thead>
											<tbody>
												<!-- El cuerpo de la tabla se llena con DataTables vía AJAX -->
											</tbody>
										</table>
										<!-- Fin de la tabla -->
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		<!-- Fin del content-body -->
	</div>
</div>