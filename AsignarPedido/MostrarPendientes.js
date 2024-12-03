// Variable para almacenar el ID del pedido seleccionado
let pedidoSeleccionado = null;

// Realizar una solicitud para obtener los usuarios desde el servidor
fetch('MostrarPendientes.php', { method: 'POST' })  // Realizar una solicitud POST a 'MostrarUsuarios.php'
.then(response => response.json())  // Convierte la respuesta en formato JSON
.then(data => {
    console.log(data); // Muestra los datos obtenidos en la consola para depuración

    // Obtener el contenedor donde se insertarán los usuarios en la tabla
    const contenedor = document.getElementById('asignarTableBody');
    const botonAsignar = document.getElementById('Asignar'); // Obtener el botón aquí

    // Deshabilitar el botón inicialmente
    botonAsignar.disabled = true;

    // Verificar que 'data' es un array y contiene usuarios
    if (Array.isArray(data) && data.length > 0) {
        // Recorrer los usuarios y crear una fila en la tabla por cada uno
        data.forEach(asignar => {
            const row = document.createElement('tr');
            
            // Crear celdas para los datos de cada usuario
            const cellID = document.createElement('td');
            cellID.textContent = asignar.ID;

            const cellNombreUsuario = document.createElement('td');
            cellNombreUsuario.textContent = asignar.NombreUsuario;

            const cellDestinatario = document.createElement('td');
            cellDestinatario.textContent = asignar.Destinatario;

            const cellDescripcion = document.createElement('td');
            cellDescripcion.textContent = asignar.Descripcion;

            // Añadir las celdas a la fila
            row.appendChild(cellID);
            row.appendChild(cellNombreUsuario);
            row.appendChild(cellDestinatario);
            row.appendChild(cellDescripcion);

            // Agregar evento para seleccionar la fila
            row.addEventListener('click', () => {
                // Quitar la clase de selección de cualquier fila previamente seleccionada
                document.querySelectorAll('tr').forEach(tr => tr.classList.remove('table-primary'));

                // Resaltar la fila seleccionada
                row.classList.add('table-primary');

                // Guardar el ID del pedido seleccionado
                pedidoSeleccionado = asignar.ID;
                console.log("Pedido seleccionado:", pedidoSeleccionado);

                // Habilitar el botón
                botonAsignar.disabled = false;
            });

            // Añadir la fila a la tabla
            contenedor.appendChild(row);
        });
    } else {
        console.log("No hay pedidos por asignar.");
        // Si no hay usuarios, mostrar un mensaje en la tabla
        const row = document.createElement('tr');
        const cell = document.createElement('td');
        cell.colSpan = 4;
        cell.textContent = "No has realizado ningun envio.";
        row.appendChild(cell);
        contenedor.appendChild(row);
    }
})
.catch(error => console.error('Error al obtener los usuarios:', error)); // Manejo de errores si la solicitud falla

// Función para manejar el botón "Ver Estado"
document.addEventListener('DOMContentLoaded', () => {
    const botonAsignar = document.getElementById('Asignar'); // Obtener el botón aquí

    botonAsignar.addEventListener('click', () => {
        if (pedidoSeleccionado) {
            // Almacenar el ID del pedido en una cookie
            document.cookie = `pedidoSeleccionado=${pedidoSeleccionado}; path=/`;

            // Redirigir a la nueva página
            window.location.href = 'SeleccionRepartidor.html';
        } else {
            alert("Por favor, selecciona un pedido primero.");
        }
    });
});
