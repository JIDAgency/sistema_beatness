    <!-- ////////////////////////////////////////////////////////////////////////////-->

    <footer class="seccion-footer text-center">
        <div class="container-fluid">
            <div class="row">

                <div class="col-sm-12 p-0">
                    <!-- <img src="<?php echo base_url(); ?>almacenamiento/img/footer.jpg" class="img-fluid"> -->
                </div>

            </div>
        </div>
    </footer>





	<!-- INICIA VENDOR JS-->
	<script src="<?php echo base_url(); ?>app-assets/vendors/js/vendors.min.js"></script>
	<!-- TERMINA VENDOR JS-->
	<!-- INICIA PAGE VENDOR JS-->
	<script src="<?php echo base_url(); ?>app-assets/vendors/js/ui/jquery.sticky.js"></script>
	<script src="<?php echo base_url(); ?>app-assets/vendors/js/ui/prism.min.js"></script>
	<!-- TERMINA PAGE VENDOR JS-->
	<!-- INICIA ROBUST JS-->
	<script src="<?php echo base_url(); ?>app-assets/js/core/app-menu.js"></script>
	<script src="<?php echo base_url(); ?>app-assets/js/core/app.js"></script>
	<script src="<?php echo base_url(); ?>app-assets/js/scripts/customizer.js"></script>

    <!-- BEGIN PAGE LEVEL JS-->
    <script src="../../../app-assets/js/scripts/navs/navs.js"></script>
    <!-- END PAGE LEVEL JS-->

   
	<!-- TERMINA ROBUST JS-->

    <?php if (isset($scripts) && is_array($scripts)): ?>
        <?php foreach ($scripts as $script): ?>
            <script type="text/javascript" src="<?php echo !$script['es_rel'] ? $script['src'] : base_url() . 'assets/js/' . $script['src']; ?>"></script>
        <?php endforeach;?>
    <?php endif;?>



</body>
</html>