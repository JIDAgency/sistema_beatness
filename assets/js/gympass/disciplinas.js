const mensaje_en_pantalla = document.querySelector('#mensaje_en_pantalla');

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('select').forEach(function (select) {
        select.setAttribute('data-previous', select.value);
    });

    var table = $('#table').DataTable({
        "searching": true,
        "responsive": true,
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

    var table_2 = $('#table_2').DataTable({
        "searching": true,
        "responsive": true,
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

function actualizar_disciplina(disciplina_id, value) {
    let select = document.getElementById('select-' + disciplina_id);
    let valor_anterior = select.getAttribute('data-previous');

    // Dividir el valor recibido en product_id y gym_id
    let parts = value.split(',');
    let gympass_product_id = parts[0];
    let gympass_gym_id = parts[1];

    mostrar_mensaje('<i class="fa fa-spinner spinner"></i> Procesando...', 'text-warning');

    if (gympass_product_id === valor_anterior) {
        mostrar_mensaje('No se realizaron cambios en el ID de Gympass.', 'text-error');
        return;
    }

    fetch('../gympass/actualizar_disciplina', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${encodeURIComponent(disciplina_id)}&gympass_product_id=${encodeURIComponent(gympass_product_id)}&gympass_gym_id=${encodeURIComponent(gympass_gym_id)}`
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                mostrar_mensaje('ID de Gympass actualizado correctamente.', 'text-success');
                select.setAttribute('data-previous', gympass_product_id);
            } else {
                throw new Error(data.message);
            }
        })
        .catch(error => {
            mostrar_mensaje('Error al actualizar ID de Gympass: ' + error.message, 'text-error');
            select.value = valor_anterior;
        });
}

function mostrar_mensaje(message, estilo) {
    mensaje_en_pantalla.innerHTML = `${message}`;
    mensaje_en_pantalla.className = `${estilo}`;
}