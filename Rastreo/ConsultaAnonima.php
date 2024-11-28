<?php
// ConsultaAnonima.php
if (isset($_POST['tracking-code'])) {
    // Obtener el valor del código de rastreo
    $trackingCode = $_POST['tracking-code'];

    // Almacenar el código de rastreo en una cookie (expira en 1 hora)
    setcookie("trackingCode", $trackingCode, time() + 3600, "/");

    // Redirigir al RastreoAnonimo.html
    header("Location: RastreoAnonimo.html");
    exit();
} else {
    echo "Por favor ingresa un código de rastreo válido.";
}
?>
