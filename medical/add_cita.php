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
$dServicio = isset($servicios['datos']) ? $servicios['datos'] : [];

$horarioscita = $cita->getHorariosCitas();
$dHorarioscita = isset($horarioscita['datos']) ? $horarioscita['datos'] : [];


/* echo "<pre>";
print_r($servicios);
echo "</pre>";
 */

$correoCliente = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['colaborador'])) {
        $idCliente = $_POST['IDCLIENTE'];
        $idMascota = $_POST['MASCOTA'];
        $idServicio = $_POST['SERVICIO'];
        $fecha = $_POST['fecha'];
        $idHorario = $_POST['horario'];
        $idColaborador = $_POST['colaborador'];

        if($idColaborador){
            $resultadoInsercion= $cita->insertCita($idCliente, $idMascota, $idServicio, $fecha, $idHorario,1);

            if ($resultadoInsercion === 0) {
                // Inserción exitosa
                $_SESSION['mensaje'] = "Cita creada.";
        
                header('Location: cita_vista.php');
                exit;
            } else {
                $_SESSION['mensaje'] = "Error al crear la cita.";
            }
            
        }
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
                <select id="SERVICIO" name="SERVICIO" onchange="cargarMedicos()">
                    <option value="" disabled selected>Seleccione un servicio</option>
                    <?php foreach ($dServicio as $servicio): ?>
                        <option value="<?php echo $servicio['IDSERVICIO']; ?>"><?php echo $servicio['SERVICIO']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="campo" id="campoMedico">
                        <label for="colaborador">Médico:</label>
                        <select id="colaborador" name="colaborador">
                            <option value="" disabled selected>Seleccione un médico</option>
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
                            <?php foreach ($dHorarioscita as $horario): ?>
                                <option value="<?php echo $horario['IDHORARIO']; ?>">
                                    <?php echo $horario['HORAINICIO']; ?>
                                </option>
                            <?php endforeach; ?>
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
         function cargarMedicos() {
            var servicioSeleccionado = document.getElementById("SERVICIO").value;
            var selectMedico = document.getElementById("colaborador");
            selectMedico.innerHTML = "<option value='' disabled selected>Seleccione un médico</option>";

            if (servicioSeleccionado) {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '../include/functions/get_medicos.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function () {
                    if (this.status === 200) {
                        var medicos = JSON.parse(this.responseText);
                        if (medicos.length > 0) {
                            medicos.forEach(function (medico) {
                                var option = document.createElement("option");
                                option.value = medico.IDCOLABORADOR;
                                option.text = medico.NOMBRE + ' ' + medico.APELLIDO1;
                                selectMedico.appendChild(option);
                            });
                        } else {
                            var option = document.createElement("option");
                            option.value = "";
                            option.text = "No hay médicos disponibles";
                            option.disabled = true;
                            selectMedico.appendChild(option);
                        }
                    }
                };
                xhr.send('idServicio=' + servicioSeleccionado);
            }
        }
</script>
    
</body>

</html>