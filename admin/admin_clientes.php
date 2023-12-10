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

require_once '../include/database/db_cliente.php';
$cliente = new Cliente();

$resultados = $cliente->getVerClientes();
$hayResultados = true;


$datosClientes = $resultados['datos'];

if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
    $respuesta = $cliente->buscarClientes($searchTerm);
    $datosClientes = $respuesta['datos'];

    if ($respuesta['numFilas'] >= 1) {
        $hayResultados = true;
    } else {
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
    <?php $enlaceActivo = 'admin_clientes';
    include '../include/template/nav.php'; ?>

    <main class="contenedor">

        <h1 class="centrar-texto">Clientes</h1>

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
                        <a href="admin_clientes.php"><ion-icon name="refresh-circle"></ion-icon></a>
                    </div>
                </div>
            </div>
        </form>

        <?php if ($hayResultados): ?>
            <section class="event__tarjetas">
                <?php foreach ($datosClientes as $cliente): ?>
                    <div class="tarjeta">
                        <div class="tarjeta__imagen">
                            <?php if (file_exists("../img/images_clients/" . $cliente['IMAGEN'])): ?>
                                <img src="../img/images_clients/<?php echo $cliente['IMAGEN']; ?>" alt="Evento 1">
                            <?php else: ?>
                                <img src="../img/no_disponible.webp" alt="Imagen no disponible">
                            <?php endif; ?>
                        </div>
                        <div class="tarjeta__detalle">
                            <!-- Nombre -->
                            <h2>
                                <?php echo $cliente['NOMBRE'] . ' ' . $cliente['APELLIDO1'] . ' ' . $cliente['APELLIDO2']; ?>
                            </h2>
                            <ul class="detalle-evento">
                                <!-- Correo -->
                                <li><strong>Correo:</strong>
                                    <?php echo $cliente['CORREO']; ?>
                                </li>
                                <!-- Telefono -->
                                <li><strong>Teléfono:</strong>
                                    <?php echo $cliente['TELEFONO']; ?>
                                </li>

                            </ul>
                        </div>
                    </div>
                <?php endforeach; ?>
            </section>
        <?php else: ?>
            <div class="err_busqueda">
                <h2 class="brincar">No se encontraron clientes que coincidan con la búsqueda.</h2>
                <img class="" src="../img/dog1.webp" alt="">
            </div>
        <?php endif; ?>

    </main>

    <!-- Footer -->
    <?php include '../include/template/footer.php'; ?>
    <!-- JS -->
</body>

</html>