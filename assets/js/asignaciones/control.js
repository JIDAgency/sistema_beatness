var table;

var actual_url = document.URL;
var method_call = '';

if(actual_url.indexOf('index') < 0){
    method_call = '../asignaciones/';
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
        'ajax': {
            'url' : method_call+'obtener_datos_tabla_control',
            'type' : 'POST'
        },
        'columns': [
            {data: 'id'},
            {data: 'nombre'},
            {data: 'estatus'},
            {data: 'cliente_nombre'},
            {data: 'cliente_correo'},
            {data: 'clases_plan'},
            {data: 'fecha_activacion'},
            {data: 'vigencia_en_dias'},
            {data: 'fecha_vigencia'},
            {data: 'categoria'},
            {data: 'disciplinas_result'},
            {data: 'clases_incluidas'},
            {data: 'clases_usadas'},
            {data: 'plan_id'},
            {data: 'usuario_id'},
        ],
        'language': {
            'sProcessing':     '<i class="fa fa-spinner spinner"></i> Cargando...',
            'sLengthMenu':     'Mostrar _MENU_',
            'sZeroRecords':    'No se encontraron resultados',
            'sEmptyTable':     'Ningún dato disponible en esta tabla =(',
            'sInfo':           'Mostrando del _START_ al _END_ de _TOTAL_',
            'sInfoEmpty':      'Mostrando del 0 al 0 de 0',
            'sInfoFiltered':   '(filtrado _MAX_)',
            'sInfoPostFix':    '',
            'sSearch':         'Buscar:',
            'sUrl':            '',
            'sInfoThousands':  ',',
            'sLoadingRecords': '&nbsp;',
            'oPaginate': {
                'sFirst':    'Primero',
                'sLast':     'Último',
                'sNext':     '>',
                'sPrevious': '<'
            },
            'oAria': {
                'sSortAscending':  ': Activar para ordenar la columna de manera ascendente',
                'sSortDescending': ': Activar para ordenar la columna de manera descendente'
            },
            'buttons': {
                'copy': 'Copiar',
                'colvis': 'Visibilidad'
            }
        },
        rowCallback: function(row, data, index){
            if(data["estatus"] == "Activo"){
                $(row).find('td:eq(0)').css('background-color', '#37BC9B');
                $(row).find('td:eq(0)').css('color', 'white');
                $(row).find('td:eq(2)').css('color', '#37BC9B');
            } else if(data["estatus"] == "Caducado"){
                $(row).find('td:eq(0)').css('background-color', '#F6BB42');
                $(row).find('td:eq(0)').css('color', 'white');
                $(row).find('td:eq(2)').css('color', '#F6BB42');
            } else if(data["estatus"] == "Cancelado"){
                $(row).find('td:eq(0)').css('background-color', '#DA4453');
                $(row).find('td:eq(0)').css('color', 'white');
                $(row).find('td:eq(2)').css('color', '#DA4453');
            }
        }
    });

    var buttons = new $.fn.dataTable.Buttons(table, {
        buttons: [
            'excelHtml5',
        ]
    }).container().appendTo($('#buttons'));
});
