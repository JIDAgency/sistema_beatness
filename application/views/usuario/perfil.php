<section class="seccion-perfil">
    
    <div class="container">
        <div class="row p-b-20">
            <h1 class="text-center p-t-20">Perfil</h1>
        </div>
    </div>

    <?php foreach ($usuarios->result() as $usuario): ?>
    <div class="container">


        <?php foreach ($asignaciones->result() as $asignacion): $resultado = 0;?>
        <div class="row">
            <div class="col-6 offset-1">
                <h1>Plan activo</h1>
            </div>
            <div class="col-5">
                <a href="#" class="btn  btn-outline-secondary" tabindex="-1" role="button" aria-disabled="true">Mis planes</a>
            </div>
        </div>
        <div class="row">
            <div class="col-6 offset-1">
                <h1><?php echo $asignacion->nombre ?></h1>
                <p>Vigencia: <?php echo $asignacion->vigencia_en_dias ?> días</p>
                <p>Fecha de inicio: <?php echo $asignacion->fecha_activacion ?></p>
                <p>Disciplinas a las que puede acceder: <?php echo $asignacion->disciplinas ?></p>
            </div>
            <div class="col-5">
                <h1>Clases restantes: <?php echo $resultado = $asignacion->clases_incluidas - $asignacion->clases_usadas ?></h1>
                <p>Plan activado: <?php echo $asignacion->esta_activo ?></p>
            </div>
        </div>
        <?php endforeach; ?>

        <div class="row">
            <div class="col-6 offset-1">
                <h1>Mis clases</h1>
            </div>
            <div class="col-5">
                <a href="#" class="btn  btn-outline-secondary" tabindex="-1" role="button" aria-disabled="true">Ver todas</a>
            </div>
        </div>

        <div class="row">
            <div class="col-6 offset-1">
                <h1>Perfil</h1>
                <p><?php echo $usuario->nombre_completo ?> <?php echo $usuario->apellido_paterno ?> <?php echo $usuario->apellido_materno ?></p>
                <p><?php echo $usuario->correo; ?></p>
                <p><?php echo $usuario->genero; ?></p>
                <p><?php echo $usuario->no_telefono; ?></p>
                <p><?php echo $usuario->rfc; ?></p>
                <p><?php echo $usuario->calle; ?> <?php echo $usuario->numero; ?> <?php echo $usuario->colonia; ?> <?php echo $usuario->estado; ?> <?php echo $usuario->pais; ?></p>
            </div>
            <div class="col-5">
                <a href="#" class="btn btn-outline-secondary" tabindex="-1" role="button" aria-disabled="true">Editar <?php echo $usuario->id ?></a>
            </div>
        </div>

    <?php endforeach; ?>

    </div>

</section>
