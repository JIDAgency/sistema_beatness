var body = document.querySelector('body');
var select = document.getElementById('disciplina_seleccionada');

var disciplina_seleccionada = '';

document.getElementById('disciplina_titulo').innerHTML = select.options[select.selectedIndex].innerText;
document.getElementById('disciplina_titulo_siguiente').innerHTML = select.options[select.selectedIndex].innerText;

obtener_clases_semana_actual_por_disciplina_id(disciplina_seleccionada);
obtener_clases_fin_de_semana_actual_por_disciplina_id(disciplina_seleccionada);
obtener_clases_semana_actual_por_disciplina_id_para_dia(disciplina_seleccionada);
obtener_clases_fin_de_semana_actual_por_disciplina_id_para_dia(disciplina_seleccionada)
obtener_clases_semana_siguiente_por_disciplina_id(disciplina_seleccionada);
obtener_clases_fin_de_semana_siguiente_por_disciplina_id(disciplina_seleccionada);

cambiarFondo();

select.onchange = function () {
    document.getElementById('disciplina_titulo').innerHTML = select.options[select.selectedIndex].innerText;
    document.getElementById('disciplina_titulo_siguiente').innerHTML = select.options[select.selectedIndex].innerText;

    disciplina_seleccionada = this.value;

    obtener_clases_semana_actual_por_disciplina_id(disciplina_seleccionada);
    obtener_clases_fin_de_semana_actual_por_disciplina_id(disciplina_seleccionada);
    obtener_clases_semana_actual_por_disciplina_id_para_dia(disciplina_seleccionada);
    obtener_clases_fin_de_semana_actual_por_disciplina_id_para_dia(disciplina_seleccionada)
    obtener_clases_semana_siguiente_por_disciplina_id(disciplina_seleccionada);
    obtener_clases_fin_de_semana_siguiente_por_disciplina_id(disciplina_seleccionada);

    cambiarFondo();
};

const reload = document.getElementById("reload");
const loading = document.getElementById("loading");

reload.addEventListener("click", async (_) => {
    loading.classList.add('spinner'); // Mostrar el indicador de carga

    try {
        await obtener_clases_semana_actual_por_disciplina_id(disciplina_seleccionada);
        await obtener_clases_fin_de_semana_actual_por_disciplina_id(disciplina_seleccionada);
        await obtener_clases_semana_actual_por_disciplina_id_para_dia(disciplina_seleccionada);
        obtener_clases_fin_de_semana_actual_por_disciplina_id_para_dia(disciplina_seleccionada)
        await obtener_clases_semana_siguiente_por_disciplina_id(disciplina_seleccionada);
        await obtener_clases_fin_de_semana_siguiente_por_disciplina_id(disciplina_seleccionada);
    } catch (error) {
        console.error('Error al actualizar las clases:', error);
    } finally {
        loading.classList.remove('spinner'); // Ocultar el indicador de carga
    }
});

function obtener_clases_semana_actual_por_disciplina_id(disciplina_id) {
    return new Promise((resolve, reject) => {
        fetch('../web/calendario/obtener_clases_semana_actual_por_disciplina_id/' + disciplina_id)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    console.error('Error backoffice');
                    return false;
                }
                console.log("Data:", data);

                document.getElementById('contenido_semana').innerHTML = data.data;
                resolve(data); // Resuelve la promesa con los datos obtenidos
            })
            .catch(error => {
                console.error('Error: ' + error);
                reject(error); // Rechaza la promesa en caso de error
                // return;
            });
    });
}

function obtener_clases_fin_de_semana_actual_por_disciplina_id(disciplina_id) {
    return new Promise((resolve, reject) => {
        fetch('../web/calendario/obtener_clases_fin_de_semana_actual_por_disciplina_id/' + disciplina_id)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    console.error('Error backoffice');
                    return false;
                }
                console.log("Data:", data);

                document.getElementById('contenido_fin_de_semana').innerHTML = data.data;
                resolve(data); // Resuelve la promesa con los datos obtenidos
            })
            .catch(error => {
                console.error('Error: ' + error);
                reject(error); // Rechaza la promesa en caso de error
                // return;
            });
    });
}

function obtener_clases_semana_actual_por_disciplina_id_para_dia(disciplina_id) {
    return new Promise((resolve, reject) => {
        fetch('../web/calendario/obtener_clases_semana_actual_por_disciplina_id_para_dia/' + disciplina_id)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    console.error('Error backoffice');
                    return false;
                }
                console.log("Data:", data);

                document.getElementById('contenido_lunes').innerHTML = data.data[0];
                document.getElementById('contenido_martes').innerHTML = data.data[1];
                document.getElementById('contenido_miercoles').innerHTML = data.data[2];
                document.getElementById('contenido_jueves').innerHTML = data.data[3];
                document.getElementById('contenido_viernes').innerHTML = data.data[4];
                resolve(data); // Resuelve la promesa con los datos obtenidos
            })
            .catch(error => {
                console.error('Error: ' + error);
                reject(error); // Rechaza la promesa en caso de error
                // return;
            });
    });
}

function obtener_clases_fin_de_semana_actual_por_disciplina_id_para_dia(disciplina_id) {
    return new Promise((resolve, reject) => {
        fetch('../web/calendario/obtener_clases_fin_de_semana_actual_por_disciplina_id_para_dia/' + disciplina_id)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    console.error('Error backoffice');
                    return false;
                }
                console.log("Data:", data);

                document.getElementById('contenido_sabado').innerHTML = data.data[0];
                document.getElementById('contenido_domingo').innerHTML = data.data[1];
                resolve(data); // Resuelve la promesa con los datos obtenidos
            })
            .catch(error => {
                console.error('Error: ' + error);
                reject(error); // Rechaza la promesa en caso de error
                // return;
            });
    });
}

function obtener_clases_semana_siguiente_por_disciplina_id(disciplina_id) {
    return new Promise((resolve, reject) => {
        fetch('../web/calendario/obtener_clases_semana_siguiente_por_disciplina_id/' + disciplina_id)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    console.error('Error backoffice');
                    return false;
                }
                console.log("Data:", data);

                document.getElementById('contenido_semana_siguiente').innerHTML = data.data;
                resolve(data); // Resuelve la promesa con los datos obtenidos
            })
            .catch(error => {
                console.error('Error: ' + error);
                reject(error); // Rechaza la promesa en caso de error
                // return;
            });
    });
}

function obtener_clases_fin_de_semana_siguiente_por_disciplina_id(disciplina_id) {
    return new Promise((resolve, reject) => {
        fetch('../web/calendario/obtener_clases_fin_de_semana_siguiente_por_disciplina_id/' + disciplina_id)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    console.error('Error backoffice');
                    return false;
                }
                console.log("Data:", data);

                document.getElementById('contenido_fin_de_semana_siguiente').innerHTML = data.data;
                resolve(data); // Resuelve la promesa con los datos obtenidos
            })
            .catch(error => {
                console.error('Error: ' + error);
                reject(error); // Rechaza la promesa en caso de error
                // return;
            });
    });
}

function cambiarFondo() {
    if (disciplina_seleccionada == 10) {
        body.style.backgroundImage = "url('../almacenamiento/disciplinas/bg-calendario-bootcamp.jpg')";
    } else if (disciplina_seleccionada == 19) {
        body.style.backgroundImage = "url('../almacenamiento/disciplinas/bg-calendario-indoorcycling.jpg')";
    } else {
        body.style.backgroundImage = "url('../almacenamiento/disciplinas/bg-calendario.svg')";
    }
}