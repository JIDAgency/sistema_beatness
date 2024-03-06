$(function () {
	$("#tabla-membresias").DataTable({
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
            "lengthMenu": "Mostrar _MENU_ registros"
        }
    });
});
