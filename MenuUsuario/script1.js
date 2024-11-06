// Seleccionar los botones de método de pago
const paymentButtons = document.querySelectorAll('.payment-btn');
const hiddenPaymentInput = document.getElementById('metodoPago');

// Agregar evento de clic a cada botón de pago
paymentButtons.forEach(button => {
    button.addEventListener('click', () => {
        // Remover la clase "selected" de todos los botones
        paymentButtons.forEach(btn => btn.classList.remove('selected'));
        
        // Agregar la clase "selected" al botón clicado
        button.classList.add('selected');
        
        // Actualizar el valor del campo oculto con el método de pago seleccionado
        hiddenPaymentInput.value = button.getAttribute('data-payment');
    });
});

document.addEventListener("DOMContentLoaded", function() {
    const envioForm = document.getElementById("envioForm");

    envioForm.addEventListener("submit", function(event) {
        event.preventDefault(); // Evita el envío del formulario

        // Muestra el mensaje al usuario
        alert("Revisa tu correo electrónico, se han enviado los PDF que incluye guía y recibo de pago");

        // Aquí podrías agregar lógica adicional para enviar el formulario al servidor, si es necesario.
    });
});