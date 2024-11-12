<?php
include '../Base de datos/DataBase.php'; // Incluir el archivo de conexión

// Verificar si la conexión es exitosa
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta de los usuarios de la base de datos
$sql = "SELECT ID, NombreUsuario, Email, NombreRol FROM Usuarios";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Crear un array para almacenar los usuarios
    $users = [];

    // Recorrer cada fila y agregar los usuarios al array
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }

    // Convertir el array en formato JSON
    echo json_encode($users);
} else {
    echo json_encode([]);
}

$conn->close();
?>
