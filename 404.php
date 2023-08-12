<?php
session_start();

if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    $correoUsuario = $usuario['correo'];
    $rolUsuario = $usuario['idRol'];
    $rol = $usuario['rol'];
    $id = $usuario['id'];

    $volver = "";

    switch ($rolUsuario) {
        case 1:
            $volver = "admin_index.php";
            break;
        case 2:
            $volver = "medical_index.php";
            break;
        case 3:
            $volver = "index.php";
            break;
        default:
            $volver = "index.php";
            exit();
    }
} elseif (!isset($_SESSION['usuario']) && basename($_SERVER['PHP_SELF']) == 'index.php') {
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
            <h1 class="hero__error centrar-texto">404</h1>
            <h2 class="hero__mensaje centrar-texto">¡Ups! Página no encontrada</h2>
            <div class="imagen-contenedor">
                <img class="hero__imagen apliada" src="img/en_costruccion.png" alt="page_not_fout">
            </div>
            <a class="boton centrar-texto" href="index.php">Volver al inicio</a>
        </section>
    </main>


</body>

</html>`