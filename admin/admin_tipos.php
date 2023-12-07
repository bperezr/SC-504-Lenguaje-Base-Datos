<?php
session_start();

if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    $correoUsuario = $usuario['correo'];
    $rolUsuario = $usuario['idRol'];
    $rol = $usuario['rol'];
    $id = $usuario['id'];
}

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['idRol'] != 1) {
    header("Location: ../acceso_denegado.php");
    exit();
}

require_once '../include/database/db_tipomascota.php';
$tipo = new TipoMascota();
$respuesta = $tipo->getTipoMascotas();
$resultadoSP = $respuesta['resultado'];
$tipos = $respuesta['datos'];

if ($resultadoSP == 1) {
    $hayResultados = true;
} elseif ($resultadoSP == 0) {
    $mensajeError = "No se encontraron tipos de mascota.";
    $hayResultados = false;
} else {
    $mensajeError = "Ocurrió un error al recuperar los tipos de mascota.";
    $hayResultados = false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idTipoMascota = $_POST['id'];

    $resultadoSP = $tipo->deleteTipoMascota($idTipoMascota);

    if ($resultadoSP == 1) {
        $_SESSION['mensaje'] = "tipo de mascota eliminado con éxito.";
    } elseif ($resultadoSP == 0) {
        $_SESSION['mensaje'] = "No se encontró el tipo de mascota para eliminar.";
    } else {
        $_SESSION['mensaje'] = "Ocurrió un error al intentar eliminar el tipo de mascota.";
    }

    header('Location: admin_tipos.php');
    exit;
}

$hayResultados = true;

if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
    $tipos = $tipo->buscarTipoMascotas($searchTerm);

    if (empty($tipos)) {
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
    <?php $enlaceActivo = 'admin_tipos';
    include '../include/template/nav.php'; ?>

    <main class="contenedor">

        <h1 class="centrar-texto">Administrar tipos de mascota</h1>

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
                        <a href="admin_tipos.php"><ion-icon name="refresh-circle"></ion-icon></a>
                    </div>
                </div>
                <div class="buscador buscador_agregar">
                    <!---Agregar-->
                    <div class="agregar">
                        <a href="admin_tipos_new.php" class="btn_agregar"><ion-icon
                                name="add-circle-outline"></ion-icon>
                            Agregar</a>
                    </div>
                </div>
            </div>
        </form>

        <?php if ($hayResultados): ?>
            <section class="event__tarjetas">
            <?php foreach ($tipos as $tipo): ?>
    <!-- Tarjeta de cada tipo de mascota -->
    <div class="tarjeta">
                        <div class="tarjeta__detalle">
                            <ul class="detalle-evento">
                                <li><strong>Tipo de mascota:</strong>
                                    <?php echo $tipo['TIPO']; ?>
                                </li>
                                <li class="justificar-texto"><strong>ID Tipo de mascota:</strong>
                                    <?php echo $tipo['IDTIPOMASCOTA']; ?>
                                </li>
                            </ul>
                        </div>
        <!-- Botones -->
        <div class="tarjeta__btn">
            <!-- Editar -->
            <a href="admin_tipos_edit.php?id=<?php echo $tipo['IDTIPOMASCOTA']; ?>"
                class="editar"><ion-icon name="create-sharp"></ion-icon>Editar</a>
        <!-- Eliminar -->
            <form action="" method="post" style="display: inline;">
                <input type="hidden" name="id" value="<?php echo $tipo['IDTIPOMASCOTA']; ?>">
                <button type="submit" class="eliminar"
                    onclick="return confirm('¿Estás seguro de que deseas eliminar este tipo de mascota?')">
                    <ion-icon name="trash-sharp"></ion-icon>Eliminar
                </button>
            </form>
        </div>
    </div>
<?php endforeach; ?>
            </section>
        <?php else: ?>
            <div class="err_busqueda">
                <h2 class="brincar">No se encontraron tipos de mascota que coincidan con la búsqueda.</h2>
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