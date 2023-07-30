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
    <link rel="preload" href="css/services.css" as="style">
    <link rel="stylesheet" href="css/services.css">

    <!--Icons-->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</head>

<body>
    <!-- Header -->
    <header>
        <!-- Logo -->
        <a class="logo" href="index.html"><img src="img/logo2_color.svg" alt="Happy-Paws" /></a>
        <!-- Menu 2 -->
        <input type="checkbox" id="menu-bar" />
        <label for="menu-bar"><ion-icon name="menu-outline"></ion-icon></label>
        <!-- Navegacion -->
        <nav class="navbar">
            <ul>
                <li>
                    <a class="active" href="services.html">Servicios</a>
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
            <a href="service_medical_check.html">
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

            <a href="service_surgery.html">
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

            <a href="service_neutering.html">
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

            <a href="service_grooming.html">
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