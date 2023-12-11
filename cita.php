<?php
session_start();

if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    $correoUsuario = isset($usuario['correo']) ? $usuario['correo'] : '';
    $rolUsuario = isset($usuario['idRol']) ? $usuario['idRol'] : '';
    $rol = isset($usuario['rol']) ? $usuario['rol'] : '';
    $id = isset($usuario['id']) ? $usuario['id'] : '';
}

if (!isset($_SESSION['usuario']) || $rolUsuario != 3) {
    header("Location: acceso_denegado.php");
    exit();
}

require_once 'include/database/db_cita.php';
require_once 'include/database/db_colaborador.php';
require_once 'include/database/db_mascota.php';
require_once 'include/database/db_servicio.php';

$cita = new Cita();
$medico = new Colaborador();
$mascota = new Mascota();
$servicio = new Servicio();

$mascotasCliente = $mascota->getMascotasPorCliente($id);
$dMascota = isset($mascotasCliente['datos']) ? $mascotasCliente['datos'] : [];

$servicios = $servicio->getServicios();
$dServicio = isset($servicios['datos']) ? $servicios['datos'] : [];

$horarioscita = $cita->getHorariosCitas();
$dHorarioscita = isset($horarioscita['datos']) ? $horarioscita['datos'] : [];

$colaboradorServicio = [];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idCliente = $id;
    $idMascota = isset($_POST['mascota']) ? $_POST['mascota'] : null;
    $idServicio = isset($_POST['servicio']) ? $_POST['servicio'] : null;
    $fecha = isset($_POST['fecha']) ? $_POST['fecha'] : null;
    $fechaFormateada = ($fecha !== null) ? date('d/m/y', strtotime($fecha)) : null;

    $idHorario = isset($_POST['horario']) ? $_POST['horario'] : null;
    $idColaborador = isset($_POST['colaborador']) ? $_POST['colaborador'] : null;
    $idEstado = 1;

    // Insertar la cita y obtener el resultado
    $resultadoInsercion = $cita->insertCita($idCliente, $idMascota, $idServicio, $fechaFormateada, $idHorario, $idEstado);

    if ($resultadoInsercion === 0) {
        // Inserción exitosa
        $_SESSION['mensaje'] = "Cita creada.";

        //header('Location: cita_vista.php');
        //exit;
    } else {
        $_SESSION['mensaje'] = "Error al crear la cita.";
    }
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <!-- styles -->
    <?php $rutaCSS = 'css/services_info.css';
    include 'include/template/header.php'; ?>
</head>

<body>
    <!-- Nav template -->
    <?php $enlaceActivo = 'cita';
    include 'include/template/nav.php'; ?>

    <main class="contenedor">
        <form class="formulario" id="formulario" method="POST" action="cita.php">
            <fieldset>
                <h3 class="centrar-texto">Agendar cita</h3>
                <div class="contenedor-campos">
                    <div class="campo">
                        <label for="nombre">Usuario:</label>
                        <input type="text" placeholder="Nombre completo" id="nombre" name="nombre" readonly
                            value="<?php echo $correoUsuario; ?>">
                    </div>

                    <div class="campo">
                        <label for="mascota">Mascota:</label>
                        <select id="mascota" name="mascota">
                            <option value="" disabled selected>Seleccione la mascota</option>
                            <?php foreach ($dMascota as $mascota): ?>
                                <option value="<?php echo $mascota['IDMASCOTA']; ?>">
                                    <?php echo $mascota['NOMBRE']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="campo">
                        <label for="servicio">Servicio:</label>
                        <select id="servicio" name="servicio" onchange="cargarMedicos()">
                            <option value="" disabled selected>Seleccione un servicio</option>
                            <?php foreach ($dServicio as $servicio): ?>
                                <option value="<?php echo $servicio['IDSERVICIO']; ?>">
                                    <?php echo $servicio['SERVICIO']; ?>
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
                        <input type="date" id="fecha" name="fecha" min="<?php echo date('Y-m-d'); ?>"
                            oninput="validarFecha()">
                    </div>

                    <div class="campo">
                        <label for="horario">Horario:</label>
                        <select id="horario" name="horario" onchange="cargarMedicos()">
                            <option value="" disabled selected>Seleccione un horario</option>
                            <?php foreach ($dHorarioscita as $horario): ?>
                                <option value="<?php echo $horario['IDHORARIO']; ?>">
                                    <?php echo $horario['HORAINICIO']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                </div>

                <div class="boton-contacto">
                    <input class="boton input-text" type="submit" value="Enviar">
                </div>

                <div class="contenedor-mensaje">
                </div>
            </fieldset>
        </form>
    </main>

    <!-- Footer -->
    <?php include 'include/template/footer.php'; ?>
    <!--  -->
    <script>
        function cargarMedicos() {
            var servicioSeleccionado = document.getElementById("servicio").value;
            var selectMedico = document.getElementById("colaborador");
            selectMedico.innerHTML = "<option value='' disabled selected>Seleccione un médico</option>";

            if (servicioSeleccionado) {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'include/functions/get_medicos.php', true);
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