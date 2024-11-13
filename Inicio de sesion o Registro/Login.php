<?php
include '../Base de datos/DataBase.php'; // Incluir el archivo de conexión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("CALL iniciarSesion(?, ?, @id, @nombreUsuario, @rolID, @nombreRol)");

    if ($stmt === false) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    $stmt->bind_param("ss", $email, $password);

    if ($stmt->execute()) {
        $result = $conn->query("SELECT @id AS id, @nombreUsuario AS nombreUsuario, @rolID AS rolID, @nombreRol AS nombreRol");
        $row = $result->fetch_assoc();

        $id = $row['id'];
        $nombreUsuario = $row['nombreUsuario'];
        $rolID = $row['rolID'];
        $nombreRol = $row['nombreRol'];

        if ($id !== null) {
            session_start();
            $_SESSION['id'] = $id;
            $_SESSION['nombreUsuario'] = $nombreUsuario;

            // Guardar el ID del usuario en una cookie con duración de 10 minutos
            setcookie("user_id", $id, time() + 600, "/"); // 600 segundos = 10 minutos

            // Redirigir según el RolID
            if ($rolID == 3) {
                header("Location: ../MenuUsuario/MenuUsuario.html");
            } elseif ($rolID == 2) {
                header("Location: ../MenuRepartidor/MenuRepartidor.html");
            } elseif ($rolID == 1) {
                header("Location: ../MenuAdmin/MenuAdmin.html");
            }
            exit();
        } else {
            echo "Contraseña incorrecta o usuario no encontrado.";
        }
    } else {
        echo "Error al ejecutar el procedimiento: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
