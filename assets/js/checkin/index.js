// Variables globales
let table;
const actual_url = document.URL;
const method_call = (actual_url.indexOf("index") < 0) ? "checkin/" : "";
const url = `${method_call}obtener_tabla_index`;
let selectedClassData = null;

// Configuración de errores y formato de DataTables
$.fn.dataTable.ext.errMode = 'throw';
$.fn.dataTable.ext.type.order['time-pre'] = d => moment(d, 'hh:mm A').format('HHmm');

$(document).ready(function () {
    table = $('#table').DataTable({
        scrollX: true,
        deferRender: true,
        processing: true,
        order: [[1, "desc"], [3, "asc"], [5, "asc"], [6, "asc"]],
        lengthMenu: [[25, 50, 100, 250, 500, -1], [25, 50, 100, 250, 500, "Todos"]],
        ajax: { url: url, type: 'POST' },
        columns: [
            { data: "opciones" },
            { data: "id" },
            { data: "usuario_nombre" },
            { data: "usuario_correo" },
            { data: "usuario_id" },
            { data: "venta_id" },
            { data: "asignacion_id" },
            { data: "reservacion_id" },
            { data: "descripcion" },
            { data: "estatus" },
            { data: "fecha_registro" },
        ],
        language: {
            sProcessing: '<div class="loader-wrapper"><div class="loader"></div></div>',
            sLengthMenu: "Mostrar _MENU_",
            sZeroRecords: "No se encontraron resultados",
            sEmptyTable: "Ningún dato disponible en esta tabla =(",
            sInfo: "Mostrando del _START_ al _END_ de _TOTAL_",
            sInfoEmpty: "Mostrando del 0 al 0 de 0",
            sInfoFiltered: "(filtrado _MAX_)",
            sSearch: "Buscar:",
            oPaginate: { sFirst: "Primero", sLast: "Último", sNext: ">", sPrevious: "<" },
            oAria: { sSortAscending: ": Activar para ordenar ascendente", sSortDescending: ": Activar para ordenar descendente" }
        },
        dom: '<"top"lfi>rt<"bottom"p><"clear">'
    });

    // Añadir botón de exportación
    new $.fn.dataTable.Buttons(table, {
        buttons: [{ extend: 'excelHtml5', className: 'custom-button' }]
    }).container().appendTo($('#buttons'));

    inicializar_buscador();

    document.getElementById("form_registrar_clase").addEventListener("submit", form_clases_submit);
});

function inicializar_buscador() {
    document.getElementById("buscador_clase").addEventListener("input", function () {
        const buscar_texto = this.value.toLowerCase().trim();
        const buscar_palabras = buscar_texto.split(" ");
        document.querySelectorAll("#disciplinas .list-group-item").forEach(item => {
            const texto_filtrado = item.textContent.toLowerCase();
            const palabras_filtradas = buscar_palabras.every(word => texto_filtrado.includes(word));
            item.style.display = palabras_filtradas ? "" : "none";
        });
    });
}

function modal_registrar_checkin(disciplina, data) {
    $('#modal_registrar_checkin').modal('show');

    fetch(`${actual_url}/clases_por_semana/${disciplina}`)
        .then(response => response.json())
        .then(clases => {
            clases_list_renderizar(clases, disciplina, data);
        })
        .catch(error => console.error('Error al obtener las clases:', error));
}

function clases_list_renderizar(clases, disciplina, data) {
    const disciplinas_seleccionadas = document.getElementById("disciplinas");
    const detalles_contenedor = document.getElementById("detalles_contenedor");
    disciplinas_seleccionadas.innerHTML = '';
    detalles_contenedor.innerHTML = '<p>Selecciona una clase para ver los detalles.</p>';

    const detalles_usuario = document.getElementById("detalles_usuario");
    detalles_usuario.innerHTML = `
        <h5>DATOS DEL USUARIO</h5>
        <p><strong>Id:</strong> ${data.usuarioid}</p>
        <p><strong>Nombre:</strong> ${data.usuario}</p>
        <p><strong>Correo:</strong> ${data.usuariocorreo}</p>
        <br>
        <h5>DATOS DE VENTA</h5>
        <p><strong>Id:</strong> ${data.ventaid}</p>
        <p><strong>Venta:</strong> ${data.venta}</p>
        <p><strong>Total:</strong> $${data.ventatotal}</p>
        <p><strong>Fecha de venta:</strong> ${data.ventafecha}</p>
    `;

    clases.forEach(clase => {
        const lista_element = document.createElement("li");
        lista_element.className = 'list-group-item list-group-item-action';
        lista_element.style.cursor = "pointer";
        lista_element.innerHTML = `
            <div class="d-flex flex-column flex-md-row align-items-start">
                <div class="col-12 col-md-4 font-weight-bold">
                    ${clase.disciplinas_nombre}<br>${clase.dificultad}
                </div>
                <div class="col-12 col-md-4 text-muted">
                    ${clase.formato_fecha_inicia}
                </div>
                <div class="col-12 col-md-4">
                    ${clase.instructor_nombre}<br><span class="badge badge-secondary">Cupo: ${clase.reservado}/${clase.cupo}</span>
                </div>
            </div>
        `;

        lista_element.addEventListener("click", () => clases_seleccionar(lista_element, clase, disciplina, data));
        disciplinas_seleccionadas.appendChild(lista_element);
    });
}

function clases_seleccionar(element, clase, disciplina, data) {
    document.querySelectorAll(".list-group-item-action").forEach(item => item.classList.remove("active-tab"));
    element.classList.add("active-tab");

    selectedClassData = {
        disciplina,
        id: data.id,
        usuario: data.usuario,
        venta: data.venta,
        asignacion: data.asignacion,
        clase_id: clase.id,
        instructor_nombre: clase.instructor_nombre,
        fecha_hora: clase.inicia,
        cupos: clase.cupo_lugares
    };

    document.getElementById("detalles_contenedor").innerHTML = `
        <h5>${clase.disciplinas_nombre}</h5>
        <p><strong>Producto:</strong> ${disciplina}</p>
        <p><strong>Instructor:</strong> ${clase.instructor_nombre}</p>
        <p><strong>Fecha y hora:</strong> ${clase.inicia}</p>
    `;
}

function form_clases_submit(event) {
    event.preventDefault();

    if (selectedClassData) {
        fetch(`${actual_url}/registrar_checkin_en_reservacion_y_clase`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
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
}