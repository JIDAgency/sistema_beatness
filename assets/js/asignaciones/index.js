var table;
var table2;
var table3;

var actual_url = document.URL;
var method_call = "";
var url;

if(actual_url.indexOf("index") < 0){
    method_call = "asignaciones/";
}

/**
 * Este línea desactiva los mensajes de error de DataTables();
 */
$.fn.dataTable.ext.errMode = 'throw';

$(document).ready(function(){
    table = $('#table').DataTable({ 
        "scrollX": true,
        "deferRender": true,
        'processing': true,
        "order": [[0, "asc"]],
        "lengthMenu": [[25, 50, 100, 250, 500, -1], [25, 50, 100, 250, 500, "Todos"]],
        "ajax": {
            "url" : method_call+"obtener_tabla_index_planes_activos_por_cliente",
            "type" : 'POST'
        },
        "columns": [
            {"data": "id"},
            {"data": "usuarios_correo"},
            {"data": "usuarios_nombre"},
            {"data": "planes"},
            {"data": "estatus"},
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
        rowCallback: function(row, data, index){
            $(row).find('td:eq(0)').css('background-color', '#37BC9B');
            $(row).find('td:eq(0)').css('color', 'white');
        }
    });

    table2 = $('#table2').DataTable({ 
        "scrollX": true,
        "deferRender": true,
        'processing': true,
        "order": [[0, "asc"]],
        "lengthMenu": [[25, 50, 100, 250, 500, -1], [25, 50, 100, 250, 500, "Todos"]],
        "ajax": {
            "url" : method_call+"obtener_tabla_index_planes_por_caducar_por_cliente",
            "type" : 'POST'
        },
        "columns": [
            {"data": "id"},
            {"data": "usuarios_correo"},
            {"data": "usuarios_nombre"},
            {"data": "planes"},
            {"data": "estatus"},
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
        rowCallback: function(row, data, index){
            $(row).find('td:eq(0)').css('background-color', '#3BAFDA');
            $(row).find('td:eq(0)').css('color', 'white');
        }
    });

    table3 = $('#table3').DataTable({ 
        "scrollX": true,
        "deferRender": true,
        'processing': true,
        "order": [[0, "asc"]],
        "lengthMenu": [[25, 50, 100, 250, 500, -1], [25, 50, 100, 250, 500, "Todos"]],
        "ajax": {
            "url" : method_call+"obtener_tabla_index_planes_caducados_por_cliente",
            "type" : 'POST'
        },
        "columns": [
            {"data": "id"},
            {"data": "usuarios_correo"},
            {"data": "usuarios_nombre"},
            {"data": "planes"},
            {"data": "estatus"},
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
        rowCallback: function(row, data, index){
            if(data["estatus"] == "Caducado"){
                $(row).find('td:eq(0)').css('background-color', '#F6BB42');
                $(row).find('td:eq(0)').css('color', 'white');
            } else if(data["estatus"] == "Cancelado"){
                $(row).find('td:eq(0)').css('background-color', '#DA4453');
                $(row).find('td:eq(0)').css('color', 'white');
            }
        }
    });

});
