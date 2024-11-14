function updateUserState() {
    const userID = document.getElementById('userID').value;
    const estado = document.getElementById('estado').value;

    if (!userID || !estado) {
        alert("Por favor, ingrese el ID del usuario y seleccione un estado.");
        return;
    }

    // Realizar una solicitud POST al servidor para actualizar el estado
    fetch('ActualizarEstadoUsuario.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ userID: userID, estado: estado })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("El estado del usuario se ha actualizado correctamente.");
            location.reload();  // Recargar la página para reflejar los cambios
        } else {
            alert("Error al actualizar el estado del usuario.");
        }
    })
    .catch(error => console.error('Error:', error));
}
