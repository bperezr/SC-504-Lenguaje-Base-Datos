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
                <img src="/img/dr2_ana.gif" alt="medico">
                <h2>Dra. Valentina Rodríguez</h2>
                <p>Cirugía Veterinaria.</p>
            </div>

            <div class="hero">
                <h2 class="centrar-texto no-margin">Acerca de mí</h2>
                <p class="justificar-texto">¡Hola a todos! Soy la Dra. Valentina Rodríguez y me emociona formar parte
                    del equipo de Happy Paws como especialista en Medicina Veterinaria General. Desde muy temprana edad,
                    supe que mi pasión por los animales me llevaría a dedicar mi vida a cuidar de ellos y a promover su
                    bienestar.</p>
                <p class="justificar-texto">
                    Mi amor por los animales comenzó con mi primer gato, a quien rescaté cuando era apenas un gatito.
                    Esta experiencia cambió mi vida y me inspiró a embarcarme en una carrera en la medicina veterinaria.
                    A lo largo de mi formación y experiencia profesional, he aprendido la importancia de brindar una
                    atención integral y compasiva a cada paciente peludo que llega a nuestra clínica.</p>
                <p class="justificar-texto">
                    En Happy Paws, encuentro el lugar perfecto para ejercer mi vocación, rodeada de un equipo
                    comprometido y apasionado por el bienestar animal. Cada día, me esfuerzo por establecer una conexión
                    especial con cada mascota y sus dueños, comprendiendo sus necesidades individuales y preocupándome
                    por su salud en general.</p>
                <p class="justificar-texto">
                    Mi enfoque es fomentar la prevención y la educación, lo que me permite trabajar junto a los
                    propietarios para asegurarme de que sus gatos y perros reciban la mejor atención posible en casa y
                    en nuestra clínica. Desde chequeos regulares hasta el manejo de enfermedades crónicas, mi objetivo
                    es proporcionar un enfoque integral y personalizado para mantener a nuestras mascotas felices y
                    saludables.</p>
                <p class="justificar-texto">
                    Fuera de la clínica, disfruto de la naturaleza y me encanta explorar senderos con mi perro
                    rescatado, Luna. Ella es mi fiel compañera y me recuerda constantemente la importancia de cuidar y
                    proteger a nuestros amigos de cuatro patas.</p>
                <p class="justificar-texto">
                    Gracias por permitirme formar parte de la vida de sus queridos gatos y perros. Estoy comprometida a
                    brindarles la atención y el cariño que se merecen, y espero ser parte de su viaje hacia una vida
                    llena de salud y alegría.</p>
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