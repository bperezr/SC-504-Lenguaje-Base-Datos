<?php

$id = $_GET['id'];

require 'include/connections/connectDB.php';
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
$citas = mysqli_fetch_assoc($resultCitas);

$queyHorario = "SELECT idHorario, horaInicio, horaFin FROM horariocitas ORDER BY idHorario";
$result = mysqli_query($db, $queyHorario);

$queryMascota = "SELECT idMascota, nombre FROM tipomascota ORDER BY idTipoMascota";
$resultMascota = mysqli_query($db, $queryMascota);

$queryServicios = "SELECT idServicio, servicio FROM servicios ORDER BY idServicio";
$resultServicios = mysqli_query($db, $queryServicios);

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
    // Retrieve form data
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $fecha = $_POST['fecha'];
    $idHorario = $_POST['idHorario'];
    $idMascota = $_POST['idMascota'];
    $idServicio = $_POST['idServicio'];
    $idCliente = $_POST['idCliente'];

    // Validation
    $requeridos = [];
    if (empty($nombre)) {
        $requeridos[] = "El nombre es requerido";
    }

    if (empty($correo)) {
        $requeridos[] = "El correo es requerido";
    }

    if (empty($fecha)) {
        $requeridos[] = "La fecha es requerida";
    }

    if (empty($idHorario)) {
        $requeridos[] = "El horario es requerido";
    }

    if (empty($idMascota)) {
        $requeridos[] = "La mascota es requerida";
    }

    if (empty($idServicio)) {
        $requeridos[] = "El servicio es requerido";
    }

    if (empty($idCliente)) {
        $requeridos[] = "El cliente es requerido";
    }

    //esta aqui

    if (empty($requeridos)) {

        $sqlUpdate = "UPDATE citas SET
        nombre = '$nombre',
        correo = '$correo',
        fecha = '$fecha',
        idHorario = $idHorario,
        idMascota = $idMascota,
        idServicio = $idServicio,
        idCliente = $idCliente
        WHERE idCita = $id";

        $insertResult = mysqli_query($db, $sqlUpdate);

        if ($insertResult) {
            header('Location: /SC-502-Proyecto/admin_events.php');
        }
    }
}

?>
