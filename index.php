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
    <?php $rutaCSS = 'css/styles.css';
    include 'include/template/header.php'; ?>
</head>

<body>
    <!-- Nav template -->
    <?php $enlaceActivo = '';
    include 'include/template/nav.php'; ?>

    <main class="contenedor">
        <!-- Banner -->
        <div class="contenedor seccion2">
            <div class="contenedor__sec">
                <h1>Dedicados a la salud y bienestar de tus mejores amigos</h1>
                <p class="justificar-texto">Nuestro equipo apasionado está
                    aquí para brindarles el cuidado más excepcional y
                    cariñoso. Porque
                    sabemos que ellos son más que mascotas, ¡son tus mejores
                    amigos! Confía en nosotros para cuidarlos y
                    amarlos como si fueran nuestros propios peludos.
                    ¡Juntos, crearemos una vida llena de alegría y
                    salud para tus adorables compañeros en Happy Paws!</p>
                <div class="enlace contenedor">
                    <a class="boton centrar-texto" href="contact.php">Contáctenos</a>
                </div>
            </div>
            <div class="contenedor__sec">
                <img src="img/home5.png" alt>
            </div>
        </div>

        <!-- Contacto -->
        <div class="contenedor seccion3">
            <div class="contenedor__sec3">
                <div class="sec3__item">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-address-book" width="60"
                        height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M20 6v12a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2z" />
                        <path d="M10 16h6" />
                        <path d="M13 11m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                        <path d="M4 8h3" />
                        <path d="M4 12h3" />
                        <path d="M4 16h3" />
                    </svg>
                </div>
                <div class="sec3__item">
                    <h3>Contáctenos</h3>
                    <p><ion-icon name="mail-sharp"></ion-icon>
                        happyPaws@email.com</p>
                    <p><ion-icon name="call-sharp"></ion-icon> +506
                        2532-3577</p>
                </div>
            </div>

            <div class="contenedor__sec3">
                <div class="sec3__item">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clock-hour-4" width="60"
                        height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                        <path d="M12 12l3 2" />
                        <path d="M12 7v5" />
                    </svg>
                </div>
                <div class="sec3__item">
                    <h3>Horario</h3>
                    <p>Lunes a Viernes: </p>
                    <p>8:00 AM a 5:00 AM</p>
                </div>
            </div>

            <div class="contenedor__sec3">
                <div class="sec3__item">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-map-2" width="60"
                        height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 18.5l-3 -1.5l-6 3v-13l6 -3l6 3l6 -3v7.5" />
                        <path d="M9 4v13" />
                        <path d="M15 7v5.5" />
                        <path
                            d="M21.121 20.121a3 3 0 1 0 -4.242 0c.418 .419 1.125 1.045 2.121 1.879c1.051 -.89 1.759 -1.516 2.121 -1.879z" />
                        <path d="M19 18v.01" />
                    </svg>
                </div>
                <div class="sec3__item">
                    <h3>Ubicación</h3>
                    <p>Calle 0, Avenida 0.</p>
                    <p><ion-icon name="navigate-circle-sharp"></ion-icon>
                        San José, Costa Rica.</p>
                </div>
            </div>
        </div>

        <!-- Servicios -->
        <div class="contenedor seccion4">
            <h1 class="centrar-texto padding2">Nuestros servicios</h1>
            <a href="services.php">
                <div class="contenedor__sec4">
                    <div class="service__card">
                        <div class="service_icon">
                            <img src="img/s1.svg" alt>
                        </div>

                        <div class="service_text">
                            <h3>Medicina General</h3>
                        </div>
                    </div>
                </div>

                <div class="contenedor__sec4">
                    <div class="service__card">
                        <div class="service_icon">
                            <img src="img/s2.svg" alt>
                        </div>

                        <div class="service_text">
                            <h3>Cirugía</h3>
                        </div>
                    </div>
                </div>

                <div class="contenedor__sec4">

                    <div class="service__card">
                        <div class="service_icon">
                            <img src="img/s3.svg" alt>
                        </div>

                        <div class="service_text">
                            <h3>Castración</h3>
                        </div>
                    </div>

                </div>

                <div class="contenedor__sec4">
                    <div class="service__card">
                        <div class="service_icon">
                            <img src="img/s4.svg" alt>
                        </div>

                        <div class="service_text">
                            <h3>Aseo</h3>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Nosotros -->
        <div class="contenedor">
            <div class="contenedor__sec5">
                <div class="sec5__item">
                    <h2 class="centrar-texto">Sobre nosotros</h2>
                    <p class="justificar-texto">En Happy Paws, nos apasiona el bienestar y la felicidad de todas las
                        mascotas. Nuestro equipo de profesionales altamente comprometidos está dedicado a brindarles el
                        mejor cuidado y amor. Creemos que las mascotas no son solo animales, son miembros valiosos de
                        nuestras familias y merecen la atención más excepcional.</p>
                    <ul><ion-icon name="checkmark-done-circle-outline"></ion-icon> Atención médica integral para tus
                        mascotas.</ul>
                    <ul><ion-icon name="checkmark-done-circle-outline"></ion-icon> Equipo de veterinarios altamente
                        capacitados.</ul>
                    <ul><ion-icon name="checkmark-done-circle-outline"></ion-icon> Servicios de castración y cuidados
                        estéticos.</ul>
                    <div class="enlace contenedor">
                        <a class="boton centrar-texto" href="about.php">Más acerca de nosotros</a>
                    </div>
                </div>
                <div class="sec5__item">
                    <img src="img/home1.png" alt="imagen" class="imgamen">
                </div>
            </div>
        </div>
    </main>

    <!-- Footer template-->
    <?php include 'include/template/footer.php'; ?>
    <!-- JS -->
</body>

</html>