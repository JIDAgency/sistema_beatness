var table;

var actual_url = document.URL;
var method_call = "";

if (actual_url.indexOf("index") < 0) {
    method_call = "clientes/";
}

/**
 * Este línea desactiva los mensajes de error de DataTables();
 */
$.fn.dataTable.ext.errMode = 'throw';

$(function () {
    table = $('#tabla').DataTable({
        "scrollX": true,
        "deferRender": true,
        'processing': true,
        "order": [[0, "desc"]],
        "lengthMenu": [[25, 50, 100, 250, 500, -1], [25, 50, 100, 250, 500, "Todos"]],
        "ajax": {
            "url": method_call + "get_lista_de_clientes",
            "type": 'POST'
        },
        "columns": [
            { "data": "id" },
            { "data": "nombre_completo" },
            { "data": "correo" },
            { "data": "no_telefono" },
            { "data": "es_estudiante" },
            { "data": "dominio" },
            { "data": "estatus" },
            { "data": "fecha_registro" },
            { "data": "opciones" },
        ],
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
