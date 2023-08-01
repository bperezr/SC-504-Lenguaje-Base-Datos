<?php 

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <!-- styles -->
    <?php 
    $rutaCSS = 'css/events.css';
    include 'include/template/header.php'; ?>

</head>

<body>
    <!-- Nav template -->
    <?php $enlaceActivo = 'events';
    include 'include/template/nav.php'; ?>

    <main class="contenedor event">
        <section class="event__contenido">
            <div class="contenido__sec">
                <h1 class="centrar-texto">Eventos</h1>
                <img src="img/img_13.jpg" alt="imagen"></img>
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
                    <img src="img/imagen_evento1.jpg" alt="Evento 1">
                </div>
                <div class="tarjeta__detalle">
                    <h2>Campaña de Castración Felina y Canina</h2>
                    <ul class="detalle-evento">
                        <li><strong>Fecha:</strong> 10 de agosto de 2023</li>
                        <li><strong>Hora:</strong> 9:00 AM - 4:00 PM</li>
                    </ul>
                </div>
                <div class="tarjeta__btn">
                    <a href="events_post.php" class="ver-evento">Ver evento</a>
                </div>
            </div>

            <!-- Evento 2 -->
            <div class="tarjeta">
                <div class="tarjeta__imagen">
                    <img src="img/imagen_evento2.jpg" alt="Evento 2">
                </div>
                <div class="tarjeta__detalle">
                    <h2>Día de Adopción Responsable</h2>
                    <ul class="detalle-evento">
                        <li><strong>Fecha:</strong> 22 de septiembre de 2023</li>
                        <li><strong>Hora:</strong> 10:00 AM - 2:00 PM</li>
                    </ul>
                </div>
                <div class="tarjeta__btn">
                    <a href="events_post.php" class="ver-evento">Ver evento</a>
                </div>
            </div>

            <!-- Evento 3 -->
            <div class="tarjeta">
                <div class="tarjeta__imagen">
                    <img src="img/imagen_evento3.jpg" alt="Evento 3">
                </div>
                <div class="tarjeta__detalle">
                    <h2>Charla sobre Nutrición y Salud Animal</h2>
                    <ul class="detalle-evento">
                        <li><strong>Fecha:</strong> 30 de septiembre de 2023</li>
                        <li><strong>Hora:</strong> 6:00 PM - 8:00 PM</li>
                    </ul>
                </div>
                <div class="tarjeta__btn">
                    <a href="events_post.php" class="ver-evento">Ver evento</a>
                </div>
            </div>

            <!-- Evento 4 -->
            <div class="tarjeta">
                <div class="tarjeta__imagen">
                    <img src="img/imagen_evento4.jpg" alt="Evento 4">
                </div>
                <div class="tarjeta__detalle">
                    <h2>Exposición de Razas Caninas</h2>
                    <ul class="detalle-evento">
                        <li><strong>Fecha:</strong> 15 de octubre de 2023</li>
                        <li><strong>Hora:</strong> 10:00 AM - 5:00 PM</li>
                    </ul>
                </div>
                <div class="tarjeta__btn">
                    <a href="events_post.php" class="ver-evento">Ver evento</a>
                </div>
            </div>

            <!-- Evento 5 -->
            <div class="tarjeta">
                <div class="tarjeta__imagen">
                    <img src="img/imagen_evento5.jpg" alt="Evento 5">
                </div>
                <div class="tarjeta__detalle">
                    <h2>Vacunación Gratuita</h2>
                    <ul class="detalle-evento">
                        <li><strong>Fecha:</strong> 25 de octubre de 2023</li>
                        <li><strong>Hora:</strong> 9:00 AM - 1:00 PM</li>
                    </ul>
                </div>
                <div class="tarjeta__btn">
                    <a href="events_post.php" class="ver-evento">Ver evento</a>
                </div>
            </div>

            <!-- Evento 6 -->
            <div class="tarjeta">
                <div class="tarjeta__imagen">
                    <img src="img/imagen_evento6.jpg" alt="Evento 5">
                </div>
                <div class="tarjeta__detalle">
                    <h2>Taller de Adiestramiento Canino</h2>
                    <ul class="detalle-evento">
                        <li><strong>Fecha:</strong> 5 de noviembre de 2023</li>
                        <li><strong>Hora:</strong>  2:00 PM - 4:00 PM</li>
                    </ul>
                </div>
                <div class="tarjeta__btn">
                    <a href="events_post.php" class="ver-evento">Ver evento</a>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <?php include 'include/template/footer.php'; ?>
    <!-- JS -->
</body>

</html>