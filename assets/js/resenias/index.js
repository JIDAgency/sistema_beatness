// Variables
var table;
var actual_url = document.URL;
var method_call = "";
var url;
var flag_editando = false;

// Configuraciones
(actual_url.indexOf("index") < 0) ? method_call = "resenias/" : method_call = "";
$.fn.dataTable.ext.errMode = 'throw'; // Configuración de manejo de errores de DataTables
$.fn.dataTable.ext.type.order['time-pre'] = function (d) {
    return moment(d, 'hh:mm A').format('HHmm');
};

$(document).ready(function () {
    url = method_call + "obtener_tabla_resenias"

    // Inicializar
    table = $('#table').DataTable({
        "scrollX": true,
        "deferRender": true,
        'processing': true,
        "order": [[1, "desc"], [3, "asc"], [5, "asc"], [6, "asc"]],
        "lengthMenu": [[25, 50, 100, 250, 500, -1], [25, 50, 100, 250, 500, "Todos"]],
        "ajax": {
            "url": url,
            "type": 'POST'
        },
        "columns": [
            { "data": "id" },
            { "data": "reservacion" },
            { "data": "clase" },
            { "data": "usuario" },
            { "data": "instructor" },
            { "data": "calificacion" },
            { "data": "nota" },
            { "data": "fecha_registro" }
        ],
        'language': {
            'sProcessing': '<div class="loader-wrapper"><div class="loader"></div></div>',
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
        },
        "dom": '<"top"lfi>rt<"bottom"p><"clear">',

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