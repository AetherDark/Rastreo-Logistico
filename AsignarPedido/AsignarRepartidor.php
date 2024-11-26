<?php
include '../BaseDeDatos/DataBase.php'; // Conexión a la base de datos

header('Content-Type: application/json');

// Leer y decodificar los datos de la solicitud
$data = json_decode(file_get_contents('php://input'), true);

// Validar datos recibidos
$pedidoID = $data['pedidoID'] ?? null;
$repartidorID = $data['repartidorID'] ?? null;

// Consulta para obtener el IDUsuario usando el ID almacenado en la cookie
$stmtUsuario = $conn->prepare("SELECT IDUsuario FROM Usuarios WHERE ID = ?");
$stmtUsuario->bind_param("i", $repartidorID); // Usamos el valor de la cookie para la consulta
$stmtUsuario->execute();
$stmtUsuario->bind_result($idRepartidor); // Vincular el resultado a la variable $idUsuario
$stmtUsuario->fetch();
$stmtUsuario->close();

if (!$pedidoID || !$repartidorID) {
    echo json_encode(['success' => false, 'error' => 'Datos incompletos.']);
    exit;
}

try {
    // Iniciar una transacción para asegurar la consistencia de los datos
    $conn->begin_transaction();

    // Insertar la asignación en la tabla correspondiente
    $stmt = $conn->prepare("INSERT INTO Asignaciones (ID, PedidoID) VALUES (?, ?)");
    $stmt->bind_param('ii', $idRepartidor, $pedidoID);

    if (!$stmt->execute()) {
        throw new Exception("Error al asignar repartidor: " . $stmt->error);
    }

    // Actualizar el estado del pedido
    $updateStmt = $conn->prepare("UPDATE Pedidos SET EstadoActual = 'Paquete enviado' WHERE ID = ?");
    $updateStmt->bind_param('i', $pedidoID);

    if (!$updateStmt->execute()) {
        throw new Exception("Error al actualizar el estado del pedido: " . $updateStmt->error);
    }

    // Confirmar la transacción
    $conn->commit();

    echo json_encode(['success' => true]);

    $stmt->close();
    $updateStmt->close();
} catch (Exception $e) {
    // Revertir la transacción en caso de error
    $conn->rollback();
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}

$conn->close();
?>
