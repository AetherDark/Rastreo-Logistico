<?php
$host = 'localhost'; // Cambia esto si tu servidor no está en localhost
$dbname = 'RegistroLogistico'; // Nombre de la base de datos
$user = ''; // Tu nombre de usuario de MySQL
$password = ''; // Tu contraseña de MySQL

// Crear conexión
$conn = new mysqli($host, $user, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>