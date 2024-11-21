document.addEventListener('DOMContentLoaded', function () {
    const fecha_inicio_input = document.getElementById('fecha_inicio');
    const fecha_fin_input = document.getElementById('fecha_fin');
    const sucursal_select = document.getElementById('sucursal');
    const disciplina_id_select = document.getElementById('disciplina_id');
    const actualizar_grafica_btn = document.getElementById('actualizar_grafica');

    let canvas_grafica = null;

    async function obtener_clases_impartidas_agrupadas_por_instructor(fecha_inicio, fecha_fin, sucursal, disciplina_id) {
        try {
            const response = await fetch(`../reportes/obtener_clases_impartidas_agrupadas_por_instructor?fecha_inicio=${fecha_inicio}&fecha_fin=${fecha_fin}&sucursal=${sucursal}&disciplina_id=${disciplina_id}`);

            if (!response.ok) {
                throw new Error(`Error: ${response.statusText}`);
            }

            const content_type = response.headers.get("content-type");
            if (content_type && content_type.indexOf("application/json") !== -1) {
                const clases = await response.json();

                const labels = clases.map(res => res.email);
                const totalClases = clases.map(res => parseInt(res.total_clases) || 0);
                const totalCupo = clases.map(res => parseInt(res.total_cupo) || 0);
                const totalReservado = clases.map(res => parseInt(res.total_reservado) || 0);
                const porcentajeOcupacion = clases.map(res => res.porcentaje_ocupacion ? parseFloat(res.porcentaje_ocupacion).toFixed(2) : '0.00');
                const promedioReservadoPorClase = clases.map(res => res.promedio_reservado_por_clase ? parseFloat(res.promedio_reservado_por_clase).toFixed(2) : '0.00');
                const promedioCupoPorClase = clases.map(res => res.promedio_cupo_por_clase ? parseFloat(res.promedio_cupo_por_clase).toFixed(2) : '0.00');
                const clasesLlenadas = clases.map(res => parseInt(res.clases_llenadas) || 0);
                const porcentajeClasesLlenadas = clases.map(res => res.porcentaje_clases_llenadas ? parseFloat(res.porcentaje_clases_llenadas).toFixed(2) : '0.00');
                const maxReservado = clases.map(res => parseInt(res.max_reservado) || 0);
                const minReservadoNoCero = clases.map(res => res.min_reservado_no_cero !== null ? parseInt(res.min_reservado_no_cero) : null);

                // Calcular cupos disponibles
                const cuposDisponibles = totalCupo.map((cupo, index) => cupo - totalReservado[index]);

                actualizar_grafica(labels, totalClases, totalCupo, totalReservado, cuposDisponibles, porcentajeOcupacion, promedioReservadoPorClase, promedioCupoPorClase, clasesLlenadas, porcentajeClasesLlenadas, maxReservado, minReservadoNoCero, clases);
            } else {
                const text = await response.text();
                throw new Error(`La respuesta no es JSON: ${text}`);
            }
        } catch (error) {
            console.error('Error obteniendo clases agrupadas:', error);
        }
    }

    function actualizar_grafica(labels, totalClases, totalCupo, totalReservado, cuposDisponibles, porcentajeOcupacion, promedioReservadoPorClase, promedioCupoPorClase, clasesLlenadas, porcentajeClasesLlenadas, maxReservado, minReservadoNoCero, clases) {
        const container = document.querySelector('.chart-container');
        const altura_por_dato = 80;
        const altura_minima = 240; // Altura mínima de la gráfica
        const altura_calculada = altura_por_dato * Math.max(labels.length, 3); // Asegurar al menos 2 datos
        const altura_canvas = Math.max(altura_minima, altura_calculada); // Altura final

        container.style.height = `${altura_canvas}px`;

        const ctx = document.getElementById('canvas_grafica').getContext('2d');

        if (canvas_grafica) {
            canvas_grafica.destroy();
        }

        // Plugin para mostrar el total al final de las barras apiladas correctamente
        const showTotalPlugin = {
            id: 'showTotal',
            afterDatasetsDraw: (chart) => {
                const { ctx } = chart;
                ctx.save();

                const metaReservas = chart.getDatasetMeta(1); // "Total de Reservas"
                const metaCupos = chart.getDatasetMeta(2); // "Cupos Disponibles"

                metaReservas.data.forEach((bar, index) => {
                    const barCupos = metaCupos.data[index];

                    // Coordenadas para posicionar el total
                    const total = totalReservado[index] + cuposDisponibles[index];
                    const x = barCupos.x + 10; // Posición x del último stack
                    const y = barCupos.y; // Ajuste de altura sobre el stack

                    ctx.font = 'bold 12px Arial';
                    ctx.fillStyle = 'black';
                    ctx.fillText(total, x, y);
                });

                ctx.restore();
            }
        };

        canvas_grafica = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Total de Clases',
                        data: totalClases,
                        backgroundColor: 'rgba(75, 192, 192, 0.5)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                        stack: 'Stack 1',
                        datalabels: {
                            anchor: 'end',
                            align: 'left',
                            color: 'black'
                        }
                    },
                    {
                        label: 'Total de Reservas',
                        data: totalReservado,
                        backgroundColor: 'rgba(255, 159, 64, 0.5)',
                        borderColor: 'rgba(255, 159, 64, 1)',
                        borderWidth: 1,
                        stack: 'Stack 0',
                        datalabels: {
                            anchor: 'center',
                            align: 'center',
                            color: 'black'
                        }
                    },
                    {
                        label: 'Cupos Disponibles',
                        data: cuposDisponibles,
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                        stack: 'Stack 0',
                        datalabels: {
                            anchor: 'center',
                            align: 'center',
                            color: 'black'
                        }
                    },
                    {
                        label: 'Porcentaje de Ocupación',
                        data: porcentajeOcupacion,
                        backgroundColor: 'rgba(153, 102, 255, 0.5)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 2,
                        type: 'line',
                        xAxisID: 'xPorcentajeOcupacion',
                        fill: false,
                        tension: 0.1,
                        datalabels: {
                            anchor: 'start',
                            align: 'right',
                            color: 'black',
                            formatter: function (value) {
                                return value + '%';
                            }
                        }
                    }
                ]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    xCantidad: {
                        type: 'linear',
                        position: 'bottom',
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Cantidad'
                        },
                        stacked: true
                    },
                    xPorcentajeOcupacion: {
                        type: 'linear',
                        position: 'top',
                        beginAtZero: true,
                        min: 0,
                        max: 100,
                        ticks: {
                            callback: function (value) {
                                return value + '%';
                            }
                        },
                        grid: {
                            drawOnChartArea: false
                        },
                        title: {
                            display: true,
                            text: 'Porcentaje de Ocupación (%)'
                        }
                    },
                    y: {
                        stacked: true
                    }
                },
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.x !== null) {
                                    label += context.parsed.x;
                                    if (label.includes('Cupos Disponibles')) {
                                        label += ` (de ${totalCupo[context.dataIndex]})`;
                                    }
                                }
                                return label;
                            },
                            afterBody: function (context) {
                                const index = context[0].dataIndex;
                                const clase = clases[index];

                                // Título y salto de línea al principio
                                const datosAdicionales = [
                                    'Datos y Porcentajes:',
                                    `Prom. Reservado/Clase: ${parseFloat(clase.promedio_reservado_por_clase).toFixed(2)}`,
                                    `Prom. Cupo/Clase: ${parseFloat(clase.promedio_cupo_por_clase).toFixed(2)}`,
                                    `Clases Llenas: ${clase.clases_llenadas}`,
                                    `Porc. Clases Llenas: ${parseFloat(clase.porcentaje_clases_llenadas).toFixed(2)}%`,
                                    `Máx. Reservado: ${clase.max_reservado}`,
                                    `Mín. Reservado (>0): ${clase.min_reservado_no_cero !== null ? clase.min_reservado_no_cero : 'N/A'}`,
                                    `Total de Clases: ${clase.total_clases}`,
                                    `Total Cupo: ${clase.total_cupo}`,
                                    `Total Reservado: ${clase.total_reservado}`,
                                    `Porcentaje de Ocupación: ${parseFloat(clase.porcentaje_ocupacion).toFixed(2)}%`,
                                    `Disciplina: ${clase.disciplina || 'N/A'}`,
                                    `Sucursal: ${clase.sucursal || 'N/A'}`
                                ];

                                return datosAdicionales.map((dato) => dato);
                            }
                        }
                    },
                    datalabels: {
                        formatter: function (value, context) {
                            if (context.dataset.type === 'line') {
                                return value + '%';
                            } else {
                                return value;
                            }
                        },
                        font: {
                            weight: 'bold'
                        },
                        color: 'black'
                    }
                },
                onClick: function (event, elements) {
                    if (elements.length > 0) {
                        const element_index = elements[0].index;
                        const usuario_id = clases[element_index].id;
                        window.location.href = `../instructores/editar/${usuario_id}`;
                    }
                }
            },
            plugins: [ChartDataLabels, showTotalPlugin]
        });
    }

    function actualizar_datos_grafica() {
        const fecha_inicio = fecha_inicio_input.value;
        const fecha_fin = fecha_fin_input.value;
        const sucursal = sucursal_select.value;
        const disciplina_id = disciplina_id_select.value;
        obtener_clases_impartidas_agrupadas_por_instructor(fecha_inicio, fecha_fin, sucursal, disciplina_id);
    }

    actualizar_grafica_btn.addEventListener('click', actualizar_datos_grafica);

    // Inicializar la gráfica con valores por defecto
    actualizar_datos_grafica();
});
