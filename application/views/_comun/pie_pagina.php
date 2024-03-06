        <!--footer class="footer footer-static footer-light navbar-shadow fixed-bottom">
            <!--p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2 container center-layout">
                <span class="d-block d-md-inline-block">Copyright &copy; <?php echo date("Y")." ".branding(); ?>  | Todos los derechos
                    reservados</span>
            </p>
        </footer-->
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
        <!-- TERMINA ROBUST JS-->
        <!-- INICIA PAGE LEVEL JS-->
            <?php if (isset($scripts) && is_array($scripts)): ?>
                <?php foreach ($scripts as $script): ?>
                    <script type="text/javascript" src="<?php echo !$script['es_rel'] ? $script['src'] : base_url() . 'assets/js/' . $script['src']; ?>"></script>
                <?php endforeach;?>
            <?php endif;?>
        <!-- TERMINA PAGE LEVEL JS-->
    </body>

</html>