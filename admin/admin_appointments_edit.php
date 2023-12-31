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
    header("Location: acceso_denegado.php");
    exit();
}

/*  */
$id = $_GET['id'];
require 'include/connections/connect.php';
$db = ConectarDB();

$queryCitas = "SELECT
                c.*,
                hi.horaInicio,
                hi.horaFin,
                m.tipo as tipoMascota,
                s.servicio as nombreServicio,
                n.nombre as nombreCliente
                FROM citas as c
                join horariocitas as hi on c.idHorario = hi.idHorario
                join tipomascota as m on c.idMascota =  m.idTipoMascota
                join servicios as s on c.idServicio = s.idServicio
                join cliente as n on c.idCliente = n.idCliente
                where idCita = ${id}";

$resultCitas = mysqli_query($db, $queryCitas);
$cita = mysqli_fetch_assoc($resultCitas);

$queryHorario = "SELECT idHorario, horaInicio, horaFin FROM horariocitas ORDER BY idHorario";
$resultHorario = mysqli_query($db, $queryHorario);

$queryMascota = "SELECT idTipoMascota, tipo FROM tipomascota ORDER BY idTipoMascota";
$resultMascota = mysqli_query($db, $queryMascota);

$queryServicio = "SELECT idServicio, servicio FROM servicios ORDER BY idServicio";
$resultServicio = mysqli_query($db, $queryServicio);

$queryCliente = "SELECT idCliente, nombre, apellido1 FROM cliente ORDER BY idCliente";
$resultCliente = mysqli_query($db, $queryCliente);



//Se inicializan las variables de acuerdo a los valores dentro de la base de datos de acuerdo al Id dato en
//el queryEventos
$requeridos = [];
$nombre = $cita['nombre'];
$correo = $cita['correo'];
$fecha = $cita['fecha'];
$idHorario = $cita['idHorario'];
$idMascota = $cita['idMascota'];
$idServicio = $cita['idServicio'];
$idCliente = $cita['idCliente'];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $fecha = $_POST['fecha'];
    $idHorario = $_POST['idHorario'];
    $idMascota = $_POST['idMascota'];
    $idServicio = $_POST['idServicio'];
    $idCliente = $_POST['idCliente'];

    if (!$nombre) {
        $requeridos[] = "El nombre del cliente es requerido";
    }

    if (!$correo) {
        $requeridos[] = "Favor insertar correo electronico";
    }

    if (!$fecha) {
        $requeridos[] = "Favor insertar la fecha de la cita";
    }

    if (!$idHorario) {
        $requeridos[] = "Favor seleccione el horario de atencion";
    }

    if (!$idMascota) {
        $requeridos[] = "Favor seleccione el tipo de mascota";
    }

    if (!$idServicio) {
        $requeridos[] = "Favor seleccione el servicio requerido";
    }

    if (!$idCliente) {
        $requeridos[] = "Favor seleccione su ID de cliente";
    }

    if (empty($requeridos)) {

        $sqlUpdate = "UPDATE citas SET nombre='$nombre', correo='$correo', fecha='$fecha',
        idHorario='$idHorario', idMascota='$idMascota', idServicio='$idServicio',
        idCliente='$idCliente' WHERE idCita=$id";

        $insertResult = mysqli_query($db, $sqlUpdate);

        if ($insertResult) {
            header('Location: /SC-502-Proyecto/admin_appointments.php');
        }
    }
}

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <!-- styles -->
    <?php $rutaCSS = 'css/admin_events.css';
    include 'include/template/header.php'; ?>
</head>

<body>
    <!-- Nav template -->
    <?php $enlaceActivo = 'admin_appointments';
    include 'include/template/nav.php'; ?>

    <main class="contenedor">
        <a href="admin_appointments.php" class="boton input-text">Atras</a>

        <?php foreach ($requeridos as $requerido): ?>
            <div class="campos-requeridos">
                <?php echo $requerido; ?>
            </div>
        <?php endforeach ?>

        <form class="formulario" method="POST" enctype="multipart/form-data">
            <section class="evento">
                <div class="evento__detalle">
                    <h2 class="centrar-texto">Actualizar cita</h2>
                    <form id="formularioParaCitas" class="formulario-evento" enctype="multipart/form-data">
                        <div class="campo">
                            <label for="nombre">Nombre cliente:</label>
                            <input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>">
                        </div>
                        <div class="campo">
                            <label for="correo">Correo electronico:</label>
                            <input type="text" id="correo" name="correo" value="<?php echo $correo; ?>">
                        </div>
                        <div class="campo">
                            <label for="fecha">Fecha:</label>
                            <input type="date" id="fecha" name="fecha" value="<?php echo $fecha; ?>">
                        </div>
                        <div class="campo">
                            <label for="idHorario">Horario: </label>
                            <select type="number" name="idHorario" id="idHorario">
                                <?php
                                if ($resultHorario->num_rows > 0) {
                                    while ($row = $resultHorario->fetch_assoc()) {
                                        echo '<option  value="' . $row["idHorario"] . '">' . $row["horaInicio"] . " - " . $row["horaFin"] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="campo">
                            <label for="idMascota">Mascota: </label>
                            <select type="number" name="idMascota" id="idMascota">
                                <?php
                                if ($resultMascota->num_rows > 0) {
                                    while ($row = $resultMascota->fetch_assoc()) {
                                        echo '<option  value="' . $row["idTipoMascota"] . '">' . $row["tipo"] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="campo">
                            <label for="idServicio">Servicio: </label>
                            <select type="number" name="idServicio" id="idServicio">
                                <?php
                                if ($resultServicio->num_rows > 0) {
                                    while ($row = $resultServicio->fetch_assoc()) {
                                        echo '<option  value="' . $row["idServicio"] . '">' . $row["servicio"] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="campo">
                            <label for="idCliente">Credenciales de registro: </label>
                            <select type="number" name="idCliente" id="idCliente">
                                <?php
                                if ($resultCliente->num_rows > 0) {
                                    while ($row = $resultCliente->fetch_assoc()) {
                                        echo '<option  value="' . $row["idCliente"] . '">' . $row["idCliente"] . " - " . $row["nombre"] . " " . $row["apellido1"] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="campo centrar-texto botones_evento">
                            <button class="enviar" type="submit">Actualizar Cita</button>
                            <a class="cancelar" href="#" onclick="window.history.back();">Cancelar</a>
                        </div>
                    </form>
                </div>
            </section>
        </form>
    </main>

    <!-- Footer -->
    <?php include 'include/template/footer.php'; ?>
    <!-- JS -->
    <script src="js/cita.js"></script>
</body>

</html>