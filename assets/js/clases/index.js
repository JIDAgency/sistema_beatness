// Variables
var table;
var actual_url = document.URL;
var method_call = "";
var url;
var flag_editando = false;
var select_estatus_pago = [];

// Configuraciones
(actual_url.indexOf("index") < 0) ? method_call = "clases/" : method_call = "";
$.fn.dataTable.ext.errMode = 'throw'; // Configuración de manejo de errores de DataTables

$(document).ready(function () {
    // Inicializar
    url = method_call + "obtener_tabla_index"
    table = $('#table').DataTable({
        "scrollX": true,
        "deferRender": true,
        'processing': true,
        "order": [[0, "asc"]],
        "lengthMenu": [[25, 50, 100, 250, 500, -1], [25, 50, 100, 250, 500, "Todos"]],
        "ajax": {
            "url": url,
            "type": 'POST'
        },
        "columns": [
            { "data": "id" },
            { "data": "sku" },
            { "data": "disciplina" },
            { "data": "cupo" },
            { "data": "sucursal" },
            { "data": "instructor" },
            { "data": "dificultad" },
            { "data": "horario" },
            { "data": "horario_esp" },
            { "data": "estatus" },
            { "data": "intervalo_horas" },
            { "data": "cupo_restantes"},
            { "data": "cupo_original" },
            { "data": "cupo_reservado" },
            { "data": "inasistencias" },
            { "data": "lugares" },
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
            }
        }

    });

    // Detectar doble clic en celda editable
    $('#table').on('dblclick', 'td.editable-cell', function () {
        if (!flag_editando) {

            flag_editando = true; // Marcar como en edición

            var celda_seleccionada = $(this); // Obtener la celda seleccionada
            var columna_indice = celda_seleccionada.index(); // Obtener el nombre de la columna según el índice
            var columna_nombres_list = table.settings().init().columns;
            console.log(columna_nombres_list);
            var columna_nombre = columna_nombres_list[columna_indice].data;
            var valor_original_de_celda = celda_seleccionada.text();

            if (columna_nombre === "monto") {
                var input = generar_campo_de_celda_a_editar('numero', valor_original_de_celda, null)
            } else if (columna_nombre === "regimen_fiscal") {
                var input = generar_campo_de_celda_a_editar('select', valor_original_de_celda, select_regimen_fiscal, select_regimen_fiscal_moral);
            } else if (columna_nombre === "uso_cfdi") {
                var input = generar_campo_de_celda_a_editar('select', valor_original_de_celda, select_uso_cfdi, select_uso_cfdi_moral);
            } else if (columna_nombre === "estatus_factura") {
                var input = generar_campo_de_celda_a_editar('select', valor_original_de_celda, select_estatus_factura);
            } else {
                var input = generar_campo_de_celda_a_editar('texto', valor_original_de_celda, null);
            }

            celda_seleccionada.data('valor_original_guardado', valor_original_de_celda); // Almacena el valor original en la celda
            celda_seleccionada.html(input);

            input.focus();

            // Guardar los cambios al salir del campo de entrada
            input.blur(function () {
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

        // Si no hay cambios, no realizar la solicitud AJAX
        if (celda_seleccionada.data('valor_original_guardado') === valor_nuevo_de_celda) {
            celda_seleccionada.html(celda_seleccionada.data('valor_original_guardado')); // Restaurar el valor en la celda
            flag_editando = false; // Marcar como fuera de edición
            return; // Salir de la función sin hacer nada
        }

        if (columna_nombre === "monto") {
            valor_nuevo_de_celda = generar_salida_de_celda_editada('moneda', valor_nuevo_de_celda, celda_seleccionada);
        } else if (columna_nombre === "regimen_fiscal") {
            valor_nuevo_de_celda = generar_salida_de_celda_editada('select', valor_nuevo_de_celda, celda_seleccionada);
        } else if (columna_nombre === "uso_cfdi") {
            valor_nuevo_de_celda = generar_salida_de_celda_editada('select', valor_nuevo_de_celda, celda_seleccionada);
        } else if (columna_nombre === "estatus_factura") {
            valor_nuevo_de_celda = generar_salida_de_celda_editada('select', valor_nuevo_de_celda, celda_seleccionada);
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
                identificador: datos_fila_tabla.identificador,
                columna: columna_nombre,
                nuevoValor: valor_nuevo_de_celda
            },
            success: function (response) {
                console.log('Dato actualizado en la base de datos');
                console.log(response);
                flag_editando = false; // Marcar como fuera de edición
            },
            error: function (xhr, status, error) {
                console.error('Error al actualizar el dato: ' + error);
                // Restaurar el valor original en caso de error
                celda_seleccionada.html(celda_seleccionada.data('valor_original_guardado'));
                flag_editando = false; // Marcar como fuera de edición
            }
        });
    }
});

function createEditableCells(row, data, dataIndex) {
    var columnsToEdit = [5, 6, 7, 8, 9, 10, 12, 13];
    $.each(columnsToEdit, function (index, columnIndex) {
        $('td:eq(' + columnIndex + ')', row).addClass('editable-cell');
    });
}
