<?php
session_start();
require '../connections/connect.php';
require_once '../functions/appointments.php';
require_once '../database/db_colaborador.php';

if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    $correoUsuario = $usuario['correo'];
    $rolUsuario = $usuario['idRol'];
    $rol = $usuario['rol'];
    $id = $usuario['id'];
    $nombre = $usuario['nombre'];
    $apellido1 = $usuario['apellido1'];
    $apellido2 = $usuario['apellido2'];
}
$cita = new Appointment();
$medico = new Colaborador();

$db = ConectarDB();

/* ------------------------------ */
$idColaborador = 33;
$camposDisponibles = $cita->getAsignacionesCitas($idColaborador);
echo "<pre>";
print_r($camposDisponibles);
echo "</pre>";

$servicio = $medico->getMedicosPorServicio(3);
echo "<pre>";
print_r($servicio);
echo "</pre>";



/* ------------------------------ */

?>

<aside class="sidebar contenido-principal">
    <form class="formulario" id="formulario" method="POST" action="cita.php" enctype="multipart/form-data">
        <fieldset>
            <h3 class="centrar-texto">Programar una cita</h3>
            <div class="contenedor-campos">
                <div class="contenedor-campos">
                    <div class="campo">
                        <label for="nombre">Nombre:</label>
                        <input type="text" placeholder="Nombre completo" id="nombre" name="nombre"
                            value="<?php echo $nombre . " " . $apellido1 . " " . $apellido2; ?>">
                    </div>

                    <div class="campo">
                        <label for="correo">Correo:</label>
                        <input type="email" placeholder="Correo electrónico" id="correo" name="correo"
                            value="<?php echo $correoUsuario; ?>">
                    </div>

                    <div class="campo">
                        <label for="mascota">Mascota:</label>
                        <select id="mascota" name="mascota">
                            <option value="" disabled selected>Seleccione la mascota</option>
                            <?php
                            $mascotas = $cita->getMascotasCliente($id);
                            foreach ($mascotas as $cantMascotas) {
                                echo '<option value="' . $cantMascotas . '">' . $cantMascotas['nombre'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="campo">
                        <label for="servicio">Servicio:</label>
                        <select id="servicio" name="servicio" onchange="obtenerMedicosPorServicio()">
                            <option value="" disabled selected>Seleccione un servicio</option>
                            <?php
                            $servicios = $cita->getServicios();
                            foreach ($servicios as $servicio) {
                                echo '<option value="' . $servicio['idServicio'] . '">' . $servicio['nombreServicio'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>


                    <div class="campo" id="campo-medicos">
                        <!-- Aquí se mostrarán los médicos por servicio -->
                    </div>



                    <div class="campo">
                        <label for="fecha">Fecha:</label>
                        <input type="date" id="fecha" name="fecha" min="<?php echo date('Y-m-d'); ?>">
                    </div>

                    <div class="campo">
                        <button type="button" onclick="obtenerHorariosDisponibles()">Mostrar Horarios
                            Disponibles</button>
                    </div>

                    <div class="campo" id="horarios-disponibles">
                        <label for="horario">Horario:</label>
                        <select id="horario" name="horario">
                            <option value="" disabled selected>Seleccione un horario</option>
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
</aside>

<script>
function obtenerMedicosPorServicio() {
    var servicioSeleccionado = document.getElementById("servicio").value;
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "obtener_medicos.php?servicio=" + servicioSeleccionado, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById("campo-medicos").innerHTML = xhr.responseText;
        }
    };
    xhr.send();
}

    function obtenerHorariosDisponibles() {
        var fechaSeleccionada = document.getElementById("fecha").value;
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "obtener_horarios_disponibles.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                document.getElementById("horarios-disponibles").innerHTML = xhr.responseText;
            }
        };
        xhr.send("fechaSeleccionada=" + fechaSeleccionada);
    }
</script>