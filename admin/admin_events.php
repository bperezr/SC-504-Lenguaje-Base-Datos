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
    header("Location: ../acceso_denegado.php");
    exit();
}*/

require_once '../include/database/db_eventos.php';
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idEvento = $_POST['idEvento'];

    // Obtener información del evento para la imagen
    $eventoInfo = $evento->getEvento($idEvento);
    if ($eventoInfo['resultado'] == 1 && !empty($eventoInfo['datos'])) {
        $nombreImagen = $eventoInfo['datos']['imagen'];

        // Primero, intentar eliminar el evento
        $resultadoSP = $evento->deleteEvento($idEvento);

        if ($resultadoSP == 1) {
            // Si el evento se elimina con éxito, proceder a eliminar la imagen del servidor
            if ($evento->deleteImagen($nombreImagen)) {
                $_SESSION['mensaje'] = "Evento e imagen eliminados con éxito.";
            } else {
                $_SESSION['mensaje'] = "Evento eliminado, pero ocurrió un error al eliminar la imagen.";
            }
        } elseif ($resultadoSP == 0) {
            $_SESSION['mensaje'] = "No se encontró el evento para eliminar.";
        } else {
            $_SESSION['mensaje'] = "Ocurrió un error al intentar eliminar el evento.";
        }
    } else {
        $_SESSION['mensaje'] = "No se encontró información del evento para eliminar.";
    }

    header('Location: admin_events.php');
    exit;
}

$hayResultados = true;

if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
    $respuesta = $evento->buscarEventos($searchTerm);
    $eventos = $respuesta['datos']; // Asume que 'datos' contiene los eventos

    // Comprobar si hay eventos encontrados
    if (empty($eventos)) {
        $hayResultados = false;
    } else {
        $hayResultados = true;
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <!-- styles -->
    <?php $rutaCSS = '../css/admin_events.css';
    include '../include/template/header.php'; ?>
</head>

<body>

    <!-- Nav template -->
    <?php $enlaceActivo = 'admin_events';
    include '../include/template/nav.php'; ?>

    <main class="contenedor">

        <h1 class="centrar-texto">Administrar Eventos</h1>

        <form action="" method="get">
            <div class="contenedor_buscar">
                <div class="buscador buscador_buscar">
                    <!-- Texto buscar -->
                    <div class="textBuscar">
                        <input type="text" placeholder="Buscar..." name="search">
                    </div>
                    <!-- Buscar -->
                    <div class="buscar">
                        <button class="btn_buscar" type="submit">Buscar</button>
                    </div>
                    <!-- Recargar -->
                    <div class="recargar">
                        <a href="admin_events.php"><ion-icon name="refresh-circle"></ion-icon></a>
                    </div>
                </div>
                <div class="buscador buscador_agregar">
                    <!---Agregar-->
                    <div class="agregar">
                        <a href="admin_events_new.php" class="btn_agregar"><ion-icon
                                name="add-circle-outline"></ion-icon>
                            Agregar</a>
                    </div>
                </div>
            </div>
        </form>

        <?php if ($hayResultados): ?>
            <section class="event__tarjetas">
                <?php foreach ($eventos as $evento): ?>
                    <!-- Evento -->
                    <div class="tarjeta">
                        <!-- Imangen -->
                        <div class="tarjeta__imagen">
                            <?php if (file_exists("../img/images_events/" . $evento['IMAGEN'])): ?>
                                <img src="../img/images_events/<?php echo $evento['IMAGEN']; ?>" alt="Evento imagen">
                            <?php else: ?>
                                <img src="../img/images_events/no_disponible.webp" alt="Imagen no disponible">
                            <?php endif; ?>
                        </div>
                        <!-- Detalle Evento -->
                        <div class="tarjeta__detalle">
                            <h2>
                                <!-- Nombre -->
                                <?php echo $evento['NOMBREEVENTO']; ?>
                            </h2>
                            <ul class="detalle-evento">
                                <li><strong>Fecha:</strong>
                                    <!-- Fecha -->
                                    <?php echo $evento['FECHA']; ?>
                                </li>
                                <!-- Horas -->
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
                            <!-- Editar -->
                            <a href="admin_events_edit.php?id=<?php echo $evento['IDEVENTO']; ?>" class="editar">
                                <ion-icon name="create-sharp"></ion-icon>Editar
                            </a>
                            <!-- Eliminar -->
                            <form class="tarjeta__btn" method="POST">
                                <input type="hidden" name="idEvento" value="<?php echo $evento['IDEVENTO'] ?>">
                                <button type="submit" class="eliminar"
                                    onclick="return confirm('¿Estás seguro de que deseas eliminar el evento?')">
                                    <ion-icon name="trash-sharp"></ion-icon>Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </section>
        <?php else: ?>
            <div class="err_busqueda">
                <h2 class="brincar">No se encontraron especialidades que coincidan con la búsqueda.</h2>
                <img class="" src="../img/dog1.webp" alt="">
            </div>
        <?php endif; ?>

    </main>

    <!-- Footer -->
    <?php include '../include/template/footer.php'; ?>
    <!-- Mensaje -->
    <?php if (isset($_SESSION['mensaje'])): ?>
        <script>
            window.onload = function () {
                alert("<?php echo $_SESSION['mensaje']; ?>");
                <?php unset($_SESSION['mensaje']); ?>
            };
        </script>
    <?php endif; ?>
</body>

</html>