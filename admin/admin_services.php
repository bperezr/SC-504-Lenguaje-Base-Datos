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

require_once '../include/database/db_servicio.php';
$servicio = new servicio();


$respuesta = $servicio->getServicios();
$resultadoSP = $respuesta['resultado'];
$servicios = $respuesta['datos'];

if ($resultadoSP == 1) {
    $hayResultados = true;
} elseif ($resultadoSP == 0) {
    $mensajeError = "No se encontraron servicios.";
    $hayResultados = false;
} else {
    $mensajeError = "Ocurrió un error al recuperar los servicios.";
    $hayResultados = false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idServicio = $_POST['id'];

    $resultadoSP = $servicio->deleteServicio($idServicio);

    if ($resultadoSP == 1) {
        $_SESSION['mensaje'] = "servicio eliminado con éxito.";
    } elseif ($resultadoSP == 0) {
        $_SESSION['mensaje'] = "No se encontró el servicio para eliminar.";
    } else {
        $_SESSION['mensaje'] = "Ocurrió un error al intentar eliminar el servicio.";
    }

    header('Location: admin_services.php');
    exit;
}

$hayResultados = true;

if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
    $servicios = $servicio->buscarServicios($searchTerm);

    if (empty($servicios)) {
        $hayResultados = false;
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <!-- styles -->
    <?php $rutaCSS = '../css/admin_workers.css';
    include '../include/template/header.php'; ?>
</head>

<body>

    <!-- Nav template -->
    <?php $enlaceActivo = 'admin_services';
    include '../include/template/nav.php'; ?>

    <main class="contenedor">

        <h1 class="centrar-texto">Administrar servicios</h1>

        <!-- Buscador -->
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
                        <a href="admin_services.php"><ion-icon name="refresh-circle"></ion-icon></a>
                    </div>
                </div>
                <div class="buscador buscador_agregar">
                    <!---Agregar-->
                    <div class="agregar">
                        <a href="admin_service_new.php" class="btn_agregar"><ion-icon
                                name="add-circle-outline"></ion-icon>
                            Agregar</a>
                    </div>
                </div>
            </div>
        </form>

        <?php if ($hayResultados): ?>
            <section class="event__tarjetas">
                <?php foreach ($servicios as $servicio): ?>
                    <!-- Tarjeta de cada servicio -->
                    <div class="tarjeta">
                        <div class="tarjeta__detalle">
                            <ul class="detalle-evento">
                                <li><strong>Servicio:</strong>
                                    <?php echo $servicio['SERVICIO']; ?>
                                </li>
                                <li class="justificar-texto"><strong>Descripción:</strong>
                                    <?php echo $servicio['DESCRIPCION']; ?>
                                </li>
                            </ul>
                        </div>
                        <!-- Botones -->
                        <div class="tarjeta__btn">
                            <!-- Editar -->
                            <a href="admin_services_edit.php?id=<?php echo $servicio['IDSERVICIO']; ?>"
                                class="editar"><ion-icon name="create-sharp"></ion-icon>Editar</a>
                            <!-- Eliminar -->
                            <form action="" method="post" style="display: inline;">
                                <input type="hidden" name="id" value="<?php echo $servicio['IDSERVICIO']; ?>">
                                <button type="submit" class="eliminar"
                                    onclick="return confirm('¿Estás seguro de que deseas eliminar este servicio?')">
                                    <ion-icon name="trash-sharp"></ion-icon>Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </section>
        <?php else: ?>
            <div class="err_busqueda">
                <h2 class="brincar">No se encontraron servicios que coincidan con la búsqueda.</h2>
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