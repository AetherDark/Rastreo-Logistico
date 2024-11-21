<?php
// FormularioPedido.php
include '../Base de datos/DataBase.php'; // Conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Inicia la sesión y verifica que exista la cookie del usuario
    session_start();
    if (!isset($_COOKIE['user_id'])) {
        die("Error: Usuario no autenticado.");
    }

    // Obtiene el ID del usuario desde la cookie
    $usuarioID = $_COOKIE['user_id'];

    // Recibe y sanitiza los datos del formulario
    $destinatario = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
    $direccionDestino = filter_input(INPUT_POST, 'direccion', FILTER_SANITIZE_STRING);
    $descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_STRING);

    if (!$destinatario || !$direccionDestino || !$descripcion) {
        die("Error: Todos los campos son obligatorios.");
    }

    // Valor predeterminado del estado del pedido
    $estadoActual = "Paquete en proceso";

    // Prepara la consulta SQL para insertar el pedido
    $stmt = $conn->prepare(
        "INSERT INTO Pedidos (UsuarioID, Destinatario, DireccionDestino, Descripcion, EstadoActual) VALUES (?, ?, ?, ?, ?)"
    );
    $stmt->bind_param("issss", $usuarioID, $destinatario, $direccionDestino, $descripcion, $estadoActual);

    // Ejecuta la consulta y verifica si fue exitosa
    if ($stmt->execute()) {
        // Redirigir o mostrar mensaje
        header("Location: ../MenuUsuario/FormularioEnviar.html?Enviado=1");
    } else {
        header("Location: ../MenuUsuario/FormularioEnviar.html?NoEnviado=1");
    }

    // Cierra la conexión
    $stmt->close();
    $conn->close();
} else {
    echo "Método no permitido.";
}
?>
