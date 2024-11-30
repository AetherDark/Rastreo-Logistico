<?php
include '../BaseDeDatos/DataBase.php'; // Incluir el archivo de conexión

header('Content-Type: application/json'); // Establecer la cabecera de tipo de contenido

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Consultar todos los pedidos enviados
    $stmt = $conn->prepare("SELECT Pedidos.ID, Pedidos.Descripcion, Pedidos.DireccionDestino, Pedidos.EstadoActual FROM Pedidos
    WHERE Pedidos.EstadoActual NOT IN ('Entregado', 'Extraviado', 'Cancelado')");
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si se obtuvieron resultados
    if ($result->num_rows > 0) {
        // Crear un array para almacenar los pedidos enviados
        $enviados = [];

        // Recorrer cada fila y agregar los pedidos enviados al array
        while ($row = $result->fetch_assoc()) {
            $enviados[] = $row; // Agregar cada pedido al array
        }

        // Convertir el array en formato JSON
        echo json_encode($enviados); // Devolver los pedidos enviados en formato JSON
    } else {
        // Si no se encontraron pedidos, devolver un array vacío
        echo json_encode([]); // Devolver un array vacío en caso de no encontrar pedidos
    }
}
// Cerrar la conexión
$conn->close(); // Cerrar la conexión a la base de datos
?>
