var table;
var actual_url = document.URL;
var method_call = "";
var flag_editando = false;

if (actual_url.indexOf("index") < 0) {
    method_call = "ventas/";
}

/**
 * Esta línea desactiva los mensajes de error de DataTables();
 */
$.fn.dataTable.ext.errMode = 'throw';

$(document).ready(function () {
    table = $('#tabla').DataTable({
        "scrollX": true,
        "deferRender": true,
        'processing': true,
        "order": [[0, "desc"]],
        "lengthMenu": [[25, 50, 100, 250, 500, -1], [25, 50, 100, 250, 500, "Todos"]],
        "ajax": {
            "url": method_call + "get_lista_de_ventas_del_mes_para_fd_con_permisos",
            "type": 'POST'
        },

        "columns": [
            { "data": "id" },
            { "data": "concepto" },
            { "data": "metodo_de_pago" },
            { "data": "comprador" },
            { "data": "categoria" },
            { "data": "estatus" },
            { "data": "costo" },
            { "data": "cantidad" },
            { "data": "total" },
            { "data": "fecha_venta" },
            { "data": "usuario_id" },
            { "data": "comprador_correo" },
            { "data": "comprador_nombre_completo" },
            { "data": "asignacion_id" },
            { "data": "asignacion" },
            { "data": "asignacion_vigencia_en_dias" },
            { "data": "asignacion_clases_del_plan" },
            { "data": "asignacion_openpay_suscripcion_id" },
            { "data": "asignacion_openpay_cliente_id" },
            { "data": "asignacion_suscripcion_estatus_del_pago" },
            { "data": "asignacion_suscripcion_fecha_de_actualizacion" },
            { "data": "sucursal" },
            { "data": "vendedor" },
            { "data": "opciones" },
        ],
        "createdRow": createEditableCells,
        'language': {
            "sProcessing": '<i class="fa fa-spinner spinner"></i> Cargando...',
            "sLengthMenu": "Mostrar _MENU_",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla =(",
            "sInfo": "Mostrando del _START_ al _END_ de _TOTAL_",
            "sInfoEmpty": "Mostrando del 0 al 0 de 0",
            "sInfoFiltered": "(filtrado _MAX_)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "&nbsp;",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": ">",
                "sPrevious": "<"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            },
            "buttons": {
                "copy": "Copiar",
                "colvis": "Visibilidad"
            }
        },
    });

    var buttons = new $.fn.dataTable.Buttons(table, {
        buttons: [
            {
                extend: 'excelHtml5',
                className: 'custom-button'

            }
        ]
    }).container().appendTo($('#buttons'));

    // Detectar doble clic en celda editable
    $('#tabla').on('dblclick', 'td.editable-cell', function () {
        if (!flag_editando) {

            flag_editando = true; // Marcar como en edición

            var celda_seleccionada = $(this); // Obtener la celda seleccionada
            var columna_indice = celda_seleccionada.index(); // Obtener el nombre de la columna según el índice
            var columna_nombres_list = table.settings().init().columns;
            var columna_nombre = columna_nombres_list[columna_indice].data;
            var valor_original_de_celda = celda_seleccionada.text();

            if (columna_nombre === "costo") {
                var input = generar_campo_de_celda_a_editar('numero', valor_original_de_celda);
            } else if (columna_nombre === "total") {
                var input = generar_campo_de_celda_a_editar('numero', valor_original_de_celda);
            } else {
                var input = generar_campo_de_celda_a_editar('texto', valor_original_de_celda, null);
            }

            celda_seleccionada.data('valor_original_guardado', valor_original_de_celda); // Almacena el valor original en la celda
            celda_seleccionada.html(input);

            input.focus();

            // Guardar los cambios al salir del campo de entrada
            input.blur(function () {
                console.log(input.val());
                guardar_valor_de_celda(celda_seleccionada, columna_nombre, input);
            });

            // Escuchar el evento keydown para detectar "Enter"
            input.keydown(function (event) {
                if (event.which === 13) {
                    guardar_valor_de_celda(celda_seleccionada, columna_nombre, input);
                }
            });

        }
    });

    // Función para guardar el valor de la celda
    function guardar_valor_de_celda(celda_seleccionada, columna_nombre, input) {

        var valor_nuevo_de_celda = input.val();

        if (columna_nombre === "costo") {
            valor_nuevo_de_celda = generar_salida_de_celda_editada('numero', valor_nuevo_de_celda, celda_seleccionada);
        } else if (columna_nombre === "total") {
            valor_nuevo_de_celda = generar_salida_de_celda_editada('numero', valor_nuevo_de_celda, celda_seleccionada);
        } else {
            valor_nuevo_de_celda = generar_salida_de_celda_editada('texto', valor_nuevo_de_celda, celda_seleccionada);
        }

        // Obtener la fila y los datos correspondientes
        var fila_tabla = table.row(celda_seleccionada.closest('tr'));
        var datos_fila_tabla = fila_tabla.data();

        // Realizar una solicitud AJAX para actualizar el dato en la base de datos
        $.ajax({
            url: method_call + "actualizar", // Actualiza con la ruta correcta
            method: 'POST',
            data: {
                id: datos_fila_tabla.id,
                columna: columna_nombre,
                nuevoValor: valor_nuevo_de_celda
            },
            success: function (response) {
                console.log('Dato actualizado en la base de datos');
                console.log('valor nuevo: ' + valor_nuevo_de_celda);
                console.log('valor id: ' + datos_fila_tabla.id);
                console.log(response);

                // Encuentra la fila correspondiente usando el id antiguo
                var row = table.rows().indexes().filter(function (idx) {
                    return table.cell(idx, 3).data() == datos_fila_tabla.id;
                });

                flag_editando = false; // Marcar como fuera de edición
            },
            error: function (xhr, status, error) {
                console.error('Error al actualizar el dato: ' + error);

                // Crear una alerta de Bootstrap
                var alertHtml = `
                <div class="alert bg-danger alert-icon-left alert-dismissible mb-2 font-small-3" role="alert">
                    <span class="alert-icon"><i class="fa fa-thumbs-o-down"></i></span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    Los datos editados ya existen en otra clase
                </div>
            `;

                // Insertar la alerta en el contenedor
                document.getElementById('alert-container').innerHTML = alertHtml;

                // Restaurar el valor original en caso de error
                celda_seleccionada.html(celda_seleccionada.data('valor_original_guardado'));
                flag_editando = false; // Marcar como fuera de edición
            }
        });
    }

    $("#mes_a_consultar").change(function () {
        //clear datatable
        table.clear().draw();

        $("#mes_a_consultar").load(this.value);
        mes_a_consultar = $(this).val();
        url = method_call + "get_lista_de_ventas_del_mes_para_fd_con_permisos/" + mes_a_consultar;
        reload_table();
        generar_datos_de_reporte_de_ventas(mes_a_consultar);
    });

});

