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
if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    $correoUsuario = $usuario['correo'];
    $rolUsuario = $usuario['idRol'];
} else {
    header("Location: ../login.php");
    exit();
}
?>
<?php
require_once '../include/database/db_colaborador.php';
require_once '../include/database/db_cargo.php';
require_once '../include/database/db_especialidad.php';

$colaborador = new Colaborador();
$cargo = new Cargo();
$especialidad = new Especialidad();

$cargos = $cargo->getCargos();
$especialidades = $especialidad->getEspecialidades();

$mensajeError = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre = $_POST['nombre'];
    $apellido1 = $_POST['apellido1'];
    $apellido2 = $_POST['apellido2'];
    $idCargo = $_POST['cargo'];
    $idEspecialidad = $_POST['especialidad'];
    $imagen = $_FILES['imagen'];
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];
    $idRol = $_POST['rol'];

    $correoExistente = $colaborador->verificarCorreoExistente($correo);

    if ($correoExistente) {
        $mensajeError = "El correo electrónico ya está registrado. Por favor, use otro correo.";
    } else {
        $nombreImagen = $colaborador->uploadImagen($imagen);
        $colaborador->insertColaborador($nombre, $apellido1, $apellido2, $idCargo, $idEspecialidad, $nombreImagen, $correo, $contrasena, $idRol);

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

                <h2 class="centrar-texto">Agregar Personal</h2>

                <div class="mensaje-error">
                    <?php echo $mensajeError; ?>
                </div>

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

                    <div class="campo">
                        <label for="correo">Correo:</label>
                        <input type="text" id="correo" name="correo" required>
                    </div>

                    <div class="campo">
                        <label for="contrasena">Contraseña:</label>
                        <input type="password" id="contrasena" name="contrasena" required>
                    </div>
                    <div class="campo campo-imagen">
                        <label for="imagen">Imagen:</label>
                        <img id="preview" src="../img/no_disponible.webp" alt="no_image">
                        <input type="file" id="imagen" name="imagen" accept="image/*">
                    </div>

                    <div class="campo">
                        <label for="rol">Rol:</label>
                        <select id="rol" name="rol" required>
                            <?php foreach ($colaborador->getRoles() as $rol): ?>
                                <option value="<?php echo $rol['idRol']; ?>"><?php echo $rol['nombreRol']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="campo centrar-texto botones_evento">
                        <button class="enviar" type="submit">Agregar</button>
                        <a class="cancelar" href="#" onclick="window.history.back();">Cancelar</a>
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