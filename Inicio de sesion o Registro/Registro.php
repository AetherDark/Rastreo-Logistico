<?php
include '../Base de datos/DataBase.php'; // Incluir el archivo de conexión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar datos del formulario
    $nombreUsuario = htmlspecialchars($_POST['nombreUsuario']);
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];
    $rolID = 3; // Asegúrate de que exista en la tabla Roles
    $nombreRol = "Usuario"; // Nombre correspondiente al RolID

    // Preparar la consulta
    $stmt = $conn->prepare("CALL registrarUsuario(?, ?, ?, ?, ?)");

    // Verificar si la preparación de la consulta fue exitosa
    if ($stmt === false) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    // Asignar parámetros
    $stmt->bind_param("ssiss", $nombreUsuario, $email, $password, $rolID, $nombreRol);

    if ($stmt->execute()) {
        // Redirigir a sesion.html después del registro exitoso
        header("Location: Sesion.html"); // Asegúrate de que la ruta sea correcta
        exit(); // Asegúrate de llamar a exit después de header
    } else {
        // Si hay un error, puedes redirigir a la misma página de registro o manejar el error como desees
        header("Location: Registro.php?error=" . urlencode($stmt->error));
        exit(); // Asegúrate de llamar a exit después de header
    }      

    // Cerrar la declaración
    $stmt->close();
}

// Cerrar la conexión
$conn->close();
?>
