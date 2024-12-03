<?php
include '../BaseDeDatos/DataBase.php'; // Incluir el archivo de conexión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];
    // Almacena la informacion de los inputs en variables

    $stmt = $conn->prepare("CALL iniciarSesion(?, ?, @id, @nombreUsuario, @rolID, @nombreRol)");
    // Preparar la consulta

    if ($stmt === false) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    $stmt->bind_param("ss", $email, $password);
    // Vincular los parámetros del procedimiento almacenado con las variables de PHP

    if ($stmt->execute()) {
        $result = $conn->query("SELECT @id AS id, @nombreUsuario AS nombreUsuario, @rolID AS rolID, @nombreRol AS nombreRol");
        $row = $result->fetch_assoc();
        // Obtener los resultados del procedimiento almacenado

        $id = $row['id'];
        $nombreUsuario = $row['nombreUsuario'];
        $rolID = $row['rolID'];
        $nombreRol = $row['nombreRol'];
        // Almacena los resultados en variables

        if ($id !== null) {
            session_start();
            $_SESSION['id'] = $id;
            $_SESSION['nombreUsuario'] = $nombreUsuario;
            // Guardar el ID y el nombre del usuario en la sesión

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
            header("Location: Sesion.html?no-registrado=1");
        }
    } else {
        echo "Error al ejecutar el procedimiento: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
