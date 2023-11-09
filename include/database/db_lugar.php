<?php
require_once 'db_config.php';

class Lugar
{
    protected $db;

    public function __construct()
    {
        $this->connectDB();
    }

    /*public function connectDB()
    {
        global $host, $port, $user, $pass, $dbname;

        $dsn = "mysql:host=$host;port=$port;dbname=$dbname";
        try {
            $this->db = new PDO($dsn, $user, $pass);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Error al conectar a la base de datos: ' . $e->getMessage());
        }
    } */

    public function connectDB()
    {
        global $host, $user, $pass , $port, $sid;

        try {
            $this->db = new PDO("oci:dbname=//$host:$port/$sid", $user, $pass );
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Error al conectar a la base de datos Oracle: ' . $e->getMessage());
        }
}


    public function obtenerNombreProvinciaPorID($idProvincia)
    {
        $query = "SELECT nombre FROM provincia WHERE idProvincia = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $idProvincia, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return $result['nombre'];
        } else {
            return "Desconocido";
        }
    }

    public function obtenerNombreCantonPorID($idCanton)
    {
        $query = "SELECT nombre FROM canton WHERE idCanton = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $idCanton, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return $result['nombre'];
        } else {
            return "Desconocido";
        }
    }

    public function obtenerNombreDistritoPorID($idDistrito)
    {
        $query = "SELECT nombre FROM distrito WHERE idDistrito = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $idDistrito, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return $result['nombre'];
        } else {
            return "Desconocido";
        }
    }

    public function getProvincias()
    {
        $query = "SELECT idProvincia, nombre FROM provincia";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCantones()
    {
        $query = "SELECT idCanton, nombre FROM canton";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDistritos()
    {
        $query = "SELECT idDistrito, nombre FROM distrito";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCantonesPorProvincia($idProvincia)
    {
        $query = "SELECT idCanton, nombre FROM canton WHERE idProvincia = :idProvincia";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idProvincia', $idProvincia, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDistritosPorCanton($idCanton)
    {
        $query = "SELECT idDistrito, nombre FROM distrito WHERE idCanton = :idCanton";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idCanton', $idCanton, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>