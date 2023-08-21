<?php
require_once 'db_config.php';

class Cita
{
    protected $db;

    public function __construct()
    {
        $this->connectDB();
    }

    public function connectDB()
    {
        global $host, $port, $user, $pass, $dbname;

        $dsn = "mysql:host=$host;port=$port;dbname=$dbname";
        try {
            $this->db = new PDO($dsn, $user, $pass);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Error al conectar a la base de datos: ' . $e->getMessage());
        }
    }

    public function getMascotasCliente($idCliente)
    {
        $sql = "SELECT * from mascota where idCliente = :idCliente";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':idCliente', $idCliente, PDO::PARAM_INT);
        $stmt->execute();
        $mascotas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $mascotas;
    }

    public function getServicios()
    {
        $query = "SELECT * FROM servicios";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMedicosPorServicio($idServicio)
    {
        $query = "SELECT c.idColaborador, c.nombre, c.apellido1, c.apellido2
            FROM colaborador c
            INNER JOIN colaboradorservicio cs ON c.idColaborador = cs.idColaborador
            WHERE cs.idServicio = :idServicio";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idServicio', $idServicio, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertCita($idCliente, $idMascota, $idServicio, $fecha, $idHorario)
    {
        $query = "INSERT INTO citas (idCliente, idMascota, idServicio, fecha, idHorario, idestado)
            VALUES (:idCliente, :idMascota, :idServicio, :fecha, :idHorario, :idestado)";
        $stmt = $this->db->prepare($query);
        $idestado = 1;
        $stmt->bindValue(':idCliente', $idCliente, PDO::PARAM_INT);
        $stmt->bindValue(':idMascota', $idMascota, PDO::PARAM_INT);
        $stmt->bindValue(':idServicio', $idServicio, PDO::PARAM_INT);
        $stmt->bindValue(':fecha', $fecha, PDO::PARAM_STR);
        $stmt->bindValue(':idHorario', $idHorario, PDO::PARAM_INT);
        $stmt->bindValue(':idestado', $idestado, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function updateCita($idCita, $idCliente, $idMascota, $idServicio, $fecha, $idHorario)
    {
        $query = "UPDATE citas SET idCliente = :idCliente, idMascota = :idMascota, idServicio = :idServicio, fecha = :fecha, idHorario = :idHorario WHERE idCita = :idCita";
        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':idCita', $idCita, PDO::PARAM_INT);
        $stmt->bindValue(':idCliente', $idCliente, PDO::PARAM_INT);
        $stmt->bindValue(':idMascota', $idMascota, PDO::PARAM_INT);
        $stmt->bindValue(':idServicio', $idServicio, PDO::PARAM_INT);
        $stmt->bindValue(':fecha', $fecha, PDO::PARAM_STR);
        $stmt->bindValue(':idHorario', $idHorario, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function updateEstadoCita($idCita, $idEstado)
    {
        $query = "UPDATE citas SET idestado = :idEstado WHERE idCita = :idCita";
        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':idCita', $idCita, PDO::PARAM_INT);
        $stmt->bindValue(':idEstado', $idEstado, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function insertAsignacionCita($idCita, $idColaborador)
    {
        $query = "INSERT INTO asignacioncitas (idcita, idColaborador) VALUES (:idCita, :idColaborador)";
        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':idCita', $idCita, PDO::PARAM_INT);
        $stmt->bindValue(':idColaborador', $idColaborador, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function updateAsignacionCita($idasignacionCita, $idCita, $idColaborador)
    {
        $query = "UPDATE asignacioncitas SET idcita = :idCita, idColaborador = :idColaborador WHERE idasignacionCita = :idasignacionCita";
        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':idasignacionCita', $idasignacionCita, PDO::PARAM_INT);
        $stmt->bindValue(':idCita', $idCita, PDO::PARAM_INT);
        $stmt->bindValue(':idColaborador', $idColaborador, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function getLastInsertId()
    {
        return $this->db->lastInsertId();
    }

    public function getCitasCliente($idCliente)
    {
        $query = "SELECT c.idCita, m.nombre AS nombreMascota, s.servicio AS nombreServicio, c.fecha, h.horaInicio, h.horaFin, co.nombre AS nombreMedico, e.estado AS nombreEstado,  e.estado AS idEstado
                FROM citas c
                JOIN mascota m ON c.idMascota = m.idMascota
                JOIN servicios s ON c.idServicio = s.idServicio
                JOIN horariocitas h ON c.idHorario = h.idHorario
                JOIN asignacioncitas ac ON c.idCita = ac.idCita
                JOIN colaborador co ON ac.idColaborador = co.idColaborador
                JOIN estado e ON c.idestado = e.idestado
                WHERE c.idCliente = :idCliente";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":idCliente", $idCliente, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCitasPorEstado($idEstado)
    {
        $query = "SELECT c.idCita, m.nombre AS nombreMascota, s.servicio AS nombreServicio, c.fecha, h.horaInicio, h.horaFin, co.nombre AS nombreMedico, e.estado AS nombreEstado
                    FROM citas c
                    JOIN mascota m ON c.idMascota = m.idMascota
                    JOIN servicios s ON c.idServicio = s.idServicio
                    JOIN horariocitas h ON c.idHorario = h.idHorario
                    JOIN asignacioncitas ac ON c.idCita = ac.idCita
                    JOIN colaborador co ON ac.idColaborador = co.idColaborador
                    JOIN estado e ON c.idestado = e.idestado
                    WHERE c.idestado = :idEstado";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":idEstado", $idEstado, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }




}