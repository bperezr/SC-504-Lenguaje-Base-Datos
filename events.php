<?php
session_start();

if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    $correoUsuario = $usuario['correo'];
    $rolUsuario = $usuario['idRol'];
    $rol = $usuario['rol'];
    $id = $usuario['id'];
}

require_once 'include/database/db_eventos.php';
$evento = new Evento();

$respuesta = $evento->getEventos();
$resultadoSP = $respuesta['resultado'];
$eventos = $respuesta['datos'];

if ($resultadoSP == 1) {
    $hayResultados = true;
} elseif ($resultadoSP == 0) {
    $mensajeError = "No se encontraron eventos.";
    $hayResultados = false;
} else {
    $mensajeError = "Ocurrió un error al recuperar los eventos.";
    $hayResultados = false;
}

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

        <?php if ($hayResultados): ?>
            <section class="event__tarjetas">
                <?php foreach ($eventos as $evento): ?>
                    <!-- Evento 1 -->
                    <div class="tarjeta">
                        <!-- Imangen -->
                        <div class="tarjeta__imagen">
                            <?php if (file_exists("img/images_events/" . $evento['IMAGEN'])): ?>
                                <img src="img/images_events/<?php echo $evento['IMAGEN']; ?>" alt="Evento imagen">
                            <?php else: ?>
                                <img src="img/images_events/no_disponible.webp" alt="Imagen no disponible">
                            <?php endif; ?>
                        </div>
                        <div class="tarjeta__detalle">
                            <h2>
                                <?php echo $evento['NOMBREEVENTO']; ?>
                            </h2>
                            <ul class="detalle-evento">
                                <li><strong>Lugar:</strong>
                                    <?php echo $evento['LUGAR']; ?>
                                </li>
                                <li><strong>Fecha:</strong>
                                    <?php echo $evento['FECHA']; ?>
                                </li>
                                <li><strong>Hora:</strong>
                                    <?php
                                    $horaInicioFormato = date('H:i', strtotime($evento['HORA_INICIO']));
                                    $horaFinFormato = date('H:i', strtotime($evento['HORA_FIN']));
                                    echo "{$horaInicioFormato} - {$horaFinFormato}";
                                    ?>
                                </li>
                            </ul>
                        </div>
                        <!-- Botones -->
                        <div class="tarjeta__btn">
                            <a href="events_post.php?id=<?php echo $evento['IDEVENTO']; ?>" class="ver-evento">Ver evento</a>
                        </div>

                    </div>
                <?php endforeach; ?>
            </section>
        <?php else: ?>
            <div class="err_busqueda">
                <h2 class="brincar">No se encontraron especialidades que coincidan con la búsqueda.</h2>
                <img class="" src="img/dog1.webp" alt="">
            </div>
        <?php endif; ?>

    </main>

    <!-- Footer -->
    <?php include 'include/template/footer.php'; ?>
    <!-- JS -->
    <script src="js/card.js"></script>
</body>

</html>