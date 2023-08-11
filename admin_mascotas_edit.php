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

$tipoMascota = new TipoMascota();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_GET['id'];
    $nombre = $_POST['tipo'];

    $tipoMascotaData = $tipoMascota->getTipoMascota($id);

    $tipoMascota->updateTipoMascota($id, $nombre);

    header('Location: admin_mascotas.php');
    exit;
} else {

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $tipoMascotaData = $tipoMascota->getTipoMascota($id);
        if (!$tipoMascotaData) {
            header('Location: admin_mascotas.php');
            exit;
        }
    } else {
        header('Location: admin_mascotas.php');
        exit;
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

        <div class="btn_atras">
            <a href="admin_mascotas.php" class="boton input-text">Atras</a>
        </div>

        <section class="evento">
            <div class="evento__detalle">
                <h2 class="centrar-texto">Editar Personal</h2>
                <form id="formularioMascota" class="formulario-evento" enctype="multipart/form-data" method="POST">
                    <div class="campo">
                        <label for="tipo">Tipo de Mascota:</label>
                        <input type="text" id="tipo" name="tipo" value="<?php echo $tipoMascotaData['tipo']; ?>"
                            required>
                    </div>
                    <div class="campo centrar-texto botones_evento">
                        <button class="enviar" type="submit">Guardar Cambios</button>
                        <a class="cancelar" href="admin_mascotas.php">Cancelar</a>
                    </div>
                </form>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <?php include 'include/template/footer.php'; ?>
    <!-- JS -->

</body>

</html>