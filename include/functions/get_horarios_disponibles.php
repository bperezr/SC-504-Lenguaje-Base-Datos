<?php
require_once '../database/db_config.php';

if (isset($_POST['fecha']) && isset($_POST['medico'])) {
    $fecha = $_POST['fecha'];
    $medicoId = $_POST['medico'];

    try {
        $db = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $user, $pass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "SELECT hc.idHorario, hc.horaInicio, hc.horaFin
                FROM horariocitas hc
                LEFT JOIN citas c ON hc.idHorario = c.idHorario AND c.fecha = :fecha AND c.idestado != 2
                LEFT JOIN asignacioncitas ac ON c.idCita = ac.idcita
                WHERE c.idCita IS NULL OR ac.idColaborador != :medicoId
                ORDER BY hc.horaInicio";

        $stmt = $db->prepare($query);
        $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
        $stmt->bindParam(':medicoId', $medicoId, PDO::PARAM_INT);
        $stmt->execute();
        $horarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($horarios);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Error al obtener los horarios disponibles']);
    }
} else {
    echo json_encode(['error' => 'Parámetros inválidos']);
}
?>