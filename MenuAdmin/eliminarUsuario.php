<?php
// Incluir la conexión a la base de datos
include '../Base de datos/DataBase.php';

// Leer los datos JSON enviados en la solicitud POST
$data = json_decode(file_get_contents("php://input"), true);

// Verificar si la solicitud es de tipo POST y si se ha enviado el parámetro 'userID'
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($data['userID'])) {
    // Asignar el valor de 'userID' del JSON a la variable $userID
    $userID = $data['userID'];

    // Validar que el 'userID' es un número entero
    if (!filter_var($userID, FILTER_VALIDATE_INT)) {
        // Si no es un número entero, devolver un error en formato JSON
        echo json_encode(["success" => false, "message" => "El ID debe ser un número entero."]);
        exit;  // Detener la ejecución
    }

    // Convertir el 'userID' a un valor entero (por si acaso)
    $userID = intval($userID);

    // Verificar si el usuario con ese 'userID' existe en la base de datos
    $query = "SELECT COUNT(*) FROM Usuarios WHERE ID = ?";
    if ($stmt = $conn->prepare($query)) {
        // Preparar la consulta y vincular el parámetro 'userID' como entero
        $stmt->bind_param("i", $userID);
        // Ejecutar la consulta
        $stmt->execute();
        // Obtener el resultado de la consulta
        $stmt->bind_result($count);
        // Extraer el resultado de la consulta (número de coincidencias)
        $stmt->fetch();
        // Cerrar la sentencia preparada
        $stmt->close();

        // Si no se encuentra el usuario, devolver un error
        if ($count == 0) {
            echo json_encode(["success" => false, "message" => "El ID de usuario no existe."]);
            exit;  // Detener la ejecución
        }

        // Si el usuario existe, eliminarlo utilizando un procedimiento almacenado
        $query = "CALL eliminarUsuario(?)"; // Procedimiento almacenado para eliminar el usuario
        if ($stmt = $conn->prepare($query)) {
            // Preparar la consulta y vincular el parámetro 'userID' como entero
            $stmt->bind_param("i", $userID);
            // Ejecutar la consulta para eliminar al usuario
            if ($stmt->execute()) {
                // Si se elimina correctamente, devolver un mensaje de éxito
                echo json_encode(["success" => true, "message" => "Usuario eliminado correctamente."]);
            } else {
                // Si ocurre un error al eliminar, devolver un mensaje de error
                echo json_encode(["success" => false, "message" => "Error al eliminar el usuario."]);
            }
            // Cerrar la sentencia preparada
            $stmt->close();
        } else {
            // Si no se puede preparar la consulta, devolver un error
            echo json_encode(["success" => false, "message" => "No se pudo preparar la consulta."]);
        }
    } else {
        // Si ocurre un error al verificar el usuario, devolver un mensaje de error
        echo json_encode(["success" => false, "message" => "Error al verificar el usuario."]);
    }
} else {
    // Si la solicitud no es POST o falta el parámetro 'userID', devolver un error
    echo json_encode(["success" => false, "message" => "Solicitud incorrecta."]);
}
?>
