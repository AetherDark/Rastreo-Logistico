<?php
// Al hacer logout
setcookie("user_id", "", time() - 3600, "/"); // Expira la cookie inmediatamente
session_start();
session_destroy();
header("Location: ../Inicio de sesion o Registro/Sesion.html");
exit();
?>
