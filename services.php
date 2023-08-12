<?php
require_once 'include/functions/auth.php';
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
    <?php $rutaCSS = 'css/services.css';
    include 'include/template/header.php'; ?>
</head>

<body>
    <!-- Nav template -->
    <?php $enlaceActivo = 'services';
    include 'include/template/nav.php'; ?>

    <main class="contenedor">

        <div class="info">
            <h1 class="centrar-texto padding-bajo">Servicios</h1>
            <h3 class="centrar-texto padding-bajo">
                ¡Bienvenido a nuestros servicios de cuidado y bienestar para tus adorables compañeros en Happy Paws!
            </h3>
            <p class="justificar-texto">
                En Happy Paws, entendemos que tus mascotas merecen lo mejor en términos de atención y cariño. Es por eso
                que nos enorgullecemos de ofrecer una amplia gama de servicios veterinarios diseñados para mantener a
                tus peludos amigos felices, saludables y llenos de vitalidad.
            </p>
            <p class="justificar-texto">
                Nuestro equipo de veterinarios altamente calificados está comprometido con brindar la mejor atención
                médica a tus mascotas. Desde servicios de Medicina General y Cirugía hasta opciones de Castración y
                cuidado de Aseo y Estética, nos aseguramos de que cada aspecto de su bienestar esté cubierto con
                profesionalismo y dedicación.
            </p>
            <p class="justificar-texto">
                En Happy Paws, tratamos a tus mascotas como si fueran nuestras propias, y trabajamos incansablemente
                para mantener su calidad de vida en su máximo potencial. Tu confianza en nosotros es nuestra mayor
                recompensa, y esperamos seguir cuidando y protegiendo el bienestar de tus fieles compañeros.
            </p>
            <p class="justificar-texto padding-bajo">
                ¡Únete a nuestra comunidad y déjanos ser parte del camino hacia la salud y felicidad de tus amados
                amigos peludos!
            </p>
        </div>

        <section class="service">
            <a href="service_medical_check.php">
                <div class="service__card">
                    <div class="service_icon">
                        <img src="img/s1.svg" alt="">
                    </div>

                    <div class="service_text">
                        <h3 class="centrar-texto">Medicina General</h3>
                        <p class="justificar-texto">
                            Nuestro servicio de Medicina General ofrece atención médica integral para tus mascotas,
                            incluyendo chequeos regulares, vacunación, diagnóstico y tratamiento de enfermedades
                            comunes, y cuidados preventivos para mantener su salud en óptimas condiciones.
                        </p>
                    </div>
                </div>
            </a>

            <a href="service_surgery.php">
                <div class="service__card">
                    <div class="service_icon">
                        <img src="img/s2.svg" alt="">
                    </div>

                    <div class="service_text">
                        <h3 class="centrar-texto">Cirugía</h3>
                        <p class="justificar-texto">
                            En Happy Paws, contamos con un equipo de veterinarios altamente capacitados que realizan
                            cirugías seguras y efectivas para tratar diversas condiciones médicas en tus mascotas,
                            siempre priorizando su bienestar y recuperación.
                        </p>
                    </div>
                </div>
            </a>

            <a href="service_neutering.php">
                <div class="service__card">
                    <div class="service_icon">
                        <img src="img/s3.svg" alt="">
                    </div>

                    <div class="service_text">
                        <h3 class="centrar-texto">Castración</h3>
                        <p class="justificar-texto">
                            Promovemos la castración como una medida responsable para el control de la población de
                            animales y la mejora de su salud. Nuestro servicio de castración es realizado por
                            profesionales experimentados, garantizando un proceso seguro y humano.
                        </p>
                    </div>
                </div>
            </a>

            <a href="service_grooming.php">
                <div class="service__card">
                    <div class="service_icon">
                        <img src="img/s4.svg" alt="">
                    </div>

                    <div class="service_text">
                        <h3 class="centrar-texto">Aceo</h3>
                        <p class="justificar-texto">
                            Consentimos a tus mascotas con nuestro servicio de Aseo y Estética, que incluye baños
                            relajantes, corte de pelo, limpieza de oídos y más, para mantenerlos con un aspecto fresco y
                            saludable, además de brindarles una experiencia agradable.
                        </p>
                    </div>
                </div>
            </a>
        </section>
    </main>

    <?php include 'include/template/footer.php'; ?>
</body>

</html>