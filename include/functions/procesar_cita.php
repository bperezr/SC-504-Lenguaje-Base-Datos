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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idCliente = $id;
    $idMascota = $_POST['mascota'];
    $idServicio = $_POST['servicio'];
    $fecha = $_POST['fecha'];
    $idHorario = $_POST['horario'];

    // Insertar cita en la tabla 'citas'
    $cita->insertCita($idCliente, $idMascota, $idServicio, $fecha, $idHorario);

    // Obtener el ID de la cita recién insertada
    $idCita = $cita->getLastInsertId();

    // Insertar asignación de cita en la tabla 'asignacioncitas'
    $idColaborador = $_POST['colaborador'];
    $cita->insertAsignacionCita($idCita, $idColaborador);

    $response = array('success' => true);
    echo json_encode($response);
} else {
    // Si se intenta acceder a este archivo sin una solicitud POST, redireccionar
    header('Location: acceso_denegado.php');
    exit();
}
?>
