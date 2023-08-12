<?php
require_once 'include/functions/auth.php';
session_start();

if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    $correoUsuario = $usuario['correo'];
    $rolUsuario = $usuario['idRol'];

    if (!validarAcceso(basename(__FILE__), $rolUsuario)) {
        header("Location: acceso_denegado.php");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
echo $rolUsuario;
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <!-- styles -->
    <?php $rutaCSS = 'css/medical_styles.css';
    include 'include/template/header.php'; ?>
</head>

<body>
    <!-- Nav template -->
    <?php $enlaceActivo = 'medico';
    include 'include/template/nav.php'; ?>

    <main class="contenedor">
        <div class="bg">
            <h1 class="centrar-texto">Panel Médico</h1>
            <div class="bg_img">
                <img src="img/logo_color.svg" alt="Happy Paws">
            </div>
        </div>
    </main>

    <!-- Footer -->
    <?php include 'include/template/footer.php'; ?>
    <!-- JS -->
</body>

</html>