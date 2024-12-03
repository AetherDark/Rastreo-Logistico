let pedidoSeleccionado = null; // Variable para almacenar el ID del pedido seleccionado

// Realizar una solicitud para obtener los pedidos desde el servidor
fetch('allPedidos.php', { method: 'POST' })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        const contenedor = document.getElementById('allpedidos'); // Obtener el contenedor aquí
        const botonCancelar = document.getElementById('cancelar'); // Obtener el botón aquí

        // Deshabilitar el botón inicialmente
        botonCancelar.disabled = true; // Deshabilitar el botón inicialmente

        if (Array.isArray(data) && data.length > 0) {
            data.forEach(pedido => {
                const row = document.createElement('tr');

                // Crear celdas
                const cellID = document.createElement('td');
                cellID.textContent = pedido.ID;

                const cellDescripcion = document.createElement('td');
                cellDescripcion.textContent = pedido.Descripcion;

                const cellDireccionDestino = document.createElement('td');
                cellDireccionDestino.textContent = pedido.DireccionDestino;

                const cellEstadoActual = document.createElement('td');
                cellEstadoActual.textContent = pedido.EstadoActual;

                row.appendChild(cellID);
                row.appendChild(cellDescripcion);
                row.appendChild(cellDireccionDestino);
                row.appendChild(cellEstadoActual);

                // Agregar evento para seleccionar pedido
                row.addEventListener('click', () => {
                    document.querySelectorAll('tr').forEach(tr => tr.classList.remove('table-primary'));
                    row.classList.add('table-primary'); // Marcar como seleccionado
                    pedidoSeleccionado = pedido.ID; // Guardar el ID del pedido seleccionado
                    console.log("Pedido seleccionado:", pedidoSeleccionado);

                    botonCancelar.disabled = false; // Habilitar el botón
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

    const botonCancelar = document.getElementById('cancelar');
    
    // Asignar los event listeners cuando se cargue la página
    botonCancelar.addEventListener('click', marcarComoCancelado);
    
    // Función para marcar como cancelado un pedido
    function marcarComoCancelado() {
        const nuevoEstado = 'Cancelado';
        
        if (!pedidoSeleccionado) {
            alert("Por favor selecciona un pedido.");
            return;
        }
    
        fetch('cancelarPedido.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: pedidoSeleccionado, estado: nuevoEstado })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("El pedido se marcó como cancelado.");
                    location.reload();
                } else {
                    alert("Error al cancelar el pedido.");
                }
            })
            .catch(error => console.error('Error al cancelar el pedido:', error)); //Tambien manda solo al catch
    }
    