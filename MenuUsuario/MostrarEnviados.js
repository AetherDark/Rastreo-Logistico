// Realizar una solicitud para obtener los usuarios desde el servidor
fetch('MostrarEnviados.php', { method: 'POST' })  // Realizar una solicitud POST a 'MostrarUsuarios.php'
.then(response => response.json())  // Convierte la respuesta en formato JSON
.then(data => {
    console.log(data); // Muestra los datos obtenidos en la consola para depuración

    // Obtener el contenedor donde se insertarán los usuarios en la tabla
    const contenedor = document.getElementById('envioTableBody');

    // Verificar que 'data' es un array y contiene usuarios
    if (Array.isArray(data) && data.length > 0) {
        // Recorrer los usuarios y crear una fila en la tabla por cada uno
        data.forEach(envio => {
            const row = document.createElement('tr');
            
            // Crear celdas para los datos de cada usuario
            const cellID = document.createElement('td');
            cellID.textContent = envio.ID;

            const cellDescripcion = document.createElement('td');
            cellDescripcion.textContent = envio.Descripcion;

            const cellDestinatario = document.createElement('td');
            cellDestinatario.textContent = envio.Destinatario;

            // Añadir las celdas a la fila
            row.appendChild(cellID);
            row.appendChild(cellDescripcion);
            row.appendChild(cellDestinatario);

            // Añadir la fila a la tabla
            contenedor.appendChild(row);
        });
    } else {
        console.log("No hay pedidos para mostrar.");
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