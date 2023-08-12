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
    header("Location: acceso_denegado.php");
    exit();
}

/*  */
require_once 'include/database/db_cargo.php';
$cargo = new Cargo();

$cargos = $cargo->getCargos();
$hayResultados = true;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idCargo = $_POST['id'];
    $cargo->deleteCargo($idCargo);
    header('Location: admin_cargos.php');
    exit;
}

if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
    $cargos = $cargo->buscarCargos($searchTerm);
    if (count($cargos) === 0) {
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
    <?php $rutaCSS = 'css/admin_workers.css';
    include 'include/template/header.php'; ?>
</head>

<body>
    <!-- Nav template -->
    <?php $enlaceActivo = 'admin_cargos';
    include 'include/template/nav.php'; ?>

    <main class="contenedor">
        <h1 class="centrar-texto">Administrar Cargos</h1>

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
                        <a href="admin_cargos.php"><ion-icon name="refresh-circle"></ion-icon></a>
                    </div>
                </div>
                <div class="buscador buscador_agregar">
                    <!---Agregar-->
                    <div class="agregar">
                        <a href="admin_cargos_new.php" class="btn_agregar"><ion-icon
                                name="add-circle-outline"></ion-icon>
                            Agregar</a>
                    </div>
                </div>
            </div>
        </form>

        <?php if ($hayResultados): ?>
            <section class="event__tarjetas">
                <?php foreach ($cargos as $cargo): ?>
                    <!-- Tarjeta de cada cargo -->
                    <div class="tarjeta">
                        <div class="tarjeta__detalle">
                            <ul class="detalle-evento">
                                <li><strong>Cargo:</strong>
                                    <?php echo $cargo['cargo']; ?>
                                </li>
                            </ul>
                        </div>
                        <!-- Botones -->
                        <div class="tarjeta__btn">
                            <a href="admin_cargos_edit.php?id=<?php echo $cargo['idCargo']; ?>" class="editar"><ion-icon
                                    name="create-sharp"></ion-icon>Editar</a>
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
            </section>
        <?php else: ?>
            <div class="err_busqueda">
                <h2 class="brincar">No se encontraron cargos que coincidan con la búsqueda.</h2>
                <img class="" src="img/dog1.webp" alt="">
            </div>
        <?php endif; ?>

    </main>

    <!-- Footer -->
    <?php include 'include/template/footer.php'; ?>
    <!-- JS -->
</body>

</html>