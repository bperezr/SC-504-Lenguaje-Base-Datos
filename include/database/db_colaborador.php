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

    public function getRoles()
    {
        $query = "SELECT idRol, nombreRol FROM rol";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function verificarCorreoExistente($correo)
    {
        $query = "SELECT idColaborador FROM colaborador WHERE correo = :correo";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_COLUMN) !== false;
    }

    public function getColaboradorPorCorreo($correo)
    {
        $query = "SELECT * FROM colaborador WHERE correo = :correo";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Función para insertar un nuevo colaborador
    public function insertColaborador($nombre, $apellido1, $apellido2, $idCargo, $idEspecialidad, $imagen, $correo, $contrasena, $idRol)
    {
        // Genera el hash
        $contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);

        $query = "INSERT INTO colaborador (nombre, apellido1, apellido2, idCargo, idEspecialidad, imagen, correo, contrasena, idRol)
        VALUES (:nombre, :apellido1, :apellido2, :idCargo, :idEspecialidad, :imagen, :correo, :contrasena, :idRol)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido1', $apellido1);
        $stmt->bindParam(':apellido2', $apellido2);
        $stmt->bindParam(':idCargo', $idCargo);
        $stmt->bindParam(':idEspecialidad', $idEspecialidad);
        $stmt->bindParam(':imagen', $imagen);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':contrasena', $contrasenaHash); // Almacenamos el hash
        $stmt->bindParam(':idRol', $idRol);

        return $stmt->execute();
    }


    // Función para actualizar un colaborador
    public function updateColaborador($id, $nombre, $apellido1, $apellido2, $idCargo, $idEspecialidad, $imagen, $correo, $contrasena, $idRol)
    {
        // Si se proporciona una nueva contraseña, genera el hash de la misma
        if (!empty($contrasena)) {
            $contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);
        }

        $query = "UPDATE colaborador SET nombre = :nombre, apellido1 = :apellido1, apellido2 = :apellido2, idCargo = :idCargo, idEspecialidad = :idEspecialidad, imagen = :imagen, correo = :correo";

        // Agrega el campo de la contraseña solo si se proporciona una nueva contraseña
        if (!empty($contrasena)) {
            $query .= ", contrasena = :contrasena";
        }

        $query .= ", idRol = :idRol WHERE idColaborador = :id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':apellido1', $apellido1, PDO::PARAM_STR);
        $stmt->bindParam(':apellido2', $apellido2, PDO::PARAM_STR);
        $stmt->bindParam(':idCargo', $idCargo, PDO::PARAM_INT);
        $stmt->bindParam(':idEspecialidad', $idEspecialidad, PDO::PARAM_INT);
        $stmt->bindParam(':imagen', $imagen);
        $stmt->bindParam(':correo', $correo);

        // Asigna el valor del hash solo si se proporciona una nueva contraseña
        if (!empty($contrasena)) {
            $stmt->bindParam(':contrasena', $contrasenaHash);
        }

        $stmt->bindParam(':idRol', $idRol);

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

    /* -----------------Login Cliente ----------------- */
    public function validarCredenciales($correo, $contrasena)
    {
        $query = "SELECT contrasena FROM colaborador WHERE correo = :correo";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':correo', $correo);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && password_verify($contrasena, $result['contrasena'])) {
            return true;
        } else {
            return false;
        }
    }

    public function obtenerColaboradorPorCorreo($correo)
    {
        $sql = "SELECT idColaborador, idRol, correo FROM colaborador WHERE correo = :correo";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
        $stmt->execute();

        $colaborador = $stmt->fetch(PDO::FETCH_ASSOC);
        return $colaborador;
    }

}
?>