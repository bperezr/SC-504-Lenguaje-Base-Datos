<?php
require_once 'db_config.php';

class Servicio
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

    public function getServicio($id)
    {
        $query = "SELECT * FROM servicios WHERE idServicio = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getServicios()
    {
        $query = "SELECT * FROM servicios";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertServicio($servicio, $descripcion)
    {
        $query = "INSERT INTO servicios (servicio, descripcion) VALUES (:servicio, :descripcion)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':servicio', $servicio, PDO::PARAM_STR);
        $stmt->bindValue(':descripcion', $descripcion, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function updateServicio($id, $servicio, $descripcion)
    {
        $query = "UPDATE servicios SET servicio = :servicio, descripcion = :descripcion WHERE idServicio = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':servicio', $servicio, PDO::PARAM_STR);
        $stmt->bindValue(':descripcion', $descripcion, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function deleteServicio($id)
    {
        $query = "DELETE FROM servicios WHERE idServicio = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function buscarServicios($searchTerm)
    {
        $query = "SELECT * FROM servicios WHERE servicio LIKE :searchTerm OR descripcion LIKE :searchTerm";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%', PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>