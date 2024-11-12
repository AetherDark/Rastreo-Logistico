<?php
include '../Base de datos/DataBase.php'; // Incluir el archivo de conexión

// Verificar si la conexión es exitosa
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error); // Mostrar mensaje de error si la conexión falla
}

// Consulta de los usuarios de la base de datos
$sql = "SELECT ID, NombreUsuario, Email, NombreRol FROM Usuarios"; // Consulta SQL para obtener los usuarios
$result = $conn->query($sql); // Ejecutar la consulta

// Verificar si se obtuvieron resultados
if ($result->num_rows > 0) {
    // Crear un array para almacenar los usuarios
    $users = [];

    // Recorrer cada fila y agregar los usuarios al array
    while ($row = $result->fetch_assoc()) {
        $users[] = $row; // Agregar cada usuario al array
    }

    // Convertir el array en formato JSON
    echo json_encode($users); // Devolver los usuarios en formato JSON
} else {
    // Si no se encontraron usuarios, devolver un array vacío
    echo json_encode([]); // Devolver un array vacío en caso de no encontrar usuarios
}

// Cerrar la conexión
$conn->close(); // Cerrar la conexión a la base de datos
?>