function reload_table() {
    table.ajax.url(url).load();
    table.ajax.reload(null, false); //reload datatable ajax 
}

function generar_datos_de_reporte_de_ventas(mes_a_consultar_var) {
    if (mes_a_consultar_var == null) {

        $.ajax({
            url: method_call + "get_numeros_de_ventas_del_mes_para_fd_con_permisos",
            type: "GET",
            dataType: 'json',
            success: function (data) {
                $.each(data, function (index, item) {
                    if (document.getElementById("no_ventas")) {
                        document.getElementById('no_ventas').innerHTML = item.no_ventas;
                    }

                    if (document.getElementById("ventas_total")) {
                        document.getElementById('ventas_total').innerHTML = item.ventas_total;
                    }

                    if (document.getElementById("no_ventas_canceladas_total")) {
                        document.getElementById('no_ventas_canceladas_total').innerHTML = item.no_ventas_canceladas_total;
                    }

                    if (document.getElementById("no_ventas_efectivo")) {
                        document.getElementById('no_ventas_efectivo').innerHTML = item.no_ventas_efectivo;
                    }
                    if (document.getElementById("ventas_efectivo")) {
                        document.getElementById('ventas_efectivo').innerHTML = item.ventas_efectivo;
                    }

                    if (document.getElementById("no_ventas_tarjeta")) {
                        document.getElementById('no_ventas_tarjeta').innerHTML = item.no_ventas_tarjeta;
                    }
                    if (document.getElementById("ventas_tarjeta")) {
                        document.getElementById('ventas_tarjeta').innerHTML = item.ventas_tarjeta;
                    }

                    if (document.getElementById("no_ventas_openpay")) {
                        document.getElementById('no_ventas_openpay').innerHTML = item.no_ventas_openpay;
                    }
                    if (document.getElementById("ventas_openpay")) {
                        document.getElementById('ventas_openpay').innerHTML = item.ventas_openpay;
                    }

                    if (document.getElementById("no_ventas_openpay_b3")) {
                        document.getElementById('no_ventas_openpay_b3').innerHTML = item.no_ventas_openpay_b3;
                    }
                    if (document.getElementById("ventas_openpay_b3")) {
                        document.getElementById('ventas_openpay_b3').innerHTML = item.ventas_openpay_b3;
                    }

                    if (document.getElementById("no_ventas_openpay_insan3")) {
                        document.getElementById('no_ventas_openpay_insan3').innerHTML = item.no_ventas_openpay_insan3;
                    }
                    if (document.getElementById("ventas_openpay_insan3")) {
                        document.getElementById('ventas_openpay_insan3').innerHTML = item.ventas_openpay_insan3;
                    }

                    if (document.getElementById("no_ventas_b3family")) {
                        document.getElementById('no_ventas_b3family').innerHTML = item.no_ventas_b3family;
                    }
                    if (document.getElementById("ventas_b3family")) {
                        document.getElementById('ventas_b3family').innerHTML = item.ventas_b3family;
                    }

                    if (document.getElementById("no_ventas_suscripcion")) {
                        document.getElementById('no_ventas_suscripcion').innerHTML = item.no_ventas_suscripcion;
                    }
                    if (document.getElementById("ventas_suscripcion")) {
                        document.getElementById('ventas_suscripcion').innerHTML = item.ventas_suscripcion;
                    }

                    if (document.getElementById("no_periodos_prueba_suscripcion")) {
                        document.getElementById('no_periodos_prueba_suscripcion').innerHTML = item.no_periodos_prueba_suscripcion;
                    }
                    if (document.getElementById("periodos_prueba_suscripcion")) {
                        document.getElementById('periodos_prueba_suscripcion').innerHTML = item.periodos_prueba_suscripcion;
                    }

                    /** Metodos de pago B3 */

                    if (document.getElementById("b3_no_ventas_total")) {
                        document.getElementById('b3_no_ventas_total').innerHTML = item.b3_no_ventas_total;
                    }
                    if (document.getElementById("b3_ventas_total")) {
                        document.getElementById('b3_ventas_total').innerHTML = item.b3_ventas_total;
                    }

                    if (document.getElementById("b3_no_ventas_efectivo")) {
                        document.getElementById('b3_no_ventas_efectivo').innerHTML = item.b3_no_ventas_efectivo;
                    }
                    if (document.getElementById("b3_ventas_efectivo")) {
                        document.getElementById('b3_ventas_efectivo').innerHTML = item.b3_ventas_efectivo;
                    }

                    if (document.getElementById("b3_no_ventas_tarjeta")) {
                        document.getElementById('b3_no_ventas_tarjeta').innerHTML = item.b3_no_ventas_tarjeta;
                    }
                    if (document.getElementById("b3_ventas_tarjeta")) {
                        document.getElementById('b3_ventas_tarjeta').innerHTML = item.b3_ventas_tarjeta;
                    }

                    if (document.getElementById("b3_no_ventas_b3family")) {
                        document.getElementById('b3_no_ventas_b3family').innerHTML = item.b3_no_ventas_b3family;
                    }
                    if (document.getElementById("b3_ventas_b3family")) {
                        document.getElementById('b3_ventas_b3family').innerHTML = item.b3_ventas_b3family;
                    }

                    /** Metodos de pago VELA */

                    if (document.getElementById("vela_no_ventas_total")) {
                        document.getElementById('vela_no_ventas_total').innerHTML = item.vela_no_ventas_total;
                    }
                    if (document.getElementById("vela_ventas_total")) {
                        document.getElementById('vela_ventas_total').innerHTML = item.vela_ventas_total;
                    }

                    if (document.getElementById("vela_no_ventas_efectivo")) {
                        document.getElementById('vela_no_ventas_efectivo').innerHTML = item.vela_no_ventas_efectivo;
                    }
                    if (document.getElementById("vela_ventas_efectivo")) {
                        document.getElementById('vela_ventas_efectivo').innerHTML = item.vela_ventas_efectivo;
                    }

                    if (document.getElementById("vela_no_ventas_tarjeta")) {
                        document.getElementById('vela_no_ventas_tarjeta').innerHTML = item.vela_no_ventas_tarjeta;
                    }
                    if (document.getElementById("vela_ventas_tarjeta")) {
                        document.getElementById('vela_ventas_tarjeta').innerHTML = item.vela_ventas_tarjeta;
                    }

                    if (document.getElementById("vela_no_ventas_b3family")) {
                        document.getElementById('vela_no_ventas_b3family').innerHTML = item.vela_no_ventas_b3family;
                    }
                    if (document.getElementById("vela_ventas_b3family")) {
                        document.getElementById('vela_ventas_b3family').innerHTML = item.vela_ventas_b3family;
                    }
                    /** Metodos de pago DORADO */

                    if (document.getElementById("dorado_no_ventas_total")) {
                        document.getElementById('dorado_no_ventas_total').innerHTML = item.dorado_no_ventas_total;
                    }
                    if (document.getElementById("dorado_ventas_total")) {
                        document.getElementById('dorado_ventas_total').innerHTML = item.dorado_ventas_total;
                    }

                    if (document.getElementById("dorado_no_ventas_efectivo")) {
                        document.getElementById('dorado_no_ventas_efectivo').innerHTML = item.dorado_no_ventas_efectivo;
                    }
                    if (document.getElementById("dorado_ventas_efectivo")) {
                        document.getElementById('dorado_ventas_efectivo').innerHTML = item.dorado_ventas_efectivo;
                    }

                    if (document.getElementById("dorado_no_ventas_tarjeta")) {
                        document.getElementById('dorado_no_ventas_tarjeta').innerHTML = item.dorado_no_ventas_tarjeta;
                    }
                    if (document.getElementById("dorado_ventas_tarjeta")) {
                        document.getElementById('dorado_ventas_tarjeta').innerHTML = item.dorado_ventas_tarjeta;
                    }

                    if (document.getElementById("dorado_no_ventas_b3family")) {
                        document.getElementById('dorado_no_ventas_b3family').innerHTML = item.dorado_no_ventas_b3family;
                    }
                    if (document.getElementById("dorado_ventas_b3family")) {
                        document.getElementById('dorado_ventas_b3family').innerHTML = item.dorado_ventas_b3family;
                    }
                    /** Metodos de pago insan3 */

                    if (document.getElementById("insan3_no_ventas_total")) {
                        document.getElementById('insan3_no_ventas_total').innerHTML = item.insan3_no_ventas_total;
                    }
                    if (document.getElementById("insan3_ventas_total")) {
                        document.getElementById('insan3_ventas_total').innerHTML = item.insan3_ventas_total;
                    }

                    if (document.getElementById("insan3_no_ventas_efectivo")) {
                        document.getElementById('insan3_no_ventas_efectivo').innerHTML = item.insan3_no_ventas_efectivo;
                    }
                    if (document.getElementById("insan3_ventas_efectivo")) {
                        document.getElementById('insan3_ventas_efectivo').innerHTML = item.insan3_ventas_efectivo;
                    }

                    if (document.getElementById("insan3_no_ventas_tarjeta")) {
                        document.getElementById('insan3_no_ventas_tarjeta').innerHTML = item.insan3_no_ventas_tarjeta;
                    }
                    if (document.getElementById("insan3_ventas_tarjeta")) {
                        document.getElementById('insan3_ventas_tarjeta').innerHTML = item.insan3_ventas_tarjeta;
                    }

                    if (document.getElementById("insan3_no_ventas_b3family")) {
                        document.getElementById('insan3_no_ventas_b3family').innerHTML = item.insan3_no_ventas_b3family;
                    }
                    if (document.getElementById("insan3_ventas_b3family")) {
                        document.getElementById('insan3_ventas_b3family').innerHTML = item.insan3_ventas_b3family;
                    }
                });
            }
        });

    } else {

        $.ajax({
            url: method_call + "get_numeros_de_ventas_del_mes_para_fd_con_permisos/" + mes_a_consultar_var,
            type: "GET",
            dataType: 'json',
            success: function (data) {
                $.each(data, function (index, item) {
                    document.getElementById('mes_reportado').innerHTML = item.mes_reportado;

                    if (document.getElementById("no_ventas")) {
                        document.getElementById('no_ventas').innerHTML = item.no_ventas;
                    }

                    if (document.getElementById("ventas_total")) {
                        document.getElementById('ventas_total').innerHTML = item.ventas_total;
                    }

                    if (document.getElementById("no_ventas_canceladas_total")) {
                        document.getElementById('no_ventas_canceladas_total').innerHTML = item.no_ventas_canceladas_total;
                    }

                    if (document.getElementById("no_ventas_efectivo")) {
                        document.getElementById('no_ventas_efectivo').innerHTML = item.no_ventas_efectivo;
                    }
                    if (document.getElementById("ventas_efectivo")) {
                        document.getElementById('ventas_efectivo').innerHTML = item.ventas_efectivo;
                    }

                    if (document.getElementById("no_ventas_tarjeta")) {
                        document.getElementById('no_ventas_tarjeta').innerHTML = item.no_ventas_tarjeta;
                    }
                    if (document.getElementById("ventas_tarjeta")) {
                        document.getElementById('ventas_tarjeta').innerHTML = item.ventas_tarjeta;
                    }

                    if (document.getElementById("no_ventas_openpay")) {
                        document.getElementById('no_ventas_openpay').innerHTML = item.no_ventas_openpay;
                    }
                    if (document.getElementById("ventas_openpay")) {
                        document.getElementById('ventas_openpay').innerHTML = item.ventas_openpay;
                    }

                    if (document.getElementById("no_ventas_openpay_b3")) {
                        document.getElementById('no_ventas_openpay_b3').innerHTML = item.no_ventas_openpay_b3;
                    }
                    if (document.getElementById("ventas_openpay_b3")) {
                        document.getElementById('ventas_openpay_b3').innerHTML = item.ventas_openpay_b3;
                    }

                    if (document.getElementById("no_ventas_openpay_insan3")) {
                        document.getElementById('no_ventas_openpay_insan3').innerHTML = item.no_ventas_openpay_insan3;
                    }
                    if (document.getElementById("ventas_openpay_insan3")) {
                        document.getElementById('ventas_openpay_insan3').innerHTML = item.ventas_openpay_insan3;
                    }

                    if (document.getElementById("no_ventas_b3family")) {
                        document.getElementById('no_ventas_b3family').innerHTML = item.no_ventas_b3family;
                    }
                    if (document.getElementById("ventas_b3family")) {
                        document.getElementById('ventas_b3family').innerHTML = item.ventas_b3family;
                    }

                    if (document.getElementById("no_ventas_suscripcion")) {
                        document.getElementById('no_ventas_suscripcion').innerHTML = item.no_ventas_suscripcion;
                    }
                    if (document.getElementById("ventas_suscripcion")) {
                        document.getElementById('ventas_suscripcion').innerHTML = item.ventas_suscripcion;
                    }

                    if (document.getElementById("no_periodos_prueba_suscripcion")) {
                        document.getElementById('no_periodos_prueba_suscripcion').innerHTML = item.no_periodos_prueba_suscripcion;
                    }
                    if (document.getElementById("periodos_prueba_suscripcion")) {
                        document.getElementById('periodos_prueba_suscripcion').innerHTML = item.periodos_prueba_suscripcion;
                    }

                    /** Metodos de pago B3 */

                    if (document.getElementById("b3_no_ventas_total")) {
                        document.getElementById('b3_no_ventas_total').innerHTML = item.b3_no_ventas_total;
                    }
                    if (document.getElementById("b3_ventas_total")) {
                        document.getElementById('b3_ventas_total').innerHTML = item.b3_ventas_total;
                    }

                    if (document.getElementById("b3_no_ventas_efectivo")) {
                        document.getElementById('b3_no_ventas_efectivo').innerHTML = item.b3_no_ventas_efectivo;
                    }
                    if (document.getElementById("b3_ventas_efectivo")) {
                        document.getElementById('b3_ventas_efectivo').innerHTML = item.b3_ventas_efectivo;
                    }

                    if (document.getElementById("b3_no_ventas_tarjeta")) {
                        document.getElementById('b3_no_ventas_tarjeta').innerHTML = item.b3_no_ventas_tarjeta;
                    }
                    if (document.getElementById("b3_ventas_tarjeta")) {
                        document.getElementById('b3_ventas_tarjeta').innerHTML = item.b3_ventas_tarjeta;
                    }

                    if (document.getElementById("b3_no_ventas_b3family")) {
                        document.getElementById('b3_no_ventas_b3family').innerHTML = item.b3_no_ventas_b3family;
                    }
                    if (document.getElementById("b3_ventas_b3family")) {
                        document.getElementById('b3_ventas_b3family').innerHTML = item.b3_ventas_b3family;
                    }

                    /** Metodos de pago VELA */

                    if (document.getElementById("vela_no_ventas_total")) {
                        document.getElementById('vela_no_ventas_total').innerHTML = item.vela_no_ventas_total;
                    }
                    if (document.getElementById("vela_ventas_total")) {
                        document.getElementById('vela_ventas_total').innerHTML = item.vela_ventas_total;
                    }

                    if (document.getElementById("vela_no_ventas_efectivo")) {
                        document.getElementById('vela_no_ventas_efectivo').innerHTML = item.vela_no_ventas_efectivo;
                    }
                    if (document.getElementById("vela_ventas_efectivo")) {
                        document.getElementById('vela_ventas_efectivo').innerHTML = item.vela_ventas_efectivo;
                    }

                    if (document.getElementById("vela_no_ventas_tarjeta")) {
                        document.getElementById('vela_no_ventas_tarjeta').innerHTML = item.vela_no_ventas_tarjeta;
                    }
                    if (document.getElementById("vela_ventas_tarjeta")) {
                        document.getElementById('vela_ventas_tarjeta').innerHTML = item.vela_ventas_tarjeta;
                    }

                    if (document.getElementById("vela_no_ventas_b3family")) {
                        document.getElementById('vela_no_ventas_b3family').innerHTML = item.vela_no_ventas_b3family;
                    }
                    if (document.getElementById("vela_ventas_b3family")) {
                        document.getElementById('vela_ventas_b3family').innerHTML = item.vela_ventas_b3family;
                    }

                    /** Metodos de pago DORADO */

                    if (document.getElementById("dorado_no_ventas_total")) {
                        document.getElementById('dorado_no_ventas_total').innerHTML = item.dorado_no_ventas_total;
                    }
                    if (document.getElementById("dorado_ventas_total")) {
                        document.getElementById('dorado_ventas_total').innerHTML = item.dorado_ventas_total;
                    }

                    if (document.getElementById("dorado_no_ventas_efectivo")) {
                        document.getElementById('dorado_no_ventas_efectivo').innerHTML = item.dorado_no_ventas_efectivo;
                    }
                    if (document.getElementById("dorado_ventas_efectivo")) {
                        document.getElementById('dorado_ventas_efectivo').innerHTML = item.dorado_ventas_efectivo;
                    }

                    if (document.getElementById("dorado_no_ventas_tarjeta")) {
                        document.getElementById('dorado_no_ventas_tarjeta').innerHTML = item.dorado_no_ventas_tarjeta;
                    }
                    if (document.getElementById("dorado_ventas_tarjeta")) {
                        document.getElementById('dorado_ventas_tarjeta').innerHTML = item.dorado_ventas_tarjeta;
                    }

                    if (document.getElementById("dorado_no_ventas_b3family")) {
                        document.getElementById('dorado_no_ventas_b3family').innerHTML = item.dorado_no_ventas_b3family;
                    }
                    if (document.getElementById("dorado_ventas_b3family")) {
                        document.getElementById('dorado_ventas_b3family').innerHTML = item.dorado_ventas_b3family;
                    }
                    /** Metodos de pago insan3 */

                    if (document.getElementById("insan3_no_ventas_total")) {
                        document.getElementById('insan3_no_ventas_total').innerHTML = item.insan3_no_ventas_total;
                    }
                    if (document.getElementById("insan3_ventas_total")) {
                        document.getElementById('insan3_ventas_total').innerHTML = item.insan3_ventas_total;
                    }

                    if (document.getElementById("insan3_no_ventas_efectivo")) {
                        document.getElementById('insan3_no_ventas_efectivo').innerHTML = item.insan3_no_ventas_efectivo;
                    }
                    if (document.getElementById("insan3_ventas_efectivo")) {
                        document.getElementById('insan3_ventas_efectivo').innerHTML = item.insan3_ventas_efectivo;
                    }

                    if (document.getElementById("insan3_no_ventas_tarjeta")) {
                        document.getElementById('insan3_no_ventas_tarjeta').innerHTML = item.insan3_no_ventas_tarjeta;
                    }
                    if (document.getElementById("insan3_ventas_tarjeta")) {
                        document.getElementById('insan3_ventas_tarjeta').innerHTML = item.insan3_ventas_tarjeta;
                    }

                    if (document.getElementById("insan3_no_ventas_b3family")) {
                        document.getElementById('insan3_no_ventas_b3family').innerHTML = item.insan3_no_ventas_b3family;
                    }
                    if (document.getElementById("insan3_ventas_b3family")) {
                        document.getElementById('insan3_ventas_b3family').innerHTML = item.insan3_ventas_b3family;
                    }
                });
            }
        });
    }
}

function createEditableCells(row, data, dataIndex) {
    var columnsToEdit = [6, 8];
    $.each(columnsToEdit, function (index, columnIndex) {
        $('td:eq(' + columnIndex + ')', row).addClass('editable-cell');
    });
}