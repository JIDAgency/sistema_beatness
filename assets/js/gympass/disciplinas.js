document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('select').forEach(function (select) {
        select.setAttribute('data-previous', select.value);
    });
});

function actualizar_disciplina(disciplina_id, gympass_product_id) {
    let select = document.getElementById('select-' + disciplina_id);
    let valor_anterior = select.getAttribute('data-previous');

    if (gympass_product_id === valor_anterior) {
        alert('No se realizaron cambios en el ID de Gympass.');
        return;
    }

    fetch('../gympass/actualizar_disciplina', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${encodeURIComponent(disciplina_id)}&gympass_product_id=${encodeURIComponent(gympass_product_id)}`
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert('ID de Gympass actualizado correctamente.');
                select.setAttribute('data-previous', gympass_product_id);
            } else {
                throw new Error(data.message);
            }
        })
        .catch(error => {
            alert('Error al actualizar ID de Gympass: ' + error.message);
            select.value = valor_anterior;
        });
}
