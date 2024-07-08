var table;

var actual_url = document.URL;
var method_call = "";
var url;
var flag_editando = false;
var select_sucursal = [];

if (actual_url.indexOf("index") < 0) {
    method_call = "clientes/";
}

/**
 * Este línea desactiva los mensajes de error de DataTables();
 */
$.fn.dataTable.ext.errMode = 'throw';

$(function () {
    url = method_call + "get_lista_de_clientes"
    obtener_opciones_select_sucursal(); // Obtención de opciones para el select 'sucursal'

    table = $('#table').DataTable({
        "scrollX": true,
        "deferRender": true,
        'processing': true,
        "order": [[0, "desc"]],
        "lengthMenu": [[25, 50, 100, 250, 500, -1], [25, 50, 100, 250, 500, "Todos"]],
        "ajax": {
            "url": url,
            "type": 'POST'
        },
        "columns": [
            { "data": "id" },
            { "data": "nombre_completo" },
            { "data": "correo" },
            { "data": "no_telefono" },
            { "data": "es_estudiante" },
            { "data": "es_estudiante_vigencia" },
            { "data": "es_empresarial" },
            { "data": "sucursal_id" },
            { "data": "dominio" },
            { "data": "estatus" },
            { "data": "fecha_registro" },
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
    $('#table').on('dblclick', 'td.editable-cell', function () {
        if (!flag_editando) {

            flag_editando = true; // Marcar como en edición

            var celda_seleccionada = $(this); // Obtener la celda seleccionada
            var columna_indice = celda_seleccionada.index(); // Obtener el nombre de la columna según el índice
            var columna_nombres_list = table.settings().init().columns;
            var columna_nombre = columna_nombres_list[columna_indice].data;
            var valor_original_de_celda = celda_seleccionada.text();

            if (columna_nombre === "sucursal_id") {
                var input = generar_campo_de_celda_a_editar('select_indice_instructor', valor_original_de_celda, select_sucursal);
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

        // Si no hay cambios, no realizar la solicitud AJAX
        if (celda_seleccionada.data('valor_original_guardado') === valor_nuevo_de_celda) {
            celda_seleccionada.html(celda_seleccionada.data('valor_original_guardado')); // Restaurar el valor en la celda
            flag_editando = false; // Marcar como fuera de edición
            return; // Salir de la función sin hacer nada
        }

        if (columna_nombre === "sucursal_id") {
            valor_nuevo_de_celda = generar_salida_de_celda_editada('select', valor_nuevo_de_celda, celda_seleccionada);
        }

        // Obtener la fila y los datos correspondientes
        var fila_tabla = table.row(celda_seleccionada.closest('tr'));
        var datos_fila_tabla = fila_tabla.data();

        // var identificador = datos_fila_tabla.identificador;

        // var partesIdentificador = identificador.split(' ');

        // Verificar si el identificador contiene la palabra 'CANCELADO'
        // var contieneCancelado = partesIdentificador.includes('CANCELADO');

        // if (contieneCancelado) {
        //     celda_seleccionada.html(celda_seleccionada.data('valor_original_guardado')); // Restaurar el valor en la celda
        //     flag_editando = false; // Marcar como fuera de edición
        //     var alertHtml = `
        //     <div class="alert bg-danger alert-icon-left alert-dismissible mb-2 font-small-3" role="alert">
        //         <span class="alert-icon"><i class="fa fa-thumbs-o-down"></i></span>
        //         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        //             <span aria-hidden="true">×</span>
        //         </button>
        //         La clase fue cancelada
        //     </div>
        //     `;
        //     // Insertar la alerta en el contenedor
        //     document.getElementById('alert-container').innerHTML = alertHtml;

        //     console.log('La clase fue cancelada CANCELADO');
        //     return;
        // }

        function formatoNombrePropio(nombre) {
            return nombre.toLowerCase().replace(/\b\w/g, function (char) {
                return char.toUpperCase();
            });
        }

        if (columna_nombre === 'sucursal_id') {
            console.log('Entre al if 1');
            for (var i = 0; i < select_sucursal.length; i++) {
                console.log(select_sucursal[i].nombre)
                console.log(valor_nuevo_de_celda)
                if (select_sucursal[i].nombre === formatoNombrePropio(valor_nuevo_de_celda)) {
                    console.log('Entre al if 2');
                    valor_nuevo_de_celda = select_sucursal[i].valor;
                    console.log(valor_nuevo_de_celda);
                    break;
                }
            }
        }

        // Realizar una solicitud AJAX para actualizar el dato en la base de datos
        $.ajax({
            url: method_call + "actualizar", // Actualiza con la ruta correcta
            method: 'POST',
            data: {
                identificador: datos_fila_tabla.id,
                columna: columna_nombre,
                nuevoValor: valor_nuevo_de_celda
            },
            success: function (response) {
                console.log('Dato actualizado en la base de datos');
                console.log('valor nuevo: ' + valor_nuevo_de_celda);
                console.log('valor id: ' + datos_fila_tabla.id);
                console.log(response);

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
});

function suspender(id) {
    // ajax delete data to database
    document.body.style.cursor = 'wait';
    $.ajax({
        url: method_call + "suspender/" + id,
        type: "POST",
        dataType: "JSON",
        success: function (data) {
            table.ajax.reload();
            //alert('True');
            var alert = '' +
                '<div class="alert bg-success alert-icon-left alert-dismissible mb-2" role="alert">' +
                '<span class="alert-icon"><i class="fa fa-thumbs-o-up"></i></span>' +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                '<span aria-hidden="true">×</span>' +
                '</button>' +
                'Cliente <a href="clientes/editar/' + id + '" class="white"><b><u>#' + id + '</u></b></a> suspendido correctamente.' +
                '</div>' +
                '';
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
                '</div>' +
                '';
            $('#mensaje-js').html(alert);

            document.body.style.cursor = 'default';
        }
    });
}

// Función para obtener opciones del select 'sucursal'
async function obtener_opciones_select_sucursal() {
    // Realizar una solicitud AJAX para obtener las opciones de select_sucursal
    $.ajax({
        url: method_call + "obtener_opciones_select_sucursal",
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            select_sucursal = data;
            console.log('Opciones de sucursal cargadas:', select_sucursal);
        },
        error: function (xhr, status, error) {
            console.error('Error al obtener opciones de disciplina: ' + error);
        }
    });
}

function createEditableCells(row, data, dataIndex) {
    var columnsToEdit = [7];
    $.each(columnsToEdit, function (index, columnIndex) {
        $('td:eq(' + columnIndex + ')', row).addClass('editable-cell');
    });
}
