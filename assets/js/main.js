$(document).ready(function () {

    'use strict';

    window.addEventListener('load', function () {
        var forms = document.getElementsByClassName('needs-validation');

        var validation = Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);

});

$(".custom-file-input").on("change", function () {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});

function load_table(table, url) {
    table.ajax.url(url).load();
}

function reload_table(table) {
    // table.ajax.reload(reload_callback);
    table.ajax.reload();
}


// Función para dar formato a números
function formato_numero(data) {
    return parseFloat(data.replace(/[^0-9.-]+/g, "")).toFixed(2);
}

// Función para dar formato a moneda
function formato_moneda(data) {
    return parseFloat(data).toLocaleString('es-MX', {
        style: 'currency',
        currency: 'MXN'
    });
}

function formato_capitalizar(data) {
    if (data.length === 0) {
        return data;
    }

    return data.charAt(0).toUpperCase() + data.slice(1);
}

function formatoNombrePropio(nombre) {
    return nombre.toLowerCase().replace(/\b\w/g, function (char) {
        return char.toUpperCase();
    });
}

function generar_campo_de_celda_a_editar(tipo_celda, valor_original_de_celda, data_opciones = null) {
    switch (tipo_celda) {
        case 'texto':
            var input = $('<input type="text" class="form-control">').val(valor_original_de_celda);
            return input;

        case 'numero':
            var input = $('<input type="number" class="form-control">').val(valor_original_de_celda);
            return input;

        case 'fecha':
            var partes_fecha_y_hora = valor_original_de_celda.split(' ');
            var fecha_dividida = partes_fecha_y_hora[0].split('/');
            var hora_dividida = partes_fecha_y_hora[1].split(':');

            // Reordenar las partes de la fecha para formar yyyy-mm-dd
            var fecha_con_formato = fecha_dividida[2] + '-' + fecha_dividida[1] + '-' + fecha_dividida[0] + 'T' + hora_dividida[0] + ':' + hora_dividida[1];

            console.log(fecha_dividida);
            console.log('0: ' + fecha_dividida[0]);
            console.log('1: ' + fecha_dividida[1]);
            console.log('2: ' + fecha_dividida[2]);
            console.log('fecha ' + fecha_con_formato);

            var input = $('<input type="datetime-local" class="form-control">').val(fecha_con_formato);
            return input;

        case 'select':

            var input = $('<select class="form-control"></select>');

            // Agregar opciones al select
            $.each(data_opciones, function (index, opcion) {
                input.append('<option selected value="' + opcion.valor + '">' + opcion.nombre + '</option>');
            });

            // Establecer el valor original seleccionado
            input.val(valor_original_de_celda.toString());

            return input;

        case 'select_indice_disciplina':

            var input = $('<select class="form-control"></select>');

            // Agregar opciones al select
            $.each(data_opciones, function (index, opcion) {
                input.append('<option selected value="' + opcion.nombre + '">' + opcion.nombre + '</option>');
            });

            // Establecer el valor original seleccionado
            input.val(valor_original_de_celda.toLocaleUpperCase());

            return input;
        case 'select_indice_instructor':

            var input = $('<select class="form-control"></select>');

            // Asegúrate de que valor_original_de_celda está en mayúsculas para comparaciones coherentes
            var valor_original_mayuscula = valor_original_de_celda.trim().toUpperCase();

            // Agregar opciones al select
            $.each(data_opciones, function (index, opcion) {
                var opcion_nombre_mayuscula = opcion.nombre.trim().toUpperCase();
                console.log('Valore: ' + valor_original_mayuscula);
                console.log('instructor: ' + opcion_nombre_mayuscula);
                var option = $('<option></option>')
                    .val(opcion_nombre_mayuscula)
                    .text(opcion_nombre_mayuscula);

                // Marcar como seleccionada si coincide con el valor original
                if (opcion_nombre_mayuscula === valor_original_mayuscula) {
                    console.log('Entre al if de valores :)')
                    option.prop('selected', true);
                } else {
                    console.log('No entre a nada :(')
                }

                input.append(option);
            });


            // Establecer el valor original seleccionado
            input.val(valor_original_mayuscula);

            return input;
        default:
            break;
    }
}

function generar_salida_de_celda_editada(tipo_celda, valor_nuevo_de_celda, celda_seleccionada) {
    console.log('Entrada:', table.row(celda_seleccionada.closest('tr')).data());

    switch (tipo_celda) {
        case 'texto':
            // Sin formatos
            celda_seleccionada.html(valor_nuevo_de_celda);

            actualizar_data_de_tabla(celda_seleccionada, valor_nuevo_de_celda);
            return valor_nuevo_de_celda;

        case 'numero':
            // Formatear el nuevo valor como decimales para la celda
            valor_nuevo_de_celda = valor_nuevo_de_celda;
            celda_seleccionada.html(valor_nuevo_de_celda);

            actualizar_data_de_tabla(celda_seleccionada, valor_nuevo_de_celda);
            // Convertir el valor formateado a decimales antes de guardar en la base de datos
            return valor_nuevo_de_celda;

        case 'fecha':
            var fecha_dividida = valor_nuevo_de_celda.split('-');
            var mes_dividida = fecha_dividida[2].split('T'); // Dividir en T
            var hora_dividida = mes_dividida[1].split(':'); // Dividir en H
            var hora = hora_dividida[0]; // Hora
            var minutos = hora_dividida[1]; // Minutos
            // console.log(valor_nuevo_de_celda);
            // console.log(fecha_dividida);
            // console.log(mes_dividida);
            // console.log(hora_dividida);
            // console.log(hora);
            // console.log(minutos);
            var fecha_con_formato = mes_dividida[0] + '/' + fecha_dividida[1] + '/' + fecha_dividida[0] + ' ' + hora + ':' + minutos + ':' + '00';

            celda_seleccionada.html(fecha_con_formato);

            actualizar_data_de_tabla(celda_seleccionada, fecha_con_formato);
            return valor_nuevo_de_celda;

        case 'moneda':
            // Formatear el nuevo valor como moneda para la celda
            valor_nuevo_de_celda = formato_moneda(valor_nuevo_de_celda);
            celda_seleccionada.html(valor_nuevo_de_celda);

            actualizar_data_de_tabla(celda_seleccionada, formato_numero(valor_nuevo_de_celda)); // NOTA: Hay que devolver la salida tal cual la tabla tenia el valor origina, hay que revisarlo cuando tienen formato de render.
            // Convertir el valor formateado a decimales antes de guardar en la base de datos
            return formato_numero(valor_nuevo_de_celda);

        case 'select':
            // Formatear el nuevo valor como texto capital para la celda
            valor_nuevo_de_celda = valor_nuevo_de_celda.charAt(0).toUpperCase() + valor_nuevo_de_celda.slice(1);
            celda_seleccionada.html(valor_nuevo_de_celda);

            actualizar_data_de_tabla(celda_seleccionada, valor_nuevo_de_celda);
            // Convertir el valor formateado a texto minúsculas antes de guardar en la base de datos
            return valor_nuevo_de_celda.toLowerCase();

        case 'select mayusculas':
            // Formatear el nuevo valor como texto mayúsculas para la celda
            valor_nuevo_de_celda = valor_nuevo_de_celda.toUpperCase();
            celda_seleccionada.html(valor_nuevo_de_celda);

            actualizar_data_de_tabla(celda_seleccionada, valor_nuevo_de_celda);
            // Convertir el valor formateado a texto mayusculas antes de guardar en la base de datos
            return valor_nuevo_de_celda.toUpperCase();

        default:
            break;
    }

    function actualizar_data_de_tabla(celda_seleccionada, valor_nuevo_de_celda) {
        table.cell(celda_seleccionada).data(valor_nuevo_de_celda).draw(false);
        console.log('Salida:', table.row(celda_seleccionada.closest('tr')).data());
    }
}
