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
        <form class="formulario" id="formulario">
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
                            <option value="8:00 AM">8:00 AM</option>
                            <option value="10:00 AM">9:00 AM</option>
                            <option value="2:00 PM">10:00 AM</option>
                            <option value="4:00 PM">11:00 AM</option>
                            <option value="8:00 AM">1:00 PM</option>
                            <option value="10:00 AM">2:00 PM</option>
                            <option value="2:00 PM">3:00 PM</option>
                            <option value="4:00 PM">4:00 PM</option>
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
    </script>
</body>

</html>