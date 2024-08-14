(async () => {
    get_reservaciones_numero_del_mes();
})();

async function get_reservaciones_numero_del_mes() {

    // Llamar a la API con la función Fetch que es nativa de JavaScript.
    const get_respuesta = await fetch("../reportes/grafica_numero_de_reservaciones_por_mes");
    // Hacer la decodificación del paquete JSON y vaciamos el contenido en la constante de “respuesta”
    const respuesta = await get_respuesta.json();

    // Ahora hay que cargar la referencia al canvas del DOM en la constante grafica
    const grafica = document.querySelector("#chart-reservaciones");

    // Se llena la hoja de datos de la gráfica con un drop de las variables y la otras configuraciones
    const grafica_datos = {
        // Aquí se vacía el array de las etiquetas
        labels: respuesta.etiquetas,
        datasets: [{
            label: "Número de reservaciones mensuales",
            // Aquí se vacía el array de los datos
            data: respuesta.datos,
            // Color de fondo
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            // Color del borde
            hoverBackgroundColor: "rgba(54, 162, 235, 0.5)",
            // Color del borde
            borderColor: 'rgba(54, 162, 235, 1)',
            // Ancho del borde
            borderWidth: 1
        }]
    };

    // Se llena la hoja de opciones y estilos de la gráfica 
    const grafica_opciones = {
        indexAxis: 'y',
        // Las opciones de los elementos se aplican a todas las opciones a menos que se anulen en un conjunto de datos
        elements: {
            rectangle: {
                borderWidth: 2,
                borderColor: 'rgb(0, 255, 0)',
                borderSkipped: 'left'
            }
        },
        responsive: true,
        maintainAspectRatio: true,
        responsiveAnimationDuration: 500,
        scales: {
            xAxes: [{
                display: true,
                gridLines: {
                    color: "#f3f3f3",
                    drawTicks: true,
                },
                scaleLabel: {
                    display: true,
                }
            }],
            yAxes: [{
                display: true,
                gridLines: {
                    color: "#f3f3f3",
                    drawTicks: true,
                },
                scaleLabel: {
                    display: true,
                },
                ticks: {
                    beginAtZero: true
                }
            }]
        },
        legend: {
            position: 'end',
        },
        // Un plugin que le permite agregar etiquetas a los gráfico.
        plugins: {
            datalabels: {
                anchor: 'end',
                align: 'end',
                formatter: Math.round,
                font: {
                    weight: 'bold',
                    size: 12
                }
            },
            title: {
                display: true,
                text: 'Reservaciones por mes'
            }
        }
    };

    // Se crea el objeto Chart y se llama a las propiedades.
    const config = {
        type: 'bar',

        // Se crea un segundo registro para el plugin que da de alta únicamente esta gráfica.
        plugins: [ChartDataLabels],

        // Chart Options
        options: grafica_opciones,

        data: grafica_datos
    };

    // Se crea un primer registro para el plugin que da de alta únicamente esta gráfica.
    Chart.register(ChartDataLabels);

    // Se crea la gráfica
    var lineChart = new Chart(grafica, config);
}

// document.addEventListener('DOMContentLoaded', function () {
//     const actualizar_grafica_btn = document.getElementById('actualizar_grafica');

//     let canvas_grafica = null; // Inicializar canvas_grafica como null

//     async function obtener_reservaciones_agrupadas_por_usuario() {
//         try {
//             const response = await fetch("../reportes/grafica_numero_de_reservaciones_por_mes");

//             if (!response.ok) {
//                 throw new Error(`Error: ${response.statusText}`);
//             }

//             const content_type = response.headers.get("content-type");
//             if (content_type && content_type.indexOf("application/json") !== -1) {
//                 const reservaciones = await response.json();
//                 // const labels = reservaciones.map(res => res.email);
//                 const datos = reservaciones.map(res => res.total_reservaciones);

//                 actualizar_grafica(labels, datos, reservaciones);
//             } else {
//                 const text = await response.text();
//                 throw new Error(`La respuesta no es JSON: ${text}`);
//             }
//         } catch (error) {
//             console.error('Error obteniendo reservaciones agrupadas:', error);
//         }
//     }

//     function actualizar_grafica(labels, datos, reservaciones) {
//         const container = document.querySelector('.chart-container');
//         const altura_por_dato = 25; // Ajusta este valor según sea necesario
//         const altura_canvas = altura_por_dato * labels.length;

//         container.style.height = `${altura_canvas}px`;

//         const ctx = document.getElementById('canvas_grafica').getContext('2d');

//         if (canvas_grafica) {
//             canvas_grafica.destroy(); // Destruir la gráfica anterior si existe
//         }

//         canvas_grafica = new Chart(ctx, {
//             type: 'bar',
//             data: {
//                 labels: labels,
//                 datasets: [{
//                     label: 'Total de Reservaciones',
//                     data: datos,
//                     backgroundColor: 'rgba(0, 248, 254, 0.2)',
//                     borderColor: 'rgba(0, 248, 254, 1)',
//                     borderWidth: 1
//                 }]
//             },
//             options: {
//                 responsive: true,
//                 maintainAspectRatio: false,
//                 indexAxis: 'y',
//                 plugins: {
//                     datalabels: {
//                         anchor: 'start',
//                         align: 'end',
//                         color: 'black',
//                         font: {
//                             weight: 'bold'
//                         },
//                         formatter: (value) => value
//                     }
//                 },
//                 scales: {
//                     y: {
//                         beginAtZero: true
//                     },
//                     x: {
//                         ticks: {
//                             autoSkip: false,
//                             maxRotation: 90,
//                             minRotation: 0
//                         }
//                     }
//                 },
//                 onClick: function (event, elements) {
//                     if (elements.length > 0) {
//                         const element_index = elements[0].index;
//                         const usuario_id = reservaciones[element_index].id; // Asegúrate de que el usuario_id esté disponible
//                         window.location.href = `../clientes/editar/${usuario_id}`;
//                     }
//                 }
//             },
//             plugins: [ChartDataLabels]
//         });
//     }

//     function actualizar_datos_grafica() {
//         obtener_reservaciones_agrupadas_por_usuario();
//     }

//     actualizar_grafica_btn.addEventListener('click', actualizar_datos_grafica);

//     // Inicializar la gráfica con valores por defecto
//     actualizar_datos_grafica();
// });
