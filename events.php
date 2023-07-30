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

    <main class="contenedor event">
        <section class="event__contenido">
            <div class="contenido__sec">
                <h1 class="centrar-texto">Eventos</h1>
                <img src="/img/img_13.jpg" alt="imagen"></img>
            </div>
            <div class="contenido__sec">
                <h3 class="centrar-texto">¡Descubre nuestros eventos en Happy Paws!</h3>
                <p class="justificar-texto">Campañas de castración, adopción y mucho más. Unidos por el bienestar de tus
                    adorables compañeros. ¡Te
                    esperamos con entusiasmo en cada evento! ¡Únete a nuestra comunidad en Happy Paws!</p>
                <p class="justificar-texto">¡Te invitamos a estar al tanto de nuestros próximos eventos y a ser parte de
                    esta hermosa comunidad que
                    lucha por el bienestar y la felicidad de nuestros queridos compañeros peludos! ¡Te esperamos con las
                    puertas abiertas en Happy Paws!</p>
            </div>
        </section>

        <section class="event__tarjetas">
            <!-- Evento 1 -->
            <div class="tarjeta">
                <div class="tarjeta__imagen">
                    <img src="/img/imagen_evento1.jpg" alt="Evento 1">
                </div>
                <div class="tarjeta__detalle">
                    <h2>Campaña de Castración Felina y Canina</h2>
                    <ul class="detalle-evento">
                        <li><strong>Fecha:</strong> 10 de agosto de 2023</li>
                        <li><strong>Hora:</strong> 9:00 AM - 4:00 PM</li>
                    </ul>
                </div>
                <div class="tarjeta__btn">
                    <a href="events_post.html" class="ver-evento">Ver evento</a>
                </div>
            </div>

            <!-- Evento 2 -->
            <div class="tarjeta">
                <div class="tarjeta__imagen">
                    <img src="/img/imagen_evento2.jpg" alt="Evento 2">
                </div>
                <div class="tarjeta__detalle">
                    <h2>Día de Adopción Responsable</h2>
                    <ul class="detalle-evento">
                        <li><strong>Fecha:</strong> 22 de septiembre de 2023</li>
                        <li><strong>Hora:</strong> 10:00 AM - 2:00 PM</li>
                    </ul>
                </div>
                <div class="tarjeta__btn">
                    <a href="events_post.html" class="ver-evento">Ver evento</a>
                </div>
            </div>

            <!-- Evento 3 -->
            <div class="tarjeta">
                <div class="tarjeta__imagen">
                    <img src="/img/imagen_evento3.jpg" alt="Evento 3">
                </div>
                <div class="tarjeta__detalle">
                    <h2>Charla sobre Nutrición y Salud Animal</h2>
                    <ul class="detalle-evento">
                        <li><strong>Fecha:</strong> 30 de septiembre de 2023</li>
                        <li><strong>Hora:</strong> 6:00 PM - 8:00 PM</li>
                    </ul>
                </div>
                <div class="tarjeta__btn">
                    <a href="events_post.html" class="ver-evento">Ver evento</a>
                </div>
            </div>

            <!-- Evento 4 -->
            <div class="tarjeta">
                <div class="tarjeta__imagen">
                    <img src="/img/imagen_evento4.jpg" alt="Evento 4">
                </div>
                <div class="tarjeta__detalle">
                    <h2>Exposición de Razas Caninas</h2>
                    <ul class="detalle-evento">
                        <li><strong>Fecha:</strong> 15 de octubre de 2023</li>
                        <li><strong>Hora:</strong> 10:00 AM - 5:00 PM</li>
                    </ul>
                </div>
                <div class="tarjeta__btn">
                    <a href="events_post.html" class="ver-evento">Ver evento</a>
                </div>
            </div>

            <!-- Evento 5 -->
            <div class="tarjeta">
                <div class="tarjeta__imagen">
                    <img src="/img/imagen_evento5.jpg" alt="Evento 5">
                </div>
                <div class="tarjeta__detalle">
                    <h2>Vacunación Gratuita</h2>
                    <ul class="detalle-evento">
                        <li><strong>Fecha:</strong> 25 de octubre de 2023</li>
                        <li><strong>Hora:</strong> 9:00 AM - 1:00 PM</li>
                    </ul>
                </div>
                <div class="tarjeta__btn">
                    <a href="events_post.html" class="ver-evento">Ver evento</a>
                </div>
            </div>

            <!-- Evento 6 -->
            <div class="tarjeta">
                <div class="tarjeta__imagen">
                    <img src="/img/imagen_evento6.jpg" alt="Evento 5">
                </div>
                <div class="tarjeta__detalle">
                    <h2>Taller de Adiestramiento Canino</h2>
                    <ul class="detalle-evento">
                        <li><strong>Fecha:</strong> 5 de noviembre de 2023</li>
                        <li><strong>Hora:</strong>  2:00 PM - 4:00 PM</li>
                    </ul>
                </div>
                <div class="tarjeta__btn">
                    <a href="events_post.html" class="ver-evento">Ver evento</a>
                </div>
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