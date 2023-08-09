<?php
require_once 'include/database/db_especialidad.php';

$especialidad = new Especialidad();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_GET['id'];
    $especialidadNombre = $_POST['especialidad'];
    $descripcion = $_POST['descripcion'];

    $especialidad->updateEspecialidad($id, $especialidadNombre, $descripcion);

    header('Location: admin_especialidad.php');
    exit;
} else {

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $especialidadData = $especialidad->getEspecialidad($id);
        if (!$especialidadData) {
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
    <?php $rutaCSS = 'css/admin_workers.css';
    include 'include/template/header.php'; ?>
</head>

<body>
    <!-- Nav template -->
    <?php $enlaceActivo = 'admin_especialidad';
    include 'include/template/nav_admin.php'; ?>

    <main class="contenedor">

        <div class="btn_atras">
            <a href="admin_especialidades.php" class="boton input-text">Atras</a>
        </div>

        <section class="evento">
            <div class="evento__detalle">
                <h2 class="centrar-texto">Editar Especialidad</h2>
                <form id="formularioEvento" class="formulario-evento" method="POST">
                    <div class="campo">
                        <label for="especialidad">Especialidad:</label>
                        <input type="text" id="especialidad" name="especialidad"
                            value="<?php echo $especialidadData['especialidad']; ?>" required>
                    </div>
                    <div class="campo">
                        <label for="descripcion">Descripción:</label>
                        <input type="text" id="descripcion" name="descripcion"
                            value="<?php echo $especialidadData['descripcion']; ?>" required>
                    </div>
                    <div class="campo centrar-texto botones_evento">
                        <button class="enviar" type="submit">Guardar Cambios</button>
                        <a class="cancelar" href="admin_especialidades.php">Cancelar</a>
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
