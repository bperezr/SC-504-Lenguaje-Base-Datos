<?php
session_start();

if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    $correoUsuario = $usuario['correo'];
    $rolUsuario = $usuario['idRol'];
    $rol = $usuario['rol'];
    $id = $usuario['id'];
}

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['idRol'] != 3) {
    header("Location: acceso_denegado.php");
    exit();
}

require_once 'include/database/db_cita.php';
$cita = new Cita();
$mascotasCliente = $cita->getMascotasCliente($id);
$servicios = $cita->getServicios();

/* echo "<pre>";
print_r($mascotasCliente);
echo "</pre>";

echo "<pre>";
print_r($servicios);
echo "</pre>"; */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idCliente = $id;
    $idMascota = $_POST['mascota'];
    $idServicio = $_POST['servicio'];
    $fecha = $_POST['fecha'];
    $idHorario = $_POST['horario'];
    $idColaborador = $_POST['colaborador'];

    echo "<pre>";
    print_r($idCliente);
    print_r($idMascota);
    print_r($idServicio);
    print_r($fecha);
    print_r($idHorario);
    print_r($idColaborador);
    echo "</pre>";

    // Insertar cita en la tabla 'citas'
    $cita->insertCita($idCliente, $idMascota, $idServicio, $fecha, $idHorario);

    // Obtén el ID de la cita recién insertada
    $idCita = $cita->getLastInsertId();

    // Insertar asignación de cita en la tabla 'asignacioncitas'
    $idColaborador = $_POST['colaborador'];
    $cita->insertAsignacionCita($idCita, $idColaborador);

/*     header('Location: profile_client.php');
    exit; */
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
                            <?php foreach ($mascotasCliente as $mascota): ?>
                                <option value="<?php echo $mascota['idMascota']; ?>"><?php echo $mascota['nombre']; ?>
                                </option>
                            <?php endforeach; ?>
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
                </div><!-- contenedor-campos -->

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
    <!-- JS -->
    <script>
        $(document).ready(function () {
            $('#servicio').on('change', function () {
                var selectedServicio = $(this).val();
                if (selectedServicio !== "") {
                    $.ajax({
                        url: 'include/functions/get_medicos.php',
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
                        url: 'include/functions/get_horarios_disponibles.php',
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
                var diaSemana = fechaInput.getDay(); // 0: domingo, 6: sábado
                // Verificar si es sábado o domingo
                if (diaSemana === 0 || diaSemana === 6) {
                    // Sumar días para obtener el siguiente día laboral (lunes)
                    fechaInput.setDate(fechaInput.getDate() + (diaSemana === 0 ? 1 : 2));
                }
                // Obtener la fecha mínima permitida (día actual)
                var fechaMinima = new Date($('#fecha').attr('min'));
                // Si la fecha actual es menor que la fecha mínima, ajustarla
                if (fechaInput < fechaMinima) {
                    $('#fecha').val(fechaMinima.toISOString().slice(0, 10)); // Formato yyyy-mm-dd
                }
            }
        });
    </script>
</body>

</html>