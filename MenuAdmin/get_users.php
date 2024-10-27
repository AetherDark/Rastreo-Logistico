<?php
include('DataBase.php');

$sql = "SELECT ID, NombreUsuario, Email, NombreRol FROM Usuarios";
$result = $conn->query($sql);

$users = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

echo json_encode($users);
?>
