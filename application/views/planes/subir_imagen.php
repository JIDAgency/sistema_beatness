<div class="app-content container center-layout mt-2">
    <div class="content-wrapper">
        <div class="content-header row">

            <div class="content-header-left col-md-6 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo site_url("inicio"); ?>">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo site_url("planes"); ?>">Planes</a></li>
                            <li class="breadcrumb-item active">Imagen</li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="content-header-right col-md-6 col-12">
            </div>

        </div>

        <div class="content-body">
            <!-- Basic form layout section start -->
            <section id="horizontal-form-layouts">

                <?php echo form_open($controlador, array('class' => 'form form-horizontal p-2', 'id' => 'forma-'.$controlador, 'enctype' => 'multipart/form-data', 'method' => 'post')); ?>

                    <div class="row">

                        <div class="col-md-12">

                            <h5 class="form-section"><i class="fa fa-cloud-upload"></i> Subir imagen</h5>

                            <div class="row">
                                <div class="col-md-6">

                                    <div class="collpase show">
                                        <div class="form-body">

                                            <div class="mt-2 mb-2">
                                                <h5><b>Plan: </b> <?php echo $plan_row->nombre." #".$plan_row->id; ?></h5>
                                                <hr>
                                                <h5><b>Formato de imagen</b></h5>
                                                <p><b>Tamaño Max.:</b> <?php echo $max_size; ?> KBs</p>
                                                <p><b>Medidas:</b> <?php echo $max_width." x ".$max_height; ?> px</p>
                                                <p><b>Formato:</b> <?php echo ".".$allowed_types; ?></p>
                                            </div>

                                            <div class="form-group text-center center-block align-center">
                                                <label class="label-control">Seleccionar imagen: </label>
                                                <br>
                                                <input type="file" name="file" id="file" onchange="loadFile(event)">
                                            </div>
                                            
                                            <div class="mt-2 mb-2 text-center ">
                                                <b class=""><?php if(isset($response)) echo $response; ?></b>
                                            </div>
                                        
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-6">
                                <?php if (isset($plan_row->url_infoventa) AND !empty($plan_row->url_infoventa)): ?>
                                    <img class="img-fluid" name="preview" id="preview" src="<?php echo $plan_row->url_infoventa; ?>" alt="">
                                <?php else: ?>
                                    <img class="img-fluid" name="preview" id="preview" src="<?php echo base_url(); ?>almacenamiento/planes/ejemplo.jpg" alt="">
                                <?php endif; ?>

                                    <input type="hidden" name="id" id="id" class="form-control" placeholder="id" value="<?php echo set_value('id') == false ? $plan_row->id : set_value('id'); ?>" required="">
                                </div>
                            </div>

                            <div class="form-actions right">
                                <a href="<?php echo site_url($regresar_a); ?>" class="btn mr-1 mb-1 btn-grey btn-sm">Regresar</a>
                                <input type='submit' name='upload'  class="btn mr-1 mb-1 btn-secondary btn-sm" value='Guardar'/>
                            </div>

                        </div>
                    </div>

                <?php echo form_close(); ?>

            </section>
            <!-- // Basic form layout section end -->
        </div>
    </div>
</div>

<script>
  var loadFile = function(event) {
    var output = document.getElementById('preview');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
      URL.revokeObjectURL(output.src) // free memory
    }
  };
</script>