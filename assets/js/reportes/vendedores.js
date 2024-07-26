(async () => {
    get_ventas_por_vendedor_numero_del_mes();
})();

async function get_ventas_por_vendedor_numero_del_mes() {

    // Llamar a la API con la función Fetch que es nativa de JavaScript.
    const get_respuesta = await fetch("../reportes/grafica_numero_de_ventas_por_vendedor_por_mes");
    // Hacer la decodificación del paquete JSON y vaciamos el contenido en la constante de “respuesta”
    const respuesta = await get_respuesta.json();

    // Ahora hay que cargar la referencia al canvas del DOM en la constante grafica
    const grafica = document.querySelector("#chart-vendedor");

    // Se llena la hoja de datos de la gráfica con un drop de las variables y la otras configuraciones
    const grafica_datos = {
        // Aquí se vacía el array de las etiquetas
        labels: respuesta.etiquetas,
        datasets: [{
            label: "Número de ventas por vendedor mensual",
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
                text: 'Ventas de vendedor por mes'
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