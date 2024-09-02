var body = document.querySelector('body');
var select = document.getElementById('disciplina_seleccionada');

var disciplina_seleccionada = '';

// document.getElementById('disciplina_titulo').innerHTML = select.options[select.selectedIndex].innerText;
// document.getElementById('disciplina_titulo_siguiente').innerHTML = select.options[select.selectedIndex].innerText;

obtener_clases_semana_actual_por_disciplina_id(disciplina_seleccionada);
obtener_clases_fin_de_semana_actual_por_disciplina_id(disciplina_seleccionada);
obtener_clases_semana_actual_por_disciplina_id_para_dia(disciplina_seleccionada);
obtener_clases_fin_de_semana_actual_por_disciplina_id_para_dia(disciplina_seleccionada)
obtener_clases_semana_siguiente_por_disciplina_id(disciplina_seleccionada);
obtener_clases_fin_de_semana_siguiente_por_disciplina_id(disciplina_seleccionada);

cambiarFondo();

select.onchange = function () {
    // document.getElementById('disciplina_titulo').innerHTML = select.options[select.selectedIndex].innerText;
    // document.getElementById('disciplina_titulo_siguiente').innerHTML = select.options[select.selectedIndex].innerText;

    disciplina_seleccionada = this.value;

    if (disciplina_seleccionada == 10) {
        document.getElementById('disciplina_titulo_lunes').innerHTML = "/ LEGS & BOOTY";
        document.getElementById('disciplina_titulo_martes').innerHTML = "/ UPPER BODY";
        document.getElementById('disciplina_titulo_miercoles').innerHTML = "/ KILLER ABS";
        document.getElementById('disciplina_titulo_jueves').innerHTML = "/ ARMS & BOOTY";
        document.getElementById('disciplina_titulo_viernes').innerHTML = "/ FULL BODY &#x1F525";
        document.getElementById('disciplina_titulo_sabado').innerHTML = "/ ABS & BOOTY &#x1F525";
        document.getElementById('disciplina_titulo_domingo').innerHTML = "/ FULL BODY";

        document.getElementById('disciplina_titulo_lunesnext').innerHTML = "/ LEGS & BOOTY";
        document.getElementById('disciplina_titulo_martesnext').innerHTML = "/ UPPER BODY";
        document.getElementById('disciplina_titulo_miercolesnext').innerHTML = "/ KILLER ABS";
        document.getElementById('disciplina_titulo_juevesnext').innerHTML = "/ ARMS & BOOTY";
        document.getElementById('disciplina_titulo_viernesnext').innerHTML = "/ FULL BODY &#x1F525";
        document.getElementById('disciplina_titulo_sabadonext').innerHTML = "/ ABS & BOOTY &#x1F525";
        document.getElementById('disciplina_titulo_domingonext').innerHTML = "/ FULL BODY";
    } else if(disciplina_seleccionada == 19) {
        document.getElementById('disciplina_titulo_lunes').innerHTML = "";
        document.getElementById('disciplina_titulo_martes').innerHTML = "";
        document.getElementById('disciplina_titulo_miercoles').innerHTML = "";
        document.getElementById('disciplina_titulo_jueves').innerHTML = "";
        document.getElementById('disciplina_titulo_viernes').innerHTML = "";
        document.getElementById('disciplina_titulo_sabado').innerHTML = "";
        document.getElementById('disciplina_titulo_domingo').innerHTML = "";

        document.getElementById('disciplina_titulo_lunesnext').innerHTML = "";
        document.getElementById('disciplina_titulo_martesnext').innerHTML = "";
        document.getElementById('disciplina_titulo_miercolesnext').innerHTML = "";
        document.getElementById('disciplina_titulo_juevesnext').innerHTML = "";
        document.getElementById('disciplina_titulo_viernesnext').innerHTML = "";
        document.getElementById('disciplina_titulo_sabadonext').innerHTML = "";
        document.getElementById('disciplina_titulo_domingonext').innerHTML = "";
    } else {
        document.getElementById('disciplina_titulo_lunes').innerHTML = "/ LEGS & BOOTY";
        document.getElementById('disciplina_titulo_martes').innerHTML = "/ PUSH DAY";
        document.getElementById('disciplina_titulo_miercoles').innerHTML = "/ LEG DAY";
        document.getElementById('disciplina_titulo_jueves').innerHTML = "/ PULL DAY";
        document.getElementById('disciplina_titulo_viernes').innerHTML = "/ BOOTY";
        document.getElementById('disciplina_titulo_sabado').innerHTML = "/ UPPER BODY";
        document.getElementById('disciplina_titulo_domingo').innerHTML = "/ FULL BODY";

        document.getElementById('disciplina_titulo_lunesnext').innerHTML = "/ LEGS & BOOTY";
        document.getElementById('disciplina_titulo_martesnext').innerHTML = "/ PUSH DAY";
        document.getElementById('disciplina_titulo_miercolesnext').innerHTML = "/ LEG DAY";
        document.getElementById('disciplina_titulo_juevesnext').innerHTML = "/ PULL DAY";
        document.getElementById('disciplina_titulo_viernesnext').innerHTML = "/ BOOTY";
        document.getElementById('disciplina_titulo_sabadonext').innerHTML = "/ UPPER BODY";
        document.getElementById('disciplina_titulo_domingonext').innerHTML = "/ FULL BODY";
    }

    obtener_clases_semana_actual_por_disciplina_id(disciplina_seleccionada);
    obtener_clases_fin_de_semana_actual_por_disciplina_id(disciplina_seleccionada);
    obtener_clases_semana_actual_por_disciplina_id_para_dia(disciplina_seleccionada);
    obtener_clases_fin_de_semana_actual_por_disciplina_id_para_dia(disciplina_seleccionada)
    obtener_clases_semana_siguiente_por_disciplina_id(disciplina_seleccionada);
    obtener_clases_fin_de_semana_siguiente_por_disciplina_id(disciplina_seleccionada);

    cambiarFondo();
};

