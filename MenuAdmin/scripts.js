// Función para mostrar la usuario o contraseña no encontrado
function mostrarAlertaError() {
    alert('Correo o contraseña incorrectos');
}

// Verificar si existe el parámetro 'error' en la URL para mostrar la alerta
const urlParams = new URLSearchParams(window.location.search);
if (urlParams.has('error')) {
    mostrarAlertaError(); // Llamar a la función de alerta
}