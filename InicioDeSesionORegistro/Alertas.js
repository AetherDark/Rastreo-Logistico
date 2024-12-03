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

// Función para mostrar la alerta de error de autenticacion
function mostrarAlertaAuto() {
    alert('Error en la autenticacion. Contacta al administrador');
}

// Función para mostrar la alerta de correco no registrado
function mostrarAlertaNoRegistrado() {
    alert('Usuario no registrado');
}


// Función para mostrar la alerta de cambio de contraseña
function mostrarAlertaErrorAuto() {
    alert('Error en la autenticacion. Contacta al administrador');
}

// Función para mostrar la alerta de inactividad
function mostrarAlertaInactividad() {
    alert('Sesión expirada por inactividad');
}
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
// Verificar si existe el parámetro 'token' en la URL para mostrar la alerta
else if (urlParams.has('Auto')) {
    mostrarAlertaAuto(); // Llamar a la función de alerta
}
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
// Verificar si existe el parámetro 'ErrorAuto' en la URL para mostrar la alerta
else if (urlParams.has('ErrorAuto')) {
    mostrarAlertaErrorAuto(); // Llamar a la función de alerta
}
// Alerta de expiracion de sesion
else if (urlParams.has('inactividad')) {
    mostrarAlertaInactividad(); // Llamar a la función de alerta
}
/* Verificar si existe el parámetro 'Error-Cambio-Pass' en la URL para mostrar la alerta
else if (urlParams.has('Error-Cambio-Pass')) {
    mostrarAlertaErrorCambioPass(); // Llamar a la función de alerta
}*/
/* Verificar si existe el parámetro 'Error-Token' en la URL para mostrar la alerta
else if (urlParams.has('Error-Token')) {
    mostrarAlertaErrorToken(); // Llamar a la función de alerta
}*/