<?php
// En el archivo donde se maneja la sesión y el cierre de sesión (por ejemplo, logout.php)
session_start();
session_unset();
session_destroy();
header("Location: login.php"); // Cambia "index.php" por la página a la que deseas redirigir
exit();
?>