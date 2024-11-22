// Alerta de paquete enviado
function mostrarAlertaPaquete() {
    alert('Se ha enviado correctamente el paquete');
}

// Alerta de error al enviar el paquete
function mostrarAlertaErrorPaquete() {
    alert('Error al enviar el paquete');
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