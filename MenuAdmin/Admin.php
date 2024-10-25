

<?php
// Iniciar la sesión si aún no está iniciada
session_start();

// Comprobar si se ha presionado el botón de cierre de sesión
if (isset($_POST['logout'])) {
    // Destruir la sesión para cerrar la sesión del usuario
    session_destroy();
    
    // Redirigir al usuario a la página de inicio de sesión
    header("Location: ../Inicio%20de%20sesion%20o%20Registro/Sesion.html");
    exit(); // Asegurarse de que el script se detenga después de redirigir
}
?>