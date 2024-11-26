<?php
// RegistrarUsuario.php

// Incluir la conexión a la base de datos
include '../BaseDeDatos/DataBase.php';

// Verificar que la solicitud sea de tipo POST y que los campos requeridos estén presentes
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger los datos enviados desde el formulario
    $pedidoID = filter_input(INPUT_POST, 'pedidoID', FILTER_SANITIZE_STRING);
    $usuarioID = $_COOKIE['user_id']; // ID del usuario actual

    // Consulta para obtener el IDUsuario usando el ID almacenado en la cookie
    $stmtUsuario = $conn->prepare("SELECT IDUsuario FROM Usuarios WHERE ID = ?");
    $stmtUsuario->bind_param("i", $usuarioID); // Usamos el valor de la cookie para la consulta
    $stmtUsuario->execute();
    $stmtUsuario->bind_result($idUsuario); // Vincular el resultado a la variable $idUsuario
    $stmtUsuario->fetch();
    $stmtUsuario->close();

    if (!$pedidoID) {
        die("Error: Todos los campos son obligatorios.");
    }

    // Insertar el nuevo usuario en la base de datos con el nombre, correo, rol y contraseña
    $stmt = $conn->prepare("INSERT INTO pedidosRecibir (ID, UsuarioID) VALUES (?, ?)");
    $stmt->bind_param("ii", $pedidoID, $idUsuario); // Vincular los parámetros

    // Ejecuta la consulta y verifica si fue exitosa
    if ($stmt->execute()) {
        // Redirigir o mostrar mensaje
        header("Location: ../MenuUsuario/Rastrear.html?Enviado=1");
    } else {
        header("Location: ../MenuUsuario/Rastrear.html?NoEnviado=1");
    }

    // Cierra la conexión
    $stmt->close();
    $conn->close();

} else {
    // Si la solicitud no es válida (no es POST o los campos faltan), devolver un error
    echo json_encode(["success" => false, "message" => "Solicitud incorrecta."]);
}
?>
