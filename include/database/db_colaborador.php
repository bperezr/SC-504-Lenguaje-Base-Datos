<?php
require_once 'db_config.php';
class Colaborador
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

    // Función para obtener un solo colaborador por su ID
    public function getColaborador($id)
    {
        $query = "SELECT * FROM colaborador WHERE idColaborador = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Función para obtener todos los colaboradores
    public function getColaboradores()
    {
        $query = "SELECT c.*, e.especialidad, cg.cargo FROM colaborador as c
        JOIN especialidad as e ON c.idEspecialidad = e.idEspecialidad
        JOIN cargo as cg ON c.idCargo = cg.idCargo";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Función para insertar un nuevo colaborador
    public function insertColaborador($nombre, $apellido1, $apellido2, $edad, $idCargo, $idEspecialidad, $imagen)
    {
        // Resto del código para insertar en la base de datos
        $query = "INSERT INTO colaborador (nombre, apellido1, apellido2, edad, idCargo, idEspecialidad, imagen)
        VALUES (:nombre, :apellido1, :apellido2, :edad, :idCargo, :idEspecialidad, :imagen)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido1', $apellido1);
        $stmt->bindParam(':apellido2', $apellido2);
        $stmt->bindParam(':edad', $edad);
        $stmt->bindParam(':idCargo', $idCargo);
        $stmt->bindParam(':idEspecialidad', $idEspecialidad);
        $stmt->bindParam(':imagen', $imagen);

        return $stmt->execute();
    }


    // Función para actualizar un colaborador
    public function updateColaborador($id, $nombre, $apellido1, $apellido2, $edad, $idCargo, $idEspecialidad, $imagen)
    {
        $query = "UPDATE colaborador SET nombre = :nombre, apellido1 = :apellido1, apellido2 = :apellido2, edad = :edad, idCargo = :idCargo, idEspecialidad = :idEspecialidad, imagen = :imagen WHERE idColaborador = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':apellido1', $apellido1, PDO::PARAM_STR);
        $stmt->bindParam(':apellido2', $apellido2, PDO::PARAM_STR);
        $stmt->bindParam(':edad', $edad, PDO::PARAM_INT);
        $stmt->bindParam(':idCargo', $idCargo, PDO::PARAM_INT);
        $stmt->bindParam(':idEspecialidad', $idEspecialidad, PDO::PARAM_INT);
        $stmt->bindParam(':imagen', $imagen);

        return $stmt->execute();
    }


    public function deleteColaborador($id)
    {
        $query = "SELECT imagen FROM colaborador WHERE idColaborador = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $nombreImagen = $row['imagen'];
            $this->deleteImagen($nombreImagen);
        }

        $query = "DELETE FROM colaborador WHERE idColaborador = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }


    public function buscarColaboradores($searchTerm)
    {
        $query = "SELECT c.*, ca.cargo, e.especialidad
                FROM colaborador c
                INNER JOIN cargo ca ON c.idCargo = ca.idCargo
                INNER JOIN especialidad e ON c.idEspecialidad = e.idEspecialidad
                WHERE c.nombre LIKE :searchTerm OR c.apellido1 LIKE :searchTerm OR c.apellido2 LIKE :searchTerm";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%', PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function uploadImagen($imagen)
    {
        $carpetaImagenes = 'img/images_workers/';
        $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
        move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);
        return $nombreImagen;
    }

    public function deleteImagen($nombreImagen)
    {
        $rutaImagen = "img/images_workers/" . $nombreImagen;
        if (file_exists($rutaImagen)) {
            unlink($rutaImagen);
            return true;
        }
        return false;
    }


}
?>