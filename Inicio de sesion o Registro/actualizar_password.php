<?php
include '../Base de datos/DataBase.php'; // Conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email']) && isset($_POST['token'])) {
    $email = htmlspecialchars($_POST['email']);
    $token = htmlspecialchars($_POST['token']);
    $nueva_contrasena = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hashear la nueva contraseña

    // Verificar si el token es válido y pertenece al email
    $stmt = $conn->prepare("SELECT * FROM PasswordResets WHERE Email = ? AND Token = ?");
    $stmt->bind_param("ss", $email, $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Token válido, actualizar la contraseña del usuario
        $stmt = $conn->prepare("UPDATE Usuarios SET PasswordHash = ? WHERE Email = ?");
        $stmt->bind_param("ss", $nueva_contrasena, $email);
        $stmt->execute();

        // Eliminar el token después de haber cambiado la contraseña
        $stmt = $conn->prepare("DELETE FROM PasswordResets WHERE Email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        header("Location: Sesion.html?Cambio-Pass=1");
    } else {
        header("Location: cambiar_password.html?Error-Cambio-Pass=1");
    }
} else {
    echo "Solicitud inválida.";
}
?>
