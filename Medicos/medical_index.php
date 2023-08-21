<?php
 session_start();

if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    $correoUsuario = $usuario['correo'];
    $rolUsuario = $usuario['idRol'];
    $rol = $usuario['rol'];
    $id = $usuario['id'];
}
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['idRol'] != 2) {
    header("Location: acceso_denegado.php");
    exit();
} 
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <!-- styles -->
    <?php $rutaCSS = '../css/medical_styles.css';
    include '../include/template/header.php'; ?>
</head>

<body>
    <!-- Nav template -->
    <?php $enlaceActivo = 'medico';
    include '../include/template/nav.php'; ?>
 
      

        <!-- Footer -->
        <?php include '../include/template/footer.php'; ?>
        <!-- JS -->

</body>

</html>