<?php
require_once '../database/db_cita.php';

$cita = new Cita();
$idServicio = $_POST['servicio'];
$medicos = $cita->getMedicosPorServicio($idServicio);

header('Content-Type: application/json');
echo json_encode($medicos);
?>
