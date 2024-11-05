// Variables
var table;
var actual_url = document.URL;
var method_call = "";
var url;


// Configuraciones
(actual_url.indexOf("index") < 0) ? method_call = "checkin/" : method_call = "";
$.fn.dataTable.ext.errMode = 'throw'; // Configuración de manejo de errores de DataTables
$.fn.dataTable.ext.type.order['time-pre'] = function (d) {
    return moment(d, 'hh:mm A').format('HHmm');
};
console.log(actual_url);
console.log(method_call);

$(document).ready(function () {
    url = method_call + "obtener_tabla_index"

    // Inicializar
    table = $('#table').DataTable({
        "scrollX": true,
        "deferRender": true,
        'processing': true,
        "order": [[1, "desc"], [3, "asc"], [5, "asc"], [6, "asc"]],
        "lengthMenu": [[25, 50, 100, 250, 500, -1], [25, 50, 100, 250, 500, "Todos"]],
        "ajax": {
            "url": url,
            "type": 'POST'
        },
        "columns": [
            { "data": "opciones" },
            { "data": "id" },
            // { "data": "disciplina_wellhub" },
            { "data": "usuario_nombre" },
            { "data": "usuario_correo" },
            { "data": "usuario_id" },
            { "data": "venta_id" },
            { "data": "asignacion_id" },
            { "data": "reservacion_id" },
            { "data": "descripcion" },
            // { "data": "timestamp" },
            { "data": "estatus" },
            { "data": "fecha_registro" },
        ],
        'language': {
            'sProcessing': '<div class="loader-wrapper"><div class="loader"></div></div>',
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
        },
        "dom": '<"top"lfi>rt<"bottom"p><"clear">',

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

let selectedClassData = null;

function modal_registrar_checkin(disciplina, data) {
    $('#modal_registrar_checkin').modal('show');

    fetch(actual_url + `/clases_por_semana/${disciplina}`)
        .then(response => response.json())
        .then(clases => {
            let categoriaSelect = document.getElementById("disciplinas");
            let detallesContainer = document.getElementById("claseDetalles");
            categoriaSelect.innerHTML = '';
            detallesContainer.innerHTML = '<p>Selecciona una clase para ver los detalles.</p>';

            // Iterar sobre las clases y crear un elemento tipo "tab" para cada una
            clases.forEach(clase => {
                let liElement = document.createElement("li");
                liElement.className = 'list-group-item list-group-item-action';
                liElement.style.cursor = "pointer";
                liElement.textContent = `${clase.inicia} - ${clase.instructor_nombre}`;

                // Manejar el clic en la pestaña para mostrar detalles de la clase
                liElement.addEventListener("click", () => {

                    // Remover la clase 'active-tab' de todos los elementos
                    document.querySelectorAll(".list-group-item-action").forEach(item => {
                        item.classList.remove("active-tab");
                    });

                    // Agregar la clase 'active-tab' solo al elemento clicado
                    liElement.classList.add("active-tab");

                    selectedClassData = {
                        disciplina: disciplina,
                        id: data.id,
                        usuario: data.usuario,
                        venta: data.venta,
                        asignacion: data.asignacion,
                        clase_id: clase.id,
                        instructor_nombre: clase.instructor_nombre,
                        fecha_hora: clase.inicia,
                        cupos: clase.cupo_lugares
                    };

                    detallesContainer.innerHTML = `
                        <h5>${clase.disciplina_nombre}</h5>
                        <p><strong>producto:</strong> ${disciplina}</p>
                        <p><strong>Instructor:</strong> ${clase.instructor_nombre}</p>
                        <p><strong>Fecha y hora:</strong> ${clase.inicia}</p>
                    `;
                });

                categoriaSelect.appendChild(liElement);
            });
        })
        .catch(error => {
            console.error('Error al obtener las clases:', error);
        });
}

// Enviar datos al controlador al hacer clic en "Registrar"
document.getElementById("form_registrar_clase").addEventListener("submit", function (event) {
    event.preventDefault(); // Evitar que el formulario se envíe de forma tradicional

    if (selectedClassData) {
        console.log(actual_url + `/registrar_checkin_en_reservacion_y_clase`)
        fetch(actual_url + `/registrar_checkin_en_reservacion_y_clase`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams(selectedClassData)
        })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    console.log('Check-in registrado exitosamente');
                    $('#modal_registrar_checkin').modal('hide');
                    table.ajax.reload();
                } else {
                    alert('Error al registrar el check-in');
                }
            })
            .catch(error => {
                console.error('Error al enviar el formulario:', error);
                alert('Hubo un problema al registrar el check-in.');
            });
    } else {
        alert('Selecciona una clase antes de registrar el check-in.');
    }
});

