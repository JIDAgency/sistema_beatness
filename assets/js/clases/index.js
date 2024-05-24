// Variables
var table;
var actual_url = document.URL;
var method_call = "";
var url;
var flag_editando = false;
var select_disciplina = [];
var select_instructor = [];
var select_dificultad = [];

// Configuraciones
(actual_url.indexOf("index") < 0) ? method_call = "clases/" : method_call = "";
$.fn.dataTable.ext.errMode = 'throw'; // Configuración de manejo de errores de DataTables

$(document).ready(function () {
    url = method_call + "obtener_tabla_index"
    obtener_opciones_select_disciplina(); // Obtención de opciones para el select 'disciplina'
    obtener_opciones_select_instructor(); // Obtención de opciones para el select 'instructor'
    obtener_opciones_select_dificultad(); // Obtención de opciones para el select 'dificultad'

    // Inicializar
    table = $('#table').DataTable({
        "scrollX": true,
        "deferRender": true,
        'processing': true,
        "order": [[0, "desc"]],
        "lengthMenu": [[25, 50, 100, 250, 500, -1], [25, 50, 100, 250, 500, "Todos"]],
        "ajax": {
            "url": url,
            "type": 'POST'
        },
        "columns": [
            { "data": "id" },
            { "data": "identificador" },
            { "data": "disciplina_id" },
            { "data": "dificultad" },
            { "data": "inicia" },
            { "data": "horario_esp" },
            { "data": "instructor_id" },
            { "data": "cupo" },
            { "data": "estatus" },
            { "data": "intervalo_horas" },
            { "data": "cupo_restantes" },
            { "data": "cupo_original" },
            { "data": "cupo_reservado" },
            { "data": "inasistencias" },
            { "data": "sucursal" },
            { "data": "opciones" },
        ],
        "createdRow": createEditableCells,
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

    // Detectar doble clic en celda editable
    $('#table').on('dblclick', 'td.editable-cell', function () {
        if (!flag_editando) {

            flag_editando = true; // Marcar como en edición

            var celda_seleccionada = $(this); // Obtener la celda seleccionada
            var columna_indice = celda_seleccionada.index(); // Obtener el nombre de la columna según el índice
            var columna_nombres_list = table.settings().init().columns;
            var columna_nombre = columna_nombres_list[columna_indice].data;
            var valor_original_de_celda = celda_seleccionada.text();

            if (columna_nombre === "disciplina_id") {
                var input = generar_campo_de_celda_a_editar('select_indice_disciplina', valor_original_de_celda, select_disciplina);
            } else if (columna_nombre === "instructor_id") {
                var input = generar_campo_de_celda_a_editar('select_indice_instructor', valor_original_de_celda, select_instructor);
            } else if (columna_nombre === "dificultad") {
                var input = generar_campo_de_celda_a_editar('select', valor_original_de_celda, select_dificultad);
            } else if (columna_nombre === "inicia") {
                var input = generar_campo_de_celda_a_editar('fecha', valor_original_de_celda);
            } else if (columna_nombre === "cupo") {
                var input = generar_campo_de_celda_a_editar('numero', valor_original_de_celda);
            } else {
                var input = generar_campo_de_celda_a_editar('texto', valor_original_de_celda, null);
            }

            celda_seleccionada.data('valor_original_guardado', valor_original_de_celda); // Almacena el valor original en la celda
            celda_seleccionada.html(input);

            input.focus();

            // Guardar los cambios al salir del campo de entrada
            input.blur(function () {
                console.log(input.val());
                guardar_valor_de_celda(celda_seleccionada, columna_nombre, input);
            });

            // Escuchar el evento keydown para detectar "Enter"
            input.keydown(function (event) {
                if (event.which === 13) {
                    guardar_valor_de_celda(celda_seleccionada, columna_nombre, input);
                }
            });

        }
    });

    // Función para guardar el valor de la celda
    function guardar_valor_de_celda(celda_seleccionada, columna_nombre, input) {

        var valor_nuevo_de_celda = input.val();

        // Si no hay cambios, no realizar la solicitud AJAX
        if (celda_seleccionada.data('valor_original_guardado') === valor_nuevo_de_celda) {
            celda_seleccionada.html(celda_seleccionada.data('valor_original_guardado')); // Restaurar el valor en la celda
            flag_editando = false; // Marcar como fuera de edición
            return; // Salir de la función sin hacer nada
        }

        if (columna_nombre === "disciplina_id") {
            valor_nuevo_de_celda = generar_salida_de_celda_editada('select', valor_nuevo_de_celda, celda_seleccionada);
        } else if (columna_nombre === "instructor_id") {
            valor_nuevo_de_celda = generar_salida_de_celda_editada('select', valor_nuevo_de_celda, celda_seleccionada);
        } else if (columna_nombre === "dificultad") {
            valor_nuevo_de_celda = generar_salida_de_celda_editada('select mayusculas', valor_nuevo_de_celda, celda_seleccionada);
        } else if (columna_nombre === "inicia") {
            valor_nuevo_de_celda = generar_salida_de_celda_editada('fecha', valor_nuevo_de_celda, celda_seleccionada);
        } else if (columna_nombre === "cupo") {
            valor_nuevo_de_celda = generar_salida_de_celda_editada('numero', valor_nuevo_de_celda, celda_seleccionada);
        } else {
            valor_nuevo_de_celda = generar_salida_de_celda_editada('texto', valor_nuevo_de_celda, celda_seleccionada);
        }

        // Obtener la fila y los datos correspondientes
        var fila_tabla = table.row(celda_seleccionada.closest('tr'));
        var datos_fila_tabla = fila_tabla.data();

        function formatoNombrePropio(nombre) {
            return nombre.toLowerCase().replace(/\b\w/g, function (char) {
                return char.toUpperCase();
            });
        }

        if (columna_nombre === 'disciplina_id') {
            console.log('Entre al if 1');
            for (var i = 0; i < select_disciplina.length; i++) {
                console.log(select_disciplina[i].nombre)
                console.log(valor_nuevo_de_celda)
                if (select_disciplina[i].nombre === valor_nuevo_de_celda.toLocaleUpperCase()) {
                    console.log('Entre al if 2');
                    valor_nuevo_de_celda = select_disciplina[i].valor;
                    console.log(valor_nuevo_de_celda);
                    break;
                }
            }
        } else if (columna_nombre === 'instructor_id') {
            console.log('Entre al if 1');
            for (var i = 0; i < select_instructor.length; i++) {
                console.log(select_instructor[i].nombre)
                console.log(valor_nuevo_de_celda.toUpperCase())
                console.log(formatoNombrePropio(valor_nuevo_de_celda))
                if (select_instructor[i].nombre === (valor_nuevo_de_celda.toUpperCase())) {
                    console.log('Entre al if 2');
                    valor_nuevo_de_celda = select_instructor[i].valor;
                    console.log(valor_nuevo_de_celda);
                    break;
                } else if (select_instructor[i].nombre === formatoNombrePropio(valor_nuevo_de_celda)) {
                    console.log('Entre al if 3');
                    valor_nuevo_de_celda = select_instructor[i].valor;
                    console.log(valor_nuevo_de_celda);
                    break;
                }
            }
        }

        // Realizar una solicitud AJAX para actualizar el dato en la base de datos
        $.ajax({
            url: method_call + "actualizar", // Actualiza con la ruta correcta
            method: 'POST',
            data: {
                identificador: datos_fila_tabla.identificador,
                columna: columna_nombre,
                nuevoValor: valor_nuevo_de_celda
            },
            success: function (response) {
                if (columna_nombre === 'inicia' || columna_nombre === 'cupo') {
                    table.ajax.reload();
                }
                console.log('Dato actualizado en la base de datos');
                console.log(response);
                flag_editando = false; // Marcar como fuera de edición
            },
            error: function (xhr, status, error) {
                console.error('Error al actualizar el dato: ' + error);
                // Restaurar el valor original en caso de error
                celda_seleccionada.html(celda_seleccionada.data('valor_original_guardado'));
                flag_editando = false; // Marcar como fuera de edición
            }
        });
    }

    $('#filtro_clase_sucursal').change(function () {
        var sucursalSeleccionada = $(this).val();
        $.ajax({
            url: method_call + "guardar_seleccion",
            method: 'POST',
            data: {
                filtro_clase_sucursal: sucursalSeleccionada
            },
            success: function (response) {
                console.log(sucursalSeleccionada + ' Sucursal guardada en la sesión');
                table.ajax.reload();

                // Nueva solicitud AJAX para obtener las disciplinas de la sucursal seleccionada
                $.ajax({
                    url: method_call + "obtener_disciplinas",
                    method: 'GET',
                    data: {
                        sucursal_id: sucursalSeleccionada // enviar el ID de la sucursal seleccionada
                    },
                    dataType: 'json',
                    success: function (data) {
                        var disciplinas = data; // Asumiendo que response.disciplinas contiene las disciplinas
                        var $disciplinaSelect = $('#filtro_clase_disciplina');

                        // Limpiar el select de disciplinas
                        $disciplinaSelect.empty();
                        $disciplinaSelect.append('<option value="0">Todas las disciplinas</option>');

                        // Agregar las nuevas opciones
                        if (Array.isArray(disciplinas)) {
                            $.each(disciplinas, function (index, disciplina) {
                                $disciplinaSelect.append('<option value="' + disciplina.id + '">' + disciplina.nombre + '</option>');
                            });
                        } else {
                            console.error('La respuesta no es un array');
                        }

                        // Actualizar el select2
                        $disciplinaSelect.select2();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.error('Error al obtener disciplinas: ' + textStatus, errorThrown);
                    }
                });
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('Error al guardar la sucursal: ' + textStatus, errorThrown);
            }
        });
    });

    $('#filtro_clase_disciplina').change(function () {
        var disciplinaSeleccionada = $(this).val();
        $.ajax({
            url: method_call + "guardar_seleccion_disciplina",
            method: 'POST',
            data: {
                filtro_clase_disciplina: disciplinaSeleccionada
            },
            success: function (response) {
                console.log(disciplinaSeleccionada + ' Disciplina guardada en la sesión');
                table.ajax.reload();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('Error al guardar la disciplina: ' + textStatus, errorThrown);
            }
        });
    });

    $('#table').on('click', '.delete-row', function (e) {
        e.preventDefault();
        var row = $(this).closest('tr');
        var id = $(this).data('id');

        // if (confirm('¿Estás seguro de que deseas eliminar esta clase?')) {
        $.ajax({
            url: method_call + 'borrar/' + id,
            type: 'POST',
            dataType: 'json', // Asegúrate de que jQuery trate la respuesta como JSON
            success: function (response) {
                // Verifica que la respuesta contiene un campo `success` con valor `true`
                console.log(response); // Agrega este línea para verificar la respuesta en la consola
                if (response.success) {
                    row.fadeOut(500, function () {
                        table.row(row).remove().draw(false);
                    });
                } else {
                    alert('Error al borrar la clase. (1)' + id);
                }
            },
            error: function () {
                alert('Error al borrar la clase.');
            }
        });
        // }
    });

    $('#table').on('click', '.clonar-row', function (e) {
        e.preventDefault();
        var row = $(this).closest('tr');
        var id = $(this).data('id');

        // if (confirm('¿Estás seguro de que deseas eliminar esta clase?')) {
        $.ajax({
            url: method_call + 'duplicar_clase/' + id,
            type: 'POST',
            dataType: 'json', // Asegúrate de que jQuery trate la respuesta como JSON
            success: function (response) { // Verifica que la respuesta contiene un campo `success` con valor `true`
                console.log(response); // Agrega este línea para verificar la respuesta en la consola
                if (response.success) {
                    // Agrega una nueva fila con los datos de la clase clonada
                    var newData = response.data;
                    table.row.add({
                        identificador: newData.identificador,
                        disciplina_id: newData.disciplina_id,
                        dificultad: newData.instructor_id,
                        inicia: newData.inicia,
                        horario_esp: newData.horario_esp,
                        instructor_id: newData.instructor_nombre,
                        cupo: newData.cupo,
                        estatus: newData.estatus,
                        intervalo_horas: newData.intervalo_horas,
                        cupo_restantes: newData.cupo - newData.reservado,
                        cupo_original: newData.cupo,
                        cupo_reservado: newData.reservado,
                        inasistencias: newData.inasistencias,
                        sucursal: newData.sucursal_nombre + ' [' + newData.sucursal_locacion + ']',
                        opciones: generateOpciones(newData)
                    }).draw(false);
                } else {
                    alert('Error al clonar la clase. (1)');
                }
            },
            error: function () {
                alert('Error al clonar la clase. (2)');
            }
        });
        // }
    });

});

function generateOpciones(clase) {
    var opciones = '';
    if (clase.estatus != 'Cancelada') {
        var fecha_de_clase = clase.inicia;
        var fecha_limite_de_clase = new Date(fecha_de_clase);
        fecha_limite_de_clase.setHours(fecha_limite_de_clase.getHours() + 48);

        if (new Date() < fecha_limite_de_clase) {
            opciones += '<a href="' + method_call + 'clases/reservar/' + clase.id + '">Reservar</a>';
        }

        opciones += ' | ';
        opciones += '<a href="' + method_call + 'clases/editar/' + clase.id + '">Editar</a>';
        opciones += ' | ';
    }
    if (clase.estatus == 'Activa') {
        opciones += '<a href="' + method_call + 'clases/duplicar_clase/' + clase.id + '"><span>Duplicar</span></a>';
    }
    if (clase.reservado == 0) {
        if (clase.estatus == 'Activa') {
            opciones += ' | ';
            opciones += '<a href="' + method_call + 'clases/cancelar/' + clase.id + '"><span class="red">Cancelar</span></a>';
            opciones += '  |  ';
            opciones += '<a href="' + method_call + 'clases/borrar/' + clase.id + '"><span class="red">Borrar</span></a>';
        }
        if (clase.reservado == 0 && clase.estatus == 'Cancelada') {
            opciones += '<a href="' + method_call + 'clases/borrar/' + clase.id + '"><span class="red">Borrar</span></a>';
        }
    }

    return opciones;
}

// Función para obtener opciones del select 'disciplina'
async function obtener_opciones_select_disciplina() {
    // Realizar una solicitud AJAX para obtener las opciones de select_disciplina
    $.ajax({
        url: method_call + "obtener_opciones_select_disciplina",
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            select_disciplina = data;
            console.log('Opciones de disciplina cargadas:', select_disciplina);
        },
        error: function (xhr, status, error) {
            console.error('Error al obtener opciones de disciplina: ' + error);
        }
    });
}

async function obtener_opciones_select_instructor() {
    // Realizar una solicitud AJAX para obtener las opciones de select_instructor
    $.ajax({
        url: method_call + "obtener_opciones_select_instructor",
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            select_instructor = data;
            console.log('Opciones de instructor cargadas:', select_instructor);
        },
        error: function (xhr, status, error) {
            console.error('Error al obtener opciones de instructor: ' + error);
        }
    });
}

// Función para obtener opciones del select 'dificultad'
async function obtener_opciones_select_dificultad() {
    $.ajax({
        url: method_call + "obtener_opciones_select_dificultad",
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            select_dificultad = data;
            console.log('Opciones de dificultad cargadas:', select_dificultad);
        },
        error: function (xhr, status, error) {
            console.error('Error al obtener opciones de dificultad: ' + error);
        }
    });
}

function createEditableCells(row, data, dataIndex) {
    var columnsToEdit = [2, 3, 4, 6];
    $.each(columnsToEdit, function (index, columnIndex) {
        $('td:eq(' + columnIndex + ')', row).addClass('editable-cell');
    });
}
