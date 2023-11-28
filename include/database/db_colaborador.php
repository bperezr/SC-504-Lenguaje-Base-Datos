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
        global $host, $user, $pass, $port, $sid;
 
        $connection_string = "//" . $host . ":" . $port . "/" . $sid;
        $this->db = oci_connect($user, $pass, $connection_string, 'AL32UTF8');
        
 
        if (!$this->db) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
    }
    // Función para obtener un solo colaborador por su ID
    public function getColaborador($id)
    {
        $conn = $this->db;
        $stmt = oci_parse($conn, "BEGIN  PAQUETE_COLABORADORES.getColaborador(:p_idColaborador, :p_nombre, :p_apellido1, :p_apellido2, :p_idCargo, :p_idEspecialidad, :p_imagen, :p_correo, :p_resultado); END;");

        oci_bind_by_name($stmt, ":p_idColaborador", $id);

        $p_idColaborador="";
        $p_nombre="";
        $p_apellido1="";
        $p_apellido2="";
        $p_idCargo="";
        $p_idEspecialidad="";
        $p_imagen="";
        $p_correo="";
        $p_resultado=0;

        oci_bind_by_name($stmt, ":p_idColaborador", $p_idColaborador, 200);
        oci_bind_by_name($stmt, ":p_nombre", $p_nombre, 200);
        oci_bind_by_name($stmt, ":p_apellido1", $p_apellido1, 200);
        oci_bind_by_name($stmt, ":p_apellido2", $p_apellido2, 200);
        oci_bind_by_name($stmt, ":p_idCargo", $p_idCargo, 200);
        oci_bind_by_name($stmt, ":p_idEspecialidad", $p_idEspecialidad, 200);
        oci_bind_by_name($stmt, ":p_imagen", $p_imagen, 200);
        oci_bind_by_name($stmt, ":p_correo", $p_correo, 200);
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        $colaborador = null;
        if ($p_resultado == 1) {
            $especialidad = array(
                'idColaborador' => $id,
                'nombre' => $p_nombre,
                'apellido1' => $p_apellido1
            );
        }

        return array('datos' => $colaborador, 'resultado' => $p_resultado);
    }

    

    public function getColaboradores()
{
    $colaboradores = array();
    $conn = $this->db;

    $stmt = oci_parse($conn, "BEGIN PAQUETE_COLABORADORES.getColaboradores(:p_cursor, :p_resultado); END;");

    $p_cursor = oci_new_cursor($conn);
    oci_bind_by_name($stmt, ":p_cursor", $p_cursor, -1, OCI_B_CURSOR);
    $p_resultado = 0;
    oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

    oci_execute($stmt);

    if ($p_resultado == 1) {
        oci_execute($p_cursor);
        while ($row = oci_fetch_assoc($p_cursor)) {
            array_push($colaboradores, $row);
        }
    }

    oci_free_statement($p_cursor);
    oci_free_statement($stmt);

    return array('datos' => $colaboradores, 'resultado' => $p_resultado);
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

    //PENDIENTE
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

    public function deleteColaborador($idColaborador)
    {
        $conn = $this->db;
        $stmt = oci_parse($conn, "BEGIN PAQUETE_COLABORADOR.deleteColaborador(:p_idColaborador, :p_resultado); END;");
    
        oci_bind_by_name($stmt, ":p_idColaborador", $idColaborador, 200);
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);
    
        oci_execute($stmt);
    
        oci_free_statement($stmt);
    
        // Asegúrate de manejar el resultado según tus necesidades
        if ($p_resultado != 1) {
            // Manejar el error, si es necesario
        }
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

    //PENDIENTE
    public function uploadImagen($imagen)
    {
        $carpetaImagenes = '../img/images_workers/';
        $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
        move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);
        return $nombreImagen;
    }

    //PENDIENTE
    public function deleteImagen($nombreImagen)
    {
        $rutaImagen = "../img/images_workers/" . $nombreImagen;
        if (file_exists($rutaImagen)) {
            unlink($rutaImagen);
            return true;
        }
        return false;
    }

    public function getMedicosPorServicio($idServicio)
    {
        $query = "SELECT c.idColaborador, c.nombre, c.apellido1, c.apellido2
                FROM colaborador c
                INNER JOIN serviciomedico sm ON c.idColaborador = sm.idColaborador
                WHERE sm.idServicio = :idServicio";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idServicio', $idServicio, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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