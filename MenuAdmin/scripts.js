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


// Alertas de usuarios
// Función para mostrar la usuario o contraseña no encontrado
function mostrarAlertaError() {
    alert('El correo o usuario ya existe');
}

// Función para mostrar la alerta de rol no válido
function mostrarRolNOValido() {
    alert('El correo ya existe');
}

// Función para mostrar la alerta de usuario registrado correctamente
function mostrarAlertaExito() {
    alert('Usuario registrado correctamente');
}

// Funcion para mostrar la alerta de error al registrar usuario
function mostrarAlertaErrorRegistro() {
    alert('Hubo un error al registrar el usuario.');
}

// Verificar si existe el parámetro 'error' en la URL para mostrar la alerta
const urlParams = new URLSearchParams(window.location.search);
if (urlParams.has('existente')) {
    mostrarAlertaError(); // Llamar a la función de alerta
}
// Verificar si existe el parametro 'RolNOValido' en la URL para mostrar la alerta
else if (urlParams.has('RolNOValido')) {
    mostrarRolNOValido(); // Llamar a la función de alerta
}
// Verificar si existe el parametro 'exito' en la URL para mostrar la alerta
else if (urlParams.has('RegistroExitoso')) {
    mostrarAlertaExito(); // Llamar a la función
}
// Verificar si existe el parametro 'errorRegistro' en la URL para mostrar la alerta
else if (urlParams.has('errorRegistro')) {
    mostrarAlertaErrorRegistro(); // Llamar a la función
}