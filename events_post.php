<?php
require_once 'include/functions/auth.php';
session_start();

if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    $correoUsuario = $usuario['correo'];
    $rolUsuario = $usuario['idRol'];
    $rol = $usuario['rol'];
    $id = $usuario['id'];
}

include 'include/functions/ver_evento.php'; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <!-- styles -->
    <?php $rutaCSS = 'css/events.css';
    include 'include/template/header.php'; ?>
</head>

<body>
    <!-- Nav template -->
    <?php $enlaceActivo = '';
    include 'include/template/nav.php'; ?>

    <main class="contenedor">
        <div class="btn_atras">
            <a href="events.php" class="boton input-text">Atras</a>
        </div>
        <section class="evento">
            <div class="evento__detalle">
                <h2 class="centrar-texto"><span>
                        <?php echo $nombreEvento; ?>
                    </span></h2>
                <ul class="evento__detalle-hora">
                    <li><strong>Fecha: </strong><span>
                            <?php echo $fecha; ?>
                    </li>
                    <li><strong>Hora: </strong><span>
                            <?php echo $horaInicio; ?>
                    </li>
                    <li><strong>Lugar: </strong><span>
                            <?php echo $lugar; ?>
                        </span></li>
                    <li><strong>Distrito: </strong><span>
                            <?php echo $nombreDistrito; ?>
                        </span></li>
                    <li><strong>Provincia: </strong><span>
                            <?php echo $nombreProvincia; ?>
                        </span></li>
                    <li><strong>Canton: </strong><span>
                            <?php echo $nombreCanton; ?>
                        </span></li>
                </ul>
                <p class="justificar-texto"><span>
                        <?php echo $descripcion; ?>
                    </span></p>
                <!--Iimagen -->
                <?php if (file_exists("img/images/" . $imagen)): ?>
                    <img src="img/images/<?php echo $imagen; ?>" alt="evento">
                <?php else: ?>
                    <!-- Si la imagen no existe, muestra una imagen alternativa -->
                    <img src="img/no_disponible.webp" alt="Imagen no disponible">
                <?php endif; ?>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <?php include 'include/template/footer.php'; ?>
    <!-- JS -->
</body>

</html>`