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
    <link rel="preload" href="css/services_info.css" as="style">
    <link rel="stylesheet" href="css/services_info.css">

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
                        <li><a class="active" href="service_neutering.html">Castración</a></li>
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

    <div class="contenedor">

        <main class="informacion ">
            <article class="entrada">
                <h1 class="centrar-texto no-margin">Castración</h1>
                <img class="service_icon" src="img/s3.svg" alt="icono">
                <p class="justificar-texto">
                    En Happy Paws, reconocemos la importancia de la castración como una medida
                    responsable y beneficiosa para el bienestar de nuestros amigos peludos. Nuestro servicio de
                    Castración está diseñado para gatos y perros, con el objetivo de controlar la población de animales
                    y proteger su salud a lo largo de sus vidas. Nuestro equipo de veterinarios altamente capacitados
                    realiza procedimientos de castración con cuidado y amor, garantizando el máximo confort y seguridad
                    para nuestras mascotas.
                </p>
            </article><!-- Texto 1 -->
            <article class="entrada">
                <h2 class="centrar-texto">Sobre el servicio</h2>
                <li>Castración para gatos y perros machos y hembras.</li>
                <li>Beneficios de la castración en la prevención de enfermedades y comportamientos no deseados.</li>
                <li>Promoción de la salud y bienestar a lo largo de la vida de la mascota.</li>
                <li>Reducción del riesgo de cáncer y enfermedades relacionadas con el sistema reproductivo.</li>
                <li>Contribución a la reducción de la superpoblación animal y el bienestar de la comunidad.</li>
                <li>Procedimiento quirúrgico seguro y eficiente con técnicas modernas y anestesia adecuada.</li>
                <li>Apoyo y cuidado postoperatorio para asegurar una recuperación rápida y sin complicaciones.</li>
                <li>Asesoramiento sobre el manejo y cuidado de la mascota después de la castración.</li>
                <img class="imagen" src="img/img_2.jpg" alt="">
            </article><!-- Texto 2 -->

            <div class="enlace contenedor">
                <a class="boton centrar-texto" href="/services.html">Mas servicios</a>
            </div>

        </main>

        <aside class="sidebar contenido-principal">
            <form class="formulario" id="formulario">
                <fieldset>
                    <h3 class="centrar-texto">Programar una cita</h3>
                    <div class="contenedor-campos">
                        <div class="campo">
                            <label for="nombre">Nombre:</label>
                            <input type="text" placeholder="Nombre completo" id="nombre" name="nombre" >
                        </div>

                        <div class="campo">
                            <label for="correo">Correo:</label>
                            <input type="email" placeholder="Correo electrónico" id="correo" name="correo" >
                        </div>

                        <div class="campo">
                            <label for="fecha">Fecha:</label>
                            <input type="date" id="fecha" name="fecha">
                        </div>

                        <div class="campo">
                            <label for="horario">Horario:</label>
                            <select id="horario" name="horario" >
                                <option value="" disabled selected>Seleccione un horario</option>
                                <option value="8:00 AM">8:00 AM</option>
                                <option value="10:00 AM">9:00 AM</option>
                                <option value="2:00 PM">10:00 AM</option>
                                <option value="4:00 PM">11:00 AM</option>
                                <option value="8:00 AM">1:00 PM</option>
                                <option value="10:00 AM">2:00 PM</option>
                                <option value="2:00 PM">3:00 PM</option>
                                <option value="4:00 PM">4:00 PM</option>
                            </select>
                        </div>

                        <div class="campo">
                            <label for="servicio">Servicio:</label>
                            <select id="servicio" name="servicio" >
                                <option value="" disabled selected>Seleccione un servicio</option>
                                <option value="Medicina General">Medicina general</option>
                                <option value="Cirugía">Cirugía</option>
                                <option value="Castración">Castración</option>
                                <option value="Aseo de mascotas">Aseo de mascotas</option>
                            </select>
                        </div>

                        <div class="campo">
                            <label for="mascota">Mascota:</label>
                            <select id="mascota" name="mascota" >
                                <option value="" disabled selected>Seleccione la mascota</option>
                                <option value="Gato">Gato</option>
                                <option value="Perro">Perro</option>
                            </select>
                        </div>
                    </div><!-- contenedor-campos -->

                    <div class="boton-contacto">
                        <input class="boton input-text" type="submit" value="Enviar">
                    </div>

                    <div class="contenedor-mensaje">
                    </div>
                </fieldset>
            </form>
        </aside>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="fcontenedor">
            <!-- Seccion 1-->
            <div class="fcontenedor__seccion">
                <img class="fcontenedor__imagen" src="img/logo_color.svg" alt="Happy-Paws" />
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
    <script src="js/cita.js"></script>
</body>

</html>`