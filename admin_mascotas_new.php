<?php
if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    $correoUsuario = $usuario['correo'];
    $rolUsuario = $usuario['idRol'];

if ($rolUsuario == 2) {
        header("Location: acceso_denegado.php");
        exit();

    } elseif ($rolUsuario == 3) {
        header("Location: acceso_denegado.php");
        exit();

    } else {
        header("Location: login.php");
        exit();
    }
}

/*  */
require_once 'include/database/db_tipomascota.php';

$tipomascota = new TipoMascota();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo = $_POST['tipo'];

    $tipomascota->insertTipoMascota($tipo);

    header('Location: admin_mascotas.php');
    exit;
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
                <h2 class="centrar-texto">Agregar Tipo de Mascota</h2>
                <form id="formularioMascota" class="formulario-evento" enctype="multipart/form-data" method="POST">
                    <div class="campo">
                        <label for="tipo">Tipo de Mascota:</label>
                        <input type="text" id="tipo" name="tipo" required>
                    <div class="campo centrar-texto botones_evento">
                        <button class="enviar" type="submit">Agregar Tipo de Mascota</button>
                        <a class="cancelar" href="#" onclick="window.history.back();">Cancelar</a>
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