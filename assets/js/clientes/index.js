// ============================================================
// ================ CATEGORÍA: VARIABLES GLOBALES =============
// ============================================================

var table;
var actual_url = document.URL;
var method_call = "";
var url;
var flag_editando = false;
var select_sucursal = [];

// Determinar ruta a utilizar según el URL actual
if (actual_url.indexOf("index") < 0) {
    method_call = "clientes/";
}

/**
 * Desactivación de mensajes de error por defecto en DataTables.
 * Esto evita que DataTables muestre mensajes emergentes de error.
 */
$.fn.dataTable.ext.errMode = 'throw';

// ============================================================
// =========== CATEGORÍA: INICIALIZACIÓN DE LA TABLA ===========
// ============================================================

$(function () {
    // MODIFICACIÓN: Se agrega comentario explicando el propósito de la URL.
    // URL para cargar la lista de clientes.
    url = method_call + "get_lista_de_clientes";

    // Obtener las opciones para el select 'sucursal'
    obtener_opciones_select_sucursal();

    // Inicialización de la DataTable con sus configuraciones.
    table = $('#table').DataTable({
        "scrollX": true,
        "deferRender": true,
        'processing': true,
        "order": [[1, "desc"]],
        "lengthMenu": [[25, 50, 100, 250, 500, -1], [25, 50, 100, 250, 500, "Todos"]],
        "ajax": {
            "url": url,
            "type": 'POST'
        },
        "columns": [
            { "data": "opciones" },
            { "data": "id" },
            { "data": "nombre_completo" },
            { "data": "correo" },
            { "data": "no_telefono" },
            { "data": "sucursal_id" },
            { "data": "fecha_registro" },
            { "data": "es_estudiante" },
            { "data": "es_estudiante_vigencia" },
            { "data": "es_empresarial" },
            { "data": "dominio" },
            { "data": "estatus" },
        ],
        // MODIFICACIÓN: Comentario explicando la función para celdas editables.
        // Esta función crea la clase 'editable-cell' en las columnas configuradas.
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

    // Botón para exportar a Excel
    var buttons = new $.fn.dataTable.Buttons(table, {
        buttons: [
            {
                extend: 'excelHtml5',
                className: 'custom-button'
            }
        ]
    }).container().appendTo($('#buttons'));

    // ============================================================
    // =========== CATEGORÍA: EVENTOS SOBRE LA TABLA ==============
    // ============================================================

    // Evento: Doble clic en la celda editable para iniciar edición en línea.
    $('#table').on('dblclick', 'td.editable-cell', function () {
        if (!flag_editando) {

            flag_editando = true; // Marcamos que estamos editando

            var celda_seleccionada = $(this);
            var columna_indice = celda_seleccionada.index();
            var columna_nombres_list = table.settings().init().columns;
            var columna_nombre = columna_nombres_list[columna_indice].data;
            var valor_original_de_celda = celda_seleccionada.text();

            // Si la columna es 'sucursal_id', generamos un select
            if (columna_nombre === "sucursal_id") {
                var input = generar_campo_de_celda_a_editar('select_indice_instructor', valor_original_de_celda, select_sucursal);
            }

            // Guardar el valor original antes de iniciar edición
            celda_seleccionada.data('valor_original_guardado', valor_original_de_celda);
            celda_seleccionada.html(input);

            input.focus();

            // Evento: Al perder el foco, guardar cambios
            input.blur(function () {
                guardar_valor_de_celda(celda_seleccionada, columna_nombre, input);
            });

            // Evento: Si presionan Enter mientras editan, guardar cambios
            input.keydown(function (event) {
                if (event.which === 13) {
                    guardar_valor_de_celda(celda_seleccionada, columna_nombre, input);
                }
            });

        }
    });

    // ============================================================
    // ================ CATEGORÍA: FUNCIONES AJAX =================
    // ============================================================

    // Función para guardar el valor editado de la celda en el servidor vía AJAX
    function guardar_valor_de_celda(celda_seleccionada, columna_nombre, input) {
        var valor_nuevo_de_celda = input.val();

        // Si no hay cambios, restaurar valor y salir
        if (celda_seleccionada.data('valor_original_guardado') === valor_nuevo_de_celda) {
            celda_seleccionada.html(celda_seleccionada.data('valor_original_guardado'));
            flag_editando = false;
            return;
        }

        if (columna_nombre === "sucursal_id") {
            valor_nuevo_de_celda = generar_salida_de_celda_editada('select', valor_nuevo_de_celda, celda_seleccionada);
        }

        var fila_tabla = table.row(celda_seleccionada.closest('tr'));
        var datos_fila_tabla = fila_tabla.data();

        function formatoNombrePropio(nombre) {
            return nombre.toLowerCase().replace(/\b\w/g, function (char) {
                return char.toUpperCase();
            });
        }

        if (columna_nombre === 'sucursal_id') {
            for (var i = 0; i < select_sucursal.length; i++) {
                if (select_sucursal[i].nombre === formatoNombrePropio(valor_nuevo_de_celda)) {
                    valor_nuevo_de_celda = select_sucursal[i].valor;
                    break;
                }
            }
        }

        // Envío AJAX para actualizar el dato en la base de datos
        $.ajax({
            url: method_call + "actualizar",
            method: 'POST',
            data: {
                identificador: datos_fila_tabla.id,
                columna: columna_nombre,
                nuevoValor: valor_nuevo_de_celda
            },
            success: function (response) {
                console.log('Dato actualizado en la base de datos');
                flag_editando = false;
            },
            error: function (xhr, status, error) {
                console.error('Error al actualizar el dato: ' + error);

                // Alerta de error si no se puede actualizar
                var alertHtml = `
                <div class="alert bg-danger alert-icon-left alert-dismissible mb-2 font-small-3" role="alert">
                    <span class="alert-icon"><i class="fa fa-thumbs-o-down"></i></span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    Los datos editados ya existen en otra clase
                </div>
                `;

                document.getElementById('alert-container').innerHTML = alertHtml;
                celda_seleccionada.html(celda_seleccionada.data('valor_original_guardado'));
                flag_editando = false;
            }
        });
    }

});

// ============================================================
// ========= CATEGORÍA: FUNCIONES DE ESTATUS (SUSPENDER) ======
// ============================================================

function suspender(id) {
    // Cambiar cursor mientras se realiza la operación
    document.body.style.cursor = 'wait';

    $.ajax({
        url: method_call + "suspender/" + id,
        type: "POST",
        dataType: "JSON",
        success: function (data) {
            table.ajax.reload();
            var alert = '' +
                '<div class="alert bg-success alert-icon-left alert-dismissible mb-2" role="alert">' +
                '<span class="alert-icon"><i class="fa fa-thumbs-o-up"></i></span>' +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                '<span aria-hidden="true">×</span>' +
                '</button>' +
                'Cliente <a href="clientes/editar/' + id + '" class="white"><b><u>#' + id + '</u></b></a> suspendido correctamente.' +
                '</div>';
            $('#mensaje-js').html(alert);
            document.body.style.cursor = 'default';

        }, error: function (jqXHR, textStatus, errorThrown) {
            var alert = '' +
                '<div class="alert alert-icon-left alert-danger alert-dismissible mb-2" role="alert">' +
                '<span class="alert-icon"><i class="fa fa-thumbs-o-down"></i></span>' +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                '<span aria-hidden="true">×</span>' +
                '</button>' +
                'Ha ocurrido un error, por favor inténtalo más tarde. (J1)' +
                '</div>';
            $('#mensaje-js').html(alert);
            document.body.style.cursor = 'default';
        }
    });
}

// ============================================================
// ======== CATEGORÍA: FUNCIONES PARA OBTENER DATOS AJAX ======
// ============================================================

async function obtener_opciones_select_sucursal() {
    // Obtiene las opciones del select de sucursales por AJAX
    $.ajax({
        url: method_call + "obtener_opciones_select_sucursal",
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            select_sucursal = data;
            console.log('Opciones de sucursal cargadas:', select_sucursal);
        },
        error: function (xhr, status, error) {
            console.error('Error al obtener opciones de sucursal: ' + error);
        }
    });
}

// ============================================================
// ============= CATEGORÍA: FUNCIONES UTILITARIAS =============
// ============================================================

function createEditableCells(row, data, dataIndex) {
    // Asignar la clase 'editable-cell' a las celdas que se puedan editar
    var columnsToEdit = [5]; // Índice de la columna 'sucursal_id'
    $.each(columnsToEdit, function (index, columnIndex) {
        $('td:eq(' + columnIndex + ')', row).addClass('editable-cell');
    });
}

// Estas funciones (generar_campo_de_celda_a_editar, generar_salida_de_celda_editada)
// se asumen definidas en otro archivo o parte del código. Si no existen, se deberían
// definir antes de usar.

// ============================================================
// =========== FIN DEL ARCHIVO CON MEJORAS COMENTADAS =========
// ============================================================
