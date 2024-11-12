<?php
include '../Base de datos/DataBase.php'; // Incluir el archivo de conexión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar datos del formulario
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];

    // Preparar la llamada al procedimiento almacenado
    $stmt = $conn->prepare("CALL iniciarSesion(?, ?, @id, @nombreUsuario, @rolID, @nombreRol)");

    // Verificar si la preparación de la consulta fue exitosa
    if ($stmt === false) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    // Asignar parámetros
    $stmt->bind_param("ss", $email, $password);

    // Ejecutar el procedimiento
    if ($stmt->execute()) {
        // Obtener los valores de salida
        $result = $conn->query("SELECT @id AS id, @nombreUsuario AS nombreUsuario, @rolID AS rolID, @nombreRol AS nombreRol");
        $row = $result->fetch_assoc();

        // Asignar las variables de salida
        $id = $row['id'];
        $nombreUsuario = $row['nombreUsuario'];
        $rolID = $row['rolID'];
        $nombreRol = $row['nombreRol'];

        // Verificar si la sesión fue exitosa
        if ($id !== null) {
            // Iniciar sesión o redirigir según el RolID
            session_start();
            $_SESSION['id'] = $id;
            $_SESSION['nombreUsuario'] = $nombreUsuario;

            if ($rolID == 3) {
                header("Location: ../MenuUsuario/MenuUsuario.html"); // Redirigir a usuario
            } elseif ($rolID == 2) {
                header("Location: ../MenuRepartidor/MenuRepartidor.html"); // Redirigir a repartidor
            } elseif ($rolID == 1) {
                header("Location: ../MenuAdmin/MenuAdmin.html"); // Redirigir a administrador
            }
            exit(); // Asegúrate de llamar a exit después de header
        } else {
            echo "Contraseña incorrecta o usuario no encontrado.";
        }
    } else {
        // Manejar error de ejecución
        echo "Error al ejecutar el procedimiento: " . $stmt->error;
    }

    // Cerrar la declaración
    $stmt->close();
}

// Cerrar la conexión
$conn->close();
?>
