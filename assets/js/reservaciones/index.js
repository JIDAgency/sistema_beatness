$(function () {
	$("#tabla-reservaciones").DataTable({
		"scrollX": true,
        "deferRender": true,
        'processing': true,
        "order": [[0, "desc"]],
        "lengthMenu": [[25, 50, 100, 250, 500, -1], [25, 50, 100, 250, 500, "Todos"]],
		"language": {
			"search": "Buscar",
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
            },
		}
	});

	var buttons = new $.fn.dataTable.Buttons(table, {
        buttons: [
            {
                extend: 'excelHtml5',
                className: 'custom-button'

            }
        ]
    }).container().appendTo($('#buttons'));
});
