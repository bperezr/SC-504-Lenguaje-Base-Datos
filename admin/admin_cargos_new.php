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
    header("Location: ../acceso_denegado.php");
    exit();
}

/*  */
require_once '../include/database/db_cargo.php';
$cargo = new Cargo();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nuevoCargo = $_POST['nuevo_cargo'];
    $cargo->insertCargo($nuevoCargo);
    header('Location: admin_cargos.php');
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
    <?php $enlaceActivo = 'admin_workers';
    include '../include/template/nav.php'; ?>

    <main class="contenedor">

        <div class="btn_atras">
            <a href="admin_cargos.php" class="boton input-text">Atras</a>
        </div>

        <section class="evento">
            <div class="evento__detalle">
                <h2 class="centrar-texto">Agregar Cargo</h2>
                <form id="formularioEvento" class="formulario-evento" method="POST">
                    <div class="campo">
                        <label for="nuevo_cargo">Nuevo Cargo:</label>
                        <input type="text" id="nuevo_cargo" name="nuevo_cargo" required>
                    </div>
                    <div class="campo centrar-texto botones_evento">
                        <button class="enviar" type="submit">Agregar Cargo</button>
                        <a class="cancelar" href="admin_cargos.php">Cancelar</a>
                    </div>
                </form>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <?php include '../include/template/footer2.php'; ?>
    <!-- JS -->
    <script src="../js/medico.js"></script>
</body>

</html>