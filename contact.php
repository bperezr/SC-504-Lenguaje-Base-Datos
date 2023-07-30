<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Header template -->
    <?php include 'include/template/header.php'; ?>
    <!-- styles -->
    <link rel="preload" href="css/contact.css" as="style">
    <link rel="stylesheet" href="css/contact.css">
</head>

<body>
    <!-- Header template-->
    <?php $enlaceActivo = 'contact'; include 'include/template/nav.php';?>

    <main class="contenedor">
        <section class="hero">

            <div class="hero__seccion infoContact">
                <h2 class="centrar-texto">Contáctenos</h2>

                <p class="justificar-texto">
                    ¡Estamos encantados de atenderte! Si tienes alguna pregunta o necesitas más información sobre
                    nuestros servicios, promociones o cuidado de tus mascotas, no dudes en comunicarte con nosotros.
                </p>
                <p class="justificar-texto">
                    Nuestro equipo estará disponible para ayudarte en todo lo que necesites. ¡Esperamos con ansias ser
                    parte de la salud y bienestar de tus mejores amigos. en Happy Paws!
                </p>

                <div class="iconos">

                    <div class="icono">
                        <a href="">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-instagram"
                                width="60" height="60" viewBox="0 0 24 24" stroke-width="2" stroke="#ffca0f" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M4 4m0 4a4 4 0 0 1 4 -4h8a4 4 0 0 1 4 4v8a4 4 0 0 1 -4 4h-8a4 4 0 0 1 -4 -4z" />
                                <path d="M12 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                <path d="M16.5 7.5l0 .01" />
                            </svg>
                            <p>@Happy-Paws</p>
                        </a>
                    </div>

                    <div class="icono">
                        <a href="">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-facebook"
                                width="60" height="60" viewBox="0 0 24 24" stroke-width="2" stroke="#ffca0f" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M7 10v4h3v7h4v-7h3l1 -4h-4v-2a1 1 0 0 1 1 -1h3v-4h-3a5 5 0 0 0 -5 5v2h-3" />
                            </svg>
                            <p>@Happy-Paws</p>
                        </a>
                    </div>

                    <div class="icono">
                        <a href="">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-whatsapp"
                                width="60" height="60" viewBox="0 0 24 24" stroke-width="2" stroke="#ffca0f" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M3 21l1.65 -3.8a9 9 0 1 1 3.4 2.9l-5.05 .9" />
                                <path
                                    d="M9 10a.5 .5 0 0 0 1 0v-1a.5 .5 0 0 0 -1 0v1a5 5 0 0 0 5 5h1a.5 .5 0 0 0 0 -1h-1a.5 .5 0 0 0 0 1" />
                            </svg>
                            <p>+506 8888-8888</p>
                        </a>
                    </div>

                    <div class="icono">
                        <a href="">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-phone"
                                width="60" height="60" viewBox="0 0 24 24" stroke-width="2" stroke="#ffca0f" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" />
                            </svg>
                            <p>+506 2532-3577</p>
                        </a>
                    </div>

                    <div class="icono">
                        <a href="mailto:happyPaws@email.com">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail" width="60"
                                height="60" viewBox="0 0 24 24" stroke-width="2" stroke="#ffca0f" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z" />
                                <path d="M3 7l9 6l9 -6" />
                            </svg>
                            <p>happyPaws@email.com</p>
                        </a>
                    </div>

                    <div class="icono">
                        <a href="">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-map-pin"
                                width="60" height="60" viewBox="0 0 24 24" stroke-width="2" stroke="#ffca0f" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M9 11a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                                <path
                                    d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0z" />
                            </svg>
                            <p>San José, Costa Ricas</p>
                        </a>
                    </div>

                </div>
            </div>

            <div class="hero__seccion">
                <img src="img/home1.png" alt="imagen">
            </div>
        </section>

        <h3 class="centrar-texto">Formulario de contacto</h3>

        <form class="formulario" id="formulario">

            <fieldset>
                <div class="contenedor-campos">
                    <div class="campo">
                        <label for="Nombre">Nombre</label>
                        <input class="input-text" type="text" id="nombre" name="nombre" placeholder="Nombre">
                    </div>

                    <div class="campo">
                        <label for="Nombre">Teléfono</label>
                        <input class="input-text" type="tel" id="telefono" name="telefono" placeholder="Teléfono">
                    </div>

                    <div class="campo">
                        <label for="Nombre">Correo</label>
                        <input class="input-text" type="email" id="correo" name="correo" placeholder="Correo">
                    </div>

                    <div class="campo">
                        <label>Mensaje</label>
                        <textarea id="mensaje" name="mensaje" class="input-text"
                            placeholder="Ingrese su mensaje"></textarea>
                    </div>
                </div><!-- contenedor-campos -->

                <div class="boton-contacto">
                    <input class="boton input-text" type="submit" value="Enviar">
                </div>

                <div class="contenedor-mensaje">

            </fieldset>
        </form>

        </section><!-- Contacto -->
    </main>

    <!-- Footer -->
    <?php include 'include/template/footer.php'; ?>
    <!-- JS -->
    <script src="js/contacto.js"></script>
</body>

</html>`