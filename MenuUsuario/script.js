// Script para el botón de rastreo
document.getElementById('startTracking').addEventListener('click', function() {
    const trackingNumber = document.getElementById('trackingNumber').value;
    if (trackingNumber) {
        alert(`Iniciando rastreo para el número de guía: ${trackingNumber}`);
        // Añadir lógica de rastreo aquí
    } else {
        alert('Por favor, ingrese un número de guía.');
    }
});
