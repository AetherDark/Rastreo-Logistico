// Función para mostrar la usuario o contraseña no encontrado
function mostrarAlertaError() {
    alert('El correo o el usuario ya se encuentra registrado');
}

function mostrarAlertaSuspension() {
    alert('Usuario suspendido. Contacta al administrador');
}

// Función para mostrar la alerta de error de cuenta
function mostrarAlertaErrorCuenta() {
    alert('Error de cuenta. Contacta al administrador');
}
// Función para mostrar la alerta de usuario registrado
function mostrarAlertaRegistro() {
    alert('Usuario registrado correctamente');
}

/* Función para mostrar la alerta de token enviado
function mostrarAlertaToken() {
    alert('Token enviado a tu correo electrónico');
}
*/

// Función para mostrar la alerta de correco no registrado
function mostrarAlertaNoRegistrado() {
    alert('Usuario no registrado');
}


/* Función para mostrar la alerta de cambio de contraseña
function mostrarAlertaCambioPass() {
    alert('Contraseña cambiada correctamente');
}
*/

/* Función para mostrar la alerta de error de cambio de contraseña
function mostrarAlertaErrorCambioPass() {
    alert('Error al cambiar la contraseña');
}
*/

/* Funcion para mostrar el error de envio de token
function mostrarAlertaErrorToken() {
    alert('Error al enviar el token');
}
*/

// Verificar si existe el parámetro 'error' en la URL para mostrar la alerta
const urlParams = new URLSearchParams(window.location.search);
if (urlParams.has('error')) {
    mostrarAlertaError(); // Llamar a la función de alerta
}
// Verificar si existe el parámetro 'registro' en la URL para mostrar la alerta
else if (urlParams.has('registro')) {
    mostrarAlertaRegistro(); // Llamar a la función de alerta
}
/* Verificar si existe el parámetro 'token' en la URL para mostrar la alerta
else if (urlParams.has('token')) {
    mostrarAlertaToken(); // Llamar a la función de alerta
}*/
// Verificar si existe el parámetro 'no-registrado' en la URL para mostrar la alerta
else if (urlParams.has('no-registrado')) {
    mostrarAlertaNoRegistrado(); // Llamar a la función de alerta
}
// Verificar si existe el parámetro 'Suspendido' en la URL para mostrar la alerta
else if (urlParams.has('Suspendido')) {
    mostrarAlertaSuspension(); // Llamar a la función de alerta
}
// Verificar si existe el parámetro 'ErrorCuenta' en la URL para mostrar la alerta
else if (urlParams.has('ErrorCuenta')) {
    mostrarAlertaErrorCuenta(); // Llamar a la función de alerta
}
/* Verificar si existe el parámetro 'Cambio-Pass' en la URL para mostrar la alerta
else if (urlParams.has('Cambio-Pass')) {
    mostrarAlertaCambioPass(); // Llamar a la función de alerta
}*/
/* Verificar si existe el parámetro 'Error-Cambio-Pass' en la URL para mostrar la alerta
else if (urlParams.has('Error-Cambio-Pass')) {
    mostrarAlertaErrorCambioPass(); // Llamar a la función de alerta
}*/
/* Verificar si existe el parámetro 'Error-Token' en la URL para mostrar la alerta
else if (urlParams.has('Error-Token')) {
    mostrarAlertaErrorToken(); // Llamar a la función de alerta
}*/