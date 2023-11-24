<?php
require_once 'db_config.php';

class Cliente
{
    protected $db;

    public function __construct()
    {
        $this->connectDB();
    }

    public function connectDB()
    {
        global $host, $user, $pass, $port, $sid;

        try {
            $this->db = new PDO("oci:dbname=//$host:$port/$sid", $user, $pass);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Error al conectar a la base de datos Oracle: ' . $e->getMessage());
        }
    }

    /*public function getCliente($id)
    {
        $query = "SELECT * FROM cliente WHERE idCliente = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }*/
    public function getCliente($id, &$nombre, &$apellido1, &$apellido2, &$telefono, &$imagen, &$domicilio, &$idProvincia, &$idCanton, &$idDistrito, &$idRol, &$correo, &$resultado)
    {
        $sql = "BEGIN getCliente(:p_idCliente, :p_nombre, :p_apellido1, :p_apellido2, :p_telefono, :p_imagen, :p_domicilio, :p_idProvincia, :p_idCanton, :p_idDistrito, :p_idRol, :p_correo, :p_resultado); END;";
        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':p_idCliente', $id, PDO::PARAM_INT);
        $stmt->bindParam(':p_nombre', $nombre, PDO::PARAM_STR, 255);
        $stmt->bindParam(':p_apellido1', $apellido1, PDO::PARAM_STR, 255);
        $stmt->bindParam(':p_apellido2', $apellido2, PDO::PARAM_STR, 255);
        $stmt->bindParam(':p_telefono', $telefono, PDO::PARAM_STR, 255);
        $stmt->bindParam(':p_imagen', $imagen, PDO::PARAM_STR, 400);
        $stmt->bindParam(':p_domicilio', $domicilio, PDO::PARAM_STR, 255);
        $stmt->bindParam(':p_idProvincia', $idProvincia, PDO::PARAM_INT, 1);
        $stmt->bindParam(':p_idCanton', $idCanton, PDO::PARAM_INT, 3);
        $stmt->bindParam(':p_idDistrito', $idDistrito, PDO::PARAM_INT, 4);
        $stmt->bindParam(':p_idRol', $idRol, PDO::PARAM_INT, 1);
        $stmt->bindParam(':p_correo', $correo, PDO::PARAM_STR, 255);
        $stmt->bindParam(':p_resultado', $resultado, PDO::PARAM_INT, 1);

