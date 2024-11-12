// Funcion para eliminar usuario
function deleteUser() {
    const userID = document.getElementById('userID').value;
    
    if (!userID) {
        alert("Por favor, ingresa un ID de usuario para eliminar.");
        return;
    }

    // Enviar la solicitud al PHP para eliminar el usuario
    fetch('eliminarUsuario.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ userID: userID })
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message); // Muestra el mensaje devuelto por PHP
        if (data.success) {
            location.reload(); // Recargar la página si la eliminación fue exitosa
        }
    })
    .catch(error => console.error('Error al eliminar el usuario:', error));
}
