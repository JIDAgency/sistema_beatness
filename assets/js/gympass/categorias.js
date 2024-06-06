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

function actualizar(id) {
    if (!id) {
        alert('No se recibió ningún ID de Categoría.');
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
                alert('Categoría de Gympass actualizada correctamente.');
                location.reload(true);
            } else {
                throw new Error(data.message);
            }
        })
        .catch(error => {
            alert('Error al actualizar Categoría de Gympass: ' + error.message);
        });
}


function registrar(id) {
    if (!id) {
        alert('No se recibió ningún ID de Categoría.');
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
                alert('Categoría de Gympass registrada correctamente.');
                location.reload(true);
            } else {
                throw new Error(data.message);
            }
        })
        .catch(error => {
            alert('Error al registrar Categoría de Gympass: ' + error.message);
        });
}
