<?php
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
    <?php $enlaceActivo = 'surgery';
    include 'include/template/nav.php'; ?>

    <div class="contenedor">

        <main class="informacion ">
            <article class="entrada">
                <h1 class="centrar-texto no-margin">Cirugía</h1>
                <img class="service_icon" src="img/s2.svg" alt="icono">
                <p class="justificar-texto">En Happy Paws, entendemos que hay momentos en la vida de nuestras mascotas
                    en los que pueden requerir intervenciones quirúrgicas para mejorar su salud y calidad de vida.
                    Nuestro servicio de Cirugía está respaldado por un equipo de cirujanos veterinarios altamente
                    capacitados y con experiencia, así como por instalaciones modernas y equipamiento médico de
                    vanguardia. Nos comprometemos a brindar procedimientos quirúrgicos seguros y efectivos para gatos y
                    perros, siempre enfocados en el bienestar y comodidad de nuestros pacientes.</p>
            </article><!-- Texto 1 -->
            <article class="entrada">
                <h2 class="centrar-texto">Sobre el servicio</h2>
                <li>Cirugías de tejidos blandos</li>
                <li>Cirugías ortopédicas para el tratamiento de lesiones musculoesqueléticas.</li>
                <li>Procedimientos quirúrgicos para el manejo de afecciones gastrointestinales.</li>
                <li>Extracción de cuerpos extraños y tratamientos para obstrucciones.</li>
                <li>Cirugía reconstructiva y de heridas para una rápida recuperación.</li>
                <li>Procedimientos oftalmológicos para problemas oculares.</li>
                <li>Intervenciones quirúrgicas para el tratamiento de tumores y masas.</li>
                <li>Cirugías dentales y extracción de dientes problemáticos.</li>
                <li>Asistencia y apoyo durante el proceso preoperatorio y postoperatorio.</li>
                <li>Uso de anestesia segura y monitoreo constante durante los procedimientos.</li>
                <img class="imagen" src="img/img_4.jpeg" alt="">
            </article><!-- Texto 2 -->
            <div class="enlace contenedor">
                <a class="boton centrar-texto" href="services.php">Mas servicios</a>
            </div>
        </main>

        <!-- Cita -->

    </div>

    <!-- Footer -->
    <?php include 'include/template/footer.php'; ?>
    <!-- JS -->
    <script src="js/cita.js"></script>
</body>

</html>