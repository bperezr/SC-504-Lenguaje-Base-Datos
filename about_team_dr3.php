<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Happy Paw</title>
    <meta name="description" content="Página web Happy Paws">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- normalize -->
    <link rel="preload" href="css/normalize.css" as="style">
    <link rel="stylesheet" href="css/normalize.css">

    <!-- Fonts -->
    <link rel="preload"
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&family=Staatliches&display=swap"
        crossorigin="crossorigin" as="font">

    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&family=Staatliches&display=swap"
        rel="stylesheet">

    <!-- styles -->
    <link rel="preload" href="css/about_team_dr.css" as="style">
    <link rel="stylesheet" href="css/about_team_dr.css">

    <!--Icons-->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</head>

<body>
    <!-- Header -->
    <header>
        <!-- Logo -->
        <a class="logo" href="index.html"><img src="/img/logo2_color.svg" alt="Happy-Paws" /></a>
        <!-- Menu 2 -->
        <input type="checkbox" id="menu-bar" />
        <label for="menu-bar"><ion-icon name="menu-outline"></ion-icon></label>
        <!-- Navegacion -->
        <nav class="navbar">
            <ul>
                <li>
                    <a href="">Servicios</a>
                    <ul>
                        <li><a href="service_medical_check.html">Medicia</a></li>
                        <li><a href="service_surgery.html">Cirugía</a></li>
                        <li><a href="service_neutering.html">Castración</a></li>
                        <li><a href="service_grooming.html">Aceo</a></li>
                    </ul>
                </li>
                <li><a href="about.html">Nosotros</a></li>
                <li><a href="events.html">Eventos</a></li>
                <li><a href="contact.html">Contacto</a></li>
                <li><a class="login" href="login.html"><ion-icon name="person-circle-outline"></ion-icon></a></li>
            </ul>
        </nav>
    </header>

    <main class="contenedor">

        <section class="hero">
            <div class="contact">
                <img src="/img/dr3_elizabeth.webp" alt="medico">
                <h2>Dra. Martina Gómez</h2>
                <p>Medicina Veterinaria General y Estética.</p>
            </div>

            <div class="hero">
                <h2 class="centrar-texto no-margin">Acerca de mí</h2>
                <p class="justificar-texto">¡Hola a todos! Soy la Dra. Martina Gómez, y estoy emocionada de ser parte
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
    <footer class="footer">
        <div class="fcontenedor">
            <!-- Seccion 1-->
            <div class="fcontenedor__seccion">
                <img class="fcontenedor__imagen" src="/img/logo_color.svg" alt="Happy-Paws" />
                <p>Dedicados a la salud y bienestar de tus mejores amigos.</p>
            </div>
            <!-- Seccion 2-->
            <div class="fcontenedor__seccion">
                <h4 class="ftitulo">Redes Sociales</h4>
                <a href="#!" class="fcontenedor__info"><ion-icon name="logo-instagram"></ion-icon> Happy-Paws</a>
                <a href="#!" class="fcontenedor__info"><ion-icon name="logo-facebook"></ion-icon> Happy-Paws</a>
                <a href="#!" class="fcontenedor__info"><ion-icon name="logo-whatsapp"></ion-icon> +506 8888-8888</a>
            </div>
            <!-- Seccion 3-->
            <div class="fcontenedor__seccion">
                <h4 class="ftitulo">Contáctenos</h4>
                <a href="#!" class="fcontenedor__info"><ion-icon name="call-sharp"></ion-icon> +506 2532-3577</a>
                <a href="#!" class="fcontenedor__info"><ion-icon name="navigate-circle-sharp"></ion-icon> San José,
                    Costa Rica.</a>
                <a href="mailto:happyPaws@email.com" class="fcontenedor__info"><ion-icon name="mail-sharp"></ion-icon>
                    happyPaws@email.com</a>
            </div>
        </div>
        <!-- Copyright -->
        <div class="copyright">
            <p>&copy; Happy Paws — Todos los derechos Reservados 2023.</p>
        </div>
    </footer>

</body>

</html>`