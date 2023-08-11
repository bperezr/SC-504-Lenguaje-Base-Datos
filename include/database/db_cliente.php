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
        global $host, $port, $user, $pass, $dbname;

        $dsn = "mysql:host=$host;port=$port;dbname=$dbname";
        try {
            $this->db = new PDO($dsn, $user, $pass);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Error al conectar a la base de datos: ' . $e->getMessage());
        }
    }

    public function getCliente($id)
    {
        $query = "SELECT * FROM cliente WHERE idCliente = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

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

    public function getRoles()
    {
        $query = "SELECT idRol, nombreRol FROM rol";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

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

    public function deleteCliente($idCliente)
    {
        $query = "DELETE FROM cliente WHERE idCliente = :idCliente";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idCliente', $idCliente, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function buscarClientes($searchTerm)
    {
        $query = "SELECT c.*, p.nombre as provincia, cn.nombre as canton, d.nombre as distrito, r.nombre as rol FROM cliente c
                INNER JOIN provincia p ON c.idProvincia = p.idProvincia
                INNER JOIN canton cn ON c.idCanton = cn.idCanton
                INNER JOIN distrito d ON c.idDistrito = d.idDistrito
                INNER JOIN rol r ON c.idRol = r.idRol
                WHERE c.nombre LIKE :searchTerm OR c.apellido1 LIKE :searchTerm OR c.apellido2 LIKE :searchTerm";
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

    public function validarCredenciales($correo, $contrasena)
    {
        $query = "SELECT idCliente, contrasena FROM cliente WHERE correo = :correo";
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

    public function insertClienteNuevo($correo, $contrasena)
    {
        $hashedContrasena = password_hash($contrasena, PASSWORD_DEFAULT);

        $query = "INSERT INTO cliente (correo, contrasena) VALUES (:correo, :contrasena)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':contrasena', $hashedContrasena);

        return $stmt->execute();
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

    public function obtenerClientePorCorreo($correo)
    {
        $sql = "SELECT idRol, correo FROM cliente WHERE correo = :correo";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);

        $stmt->execute();

        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

        return $cliente;
    }

}
?>