        $stmt->execute();
    }
    //DONE
    public function getClientes()
    {
        $query = "SELECT c.*, p.nombre as provincia, cn.nombre as canton, d.nombre as distrito, r.nombre as rol FROM cliente as c
        JOIN provincia as p ON c.idProvincia = p.idProvincia
        JOIN canton as cn ON c.idCanton = cn.idCanton
        JOIN distrito as d ON c.idDistrito = d.idDistrito
        JOIN rol as r ON c.idRol = r.idRol";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    //DONE
    public function getVerClientes()
    {
        $query = "SELECT idCliente, nombre, apellido1, apellido2, telefono, imagen, domicilio, idProvincia, idCanton, idDistrito, correo FROM cliente";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    //DONE
    public function getRoles()
    {
        $query = "SELECT idRol, nombreRol FROM rol";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    //DONE
    public function insertCliente($nombre, $apellido1, $apellido2, $telefono, $domicilio, $idProvincia, $idCanton, $idDistrito, $idRol, $correo, $contrasena)
    {
        $query = "INSERT INTO cliente (nombre, apellido1, apellido2, telefono, domicilio, idProvincia, idCanton, idDistrito, idRol, correo, contrasena)
        VALUES (:nombre, :apellido1, :apellido2, :telefono, :domicilio, :idProvincia, :idCanton, :idDistrito, :idRol, :correo, :contrasena)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido1', $apellido1);
        $stmt->bindParam(':apellido2', $apellido2);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':domicilio', $domicilio);
        $stmt->bindParam(':idProvincia', $idProvincia);
        $stmt->bindParam(':idCanton', $idCanton);
        $stmt->bindParam(':idDistrito', $idDistrito);
        $stmt->bindParam(':idRol', $idRol);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':contrasena', $contrasena);

        return $stmt->execute();
    }
    //DONE
    public function updateCliente($idCliente, $nombre, $apellido1, $apellido2, $telefono, $domicilio, $idProvincia, $idCanton, $idDistrito, $idRol, $correo)
    {
        $query = "UPDATE cliente SET nombre = :nombre, apellido1 = :apellido1, apellido2 = :apellido2, telefono = :telefono, domicilio = :domicilio, idProvincia = :idProvincia, idCanton = :idCanton, idDistrito = :idDistrito, idRol = :idRol, correo = :correo WHERE idCliente = :idCliente";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idCliente', $idCliente, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido1', $apellido1);
        $stmt->bindParam(':apellido2', $apellido2);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':domicilio', $domicilio);
        $stmt->bindParam(':idProvincia', $idProvincia);
        $stmt->bindParam(':idCanton', $idCanton);
        $stmt->bindParam(':idDistrito', $idDistrito);
        $stmt->bindParam(':idRol', $idRol);
        $stmt->bindParam(':correo', $correo);

        return $stmt->execute();
    }
    //DONE
    public function updateClienteNuevo($idCliente, $nombre, $apellido1, $apellido2, $telefono, $domicilio, $idProvincia, $idCanton, $idDistrito, $imagen)
    {
        $query = "UPDATE cliente SET nombre = :nombre, apellido1 = :apellido1, apellido2 = :apellido2, telefono = :telefono, domicilio = :domicilio, idProvincia = :idProvincia, idCanton = :idCanton, idDistrito = :idDistrito, imagen = :imagen WHERE idCliente = :idCliente";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idCliente', $idCliente, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido1', $apellido1);
        $stmt->bindParam(':apellido2', $apellido2);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':domicilio', $domicilio);
        $stmt->bindParam(':idProvincia', $idProvincia);
        $stmt->bindParam(':idCanton', $idCanton);
        $stmt->bindParam(':idDistrito', $idDistrito);
        $stmt->bindParam(':imagen', $imagen);

        return $stmt->execute();
    }

    //DONE
    public function deleteCliente($idCliente)
    {
        $query = "DELETE FROM cliente WHERE idCliente = :idCliente";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idCliente', $idCliente, PDO::PARAM_INT);
        return $stmt->execute();
    }

    //DONE
    public function buscarClientes($searchTerm)
    {
        $query = "SELECT idCliente, nombre, apellido1, apellido2, correo, imagen, telefono FROM cliente
            WHERE nombre LIKE :searchTerm OR apellido1 LIKE :searchTerm OR apellido2 LIKE :searchTerm OR correo LIKE :searchTerm";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%', PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /* -----------------Login Cliente ----------------- */
    public function verificarCorreoExistente($correo)
    {
        $query = "SELECT idCliente FROM cliente WHERE correo = :correo";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':correo', $correo);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    /*  public function validarCredenciales($correo, $contrasena)
    {
        $query = "SELECT idCliente, contrasena FROM cliente WHERE correo = :correo";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':correo', $correo);
        $stmt->execute();

        $result= $stmt->fetch(PDO::FETCH_ASSOC);

        $hash = password_hash($contrasena, PASSWORD_DEFAULT, array("cost" => 10));

        if ($result && password_verify($contrasena, $hash)) {
            return true;
        } else {
            return false;
        }
    }
  */
    public function validarCredenciales($correo, $contrasena, &$resultado)
    {
        $sql = "BEGIN validarcredenciales(:correo, :contrasena, :resultado); END;";
        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':contrasena', $contrasena);
        $stmt->bindParam(':resultado', $resultado, PDO::PARAM_INT, 1);

        $stmt->execute();
    }


    /*   public function insertClienteNuevo($correo, $contrasena)
    {
        $hashedContrasena = password_hash($contrasena, PASSWORD_DEFAULT);

        $query = "INSERT INTO cliente (correo, contrasena) VALUES (:correo, :contrasena)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':contrasena', $hashedContrasena);

        return $stmt->execute();
       } */

    public function insertClienteNuevo($correo, $contrasena, &$resultado)
    {
        $sql = "BEGIN insertClienteNuevo(:correo, :contrasena, :resultado); END;";
        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':contrasena', $contrasena);
        $stmt->bindParam(':resultado', $resultado, PDO::PARAM_INT, 1);

        $stmt->execute();
    }

    public function camposNull($correo)
    {
        $query = "SELECT nombre, apellido1, apellido2, telefono, domicilio, idProvincia, idCanton, idDistrito FROM cliente WHERE correo = :correo";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':correo', $correo);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result === false) {
            return false;
        }
        $camposObligatorios = array('nombre', 'apellido1', 'apellido2', 'telefono', 'domicilio', 'idProvincia', 'idCanton', 'idDistrito');
        foreach ($camposObligatorios as $campo) {
            if ($result[$campo] === null) {
                return true;
            }
        }
        return false;
    }

    /*  public function obtenerClientePorCorreo($correo)
    {
        $sql = "SELECT idCliente, idRol, correo, nombre, apellido1, apellido2 FROM cliente WHERE correo = :correo";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);

        $stmt->execute();

        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

        return $cliente;
      } */

    public function obtenerClientePorCorreo($correo, &$idCliente, &$idRol, &$nombre, &$apellido1, &$apellido2, &$resultado)
    {

        $sql = "BEGIN obtenerClientePorCorreo(:correo, :idCliente, :idRol, :nombre, :apellido1, :apellido2, :resultado); END;";
        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
        $stmt->bindParam(':idCliente', $idCliente, PDO::PARAM_INT, 11);
        $stmt->bindParam(':idRol', $idRol, PDO::PARAM_INT, 1);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR, 255);
        $stmt->bindParam(':apellido1', $apellido1, PDO::PARAM_STR, 255);
        $stmt->bindParam(':apellido2', $apellido2, PDO::PARAM_STR, 255);
        $stmt->bindParam(':resultado', $resultado, PDO::PARAM_INT, 1);

        $stmt->execute();
    }


    public function uploadImagen($imagen)
    {
        $carpetaImagenes = 'img/images_clients/';
        $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
        move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);
        return $nombreImagen;
    }

    public function deleteImagen($nombreImagen)
    {
        $rutaImagen = "img/images_clients/" . $nombreImagen;
        if (file_exists($rutaImagen)) {
            unlink($rutaImagen);
            return true;
        }
        return false;
    }
}
