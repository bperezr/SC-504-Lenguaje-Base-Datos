<?php
session_start();

if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    $rolUsuario = $usuario['idRol'];
    $rol = $usuario['rol'];
    $id = $usuario['id'];

    $volver = "";

    switch ($rolUsuario) {
        case 1:
            $volver = "admin/admin_index.php";
            break;
        case 2:
            $volver = "medical/medical_index.php";
            break;
        case 3:
            $volver = "index.php";
            break;
        default:
            $volver = "index.php";
    }
} elseif (!isset($_SESSION['usuario']) && basename($_SERVER['PHP_SELF']) != 'index.php') {
    header("Location: index.php");
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
            <h3 class="hero__mensaje centrar-texto">No tiene permitido esta vista</h3>
            <div class="imagen-contenedor">
                <img class="hero__imagen2 reducida" src="img/denegado.png" alt="page_not_found">
            </div>
            <a class="boton centrar-texto" href="<?php echo $volver ?>">Volver al inicio</a>
        </section>
    </main>

</body>

</html>`