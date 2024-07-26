document.addEventListener('DOMContentLoaded', function () {
    const fecha_inicio_input = document.getElementById('fecha_inicio');
    const fecha_fin_input = document.getElementById('fecha_fin');
    const sucursal_select = document.getElementById('sucursal');
    const actualizar_grafica_btn = document.getElementById('actualizar_grafica');

    let canvas_grafica = null; // Inicializar canvas_grafica como null

    async function obtener_reservaciones_agrupadas_por_usuario(fecha_inicio, fecha_fin, sucursal) {
        try {
            const response = await fetch(`../reportes/obtener_reservaciones_agrupadas_por_usuario?fecha_inicio=${fecha_inicio}&fecha_fin=${fecha_fin}&sucursal=${sucursal}`);

            if (!response.ok) {
                throw new Error(`Error: ${response.statusText}`);
            }

            const content_type = response.headers.get("content-type");
            if (content_type && content_type.indexOf("application/json") !== -1) {
                const reservaciones = await response.json();
                const labels = reservaciones.map(res => res.email);
                const datos = reservaciones.map(res => res.total_reservaciones);

                actualizar_grafica(labels, datos, reservaciones);
            } else {
                const text = await response.text();
                throw new Error(`La respuesta no es JSON: ${text}`);
            }
        } catch (error) {
            console.error('Error obteniendo reservaciones agrupadas:', error);
        }
    }

    function actualizar_grafica(labels, datos, reservaciones) {
        const container = document.querySelector('.chart-container');
        const altura_por_dato = 25; // Ajusta este valor según sea necesario
        const altura_canvas = altura_por_dato * labels.length;

        container.style.height = `${altura_canvas}px`;

        const ctx = document.getElementById('canvas_grafica').getContext('2d');

        if (canvas_grafica) {
            canvas_grafica.destroy(); // Destruir la gráfica anterior si existe
        }

        canvas_grafica = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total de Reservaciones',
                    data: datos,
                    backgroundColor: 'rgba(0, 248, 254, 0.2)',
                    borderColor: 'rgba(0, 248, 254, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                plugins: {
                    datalabels: {
                        anchor: 'start',
                        align: 'end',
                        color: 'black',
                        font: {
                            weight: 'bold'
                        },
                        formatter: (value) => value
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    },
                    x: {
                        ticks: {
                            autoSkip: false,
                            maxRotation: 90,
                            minRotation: 0
                        }
                    }
                },
                onClick: function (event, elements) {
                    if (elements.length > 0) {
                        const element_index = elements[0].index;
                        const usuario_id = reservaciones[element_index].id; // Asegúrate de que el usuario_id esté disponible
                        window.location.href = `../clientes/editar/${usuario_id}`;
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
    }

    function actualizar_datos_grafica() {
        const fecha_inicio = fecha_inicio_input.value;
        const fecha_fin = fecha_fin_input.value;
        const sucursal = sucursal_select.value;
        obtener_reservaciones_agrupadas_por_usuario(fecha_inicio, fecha_fin, sucursal);
    }

    actualizar_grafica_btn.addEventListener('click', actualizar_datos_grafica);

    // Inicializar la gráfica con valores por defecto
    actualizar_datos_grafica();
});
