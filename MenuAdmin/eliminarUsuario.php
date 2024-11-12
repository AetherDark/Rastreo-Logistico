<?php
// Incluir la conexión a la base de datos
include '../Base de datos/DataBase.php';

// Verificar que la solicitud sea POST y recibir el JSON
$data = json_decode(file_get_contents("php://input"), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($data['userID'])) {
    $userID = $data['userID'];

    // Validar el ID
    if (!filter_var($userID, FILTER_VALIDATE_INT)) {
        echo json_encode(["success" => false, "message" => "El ID debe ser un número entero."]);
        exit;
    }

    // Convertir el ID a entero
    $userID = intval($userID);

    // Verificar si el usuario existe
    $query = "SELECT COUNT(*) FROM Usuarios WHERE ID = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        if ($count == 0) {
            echo json_encode(["success" => false, "message" => "El ID de usuario no existe."]);
            exit;
        }

        // Eliminar el usuario si existe
        $query = "CALL eliminarUsuario(?)"; // Procedimiento almacenado
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("i", $userID);
            if ($stmt->execute()) {
                echo json_encode(["success" => true, "message" => "Usuario eliminado correctamente."]);
            } else {
                echo json_encode(["success" => false, "message" => "Error al eliminar el usuario."]);
            }
            $stmt->close();
        } else {
            echo json_encode(["success" => false, "message" => "No se pudo preparar la consulta."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Error al verificar el usuario."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Solicitud incorrecta."]);
}
?>
