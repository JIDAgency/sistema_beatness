<!DOCTYPE html>
<html>
    <head>
    </head>
    <body>
        <div class="ticket">
            <style>
                * {
                    font-size: 12px;
                    font-family: sans-serif;
                }

                td,
                th,
                tr,
                table {
                    border-top: 1px solid black;
                    border-collapse: collapse;
                }

                td.producto,
                th.producto {
                    width: 100px;
                    max-width: 100px;
                }

                td.cantidad,
                th.cantidad {
                    width: 50px;
                    max-width: 50px;
                    word-break: break-all;
                }

                td.precio,
                th.precio {
                    width: 50px;
                    max-width: 50px;
                    word-break: break-all;
                }

                .centrado {
                    text-align: center;
                    align-content: center;
                }

                .justificado {
                    text-align: justify;
                    align-content: center;
                }

                .terminos {
                    font-size: 9px;
                }

                .ticket {
                    width: 200px;
                    max-width: 200px;
                }

                img {
                    max-width: inherit;
                    width: inherit;
                }
                @media print {
                    .oculto-impresion,
                    .oculto-impresion * {
                        display: none !important;
                    }
                }
            </style>
            <img src="<?php echo base_url(); ?>almacenamiento/logos/logo.png" alt="Logotipo">
            <p class="centrado">
                <b><?php echo mb_strtoupper($empresa).', S.A. DE C.V.'; ?></b>
                <br>
                <?php echo $rfc; ?>
                <br>
                <small class="terminos"><?php echo $regimen_fiscal; ?></small>
                <br>
                <?php echo $domicilio_fiscal; ?>
                <br>
                <?php echo $fecha; ?>
            </p>
            <p class="centrado">
                <b><?php echo $no_venta; ?></b>
                <br>
                Suc. <?php echo $empresa." [".$sucursal_locacion."]"; ?>
                <br>
                Cliente: <?php echo $usuario_nombre; ?>
                <br>
                Método: <?php echo $metodo_pago_nombre; ?>
                <br>
                Atendió: <?php echo $vendedor; ?>
                <br>
                Fecha de venta: <br> <?php echo $fecha_venta; ?>
            </p>
            <table>
                <thead>
                    <tr>
                        <th class="cantidad">CANT</th>
                        <th class="producto">PRODUCTO</th>
                        <th class="precio">$$</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="cantidad"><?php echo $cantidad; ?></td>
                        <td class="producto"><?php echo $concepto; ?></td>
                        <td class="precio"><?php echo $costo; ?></td>
                    </tr>
                    <tr>
                        <td class="cantidad"></td>
                        <td class="producto">TOTAL</td>
                        <td class="precio"><?php echo $total; ?></td>
                    </tr>
                </tbody>
            </table>
            <p class="centrado">
                <?php echo $total_letras; ?>
            </p>
            <p class="centrado">
                ¡GRACIAS POR SU COMPRA!
                <br>
                <?php echo pagina(); ?>
                <br>
                <em><?php echo lema();?></em>
            </p>
            <p class="justificado terminos">
                Consulta nuestros términos y condiciones, así como nuestra política de privacidad en <?php echo terminos_del_servicio(); ?>.
                <br>
                <br>
                Las vigencias de nuestros planes se fijan estimando que el usuario deberá reservar 1 clase diaria aproximadamente. Una vez concluido el periodo de vigencia establecido en el plan este se dará por terminado.
                <br>
                <br>
                Al reservar una clase en <?php echo branding(); ?>, durante este periodo de contingencia, el cliente hace constar que asumirá las medidas de prevención al interior de las instalaciones como son: Toma obligatoria de temperatura, uso obligatorio de cubrebocas en todo momento, aplicación de gel desinfectante de manera continua y conservar la sana distancia en cada una de las áreas comunes. El uso de lockers y amenites por el momento se encontrarán suspendidos.
                <br>
                <br>
                Todo esto en virtud de garantizar su propia seguridad y la del personal que labora en el estudio.
            </p>
        </div>

        <button class="oculto-impresion" onclick="cerrar_ventana()">Regresar</button>
        <button class="oculto-impresion" onclick="imprimir()">Imprimir</button>
        
        <script>
            function imprimir() {
                window.print();
            }

            function cerrar_ventana() {
                if (confirm("¿Está seguro de que quiere cerrar esta ventana?")) {
                    window.close();
                }
            }
        </script>
    
    </body>
</html>