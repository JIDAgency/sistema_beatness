<section class="seccion-texto">

    <div class="container">
        <div class="row p-b-20">
            <h1 class="text-center p-t-20">Estas son tus clases proximas</h1>
        </div>
    </div>

    <div class="container">

        <?php $this->load->view('_comun/mensajes_alerta'); $i = 1; ?>
        
        <?php foreach ($reservaciones->result() as $reservacion): ?>
        <?php foreach ($clases->result() as $clase):?>
        <?php if($reservacion->clase_id == $clase->id): ?>
        <div class="row p-b-20">
        
            <div class="col-3 offset-2">
                <h1><?php echo $clase->disciplina; ?></h1>
                <p><?php echo branding(); ?> Boca del río</p>
                <p>Instructor: <?php echo $clase->usuario; ?></p>
            </div>
            <div class="col-3 offset-2">
                <h1>Viernes</h1>
                <p><?php echo $clase->inicia; ?></p>
                <p><?php echo $clase->dificultad; ?></p>
            </div>
        </div>
        
        <hr>
        <?php endif;?>
        <?php endforeach;?>
        <?php endforeach;?>

    </div>

</section>