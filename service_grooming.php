<?php
require_once 'include/functions/auth.php';
session_start();

if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    $correoUsuario = $usuario['correo'];
    $rolUsuario = $usuario['idRol'];
    $rol = $usuario['rol'];
    $id = $usuario['id'];
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
    <?php $enlaceActivo = 'grooming';
    include 'include/template/nav.php'; ?>

    <div class="contenedor">

        <main class="informacion ">
            <article class="entrada">
                <h1 class="centrar-texto no-margin">Aseo</h1>
                <img class="service_icon" src="img/s4.svg" alt="icono">
                <p class="justificar-texto">
                    En Happy Paws, sabemos lo importante que es mantener a tus mascotas con una apariencia y sensación
                    fresca y saludable. Nuestro servicio de Aseo y Estética está diseñado para consentir a tus adorables
                    compañeros peludos y brindarles un cuidado completo para que luzcan y se sientan increíbles. Nuestro
                    equipo de estilistas y cuidadores expertos se asegurará de que tu mascota tenga una experiencia
                    relajante y agradable mientras se somete a los tratamientos de aseo.
                </p>
            </article><!-- Texto 1 -->
            <article class="entrada">
                <h2 class="centrar-texto">Sobre el servicio</h2>
                <li>Baño completo con productos de alta calidad.</li>
                <li>Corte de pelo y peinado.</li>
                <li>Limpieza y cuidado de oídos y ojos.</li>
                <li>Corte de uñas para evitar que crezcan en exceso y causen molestias.</li>
                <li>Desenredado y deslanado para eliminar el pelo muerto y nudos.</li>
                <li>Perfumería y fragancias para que tu mascota huela delicioso.</li>
                <li>Tratamientos especiales para hidratar y nutrir la piel y el pelaje.</li>
                <li>Servicios de arreglo y estilismo para ocasiones especiales.</li>
                <li>Asesoramiento sobre el cuidado y mantenimiento del pelaje y la piel entre las sesiones de aseo.</li>
                <img class="imagen" src="img/img_11.jpg" alt="">
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