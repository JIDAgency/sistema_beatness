var table;
var table_suspendidos;

var actual_url = document.URL;
var method_call = "";

if (actual_url.indexOf("index") < 0) {
    method_call = "planes/";
}

/**
 * Este línea desactiva los mensajes de error de DataTables();
 */
$.fn.dataTable.ext.errMode = 'throw';

$(function () {
    table = $('#tabla-planes').DataTable({
        "scrollX": true,
        "deferRender": true,
        'processing': true,
        "order": [[0, "desc"]],
        "lengthMenu": [[25, 50, 100, 250, 500, -1], [25, 50, 100, 250, 500, "Todos"]],
        "ajax": {
            "url": method_call + "load_lista_de_todos_los_planes_para_datatable",
            "type": 'POST'
        },
        "columns": [
            { "data": "listar_opciones" },
            { "data": "listar_imagenes" },
            { "data": "listar_id" },
            { "data": "listar_nombre_completo" },
            { "data": "listar_orden_venta" },
            { "data": "listar_clases_incluidas" },
            { "data": "listar_vigencia_en_dias" },
            { "data": "sucursal" },
            { "data": "codigo" },
            { "data": "listar_costo" },
            { "data": "es_ilimitado" },
            { "data": "es_primera" },
            { "data": "es_estudiante" },
            { "data": "es_empresarial" },
            { "data": "pagar_en" },
            { "data": "listar_activo" },
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

    table_suspendidos = $('#tabla-planes-suspendidos').DataTable({
        "scrollX": true,
        "deferRender": true,
        'processing': true,
        "order": [[0, "desc"]],
        "lengthMenu": [[25, 50, 100, 250, 500, -1], [25, 50, 100, 250, 500, "Todos"]],
        "ajax": {
            "url": method_call + "load_lista_de_todos_los_planes_suspendidos_para_datatable",
            "type": 'POST'
        },
        "columns": [
            { "data": "listar_opciones" },
            { "data": "listar_imagenes" },
            { "data": "listar_id" },
            { "data": "listar_nombre_completo" },
            { "data": "listar_orden_venta" },
            { "data": "listar_clases_incluidas" },
            { "data": "listar_vigencia_en_dias" },
            { "data": "sucursal" },
            { "data": "codigo" },
            { "data": "listar_costo" },
            { "data": "es_ilimitado" },
            { "data": "es_primera" },
            { "data": "es_estudiante" },
            { "data": "es_empresarial" },
            { "data": "pagar_en" },
            { "data": "listar_activo" },
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

    $('#sucursal').on('change', function () {
        var sucursal = $(this).val();  // Obtener el valor seleccionado
        if (sucursal) {
            table.column(7).search('^' + sucursal + '$', true, false).draw();  // Aplicar búsqueda exacta
        } else {
            table.column(7).search('').draw();  // Limpiar filtro
        }
    });

    $('#sucursal-suspendidos').on('change', function () {
        var sucursal = $(this).val();  // Obtener el valor seleccionado
        if (sucursal) {
            table_suspendidos.column(7).search('^' + sucursal + '$', true, false).draw();  // Aplicar búsqueda exacta
        } else {
            table_suspendidos.column(7).search('').draw();  // Limpiar filtro
        }
    });
})


/*$(function () {
    $("#tabla-planes").DataTable({
        "deferRender": true,
        "responsive": true,
        "order": [[0, "asc"]],
        'processing': true,
        "lengthMenu": [[25, 50, 100, 250, 500, -1],[25, 50, 100, 250, 500, "Todos"]],
        "language": {
            "search": "Buscar",
            "scrollX": false,
            "infoEmpty": "No hay registros que mostrar",
            "infoFiltered": " - (filtrado de _MAX_)",
            "zeroRecords": "No hay registros que mostrar",
            "info": "Mostrando _START_ a _END_ de _TOTAL_",
            "paginate": {
                "first": "«",
                "last": "»",
                "next": ">",
                "previous": "<"
            },
            "lengthMenu": "Mostrar _MENU_"
        }
    });
});*/