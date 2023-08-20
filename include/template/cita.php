<?php
session_start();
require '../connections/connect.php';
require_once '../functions/appointments.php';
require_once '../functions/validar_fecha.php';

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


/* $idColaborador = 33;
$camposDisponibles = $cita->getAsignacionesCitas($idColaborador);
 foreach($camposDisponibles as $cant ){
    echo "<pre>";
    print_r($cant['horaInicio']);
   echo "</pre>";

} */


if (isset($_POST['fechaSeleccionada'])) {

    $fechaSeleccionada = $_POST['fechaSeleccionada'];
    echo "<pre>";
    echo (" variable vf desde validar:  " . $fechaSeleccionada);
    echo "</pre>";

    $idColaborador = 33;

    $camposDisponibles = $cita->getAsignacionesCitas($idColaborador);
    $fechacita = "";
    $hora = "";


    foreach ($camposDisponibles as $citasdisponibles) {
        echo "<pre>";
        print_r($citasdisponibles);
        echo "</pre>";

        $fechacita = $citasdisponibles['fecha'];
        $hora = $citasdisponibles['horaInicio'];

        if ($citasdisponibles['fecha'] == $fechaSeleccionada) {
            echo "<pre>";
            echo ("true ");
            echo "</pre>";
            echo "<pre>";
            echo ($hora);
            echo "</pre>";
        } else {
            echo "false";
        }
    }
}



$db = ConectarDB();

?>
<aside class="sidebar contenido-principal">
    <form class="formulario" id="formulario" method="POST" action="cita.php" enctype="multipart/form-data">
        <fieldset>
            <h3 class="centrar-texto">Programar una cita</h3>
            <div class="contenedor-campos">
                <div class="campo">
                    <label for="nombre">Nombre:</label>
                    <input type="text" placeholder="Nombre completo" id="nombre" name="nombre" value="<?php echo $nombre . " " . $apellido1 . " " . $apellido2; ?>">
                </div>

                <div class="campo">
                    <label for="correo">Correo:</label>
                    <input type="email" placeholder="Correo electrónico" id="correo" name="correo" value="<?php echo $correoUsuario; ?>">
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
                    <select id="servicio" name="servicio">
                        <option value="" disabled selected>Seleccione un servicio</option>
                        <?php
                        $servicios = $cita->getServicios();
                        foreach ($servicios as $serviciosCita) {
                            echo '<option value="' . $serviciosCita . '">' . $serviciosCita['servicio'] . '</option>';
                        }
                        ?>
                    </select>
                </div>


                <div class="campo">
                    <label for="fecha">Fecha:</label>
                    <input type="date" id="fecha" name="fecha" min="<?php echo date('Y-m-d'); ?>" onchange="obtenerHorariosDisponibles()">
                </div>

                <div class="campo">
                    <label for="horario">Horario:</label>
                    <select id="horario" name="horario">
                        <option value="" disabled selected>Seleccione un horario</option>
                        <?php
                        $horarios = $cita->getHorarios();
                        $idColaborador = 33;
                        $camposDisponibles = $cita->getAsignacionesCitas($idColaborador);
                                              
                         /* 
                            foreach ($horarios as $horariosCita) {  
                                if ($horariosCita['horaInicio'] <> $hora )                                              
                                echo '<option value="' . $horariosCita . '">' . $horariosCita['horaInicio'] . '</option>';
                            }
                     
                        */


                        foreach ($camposDisponibles as $citasdisponibles) {                             

                                    foreach ($horarios as $horariosCita) {                                   

                                     if ($horariosCita['horaInicio'] <> $citasdisponibles['horaInicio'] && $fechaSeleccionada == $citasdisponibles['fecha'] ) {                                   
                                        echo '<option value="' . $horariosCita . '">' . $horariosCita['horaInicio'] . '</option>';
                                    }
                                      
                                }                       
                        } 
                        ?>
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

</aside>
<script src="../../js/cita.js"></script>


<script>
    function obtenerHorariosDisponibles() {
        var fechaSeleccionada = document.getElementById("fecha").value;
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "cita.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Respuesta del servidor, puedes hacer algo con ella si es necesario
                console.log(xhr.responseText);
            }
        };
        xhr.send("fechaSeleccionada=" + fechaSeleccionada);
        console.log(fechaSeleccionada);
    }
</script>