document.addEventListener('DOMContentLoaded', function () {
    // Seleccionamos todos los <th> y los enlaces dentro de los <th>
    document.querySelectorAll('.day-link').forEach(function (link) {
        link.addEventListener('click', function (event) {
            event.preventDefault();
            // Ocultar el div contenedor de la tabla
            document.getElementById('tabla-container').style.display = 'none';
            document.getElementById('tabla-dia').style.display = 'block';

            // Obtener el id del tab correspondiente
            var tabId = this.getAttribute('aria-controls');

            // Quitar la clase 'active' de todos los enlaces de navegación
            document.querySelectorAll('#tabla-dia .nav-link').forEach(function(navLink) {
                navLink.classList.remove('active');
            });

            // Añadir la clase 'active' al enlace de navegación clicado
            document.getElementById(this.id).classList.add('active');

            // Quitar la clase 'active' de todos los tab panes
            document.querySelectorAll('#tabla-dia .tab-pane').forEach(function(tab) {
                tab.classList.remove('active');
            });

            // Añadir la clase 'active' al tab correspondiente
            document.getElementById(tabId).classList.add('active');
        });
    });

    document.querySelectorAll('.day-link2').forEach(function (link) {
        link.addEventListener('click', function (event) {
            event.preventDefault();
            // Ocultar el div contenedor de la tabla
            document.getElementById('tabla-container').style.display = 'none';
            document.getElementById('tabla-dianext').style.display = 'block';

            // Obtener el id del tab correspondiente
            var tabId = this.getAttribute('aria-controls');

            // Quitar la clase 'active' de todos los enlaces de navegación
            document.querySelectorAll('#tabla-dianext .nav-link').forEach(function(navLink) {
                navLink.classList.remove('active');
            });

            // Añadir la clase 'active' al enlace de navegación clicado
            document.getElementById(this.id).classList.add('active');

            // Quitar la clase 'active' de todos los tab panes
            document.querySelectorAll('#tabla-dianext .tab-pane').forEach(function(tab) {
                tab.classList.remove('active');
            });

            // Añadir la clase 'active' al tab correspondiente
            document.getElementById(tabId).classList.add('active');
        });
    });

    // document.querySelectorAll('.semana th').forEach(function(th) {
    //     th.addEventListener('click', function(event) {
    //         event.preventDefault();
    //         // Ocultar el div contenedor de la tabla
    //         document.getElementById('tabla-container').style.display = 'none';
    //         document.getElementById('tabla-dia').style.display = 'block';
    //     });
    // });

    document.querySelectorAll('.semanal').forEach(function (th) {
        th.addEventListener('click', function (event) {
            event.preventDefault();
            // Ocultar el div contenedor de la tabla
            document.getElementById('tabla-container').style.display = 'block';
            document.getElementById('tabla-dia').style.display = 'none';
            document.getElementById('tabla-dianext').style.display = 'none';
        });
    });
});

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
        body.style.backgroundImage = "url('../almacenamiento/disciplinas/bg-calendario.jpg')";
    }
}

function handleSelectChange(selectElement) {
    var selectedValue = selectElement.value;

    if (selectedValue === "semanal") {
        // Reset the select to its default value
        document.getElementById(selectedValue).click();
        selectElement.selectedIndex = 0;
    } else {
        // Simulate a click on the corresponding tab
        document.getElementById(selectedValue).click();
    }
}

document.addEventListener('DOMContentLoaded', function() {
    var navLinks = document.querySelectorAll('.nav-tabs .nav-link');
    var navLinks = document.querySelectorAll('nav2 .nav-link');
    var select = document.getElementById('nav-tabs-select');
    var select = document.getElementById('nav-tabs-select2');

    navLinks.forEach(function(link) {
        link.addEventListener('click', function() {
            // Remove 'active' class from all nav-links
            navLinks.forEach(function(lnk) {
                lnk.classList.remove('active');
            });
            // Add 'active' class to the clicked nav-link
            this.classList.remove('active');
            // Set the corresponding select option to selected
            select.value = this.id;
        });
    });

    select.addEventListener('change', function() {
        handleSelectChange(this);
    });
});
