<?php
require_once 'include/database/db_cliente.php';

$cliente = new Cliente();

$mensajeError = '';

$nombre = null;
$apellido1 = null;
$apellido2 = null;
$telefono = null;
$imagen = null;
$domicilio = null;
$idProvincia = null;
$idCanton = null;
$idDistrito = null;
$idRol = null;
$correo = null;
$resultado = null;

$cliente->getCliente(5, $nombre, $apellido1, $apellido2, $telefono, $imagen, $domicilio, $idProvincia, $idCanton, $idDistrito, $idRol, $correo, $resultado);

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
                            <?php echo $nombre; ?>
                        </p>
                        <p class="apellido">
                            <?php echo $apellido1; ?>
                            <?php echo $apellido2; ?>
                        </p>
                        <div class="detalle">
                            <p>Telefono:
                                <?php echo $telefono; ?>
                            </p>
                            <p>Correo:
                                <?php echo $correo; ?>
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

        </section>
    </main>
    <!-- Footer -->
    <?php include 'include/template/footer.php'; ?>
    <!-- JS -->
</body>

</html>