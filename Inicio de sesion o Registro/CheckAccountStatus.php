<?php
// CheckAccountStatus.php
include '../Base de datos/DataBase.php'; // Incluir el archivo de conexión

header('Content-Type: application/json');

session_start(); // Asegurarte de que la sesión esté activa

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Leer el ID del usuario desde las cookies
    if (isset($_COOKIE['user_id'])) {
        $userID = $_COOKIE['user_id'];
    } else {
        echo json_encode(["status" => "error", "message" => "No se encontró la cookie de usuario."]);
        exit;
    }

    // Consultar el estado de la cuenta
    $stmt = $conn->prepare("SELECT EstadoCuenta FROM Usuarios WHERE ID = ?");
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode(["status" => $row['EstadoCuenta']]);
    } else {
        echo json_encode(["status" => "error", "message" => "Usuario no encontrado."]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Método no permitido."]);
}
?>
