const mensaje_en_pantalla = document.querySelector('#mensaje_en_pantalla');

document.addEventListener('DOMContentLoaded', function () {
    var table = $('#table').DataTable({
        "searching": true,
        "scrollX": true,
        "deferRender": true,
        'processing': true,
        "order": [[1, "asc"]],
        "lengthMenu": [[25, 50, 100, 250, 500, -1], [25, 50, 100, 250, 500, "Todos"]],
        "columnDefs": [
            { "orderable": false, "targets": 0 }
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
});

function actualizar(id) {
    if (!id) {
        mostrar_mensaje('No se recibió ningún ID de Categoría.', 'text-danger');
        return;
    }

    mostrar_mensaje('<i class="fa fa-spinner spinner"></i> Procesando...', 'text-info');

    // Agregar confirmación antes de proceder
    var confirmar = confirm('¿Estás seguro de que deseas actualizar esta categoría de Gympass?');
    if (!confirmar) {
        mostrar_mensaje();
        return;
    }

    fetch('../gympass/actualizar_categoria', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${encodeURIComponent(id)}`
    })
        .then(response => {
            // Imprime la respuesta completa
            return response.text().then(text => {
                console.log(text); // Muestra la respuesta en la consola
                try {
                    return JSON.parse(text);
                } catch (error) {
                    throw new Error('Respuesta no es JSON: ' + text);
                }
            });
        })
        .then(data => {
            if (data.status === 'success') {
                mostrar_mensaje('Categoría de Gympass actualizada correctamente.', 'text-success');
                location.reload(true);
            } else {
                throw new Error(data.message);
            }
        })
        .catch(error => {
            mostrar_mensaje('Error al actualizar Categoría de Gympass: ' + error.message, 'text-danger');
        });
}


function registrar(id) {
    if (!id) {
        mostrar_mensaje('No se recibió ningún ID de Categoría.', 'text-danger');
        return;
    }

    mostrar_mensaje('<i class="fa fa-spinner spinner"></i> Procesando...', 'text-info');

    // Agregar confirmación antes de proceder
    var confirmar = confirm('¿Estás seguro de que deseas registrar esta categoría de Gympass?');
    if (!confirmar) {
        mostrar_mensaje();
        return;
    }

    fetch('../gympass/registrar_categoria', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${encodeURIComponent(id)}`
    })
        .then(response => {
            // Imprime la respuesta completa
            return response.text().then(text => {
                console.log(text); // Muestra la respuesta en la consola
                try {
                    return JSON.parse(text);
                } catch (error) {
                    throw new Error('Respuesta no es JSON: ' + text);
                }
            });
        })
        .then(data => {
            if (data.status === 'success') {
                mostrar_mensaje('Categoría de Gympass registrada correctamente.', 'text-success');
                location.reload(true);
            } else {
                throw new Error(data.message);
            }
        })
        .catch(error => {
            mostrar_mensaje('Error al registrar Categoría de Gympass: ' + error.message, 'text-danger');
        });
}

function eliminar(id) {
    if (!id) {
        mostrar_mensaje('No se recibió ningún ID de Categoría.', 'text-danger');
        return;
    }

    mostrar_mensaje('<i class="fa fa-spinner spinner"></i> Procesando...', 'text-info');

    // Agregar confirmación antes de proceder
    var confirmar = confirm('¿Estás seguro de que deseas eliminar esta categoría de Gympass?');
    if (!confirmar) {
        mostrar_mensaje();
        return;
    }

    fetch('../gympass/eliminar_categoria', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${encodeURIComponent(id)}`
    })
        .then(response => {
            // Imprime la respuesta completa
            return response.text().then(text => {
                console.log(text); // Muestra la respuesta en la consola
                try {
                    return JSON.parse(text);
                } catch (error) {
                    throw new Error('Respuesta no es JSON: ' + text);
                }
            });
        })
        .then(data => {
            if (data.status === 'success') {
                mostrar_mensaje('Categoría de Gympass eliminada correctamente.', 'text-success');
                location.reload(true);
            } else {
                throw new Error(data.message);
            }
        })
        .catch(error => {
            mostrar_mensaje('Error al eliminar Categoría de Gympass: ' + error.message, 'text-danger');
        });
}

function mostrar_mensaje(message = null, estilo = null) {
    if (message) {
        mensaje_en_pantalla.innerHTML = message;
        mensaje_en_pantalla.className = estilo;
        mensaje_en_pantalla.style.display = 'block'; // Asegura que el mensaje sea visible
    } else {
        mensaje_en_pantalla.innerHTML = '';
        mensaje_en_pantalla.className = '';
        mensaje_en_pantalla.style.display = 'none'; // Oculta el contenedor del mensaje
    }
}