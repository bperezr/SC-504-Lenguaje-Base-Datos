<?php
session_start();
/*
if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    $correoUsuario = $usuario['correo'];
    $rolUsuario = $usuario['idRol'];
    $rol = $usuario['rol'];
    $id = $usuario['id'];
}

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['idRol'] != 1) {
    header("Location: acceso_denegado.php");
    exit();
}
*/
require_once '../include/database/db_colaborador.php';

$c = new Colaborador();
$resultados = $c->getColaboradores();
$colaborador = $resultados['datos'];
/*echo '<pre>';
print_r($resultados);
echo '</pre>';*/
$hayResultados = true;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idColaborador = $_POST['id'];
    
    $c->deleteColaborador($idColaborador);
    header('Location: admin_workers.php');
    exit;
}


if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
    $resultados = $c->buscarColaboradores($searchTerm);
    if (count($resultados) === 0) {
        $hayResultados = false;
    } else {
        $hayResultados = true;
    }
}



/*

require_once '../include/database/db_colaborador.php';
$c = new Colaborador();

$respuesta = $c->getColaboradores();
$resultadoSP = $respuesta['resultado'];
$colaboradores = $respuesta['datos'];

if ($resultadoSP == 1) {
    $hayResultados = true;
} elseif ($resultadoSP == 0) {
    $mensajeError = "No se encontraron especialidades.";
    $hayResultados = false;
} else {
    $mensajeError = "Ocurrió un error al recuperar las especialidades.";
    $hayResultados = false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idColaborador = $_POST['id'];

    $resultadoSP = $c->deleteColaborador($idColaborador);

    if ($resultadoSP == 1) {
        $_SESSION['mensaje'] = "Colaborador eliminado con éxito.";
    } elseif ($resultadoSP == 0) {
        $_SESSION['mensaje'] = "No se encontró el colaborador para eliminar.";
    } else {
        $_SESSION['mensaje'] = "Ocurrió un error al intentar eliminar el colaborador.";
    }

    header('Location: admin_workers.php');
    exit;
}

$hayResultados = true;

if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
    $colaboradores = $c->buscarEspecialidades($searchTerm);

    if (empty($colaboradores)) {
        $hayResultados = false;
    }
}*/
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
    <?php $enlaceActivo = 'admin_workers';
    include '../include/template/nav.php'; ?>

    <main class="contenedor">

        <h1 class="centrar-texto">Administrar Personal</h1>

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
                        <a href="admin_workers.php"><ion-icon name="refresh-circle"></ion-icon></a>
                    </div>
                </div>
                <div class="buscador buscador_agregar">
                    <!---Agregar-->
                    <div class="agregar">
                        <a href="admin_worker_new.php" class="btn_agregar"><ion-icon
                                name="add-circle-outline"></ion-icon>
                            Agregar</a>
                    </div>
                </div>
            </div>
        </form>

        <?php if ($hayResultados): ?>
            <section class="event__tarjetas">
            <?php foreach ($colaborador as $colaborador): ?>
    <!-- Tarjeta de cada colaborador -->
    <div class="tarjeta">
        <div class="tarjeta__imagen">
            <?php if (isset($colaborador['IMAGEN']) && file_exists("../img/images_workers/" . $colaborador['IMAGEN'])): ?>
                <img src="../img/images_workers/<?php echo $colaborador['IMAGEN']; ?>" alt="Evento 1">
            <?php else: ?>
                <img src="../img/no_disponible.webp" alt="Imagen no disponible">
            <?php endif; ?>
        </div>
        <div class="tarjeta__detalle">
            <h2>
                <?php
                 echo $colaborador['NOMBRE'] . ' ' . $colaborador['APELLIDO1'] . ' ' . $colaborador['APELLIDO2']; 
                ?>
            </h2>
            <ul class="detalle-evento">
                <li><strong>Cargo:</strong>
                    <?php echo isset($colaborador['IDCARGO']) ? $colaborador['IDCARGO'] : ''; ?>
                </li>
                <li><strong>Especialidad:</strong>
                    <?php echo isset($colaborador['IDESPECIALIDAD']) ? $colaborador['IDESPECIALIDAD'] : ''; ?>
                </li>
            </ul>
        </div>
        <!-- Botones -->
        <div class="tarjeta__btn">
            <a href="admin_worker_edit.php?id=<?php echo $colaborador['IDCOLABORADOR']; ?>"
                class="editar"><ion-icon name="create-sharp"></ion-icon>Editar</a>
            <form action="" method="post" style="display: inline;">
                <input type="hidden" name="id" value="<?php echo $colaborador['IDCOLABORADOR']; ?>">
                <button type="submit" class="eliminar"
                    onclick="return confirm('¿Estás seguro de que deseas eliminar este colaborador?')">
                    <ion-icon name="trash-sharp"></ion-icon>Eliminar
                </button>
            </form>
        </div>
    </div>
<?php endforeach; ?>
            </section>
        <?php else: ?>
            <div class="err_busqueda">
                <h2 class="brincar">No se encontraron eventos que coincidan con la búsqueda.</h2>
                <img class="" src="../img/dog1.webp" alt="">
            </div>
        <?php endif; ?>

    </main>

    <!-- Footer -->
    <?php include '../include/template/footer.php'; ?>
    <!-- JS -->
</body>

</html>