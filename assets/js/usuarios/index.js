var table;

var actual_url = document.URL;
var method_call = "";

if(actual_url.indexOf("index") < 0){
    method_call = "usuarios/";
}

/**
 * Este línea desactiva los mensajes de error de DataTables();
 */
 $.fn.dataTable.ext.errMode = 'throw';

$(function () {
    table = $('#tabla-clientes').dataTable({
        "scrollX": true,
        "deferRender": true,
        'processing': true,
        "order": [[0, "desc"]],
        "lengthMenu": [[25, 50, 100, 250, 500, -1], [25, 50, 100, 250, 500, "Todos"]],
        "ajax": {
            "url" : method_call+"load_lista_de_todos_los_colaboradores_para_datatable",
            "type" : 'POST'
        },
        "columns": [
            { "data": "listar_id" },
            { "data": "listar_nombre_completo" },
            { "data": "listar_correo" },
            { "data": "listar_no_telefono" },
            { "data": "listar_tipo" },
            { "data": "listar_locacion" },
            { "data": "listar_opciones" },
        ],
        'language': {
            "sProcessing":     '<i class="fa fa-spinner spinner"></i> Cargando...',
            "sLengthMenu":     "Mostrar _MENU_",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla =(",
            "sInfo":           "Mostrando del _START_ al _END_ de _TOTAL_",
            "sInfoEmpty":      "Mostrando del 0 al 0 de 0",
            "sInfoFiltered":   "(filtrado _MAX_)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "&nbsp;",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     ">",
                "sPrevious": "<"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
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
})
