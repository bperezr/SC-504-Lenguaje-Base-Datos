<?php
// get_medicos.php
require_once '../database/db_colaborador.php';
$medico = new Colaborador();

if (isset($_POST['idServicio'])) {
    $idServicio = $_POST['idServicio'];
    $respuesta = $medico->getMedicosPorServicio($idServicio);

    // Verifica si la operación fue exitosa
    if ($respuesta['resultado'] == 0) {
        echo json_encode($respuesta['datos']);
    } else {
        // En caso de error, puedes devolver un array vacío o un mensaje de error
        echo json_encode([]);
    }

    exit;
}
?>