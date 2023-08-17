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
    <?php $rutaCSS = 'css/about_team_dr.css';
    include 'include/template/header.php'; ?>
</head>

<body>
    <!-- Nav template -->
    <?php $enlaceActivo = '';
    include 'include/template/nav.php'; ?>

    <main class="contenedor">

        <section class="hero">
            <div class="contact">
                <img src="img/dr3_elizabeth.webp" alt="medico">
                <h2>Dra. Elizabeth Gómez Roldan</h2>
                <p>Medicina Veterinaria General y Estética.</p>
            </div>

            <div class="hero">
                <h2 class="centrar-texto no-margin">Acerca de mí</h2>
                <p class="justificar-texto">¡Hola a todos! Soy la Dra. Elizabeth Gómez Roldan, y estoy emocionada de ser parte
                    del maravilloso equipo de Happy Paws como especialista en Medicina Veterinaria General y Estética
                    Canina y Felina. Desde muy joven, mi pasión por los animales y mi fascinación por el arte de
                    embellecerlos me llevaron a seguir este camino profesional único.</p>
                <p class="justificar-texto">
                    Además de mi amor por la medicina veterinaria, encontré una pasión especial en la estética y el
                    bienestar de nuestros queridos amigos de cuatro patas. En Happy Paws, tengo el privilegio de
                    combinar ambas pasiones, brindando atención médica integral y realzando la belleza de gatos y perros
                    con una dedicación excepcional.</p>
                <p class="justificar-texto">
                    Como especialista en Estética Canina y Felina, me dedico a proporcionar un cuidado de primera
                    categoría que no solo beneficie la salud de las mascotas, sino que también realce su aspecto y
                    bienestar emocional. Desde cortes y baños hasta tratamientos especiales de piel y pelaje, mi
                    objetivo es asegurarme de que cada mascota se sienta y se vea su mejor versión.</p>
                <p class="justificar-texto">
                    En Happy Paws, encuentro el ambiente perfecto para desarrollar mi creatividad y habilidades técnicas
                    en el campo de la estética. Mi enfoque es brindar una experiencia relajante y positiva para las
                    mascotas, manteniendo sus necesidades individuales y preferencias en mente. Además, trabajo en
                    estrecha colaboración con los propietarios para comprender sus expectativas y asegurarme de que el
                    resultado final sea espectacular.</p>
                <p class="justificar-texto">
                    Fuera de la clínica, disfruto de los desafíos creativos y encuentro inspiración en las últimas
                    tendencias de estética canina y felina. Mi objetivo es estar siempre actualizada en técnicas y
                    productos de vanguardia para ofrecer un servicio excepcional y de calidad a nuestros clientes
                    peludos.</p>
                <p class="justificar-texto">
                    Gracias por confiar en mí y en el equipo de Happy Paws para el cuidado y la estética de sus amados
                    gatos y perros. Estoy emocionada de trabajar juntos para brindarles una experiencia única y
                    enriquecedora.</p>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <?php include 'include/template/footer.php'; ?>
    <!-- JS -->
</body>

</html>