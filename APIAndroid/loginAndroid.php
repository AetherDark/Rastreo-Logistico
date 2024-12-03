<?php
include '../BaseDeDatos/DataBase.php'; // Incluye tu conexión a la base de datos

header('Content-Type: application/json'); // La respuesta será JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos enviados desde la app
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $email = $data['email'] ?? '';
    $password = $data['password'] ?? '';

    $stmt = $conn->prepare("CALL iniciarSesion(?, ?, @id, @nombreUsuario, @rolID, @nombreRol)");
    $stmt->bind_param("ss", $email, $password);

    if ($stmt->execute()) {
        $result = $conn->query("SELECT @id AS id, @nombreUsuario AS nombreUsuario, @rolID AS rolID, @nombreRol AS nombreRol");
        $row = $result->fetch_assoc();

        $id = $row['id'];
        $nombreUsuario = $row['nombreUsuario'];
        $rolID = $row['rolID'];
        $nombreRol = $row['nombreRol'];

        if ($rolID != 2)
        {
            echo json_encode(['success' => false, 'message' => 'Acceso denegado para este usuario.']);
            exit;
        }
    } else {
        echo "Error al ejecutar el procedimiento: " . $stmt->error;
    }

    
    // Devolver datos exitosos
    echo json_encode([
        'success' => true,
        'message' => 'Inicio de sesión exitoso.',
        'data' => [
            'id' => $row['id'],
            'nombreUsuario' =>$row['nombreUsuario'],
            'rolID' => $row['rolID'],
            'nombreRol' => $row['nombreRol']
        ]
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
}

$conn->close();
?>
