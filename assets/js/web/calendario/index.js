var body = document.querySelector('body');
var select = document.getElementById('disciplina_seleccionada');
var disciplina_seleccionada = 10;

document.getElementById('disciplina_titulo').innerHTML = select.options[select.selectedIndex].innerText;

obtener_clases_semana_actual_por_disciplina_id(disciplina_seleccionada);
obtener_clases_fin_de_semana_actual_por_disciplina_id(disciplina_seleccionada);
cambiarFondo();

select.onchange = function () {
    //document.getElementById('card_titulo').innerHTML = this.value;
    document.getElementById('disciplina_titulo').innerHTML = select.options[select.selectedIndex].innerText;
    disciplina_seleccionada = this.value;
    obtener_clases_semana_actual_por_disciplina_id(disciplina_seleccionada);
    obtener_clases_fin_de_semana_actual_por_disciplina_id(disciplina_seleccionada);
    cambiarFondo();
};

function obtener_clases_semana_actual_por_disciplina_id(disciplina_id) {
    fetch('../web/calendario/obtener_clases_semana_actual_por_disciplina_id/' + disciplina_id)
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
    fetch('../web/calendario/obtener_clases_fin_de_semana_actual_por_disciplina_id/' + disciplina_id)
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

function cambiarFondo() {
    if (disciplina_seleccionada == 10) {
        body.style.backgroundImage = "url('../almacenamiento/disciplinas/bg-calendario-bootcamp.jpg')";
    } else if (disciplina_seleccionada == 19) {
        body.style.backgroundImage = "url('../almacenamiento/disciplinas/bg-calendario-indoorcycling.jpg')";
    } else {
        body.style.backgroundImage = "url('../almacenamiento/img/bg-calendario.svg')";
    }
}