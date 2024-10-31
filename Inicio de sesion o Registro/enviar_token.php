<?php
include '../Base de datos/DataBase.php'; // Conexión a la base de datos

// Incluir PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars($_POST['email']);

    // Verificar si el email existe en la base de datos de usuarios
    $stmt = $conn->prepare("SELECT * FROM Usuarios WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Generar un token único
        $token = bin2hex(random_bytes(4)); // Token de 8 caracteres en formato hexadecimal

        // Insertar o actualizar el token en la tabla PasswordResets
        $stmt = $conn->prepare("INSERT INTO PasswordResets (Email, Token) VALUES (?, ?) 
                                ON DUPLICATE KEY UPDATE Token = ?, FechaCreacion = NOW()");
        $stmt->bind_param("sss", $email, $token, $token);
        $stmt->execute();

        // Guardar el token en la sesión para usarlo en la página de verificación (opcional)
        session_start();
        $_SESSION['email'] = $email;
        $_SESSION['token'] = $token;

        // Crear una nueva instancia de PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor
            $mail->isSMTP();                                            // Enviar usando SMTP
            $mail->Host       = 'smtp-mail.outlook.com';                   // Establecer el servidor SMTP
            $mail->SMTPAuth   = true;                                 // Habilitar autenticación SMTP
            $mail->Username   = 'traceandtrackcorp@outlook.com';             // Tu correo electrónico
            $mail->Password   = 'zidcxiptxpncqfcl';                      // Tu contraseña de correo
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;      // Habilitar cifrado TLS
            $mail->Port       = 587;                                  // Puerto TCP para TLS

            // Destinatarios
            $mail->setFrom('traceandtrackcorp@outlook.com', 'Trace&Track'); // De
            $mail->addAddress($email);                                 // Para

            // Contenido del correo
            $mail->isHTML(true);                                      // Establecer el formato de correo como HTML
            $mail->Subject = 'Código de recuperación de contraseña';
            $mail->Body    = 'Tu código de recuperación es: ' . $token;

            // Enviar correo
            $mail->send();

            // Redirigir a la página de cambio de contraseña
            header("Location: cambiar_password.html?token=1");
            exit(); // Asegúrate de detener la ejecución después de la redirección

        } catch (Exception $e) {
            header("Location: recuperar_password.html?Error-Token=1");
        }
        
    } else {
        header("Location: recuperar_password.html?no-registrado=1");
    }
}
?>
