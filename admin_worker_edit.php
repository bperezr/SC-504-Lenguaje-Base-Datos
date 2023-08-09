<?php
require_once 'include/database/db_colaborador.php';
require_once 'include/database/db_cargo.php';
require_once 'include/database/db_especialidad.php';

$colaborador = new Colaborador();
$cargo = new Cargo();
$especialidad = new Especialidad();

$cargos = $cargo->getCargos();
$especialidades = $especialidad->getEspecialidades();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_GET['id'];
    $nombre = $_POST['nombre'];
    $apellido1 = $_POST['apellido1'];
    $apellido2 = $_POST['apellido2'];
    $edad = $_POST['edad'];
    $idCargo = $_POST['cargo'];
    $idEspecialidad = $_POST['especialidad'];

    if ($_FILES['imagen']['tmp_name']) {
        $imagen = $_FILES['imagen'];
        $nombreImagen = $colaborador->uploadImagen($imagen);
        $colaboradorData = $colaborador->getColaborador($id);

        if ($colaboradorData && file_exists("img/images_workers/" . $colaboradorData['imagen'])) {
            unlink("img/images_workers/" . $colaboradorData['imagen']);
        }
    } else {
        $colaboradorData = $colaborador->getColaborador($id);
        $nombreImagen = $colaboradorData['imagen'];
    }

    $colaborador->updateColaborador($id, $nombre, $apellido1, $apellido2, $edad, $idCargo, $idEspecialidad, $nombreImagen);

    header('Location: admin_workers.php');
    exit;
} else {

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $colaboradorData = $colaborador->getColaborador($id);
        if (!$colaboradorData) {
            header('Location: admin_workers.php');
            exit;
        }
    } else {
        header('Location: admin_workers.php');
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
    <?php $enlaceActivo = 'admin_workers';
    include 'include/template/nav_admin.php'; ?>

    <main class="contenedor">

        <div class="btn_atras">
            <a href="admin_workers.php" class="boton input-text">Atras</a>
        </div>

        <section class="evento">
            <div class="evento__detalle">
                <h2 class="centrar-texto">Editar Personal</h2>
                <form id="formularioEvento" class="formulario-evento" enctype="multipart/form-data" method="POST">
                    <div class="campo">
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" value="<?php echo $colaboradorData['nombre']; ?>"
                            required>
                    </div>
                    <div class="campo">
                        <label for="apellido1">Apellido 1:</label>
                        <input type="text" id="apellido1" name="apellido1"
                            value="<?php echo $colaboradorData['apellido1']; ?>" required>
                    </div>
                    <div class="campo">
                        <label for="apellido2">Apellido 2:</label>
                        <input type="text" id="apellido2" name="apellido2"
                            value="<?php echo $colaboradorData['apellido2']; ?>" required>
                    </div>
                    <div class="campo">
                        <label for="edad">Edad:</label>
                        <input type="number" id="edad" name="edad" value="<?php echo $colaboradorData['edad']; ?>"
                            required>
                    </div>
                    <div class="campo">
                        <label for="cargo">Cargo:</label>
                        <select id="cargo" name="cargo" required>
                            <?php foreach ($cargos as $cargo): ?>
                                <option value="<?php echo $cargo['idCargo']; ?>" <?php echo ($colaboradorData['idCargo'] == $cargo['idCargo']) ? 'selected' : ''; ?>>
                                    <?php echo $cargo['cargo']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="campo">
                        <label for="especialidad">Especialidad:</label>
                        <select id="especialidad" name="especialidad" required>
                            <?php foreach ($especialidades as $especialidad): ?>
                                <option value="<?php echo $especialidad['idEspecialidad']; ?>" <?php echo ($colaboradorData['idEspecialidad'] == $especialidad['idEspecialidad']) ? 'selected' : ''; ?>>
                                    <?php echo $especialidad['especialidad']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="campo campo-imagen">
                        <label for="imagen">Imagen:</label>
                        <img id="preview" src="img/images_workers/<?php echo $colaboradorData['imagen']; ?>"
                            alt="Imagen actual">
                        <input type="file" id="imagen" name="imagen" accept="image/*">
                    </div>
                    <div class="campo centrar-texto botones_evento">
                        <button class="enviar" type="submit">Guardar Cambios</button>
                        <a class="cancelar" href="admin_workers.php">Cancelar</a>
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