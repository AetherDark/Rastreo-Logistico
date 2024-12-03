// Alerta de paquete enviado
function mostrarAlertaPaquete() {
    alert('Se ha enviado correctamente el paquete');
}

// Alerta de error al enviar el paquete
function mostrarAlertaErrorPaquete() {
    alert('Error al enviar el paquete');
}

// Alerta de autenticación incorrecta
function mostrarAlertaErrorAuto() {
    alert('Error en las credenciales. Por favor, intente mas tarde.');
}

// Alerta de envio exitoso
function mostrarAlertaEnviado() {
    alert('Se ha enviado correctamente el paquete');
}

// Alerta de envio fallido
function mostrarAlertaNoEnviado() {
    alert('Error al enviar el paquete. Por favor, intente mas tarde');
}

// Alerta de rastreo exitoso
function mostrarAlertaRastreo() {
    alert('El paquete ha sido añadido correctamente');
}

// Alerta de rastreo fallido
 function mostrarAlertaErrorRastreo() {
    alert('Error al añadir el paquete. Por favor, intente mas tarde.');
}

// Verificar si existe el parametro en la url de Enviado
const urlParams = new URLSearchParams(window.location.search);
if (urlParams.has('Enviado')) {
    mostrarAlertaPaquete(); // Llamar a la función de alerta
}
// Verificar si existe el parametro en la url de NoEnviado
else if (urlParams.has('NoEnviado')) {
    mostrarAlertaErrorPaquete()
}
// Alerta de autenticación incorrecta
else if (urlParams.has('Auto')) {
    mostrarAlertaErrorAuto()
}
// Alerta de envio exitoso
else if (urlParams.has('Enviado')) {
    mostrarAlertaEnviado()
}
// Alerta de erro de envio
else if (urlParams.has('NoEnviado')) {
    mostrarAlertaEnviado()
}
// Alerta de rastreo exitoso
else if (urlParams.has('Rastreo')) {
    mostrarAlertaRastreo()
}
 // Alerta de rastreo fallido
else if (urlParams.has('ErrorRastreo')) {
    mostrarAlertaErrorRastreo();
}