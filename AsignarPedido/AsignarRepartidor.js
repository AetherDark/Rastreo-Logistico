// Función para obtener el valor de una cookie por su nombre
function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
}

const pedidoID = getCookie('pedidoSeleccionado'); // Obtener el ID del pedido desde la cookie
console.log("Pedido seleccionado desde la cookie:", pedidoID);

// Variable para almacenar el ID del repartidor seleccionado
let repartidorSeleccionado = null;

// Obtener la tabla y el botón
const tablaRepartidores = document.getElementById('repartidorTableBody');
const botonAsignarRepartidor = document.getElementById('AsignarRepartidor');

// Deshabilitar el botón inicialmente
botonAsignarRepartidor.disabled = true;

// Simular carga de repartidores (puedes reemplazar esto con una solicitud fetch)
fetch('MostrarRepartidores.php') // Reemplaza con tu endpoint PHP para listar repartidores
    .then(response => response.json())
    .then(data => {
        if (Array.isArray(data) && data.length > 0) {
            data.forEach(repartidor => {
                const row = document.createElement('tr');

                const cellID = document.createElement('td');
                cellID.textContent = repartidor.ID;

                const cellNombreUsuario = document.createElement('td');
                cellNombreUsuario.textContent = repartidor.NombreUsuario;

                const cellEmail = document.createElement('td');
                cellEmail.textContent = repartidor.Email;

                const cellEstadoCuenta = document.createElement('td');
                cellEstadoCuenta.textContent = repartidor.EstadoCuenta;

                row.appendChild(cellID);
                row.appendChild(cellNombreUsuario);
                row.appendChild(cellEmail);
                row.appendChild(cellEstadoCuenta);

                row.addEventListener('click', () => {
                    // Resaltar fila seleccionada
                    document.querySelectorAll('tr').forEach(tr => tr.classList.remove('table-primary'));
                    row.classList.add('table-primary');

                    // Guardar el ID del repartidor seleccionado
                    repartidorSeleccionado = repartidor.ID;
                    console.log("Repartidor seleccionado:", repartidorSeleccionado);

                    // Habilitar el botón
                    botonAsignarRepartidor.disabled = false;
                });

                tablaRepartidores.appendChild(row);
            });
        } else {
            const row = document.createElement('tr');
            const cell = document.createElement('td');
            cell.colSpan = 4;
            cell.textContent = "No hay repartidores disponibles.";
            row.appendChild(cell);
            tablaRepartidores.appendChild(row);
        }
    });

// Asignar el pedido al repartidor
botonAsignarRepartidor.addEventListener('click', () => {
    if (pedidoID && repartidorSeleccionado) {
        fetch('AsignarRepartidor.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ pedidoID, repartidorID: repartidorSeleccionado })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Pedido asignado correctamente.');
                    window.location.href = 'AsignarPedido.html';
                } else {
                    alert('Error al asignar el pedido.');
                }
            })
            .catch(error => console.error('Error al asignar el pedido:', error));
    } else {
        alert("Por favor, selecciona un pedido y un repartidor.");
    }
});