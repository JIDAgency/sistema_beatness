<?php if (isset($mensaje_exito) && !is_null($mensaje_exito)): ?>
    <div class="alert bg-success alert-icon-left alert-dismissible mb-2" role="alert">
        <span class="alert-icon"><i class="fa fa-thumbs-o-up"></i></span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        <?php echo $mensaje_exito; ?>
    </div>
<?php endif;?>
<?php if (isset($mensaje_info) && !is_null($mensaje_info)): ?>
    <div class="alert alert-icon-left alert-info alert-dismissible mb-2" role="alert">
        <span class="alert-icon"><i class="fa fa-info-circle"></i></span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        <?php echo $mensaje_info; ?>
    </div>
<?php endif;?>
<?php if (isset($mensaje_error) && !is_null($mensaje_error)): ?>
    <div class="alert alert-icon-left alert-danger alert-dismissible mb-2" role="alert">
        <span class="alert-icon"><i class="fa fa-thumbs-o-down"></i></span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        <?php echo $mensaje_error; ?>
    </div>
<?php endif;?>
<?php if (validation_errors()): ?>
	<div class="alert bg-danger alert-icon-left alert-dismissible mb-2 font-small-3" role="alert">
		<span class="alert-icon"><i class="fa fa-thumbs-o-down"></i></span>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">×</span>
		</button>
		<?php echo validation_errors(); ?>
	</div>
<?php endif?>
