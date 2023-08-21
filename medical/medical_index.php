<?php
session_start();

require_once '../include/database/db_config.php';
require_once '../include/database/db_cita.php';

if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    $correoUsuario = $usuario['correo'];
    $rolUsuario = $usuario['idRol'];
    $rol = $usuario['rol'];
    $id = $usuario['id'];
}
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['idRol'] != 2) {
    header("Location: ../acceso_denegado.php");
    exit();
}

$cita = new Cita();

$citaDetalle = $cita->getDetalleCitaMedico($id);

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
     <?php include '../include/template/footer2.php'; ?> 
    <!-- JS -->
</body>

</html>