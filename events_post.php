<?php
session_start();

/*if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    $correoUsuario = $usuario['correo'];
    $rolUsuario = $usuario['idRol'];
    $rol = $usuario['rol'];
    $id = $usuario['id'];
}

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['idRol'] != 1) {
    header("Location: acceso_denegado.php");
    exit();
}*/

require_once 'include/database/db_eventos.php';
$evento = new Evento();

$idEvento = isset($_GET['id']) ? $_GET['id'] : null;
$detalleEvento = null;


if ($idEvento) {
    $respuesta = $evento->getEvento($idEvento);
    $resultadoSP = $respuesta['resultado'];
    if ($resultadoSP == 1) {
        $detalleEvento = $respuesta['datos'];
    }
}

?>

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
            <?php if ($resultadoSP == 1): ?>
                <div class="evento__detalle">
                    <h2 class="centrar-texto">
                        <?php echo $detalleEvento['nombreEvento']; ?>
                    </h2>
                    <ul class="evento__detalle-hora">
                        <li><strong>Fecha: </strong>
                            <?php echo $detalleEvento['fecha']; ?>
                        </li>
                        <li><strong>Hora: </strong>
                            <?php
                            $horaInicioFormato = date('H:i', strtotime($detalleEvento['horaInicio']));
                            $horaFinFormato = date('H:i', strtotime($detalleEvento['horaFin']));
                            echo "{$horaInicioFormato} - {$horaFinFormato}";
                            ?>
                        </li>
                        <li><strong>Lugar: </strong>
                            <?php echo $detalleEvento['lugar']; ?>
                        </li>
                        <li><strong>Distrito: </strong>
                            <?php echo $detalleEvento['idDistrito']; ?>
                        </li>
                        <li><strong>Provincia: </strong>
                            <?php echo $detalleEvento['idProvincia']; ?>
                        </li>
                        <li><strong>Canton: </strong>
                            <?php echo $detalleEvento['idCanton']; ?>
                        </li>
                    </ul>
                    <p class="justificar-texto">
                        <?php echo $detalleEvento['descripcion']; ?>
                    </p>
                    <?php if (file_exists("img/images_events/" . $detalleEvento['imagen'])): ?>
                        <img src="img/images_events/<?php echo $detalleEvento['imagen']; ?>" alt="evento">
                    <?php else: ?>
                        <img src="img/no_disponible.webp" alt="Imagen no disponible">
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="err_busqueda">
                    <h2 class="brincar">No se encontraron especialidades que coincidan con la búsqueda.</h2>
                    <img class="" src="img/dog1.webp" alt="">
                </div>
            <?php endif; ?>
        </section>
    </main>

    <?php include 'include/template/footer.php'; ?>
</body>

</html>