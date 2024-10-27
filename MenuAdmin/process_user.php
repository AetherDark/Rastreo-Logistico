<?php
include('DataBase.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action === 'add') {
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $rol = $_POST['rol'];

        // Aquí deberías agregar validaciones y sanitización de datos
        $sql = "INSERT INTO Usuarios (NombreUsuario, Email, RolID, NombreRol) VALUES ('$nombre', '$email', (SELECT ID FROM Roles WHERE Nombre = '$rol'), '$rol')";

        if ($conn->query($sql) === TRUE) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $conn->error]);
        }
    } elseif ($action === 'delete') {
        $id = $_POST['id'];

        $sql = "DELETE FROM Usuarios WHERE ID = $id";

        if ($conn->query($sql) === TRUE) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $conn->error]);
        }
    }
}
?>