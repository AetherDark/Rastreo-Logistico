document.addEventListener('DOMContentLoaded', () => {
    // Obtener el código de rastreo desde la cookie
    const trackingCode = getCookie("trackingCode");

    if (trackingCode) {
        // Realizar una solicitud al backend para obtener el estado del pedido
        fetch('getPedidoAnonimo.php', {
            method: 'POST',
            body: JSON.stringify({ id: trackingCode }), // Enviar el código de rastreo como un parámetro JSON
            headers: {
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            const estadoActual = data.EstadoActual;

            // Lógica para determinar el progreso de la barra
            let progressPercentage = 0;
            let activeStepIndex = 0;

            switch (estadoActual) {
                case 'Paquete en proceso':
                    progressPercentage = 25;
                    activeStepIndex = 0;
                    break;
                case 'Paquete enviado':
                    progressPercentage = 50;
                    activeStepIndex = 1;
                    break;
                case 'En tránsito':
                    progressPercentage = 75;
                    activeStepIndex = 2;
                    break;
                case 'Entregado':
                    progressPercentage = 100;
                    activeStepIndex = 3;
                    break;
                    case 'Cancelado':
                    case 'Extraviado':
                        // Cambiar el color de la barra a rojo
                        progressBar.style.backgroundColor = 'red';
                        progressBar.style.width = '100%';
                        progressBar.setAttribute('aria-valuenow', 100);
            
                        // Mostrar alerta al usuario
                        alert(`Su paquete fue ${estadoActual.toLowerCase()}. Por favor, contacte a soporte.`);
                        return; // No continuar actualizando los pasos
                default:
                    progressPercentage = 25;
                    activeStepIndex = 25;
                    break;
            }

            // Actualizar la barra de progreso
            const progressBar = document.getElementById('progressBar');
            progressBar.style.width = progressPercentage + '%';
            progressBar.setAttribute('aria-valuenow', progressPercentage);

            // Actualizar los pasos de progreso
            const progressSteps = document.querySelectorAll('.progress-step');
            progressSteps.forEach((step, index) => {
                if (index <= activeStepIndex) {
                    step.classList.add('active');
                } else {
                    step.classList.remove('active');
                }
            });
        })
        .catch(error => console.error('Error al obtener el estado del pedido:', error));
    } else {
        alert('No se ha encontrado ningun pedido con ese codigo.');
    }
});

// Función para obtener el valor de una cookie
function getCookie(name) {
    const nameEQ = name + "=";
    const ca = document.cookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) === ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}