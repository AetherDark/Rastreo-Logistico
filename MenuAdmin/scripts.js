$(document).ready(function() {
    // Cargar usuarios existentes al cargar la página
    loadUsers();

    // Evento para seleccionar un usuario al hacer clic en una fila
    $(document).on('click', '#userTableBody tr', function() {
        $(this).toggleClass('selected');
        $('#deleteUserButton').prop('disabled', !$(this).hasClass('selected'));
    });

    // Evento para el botón de eliminar
    $('#deleteUserButton').click(function() {
        const row = $('#userTableBody .selected');
        const userId = row.data('id');

        if (confirm("¿Estás seguro de que deseas eliminar este usuario?")) {
            $.ajax({
                type: "POST",
                url: "process_user.php",
                data: { action: 'delete', id: userId },
                success: function(response) {
                    if (response.success) {
                        row.remove();
                        alert("Usuario eliminado exitosamente.");
                        $('#deleteUserButton').prop('disabled', true);
                    } else {
                        alert("Error al eliminar el usuario.");
                    }
                }
            });
        }
    });

    // Evento para el botón de regresar
    $('#backButton').click(function() {
        window.location.href = "pagina_de_regreso.html"; // Cambia esto por la URL de la página a la que deseas regresar
    });
});

// Función para cargar usuarios existentes
function loadUsers() {
    console.log("Cargando usuarios...");
    $.ajax({
        type: "GET",
        url: "get_users.php", // Cambia esto por la URL de tu script que devuelve los usuarios
        success: function(data) {
            const users = JSON.parse(data);
            users.forEach(user => {
                $('#userTableBody').append(`
                    <tr data-id="${user.ID}">
                        <td>${user.ID}</td>
                        <td>${user.NombreUsuario}</td>
                        <td>${user.Email}</td>
                        <td>${user.NombreRol}</td>
                    </tr>
                `);
            });
        }
    });
}
