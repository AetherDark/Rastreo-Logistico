<?php
include '../Base de datos/DataBase.php';

if (isset($_COOKIE['user_id'])) {
    $userID = $_COOKIE['user_id'];

    // Preparar y ejecutar la consulta para obtener el nombre del usuario
    $stmt = $conn->prepare("SELECT NombreUsuario FROM Usuarios WHERE ID = ?");
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        echo json_encode(["nombreUsuario" => $user['NombreUsuario']]);
    } else {
        echo json_encode(["nombreUsuario" => "Usuario no encontrado"]);
    }

    $stmt->close();
} else {
    echo json_encode(["nombreUsuario" => "No autenticado"]);
}

$conn->close();
