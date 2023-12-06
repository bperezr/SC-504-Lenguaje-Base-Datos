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

/*  */
require_once '../include/database/db_especialidad.php';

$especialidad = new Especialidad();
$mensajeAlerta = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_GET['id'];
    $especialidadNombre = $_POST['especialidad'];
    $descripcion = $_POST['descripcion'];

    $resultadoSP = $especialidad->updateEspecialidad($id, $especialidadNombre, $descripcion);


    if ($resultadoSP == 1) {
        $_SESSION['mensaje'] = "¡Actualización exitosa!";
    } elseif ($resultadoSP == 0) {
        $_SESSION['mensaje'] = "No se encontró ninguna fila para actualizar.";
    } else {
        $_SESSION['mensaje'] = "Ocurrió un error durante la actualización.";
    }
    header('Location: admin_especialidad.php');
    exit;

} else {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $especialidadData = $especialidad->getEspecialidad($id);

        if (!$especialidadData['datos']) {
            header('Location: admin_especialidades.php');
            exit;
        }
    } else {
        header('Location: admin_especialidades.php');
        exit;
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
    <?php $enlaceActivo = 'admin_especialidad';
    include '../include/template/nav.php'; ?>

    <main class="contenedor">

        <div class="btn_atras">
            <a href="admin_especialidad.php" class="boton input-text">Atras</a>
        </div>

        <section class="evento">
            <div class="evento__detalle">
                <h2 class="centrar-texto">Editar Especialidad</h2>
                <form id="formularioEvento" class="formulario-evento" method="POST">

                    <div class="campo">
                        <label for="especialidad">Especialidad:</label>
                        <input type="text" id="especialidad" name="especialidad"
                            value="<?php echo $especialidadData['datos']['especialidad']; ?>" required>
                    </div>
                    <div class="campo">
                        <label for="descripcion">Descripción:</label>
                        <input type="text" id="descripcion" name="descripcion"
                            value="<?php echo $especialidadData['datos']['descripcion']; ?>" required>
                    </div>

                    <div class="campo centrar-texto botones_evento">
                        <button class="enviar" type="submit">Guardar Cambios</button>
                        <a class="cancelar" href="admin_especialidad.php">Cancelar</a>
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