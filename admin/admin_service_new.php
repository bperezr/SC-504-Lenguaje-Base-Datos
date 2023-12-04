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

require_once '../include/database/db_servicio.php';

$servicio = new Servicio();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $servicioNombre = $_POST['servicio'];
    $descripcion = $_POST['descripcion'];

    $resultadoSP = $servicio->insertServicio($servicioNombre, $descripcion);

    if ($resultadoSP == 1) {
        $_SESSION['mensaje'] = "Éxito en la inserción.";
    } else {
        $_SESSION['mensaje'] = "Ocurrió un error durante la inserción.";
    }
    header('Location: admin_services.php');
    exit;
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
    <?php $enlaceActivo = 'admin_services';
    include '../include/template/nav.php'; ?>

    <main class="contenedor">

        <div class="btn_atras">
            <a href="admin_services.php" class="boton input-text">Atrás</a>
        </div>

        <section class="evento">
            <div class="evento__detalle">
                <h2 class="centrar-texto">Agregar servicio</h2>
                <form id="formularioEvento" class="formulario-evento" method="POST">
                    <div class="campo">
                        <label for="servicio">Servicio:</label>
                        <input type="text" id="servicio" name="servicio" required>
                    </div>
                    <div class="campo">
                        <label for="descripcion">Descripción:</label>
                        <input type="text" id="descripcion" name="descripcion" required>
                    </div>
                    <div class="campo centrar-texto botones_evento">
                        <button class="enviar" type="submit">Agregar servicio</button>
                        <a class="cancelar" href="#" onclick="window.history.back();">Cancelar</a>
                    </div>
                </form>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <?php include '../include/template/footer.php'; ?>
    <!-- JS -->
    <script src="../js/medico.js"></script>
</body>

</html>