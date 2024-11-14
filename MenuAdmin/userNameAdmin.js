document.addEventListener("DOMContentLoaded", function() {
    fetch('getUserNameAdmin.php')
        .then(response => response.json())
        .then(data => {
            console.log("Respuesta del servidor:", data); // Verifica la respuesta en la consola
            const userNameDisplay = document.getElementById("user-name-display");
            userNameDisplay.textContent = data.nombreUsuario;
        })
        .catch(error => console.error('Error al obtener el nombre del usuario:', error));
});
