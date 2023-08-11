<?php
session_start();

if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    $correoUsuario = $usuario['correo'];
    $rolUsuario = $usuario['idRol'];
} else {
    header("Location: login.php");
    exit();
}
/*  */

require_once 'include/database/db_tipomascota.php';

$c = new TipoMascota();
$resultados = $c->getTipoMascotas();
$hayResultados = true;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idTipoMascota = $_POST['id'];
    $c->deleteTipoMascota($idTipoMascota);
    header('Location: admin_mascotas.php');
    exit;
}

if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
    $resultados = $c->buscarTipoMascota($searchTerm);
    if (count($resultados) === 0) {
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
    <?php $enlaceActivo = 'admin_mascotas';
    include 'include/template/nav.php'; ?>

    <main class="contenedor">

        <h1 class="centrar-texto">Administrar Tipos de Mascotas</h1>

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
                        <a href="admin_mascotas.php"><ion-icon name="refresh-circle"></ion-icon></a>
                    </div>
                </div>
                <div class="buscador buscador_agregar">
                    <!---Agregar-->
                    <div class="agregar">
                        <a href="admin_mascotas_new.php" class="btn_agregar"><ion-icon
                                name="add-circle-outline"></ion-icon>
                            Agregar</a>
                    </div>
                </div>
            </div>
        </form>

        <?php if ($hayResultados): ?>
            <section class="event__tarjetas">
                <?php foreach ($resultados as $tipomascota): ?>
                    <!-- Tarjeta de cada colaborador -->
                    <div class="tarjeta">
                        <div class="tarjeta__detalle">
                            <ul class="detalle-evento">
                                <li><strong>Tipo de mascota:</strong>
                                    <?php echo $tipomascota['tipo']; ?>
                                </li>
                            </ul>
                        </div>
                        <!-- Botones -->
                        <div class="tarjeta__btn">
                            <a href="admin_mascotas_edit.php?id=<?php echo $tipomascota['idTipoMascota']; ?>"
                                class="editar"><ion-icon name="create-sharp"></ion-icon>Editar</a>
                            <form action="" method="post" style="display: inline;">
                                <input type="hidden" name="id" value="<?php echo $tipomascota['idTipoMascota']; ?>">
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
                <img class="" src="img/dog1.webp" alt="">
            </div>
        <?php endif; ?>

    </main>

    <!-- Footer -->
    <?php include 'include/template/footer.php'; ?>
    <!-- JS -->
</body>

</html>