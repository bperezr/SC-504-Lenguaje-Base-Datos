<?php
session_start();

if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    $correoUsuario = $usuario['correo'];
    $rolUsuario = $usuario['idRol'];
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
    <?php $enlaceActivo = 'medical_check';
    include 'include/template/nav.php'; ?>

    <div class="contenedor">

        <main class="informacion ">
            <article class="entrada">
                <h1 class="centrar-texto no-margin">Medicina General</h1>
                <img class="service_icon" src="img/s1.svg" alt="icono">
                <p class="justificar-texto">En nuestro servicio de Medicina General, nos preocupamos por la salud
                    integral de tus queridas mascotas. Nuestro equipo de veterinarios altamente capacitados y con
                    experiencia se dedica a brindar diagnósticos precisos y tratamientos efectivos para una amplia
                    variedad de condiciones médicas en gatos y perros. Desde exámenes de rutina hasta el manejo de
                    enfermedades crónicas, estamos comprometidos a proporcionar el más alto nivel de atención y cuidado
                    para garantizar el bienestar de tus adorables compañeros.</p>
            </article><!-- Texto 1 -->
            <article class="entrada">
                <h2 class="centrar-texto">Sobre el servicio</h2>
                <li>Consultas médicas completas para gatos y perros.</li>
                <li>Diagnóstico y tratamiento de enfermedades y condiciones médicas.</li>
                <li>Exámenes de rutina y chequeos de salud.</li>
                <li>Administración de vacunas y desparasitación.</li>
                <li>Control y prevención de enfermedades parasitarias.</li>
                <li>Manejo de problemas de piel y alergias.</li>
                <li>Cuidados geriátricos y atención para mascotas mayores.</li>
                <li>Asesoramiento sobre nutrición y dietas especiales.</li>
                <li>Orientación sobre el bienestar y cuidado preventivo.</li>
                <li>Atención y seguimiento postoperatorio para cirugías menores.</li>
                <img class="imagen" src="img/img_5.jpg" alt="">
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