<?php
session_start();

if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    $correoUsuario = $usuario['correo'];
    $rolUsuario = $usuario['idRol'];
    $rol = $usuario['rol'];
    $id = $usuario['id'];
}

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['idRol'] != 3) {
    header("Location: acceso_denegado.php");
    exit();
}

/*  */
require_once 'include/database/db_cliente.php';
require_once 'include/database/db_lugar.php';
require_once 'include/database/db_mascota.php';

$cliente = new Cliente();
$lugar = new Lugar();

$provincias = $lugar->getProvincias();
$cantones = $lugar->getCantones();
$distritos = $lugar->getDistritos();

$mensajeError = '';

$clienteData = $cliente->getCliente($id);
/* echo "<pre>";
print_r($clienteData);
echo "</pre>"; */

$nombre = $clienteData['nombre'];
$apellido1 = $clienteData['apellido1'];
$apellido2 = $clienteData['apellido2'];
$telefono = $clienteData['telefono'];
$domicilio = $clienteData['domicilio'];
$idProvincia = $clienteData['idProvincia'];
$idCanton = $clienteData['idCanton'];
$idDistrito = $clienteData['idDistrito'];
$imagen = $clienteData['imagen'];

/* Mascotas */
$hayResultados = true;
$mascota = new Mascota();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idMascota = $_POST['id'];
    $mascota->deleteMascota($idMascota);
    header('Location: profile_client.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <!-- styles -->
    <?php $rutaCSS = 'css/client_profile.css';
    include 'include/template/header.php'; ?>
</head>

<body>
    <!-- Nav template -->
    <?php
    $enlaceActivo = 'perfil';
    include 'include/template/nav.php';
    ?>

    <main class="contenedor">

        <h1 class="centrar-texto">Perfil de Usuario</h1>

        <section class="perfil">
            <!-- Encabezado -->
            <div class="perfil__head">
                <div class="perfil__head-sec1">
                    <div class="imagen">
                        <img src="img/images_clients/<?php echo $imagen; ?>" alt="">
                    </div>
                    <div class="head-sec2">
                        <p class="nombre">
                            <?php echo $clienteData['nombre']; ?>
                        </p>
                        <p class="apellido">
                            <?php echo $clienteData['apellido1']; ?>
                            <?php echo $clienteData['apellido2']; ?>
                        </p>
                        <div class="detalle">
                            <p>Telefono:
                                <?php echo $clienteData['telefono']; ?>
                            </p>
                            <p>Correo:
                                <?php echo $clienteData['correo']; ?>
                            </p>
                            <div></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="perfil__bnt">
                <a href="profile_client_edit.php" class="btn-1">Editar Perfil</a>
                <a href="cita.php" class="btn-2">Agendar cita</a>
            </div>

            <!-- Informacion -->

            <h2>Direccion</h2>

            <div class="perfil__detalle">
                <div class="perfil__detalle-info">
                    <p>Provincia:
                        <?php echo $lugar->obtenerNombreProvinciaPorID($clienteData['idProvincia']); ?>
                    </p>
                    <p>Canton:
                        <?php echo $lugar->obtenerNombreCantonPorID($clienteData['idCanton']); ?>
                    </p>
                    <p>Distrito:
                        <?php echo $lugar->obtenerNombreDistritoPorID($clienteData['idDistrito']); ?>
                    </p>
                    <p>Direccion:
                        <?php echo $clienteData['domicilio']; ?>
                    </p>
                </div>
            </div>

            <!-- Mascotas -->
            <h2>Mascotas</h2>

            <!-- Buscador -->
            <form action="profile_client.php" method="get">
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
                            <a href="profile_client.php"><ion-icon name="refresh-circle"></ion-icon></a>
                        </div>
                    </div>
                    <div class="buscador buscador_agregar">
                        <!---Agregar-->
                        <div class="agregar">
                            <a href="pet_new.php" class="btn_agregar"><ion-icon name="add-circle-outline"></ion-icon>
                                Agregar</a>
                        </div>
                    </div>
                </div>
                </div>
            </form>

            <div class="perfil__mascota">
                <?php
                $mascota = new Mascota();
                $todasLasMascotas = $mascota->getMascotasPorCliente($id);

                if (isset($_GET['search'])) {
                    $searchTerm = $_GET['search'];
                    $mascotas = $mascota->buscarMascotas($id, $searchTerm);
                    if (count($mascotas) === 0) {
                        $hayResultados = false;
                    } else {
                        $hayResultados = true;
                    }
                }
                ?>

                <?php if ((isset($_GET['search']) && $hayResultados) || !isset($_GET['search'])): ?>
                    <?php foreach ((isset($_GET['search']) && $hayResultados) ? $mascotas : $todasLasMascotas as $mascota): ?>
                        <!-- Tarjeta mascota -->
                        <div class="perfil__mascota-card">
                            <div class="contenedor__mascota-img">
                                <div class="mascota__img">
                                    <?php if (isset($mascota['imagen']) && file_exists("img/images_pets/" . $mascota['imagen'])): ?>
                                        <img src="img/images_pets/<?php echo $mascota['imagen']; ?>" alt="Imagen de la mascota">
                                    <?php else: ?>
                                        <img src="img/no_disponible.webp" alt="Imagen no disponible">
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="mascota__detalle">
                                <h4>
                                    <?php echo $mascota['nombre']; ?>
                                </h4>
                            </div>
                            <!-- Botones -->
                            <div class="tarjeta__btn">
                                <a href="pet_edit.php?id=<?php echo $mascota['idMascota']; ?>" class="editar"><ion-icon
                                        name="create-sharp"></ion-icon>Editar</a>
                                <form action="" method="post" style="display: inline;">
                                    <input type="hidden" name="id" value="<?php echo $mascota['idMascota']; ?>">
                                    <button type="submit" class="eliminar"
                                        onclick="return confirm('¿Estás seguro de que deseas eliminar esta mascota?')">
                                        <ion-icon name="trash-sharp"></ion-icon>Eliminar
                                    </button>
                                </form>
                            </div>

                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="err_busqueda">
                        <h2 class="brincar">No se encontraron mascotas que coincidan con la búsqueda.</h2>
                        <img class="" src="img/dog1.webp" alt="no encontrado">
                    </div>
                <?php endif; ?>
            </div>

        </section>
    </main>
    <!-- Footer -->
    <?php include 'include/template/footer.php'; ?>
    <!-- JS -->
</body>

</html>