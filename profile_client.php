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
$mascota = new Mascota();

$provincias = $lugar->getProvincias();
$cantones = $lugar->getCantones();
$distritos = $lugar->getDistritos();

$mensajeError = '';

$clienteD = $cliente->getCliente($id);
$resultadoSP = $clienteD['resultado'];
$clienteData = $clienteD['datos'];

$nombre = $clienteData['nombre'];
$apellido1 = $clienteData['apellido1'];
$apellido2 = $clienteData['apellido2'];
$telefono = $clienteData['telefono'];
$domicilio = $clienteData['domicilio'];
$idProvincia = $clienteData['idProvincia'];
$idCanton = $clienteData['idCanton'];
$idDistrito = $clienteData['idDistrito'];
$imagen = $clienteData['imagen'];

$pro = $lugar->getNombreProvinciaPorID($idProvincia);
$can = $lugar->getNombreCantonPorID($idCanton);
$dis = $lugar->getNombreDistritoPorID($idDistrito);

$provincia = $pro['datos'];
$canton = $can['datos'];
$distrito = $dis['datos'];

// Obtener las mascotas del cliente
$respuestaMascotas = $mascota->getMascotasPorCliente($id);
$mascotas = $respuestaMascotas['datos'];
$resultadoSP = $respuestaMascotas['resultado'];

// Verificar si se obtuvieron resultados
if ($resultadoSP == 0 && !empty($mascotas)) {
    $hayResultados = true;
} else {
    $mensajeError = "No se encontraron mascotas para este cliente.";
    $hayResultados = false;
}

if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
    $respuestaB = $mascota->buscarMascotasPorCliente($id, $searchTerm);
    $mascotas = $respuestaB['datos'];

    if (empty($mascotas)) {
        $hayResultados = false;
    } else {
        $hayResultados = true;
    }
}

/* echo "<pre>";
print_r($respuestaB);
echo "</pre>";
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idMascota = $_POST['idMascota'];

    $mascotaInfo = $mascota->getMascota($idMascota);

    if ($mascotaInfo['resultado'] == 0 && !empty($mascotaInfo['datos'])) {
        $nombreImagen = $mascotaInfo['datos']['imagen'];

        // Primero, intentar eliminar la mascota
        $resultadoSP = $mascota->deleteMascota($idMascota);

        if ($resultadoSP == 0) {
            // Si la mascota se elimina con éxito, proceder a eliminar la imagen del servidor
            if ($mascota->deleteImagen($nombreImagen)) {
                $_SESSION['mensaje'] = "Mascota e imagen eliminadas con éxito.";
            } else {
                $_SESSION['mensaje'] = "Mascota eliminada, no se encontro la imagen.";
            }
        } elseif ($resultadoSP == 0) {
            $_SESSION['mensaje'] = "No se encontró la mascota para eliminar.";
        } else {
            $_SESSION['mensaje'] = "Ocurrió un error al intentar eliminar la mascota.";
        }
    } else {
        $_SESSION['mensaje'] = "No se encontró información de la mascota para eliminar.";
    }

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
            <h2>dirección</h2>
            <div class="perfil__detalle">
                <div class="perfil__detalle-info">
                    <p>Provincia:
                        <?php echo $provincia; ?>
                    </p>
                    <p>Canton:
                        <?php echo $canton; ?>
                    </p>
                    <p>Distrito:
                        <?php echo $distrito; ?>
                    </p>
                    <p>Direccion:
                        <?php echo $clienteData['domicilio']; ?>
                    </p>
                </div>
            </div>

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
            <!-- Mascotas -->
            <?php if ($hayResultados): ?>
                <section class="perfil__mascota">
                    <?php foreach ($mascotas as $mascota): ?>
                        <!-- Tarjeta mascota -->
                        <div class="perfil__mascota-card">
                            <!-- Imagen -->
                            <div class="contenedor__mascota-img">
                                <div class="mascota__img">
                                    <?php if (isset($mascota['IMAGEN']) && file_exists("img/images_pets/" . $mascota['IMAGEN'])): ?>
                                        <img src="img/images_pets/<?php echo $mascota['IMAGEN']; ?>" alt="Imagen de la mascota">
                                    <?php else: ?>
                                        <img src="img/no_disponible.webp" alt="Imagen no disponible">
                                    <?php endif; ?>
                                </div>
                            </div>
                            <!-- Nombre -->
                            <div class="mascota__detalle">
                                <h4>
                                    <?php echo $mascota['NOMBRE']; ?>
                                </h4>
                            </div>
                            <!-- Botones -->
                            <div class="tarjeta__btn">
                                <!-- Editar -->
                                <a href="pet_edit.php?id=<?php echo $mascota['IDMASCOTA']; ?>" class="editar"><ion-icon
                                        name="create-sharp"></ion-icon>Editar</a>
                                <!-- Eliminar -->
                                <form action="" method="post" style="display: inline;">
                                    <input type="hidden" name="idMascota" value="<?php echo $mascota['IDMASCOTA']; ?>">
                                    <button type="submit" class="eliminar"
                                        onclick="return confirm('¿Estás seguro de que deseas eliminar esta mascota?')">
                                        <ion-icon name="trash-sharp"></ion-icon>Eliminar
                                    </button>
                                </form>

                            </div>
                        </div>
                    <?php endforeach; ?>
                </section>
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