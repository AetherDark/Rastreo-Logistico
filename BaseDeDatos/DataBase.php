<?php
$host = 'bgk11a8tav2b4susudqe-mysql.services.clever-cloud.com'; // Conexion a base de datos de remota
$dbname = 'bgk11a8tav2b4susudqe'; // Nombre de la base de datos
$user = 'utvm65njmm5pm3se'; // Usuario para conectar a la base de datos
$password = 'JHYFvC3iTVrAp06AnqHS'; // Contraseña del computador, cambiar dependiendo de quien la use

// Crear conexión
$conn = new mysqli($host, $user, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>