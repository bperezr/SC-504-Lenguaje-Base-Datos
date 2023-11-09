<?php
require_once 'db_config.php';

class Mascota
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


    public function insertMascota($nombre, $descripcion, $idTipoMascota, $idCliente, $imagen)
    {
        $query = "INSERT INTO mascota (nombre, descripcion, idTipoMascota, idCliente, imagen)
        VALUES (:nombre, :descripcion, :idTipoMascota, :idCliente, :imagen)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':idTipoMascota', $idTipoMascota);
        $stmt->bindParam(':idCliente', $idCliente);
        $stmt->bindParam(':imagen', $imagen);
        return $stmt->execute();
    }

    public function getMascota($idMascota) {
        $query = "SELECT * FROM mascota WHERE idMascota = :idMascota";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':idMascota', $idMascota, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getMascotasPorCliente($idCliente)
    {
        $query = "SELECT * FROM mascota WHERE idCliente = :idCliente";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idCliente', $idCliente);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateMascota($idMascota, $nombre, $descripcion, $idTipoMascota, $imagen)
    {
        $query = "UPDATE mascota
                SET nombre = :nombre, descripcion = :descripcion,
                    idTipoMascota = :idTipoMascota, imagen = :imagen
                WHERE idMascota = :idMascota";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idMascota', $idMascota);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':idTipoMascota', $idTipoMascota);
        $stmt->bindParam(':imagen', $imagen);
        return $stmt->execute();
    }

    public function deleteMascota($idMascota)
    {
        $query = "DELETE FROM mascota WHERE idMascota = :idMascota";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idMascota', $idMascota);
        return $stmt->execute();
    }

    public function buscarMascotas($idCliente, $searchTerm)
    {
        $query = "SELECT * FROM mascota WHERE idCliente = :idCliente AND nombre LIKE :searchTerm";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':idCliente', $idCliente, PDO::PARAM_INT);
        $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%', PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function uploadImagen($imagen)
    {
        $carpetaImagenes = 'img/images_pets/';
        $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
        move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);
        return $nombreImagen;
    }

    public function deleteImagen($nombreImagen)
    {
        $rutaImagen = "img/images_pets/" . $nombreImagen;
        if (file_exists($rutaImagen)) {
            unlink($rutaImagen);
            return true;
        }
        return false;
    }

}
?>