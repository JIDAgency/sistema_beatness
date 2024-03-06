<div class="app-content container center-layout mt-2">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo site_url('inicio'); ?>">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo site_url('clases/index_clases_en_linea'); ?>">Clases en línea</a></li>
                            <li class="breadcrumb-item active">Editar</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-body">
            <!-- Bootstrap Checkout form -->
            <section id="social-cards">
                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-header">
                                <div class="content-header row">
                                    <div class="content-header-left col-md-6 col-12 mb-2">
                                        <h4 class="card-title">Editar una clase en línea</h4>
                                    </div>
                                </div>
                            </div>

                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard">

                                    <?php echo form_open($controlador, array('class' => 'form form-horizontal needs-validation', 'id' => 'forma-editar-clase-streaming', 'novalidate' => '')); ?>
                                            
                                        <?php if (validation_errors()): ?>
                                            <div class="alert bg-danger alert-icon-left alert-dismissible mb-2 font-small-3" role="alert">
                                                <span class="alert-icon"><i class="fa fa-thumbs-o-down"></i></span>
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                                <?php echo validation_errors(); ?>
                                            </div>
										<?php endif?>

                                        <h4 class="text-muted">Formulario de datos de la clase en línea<hr class="mb-2"></h4>

                                        <div class="row">

                                            <div class="col-md-6 mb-3">

                                                <div class="row">
                                                    <div class="col-md-12 mb-3">
                                                        <label for="identificador">Identificador de la clase en línea <span class="red">*</span></label>
                                                        <input type="text" class="form-control" name="identificador" id="identificador" placeholder="Identificador" value="<?php echo set_value('identificador') == false ? $clase_a_editar->identificador : set_value('identificador'); ?>" required="">
                                                        <div class="invalid-feedback">
                                                            Se requiere un identificador de la clase en línea válido.
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12 mb-3">
                                                        <label for="descripcion">Descripción del video <span class="red">*</span></label>
                                                        <input type="text" class="form-control" name="descripcion" id="descripcion" placeholder="Descripción" value="<?php echo set_value('descripcion') == false ? $clase_a_editar->descripcion : set_value('descripcion'); ?>" required="">
                                                        <input type="hidden" class="form-control" name="id" id="id" placeholder="ID" value="<?php echo set_value('id') == false ? $clase_a_editar->id : set_value('id'); ?>" required="">
                                                        <div class="invalid-feedback">
                                                            Se requiere un descripción del video.
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12 mb-3">
                                                        <label for="url_video">Url del video <span class="red">*</span></label>
                                                        <textarea class="form-control" name="url_video" id="url_video" rows="5" placeholder="Url del video" required=""><?php echo set_value('url_video') == false ? $clase_a_editar->url_video : set_value('url_video'); ?></textarea>
                                                        <div class="invalid-feedback">
                                                            Se requiere un url del video válido.
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12 mb-3">
                                                        <label for="url_preview">Nombre de imagen de previsualización <span class="red">*</span></label>
                                                        <input type="text" class="form-control" name="url_preview" id="url_preview" placeholder="Nombre del archivo de imagen" value="<?php echo set_value('url_preview') == false ? $clase_a_editar->url_preview : set_value('url_preview'); ?>" required="">
                                                        <div class="invalid-feedback">
                                                            Se requiere un nombre del archivo de imagen válida.
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-12 mb-3">
                                                        <label for="tematica">Temática de clase <span class="red">*</span></label>
                                                        <select class="custom-select d-block w-100 select2" name="tematica" id="tematica" required="">
                                                            <option value="" <?php echo set_select('tematica', '', set_value('tematica') ? false : '' == $clase_a_editar->tematica); ?>>Seleccione una temática de clase...</option>
															<option value="Outdoor Ride" <?php echo set_select('tematica', 'Outdoor Ride', set_value('tematica') ? false : 'Outdoor Ride' == $clase_a_editar->tematica); ?>>Outdoor Ride</option>
															<option value="Theme Ride" <?php echo set_select('tematica', 'Theme Ride', set_value('tematica') ? false : 'Theme Ride' == $clase_a_editar->tematica); ?>>Theme Ride</option>
															<option value="Double Ride" <?php echo set_select('tematica', 'Double Ride', set_value('tematica') ? false : 'Double Ride' == $clase_a_editar->tematica); ?>>Double Ride</option>
															<option value="Upper Body" <?php echo set_select('tematica', 'Upper Body', set_value('tematica') ? false : 'Upper Body' == $clase_a_editar->tematica); ?>>Upper Body</option>
															<option value="Lower Body" <?php echo set_select('tematica', 'Lower Body', set_value('tematica') ? false : 'Lower Body' == $clase_a_editar->tematica); ?>>Lower Body</option>
															<option value="Full Body" <?php echo set_select('tematica', 'Full Body', set_value('tematica') ? false : 'Full Body' == $clase_a_editar->tematica); ?>>Full Body</option>
															<option value="Pierna/Glúteo" <?php echo set_select('tematica', 'Pierna/Glúteo', set_value('tematica') ? false : 'Pierna/Glúteo' == $clase_a_editar->tematica); ?>>Pierna/Glúteo</option>
															<option value="Pecho/Espalda" <?php echo set_select('tematica', 'Pecho/Espalda', set_value('tematica') ? false : 'Pecho/Espalda' == $clase_a_editar->tematica); ?>>Pecho/Espalda</option>
															<option value="Pierna/Glúteo+Abs" <?php echo set_select('tematica', 'Pierna/Glúteo+Abs', set_value('tematica') ? false : 'Pierna/Glúteo+Abs' == $clase_a_editar->tematica); ?>>Pierna/Glúteo+Abs</option>
															<option value="Hombro/Bíceps" <?php echo set_select('tematica', 'Hombro/Bíceps', set_value('tematica') ? false : 'Hombro/Bíceps' == $clase_a_editar->tematica); ?>>Hombro/Bíceps</option>
															<option value="High Performance" <?php echo set_select('tematica', 'High Performance', set_value('tematica') ? false : 'High Performance' == $clase_a_editar->tematica); ?>>High Performance</option>
															<option value="Ball" <?php echo set_select('tematica', 'Ball', set_value('tematica') ? false : 'Ball' == $clase_a_editar->tematica); ?>>Ball</option>
															<option value="Stick" <?php echo set_select('tematica', 'Stick', set_value('tematica') ? false : 'Stick' == $clase_a_editar->tematica); ?>>Stick</option>
															<option value="Resistance Bands" <?php echo set_select('tematica', 'Resistance Bands', set_value('tematica') ? false : 'Resistance Bands' == $clase_a_editar->tematica); ?>>Resistance Bands</option>
															<option value="All in One" <?php echo set_select('tematica', 'All in One', set_value('tematica') ? false : 'All in One' == $clase_a_editar->tematica); ?>>All in One</option>
															<option value="Básico" <?php echo set_select('tematica', 'Básico', set_value('tematica') ? false : 'Básico' == $clase_a_editar->tematica); ?>>Básico</option>
															<option value="Intermedio" <?php echo set_select('tematica', 'Intermedio', set_value('tematica') ? false : 'Intermedio' == $clase_a_editar->tematica); ?>>Intermedio</option>
															<option value="Avanzado" <?php echo set_select('tematica', 'Avanzado', set_value('tematica') ? false : 'Avanzado' == $clase_a_editar->tematica); ?>>Avanzado</option>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            Por favor seleccione una tematica temática de clase válida.
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12 mb-3">
                                                        <label for="disciplina_id">Disciplina de la clase <span class="red">*</span></label>
                                                        <select class="custom-select d-block w-100 select2" name="disciplina_id" id="disciplina_id" required="">
                                                            <option value="" <?php echo set_select('disciplina_id', ""); ?>>Seleccione un instructor de clase...</option>
                                                            <?php foreach ($disciplinas_list as $disciplina_row): ?>
                                                                <option value="<?php echo $disciplina_row->id; ?>" <?php echo set_select('disciplina_id', $disciplina_row->id, set_value('disciplina_id') ? false : $disciplina_row->id == $clase_a_editar->disciplina_id); ?>>
																	<?php echo $disciplina_row->id .' | '. $disciplina_row->nombre; ?>
																</option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            Se requiere una disciplina de la clase válido.
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12 mb-3">
                                                        <label for="instructor_id">Instructor de la clase <span class="red">*</span></label>
                                                        <select class="custom-select d-block w-100 select2" name="instructor_id" id="instructor_id" required="">
                                                            <option value="" <?php echo set_select('instructor_id', ""); ?>>Seleccione un instructor de clase...</option>
                                                            <?php foreach ($instructores_list as $instructor_row): ?>
                                                                <option value="<?php echo $instructor_row->id; ?>" <?php echo set_select('instructor_id', $instructor_row->id, set_value('instructor_id') ? false : $instructor_row->id == $clase_a_editar->instructor_id); ?>>
																	<?php echo $instructor_row->id .' | '. $instructor_row->nombre_completo .' '. $instructor_row->apellido_paterno.' '. $instructor_row->apellido_materno; ?>
																</option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            Se requiere una instructor de la clase válido.
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12 mb-3">
                                                        <label for="duracion">Duración de la clase <small class="text-muted">(En minutos)</small><span class="red">*</span></label>
                                                        <input type="text" class="form-control" name="duracion" id="duracion" placeholder="Duración" value="<?php echo set_value('duracion') == false ? $clase_a_editar->duracion : set_value('duracion'); ?>" required="">
                                                        <div class="invalid-feedback">
                                                            Se requiere una duración de la clase válida.
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12 mb-3">
                                                        <label for="fecha_transmision">Fecha de la clase <span class="red">*</span></label>
                                                        <input type="date" class="form-control" name="fecha_transmision" id="fecha_transmision" placeholder="Fecha" value="<?php echo set_value('fecha_transmision') == false ? date('Y-m-d', strtotime($clase_a_editar->fecha_clase)) : set_value('fecha_transmision'); ?>" required="">
                                                        <div class="invalid-feedback">
                                                            Se requiere una fecha de la clase válido.
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12 mb-3">
                                                        <label for="estatus">Estatus del portafolio <span class="red">*</span></label>
                                                        <select class="custom-select d-block w-100 select2" name="estatus" id="estatus" required="">
                                                            <option value="" <?php echo set_select('estatus', '', set_value('estatus') ? false : '' == $clase_a_editar->estatus); ?>>Seleccione un estatus de portafolio...</option>
                                                            <option value="activo" <?php echo set_select('estatus', 'activo', set_value('estatus') ? false : 'activo' == $clase_a_editar->estatus); ?>>Activo</option>
                                                            <option value="suspendido" <?php echo set_select('estatus', 'suspendido', set_value('suspendido') ? false : 'suspendido' == $clase_a_editar->estatus); ?>>Suspendido</option>
                                                            <option value="cancelado" <?php echo set_select('estatus', 'cancelado', set_value('estatus') ? false : 'cancelado' == $clase_a_editar->estatus); ?>>Cancelado</option>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            Por favor seleccione un estatus de portafolio válido.
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <div class="row">
                                                    <div class="col-md-12 mb-1">
                                                        <h5>Video preview:</h5>
                                                        <div class="text-center pb-3">
                                                            <iframe src="<?php echo $clase_a_editar->url_video; ?>" width="100%" height="200" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-12 mb-1">
                                                        <h5>Imagen preview:</h5>
                                                        <div class="text-center">
                                                            <img class="img-fluid" src="<?php echo site_url('subidas/b3-clases-online-portadas/portadas-clases/'.$clase_a_editar->url_preview); ?>" alt="B3 Class Preview..." width="200px" class="img-fluid">
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-12 mb-1">
                                                        <h5>Vistas: <span class="text-muted"><i class="icon-eye"></i> <?php echo $clase_a_editar->reservados; ?></span></h5>
                                                        
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-12 mb-1">
                                                        <h5>Visto por:</h5>
                                                        <small><p class="text-muted">
                                                            <?php 
                                                                foreach (json_decode($clase_a_editar->cupo_lugares) as $key) {
                                                                    echo '- '.$key->nombre_usuario.' #'.$key->id_usuario.'<br>';
                                                                }
                                                            ?>
                                                        </p></small>
                                                    </div>
                                                </div>
                                            </div>                                            
                                        </div>
                                        
                                        <div class="form-actions right">
                                            <a href="<?php echo site_url($regresar_a); ?>" class="btn btn-secondary btn-sm">Atras</a>
                                            <button type="submit" class="btn btn-secondary btn-sm">Guardar</button>
                                        </div>

                                    <?php echo form_close(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- // Bootstrap Checkout form end -->

        </div>
    </div>
</div>
