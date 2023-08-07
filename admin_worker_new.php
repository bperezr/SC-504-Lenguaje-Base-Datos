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
    $nombre = $_POST['nombre'];
    $apellido1 = $_POST['apellido1'];
    $apellido2 = $_POST['apellido2'];
    $edad = $_POST['edad'];
    $idCargo = $_POST['cargo'];
    $idEspecialidad = $_POST['especialidad'];
    $imagen = $_FILES['imagen'];

    $nombreImagen = $colaborador->uploadImagen($imagen);
    $colaborador->insertColaborador($nombre, $apellido1, $apellido2, $edad, $idCargo, $idEspecialidad, $nombreImagen);

    header('Location: admin_workers.php');
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
    <?php $enlaceActivo = 'admin_workers';
    include 'include/template/nav_admin.php'; ?>

    <main class="contenedor">

        <div class="btn_atras">
            <a href="admin_workers.php" class="boton input-text">Atras</a>
        </div>

        <section class="evento">
            <div class="evento__detalle">
                <h2 class="centrar-texto">Agregar Personal</h2>
                <form id="formularioEvento" class="formulario-evento" enctype="multipart/form-data" method="POST">
                    <div class="campo">
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" required>
                    </div>
                    <div class="campo">
                        <label for="apellido1">Apellido 1:</label>
                        <input type="text" id="apellido1" name="apellido1" required>
                    </div>
                    <div class="campo">
                        <label for="apellido2">Apellido 2:</label>
                        <input type="text" id="apellido2" name="apellido2" required>
                    </div>
                    <div class="campo">
                        <label for="edad">Edad:</label>
                        <input type="number" id="edad" name="edad" required>
                    </div>
                    <div class="campo">
                        <label for="cargo">Cargo:</label>
                        <select id="cargo" name="cargo" required>
                            <?php foreach ($cargos as $cargo): ?>
                                <option value="<?php echo $cargo['idCargo']; ?>"><?php echo $cargo['cargo']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="campo">
                        <label for="especialidad">Especialidad:</label>
                        <select id="especialidad" name="especialidad" required>
                            <?php foreach ($especialidades as $especialidad): ?>
                                <option value="<?php echo $especialidad['idEspecialidad']; ?>"><?php echo $especialidad['especialidad']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="campo campo-imagen">
                        <label for="imagen">Imagen:</label>
                        <img id="preview" src="img/no_disponible.webp" alt="no_image">
                        <input type="file" id="imagen" name="imagen" accept="image/*" required>
                    </div>
                    <div class="campo centrar-texto botones_evento">
                        <button class="enviar" type="submit">Agregar Médico</button>
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