<?php
session_start();
/*
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
*/
/*  */


require_once '../include/database/db_colaborador.php';
require_once '../include/database/db_cargo.php';
require_once '../include/database/db_especialidad.php';

$colaborador = new Colaborador();
$cargo = new Cargo();
$especialidad = new Especialidad();

$cargos = $cargo->getCargos();
$resultadosCargos = $cargos['datos'];

$especialidades = $especialidad->getEspecialidades();
$resultadosEspecialidades = $especialidades['datos'];

$c = $colaborador->getRoles();
$resultadosC = $c['datos'];



$mensajeAlerta = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_GET['id'];
    $nombre = $_POST['nombre'];
    $apellido1 = $_POST['apellido1'];
    $apellido2 = $_POST['apellido2'];
    $idCargo = $_POST['cargo'];
    $idEspecialidad = $_POST['especialidad'];
    $correo = $_POST['correo'];
    $idRol = $_POST['rol'];

    $colaboradorData = $colaborador->getColaborador($id);
    // Manejo de la imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $imagen = $_FILES['imagen'];
        $nombreImagen = $colaborador->uploadImagen($imagen);
        // Eliminar imagen anterior
        if ($colaboradorData && file_exists("../img/images_workers/" . $colaboradorData['imagen'])) {
            unlink("../img/images_workers/" . $colaboradorData['imagen']);
        }
    } else {
        $nombreImagen = $colaboradorData['imagen'];
    }


    $colaborador->updateColaborador($id, $nombre, $apellido1, $apellido2, $idCargo, $idEspecialidad, $nombreImagen, $correo, $idRol);

    header('Location: admin_workers.php');
    exit;
} else {
    // Obtener detalles del colaborador para editar
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
    <?php $rutaCSS = '../css/admin_workers.css';
    include '../include/template/header.php'; ?>
</head>

<body>
    <!-- Nav template -->
    <?php $enlaceActivo = 'admin_workers';
    include '../include/template/nav.php'; ?>

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
                        <input type="text" id="nombre" name="nombre"
                            value="<?php echo $colaboradorData['datos']['nombre']; ?>" required>
                    </div>
                    <div class="campo">
                        <label for="apellido1">Apellido 1:</label>
                        <input type="text" id="apellido1" name="apellido1"
                            value="<?php echo $colaboradorData['datos']['apellido1']; ?>" required>
                    </div>
                    <div class="campo">
                        <label for="apellido2">Apellido 2:</label>
                        <input type="text" id="apellido2" name="apellido2"
                            value="<?php echo $colaboradorData['datos']['apellido2']; ?>" required>
                    </div>
                    <div class="campo">
                        <label for="cargo">Cargo:</label>
                        <select id="cargo" name="cargo" required>
                            <?php
                            foreach ($resultadosCargos as $cargoResultado) {
                                echo '<option value="' . $cargoResultado['idCargo'] . '">' . $cargoResultado['CARGO'] . '</option>';
                            }
                            ?>
                        </select>
                        </select>
                    </div>


                    <div class="campo">
                        <label for="especialidad">Especialidad:</label>
                        <select id="especialidad" name="especialidad" required>
                            <?php foreach ($resultadosEspecialidades as $resultadosEspecialidad): ?>
                                <option value="<?php echo $resultadosEspecialidad['IDESPECIALIDAD']; ?>">
                                    <?php echo $resultadosEspecialidad['ESPECIALIDAD']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="campo">
                        <label for="correo">Correo:</label>
                        <input type="text" id="correo" name="correo"
                            value="<?php echo $colaboradorData['datos']['correo']; ?>" required readonly>
                    </div>

                    <!-- Imagen -->
                    <div id="formularioEvento" class="campo campo-imagen">
                        <label for="imagen">Imagen:</label>
                        <?php if (file_exists("../img/images_workers/" . $colaboradorData['datos']['imagen'])): ?>
                            <img id="preview" src="../img/images_workers/<?php echo $colaboradorData['datos']['imagen']; ?>"
                                alt="Imagen actual">
                        <?php else: ?>
                            <img id="preview" src="../img/no_disponible.webp" alt="Imagen no disponible">
                        <?php endif; ?>
                        <input type="file" id="imagen" name="imagen" accept="image/*">
                    </div>

                    <div class="campo">
                        <label for="rol">Rol:</label>
                        <select id="rol" name="rol" required>
                            <?php foreach ($resultadosC as $rol): ?>
                                <option value="<?php echo $rol['IDROL']; ?>">
                                    <?php echo $rol['NOMBREROL']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
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
    <?php include '../include/template/footer.php'; ?>
    <!-- JS -->
    <script src="../js/medico.js"></script>
</body>

</html>