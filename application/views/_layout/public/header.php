<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="facebook-domain-verification" content="hmo3j2doq28l4psfujdxqkw4g3b0uc"   />

    <link rel="apple-touch-icon" href="<?php echo base_url(); ?>app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>almacenamiento/logos/logo.jpg">
    <!-- <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>app-assets/images/ico/favicon.ico"> -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans: 300,300i,400,400i,600,600i,700,700i|Muli:300,400,500,700">
    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/vendors.css">
    <!-- END VENDOR CSS-->
    <!-- BEGIN ROBUST CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/app.css">
    <!-- END ROBUST CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/core/menu/menu-types/horizontal-menu.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/core/colors/palette-gradient.css">
    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style.css">
    <!-- END Custom CSS-->

    <meta property="og:url" content="https://beatness.mx/" />
    <meta property="og:type" content="Website" />
    <meta name="description" content="<?php echo description(); ?>">
    <meta name="keywords" content="<?php echo keywords(); ?>">
    <meta name="author" content="<?php echo author(); ?>">

    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>almacenamiento/logos/logo.jpg">
    <!-- <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>app-assets/images/ico/favicon.ico"> -->

    <title><?php echo isset($titulo_pagina) ? $titulo_pagina . " | " : ""; ?><?php echo titulo(); ?><?php $lema = lema();
                                                                                                    echo isset($lema) ? ", " . $lema : ""; ?></title>

    <!-- Meta Pixel Code -->
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '1230227784598664');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=1230227784598664&ev=PageView&noscript=1" /></noscript>
    <!-- End Meta Pixel Code -->


</head>

<body>


    <section class="seccion-menu-principal p-t-20">
        <div class="container">
            <div class="row">

                <!--div class="col-xs-4 col-md-4">
                    <a href="<?php echo site_url(); ?>"><img src="<?php echo base_url(); ?>almacenamiento/img/logo-sensoria-horizontal.png" class="img-fluid"></a>
                </div-->

                <div class="col-xs-12">
                    <!-- <a href="https://beatness.mx/descarga" target="_blank"><img src="<?php echo base_url(); ?>almacenamiento/logos/logo.jpg" alt="" class="img-fluid"></a> -->
                    <a href="#"><img src="<?php echo base_url(); ?>almacenamiento/logos/logo.jpg" alt="" class="img-fluid"></a>
                </div>

            </div>
        </div>
    </section>