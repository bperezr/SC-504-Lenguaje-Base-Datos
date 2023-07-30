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
                <img src="/img/dr1_luis.png" alt="medico">
                <h2>Dr. Juan Carlos Morales</h2>
                <p>Medicina Interna Veterinaria.</p>
            </div>

            <div class="hero">
                <h2 class="centrar-texto no-margin">Acerca de mí</h2>
                <p class="justificar-texto">¡Hola a todos! Soy el Dr. Juan Carlos Morales, y me complace ser parte del
                    equipo de Happy Paws como especialista en Medicina Interna Veterinaria. Desde muy joven, siempre
                    supe que quería dedicar mi vida a cuidar y proteger a los animales, y aquí estoy, viviendo mi sueño
                    cada día.</p>
                <p class="justificar-texto">
                    Mi pasión por la medicina veterinaria comenzó en mi infancia, creciendo en un hogar donde siempre
                    había mascotas. Esta cercana relación con los animales despertó en mí un profundo amor y respeto por
                    todas las criaturas vivas. Siempre me he sentido comprometido a mejorar la calidad de vida de
                    nuestros fieles compañeros peludos, y es por eso que decidí especializarme en Medicina Interna
                    Veterinaria.</p>
                <p class="justificar-texto">
                    Durante mis años de estudio y entrenamiento, aprendí la importancia de escuchar y comprender a los
                    pacientes de cuatro patas. Cada caso es único y presenta sus desafíos, lo que me motiva a mantenerme
                    actualizado en las últimas técnicas y avances médicos. Mi objetivo es proporcionar un diagnóstico
                    preciso y un plan de tratamiento efectivo, siempre enfocado en el bienestar y la salud a largo plazo
                    de cada mascota.</p>
                <p class="justificar-texto">
                    En Happy Paws, encuentro el entorno ideal para ejercer mi profesión con integridad y empatía. Cada
                    día, tengo el privilegio de trabajar con un equipo excepcional y propietarios comprometidos que
                    buscan lo mejor para sus gatos y perros. Mi mayor satisfacción es ver a nuestras mascotas
                    recuperarse y prosperar, sabiendo que puedo marcar la diferencia en sus vidas.</p>
                <p class="justificar-texto">
                    Fuera del trabajo, disfruto del aire libre y me encanta pasar tiempo con mi propia mascota, un
                    adorable Golden Retriever llamado Max. Juntos, compartimos aventuras y momentos de alegría, lo que
                    me recuerda constantemente la importancia de los lazos especiales que creamos con nuestros animales
                    de compañía.</p>
                <p class="justificar-texto">
                    Gracias por confiar en mí y en el equipo de Happy Paws para el cuidado de sus amados gatos y perros.
                    Siempre estaré aquí para brindarles la atención que se merecen y para ser parte de su viaje hacia
                    una vida feliz y saludable.</p>
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