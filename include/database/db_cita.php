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

}