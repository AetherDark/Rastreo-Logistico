<?php
include '../BaseDeDatos/DataBase.php'; // Incluir el archivo de conexión

header('Content-Type: application/json'); // Establecer la cabecera de tipo de contenido

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Leer el ID del usuario desde las cookies
    if (isset($_COOKIE['user_id'])) {
        $userID = $_COOKIE['user_id'];

        // Consulta para obtener el IDUsuario usando el ID almacenado en la cookie
        $stmtUsuario = $conn->prepare("CALL obtenerIDUsuario(?)");
        $stmtUsuario->bind_param("i", $userID); // Usamos el valor de la cookie para la consulta
        $stmtUsuario->execute();
        $stmtUsuario->bind_result($idUsuario); // Vincular el resultado a la variable $idUsuario
        $stmtUsuario->fetch();
        $stmtUsuario->close();
    } else {
        echo json_encode(["status" => "error", "message" => "No se encontró la cookie de usuario."]);
        exit;
    }

    // Consultar el los pedidos enviados
    $stmt = $conn->prepare("CALL obtenerPedidosRecibir(?)");
    $stmt->bind_param("i", $idUsuario); // Usar el IDUsuario obtenido previamente
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si se obtuvieron resultados
    if ($result->num_rows > 0) {
        // Crear un array para almacenar los usuarios
        $recibidos = [];

        // Recorrer cada fila y agregar los pedidos enviados al array
        while ($row = $result->fetch_assoc()) {
            $recibidos[] = $row; // Agregar cada envio al array
        }

        // Convertir el array en formato JSON
        echo json_encode($recibidos); // Devolver los usuarios en formato JSON
    } else {
        // Si no se encontraron usuarios, devolver un array vacío
        echo json_encode([]); // Devolver un array vacío en caso de no encontrar usuarios
    }
}
// Cerrar la conexión
$conn->close(); // Cerrar la conexión a la base de datos
?>
