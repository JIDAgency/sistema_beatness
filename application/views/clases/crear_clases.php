<div class="app-content container center-layout mt-2">

	<div class="content-header-left col-md-6 col-12 mb-2">
		<div class="row breadcrumbs-top">
			<div class="breadcrumb-wrapper col-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo site_url('inicio/index') ?>">Inicio</a>
					</li>
					<li class="breadcrumb-item"><a href="<?php echo site_url('clases/index') ?>">Clases</a>
					</li>
					<li class="breadcrumb-item active">Crear nuevas clases
					</li>
				</ol>
			</div>
		</div>
	</div>

	<div class="content-wrapper">
		<div class="content-body">
			<section>
				<div class="row">
					<div class="col-12">
						<div class="card">

							<div class="card-header">
								<h4 class="card-title">Nuevas clases</h4>
							</div>

							<div class="card-content">
								<div class="card-body">
									<?php echo form_open('clases/crear_clases', array('class' => 'form form-horizontal', 'id' => 'forma-crear-clases')); ?>

                                        <div class="form-body">

                                            <?php if (validation_errors()): ?>
                                                <div class="alert bg-danger alert-icon-left alert-dismissible mb-2 font-small-3" role="alert">
                                                    <span class="alert-icon"><i class="fa fa-thumbs-o-down"></i></span>
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                    <?php echo validation_errors(); ?>
                                                </div>
                                            <?php endif?>

                                            <h4 class="form-section">#1 Datos de clase</h4>

                                            <div class="row">

                                                <div class="col-md-4">
                                                    <label for="identificador1" class="col-md-12 label-control"><span class="red">*</span> Identificador de clase</label>
                                                    <div class="form-group row">
                                                        <div class="col-md-12">
                                                            <input type="text" name="identificador1" id="identificador1" class="form-control" placeholder="ID" value="<?php echo set_value('identificador1'); ?>" readonly="true">
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row">

                                                <div class="col-md-4">
                                                    <label for="disciplina_id1" class="col-md-12 label-control"><span class="red">*</span> Disciplina de clase</label>
                                                    <div class="form-group row">
                                                        <div class="col-md-12">
                                                            <select name="disciplina_id1" id="disciplina_id1" class="form-control">
                                                                <option value="">Seleccione una disciplina…</option>
                                                                <?php foreach ($disciplinas->result() as $disciplina): ?>
                                                                    <?php if ($disciplina->id != 1): ?>
                                                                        <option value="<?php echo $disciplina->id; ?>" <?php echo set_select('disciplina_id1', $disciplina->id); ?>>
                                                                            <?php 
                                                                                if($disciplina->id == 5){
                                                                                    echo 'B. BIKE + '.$disciplina->nombre; 
                                                                                } elseif($disciplina->id == 6){
                                                                                    echo 'B. BOX + '.$disciplina->nombre; 
                                                                                } elseif($disciplina->id == 7){
                                                                                    echo 'B. BODY + '.$disciplina->nombre; 
                                                                                } else{
                                                                                    echo $disciplina->nombre; 
                                                                                }
                                                                            ?>
                                                                        </option>
                                                                    <?php endif;?>
                                                                <?php endforeach;?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="instructor_id1" class="col-md-12 label-control"><span class="red">*</span> Instructor de clase</label>
                                                    <div class="form-group row">
                                                        <div class="col-md-12">
                                                            <select name="instructor_id1" id="instructor_id1" class="form-control">
                                                                <option value="">Seleccione un instructor de clase…</option>
                                                                <?php foreach ($instructores->result() as $instructor): ?>
                                                                    <option value="<?php echo $instructor->id; ?>" <?php echo set_select('instructor_id1', $instructor->id); ?>>
                                                                        <?php echo $instructor->nombre_completo .' '. $instructor->apellido_paterno.' '. $instructor->apellido_materno; ?>
                                                                    </option>
                                                                <?php endforeach;?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="dificultad1" class="col-md-12 label-control"><span class="red">*</span> Dificultad de clase</label>
                                                    <div class="form-group row">
                                                        <div class="col-md-12">
                                                            <select name="dificultad1" id="dificultad1" class="form-control">
                                                                <option value="">Seleccione una dificultad…</option>
                                                                <option value="All in One">All in One</option>
                                                                <option value="Avanzado">Avanzado</option>
                                                                <option value="Ball">Ball</option>
                                                                <option value="Básico">Básico</option>
                                                                <option value="Double Ride">Double Ride</option>
                                                                <option value="Full Body">Full Body</option>
                                                                <option value="High Performance">High Performance</option>
                                                                <option value="Hombro/Bíceps">Hombro/Bíceps</option>
                                                                <option value="Intermedio">Intermedio</option>
                                                                <option value="Lower Body">Lower Body</option>
                                                                <option value="Outdoor Ride">Outdoor Ride</option>
                                                                <option value="Pecho/Espalda">Pecho/Espalda</option>
                                                                <option value="Pierna/Glúteo">Pierna/Glúteo</option>
                                                                <option value="Pierna/Glúteo+Abs">Pierna/Glúteo+Abs</option>
                                                                <option value="Resistance Bands">Resistance Bands</option>
                                                                <option value="Stick">Stick</option>
                                                                <option value="Theme Ride">Theme Ride</option>
                                                                <option value="Upper Body">Upper Body</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row">

                                                <div class="col-md-4">
                                                    <label for="inicia" class="col-md-12 label-control"><span class="red">*</span> Fecha y hora de inicio de la clase</label>
                                                    <div class="form-group row">
                                                        <fieldset class="col-md-12">
                                                            <div class="input-group">
                                                                <input type="date" name="inicia_date1" id="inicia_date1" class="form-control" value="<?php echo set_value('inicia_date1'); ?>">
                                                                <div class="input-group-append">
                                                                    <input type="time" name="inicia_time1" id="inicia_time1" class="form-control" value="<?php echo set_value('inicia_time1'); ?>">   
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="cupo1" class="col-md-12 label-control"><span class="red">*</span> Cupo</label>
                                                    <div class="form-group row">
                                                        <div class="col-md-12">
                                                            <input type="number" name="cupo1" id="cupo1" class="form-control" placeholder="No. lugares disponibles de clase" value="<?php echo set_value('cupo1'); ?>" min="1" max="10" pattern="^[0-9]+">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="intervalo_horas1" class="col-md-12 label-control"><span class="red">*</span> Clases a consumir del plan</label>
                                                    <div class="form-group row">
                                                        <div class="col-md-12">
                                                            <input type="number" name="intervalo_horas1" id="intervalo_horas1" class="form-control" placeholder="No. de clases a consumir" value="<?php echo set_value('intervalo_horas1'); ?>" min="1" max="10" pattern="^[0-9]+">
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <h4 class="form-section">#2 Datos de clase</h4>

                                            <div class="row">

                                                <div class="col-md-4">
                                                    <label for="identificador2" class="col-md-12 label-control"><span class="red">*</span> Identificador de clase</label>
                                                    <div class="form-group row">
                                                        <div class="col-md-12">
                                                            <input type="text" name="identificador2" id="identificador2" class="form-control" placeholder="ID" value="<?php echo set_value('identificador2'); ?>" readonly="true">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">

                                                </div>

                                                <div class="col-md-4">
                                                    <label for="opciones2" class="col-md-12 label-control"> Opciones</label>
                                                    <div class="form-group row">
                                                        <div class="col-md-12">
                                                            <a href="#" class="btn btn-secondary btn-sm" onclick="copiar_datos_clase1();return false;"><i class="icon-docs"></i> Copiar</a>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row">

                                                <div class="col-md-4">
                                                    <label for="disciplina_id2" class="col-md-12 label-control"><span class="red">*</span> Disciplina de clase</label>
                                                    <div class="form-group row">
                                                        <div class="col-md-12">
                                                            <select name="disciplina_id2" id="disciplina_id2" class="form-control">
                                                                <option value="">Seleccione una disciplina…</option>
                                                                <?php foreach ($disciplinas->result() as $disciplina): ?>
                                                                    <?php if ($disciplina->id != 1): ?>
                                                                        <option value="<?php echo $disciplina->id; ?>" <?php echo set_select('disciplina_id2', $disciplina->id); ?>>
                                                                            <?php 
                                                                                if($disciplina->id == 5){
                                                                                    echo 'B. BIKE + '.$disciplina->nombre; 
                                                                                } elseif($disciplina->id == 6){
                                                                                    echo 'B. BOX + '.$disciplina->nombre; 
                                                                                } elseif($disciplina->id == 7){
                                                                                    echo 'B. BODY + '.$disciplina->nombre; 
                                                                                } else{
                                                                                    echo $disciplina->nombre; 
                                                                                }
                                                                            ?>
                                                                        </option>
                                                                    <?php endif;?>
                                                                <?php endforeach;?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="instructor_id2" class="col-md-12 label-control"><span class="red">*</span> Instructor de clase</label>
                                                    <div class="form-group row">
                                                        <div class="col-md-12">
                                                            <select name="instructor_id2" id="instructor_id2" class="form-control">
                                                                <option value="">Seleccione un instructor de clase…</option>
                                                                <?php foreach ($instructores->result() as $instructor): ?>
                                                                    <option value="<?php echo $instructor->id; ?>" <?php echo set_select('instructor_id2', $instructor->id); ?>>
                                                                        <?php echo $instructor->nombre_completo .' '. $instructor->apellido_paterno.' '. $instructor->apellido_materno; ?>
                                                                    </option>
                                                                <?php endforeach;?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="dificultad2" class="col-md-12 label-control"><span class="red">*</span> Dificultad de clase</label>
                                                    <div class="form-group row">
                                                        <div class="col-md-12">
                                                            <select name="dificultad2" id="dificultad2" class="form-control">
                                                                <option value="">Seleccione una dificultad…</option>
                                                                <option value="All in One">All in One</option>
                                                                <option value="Avanzado">Avanzado</option>
                                                                <option value="Ball">Ball</option>
                                                                <option value="Básico">Básico</option>
                                                                <option value="Double Ride">Double Ride</option>
                                                                <option value="Full Body">Full Body</option>
                                                                <option value="High Performance">High Performance</option>
                                                                <option value="Hombro/Bíceps">Hombro/Bíceps</option>
                                                                <option value="Intermedio">Intermedio</option>
                                                                <option value="Lower Body">Lower Body</option>
                                                                <option value="Outdoor Ride">Outdoor Ride</option>
                                                                <option value="Pecho/Espalda">Pecho/Espalda</option>
                                                                <option value="Pierna/Glúteo">Pierna/Glúteo</option>
                                                                <option value="Pierna/Glúteo+Abs">Pierna/Glúteo+Abs</option>
                                                                <option value="Resistance Bands">Resistance Bands</option>
                                                                <option value="Stick">Stick</option>
                                                                <option value="Theme Ride">Theme Ride</option>
                                                                <option value="Upper Body">Upper Body</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row">

                                                <div class="col-md-4">
                                                    <label for="inicia" class="col-md-12 label-control"><span class="red">*</span> Fecha y hora de inicio de la clase</label>
                                                    <div class="form-group row">
                                                        <fieldset class="col-md-12">
                                                            <div class="input-group">
                                                                <input type="date" name="inicia_date2" id="inicia_date2" class="form-control" value="<?php echo set_value('inicia_date2'); ?>">
                                                                <div class="input-group-append">
                                                                    <input type="time" name="inicia_time2" id="inicia_time2" class="form-control" value="<?php echo set_value('inicia_time2'); ?>">   
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="cupo2" class="col-md-12 label-control"><span class="red">*</span> Cupo</label>
                                                    <div class="form-group row">
                                                        <div class="col-md-12">
                                                            <input type="number" name="cupo2" id="cupo2" class="form-control" placeholder="No. lugares disponibles de clase" value="<?php echo set_value('cupo2'); ?>" min="1" max="10" pattern="^[0-9]+">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="intervalo_horas2" class="col-md-12 label-control"><span class="red">*</span> Clases a consumir del plan</label>
                                                    <div class="form-group row">
                                                        <div class="col-md-12">
                                                            <input type="number" name="intervalo_horas2" id="intervalo_horas2" class="form-control" placeholder="No. de clases a consumir" value="<?php echo set_value('intervalo_horas2'); ?>" min="1" max="10" pattern="^[0-9]+">
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="form-actions right">
                                                <a href="<?php echo site_url('clases/index'); ?>" class="btn btn-secondary btn-sm">Cancelar</a>
                                                <button type="submit" class="btn btn-secondary btn-sm">Guardar</button>
                                            </div>

                                        </div>

									<?php echo form_close(); ?>
								</div>
							</div>

						</div>
					</div>
				</div>
			</section>
		</div>
	</div>

</div>
