// Variables
var table;
var table_suspendidos;
var actual_url = document.URL;
var method_call = "";
var url;
var urlsuspendidos;

// Configuraciones
(actual_url.indexOf("index") < 0) ? method_call = "planes_categorias/" : method_call = "";
$.fn.dataTable.ext.errMode = 'throw'; // Configuración de manejo de errores de DataTables

$(document).ready(function () {
    url = method_call + "obtener_tabla_index"

    // Inicializar
    table = $('#table').DataTable({
        "scrollX": true,
        "deferRender": true,
        'processing': true,
        "order": [[1, "desc"]],
        "lengthMenu": [[25, 50, 100, 250, 500, -1], [25, 50, 100, 250, 500, "Todos"]],
        "ajax": {
            "url": url,
            "type": 'POST'
        },
        "columns": [
            { "data": "opciones" },
            { "data": "id" },
            { "data": "url_banner" },
            { "data": "orden" },
            { "data": "nombre" },
            { "data": "identificador" },
            { "data": "estatus" },
            { "data": "fecha_registro" },
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

    urlsuspendidos = method_call + "obtener_tabla_index_suspendidos"

    table_suspendidos = $('#table_suspendidos').DataTable({
        "scrollX": true,
        "deferRender": true,
        'processing': true,
        "order": [[2, "desc"]],
        "lengthMenu": [[25, 50, 100, 250, 500, -1], [25, 50, 100, 250, 500, "Todos"]],
        "ajax": {
            "url": urlsuspendidos,
            "type": 'POST'
        },
        "columns": [
            { "data": "opciones" },
            { "data": "id" },
            { "data": "url_banner" },
            { "data": "orden" },
            { "data": "nombre" },
            { "data": "identificador" },
            { "data": "estatus" },
            { "data": "fecha_registro" },
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

document.querySelectorAll('.smooth-scroll').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault(); // Evita el comportamiento predeterminado
        const target = document.querySelector(this.getAttribute('href')); // Selecciona el ID del destino
        target.scrollIntoView({
            behavior: 'smooth', // Desplazamiento suave
            block: 'start' // Ajusta al inicio del elemento destino
        });
    });
});