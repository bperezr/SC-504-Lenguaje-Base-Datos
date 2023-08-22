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

require_once '../include/database/db_cita.php';
require_once '../include/database/db_cliente.php';
$cita = new Cita();
$cliente = new Cliente();

$mascotasCliente = $cita->getMascotasCliente($id);
$servicios = $cita->getServicios();
$correoCliente = '';

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
        <form class="formulario" id="formulario" method="POST" action="admin_cita.php">
            <fieldset>
                <h3 class="centrar-texto">Agendar cita</h3>

                <label for="correoCliente">Buscar cliente por correo:</label>
                <input type="email" name="correoCliente" id="correoCliente" value="<?php echo $correoCliente; ?>">
                <button type="submit" name="buscarCliente">Buscar</button>

                <?php
                if (isset($_POST['buscarCliente'])) {
                    $correoCliente = $_POST['correoCliente'];

                    $cliente = $cliente->obtenerClientePorCorreo($correoCliente);

                    if ($cliente) {
                        echo "<p>Cliente encontrado:</p>";
                        echo "<p>ID de Cliente: " . $cliente['idCliente'] . "</p>";
                        echo "<p>Nombre: " . $cliente['nombre'] . " " . $cliente['apellido1'] . " " . $cliente['apellido2'] . "</p>";
                    } else {
                        echo "<p>Cliente no encontrado.</p>";
                    }
                }
                ?>

                <div class="campo" id="campoMascota">
                    <label for="mascota">Mascota:</label>
                    <select id="mascota" name="mascota">
                        <option value="" disabled selected>Seleccione la mascota</option>
                        <?php
                        if ($cliente) {
                            $mascotasCliente = $cita->getMascotasCliente($cliente['idCliente']);

                            if (!empty($mascotasCliente)) {
                                foreach ($mascotasCliente as $mascota) {
                                    echo "<option value='" . $mascota['idMascota'] . "'>" . $mascota['nombre'] . "</option>";
                                }
                            } else {
                                echo "<option value='' disabled>No hay mascotas registradas para este cliente</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="campo">
                    <label for="servicio">Servicio:</label>
                    <select id="servicio" name="servicio">
                        <option value="" disabled selected>Seleccione un servicio</option>
                        <?php foreach ($servicios as $servicio): ?>
                            <option value="<?php echo $servicio['idServicio']; ?>"><?php echo $servicio['servicio']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="campo" id="campoMedico" style="display: none;">
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
                    <select id="horario" name="horario">
                        <option value="" disabled selected>Seleccione un horario</option>
                    </select>
                </div>
                </div>

                <div class="boton-contacto">
                    <input class="boton input-text" type="submit" value="Enviar" name="nuevaCita">
                </div>
            </fieldset>
        </form>
        <?php
        if (isset($_POST['nuevaCita'])) {
            $cliente['idCliente'];
            $idMascota = $_POST['mascota'];
            $idServicio = $_POST['servicio'];
            $fecha = $_POST['fecha'];
            $idHorario = $_POST['horario'];
            $idColaborador = $_POST['colaborador'];

            $cita->insertCita($idCliente, $idMascota, $idServicio, $fecha, $idHorario);
            $idCita = $cita->getLastInsertId();
            $idColaborador = $_POST['colaborador'];
            $cita->insertAsignacionCita($idCita, $idColaborador);

            header('Location: admin_cita.php');
            exit;
        }
        ?>
    </main>

    <!-- Footer -->
    <?php include '../include/template/footer.php'; ?>
    <!-- JS -->
    <script>
        $(document).ready(function () {
            $('#servicio').on('change', function () {
                var selectedServicio = $(this).val();
                if (selectedServicio !== "") {
                    $.ajax({
                        url: '../include/functions/get_medicos.php',
                        method: 'POST',
                        data: { servicio: selectedServicio },
                        dataType: 'json',
                        success: function (data) {
                            var selectMedico = $('#colaborador');
                            selectMedico.empty();
                            selectMedico.append('<option value="" disabled selected>Seleccione un médico</option>');
                            $.each(data, function (index, medico) {
                                selectMedico.append('<option value="' + medico.idColaborador + '">' + medico.nombre + ' ' + medico.apellido1 + '</option>');
                            });
                            $('#campoMedico').show();
                        }
                    });
                } else {
                    $('#campoMedico').hide();
                }
            });


            $('#servicio').on('change', function () {
                var selectedServicio = $(this).val();
                if (selectedServicio !== "") {
                    $.ajax({
                        url: '../include/functions/get_medicos.php',
                        method: 'POST',
                        data: { servicio: selectedServicio },
                        dataType: 'json',
                        success: function (data) {
                            var selectMedico = $('#colaborador');
                            selectMedico.empty();
                            selectMedico.append('<option value="" disabled selected>Seleccione un médico</option>');
                            $.each(data, function (index, medico) {
                                selectMedico.append('<option value="' + medico.idColaborador + '">' + medico.nombre + ' ' + medico.apellido1 + '</option>');
                            });
                            $('#campoMedico').show();
                        }
                    });
                } else {
                    $('#campoMedico').hide();
                }
            });

            $('#fecha').on('change', function () {
                var selectedFecha = $(this).val();
                var selectedMedico = $('#colaborador').val();

                if (selectedFecha && selectedMedico) {
                    $.ajax({
                        url: '../include/functions/get_horarios_disponibles.php',
                        method: 'POST',
                        data: { fecha: selectedFecha, medico: selectedMedico },
                        dataType: 'json',
                        success: function (data) {
                            var selectHorario = $('#horario');
                            selectHorario.empty();
                            selectHorario.append('<option value="" disabled selected>Seleccione un horario</option>');
                            $.each(data, function (index, horario) {
                                selectHorario.append('<option value="' + horario.idHorario + '">' + horario.horaInicio + ' - ' + horario.horaFin + '</option>');
                            });
                            $('#campoHorario').show();
                        }
                    });
                } else {
                    $('#campoHorario').hide();
                }
            });
            function validarFecha() {
                var fechaInput = new Date($('#fecha').val());
                var diaSemana = fechaInput.getDay();
                if (diaSemana === 0 || diaSemana === 6) {
                    fechaInput.setDate(fechaInput.getDate() + (diaSemana === 0 ? 1 : 2));
                }
                var fechaMinima = new Date($('#fecha').attr('min'));
                if (fechaInput < fechaMinima) {
                    $('#fecha').val(fechaMinima.toISOString().slice(0, 10));
                }
            }
        });

    </script>
</body>

</html>