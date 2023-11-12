<?php
require_once 'db_config.php';

class TipoMascota
{
    protected $db;

    public function __construct()
    {
        $this->connectDB();
    }

   /* public function connectDB()
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


    // Función para obtener un tipo de mascota por su ID
    public function getTipoMascota($id)
    {
        $query = "SELECT * FROM tipomascota WHERE idTipoMascota = :idTipoMascota";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idTipoMascota', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Función para obtener todos los tipos de mascotas
    public function getTipoMascotas()
    {
        $query = "SELECT * FROM tipomascota";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Función para insertar un nuevo tipo de mascota
    public function insertTipoMascota($tipo)
    {
        $query = "INSERT INTO tipomascota (tipo) VALUES (:tipo)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':tipo', $tipo);
        return $stmt->execute();
    }

    // Función para actualizar un tipo de mascota
    public function updateTipoMascota($id, $tipo)
    {
        $query = "UPDATE tipomascota SET tipo = :tipo WHERE idTipoMascota = :idTipoMascota";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idTipoMascota', $id);
        $stmt->bindParam(':tipo', $tipo);
        return $stmt->execute();
    }

    // Función para eliminar un tipo de mascota por su ID
    public function deleteTipoMascota($id)
    {
        $query = "DELETE FROM tipomascota WHERE idTipoMascota = :idTipoMascota";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idTipoMascota', $id);
        return $stmt->execute();
    }

    public function buscarTipoMascota($searchTerm)
    {
        $query = "SELECT tp.* FROM tipomascota tp
                WHERE tp.tipo LIKE :searchTerm";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%', PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>