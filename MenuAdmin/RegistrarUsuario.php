<?php
// RegistrarUsuario.php

// Incluir la conexión a la base de datos
include '../Base de datos/DataBase.php';

// Verificar que la solicitud sea POST y que los campos requeridos estén presentes
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre'], $_POST['email'], $_POST['rol'], $_POST['pass'])) {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $rolID = $_POST['rol']; // Este será el ID de rol (1 para administrador, 2 para repartidor)
    $password = $_POST['pass']; // Aquí se recoge la contraseña directamente

    // Verificar si el correo ya existe en la base de datos
    $query = "SELECT COUNT(*) FROM Usuarios WHERE Email = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        if ($count > 0) {
            header("Location: PanelUsuarios.html?existente=1");
            exit();
        }
    }

    // Verificar si el usuario ya existe en la base de datos
    $query = "SELECT COUNT(*) FROM Usuarios WHERE NombreUsuario = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("s", $nombre);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        if ($count > 0) {
            header("Location: PanelUsuarios.html?existente=1");
            exit();
        }
    }

    // Obtener el nombre del rol de la tabla Roles
    $roleQuery = "SELECT Nombre FROM Roles WHERE ID = ?";
    $roleName = '';
    if ($stmt = $conn->prepare($roleQuery)) {
        $stmt->bind_param("i", $rolID);
        $stmt->execute();
        $stmt->bind_result($roleName);
        $stmt->fetch();
        $stmt->close();
    }

    // Verificar si se obtuvo un nombre de rol válido
    if (empty($roleName)) {
        header("Location: PanelUsuarios.html?RolNOValido=1");
        exit;
    }

    // Insertar el usuario en la base de datos con el rol seleccionado y la contraseña
    $query = "INSERT INTO Usuarios (NombreUsuario, Email, RolID, NombreRol, PasswordHash) VALUES (?, ?, ?, ?, ?)";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("ssiss", $nombre, $email, $rolID, $roleName, $password); // Insertar el nombre del rol

        if ($stmt->execute()) {
            header("Location: PanelUsuarios.html?RegistroExitoso=1");
        } else {
            header("Location: PanelUsuarios.html?errorRegistro=1");
        }

        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "No se pudo preparar la consulta."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Solicitud incorrecta."]);
}
?>
