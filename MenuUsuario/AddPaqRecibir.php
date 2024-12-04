<?php
// Incluir la conexión a la base de datos
include '../BaseDeDatos/DataBase.php';

try {
    // Verificar que la solicitud sea de tipo POST y que los campos requeridos estén presentes
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Recoger los datos enviados desde el formulario
        $pedidoID = filter_input(INPUT_POST, 'pedidoID', FILTER_SANITIZE_STRING);
        $usuarioID = $_COOKIE['user_id']; // ID del usuario actual

        // Validar que se haya proporcionado un pedidoID
        if (!$pedidoID) {
            throw new Exception("Error: Todos los campos son obligatorios.");
        }

        // Consulta para obtener el IDUsuario usando el ID almacenado en la cookie
        $stmtUsuario = $conn->prepare("CALL obtenerIDUsuario(?)");
        $stmtUsuario->bind_param("i", $usuarioID); // Usamos el valor de la cookie para la consulta
        $stmtUsuario->execute();
        $stmtUsuario->bind_result($idUsuario); // Vincular el resultado a la variable $idUsuario

        if (!$stmtUsuario->fetch()) {
            throw new Exception("Error: Usuario no encontrado.");
        }

        $stmtUsuario->close();

        // Insertar el nuevo registro en la tabla pedidosRecibir
        $stmt = $conn->prepare("CALL insertarPedidoRecibir(?, ?)");
        $stmt->bind_param("ii", $pedidoID, $idUsuario); // Vincular los parámetros

        if (!$stmt->execute()) {
            throw new Exception("Error: No se pudo insertar el pedido. Verifica los datos.");
        }

        // Redirigir o mostrar mensaje en caso de éxito
        header("Location: ../MenuUsuario/Rastrear.html?Rastreo=1");
    } else {
        throw new Exception("Solicitud incorrecta.");
    }
} catch (mysqli_sql_exception $e) {
    // Manejo de errores específicos de MySQL
    error_log("Error SQL: " . $e->getMessage());
    header("Location: ../MenuUsuario/Rastrear.html?ErrorRastreo=1");
} catch (Exception $e) {
    // Manejo de errores generales
    error_log("Error: " . $e->getMessage());
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
    header("Location: ../MenuUsuario/Rastrear.html?ErrorRastreo=1");
} finally {
    // Cierra la conexión si está abierta
    if (isset($stmt)) $stmt->close();
    if (isset($conn)) $conn->close();
}
?>