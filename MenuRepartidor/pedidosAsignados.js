let pedidoSeleccionado = null; // Variable para almacenar el ID del pedido seleccionado

// Realizar una solicitud para obtener los pedidos desde el servidor
fetch('pedidosAsignados.php', { method: 'POST' })
    .then(response => response.json())
    .then(data => {
        console.log(data);

        const contenedor = document.getElementById('pedidoAsignado');
        const botonEstado = document.getElementById('cambiarEstado'); // Obtener el botón aquí
        const botonExtravio = document.getElementById('extraviado'); // Obtener el botón aquí

        // Deshabilitar el botón inicialmente
        botonEstado.disabled = true; // Deshabilitar el botón inicialmente
        botonExtravio.disabled = true; // Deshabilitar el botón inicialmente

        if (Array.isArray(data) && data.length > 0) {
            data.forEach(pedido => {
                const row = document.createElement('tr');

                // Crear celdas
                const cellID = document.createElement('td');
                cellID.textContent = pedido.ID;

                const cellDescripcion = document.createElement('td');
                cellDescripcion.textContent = pedido.Descripcion;

                const cellEstadoActual = document.createElement('td');
                cellEstadoActual.textContent = pedido.EstadoActual;

                row.appendChild(cellID);
                row.appendChild(cellDescripcion);
                row.appendChild(cellEstadoActual);

                // Agregar evento para seleccionar pedido
                row.addEventListener('click', () => {
                    document.querySelectorAll('tr').forEach(tr => tr.classList.remove('table-primary'));
                    row.classList.add('table-primary'); // Marcar como seleccionado
                    pedidoSeleccionado = pedido.ID; // Guardar el ID del pedido seleccionado
                    console.log("Pedido seleccionado:", pedidoSeleccionado);

                    botonEstado.disabled = false; // Habilitar el botón
                    botonExtravio.disabled = false; // Habilitar el botón
                });

                contenedor.appendChild(row);
            });
        } else {
            console.log("No hay pedidos para mostrar.");
            const row = document.createElement('tr');
            const cell = document.createElement('td');
            cell.colSpan = 4;
            cell.textContent = "No tienes ningún pedido asignado.";
            row.appendChild(cell);
            contenedor.appendChild(row);
        }
    })
    .catch(error => console.error('Error al obtener los pedidos:', error));

    const botonEstado = document.getElementById('cambiarEstado');
    const botonExtravio = document.getElementById('extraviado');
    
    // Asignar los event listeners cuando se cargue la página
    botonEstado.addEventListener('click', actualizarEstado);
    botonExtravio.addEventListener('click', marcarComoExtraviado);
    
    // Función para actualizar el estado del pedido
    function actualizarEstado() {
        const select = document.getElementById('estado'); // Obtener el select de estados
        const nuevoEstado = select.value;
    
        if (!pedidoSeleccionado) {
            alert("Por favor selecciona un pedido.");
            return;
        }
    
        if (!nuevoEstado) {
            alert("Por favor selecciona un estado.");
            return;
        }
    
        fetch('actualizarPedido.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: pedidoSeleccionado, estado: nuevoEstado })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Estado del pedido actualizado correctamente.");
                    location.reload(); // Recargar la página para ver los cambios
                } else {
                    alert("Error al actualizar el estado del pedido.");
                }
            })
            .catch(error => console.error('Error al actualizar el estado:', error)); // Siempre manda al catch
    }
    
    // Función para marcar como extraviado
    function marcarComoExtraviado() {
        const nuevoEstado = 'Extraviado';
        
        if (!pedidoSeleccionado) {
            alert("Por favor selecciona un pedido.");
            return;
        }
    
        fetch('actualizarPedido.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: pedidoSeleccionado, estado: nuevoEstado })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("El pedido se marcó como extraviado.");
                    location.reload();
                } else {
                    alert("Error al marcar como extraviado.");
                }
            })
            .catch(error => console.error('Error al marcar como extraviado:', error)); //Tambien manda solo al catch
    }
    