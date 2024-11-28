<?php
// getPedidoEstado.php
include '../BaseDeDatos/DataBase.php';

// Obtener el ID del pedido desde la solicitud POST
$data = json_decode(file_get_contents('php://input'), true);

// Verificar que se recibió el ID del pedido
if (isset($data['id'])) {
    $pedidoID = $data['id'];

    // Consultar el estado del pedido
    $sql = "SELECT EstadoActual FROM Pedidos WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $pedidoID); // 'i' para entero
    $stmt->execute();
    $stmt->bind_result($estadoActual);
    $stmt->fetch();

    // Cerrar la conexión
    $stmt->close();
    $conn->close();

    // Devolver el estado como JSON
    if ($estadoActual) {
        echo json_encode(['EstadoActual' => $estadoActual]);
    } else {
        echo json_encode(['error' => 'Pedido no encontrado']);
    }
} else {
    echo json_encode(['error' => 'ID de pedido no proporcionado']);
}
?>
