<?php
// Incluir la conexión a la base de datos
include '../BaseDeDatos/DataBase.php';

// Leer la solicitud JSON
$data = json_decode(file_get_contents("php://input"), true);
$userID = $data['userID'];
$estadoCuenta = $data['estado'];

// Actualizar el estado del usuario
$sql = "CALL actualizarEstadoUsuario(?, ?)";
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
