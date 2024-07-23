<!DOCTYPE html>
<html class="loading" lang="es" data-textdirection="ltr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

    <meta name="description" content="<?php echo descripcion(); ?>">
    <meta name="keywords" content="<?php echo palabras_clave(); ?>">
    <meta name="author" content="<?php echo autor(); ?>">

    <!-- Open Graph Tags -->
    <meta property="og:title" content="<?php echo isset($pagina_titulo) ? $pagina_titulo . " | " : ""; ?><?php echo titulo() ? titulo() : ""; ?>">
    <meta property="og:description" content="<?php echo descripcion(); ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo base_url(); ?>">
    <meta property="og:image" content="<?php echo base_url(); ?>almacenamiento/logos/logo.jpg">
    <!-- Fin de Open Graph Tags -->

    <title><?php echo isset($pagina_titulo) ? $pagina_titulo . " | " : ""; ?><?php echo titulo() ? titulo() : ""; ?></title>

    <link rel="apple-touch-icon" href="<?php echo base_url(); ?>almacenamiento/logos/logo.jpg">
    <link rel=" shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>almacenamiento/logos/logo.jpg">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i%7CMuli:300,400,500,700" rel="stylesheet">
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

    <?php if (isset($styles) && is_array($styles)) : ?>
        <?php foreach ($styles as $style) : ?>
            <link rel="stylesheet" type="text/css" href="<?php echo !$style['es_rel'] ? $style['href'] : base_url() . 'assets/css/' . $style['href']; ?>">
        <?php endforeach; ?>
    <?php endif; ?>

</head>

