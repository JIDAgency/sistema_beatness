/*$(function () {
	$("#tabla-reportes-clases").DataTable({
		"lengthMenu": [[100, 250, 500, -1],[100, 250, 500, "Todos"]],
        "dom": 'Bfrtip',
        "buttons": ['pageLength','excel','copy'],    // adds the excel button
        order: [[ 5, 'desc' ]],
        responsive: true,
		/*columnDefs: [
            { responsivePriority: 1, targets: 13 },
            { responsivePriority: 3, targets: -1 },
            { orderable: true, targets: 13 }
        ],
		"language": {
			"search": "Buscar",
			"scrollX": false,
			"infoEmpty": "No hay registros que mostrar",
			"infoFiltered": " - ( filtrado de _MAX_ registros )",
			"zeroRecords": "No hay registros que mostrar",
			"info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
			"paginate": {
				"first": "«",
				"last": "»",
				"next": ">",
				"previous": "<"
			},
			"buttons": {
                "pageLength": {
                    _: "Mostrar %d",
                    '-1': "Mostrar ∞"
                },
                "copy": 'Copiar',
                "copySuccess": {
                    1: "Copio una fila al portapapeles",
                    _: "Copio %d filas al portapapeles"
                },
                "copyTitle": 'Copiar al portapapeles',
            }
		}
	});
});*/

var table;
var mes_a_consultar;
var url;

$(document).ready(function(){


    table = $('#tabla-reportes-clases').DataTable({ 
        "scrollX": true,
        "deferRender": true,
        'processing': true,
        "order": [[0, "desc"]],
        "lengthMenu": [[25, 50, 100, 250, 500, -1], [25, 50, 100, 250, 500, "Todos"]],
        "ajax": {
            "url" : 'get_reporte_de_clases_del_mes_dinamico',
            "type" : 'POST',
        },
        "columns": [
            { "data": "id" },
            { "data": "identificador" },
            { "data": "disciplina" },
            { "data": "instructor" },
            { "data": "cupo" },
            { "data": "reservado" },
            { "data": "inicia" },
            { "data": "lista_lugares" },
            { "data": "inasistencias" },
            { "data": "estatus" },
        ],
    });

    $("#mes_a_consultar").change(function () {
        //clear datatable
        table.clear().draw();

        $("#mes_a_consultar").load(this.value);
        mes_a_consultar = $(this).val();
        url = "reportes_clases/get_reporte_de_clases_del_mes_dinamico/"+mes_a_consultar;
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