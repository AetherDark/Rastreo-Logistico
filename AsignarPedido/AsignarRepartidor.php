<?php
include '../BaseDeDatos/DataBase.php'; // Conexión a la base de datos

header('Content-Type: application/json');

// Obtener datos de la solicitud
$data = json_decode(file_get_contents('php://input'), true);
$pedidoID = $data['pedidoID'] ?? null;
$repartidorID = $data['repartidorID'] ?? null;

if ($pedidoID && $repartidorID) {
    // Insertar la asignación en la tabla correspondiente
    $stmt = $conn->prepare("INSERT INTO Asignaciones (ID, PedidoID) VALUES (?, ?)");
    $stmt->bind_param('ii', $repartidorID, $pedidoID);

    if ($stmt->execute()) {
        // Después de la inserción, actualizar el estado del pedido
        $updateStmt = $conn->prepare("UPDATE Pedidos SET EstadoActual = 'Paquete enviado' WHERE ID = ?");
        $updateStmt->bind_param('i', $pedidoID);

        if ($updateStmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $updateStmt->error]);
        }

        $updateStmt->close();
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Datos incompletos.']);
}

$conn->close();
?>
