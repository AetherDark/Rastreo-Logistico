<?php
include 'DataBase.php'; // Incluir el archivo de conexión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar datos del formulario
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];

    // Preparar la consulta
    $stmt = $conn->prepare("SELECT * FROM Usuarios WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verificar la contraseña
        if (password_verify($password, $row['PasswordHash'])) {
            echo "Inicio de sesión exitoso. Bienvenido " . $row['NombreUsuario'];
            // Aquí puedes iniciar la sesión o redirigir al usuario a otra página
        } else {
            echo "Contraseña incorrecta";
        }
    } else {
        echo "No se encontró el usuario";
    }

    // Cerrar la declaración y la conexión
    $stmt->close();
}

$conn->close();
?>