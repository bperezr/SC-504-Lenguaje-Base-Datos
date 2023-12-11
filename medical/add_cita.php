<?php
session_start();


if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    $correoUsuario = $usuario['correo'];
    $rolUsuario = $usuario['idRol'];
    $rol = $usuario['rol'];
    $id = $usuario['id'];
}

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['idRol'] != 2) {
    header("Location: ../acceso_denegado.php");
    exit();
}

require_once '../include/database/db_cita.php';
require_once '../include/database/db_cliente.php';
require_once '../include/database/db_mascota.php';
require_once '../include/database/db_servicio.php';
require_once '../include/database/db_colaborador.php';

$cita = new Cita();
$cliente = new Cliente();
$mascotas = new Mascota();
$servicio = new Servicio();
$colaborador = new Colaborador();

$servicios = $servicio->getServicios();
$serviciosData = $servicios['datos'];


if (isset($_GET['idServicio'])) {
    $idServicio = $_GET['idServicio'];
    
    // Crear una instancia de tu clase P_COLABORADOR (ajusta el nombre de la clase según tu implementación)

    // Llamar a la función getMedicosPorServicio para obtener los datos
    $resultado = $colaborador->getMedicosPorServicio($idServicio);

    // Devolver los datos en formato JSON
    header('Content-Type: application/json');
    echo json_encode($resultado['datos']);
} else {
    // Manejar el caso en que no se proporciona el parámetro esperado
    echo 'Error: Falta el parámetro idServicio';
}



/* echo "<pre>";
print_r($servicios);
echo "</pre>";
 */

if ($resultadoSP == 0 && !empty($mascotaData)) {
    $hayResultados = true;
} else {
    $mensajeError = "No se encontraron mascotas para este cliente.";
    $hayResultados = false;
}


$correoCliente = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['idCliente'])) {
        $idCliente = $_POST['idCliente'];
        $idMascota = $_POST['mascota'];
        $idServicio = $_POST['servicio'];
        $fecha = $_POST['fecha'];
        $idHorario = $_POST['horario'];
        $idColaborador = $_POST['colaborador'];

        $cita->insertCita($idCliente, $idMascota, $idServicio, $fecha, $idHorario,1);
                    $idCita = $cita->getLastInsertId();
                    $idColaborador = $_POST['colaborador'];
                    $cita->insertAsignacionCita($idCita, $idColaborador);

                    header('Location: medical_appointments.php');
                    exit;     
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <!-- styles -->
    <?php $rutaCSS = '../css/services_info.css';
    include '../include/template/header.php'; ?>
</head>

<body>
    <!-- Nav template -->
    <?php $enlaceActivo = 'cita';
    include '../include/template/nav.php'; ?>

    <main class="contenedor">
        <form class="formulario" id="formulario1" method="POST">
            <h3 class="centrar-texto">Agendar cita</h3>

            <?php
            if (isset($_POST['buscarCliente'])) {
                $correoCliente = $_POST['correoCliente'];

                $cliente = $cliente->obtenerClientePorCorreo($correoCliente);
                $clienteData = $cliente['datos'];

                if ($clienteData) {
                    echo "<p>Cliente encontrado:</p>";
                    echo "<p>ID de Cliente: " . $clienteData['idCliente'] . "</p>";
                    echo "<p>Nombre: " . $clienteData['nombre'] . " " . $clienteData['apellido1'] . " " . $clienteData['apellido2'] . "</p>";
                } else {
                    echo "<p>Cliente no encontrado.</p>";
                }
            }
            ?>
            <label for="correoCliente">Buscar cliente por correo:</label>
            <input type="email" name="correoCliente" id="correoCliente" value="<?php echo $correoCliente; ?>">
            <button type="submit" name="buscarCliente">Buscar</button>

            <input type="hidden" name="IDCLIENTE" id="IDCLIENTE" value="<?php echo $clienteData['idCliente']; ?>">

            <div class="campo" id="campoMascota">
                <label for="mascota">Mascota:</label>
                <select id="mascota" name="MASCOTA">
                    <option value="" disabled selected>Seleccione la mascota</option>
                    <?php
                    if ($clienteData) {
                        $mascotasCliente = $mascotas->getMascotasPorCliente($clienteData['idCliente']);                      
                        $mascotaData = $mascotasCliente['datos'];

                        if (!empty($mascotaData)) {
                            foreach ($mascotaData as $mascotasCliente) {                            
                                echo "<option value='" . $mascotasCliente['IDMASCOTA'] . "'>" . $mascotasCliente['NOMBRE'] . "</option>";
                            }
                        } else {
                            echo "<option value='' disabled>No hay mascotas registradas para este cliente</option>";
                        }
                    }

                    ?>
                </select>
            </div>

            <div class="campo">
                <label for="SERVICIO">Servicio:</label>
                <select id="SERVICIO" name="SERVICIO">
                    <option value="" disabled selected>Seleccione un servicio</option>
                    <?php foreach ($serviciosData as $servicio): ?>
                        <option value="<?php echo $servicio['IDSERVICIO']; ?>"><?php echo $servicio['SERVICIO']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="campo" id="campoMedico">
                <label for="colaborador">Médico:</label>
                <select id="colaborador" name="colaborador">         

                </select>
            </div>

            <div class="campo">
                <label for="fecha">Fecha:</label>
                <input type="date" id="fecha" name="fecha" min="<?php echo date('Y-m-d'); ?>" oninput="validarFecha()">
            </div>


            <div class="campo">
                <label for="horario">Horario:</label>
                <select id="horario" name="horario">
                    <option value="" disabled selected>Seleccione un horario</option>
                </select>
            </div>

            <div class="boton-contacto">
                <input class="boton input-text" type="submit" value="Enviar" name="nuevaCita">
            </div>

        </form>
    </main>

    <!-- Footer -->
    <?php include '../include/template/footer2.php'; ?>
    <!-- JS -->

    <script>
</script>
    
</body>

</html>