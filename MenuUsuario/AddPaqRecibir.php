<?php
// RegistrarUsuario.php

// Incluir la conexión a la base de datos
include '../Base de datos/DataBase.php';

// Verificar que la solicitud sea de tipo POST y que los campos requeridos estén presentes
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger los datos enviados desde el formulario
    $pedidoID = filter_input(INPUT_POST, 'pedidoID', FILTER_SANITIZE_STRING);
    $usuarioID = $_COOKIE['user_id']; // ID del usuario actual

    if (!$pedidoID) {
        die("Error: Todos los campos son obligatorios.");
    }

    // Insertar el nuevo usuario en la base de datos con el nombre, correo, rol y contraseña
    $stmt = $conn->prepare("INSERT INTO pedidosRecibir (ID, UsuarioID) VALUES (?, ?)");
    $stmt->bind_param("ii", $pedidoID, $usuarioID);

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
