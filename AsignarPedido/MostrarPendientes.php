<?php
include '../BaseDeDatos/DataBase.php'; // Incluir el archivo de conexión

header('Content-Type: application/json'); // Establecer la cabecera de tipo de contenido

    // Consultar el los pedidos enviados
    $stmt = $conn->prepare("SELECT ID, NombreUsuario, Destinatario, Descripcion FROM vista_pedidos_en_proceso");
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si se obtuvieron resultados
    if ($result->num_rows > 0) {
        // Crear un array para almacenar los usuarios
        $pendientes = [];

        // Recorrer cada fila y agregar los pedidos enviados al array
        while ($row = $result->fetch_assoc()) {
            $pendientes[] = $row; // Agregar cada envio al array
        }

        // Convertir el array en formato JSON
        echo json_encode($pendientes); // Devolver los usuarios en formato JSON
    } else {
        // Si no se encontraron usuarios, devolver un array vacío
        echo json_encode([]); // Devolver un array vacío en caso de no encontrar usuarios
    }
// Cerrar la conexión
$conn->close(); // Cerrar la conexión a la base de datos
?>
