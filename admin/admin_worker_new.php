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

/*  */
/*if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    $correoUsuario = $usuario['correo'];
    $rolUsuario = $usuario['idRol'];
} else {
    header("Location: ../login.php");
    exit();
}*/
?>
<?php
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
/*
echo '<pre>';
print_r($resultadosC);
echo '</pre>';*/



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

    $nombreImagen = $colaborador->uploadImagen($imagen);

    if (is_array($resultadosCargos) && !empty($resultadosCargos)) {
        $idCargoValido = false;

        foreach ($resultadosCargos as $cargoResultado) {
            if ($cargoResultado['IDCARGO'] == $idCargo) {
                $idCargoValido = true;
                break;
            }
        }

        if (!$idCargoValido) {
            $mensajeError = "El ID del cargo no es válido.";
        }
    } else {
        $mensajeError = "No se pudieron obtener los datos de los cargos.";
    }

    $correoExistente = $colaborador->verificarCorreoExistente($correo);



if ($correoExistente) {
    $mensajeError = "El correo electrónico ya está registrado. Por favor, use otro correo.";
} else {

        $insertado = $colaborador->insertColaborador($nombre, $apellido1, $apellido2, $idCargo, $idEspecialidad, $nombreImagen, $correo, $contrasena, $idRol);

        if ($insertado) {
            header('Location: admin_workers.php');
            exit;
        } else {
            $mensajeError = "Error al insertar el nuevo colaborador.";
        }
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
                            <?php
                            foreach ($resultadosCargos as $cargoResultado) {
                                echo '<option value="' . $cargoResultado['IDCARGO'] . '">' . $cargoResultado['CARGO'] . '</option>';
                            }
                            ?>
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
                            <?php foreach ($resultadosC as $rol): ?>
                                <option value="<?php echo $rol['IDROL']; ?>">
                                    <?php echo $rol['NOMBREROL']; ?>
                                </option>
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
    <?php include '../include/template/footer.php'; ?>
    <!-- JS -->
    <script src="../js/medico.js"></script>
</body>

</html>