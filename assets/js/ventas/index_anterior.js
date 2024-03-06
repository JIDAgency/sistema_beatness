var table;

var actual_url = document.URL;
var method_call = "";

if(actual_url.indexOf("index") < 0){
    method_call = "ventas/";
}

/**
 * Este línea desactiva los mensajes de error de DataTables();
 */
$.fn.dataTable.ext.errMode = 'throw';

$(function () {
    table = $('#tabla-ventas').dataTable({
        "lengthMenu": [[25, 50, 100, 250, 500, -1],[25, 50, 100, 250, 500, "Todos"]],
        "deferRender": true,
        "order": [[0, "desc"]],
        "responsive": true,
        'processing': true,
        "ajax": {
            "url" : method_call+"listar_las_ventas_de_admin_front",
            "type" : 'POST'
        },
        "columns": [
            { "data": "listar_id" },
            { "data": "listar_concepto" },
            { "data": "listar_usuario" },
            { "data": "listar_metodo_nombre" },
            { "data": "listar_costo" },
            { "data": "listar_cantidad" },
            { "data": "listar_total" },
            { "data": "listar_estatus" },
            { "data": "listar_asignacion" },
            { "data": "listar_clases_incluidas" },
            { "data": "listar_clases_usadas" },
            { "data": "listar_clases_restantes" },
            { "data": "listar_vigencia_en_dias" },
            { "data": "listar_fecha_activacion" },
            { "data": "listar_sucursales_locacion" },
            { "data": "listar_vendedor" },
            { "data": "listar_fecha_venta" },
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
})