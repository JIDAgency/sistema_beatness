        <footer class="footer m-t-50">
            <p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2 container center-layout">
                <span>Copyright &copy; <?php echo date("Y")." ".branding(); ?> | Todos los derechos reservados | <a href="<?php echo base_url(); ?>terminos-de-servicio.html" target="_blank">Terminos y condiciones</a> | <a href="<?php echo base_url(); ?>politica-de-privacidad.html" target="_blank">Politica de privacidad</a>
                    </span>
            </p>
        </footer>
        <!-- INICIA VENDOR JS-->
        <script src="<?php echo base_url(); ?>app-assets/vendors/js/vendors.min.js" type="text/javascript"></script>
        <!-- TERMINA VENDOR JS-->
        <!-- INICIA PAGE VENDOR JS-->
        <script type="text/javascript" src="<?php echo base_url(); ?>app-assets/vendors/js/ui/jquery.sticky.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>app-assets/vendors/js/ui/prism.min.js"></script>
        <!-- TERMINA PAGE VENDOR JS-->
        <!-- INICIA ROBUST JS-->
        <script src="<?php echo base_url(); ?>app-assets/js/core/app-menu.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>app-assets/js/core/app.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>app-assets/js/scripts/customizer.js" type="text/javascript"></script>
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
