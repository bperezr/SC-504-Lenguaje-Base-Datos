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

require_once '../include/database/db_cargo.php';
<<<<<<< Updated upstream

$cargo = new Cargo();
$hayResultados = false;
$idCargo = null;
$resultados = $cargo->getCargos();
$cargosData = $resultados['datos'];
/*echo '<pre>';
print_r($resultados);
echo '</pre>';*/

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idCargo = $_POST['id'];
    $hayResultados = true;
    
    $cargo->deleteCargo($idCargo);
=======
$cargo = new cargo();


$respuesta = $cargo->getCargo();
$resultadoSP = $respuesta['resultado'];
$cargoes = $respuesta['datos'];

if ($resultadoSP == 1) {
    $hayResultados = true;
} elseif ($resultadoSP == 0) {
    $mensajeError = "No se encontraron cargos.";
    $hayResultados = false;
} else {
    $mensajeError = "Ocurrió un error al recuperar los cargos.";
    $hayResultados = false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idcargo = $_POST['id'];

    $resultadoSP = $cargo->deleteCargo($idcargo);

    if ($resultadoSP == 1) {
        $_SESSION['mensaje'] = "cargo eliminado con éxito.";
    } elseif ($resultadoSP == 0) {
        $_SESSION['mensaje'] = "No se encontró el cargo para eliminar.";
    } else {
        $_SESSION['mensaje'] = "Ocurrió un error al intentar eliminar el cargo.";
    }

>>>>>>> Stashed changes
    header('Location: admin_cargo.php');
    exit;
}

<<<<<<< Updated upstream
// Obtener los cargos después de verificar la solicitud POST
$resultados = $cargo->getCargos($idCargo);
$cargoData = $resultados['datos'];

if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
    $resultados = $cargo->buscarCargos($searchTerm);
    if (count($resultados['datos']) === 0) {
        $hayResultados = false;
    } else {
        $hayResultados = true;
    }
}
?>

=======
$hayResultados = true;

if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
    $cargo = $cargo->buscarCargos($searchTerm);

    if (empty($cargo)) {
        $hayResultados = false;
    }
}

?>
>>>>>>> Stashed changes

<!DOCTYPE html>
<html lang="es">

<head>
    <!-- styles -->
    <?php $rutaCSS = '../css/admin_workers.css';
    include '../include/template/header.php'; ?>
</head>

<body>

    <!-- Nav template -->
    <?php $enlaceActivo = 'admin_cargo';
    include '../include/template/nav.php'; ?>

    <main class="contenedor">

        <h1 class="centrar-texto">Administrar cargos</h1>

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
                        <a href="admin_cargo.php"><ion-icon name="refresh-circle"></ion-icon></a>
                    </div>
                </div>
                <div class="buscador buscador_agregar">
                    <!---Agregar-->
                    <div class="agregar">
                        <a href="admin_cargo_new.php" class="btn_agregar"><ion-icon
                                name="add-circle-outline"></ion-icon>
                            Agregar</a>
                    </div>
                </div>
            </div>
        </form>

        <?php if ($hayResultados): ?>
            <section class="event__tarjetas">
<<<<<<< Updated upstream
            <?php foreach ($resultados as $resultados): ?>
    <!-- Tarjeta de cada cargo -->
    <div class="tarjeta">
        <div class="tarjeta__imagen">
            <?php if (isset($resultados['IMAGEN']) && file_exists("../img/images_workers/" . $resultados['IMAGEN'])): ?>
                <img src="../img/images_workers/<?php echo $resultados['IMAGEN']; ?>" alt="Evento 1">
            <?php else: ?>
                <img src="../img/no_disponible.webp" alt="Imagen no disponible">
            <?php endif; ?>
        </div>
        <div class="tarjeta__detalle">
            <h2>
                <?php
                 echo $resultados['IDCARGO'] . ' ' . $resultados['CARGO ']; 
                ?>
            </h2>
            <ul class="detalle-evento">
                <li><strong>Cargo:</strong>
                    <?php echo isset($resultados['IDCARGO']) ? $resultados['IDCARGO'] : ''; ?>
                </li>
                <li><strong>Especialidad:</strong>
                    <?php echo isset($resultados['IDCARGO']) ? $resultados['IDCARGO'] : ''; ?>
                </li>
            </ul>
        </div>
        <!-- Botones -->
        <div class="tarjeta__btn">
            <a href="admin_worker_edit.php?id=<?php echo $resultados['IDCARGO']; ?>"
                class="editar"><ion-icon name="create-sharp"></ion-icon>Editar</a>
            <form action="" method="post" style="display: inline;">
                <input type="hidden" name="id" value="<?php echo $cargo['IDCARGO']; ?>">
                <button type="submit" class="eliminar"
                    onclick="return confirm('¿Estás seguro de que deseas eliminar este cargo?')">
                    <ion-icon name="trash-sharp"></ion-icon>Eliminar
                </button>
            </form>
        </div>
    </div>
<?php endforeach; ?>
=======
                <?php foreach ($cargo as $cargo): ?>
                    <!-- Tarjeta de cada cargo -->
                    <div class="tarjeta">
                        <div class="tarjeta__detalle">
                            <ul class="detalle-evento">
                                <li><strong>cargo:</strong>
                                    <?php echo $cargo['cargo']; ?>
                                </li>
                            </ul>
                        </div>
                        <!-- Botones -->
                        <div class="tarjeta__btn">
                            <!-- Editar -->
                            <a href="admin_cargo_edit.php?id=<?php echo $cargo['idCargo']; ?>"
                                class="editar"><ion-icon name="create-sharp"></ion-icon>Editar</a>
                            <!-- Eliminar -->
                            <form action="" method="post" style="display: inline;">
                                <input type="hidden" name="id" value="<?php echo $cargo['idCargo']; ?>">
                                <button type="submit" class="eliminar"
                                    onclick="return confirm('¿Estás seguro de que deseas eliminar este cargo?')">
                                    <ion-icon name="trash-sharp"></ion-icon>Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
>>>>>>> Stashed changes
            </section>
        <?php else: ?>
            <div class="err_busqueda">
                <h2 class="brincar">No se encontraron cargos que coincidan con la búsqueda.</h2>
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