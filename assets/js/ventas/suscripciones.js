var table;

var actual_url = document.URL;
var method_call = "";

if(actual_url.indexOf("suscripciones") < 0){
    method_call = "ventas/";
}

/**
 * Este línea desactiva los mensajes de error de DataTables();
 */
$.fn.dataTable.ext.errMode = 'throw';

$(function () {
    table = $('#tabla-suscripciones').dataTable({
        "lengthMenu": [[25, 50, 100, 250, 500, -1],[25, 50, 100, 250, 500, "Todos"]],
        "deferRender": true,
        "order": [[0, "desc"]],
        "responsive": true,
        'processing': true,
        "ajax": {
            "url" : method_call+"listar_las_ventas_de_suscripciones",
            "type" : 'POST'
        },
        "columns": [
            { "data": "id" },
            { "data": "concepto" },
            { "data": "cliente" },
            { "data": "asignacion_id" },
            { "data": "metodo" },
            { "data": "costo" },
            { "data": "cantidad" },
            { "data": "total" },
            { "data": "estatus" },
            { "data": "asignacion_suscripcion_id" },
            { "data": "asignacion_plan_id" },
            { "data": "asignacion_clases_usadas" },
            { "data": "asignacion_estatus_del_pago" },
            { "data": "asignacion_estatus" },
            { "data": "fecha_venta" },
            { "data": "vendedor" },
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