<?php
// Al hacer logout
setcookie("user_id", "", time() - 3600, "/"); // Expira la cookie inmediatamente
session_start();
session_destroy();
header("Location: ../InicioDeSesionORegistro/Sesion.html");
exit();
?>