<body class="horizontal-layout bg-calendario horizontal-menu horizontal-menu-padding 2-columns   menu-expanded" data-open="hover" data-menu="horizontal-menu" data-col="2-columns">

    <!-- ////////////////////////////////////////////////////////////////////////////-->

    <div class="app-content content center-layout mt-1">
        <div class="content-wrapper">

            <div class="content-header row">
                <div class="content-header-left col-md-6 col-4 mb-2">
                    <img src="<?php echo base_url('almacenamiento/calendario/logo.png') ?>" alt="" class="img-fluid">
                </div>
                <div class="content-header-right row col-md-6 col-8">
                    <div class="col-lg-6 col-md-6 col-6 text-right">
                        <a href="https://apps.apple.com/mx/app/beatness-studio/id6479663018" target="_blank"><img src="<?php echo base_url('almacenamiento/calendario/appstore.png') ?>" alt="" class="img-fluid"></a>
                    </div>
                    <div class="col-lg-6 col-md-6 col-6">
                        <a href="https://play.google.com/store/apps/details?id=com.mx.beatness.app" target="_blank"><img src="<?php echo base_url('almacenamiento/calendario/googleplay.png') ?>" alt="" class="img-fluid"></a>
                    </div>
                </div>
            </div>

            <div class="content-body">

                <!-- Start -->
                <section id="basic-tabs-components">

                    <div class="row match-height">
                        <div class="col-xl-6 col-md-6 col-sm-12">

                            <div class="form-group">
                                <div class="row">
                                    <!-- <label class="col-lg-12 text-white"><b>+ DISCIPLINAS</b></label> -->
                                    <div class="col-lg-8">
                                        <select class="form-control select2 custom-select tp-select" name="disciplina_seleccionada" id="disciplina_seleccionada" required>
                                            <option value="" <?php echo set_select('disciplina_seleccionada', '', set_value('disciplina_seleccionada') ? false : '' == $this->session->flashdata('disciplina_seleccionada')); ?>>Seleccione una disciplina…</option>
                                            <?php foreach ($disciplinas_list as $disciplina_key => $disciplina_value) : ?>
                                                <?php if ($disciplina_key != 0 and $disciplina_value->estatus == 'activo' and $disciplina_value->mostrar_en_app == 'si') : ?>
                                                    <option value="<?php echo $disciplina_value->id; ?>" <?php // echo ($disciplina_key == 1) ? 'selected' : ''; 
                                                                                                            ?> <?php echo set_select('disciplina_seleccionada', $disciplina_value->id, set_value('disciplina_seleccionada') ? false : $disciplina_value->id == $this->session->flashdata('disciplina_seleccionada')); ?>>
                                                        <?php echo trim(ucfirst($disciplina_value->nombre)); ?>
                                                    </option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            Se requiere seleccionar una disciplina válida.
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 d-flex align-items-center">
                                        <a id="reload">
                                            <h3 class="white"><i class="ft-refresh-cw" id="loading"></i></h3>
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row match-height" id="tabla-container" style="display: block">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="card card-transparent no-border">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="base-tab1" data-toggle="tab" aria-controls="tab1" href="#tab1" aria-expanded="true">Semana actual <?php echo date('d/M/Y', strtotime($fecha_lunes)) . ' - ' . date('d/M/Y', strtotime($fecha_domingo)); ?></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2" href="#tab2" aria-expanded="false">Semana siguiente <?php echo date('d/M/Y', strtotime($fecha_lunes_siguente)) . ' - ' . date('d/M/Y', strtotime($fecha_domingo_siguente)); ?></a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="tab1" aria-expanded="true" aria-labelledby="base-tab1">
                                        <div class="card-header bg-transparent">
                                            <h4 class="card-title text-bold-600 text-white" name="card_titulo" id="card_titulo">
                                                <span name="disciplina_titulo" id="disciplina_titulo"></span>
                                            </h4>
                                        </div>

                                        <div class="card-content">
                                            <div class="card-body bg-transparent">

                                                <table class="semana responsive">
                                                    <thead>
                                                        <tr>
                                                            <th class="blue lighten-3">Horario</th>
                                                            <th><a id="base-tablunes" data-toggle="tab" aria-controls="tablunes" href="#tablunes" class="day-link">Lun <br><?php echo date('d M', strtotime($fecha_lunes)); ?> </a></th>
                                                            <th><a id="base-tabmartes" data-toggle="tab" aria-controls="tabmartes" href="#tabmartes" class="day-link">Mar <br><?php echo date('d M', strtotime($fecha_lunes . ' +1 days')); ?></a></th>
                                                            <th><a id="base-tab3" data-toggle="tab" aria-controls="tab3" href="#tab3" class="day-link">Mie <br><?php echo date('d M', strtotime($fecha_lunes . ' +2 days')); ?></a></th>
                                                            <th><a id="base-tab4" data-toggle="tab" aria-controls="tab4" href="#tab4" class="day-link">Jue <br><?php echo date('d M', strtotime($fecha_lunes . ' +3 days')); ?></a></th>
                                                            <th><a id="base-tab5" data-toggle="tab" aria-controls="tab5" href="#tab5" class="day-link">Vie <br><?php echo date('d M', strtotime($fecha_lunes . ' +4 days')); ?></a></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody name="contenido_semana" id="contenido_semana">
                                                    </tbody>
                                                </table>

                                                <br>
                                                <br>

                                                <table class="semana">
                                                    <thead>
                                                        <tr>
                                                            <th class="blue lighten-3">Horario</th>
                                                            <th class=""><a id="base-tab6" data-toggle="tab" aria-controls="tab6" href="#tab6" class="day-link">Sab <br><?php echo date('d M', strtotime($fecha_lunes . ' +5 days')); ?></a></th>
                                                            <th class=""><a id="base-tab7" data-toggle="tab" aria-controls="tab7" href="#tab7" class="day-link">Dom <br><?php echo date('d M', strtotime($fecha_domingo)); ?></a></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody name="contenido_fin_de_semana" id="contenido_fin_de_semana">
                                                        <!-- <div name="contenido_fin_de_semana" id="contenido_fin_de_semana">
                                                        </div> -->
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab2" aria-labelledby="base-tab2">

                                        <div class="card-header bg-transparent">
                                            <h4 class="card-title text-bold-600 text-white" name="card_titulo" id="card_titulo">
                                                <span name="disciplina_titulo_siguiente" id="disciplina_titulo_siguiente"></span>
                                            </h4>
                                        </div>

                                        <div class="card-content">
                                            <div class="card-body bg-transparent">

                                                <table class="semana responsive">
                                                    <thead>
                                                        <tr>
                                                            <th class="blue lighten-3">Horario</th>
                                                            <th class=""><a id="base-tablunesnext" data-toggle="tab" aria-controls="tablunesnext" href="#tablunesnext" class="day-link2">Lun <br><?php echo date('d M', strtotime($fecha_lunes_siguente)); ?></a></th>
                                                            <th class=""><a id="base-tabmartesnext" data-toggle="tab" aria-controls="tabmartesnext" href="#tabmartesnext" class="day-link2">Mar <br><?php echo date('d M', strtotime($fecha_lunes_siguente . ' +1 days')); ?></a></th>
                                                            <th class=""><a id="base-tabmiercolesnext" data-toggle="tab" aria-controls="tabmiercolesnext" href="#tabmiercolesnext" class="day-link2">Mie <br><?php echo date('d M', strtotime($fecha_lunes_siguente . ' +2 days')); ?></a></th>
                                                            <th class=""><a id="base-tabjuevesnext" data-toggle="tab" aria-controls="tabjuevesnext" href="#tabjuevesnext" class="day-link2">Jue <br><?php echo date('d M', strtotime($fecha_lunes_siguente . ' +3 days')); ?></a></th>
                                                            <th class=""><a id="base-tabviernesnext" data-toggle="tab" aria-controls="tabviernesnext" href="#tabviernesnext" class="day-link2">Vie <br><?php echo date('d M', strtotime($fecha_lunes_siguente . ' +4 days')); ?></a></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody name="contenido_semana_siguiente" id="contenido_semana_siguiente">
                                                        <!-- <div name="contenido_semana_siguiente" id="contenido_semana_siguiente">
                                                        </div> -->
                                                    </tbody>
                                                </table>

                                                <br>
                                                <br>

                                                <table class="semana">
                                                    <thead>
                                                        <tr>
                                                            <th class="blue lighten-3">Horario</th>
                                                            <th class=""><a id="base-tabsabadonext" data-toggle="tab" aria-controls="tabsabadonext" href="#tabsabadonext" class="day-link2">Sab <br><?php echo date('d M', strtotime($fecha_lunes_siguente . ' +5 days')); ?></a></th>
                                                            <th class=""><a id="base-tabdomingonext" data-toggle="tab" aria-controls="tabdomingonext" href="#tabdomingonext" class="day-link2">Dom <br><?php echo date('d M', strtotime($fecha_domingo_siguente)); ?></a></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody name="contenido_fin_de_semana_siguiente" id="contenido_fin_de_semana_siguiente">
                                                        <!-- <div name="contenido_fin_de_semana_siguiente" id="contenido_fin_de_semana_siguiente">
                                                        </div> -->
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row match-height" id="tabla-dia" style="display: none">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="card card-transparent no-border" id="nav-tabs-container">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link" id="base-tablunes" data-toggle="tab" aria-controls="tablunes" href="#tablunes" aria-expanded="false">Lunes <?php echo date('d M', strtotime($fecha_lunes)) ?> </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="base-tabmartes" data-toggle="tab" aria-controls="tabmartes" href="#tabmartes" aria-expanded="false">Martes <?php echo date('d M', strtotime($fecha_lunes . ' +1 days')) ?></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="base-tab3" data-toggle="tab" aria-controls="tab3" href="#tab3" aria-expanded="false">Miercoles <?php echo date('d M', strtotime($fecha_lunes . ' +2 days')) ?></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="base-tab4" data-toggle="tab" aria-controls="tab4" href="#tab4" aria-expanded="false">Jueves <?php echo date('d M', strtotime($fecha_lunes . ' +3 days')) ?></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="base-tab5" data-toggle="tab" aria-controls="tab5" href="#tab5" aria-expanded="false">Vierenes <?php echo date('d M', strtotime($fecha_lunes . ' +4 days')) ?></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="base-tab6" data-toggle="tab" aria-controls="tab6" href="#tab6" aria-expanded="false">Sabado <?php echo date('d M', strtotime($fecha_lunes . ' +5 days')) ?></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="base-tab7" data-toggle="tab" aria-controls="tab7" href="#tab7" aria-expanded="false">Domingo <?php echo date('d M', strtotime($fecha_lunes . ' +6 days')) ?></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link semanal" id="semanal" data-toggle="tab" aria-controls="tab7" href="#" aria-expanded="false">Calendario semanal</a>
                                    </li>
                                </ul>
                                <select id="nav-tabs-select" class="d-block d-sm-none form-control tp-select" onchange="handleSelectChange(this)">
                                    <option value="base-tablunes">Lunes <?php echo date('d M', strtotime($fecha_lunes)) ?></option>
                                    <option value="base-tabmartes">Martes <?php echo date('d M', strtotime($fecha_lunes . ' +1 days')) ?></option>
                                    <option value="base-tab3">Miercoles <?php echo date('d M', strtotime($fecha_lunes . ' +2 days')) ?></option>
                                    <option value="base-tab4">Jueves <?php echo date('d M', strtotime($fecha_lunes . ' +3 days')) ?></option>
                                    <option value="base-tab5">Viernes <?php echo date('d M', strtotime($fecha_lunes . ' +4 days')) ?></option>
                                    <option value="base-tab6">Sabado <?php echo date('d M', strtotime($fecha_lunes . ' +5 days')) ?></option>
                                    <option value="base-tab7">Domingo <?php echo date('d M', strtotime($fecha_lunes . ' +6 days')) ?></option>
                                    <option value="semanal">Calendario semanal</option>
                                </select>

                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane" id="tablunes" aria-expanded="false" aria-labelledby="base-tablunes">
                                        <div class="card-header bg-transparent">
                                            <h1 class="text-verdeb" name="card_titulo" id="card_titulo">
                                                LUNES <span name="disciplina_titulo_lunes" id="disciplina_titulo_lunes"></span>
                                            </h1>
                                        </div>

                                        <div class="card-content">
                                            <div class="card-body bg-transparent">

                                                <div name="contenido_lunes" id="contenido_lunes">
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="tabmartes" aria-expanded="false" aria-labelledby="base-tabmartes">
                                        <div class="card-header bg-transparent">
                                            <h1 class="text-verdeb" name="card_titulo" id="card_titulo">
                                                MARTES <span name="disciplina_titulo_martes" id="disciplina_titulo_martes"></span>
                                            </h1>
                                        </div>

                                        <div class="card-content">
                                            <div class="card-body bg-transparent">

                                                <div name="contenido_martes" id="contenido_martes">
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane" id="tab3" aria-labelledby="base-tab3">
                                        <div class="card-header bg-transparent">
                                            <h1 class="text-verdeb" name="card_titulo" id="card_titulo">
                                                MIERCOLES <span name="disciplina_titulo_miercoles" id="disciplina_titulo_miercoles"></span>
                                            </h1>
                                        </div>

                                        <div class="card-content">
                                            <div class="card-body bg-transparent">

                                                <div name="contenido_miercoles" id="contenido_miercoles">
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane" id="tab4" aria-labelledby="base-tab4">
                                        <div class="card-header bg-transparent">
                                            <h1 class="text-verdeb" name="card_titulo" id="card_titulo">
                                                JUEVES <span name="disciplina_titulo_jueves" id="disciplina_titulo_jueves"></span>
                                            </h1>
                                        </div>

                                        <div class="card-content">
                                            <div class="card-body bg-transparent">

                                                <div name="contenido_jueves" id="contenido_jueves">
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane" id="tab5" aria-labelledby="base-tab5">
                                        <div class="card-header bg-transparent">
                                            <h1 class="text-verdeb" name="card_titulo" id="card_titulo">
                                                VIERNES <span name="disciplina_titulo_viernes" id="disciplina_titulo_viernes"></span>
                                            </h1>
                                        </div>

                                        <div class="card-content">
                                            <div class="card-body bg-transparent">

                                                <div name="contenido_viernes" id="contenido_viernes">
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane" id="tab6" aria-labelledby="base-tab6">
                                        <div class="card-header bg-transparent">
                                            <h1 class="text-verdeb" name="card_titulo" id="card_titulo">
                                                SABADO <span name="disciplina_titulo_sabado" id="disciplina_titulo_sabado"></span>
                                            </h1>
                                        </div>

                                        <div class="card-content">
                                            <div class="card-body bg-transparent">

                                                <div name="contenido_sabado" id="contenido_sabado">
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane" id="tab7" aria-labelledby="base-tab7">
                                        <div class="card-header bg-transparent">
                                            <h1 class="text-verdeb" name="card_titulo" id="card_titulo">
                                                DOMINGO <span name="disciplina_titulo_domingo" id="disciplina_titulo_domingo"></span>
                                            </h1>
                                        </div>

                                        <div class="card-content">
                                            <div class="card-body bg-transparent">

                                                <div name="contenido_domingo" id="contenido_domingo">
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row match-height" id="tabla-dianext" style="display: none">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="card card-transparent no-border" id="nav-tabs-container2">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="base-tablunesnext" data-toggle="tab" aria-controls="tablunesnext" href="#tablunesnext" aria-expanded="false">Lunes <?php echo date('d M', strtotime($fecha_lunes_siguente)) ?> </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="base-tabmartesnext" data-toggle="tab" aria-controls="tabmartesnext" href="#tabmartesnext" aria-expanded="false">Martes <?php echo date('d M', strtotime($fecha_lunes_siguente . ' +1 days')) ?></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="base-tabmiercolesnext" data-toggle="tab" aria-controls="tabmiercolesnext" href="#tabmiercolesnext" aria-expanded="false">Miercoles <?php echo date('d M', strtotime($fecha_lunes_siguente . ' +2 days')) ?></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="base-tabjuevesnext" data-toggle="tab" aria-controls="tabjuevesnext" href="#tabjuevesnext" aria-expanded="false">Jueves <?php echo date('d M', strtotime($fecha_lunes_siguente . ' +3 days')) ?></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="base-tabviernesnext" data-toggle="tab" aria-controls="tabviernesnext" href="#tabviernesnext" aria-expanded="false">Vierenes <?php echo date('d M', strtotime($fecha_lunes_siguente . ' +4 days')) ?></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="base-tabsabadonext" data-toggle="tab" aria-controls="tabsabadonext" href="#tabsabadonext" aria-expanded="false">Sabado <?php echo date('d M', strtotime($fecha_lunes_siguente . ' +5 days')) ?></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="base-tabdomingonext" data-toggle="tab" aria-controls="tabdomingonext" href="#tabdomingonext" aria-expanded="false">Domingo <?php echo date('d M', strtotime($fecha_lunes_siguente . ' +6 days')) ?></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link semanal" id="semanal" data-toggle="tab" aria-controls="tab7" href="#" aria-expanded="false">Calendario semanal</a>
                                    </li>
                                </ul>

                                <select id="nav-tabs-select2" class="d-block d-sm-none form-control tp-select" onchange="handleSelectChange(this)">
                                    <option value="base-tablunesnext">Lunes <?php echo date('d M', strtotime($fecha_lunes_siguente)) ?></option>
                                    <option value="base-tabmartesnext">Martes <?php echo date('d M', strtotime($fecha_lunes_siguente . ' +1 days')) ?></option>
                                    <option value="base-tabmiercolesnext">Miercoles <?php echo date('d M', strtotime($fecha_lunes_siguente . ' +2 days')) ?></option>
                                    <option value="base-tabjuevesnext">Jueves <?php echo date('d M', strtotime($fecha_lunes_siguente . ' +3 days')) ?></option>
                                    <option value="base-tabviernesnext">Viernes <?php echo date('d M', strtotime($fecha_lunes_siguente . ' +4 days')) ?></option>
                                    <option value="base-tabsabadonext">Sabado <?php echo date('d M', strtotime($fecha_lunes_siguente . ' +5 days')) ?></option>
                                    <option value="base-tabdomingonext">Domingo <?php echo date('d M', strtotime($fecha_lunes_siguente . ' +6 days')) ?></option>
                                    <option value="semanal">Calendario semanal</option>
                                </select>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tablunesnext" aria-labelledby="base-tablunesnext">

                                        <div class="card-header bg-transparent">
                                            <h1 class="text-verdeb" name="card_titulo" id="card_titulo">
                                                LUNES <span name="disciplina_titulo_lunesnext" id="disciplina_titulo_lunesnext"></span>
                                            </h1>
                                        </div>

                                        <div class="card-content">
                                            <div class="card-body bg-transparent">

                                                <div name="contenido_lunes_siguiente" id="contenido_lunes_siguiente">
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tabmartesnext" aria-labelledby="base-tabmartesnext">

                                        <div class="card-header bg-transparent">
                                            <h1 class="text-verdeb" name="card_titulo" id="card_titulo">
                                                MARTES <span name="disciplina_titulo_martesnext" id="disciplina_titulo_martesnext"></span>
                                            </h1>
                                        </div>

                                        <div class="card-content">
                                            <div class="card-body bg-transparent">

                                                <div name="contenido_martes_siguiente" id="contenido_martes_siguiente">
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane" id="tabmiercolesnext" aria-labelledby="base-tabmiercolesnext">

                                        <div class="card-header bg-transparent">
                                            <h1 class="text-verdeb" name="card_titulo" id="card_titulo">
                                                MIERCOLES <span name="disciplina_titulo_miercolesnext" id="disciplina_titulo_miercolesnext"></span>
                                            </h1>
                                        </div>

                                        <div class="card-content">
                                            <div class="card-body bg-transparent">

                                                <div name="contenido_miercoles_siguiente" id="contenido_miercoles_siguiente">
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane" id="tabjuevesnext" aria-labelledby="base-tabjuevesnext">

                                        <div class="card-header bg-transparent">
                                            <h1 class="text-verdeb" name="card_titulo" id="card_titulo">
                                                JUEVES <span name="disciplina_titulo_juevesnext" id="disciplina_titulo_juevesnext"></span>
                                            </h1>
                                        </div>

                                        <div class="card-content">
                                            <div class="card-body bg-transparent">

                                                <div name="contenido_jueves_siguiente" id="contenido_jueves_siguiente">
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane" id="tabviernesnext" aria-labelledby="base-tabviernesnext">

                                        <div class="card-header bg-transparent">
                                            <h1 class="text-verdeb" name="card_titulo" id="card_titulo">
                                                VIERNES <span name="disciplina_titulo_viernesnext" id="disciplina_titulo_viernesnext"></span>
                                            </h1>
                                        </div>

                                        <div class="card-content">
                                            <div class="card-body bg-transparent">

                                                <div name="contenido_viernes_siguiente" id="contenido_viernes_siguiente">
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane" id="tabsabadonext" aria-labelledby="base-tabsabadonext">
                                        <div class="card-header bg-transparent">
                                            <h1 class="text-verdeb" name="card_titulo" id="card_titulo">
                                                SABADO <span name="disciplina_titulo_sabadonext" id="disciplina_titulo_sabadonext"></span>
                                            </h1>
                                        </div>

                                        <div class="card-content">
                                            <div class="card-body bg-transparent">

                                                <div name="contenido_sabado_siguiente" id="contenido_sabado_siguiente">
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane" id="tabdomingonext" aria-labelledby="base-tabdomingonext">
                                        <div class="card-header bg-transparent">
                                            <h1 class="text-verdeb" name="card_titulo" id="card_titulo">
                                                DOMINGO <span name="disciplina_titulo_domingonext" id="disciplina_titulo_domingonext"></span>
                                            </h1>
                                        </div>

                                        <div class="card-content">
                                            <div class="card-body bg-transparent">

                                                <div name="contenido_domingo_siguiente" id="contenido_domingo_siguiente">
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row col-lg-12 col-md-12 col-sm-12">
                        <div class="col-lg-12 col-md-12 col-12 text-center">
                            <h4 class="text-verdeb">#SEMANABEATNESS</h4>
                            <img src="<?php echo base_url('almacenamiento/calendario/platform.png') ?>" alt="" class="img-fluid">
                        </div>
                    </div>
                </section>
                <!-- End -->
            </div>
        </div>
    </div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->


    <!-- <footer class="footer footer-static footer-light navbar-shadow">
        <p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2 container center-layout"><span class="float-md-left d-block d-md-inline-block">Copyright &copy; 2018 <a class="text-bold-800 grey darken-2" href="https://themeforest.net/user/pixinvent/portfolio?ref=pixinvent" target="_blank">PIXINVENT </a>, All rights reserved. </span><span class="float-md-right d-block d-md-inline-blockd-none d-lg-block">Hand-crafted & Made with <i class="ft-heart pink"></i></span></p>
    </footer> -->

    <!-- BEGIN VENDOR JS-->
    <script src="<?php echo base_url(); ?>app-assets/vendors/js/vendors.min.js"></script>
    <!-- BEGIN VENDOR JS-->
    <!-- BEGIN PAGE VENDOR JS-->
    <script src="<?php echo base_url(); ?>app-assets/vendors/js/ui/jquery.sticky.js"></script>
    <!-- END PAGE VENDOR JS-->
    <!-- BEGIN ROBUST JS-->
    <script src="<?php echo base_url(); ?>app-assets/js/core/app-menu.js"></script>
    <script src="<?php echo base_url(); ?>app-assets/js/core/app.js"></script>
    <!-- END ROBUST JS-->
    <!-- BEGIN PAGE LEVEL JS-->
    <script src="<?php echo base_url(); ?>app-assets/js/scripts/navs/navs.js"></script>
    <!-- END PAGE LEVEL JS-->
    <?php if (isset($scripts) && is_array($scripts)) : ?>
        <?php foreach ($scripts as $script) : ?>
            <script type="text/javascript" src="<?php echo !$script['es_rel'] ? $script['src'] : base_url() . 'assets/js/' . $script['src']; ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>

</body>

</html>