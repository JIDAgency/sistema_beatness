var table;
var mes_a_consultar;
var url;

$(document).ready(function(){


    table = $('#tabla-historial-reservaciones').DataTable({ 
        "ajax": {
            "url" : 'get_reporte_de_reservaciones_del_mes_dinamico',
            "type" : 'POST',
        },
        "scrollX": true,
        "deferRender": true,
        'processing': true,
        "order": [[0, "desc"]],
        "lengthMenu": [[25, 50, 100, 250, 500, -1], [25, 50, 100, 250, 500, "Todos"]],
        "order": [[0, "desc"]],
        "columns": [
            { "data": "id" },
            { "data": "clase" },
            { "data": "usuario" },
            { "data": "disciplina" },
            { "data": "no_lugar" },
            { "data": "asistencia" },
            { "data": "horario" },
            { "data": "estatus" },
            { "data": "opciones" },
        ],
    });

    $("#mes_a_consultar").change(function () {
        //clear datatable
        table.clear().draw();
        
        $("#mes_a_consultar").load(this.value);
        mes_a_consultar = $(this).val();
        url = "historial_reservaciones/get_reporte_de_reservaciones_del_mes_dinamico/"+mes_a_consultar;
        reload_table();
    });

    var buttons = new $.fn.dataTable.Buttons(table, {
        buttons: [
            'excelHtml5',
        ]
    }).container().appendTo($('#buttons'));

});

setInterval(function(){
    table.ajax.reload( null, false ); //reload datatable ajax 
}, 180000);

function reload_table()
{
    $('#mes_dinamico').text('[Cargando...]'); 
    table.ajax.url(url).load();
    table.ajax.reload( null, false ); //reload datatable ajax 
    setTimeout(function(){
        $('#mes_dinamico').text($("#mes_a_consultar :selected").text()); 
    }, 6000); 
}