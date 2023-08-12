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
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <!-- styles -->
    <?php $rutaCSS = 'css/services_info.css';
    include 'include/template/header.php'; ?>
</head>

<body>
    <!-- Nav template -->
    <?php $enlaceActivo = 'neutering';
    include 'include/template/nav.php'; ?>

    <div class="contenedor">

        <main class="informacion ">
            <article class="entrada">
                <h1 class="centrar-texto no-margin">Castración</h1>
                <img class="service_icon" src="img/s3.svg" alt="icono">
                <p class="justificar-texto">
                    En Happy Paws, reconocemos la importancia de la castración como una medida
                    responsable y beneficiosa para el bienestar de nuestros amigos peludos. Nuestro servicio de
                    Castración está diseñado para gatos y perros, con el objetivo de controlar la población de animales
                    y proteger su salud a lo largo de sus vidas. Nuestro equipo de veterinarios altamente capacitados
                    realiza procedimientos de castración con cuidado y amor, garantizando el máximo confort y seguridad
                    para nuestras mascotas.
                </p>
            </article><!-- Texto 1 -->
            <article class="entrada">
                <h2 class="centrar-texto">Sobre el servicio</h2>
                <li>Castración para gatos y perros machos y hembras.</li>
                <li>Beneficios de la castración en la prevención de enfermedades y comportamientos no deseados.</li>
                <li>Promoción de la salud y bienestar a lo largo de la vida de la mascota.</li>
                <li>Reducción del riesgo de cáncer y enfermedades relacionadas con el sistema reproductivo.</li>
                <li>Contribución a la reducción de la superpoblación animal y el bienestar de la comunidad.</li>
                <li>Procedimiento quirúrgico seguro y eficiente con técnicas modernas y anestesia adecuada.</li>
                <li>Apoyo y cuidado postoperatorio para asegurar una recuperación rápida y sin complicaciones.</li>
                <li>Asesoramiento sobre el manejo y cuidado de la mascota después de la castración.</li>
                <img class="imagen" src="img/img_2.jpg" alt="">
            </article><!-- Texto 2 -->
            <div class="enlace contenedor">
                <a class="boton centrar-texto" href="services.php">Mas servicios</a>
            </div>
        </main>

        <!-- Cita -->
        <?php include 'include/template/cita.php'; ?>
    </div>

    <!-- Footer -->
    <?php include 'include/template/footer.php'; ?>
    <!-- JS -->
    <script src="js/cita.js"></script>
</body>

</html>