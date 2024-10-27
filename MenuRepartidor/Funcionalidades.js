// Control de la acción al enviar el formulario de actualización de pedidos
document.getElementById('updateForm')?.addEventListener('submit', function(event) {
    event.preventDefault();
    alert('Estado actualizado con éxito');
});

// Control para mostrar el nombre del repartidor en la interfaz
document.getElementById('nombreRepartidor').innerText = 'Juan Pérez'; // Cambia esto dinámicamente según el usuario
