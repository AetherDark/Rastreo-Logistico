<?php
// getPedidoEstado.php
include '../BaseDeDatos/DataBase.php';

// Obtener la entrada JSON desde el frontend
$data = json_decode(file_get_contents('php://input'), true);

// Verificar que se recibió el ID del pedido
if (isset($data['id'])) {
    $pedidoID = $data['id'];

    // Consultar el estado del pedido
    $sql = "CALL obtenerEstadoPedido(?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $pedidoID);
    $stmt->execute();
    $stmt->bind_result($estadoActual);
    $stmt->fetch();
    
    // Cerrar la conexión
    $stmt->close();
    $conn->close();

    // Devolver el estado como JSON
    echo json_encode(['EstadoActual' => $estadoActual]);
} else {
    echo json_encode(['error' => 'ID de pedido no proporcionado']);
}
?>
