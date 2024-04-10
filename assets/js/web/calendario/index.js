obtener_clases_semana_actual_por_disciplina_id(2);
obtener_clases_fin_de_semana_actual_por_disciplina_id(2);

var select = document.getElementById('disciplina_seleccionada');

document.getElementById('disciplina_titulo').innerHTML = select.options[select.selectedIndex].innerText;

select.onchange = function () {
    //document.getElementById('card_titulo').innerHTML = this.value;
    document.getElementById('disciplina_titulo').innerHTML = select.options[select.selectedIndex].innerText;
    obtener_clases_semana_actual_por_disciplina_id(this.value);
    obtener_clases_fin_de_semana_actual_por_disciplina_id(this.value);
};

function obtener_clases_semana_actual_por_disciplina_id(disciplina_id) {
    fetch('http://localhost:8888/sistema_beatness/web/calendario/obtener_clases_semana_actual_por_disciplina_id/' + disciplina_id)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error('Error backoffice');
                return false;
            }
            console.log("Data:", data);

            document.getElementById('contenido_semana').innerHTML = data.data;
        })
        .catch(error => {
            console.error('Error: ' + error);
            return;
        });
}

function obtener_clases_fin_de_semana_actual_por_disciplina_id(disciplina_id) {
    fetch('http://localhost:8888/sistema_beatness/web/calendario/obtener_clases_fin_de_semana_actual_por_disciplina_id/' + disciplina_id)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error('Error backoffice');
                return false;
            }
            console.log("Data:", data);

            document.getElementById('contenido_fin_de_semana').innerHTML = data.data;
        })
        .catch(error => {
            console.error('Error: ' + error);
            return;
        });
}