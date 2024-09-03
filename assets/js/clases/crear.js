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
(actual_url.indexOf("index") < 0) ? method_call = "" : method_call = "";

$(function () {
    // Inicializar date dropper (si es necesario)

    // Establecer validaciones
    $("#forma-crear-clase").validate({
        rules: {
            "identificador": {
                required: true
            },
            "instructor_id": {
                required: true
            },
            /*"dificultad": {
                required: true
            },*/
            "intervalo_horas": {
                required: true,
                number: true
            },
            "disciplina_id": {
                required: true
            },
            "cupo": {
                required: true
            }
        },
        messages: {
            "identificador": {
                required: "Este campo es requerido"
            },
            "instructor_id": {
                required: "Debe seleccionar un instructor"
            },
            /*"dificultad": {
                required: "Este campo es requerido"
            },*/
            "intervalo_horas": {
                required: "Este campo es requerido",
                number: "Debe ser un valor numerico"
            },
            "disciplina_id": {
                required: "Por favor seleccione una disciplina"
            },
            "cupo": {
                required: "Debe establecer el cupo"
            }
        },
        errorClass: "has-error"
    });

    // Manejar el cambio de disciplina y actualizar las dificultades
    $('#disciplina_id').change(function () {
        var disciplina_id = $(this).val();

        // Solicitud AJAX para obtener las dificultades basadas en la disciplina seleccionada
        $.ajax({
            url: method_call + 'obtener_dificultades_por_disciplina',
            method: 'POST',
            data: {disciplina_id: disciplina_id},
            dataType: 'json',
            success: function (response) {
                $('#dificultad').empty(); // Limpia el select de dificultad
                $('#dificultad').append('<option value="">Seleccione un grupo muscular…</option>');

                $.each(response, function (index, value) {
                    $('#dificultad').append('<option value="' + value.id + '|' + value.nombre + '">' + value.nombre + '</option>');
                });
            }
        });
    });
});
