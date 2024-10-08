<?php
include 'DataBase.php'; // Incluir el archivo de conexión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar datos del formulario
    $nombreUsuario = htmlspecialchars($_POST['nombreUsuario']);
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash de la contraseña
    $rolID = 3; // Asegúrate de que exista en la tabla Roles
    $nombreRol = "Usuario"; // Nombre correspondiente al RolID

    // Preparar la consulta
    $stmt = $conn->prepare("INSERT INTO Usuarios (NombreUsuario, Email, PasswordHash, RolID, NombreRol) VALUES (?, ?, ?, ?, ?)");

    // Verificar si la preparación de la consulta fue exitosa
    if ($stmt === false) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    // Asignar parámetros
    $stmt->bind_param("ssiss", $nombreUsuario, $email, $password, $rolID, $nombreRol);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Usuario registrado exitosamente";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Cerrar la declaración
    $stmt->close();
}

// Cerrar la conexión
$conn->close();
?>
