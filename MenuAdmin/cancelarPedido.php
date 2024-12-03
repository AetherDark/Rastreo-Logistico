<?php
include '../BaseDeDatos/DataBase.php'; // Incluir el archivo de conexión

header('Content-Type: application/json');

// Obtener los datos recibidos en formato JSON
$input = json_decode(file_get_contents('php://input'), true);

// Validar que los datos existan
if (isset($input['id']) && isset($input['estado'])) {
    $id = (int)$input['id']; // Asegurarse de que el ID sea un número entero
    $estado = $input['estado'];

    // Verificar si el ID y el estado son válidos
    if ($id > 0 && !empty($estado)) {
        // Preparar la consulta para actualizar el estado del pedido
        $query = "CALL actualizarEstadoPedido(?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('si', $estado, $id);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $stmt->error]);
        }

        // Cerrar la declaración y la conexión
        $stmt->close();
        $conn->close();
    } else {
        echo json_encode(['success' => false, 'error' => 'ID o estado inválidos']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Datos incompletos']);
}
?>
