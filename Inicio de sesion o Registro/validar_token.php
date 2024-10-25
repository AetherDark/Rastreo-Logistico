<?php
include '../Base de datos/DataBase.php'; // Conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['email']) && isset($_GET['token'])) {
    $email = htmlspecialchars($_GET['email']);
    $token = htmlspecialchars($_GET['token']);

    // Verificar si el token es válido y no ha expirado (en este caso, 30 minutos)
    $stmt = $conn->prepare("SELECT * FROM PasswordResets WHERE Email = ? AND Token = ? AND FechaCreacion >= NOW() - INTERVAL 30 MINUTE");
    $stmt->bind_param("ss", $email, $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Token válido, redirigir al formulario de actualización de contraseña
        header("Location: actualizar_password.php?email=" . urlencode($email) . "&token=" . urlencode($token));
        exit();
    } else {
        echo "El enlace ha expirado o es inválido.";
    }
} else {
    echo "Solicitud inválida.";
}
?>
