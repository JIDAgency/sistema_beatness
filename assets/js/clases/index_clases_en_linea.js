var table;

var actual_url = document.URL;
var method_call = "";

if(actual_url.indexOf("index") < 0){
    method_call = "clases/";
}

/**
 * Este línea desactiva los mensajes de error de DataTables();
 */
$.fn.dataTable.ext.errMode = 'throw';

$(document).ready(function() {

    table = $('#tabla-clases-streaming').dataTable({
        "scrollX": true,
        "deferRender": true,
        'processing': true,
        "order": [[0, "desc"]],
        "lengthMenu": [[25, 50, 100, 250, 500, -1], [25, 50, 100, 250, 500, "Todos"]],
        "ajax": {
            "url" : method_call+"load_lista_de_todas_las_clases_por_streaming_con_detalles_para_datatables",
            "type" : 'POST'
        },
        "columns": [
            { "data": "id" },
            { "data": "identificador" },
            { "data": "disciplina" },
            { "data": "tematica" },
            { "data": "instructor" },
            { "data": "fecha_clase" },
            { "data": "estatus" },
            { "data": "opciones" },
            { "data": "descripcion" },
            { "data": "url_preview" },
            { "data": "url_video" },
            { "data": "duracion" },
            { "data": "reservados" },
            { "data": "fecha_registro" },
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

});