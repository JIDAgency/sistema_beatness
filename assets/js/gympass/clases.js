let table;

const actualUrl = document.URL;
const methodCall = actualUrl.includes("index") ? "" : "";

$.fn.dataTable.ext.errMode = 'throw'; // Configuración de manejo de errores de DataTables
$.fn.dataTable.ext.type.order['time-pre'] = function (d) {
    return moment(d, 'hh:mm A').format('HHmm');
};

document.addEventListener('DOMContentLoaded', function () {
    table = $('#table').DataTable({
        searching: true,
        scrollX: true,
        deferRender: true,
        processing: true,
        order: [[2, "desc"], [4, "asc"], [6, "asc"], [7, "asc"]],
        lengthMenu: [[25, 50, 100, 250, 500, -1], [25, 50, 100, 250, 500, "Todos"]],
        language: {
            sProcessing: '<i class="fa fa-spinner spinner"></i> Cargando...',
            sLengthMenu: "Mostrar _MENU_",
            sZeroRecords: "No se encontraron resultados",
            sEmptyTable: "Ningún dato disponible en esta tabla =(",
            sInfo: "Mostrando del _START_ al _END_ de _TOTAL_",
            sInfoEmpty: "Mostrando del 0 al 0 de 0",
            sInfoFiltered: "(filtrado _MAX_)",
            sSearch: "Buscar:",
            oPaginate: {
                sFirst: "Primero",
                sLast: "Último",
                sNext: ">",
                sPrevious: "<"
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

    // Llamada AJAX para obtener las categorías filtradas por gympass_product_id
    fetch(`../gympass/categorias_por_producto/${data.disciplinas_gympass_product_id}/${data.disciplina_id}`)
        .then(response => response.json())
        .then(categorias => {
            let categoriaSelect = document.getElementById("categoria");
            categoriaSelect.innerHTML = '<option value="">Seleccione una categoría…</option>';
            categorias.forEach(categoria => {
                let option = document.createElement("option");
                option.value = categoria.id;
                option.text = `${categoria.nombre} - ${categoria.disciplinas_nombre}`;

                if (data.clase_categoria_id === categoria.id) {
                    option.selected = true;
                }

                categoriaSelect.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Error al obtener las categorías:', error);
        });
}

function actualizar_clase(id) {
    if (!id) {
        alert('El ID de la clase no fue proporcionado.');
        return;
    }

    fetch('../gympass/actualizar_clase', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${encodeURIComponent(id)}`
    })
        .then(response => response.json().catch(() => {
            throw new Error('Respuesta no es JSON.');
        }))
        .then(data => {
            if (data.status === 'success') {
                alert('La clase se ha actualizado en Gympass correctamente.');
                location.reload(true);
            } else if (data.status === 'info') {
                alert('Información: ' + data.message);
            } else {
                throw new Error(data.message || 'Error desconocido.');
            }
        })
        .catch(error => {
            alert('Error al actualizar clase de Gympass: ' + error.message);
        });
}

function eliminar_clase(id) {
    if (!id) {
        alert('El ID de la clase no fue proporcionado.');
        return;
    }

    fetch('../gympass/eliminar_clase', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${encodeURIComponent(id)}`
    })
        .then(response => response.json().catch(() => {
            throw new Error('Respuesta no es JSON.');
        }))
        .then(data => {
            if (data.status === 'success') {
                alert('La clase se ha eliminado en Gympass correctamente.');
                location.reload(true);
            } else if (data.status === 'info') {
                alert('Información: ' + data.message);
            } else {
                throw new Error(data.message || 'Error desconocido.');
            }
        })
        .catch(error => {
            alert('Error al eliminar clase de Gympass: ' + error.message);
        });
}

function reservacion_clase(id) {
    if (!id) {
        alert('El ID de la clase no fue proporcionado.');
        return;
    }

    fetch('../gympass/reservacion_clase', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${encodeURIComponent(id)}`
    })
        .then(response => response.json().catch(() => {
            throw new Error('Respuesta no es JSON.');
        }))
        .then(data => {
            if (data.status === 'success') {
                alert('La clase se ha actualizado en Gympass correctamente.');
                location.reload(true);
            } else if (data.status === 'info') {
                alert('Información: ' + data.message);
            } else {
                throw new Error(data.message || 'Error desconocido.');
            }
        })
        .catch(error => {
            alert('Error al actualizar clase de Gympass: ' + error.message);
        });
}