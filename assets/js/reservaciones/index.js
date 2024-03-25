$(function () {
	$("#tabla-reservaciones").DataTable({
		"scrollX": true,
        "deferRender": true,
        'processing': true,
		"lengthMenu": [[100, 250, 500, -1],[100, 250, 500, "Todos"]],
        "dom": 'Bfrtip',
        "buttons": ['pageLength','excel','copy'],    // adds the excel button
        order: [[ 0, 'desc' ]],
		/*columnDefs: [
            { responsivePriority: 1, targets: 7 },
            { responsivePriority: 2, targets: -1 },
            { orderable: true, targets: 7 }
		],*/
		order: [[ 0, 'desc' ]],
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
});
