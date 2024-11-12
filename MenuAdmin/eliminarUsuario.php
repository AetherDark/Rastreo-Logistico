<?php
// Asegúrate de incluir la conexión a la base de datos
include '../Base de datos/DataBase.php'; // Se manda a llamar la conexion de la base de datos sin tener que escribirla de nuevo

// Verificar que la solicitud sea POST y que el ID esté presente
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['userID'])) {
    $userID = $_POST['userID'];

    // Verificar si el ID es un número entero
    if (!filter_var($userID, FILTER_VALIDATE_INT)) {
        echo json_encode(["success" => false, "message" => "El ID debe ser un número entero."]);
        exit; // Salir del script si no es un número entero
    }

    // Convertir a entero
    $userID = intval($userID);

    // Verificar si el ID existe en la base de datos
    $query = "SELECT COUNT(*) FROM Usuarios WHERE ID = ?";
    if ($stmt = $conn->prepare($query)) {
        // Vincular el parámetro
        $stmt->bind_param("i", $userID);

        // Ejecutar la consulta
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        // Verificar si el usuario existe
        if ($count == 0) {
            echo json_encode(["success" => false, "message" => "El ID de usuario no existe."]);
            exit; // Salir del script si el ID no existe
        }

        // Si el ID existe, proceder a eliminarlo
        $query = "CALL eliminarUsuario(?)"; // Usar el procedimiento almacenado
        if ($stmt = $conn->prepare($query)) {
            // Vincular el parámetro
            $stmt->bind_param("i", $userID);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                // Si la eliminación fue exitosa, enviar una respuesta exitosa
                echo json_encode(["success" => true, "message" => "Usuario eliminado correctamente."]);
            } else {
                // Si hubo un error, enviar un mensaje de error
                echo json_encode(["success" => false, "message" => "Hubo un error al eliminar el usuario."]);
            }

            $stmt->close();
        } else {
            echo json_encode(["success" => false, "message" => "No se pudo preparar la consulta."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "No se pudo verificar si el usuario existe."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Solicitud incorrecta."]);
}
?>
