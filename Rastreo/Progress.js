document.addEventListener('DOMContentLoaded', () => {
    // Obtener el ID del pedido de la URL
    const urlParams = new URLSearchParams(window.location.search);
    const pedidoID = urlParams.get('id');

    // Obtener la barra de progreso y los pasos
    const progressBar = document.getElementById('progressBar');
    const progressSteps = document.querySelectorAll('.progress-step');

    // Realizar una solicitud al backend para obtener el estado actual del pedido
    fetch('getPedidoEstado.php', {
        method: 'POST',
        body: JSON.stringify({ id: pedidoID }),
        headers: {
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        // Asumimos que el estado actual viene como 'proceso', 'enviado', 'transito', o 'entregado'
        const estadoActual = data.EstadoActual;

        // Determinar el progreso y actualizar la barra de progreso
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
            default:
                progressPercentage = 0;
                activeStepIndex = 0;
                break;
        }

        // Actualizar la barra de progreso
        progressBar.style.width = progressPercentage + '%';
        progressBar.setAttribute('aria-valuenow', progressPercentage);

        // Actualizar los pasos de progreso
        progressSteps.forEach((step, index) => {
            if (index <= activeStepIndex) {
                step.classList.add('active');
            } else {
                step.classList.remove('active');
            }
        });
    })
    .catch(error => console.error('Error al obtener el estado del pedido:', error));
});
