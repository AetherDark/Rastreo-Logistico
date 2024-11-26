<?php
// FormularioPedido.php
include '../BaseDeDatos/DataBase.php'; // Conexión a la base de datos

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

    // Generar un ID aleatorio de 10 dígitos
    do {
        $pedidoID = mt_rand(1000000000, 9999999999);
        $result = $conn->query("SELECT 1 FROM Pedidos WHERE ID = $pedidoID");
    } while ($result && $result->num_rows > 0);
    
    // Valor predeterminado del estado del pedido
    $estadoActual = "Paquete en proceso";

    // Prepara la consulta SQL para insertar el pedido
    $stmt = $conn->prepare(
        "INSERT INTO Pedidos (ID, UsuarioID, Destinatario, DireccionDestino, Descripcion, EstadoActual) VALUES (?, ?, ?, ?, ?, ?)"
    );
    $stmt->bind_param("iissss",$pedidoID, $usuarioID, $destinatario, $direccionDestino, $descripcion, $estadoActual);

    // Ejecuta la consulta y verifica si fue exitosa
    if ($stmt->execute()) {
        // Redirigir o mostrar mensaje
        header("Location: FormularioEnviar.html?Enviado=1");
    } else {
        header("Location: FormularioEnviar.html?NoEnviado=1");
    }

    // Cierra la conexión
    $stmt->close();
    $conn->close();
} else {
    header("Location: FormularioEnviar.html?NoEnviado=1");
}
?>
