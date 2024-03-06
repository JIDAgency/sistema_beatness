$(function () {
	$("#tabla-clases").DataTable({
		"lengthMenu": [[100, 250, 500, -1],[100, 250, 500, "Todos"]],
        "dom": 'Bfrtip',
        "buttons": ['pageLength','excel','copy'],    // adds the excel button
        order: [[ 0, 'desc' ]],
        responsive: true,
		/*columnDefs: [
            { responsivePriority: 1, targets: 13 },
            { responsivePriority: 3, targets: -1 },
            { orderable: true, targets: 13 }
        ],*/
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
});
