<?php
session_start();

if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    $correoUsuario = $usuario['correo'];
    $rolUsuario = $usuario['idRol'];
}else {
    header("Location: login.php");
    exit();
    }
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <!-- styles -->
    <?php $rutaCSS = 'css/404.css';
    include 'include/template/header.php'; ?>
</head>

<body>

    <main class="contenedor">
        <section class="hero">
            <h3 class="hero__error centrar-texto">Acceso Denegado</h3>
            <h3 class="hero__mensaje centrar-texto">Este usuario no tiene permitido esta vista</h3>
            <img class="hero__imagen" src="img/denegado.png" alt="page_not_fout">
        </section>
    </main>

</body>

</html>`