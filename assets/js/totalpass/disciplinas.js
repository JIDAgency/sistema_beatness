var table;

var actual_url = document.URL;
var method_call = "";

if (actual_url.indexOf("index") < 0) {
    method_call = "";
}

$.fn.dataTable.ext.errMode = 'throw';

$(document).ready(function () {
    table = $('#table').DataTable({
        "searching": true,
        "scrollX": true,
        "deferRender": true,
        'processing': true,
        "order": [[0, "desc"]],
        "lengthMenu": [[25, 50, 100, 250, 500, -1], [25, 50, 100, 250, 500, "Todos"]],
        "ajax": {
            "url": method_call + "disciplinas_obtener",
            "type": 'POST'
        },
        "columns": [
            { "data": "opciones" },
            { "data": "id" },
            { "data": "totalpass_partner_api_key" },
            { "data": "totalpass_place_api_key" },
            { "data": "totalpass_plan_id" },
            { "data": "totalpass_token_expiracion" },
            { "data": "nombre" },
            { "data": "estatus" },
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
            }
        }
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