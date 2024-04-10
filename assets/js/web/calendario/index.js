dibujar_tabla_calendario(1);

var select = document.getElementById('disciplina_seleccionada');

select.onchange = function () {
    document.getElementById('card_titulo').innerHTML = this.value;
    dibujar_tabla_calendario(this.value);
};

function dibujar_tabla_calendario(disciplina_id) {
    fetch('http://localhost:8888/sistema_beatness/web/calendario/dibujar_tabla_calendario/' + disciplina_id)
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