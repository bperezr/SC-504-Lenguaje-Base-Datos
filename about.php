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
    <?php $rutaCSS = 'css/about.css';
    include 'include/template/header.php'; ?>
</head>

<body>
    <!-- Nav template -->
    <?php $enlaceActivo = 'about';
    include 'include/template/nav.php'; ?>

    <!-- Contenido -->
    <main class="contenedor about">
        <!-- hero -->
        <section class="hero1">
            <div class="hero__info">
                <h1 class="centrar-texto">Sobre nosotros</h1>
                <p>¡Bienvenido(a) a Happy Paws, la clínica veterinaria especializada en el cuidado y bienestar exclusivo
                    de gatos y perros! En Happy Paws, entendemos el vínculo especial que tienes con tus mascotas, por
                    eso nos comprometemos a brindarles el mejor cuidado posible y a ofrecerte una experiencia
                    conveniente y amigable.</p>
            </div>
            <div class="hero__imagen">
                <img src="img/about1.jpg" alt="">
            </div>
        </section>
        <!-- hero -->
        <div class="about__info">
            <section class="hero2">
                <div class="hero__imagen">
                    <img src="img/about2.jpg" alt="">
                </div>
                <div class="hero__info">
                    <h2 class="centrar-texto">Nuestra misión</h2>
                    <p>En Happy Paws, nuestra misión es proporcionar un servicio veterinario integral y personalizado
                        para gatos y perros, centrándonos en su salud, felicidad y calidad de vida. Nuestro enfoque está
                        en el cuidado preventivo y la atención médica especializada, asegurando que cada mascota que nos
                        visita reciba un trato amoroso y compasivo.</p>
                </div>
            </section>

            <section class="hero3">
                <div class="hero__info">
                    <h2 class="centrar-texto">Nuestra visión</h2>
                    <p>En Happy Paws, aspiramos a ser la clínica veterinaria de referencia para gatos y perros,
                        destacando por brindar un cuidado excepcional, promover la salud preventiva y establecer una
                        comunidad amorosa y comprometida con el bienestar animal. Nuestro objetivo es ser reconocidos
                        por nuestra dedicación y excelencia en el cuidado de mascotas, utilizando tecnología avanzada
                        para hacer que la experiencia de nuestros clientes sea conveniente y segura. En Happy Paws, cada
                        mascota es tratada con cariño y respeto, y nuestro compromiso es construir un futuro más
                        saludable y feliz para nuestros fieles compañeros.</p>
                </div>
                <div class="hero__imagen">
                    <img src="img/about4.jpg" alt="">
                </div>
            </section>
        </div>
        <!-- hero -->
        <section class="hero4">
            <h2 class="centrar-texto">Nuestros valores</h2>
            <div class="valores">
                <div class="valores__item">
                    <img src="img/icon1_confianza.svg" alt="">
                    <h3>Confianza</h3>
                    <p class="justificar-texto">En Happy Paws, la confianza es el pilar fundamental de nuestra relación
                        con los propietarios de mascotas. Nos esforzamos por ganarnos su confianza a través de un trato
                        cálido, comprensivo y profesional hacia cada gato y perro que nos visita. Nuestro equipo de
                        médicos altamente capacitados trabaja con transparencia y honestidad, asegurando que cada
                        decisión médica esté basada en el bienestar de las mascotas. En Happy Paws, la confianza se
                        forja con cada latido del corazón que cuidamos.</p>
                </div>

                <div class="valores__item">
                    <img src="img/icon2_calidad.svg" alt="">
                    <h3>Calidad</h3>
                    <p class="justificar-texto">En Happy Paws, la calidad es el sello distintivo de nuestro trabajo. Nos
                        comprometemos a ofrecer
                        un cuidado excepcional y personalizado a cada una de nuestras adorables mascotas. Desde la
                        precisión en nuestros diagnósticos hasta la atención meticulosa en cada procedimiento médico,
                        nuestra búsqueda de la excelencia guía cada paso que damos. En Happy Paws, la calidad es nuestra
                        brújula hacia la salud y bienestar de nuestros pacientes peludos.</p>
                </div>

                <div class="valores__item">
                    <img src="img/icon3_integridad.svg" alt="">
                    <h3>Integridad</h3>
                    <p class="justificar-texto">En Happy Paws, la integridad es el cimiento de nuestras acciones y
                        decisiones. Nos enorgullecemos de actuar con honestidad, ética y transparencia en todo lo que
                        hacemos. Cada interacción con los propietarios de mascotas y cada decisión médica se toma con
                        responsabilidad y profesionalismo. En Happy Paws, la integridad es el motor que impulsa nuestra
                        vocación de servir y proteger a nuestros fieles amigos de cuatro patas.</p>
                </div>

                <div class="valores__item">
                    <img src="img/icon4_amor.svg" alt="">
                    <h3>Amor</h3>
                    <p class="justificar-texto">En Happy Paws, el amor es el alma de nuestra clínica veterinaria. Cada
                        uno de nosotros, desde los
                        médicos hasta el personal de apoyo, tiene un profundo amor y cariño por los animales. Nuestro
                        trato amoroso y compasivo hacia cada mascota que nos visita crea un ambiente acogedor y libre de
                        estrés. En Happy Paws, el amor es lo que nos inspira a hacer de cada consulta y tratamiento una
                        experiencia positiva y enriquecedora para nuestros queridos pacientes peludos.</p>
                </div>
            </div>
        </section>
        <!-- hero -->
        <section class="hero5">
            <h2 class="centrar-texto">Nuestro equipo medico</h2>

            <p class="justificar-texto">En Happy Paws, contamos con un equipo de médicos veterinarios altamente
                capacitados y apasionados por su trabajo. Cada uno de nuestros veterinarios está enfocado en brindar una
                atención especializada y personalizada para gatos y perros. Nos enorgullece la dedicación y el
                compromiso de nuestro equipo para garantizar el bienestar y la salud de cada paciente peludo que nos
                visita.</p>

            <div class="team">
                <div class="team_card">
                    <a href="about_team_dr1.php">
                        <img src="img/dr1_luis.png" alt="">
                        <h3 class="centrar-texto">Dr. Luis Carlos Morales Mena</h3>
                        <p class="justificar-texto">El Dr. Luis Carlos Morales Mena es un experto en medicina interna con una
                            pasión por resolver los casos más complejos. Su enfoque analítico y su amplio conocimiento
                            médico le permiten diagnosticar y tratar enfermedades de manera eficiente. Siempre se
                            esfuerza por brindar la mejor atención y mantener una comunicación clara con los
                            propietarios para asegurar la salud a largo plazo de cada paciente.</p>
                    </a>
                </div>

                <div class="team_card">
                    <a href="about_team_dr2.php">
                        <img src="img/dr2_ana.gif" alt="">
                        <h3 class="centrar-texto">Dra. Ana Rodríguez Moya</h3>
                        <p class="justificar-texto">La Dra. Ana Rodríguez Moya es una apasionada defensora del
                            bienestar animal. Su enfoque amable y compasivo la convierte en una profesional cercana a
                            los animales y sus dueños. Siempre se esfuerza por brindar un trato personalizado a cada
                            mascota, asegurándose de que se sientan cómodas y seguras durante su visita.</p>
                    </a>
                </div>

                <div class="team_card">
                    <a href="about_team_dr3.php">
                        <img src="img/dr3_elizabeth.webp" alt="">
                        <h3 class="centrar-texto">Dra. Elizabeth Gómez Roldan</h3>
                        <p class="justificar-texto">La Dra. Elizabeth Gómez Roldan es una cirujana veterinaria altamente
                            capacitada y dedicada. Su destreza quirúrgica y atención meticulosa garantizan que cada
                            procedimiento sea realizado con la más alta calidad. Además de su habilidad técnica, su amor
                            incondicional por los animales la impulsa a cuidar de cada paciente como si fuera su propia
                            mascota.</p>
                    </a>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <?php include 'include/template/footer.php'; ?>
    <!-- JS -->
</body>

</html>`