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
require_once 'include/database/db_especialidad.php';

$especialidad = new Especialidad();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $especialidadNombre = $_POST['especialidad'];
    $descripcion = $_POST['descripcion'];

    $especialidad->insertEspecialidad($especialidadNombre, $descripcion);

    header('Location: admin_especialidad.php');
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
    <?php $enlaceActivo = 'admin_especialidad';
    include 'include/template/nav.php'; ?>

    <main class="contenedor">

        <div class="btn_atras">
            <a href="admin_especialidad.php" class="boton input-text">Atras</a>
        </div>

        <section class="evento">
            <div class="evento__detalle">
                <h2 class="centrar-texto">Agregar Especialidad</h2>
                <form id="formularioEvento" class="formulario-evento" method="POST">
                    <div class="campo">
                        <label for="especialidad">Especialidad:</label>
                        <input type="text" id="especialidad" name="especialidad" required>
                    </div>
                    <div class="campo">
                        <label for="descripcion">Descripción:</label>
                        <input type="text" id="descripcion" name="descripcion" required>
                    </div>
                    <div class="campo centrar-texto botones_evento">
                        <button class="enviar" type="submit">Agregar Especialidad</button>
                        <a class="cancelar" href="#" onclick="window.history.back();">Cancelar</a>
                    </div>
                </form>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <?php include 'include/template/footer.php'; ?>
    <!-- JS -->
    <script src="js/medico.js"></script>
</body>

</html>
