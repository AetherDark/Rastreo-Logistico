<?php
include '../Base de datos/DataBase.php'; // Se manda a llamar la conexion de la base de datos sin tener que escribirla de nuevo

// Asignacion de variables (parametros del formulario)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreUsuario = htmlspecialchars($_POST['nombreUsuario']); // Nombre de usuario
    $email = htmlspecialchars($_POST['email']); // Email de usuario
    $password = $_POST['password']; // Password de usuario
    $rolID = 3; // Rol del usuario
    $nombreRol = "Usuario"; // Nombre del Rol
    /*
    Se asigna por default el ROLID 3 ya que es el Rol de usuario el cual solo los usuarios son los que se registran
    ya los demas usuarios que son el de admin y repartidor los agrega manualmente el administrator
    */

    // Llamada al procedimiento almacenado
    $stmt = $conn->prepare("CALL registrarUsuario(?, ?, ?, ?, ?)");

    // if hecho para el testing y verificar los posibles errores que se generen con la consulta
    if ($stmt === false) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    $stmt->bind_param("ssiss", $nombreUsuario, $email, $password, $rolID, $nombreRol);
    /*
    Tiene como función enlazar los parámetros del procedimiento almacenado con las variables de PHP,
    para pasarlas a la consulta de forma segura y evitar inyecciones SQL.
    */

    try {
        if ($stmt->execute()) {
            header("Location: Sesion.html?registro=1");
            exit();
            // Redirige al de regreso al menu de sesion para iniciar sesion una vez creada la cuenta con un parametro en la url
            // Este parametro activa el js para la alerta de que se registro correctamente
        }
    } catch (Exception $e) {
        header("Location: Registro.php?error=1" . urlencode($e->getMessage()));
        exit();
        // Redirige al de regreso al menu de sesion con un parametro en la url de error para que de alerta
        // de que hubo un error al registrar la cuenta
    }

    $stmt->close();
}

$conn->close();
?>
