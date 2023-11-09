<?php
require_once 'db_config.php';

class Especialidad
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


    // Función para obtener una especialidad por su ID
    public function getEspecialidad($id)
    {
        $query = "SELECT * FROM especialidad WHERE idEspecialidad = :idEspecialidad";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idEspecialidad', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Función para obtener todas las especialidades
    public function getEspecialidades()
    {
        $query = "SELECT * FROM especialidad";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Función para insertar una nueva especialidad
    public function insertEspecialidad($especialidad, $descripcion)
    {
        $query = "INSERT INTO especialidad (especialidad, descripcion) VALUES (:especialidad, :descripcion)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':especialidad', $especialidad);
        $stmt->bindParam(':descripcion', $descripcion);
        return $stmt->execute();
    }

    // Función para actualizar una especialidad
    public function updateEspecialidad($id, $especialidad, $descripcion)
    {
        $query = "UPDATE especialidad SET especialidad = :especialidad, descripcion = :descripcion WHERE idEspecialidad = :idEspecialidad";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idEspecialidad', $id);
        $stmt->bindParam(':especialidad', $especialidad);
        $stmt->bindParam(':descripcion', $descripcion);
        return $stmt->execute();
    }

    // Función para eliminar una especialidad por su ID
    public function deleteEspecialidad($id)
    {
        $query = "DELETE FROM especialidad WHERE idEspecialidad = :idEspecialidad";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idEspecialidad', $id);
        return $stmt->execute();
    }

    public function buscarEspecialidades($searchTerm)
    {
        $query = "SELECT e.*     
                FROM especialidad e        
                WHERE e.especialidad LIKE :searchTerm";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%', PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>