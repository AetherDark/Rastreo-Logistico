<?php
$host = 'b0aksj8vnbgrjqf1hnl6-mysql.services.clever-cloud.com'; // Conexion a base de datos de remota
$dbname = 'b0aksj8vnbgrjqf1hnl6'; // Nombre de la base de datos
$user = 'udyqkxeukqobm1ci'; // Usuario para conectar a la base de datos
$password = 'Ro5jIojLNbBuTQoiMWfx'; // Contraseña del computador, cambiar dependiendo de quien la use

// Crear conexión
$conn = new mysqli($host, $user, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>