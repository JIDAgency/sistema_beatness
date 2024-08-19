var table;

var actual_url = document.URL;
var method_call = "";

if (actual_url.indexOf("index") < 0) {
    method_call = "";
}

$.fn.dataTable.ext.errMode = 'throw';

$(document).ready(function () {
    table = $('#table').DataTable({
        "searching": true,
        "scrollX": true,
        "deferRender": true,
        'processing': true,
        "order": [[2, "desc"]],
        "lengthMenu": [[25, 50, 100, 250, 500, -1], [25, 50, 100, 250, 500, "Todos"]],
        "ajax": {
            "url": method_call + "clases_obtener_activas",
            "type": 'POST'
        },
        "columns": [
            { "data": "opciones" },
            { "data": "id" },
            { "data": "totalpass_event_id" },
            { "data": "totalpass_eventOccurrenceUuid" },
            { "data": "identificador" },
            { "data": "disciplinas_nombre" },
            { "data": "dificultad" },
            { "data": "fecha" },
            { "data": "horario" },
            { "data": "instructores_nombre" },
            { "data": "sucursales_locacion" },
            { "data": "cupos" },
        ],
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

    var buttons = new $.fn.dataTable.Buttons(table, {
        buttons: [
            {
                extend: 'excelHtml5',
                className: 'custom-button'
            }
        ]
    }).container().appendTo($('#buttons'));
});

function crear_ocurrencia_evento(clase_id) {
    var button = $('a[data-id="' + clase_id + '"]');
    var mensajeEnPantalla = $('#mensaje_en_pantalla'); // Seleccionar el span del mensaje

    // Deshabilitar el botón inmediatamente para evitar múltiples clics
    if (button.data('clicked')) {
        return; // Si el botón ya fue clicado, no hacer nada
    }

    button.data('clicked', true); // Marcar el botón como clicado
    button.prop('disabled', true); // Deshabilitar el botón

    // Cambiar el texto del botón a un loader
    button.html('<i class="fa fa-spinner spinner"></i> Procesando...');
    mensajeEnPantalla.html('<i class="fa fa-spinner spinner"></i> Procesando...'); // Mostrar mensaje de éxito


    fetch(method_call + "crear_ocurrencia_evento/" + clase_id, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ clase_id: clase_id })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                mensajeEnPantalla.html(data.message); // Mostrar mensaje de éxito
                mensajeEnPantalla.removeClass().addClass('text-success'); // Cambiar estilo para éxito

                var updatedData = data.data;
                var row = table.row(button.closest('tr'));

                row.data({
                    opciones: updatedData.opciones,
                    id: updatedData.id,
                    totalpass_event_id: updatedData.totalpass_event_id,
                    totalpass_eventOccurrenceUuid: updatedData.totalpass_eventOccurrenceUuid,
                    identificador: updatedData.identificador,
                    disciplinas_nombre: updatedData.disciplinas_nombre,
                    dificultad: updatedData.dificultad,
                    fecha: updatedData.fecha,
                    horario: updatedData.horario,
                    instructores_nombre: updatedData.instructores_nombre,
                    sucursales_locacion: updatedData.sucursales_locacion,
                    cupos: updatedData.cupos,
                }).draw(false);
            } else {
                mensajeEnPantalla.html('Error: ' + data.message); // Mostrar mensaje de error
                mensajeEnPantalla.removeClass().addClass('text-danger'); // Cambiar estilo para error
                button.html('Registrar (intento fallido)'); // Cambiar el texto del botón para reflejar el fallo
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mensajeEnPantalla.html('Ocurrió un error al crear la ocurrencia del evento.'); // Mostrar mensaje de error
            mensajeEnPantalla.removeClass().addClass('text-danger'); // Cambiar estilo para error
            button.html('Registrar (intento fallido)'); // Cambiar el texto del botón para reflejar el fallo
        });
}
