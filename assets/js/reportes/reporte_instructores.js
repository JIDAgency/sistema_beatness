var table;
var table_primera_quincena;
var table_segunda_quincena;

var actual_url = document.URL;
var method_call = "";
var url;
var url_primera_quincena;
var url_segunda_quincena;

// crea una instancia del objeto Date
let fecha = new Date();

// obtiene el año, mes y día de la fecha actual
let anio = fecha.getFullYear();
let mes = fecha.getMonth() + 1; // el mes empieza en 0, se le suma 1

// agrega un cero a la izquierda si el mes o el día es menor a 10
if (mes < 10) {
    mes = '0' + mes;
}

// concatena los valores en el formato deseado: "Y-m-d"
let fechaYm = anio + '-' + mes;

//console.log(fechaYm); // ejemplo de salida: "2023-03-14"

if(actual_url.indexOf("index") < 0){
    method_call = "";
}

/**
 * Este línea desactiva los mensajes de error de DataTables();
 */
$.fn.dataTable.ext.errMode = 'throw';

$(document).ready( function(){
    table = $('#table').DataTable({ 
        "scrollX": true,
        "deferRender": true,
        'processing': true,
        "order": [[0, "desc"]],
        "lengthMenu": [[25, 50, 100, 250, 500, -1], [25, 50, 100, 250, 500, "Todos"]],
        "ajax": {
            "url" : method_call+"obtener_tabla_reporte_instructores_por_mes/"+fechaYm,
            "type" : 'POST'
        },
        "columns": [
            {"data": "id"},
            {"data": "instructor_nombre"},
            {"data": "total_clases"},
            {"data": "total_reservado"},
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

    table_primera_quincena = $('#table_primera_quincena').DataTable({ 
        "scrollX": true,
        "deferRender": true,
        'processing': true,
        "order": [[0, "desc"]],
        "lengthMenu": [[25, 50, 100, 250, 500, -1], [25, 50, 100, 250, 500, "Todos"]],
        "ajax": {
            "url" : method_call+"obtener_tabla_reporte_instructores_entre_fechas/"+fechaYm+"-01/"+fechaYm+"-15",
            "type" : 'POST'
        },
        "columns": [
            {"data": "id"},
            {"data": "instructor_nombre"},
            {"data": "total_clases"},
            {"data": "total_reservado"},
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

    table_segunda_quincena = $('#table_segunda_quincena').DataTable({ 
        "scrollX": true,
        "deferRender": true,
        'processing': true,
        "order": [[0, "desc"]],
        "lengthMenu": [[25, 50, 100, 250, 500, -1], [25, 50, 100, 250, 500, "Todos"]],
        "ajax": {
            "url" : method_call+"obtener_tabla_reporte_instructores_entre_fechas/"+fechaYm+"-16/"+fechaYm+"-31",
            "type" : 'POST'
        },
        "columns": [
            {"data": "id"},
            {"data": "instructor_nombre"},
            {"data": "total_clases"},
            {"data": "total_reservado"},
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
            'excelHtml5',
        ]
    }).container().appendTo($('#buttons'));

    $("#mes_a_consultar").change(function () {
        table.clear().draw();
        table_primera_quincena.clear().draw();
        table_segunda_quincena.clear().draw();
        fechaYm = $(this).val();
        url = method_call+"obtener_tabla_reporte_instructores_por_mes/"+fechaYm;
        url_primera_quincena = method_call+"obtener_tabla_reporte_instructores_entre_fechas/"+fechaYm+"-01/"+fechaYm+"-15",
        url_segunda_quincena = method_call+"obtener_tabla_reporte_instructores_entre_fechas/"+fechaYm+"-16/"+fechaYm+"-31";
        reload_table();
    });

});

function reload_table() {
    table.ajax.url(url).load();
    table_primera_quincena.ajax.url(url_primera_quincena).load();
    table_segunda_quincena.ajax.url(url_segunda_quincena).load();
    //table.ajax.reload();
}
