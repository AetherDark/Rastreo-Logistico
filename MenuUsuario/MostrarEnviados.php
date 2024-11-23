<?php
include '../BaseDeDatos/DataBase.php'; // Incluir el archivo de conexión

header('Content-Type: application/json'); // Establecer la cabecera de tipo de contenido

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Leer el ID del usuario desde las cookies
    if (isset($_COOKIE['user_id'])) {
        $userID = $_COOKIE['user_id'];
    } else {
        echo json_encode(["status" => "error", "message" => "No se encontró la cookie de usuario."]);
        exit;
    }


    // Consultar el los pedidos enviados
    $stmt = $conn->prepare("SELECT ID, Descripcion, Destinatario FROM Pedidos WHERE UsuarioID = ?");
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si se obtuvieron resultados
    if ($result->num_rows > 0) {
        // Crear un array para almacenar los usuarios
        $enviados = [];

        // Recorrer cada fila y agregar los pedidos enviados al array
        while ($row = $result->fetch_assoc()) {
            $enviados[] = $row; // Agregar cada envio al array
        }

        // Convertir el array en formato JSON
        echo json_encode($enviados); // Devolver los usuarios en formato JSON
    } else {
        // Si no se encontraron usuarios, devolver un array vacío
        echo json_encode([]); // Devolver un array vacío en caso de no encontrar usuarios
    }
}
// Cerrar la conexión
$conn->close(); // Cerrar la conexión a la base de datos
?>
