<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Happy Paw</title>
    <link rel="icon" type="image/svg+xml" href="/img/favicon.png">
    <link rel="icon" type="image/png" href="/img/favicon.svg">
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
    <link rel="preload" href="css/events.css" as="style">
    <link rel="stylesheet" href="css/events.css">

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
                <li><a class="active" href="events.html">Eventos</a></li>
                <li><a href="contact.html">Contacto</a></li>
                <li><a class="login" href="login.html"><ion-icon name="person-circle-outline"></ion-icon></a></li>
            </ul>
        </nav>
    </header>

    <main class="contenedor">
        <section class="evento">
            <div class="evento__detalle">
                <h2 class="centrar-texto">Campaña de Castración Felina y Canina</h2>
                <ul class="evento__detalle-hora">
                    <li><strong>Fecha:</strong> 10 de agosto de 2023</li>
                    <li><strong>Hora:</strong> 9:00 AM - 4:00 PM</li>
                    <li><strong>Lugar:</strong> San José, Costa Rica.</li>
                </ul>
                <p class="justificar-texto">Únete a nuestra campaña de castración para gatos y perros, donde promovemos la esterilización como
                    una medida responsable y beneficiosa para el bienestar de nuestras mascotas. Contaremos con
                    veterinarios especializados que brindarán una atención cuidadosa y amorosa a cada animal. ¡Ayúdanos
                    a controlar la población de animales y a proteger su salud!</p>
                    <img src="/img/imagen_evento1.jpg" alt="Evento 1">
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

    <script src="js/card.js"></script>
</body>

</html>`