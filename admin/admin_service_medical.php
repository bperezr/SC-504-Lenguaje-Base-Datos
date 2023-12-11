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

require_once '../include/database/db_servicio.php';
require_once '../include/database/db_colaborador.php';

$colaborador = new Colaborador();
$servicio = new Servicio();

$resultColaborador = $colaborador->getColaboradoresEspecialidad();
$colaboradorDatos = $resultColaborador['datos'];
$resultadoSP1 = $resultColaborador['resultado'];

/* echo '<pre>';
print_r($resultColaborador);
echo '</pre>'; */

$resultServicio = $servicio->getServicios();
$servicioDatos = $resultServicio['datos'];
$resultadoSP1 = $resultServicio['resultado'];

/* echo '<pre>';
print_r($servicioDatos);
echo '</pre>'; */

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
    <?php $enlaceActivo = 'admin_serviciosM';
    include '../include/template/nav.php'; ?>

    <main class="contenedor">

        <section class="evento">
            <div class="evento__detalle">

                <h2 class="centrar-texto">Agregar servicio a Médico</h2>

                <form id="formularioEvento" class="formulario-evento" method="POST">
                    <div class="campo">
                        <label for="colaborador">Colaborador:</label>
                        <select id="colaborador" name="colaborador" onchange="this.form.submit()">
                            <?php foreach ($colaboradorDatos as $colaborador): ?>
                                <option value="<?php echo $colaborador['IDCOLABORADOR']; ?>" <?php echo (isset($_POST['colaborador']) && $_POST['colaborador'] == $colaborador['IDCOLABORADOR']) ? 'selected' : ''; ?>>
                                    <?php echo $colaborador['NOMBRE'] . ' ' . $colaborador['APELLIDO1'] . ' ' . $colaborador['APELLIDO2']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </form>

                <h3>Servicios del Médico:</h3>

                <div id="serviciosContainer">
                    <?php
                    if (isset($_POST['colaborador'])) {
                        $idColaboradorSeleccionado = $_POST['colaborador'];
                        $colaborador = new Colaborador();
                        $result = $colaborador->getServiciosPorColaborador($idColaboradorSeleccionado);

                        if ($result['resultado'] == 1) {
                            $servicios = $result['datos'];
                            echo '<ul>';
                            foreach ($servicios as $servicio) {
                                echo '<li>' . $servicio['SERVICIO'] . '</li>';
                            }
                            echo '</ul>';
                        } else {
                            echo '<p>No se encontraron servicios para este médico.</p>';
                        }
                    }
                    ?>
                </div>

            </div>
        </section>
    </main>

    <!-- Footer -->
    <?php include '../include/template/footer.php'; ?>
    <!-- Mensaje -->
    <?php if (isset($_SESSION['mensaje'])): ?>
        <script>
            window.onload = function () {
                alert("<?php echo $_SESSION['mensaje']; ?>");
                <?php unset($_SESSION['mensaje']); ?>
            };
        </script>
    <?php endif; ?>
</body>

</html>