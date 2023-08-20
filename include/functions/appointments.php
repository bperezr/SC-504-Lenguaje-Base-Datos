<?php
require_once '../database/db_config.php';

class Appointment
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

    public function insertarCita($nombre, $correo, $fecha, $idhorario, $idMascota, $idServicio, $idCliente, $idEstado)
    {
        $query = "INSERT INTO citas (nombre, correo, fecha, idhorario, idMascota, idServicio, idCliente, idEstado)
        VALUES (:nombre, :correo, :fecha, :idhorario, :idMascota, :idServicio, :idCliente, :idEstado)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':idhorario', $idhorario, PDO::PARAM_INT);
        $stmt->bindParam(':idMascota', $idMascota, PDO::PARAM_INT);
        $stmt->bindParam(':idServicio', $idServicio, PDO::PARAM_INT);
        $stmt->bindParam(':idCliente', $idCliente, PDO::PARAM_INT);
        $stmt->bindParam(':idEstado', $idEstado, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function insertarAsignacionesCitas($idcita, $idColaborador)
    {
        $query = "INSERT INTO asignacioncitas (idcita, idColaborador)
        VALUES (:idcita, :idColaborador)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idcita', $idcita);
        $stmt->bindParam(':idColaborador', $idColaborador);
        return $stmt->execute();
    }

    //Metodo para saber si el medico seleccionado tiene espacio en la agenda 
    //Si el resultado es true se puede hacer la reserva
    public function getAsignacionesCitas($idColaborador)
    {
        $query = "SELECT ac.*, ci.nombre, ci.fecha, ci.idHorario, hc.horaInicio, hc.horaFin 
        from asignacioncitas AS ac join citas AS ci on ac.idcita = ci.idcita
        join horariocitas AS hc on ci.idHorario = hc.idHorario WHERE ac.idColaborador = :idColaborador ";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idColaborador', $idColaborador);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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

        $sql = "SELECT * from servicios";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $servicios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $servicios;
    }

    public function getHorarios()
    {

        $sql = "SELECT * from horariocitas";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $horarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $horarios;
    }


}