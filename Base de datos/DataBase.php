<?php
$host = 'localhost'; // Conexion a base de datos de manera local en MySQL
$dbname = 'RastreoLogistico'; // Nombre de la base de datos
$user = 'root'; // Usuario para conectar a la base de datos
$password = ''; // Contraseña del computador, cambiar dependiendo de quien la use

// Crear conexión
$conn = new mysqli($host, $user, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>