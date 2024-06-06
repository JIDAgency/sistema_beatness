function actualizar(id) {
    if (!id) {
        alert('No se recibió ningún ID de Categoría.');
        return;
    }

    fetch('../gympass/actualizar_categoria', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${encodeURIComponent(id)}`
    })
        .then(response => {
            // Imprime la respuesta completa
            return response.text().then(text => {
                console.log(text); // Muestra la respuesta en la consola
                try {
                    return JSON.parse(text);
                } catch (error) {
                    throw new Error('Respuesta no es JSON: ' + text);
                }
            });
        })
        .then(data => {
            if (data.status === 'success') {
                alert('Categoría de Gympass actualizada correctamente.');
                location.reload(true);
            } else {
                throw new Error(data.message);
            }
        })
        .catch(error => {
            alert('Error al actualizar Categoría de Gympass: ' + error.message);
        });
}


function registrar(id) {
    if (!id) {
        alert('No se recibió ningún ID de Categoría.');
        return;
    }

    fetch('../gympass/registrar_categoria', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${encodeURIComponent(id)}`
    })
        .then(response => {
            // Imprime la respuesta completa
            return response.text().then(text => {
                console.log(text); // Muestra la respuesta en la consola
                try {
                    return JSON.parse(text);
                } catch (error) {
                    throw new Error('Respuesta no es JSON: ' + text);
                }
            });
        })
        .then(data => {
            if (data.status === 'success') {
                alert('Categoría de Gympass registrada correctamente.');
                location.reload(true);
            } else {
                throw new Error(data.message);
            }
        })
        .catch(error => {
            alert('Error al registrar Categoría de Gympass: ' + error.message);
        });
}
