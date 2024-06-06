document.addEventListener('DOMContentLoaded', function () {
    var table = $('#table').DataTable({
        "searching": true,
        "scrollX": true,
        "deferRender": true,
        'processing': true,
        "order": [[0, "asc"]],
        "lengthMenu": [[25, 50, 100, 250, 500, -1], [25, 50, 100, 250, 500, "Todos"]],
        'language': {
            "sProcessing": '<i class="fa fa-spinner spinner"></i> Cargando...',
            "sLengthMenu": "Mostrar _MENU_",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla =(",
            "sInfo": "Mostrando del _START_ al _END_ de _TOTAL_",
            "sInfoEmpty": "Mostrando del 0 al 0 de 0",
            "sInfoFiltered": "(filtrado _MAX_)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "&nbsp;",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": ">",
                "sPrevious": "<"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }

    });
});

function modal_registrar_clase(id, data) {
    $('#modal_registrar_clase').modal('show');
    document.getElementById("id").value = id;
    document.getElementById("identificador").innerHTML = data.identificador;
    document.getElementById("disciplinas_nombre").innerHTML = data.disciplinas_nombre;
    document.getElementById("dificultad").innerHTML = data.dificultad;
    document.getElementById("fecha").innerHTML = data.fecha;
    document.getElementById("horario").innerHTML = data.horario;
    document.getElementById("instructores_nombre").innerHTML = data.instructores_nombre;
    document.getElementById("sucursales_locacion").innerHTML = data.sucursales_locacion;
    document.getElementById("cupos").innerHTML = data.cupos;
}