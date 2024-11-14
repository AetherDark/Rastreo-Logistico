<?php
// Incluir la conexión a la base de datos
include '../Base de datos/DataBase.php';

// Leer la solicitud JSON
$data = json_decode(file_get_contents("php://input"), true);
$userID = $data['userID'];
$estadoCuenta = $data['estado'];

// Actualizar el estado del usuario
$sql = "UPDATE Usuarios SET EstadoCuenta = ? WHERE ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $estadoCuenta, $userID);

$response = array();

if ($stmt->execute()) {
    $response['success'] = true;
} else {
    $response['success'] = false;
}

$stmt->close();
$conn->close();

// Devolver la respuesta en formato JSON
echo json_encode($response);
?>
