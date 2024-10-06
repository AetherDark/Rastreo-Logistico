<?php
$host = '34.46.18.18'; // Cambia esto si tu servidor no está en localhost
$dbname = 'RegistroLogistico'; // Nombre de la base de datos
$user = 'jaret'; // Tu nombre de usuario de MySQL
$password = 'J@ret5478'; // Tu contraseña de MySQL

// Crear conexión
$conn = new mysqli($host, $user, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>