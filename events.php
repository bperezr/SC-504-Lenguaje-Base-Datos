<?php
require 'include/connections/connect.php';
$db = ConectarDB();

$queryEventos = "SELECT * FROM eventos ";

$result = mysqli_query($db, $queryEventos);
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
            <?php while ($eventos = mysqli_fetch_assoc($result)): ?>
                <!-- Evento 1 -->
                <div class="tarjeta">
                    <div class="tarjeta__imagen">
                        <img src="img/images/<?php echo $eventos['imagen']; ?>" alt="Evento 1">
                    </div>
                    <div class="tarjeta__detalle">
                        <h2>
                            <?php echo $eventos['nombreEvento']; ?>
                        </h2>
                        <ul class="detalle-evento">
                            <li><strong>Lugar:</strong>
                                <?php echo $eventos['Lugar']; ?>
                            </li>
                            <li><strong>Fecha:</strong>
                                <?php echo $eventos['fecha']; ?>
                            </li>
                            <li><strong>Hora:</strong>
                                <?php echo $eventos['hora_inicio']; ?> -
                                <?php echo $eventos['hora_fin'] ?>
                            </li>
                        </ul>
                    </div>
                    <!-- Botones -->
                    <div class="tarjeta__btn">
                        <a href="events_post.php" class="ver-evento">Ver evento</a>
                    </div>
                </div>
            <?php endwhile; ?>
        </section>

    </main>

    <!-- Footer -->
    <?php include 'include/template/footer.php'; ?>
    <!-- JS -->
    <script src="js/card.js"></script>
</body>

</html>