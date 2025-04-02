<h2>Reporte en Vivo: Reservaciones por Disciplina y Origen</h2>
<div>
    <label for="fecha_inicio">Fecha Inicio:</label>
    <input type="date" id="fecha_inicio" name="fecha_inicio" value="<?= date('Y-m-01') ?>">

    <label for="fecha_fin">Fecha Fin:</label>
    <input type="date" id="fecha_fin" name="fecha_fin" value="<?= date('Y-m-t') ?>">
</div>

<!-- Loader -->
<div id="loader">Cargando datos...</div>

<br>
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Disciplina</th>
            <th>Origen</th>
            <th>Total Reservaciones</th>
        </tr>
    </thead>
    <tbody id="reportTableBody">
        <!-- Los datos se cargarán aquí dinámicamente -->
    </tbody>
</table>

<script>
    async function fetchLiveReport() {
        // Mostrar el loader
        document.getElementById('loader').style.display = 'block';

        const fechaInicio = document.getElementById('fecha_inicio').value;
        const fechaFin = document.getElementById('fecha_fin').value;

        try {
            const response = await fetch("<?= base_url('reportes/obtener_reservaciones_disciplina_origen_live') ?>?fecha_inicio=" + encodeURIComponent(fechaInicio) + "&fecha_fin=" + encodeURIComponent(fechaFin));
            const data = await response.json();

            const tbody = document.getElementById('reportTableBody');
            tbody.innerHTML = ''; // Limpiar contenido previo

            if (data && data.length > 0) {
                data.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                            <td>${item.disciplina}</td>
                            <td>${item.origen}</td>
                            <td>${item.total_reservaciones}</td>
                        `;
                    tbody.appendChild(row);
                });
            } else {
                const row = document.createElement('tr');
                row.innerHTML = '<td colspan="3">No se encontraron datos para el rango seleccionado.</td>';
                tbody.appendChild(row);
            }
        } catch (error) {
            console.error('Error al obtener el reporte en vivo:', error);
        } finally {
            // Ocultar el loader
            document.getElementById('loader').style.display = 'none';
        }
    }

    // Actualizar la tabla al cambiar las fechas
    document.getElementById('fecha_inicio').addEventListener('change', fetchLiveReport);
    document.getElementById('fecha_fin').addEventListener('change', fetchLiveReport);

    // Cargar la tabla al iniciar la página
    document.addEventListener('DOMContentLoaded', fetchLiveReport);
</script>