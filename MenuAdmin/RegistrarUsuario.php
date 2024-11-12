<?php
// RegistrarUsuario.php

// Incluir la conexión a la base de datos
include '../Base de datos/DataBase.php';

// Verificar que la solicitud sea de tipo POST y que los campos requeridos estén presentes
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre'], $_POST['email'], $_POST['rol'], $_POST['pass'])) {
    // Recoger los datos enviados desde el formulario
    $nombre = $_POST['nombre'];  // Nombre completo del usuario
    $email = $_POST['email'];    // Correo electrónico del usuario
    $rolID = $_POST['rol'];      // ID del rol seleccionado (1 para administrador, 2 para repartidor)
    $password = $_POST['pass'];  // Contraseña proporcionada por el usuario

    // Verificar si el correo electrónico ya existe en la base de datos
    $query = "SELECT COUNT(*) FROM Usuarios WHERE Email = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("s", $email);  // Vincular el parámetro del correo
        $stmt->execute();  // Ejecutar la consulta
        $stmt->bind_result($count);  // Obtener el resultado de la consulta
        $stmt->fetch();  // Almacenar el resultado en la variable $count
        $stmt->close();  // Cerrar la sentencia

        // Si el correo electrónico ya existe, redirigir al panel de usuarios con un mensaje de error
        if ($count > 0) {
            header("Location: PanelUsuarios.html?existente=1");
            exit();  // Detener la ejecución del script
        }
    }

    // Verificar si el nombre de usuario ya existe en la base de datos
    $query = "SELECT COUNT(*) FROM Usuarios WHERE NombreUsuario = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("s", $nombre);  // Vincular el parámetro del nombre de usuario
        $stmt->execute();  // Ejecutar la consulta
        $stmt->bind_result($count);  // Obtener el resultado de la consulta
        $stmt->fetch();  // Almacenar el resultado en la variable $count
        $stmt->close();  // Cerrar la sentencia

        // Si el nombre de usuario ya existe, redirigir al panel de usuarios con un mensaje de error
        if ($count > 0) {
            header("Location: PanelUsuarios.html?existente=1");
            exit();  // Detener la ejecución del script
        }
    }

    // Obtener el nombre del rol desde la tabla Roles basado en el rolID
    $roleQuery = "SELECT Nombre FROM Roles WHERE ID = ?";
    $roleName = '';  // Inicializar la variable $roleName
    if ($stmt = $conn->prepare($roleQuery)) {
        $stmt->bind_param("i", $rolID);  // Vincular el parámetro del rolID
        $stmt->execute();  // Ejecutar la consulta
        $stmt->bind_result($roleName);  // Obtener el nombre del rol
        $stmt->fetch();  // Almacenar el resultado en la variable $roleName
        $stmt->close();  // Cerrar la sentencia
    }

    // Verificar si se obtuvo un nombre de rol válido
    if (empty($roleName)) {
        header("Location: PanelUsuarios.html?RolNOValido=1");
        exit;  // Detener la ejecución del script si el rol no es válido
    }

    // Insertar el nuevo usuario en la base de datos con el nombre, correo, rol y contraseña
    $query = "INSERT INTO Usuarios (NombreUsuario, Email, RolID, NombreRol, PasswordHash) VALUES (?, ?, ?, ?, ?)";
    if ($stmt = $conn->prepare($query)) {
        // Vincular los parámetros para la inserción de los datos en la base de datos
        $stmt->bind_param("ssiss", $nombre, $email, $rolID, $roleName, $password); // Incluir la contraseña directamente (no hash)

        // Ejecutar la consulta y verificar si la inserción fue exitosa
        if ($stmt->execute()) {
            header("Location: PanelUsuarios.html?RegistroExitoso=1");  // Redirigir al panel de usuarios con mensaje de éxito
        } else {
            header("Location: PanelUsuarios.html?errorRegistro=1");  // Redirigir al panel de usuarios con mensaje de error
        }

        $stmt->close();  // Cerrar la sentencia
    } else {
        // En caso de que no se pueda preparar la consulta, devolver un error
        echo json_encode(["success" => false, "message" => "No se pudo preparar la consulta."]);
    }
} else {
    // Si la solicitud no es válida (no es POST o los campos faltan), devolver un error
    echo json_encode(["success" => false, "message" => "Solicitud incorrecta."]);
}
?>
