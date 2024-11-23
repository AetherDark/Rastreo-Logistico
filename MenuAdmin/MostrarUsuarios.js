// Realizar una solicitud para obtener los usuarios desde el servidor
fetch('MostrarUsuarios.php')
.then(response => response.json())  // Convierte la respuesta en formato JSON
.then(data => {
    console.log(data); // Muestra los datos obtenidos en la consola para depuración

    // Obtener el contenedor donde se insertarán los usuarios en la tabla
    const contenedor = document.getElementById('userTableBody');

    // Verificar que 'data' es un array y contiene usuarios
    if (Array.isArray(data) && data.length > 0) {
        // Recorrer los usuarios y crear una fila en la tabla por cada uno
        data.forEach(user => {
            const row = document.createElement('tr');
            
            // Crear celdas para los datos de cada usuario
            const cellID = document.createElement('td');
            cellID.textContent = user.ID;

            const cellName = document.createElement('td');
            cellName.textContent = user.NombreUsuario;

            const cellEmail = document.createElement('td');
            cellEmail.textContent = user.Email;

            const cellRole = document.createElement('td');
            cellRole.textContent = user.NombreRol;

            const cellEstado = document.createElement('td');
            cellEstado.textContent = user.EstadoCuenta;

            // Añadir las celdas a la fila
            row.appendChild(cellID);
            row.appendChild(cellName);
            row.appendChild(cellEmail);
            row.appendChild(cellRole);
            row.appendChild(cellEstado);

            // Añadir la fila a la tabla
            contenedor.appendChild(row);
        });
    } else {
        console.log("No hay usuarios para mostrar.");
        // Si no hay usuarios, mostrar un mensaje en la tabla
        const row = document.createElement('tr');
        const cell = document.createElement('td');
        cell.colSpan = 4;
        cell.textContent = "No hay usuarios disponibles.";
        row.appendChild(cell);
        contenedor.appendChild(row);
    }
})
.catch(error => console.error('Error al obtener los usuarios:', error)); // Manejo de errores si la solicitud falla