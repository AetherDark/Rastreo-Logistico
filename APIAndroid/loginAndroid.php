<?php
include '../BaseDeDatos/DataBase.php'; // Incluye tu conexión a la base de datos

header('Content-Type: application/json'); // La respuesta será JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos enviados desde la app
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $email = $data['email'] ?? '';
    $password = $data['password'] ?? '';

    if (empty($email) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Email o contraseña faltantes.']);
        exit;
    }

    // Consultar el usuario en la base de datos
    $stmt = $conn->prepare("SELECT ID, NombreUsuario, PasswordHash, RolID FROM Usuarios WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo json_encode(['success' => false, 'message' => 'Usuario no encontrado.']);
        exit;
    }

    $user = $result->fetch_assoc();

    // Verificar la contraseña
    if (!password_verify($password, $user['PasswordHash'])) {
        echo json_encode(['success' => false, 'message' => 'Contraseña incorrecta.']);
        exit;
    }

    // Validar el rol del usuario (ejemplo: solo repartidores con RolID = 2)
    if ($user['RolID'] != 2) {
        echo json_encode(['success' => false, 'message' => 'Acceso denegado para este usuario.']);
        exit;
    }

    // Devolver datos exitosos
    echo json_encode([
        'success' => true,
        'message' => 'Inicio de sesión exitoso.',
        'data' => [
            'id' => $user['ID'],
            'nombreUsuario' => $user['NombreUsuario'],
            'email' => $email,
            'rolID' => $user['RolID']
        ]
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
}

$conn->close();
?>
