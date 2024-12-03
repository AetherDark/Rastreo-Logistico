<?php
include '../BaseDeDatos/DataBase.php'; // Incluir el archivo de conexión

header('Content-Type: application/json'); // Establecer la cabecera de tipo de contenido

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Leer el ID del usuario desde el cuerpo de la solicitud
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['user_id'])) {
        $userID = $data['user_id']; // Obtener el user_id del cuerpo de la solicitud

        try {
            // Consulta para obtener el IDUsuario usando el ID proporcionado
            $stmtUsuario = $conn->prepare("SELECT IDUsuario FROM Usuarios WHERE ID = ?");
            $stmtUsuario->bind_param("i", $userID);
            $stmtUsuario->execute();
            $stmtUsuario->bind_result($idUsuario);
            $stmtUsuario->fetch();
            $stmtUsuario->close();

            if ($idUsuario) {
                // Consultar los pedidos asignados al usuario
                $stmt = $conn->prepare("
                    SELECT Pedidos.ID AS id, Pedidos.Descripcion AS descripcion, Pedidos.EstadoActual AS estado 
                    FROM Asignaciones
                    JOIN Pedidos ON Asignaciones.PedidoID = Pedidos.ID
                    WHERE Asignaciones.ID = ? AND Pedidos.EstadoActual NOT IN ('Entregado', 'Extraviado', 'Cancelado')
                ");
                $stmt->bind_param("i", $idUsuario);
                $stmt->execute();
                $result = $stmt->get_result();

                $enviados = [];
                while ($row = $result->fetch_assoc()) {
                    $enviados[] = [
                        'id' => $row['id'],
                        'descripcion' => $row['descripcion'],
                        'estado' => $row['estado']
                    ];
                }

                $stmt->close();

                // Responder con los pedidos obtenidos
                echo json_encode([
                    'success' => true,
                    'pedidos' => $enviados
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'No se encontró un usuario con el ID proporcionado.'
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error interno del servidor.',
                'error' => $e->getMessage()
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'No se proporcionó el user_id.'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido.'
    ]);
}

$conn->close(); // Cerrar la conexión a la base de datos
?>
