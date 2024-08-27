let table;

const actualUrl = document.URL;
const methodCall = actualUrl.includes("index") ? "" : "";

document.addEventListener('DOMContentLoaded', function () {
    table = $('#table').DataTable({
        searching: true,
        scrollX: true,
        deferRender: true,
        processing: true,
        order: [[2, "desc"], [4, "asc"], [6, "asc"], [7, "asc"]],
        lengthMenu: [[25, 50, 100, 250, 500, -1], [25, 50, 100, 250, 500, "Todos"]],
        ajax: {
            url: `${methodCall}clases_obtener_activas`,
            type: 'POST'
        },
        columns: [
            { data: "opciones" },
            { data: "id" },
            { data: "totalpass_eventOccurrenceUuid" },
            { data: "identificador" },
            { data: "disciplinas_nombre" },
            { data: "dificultad" },
            { data: "fecha" },
            { data: "horario" },
            { data: "instructores_nombre" },
            { data: "sucursales_locacion" },
            { data: "cupos" }
        ],
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

async function manejar_evento(clase_id, accion, funcion) {
    const button = document.querySelector(`#${accion}_${clase_id}`);
    if (!button) {
        console.error(`Botón con ID #${accion}_${clase_id} no encontrado`);
        return;
    }
    const mensaje_en_pantalla = document.querySelector('#mensaje_en_pantalla');

    if (button.dataset.clicked) {
        return;
    }

    button.dataset.clicked = true;
    button.disabled = true;

    button.innerHTML = '<i class="fa fa-spinner spinner"></i> Procesando...';
    button.className = 'text-warning';

    mensaje_en_pantalla.innerHTML = '<i class="fa fa-spinner spinner"></i> Procesando...';
    mensaje_en_pantalla.className = 'text-warning';

    try {
        const response = await fetch(`${methodCall}${funcion}/${clase_id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ clase_id })
        });

        const data = await response.json();

        if (data.success) {
            mensaje_en_pantalla.innerHTML = data.message;
            mensaje_en_pantalla.className = 'text-success';

            const updatedData = data.data;
            const row = table.row(button.closest('tr'));

            if (row) {
                row.data({
                    opciones: updatedData.opciones,
                    id: updatedData.id,
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
                console.error('Fila no encontrada para actualizar.');
            }

        } else {
            mostrar_error(data.message, button, accion);
        }

    } catch (error) {
        console.error('Error:', error);
        mostrar_error('No se pudo procesar la solicitud en TotalPass.', button, accion);
    }
}

function mostrar_error(message, button, accion) {
    const mensaje_en_pantalla = document.querySelector('#mensaje_en_pantalla');
    mensaje_en_pantalla.innerHTML = `${message}`;
    mensaje_en_pantalla.className = 'text-danger';
    button.innerHTML = capitalize_first_letter(accion);
    button.disabled = false;
    delete button.dataset.clicked;
}

function capitalize_first_letter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

function crear_ocurrencia_evento(clase_id) {
    var boton = 'registrar';
    var funcion = 'crear_ocurrencia_evento';
    manejar_evento(clase_id, boton, funcion);
}

function actualizar_ocurrencia_evento(clase_id) {
    var boton = 'actualizar';
    var funcion = 'actualizar_ocurrencia_evento';
    manejar_evento(clase_id, boton, funcion);
}

function eliminar_ocurrencia_evento(clase_id) {
    var boton = 'cancelar';
    var funcion = 'eliminar_ocurrencia_evento';
    manejar_evento(clase_id, boton, funcion);
}
