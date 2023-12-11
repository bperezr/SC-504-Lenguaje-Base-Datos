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
    
        oci_bind_by_name($stmt, ":p_idColaborador", $id, 200);
    
        $p_idColaborador=$id;
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
        if ($p_resultado == 0) {
            $colaborador = array(
                'idColaborador' => $p_idColaborador,
                'nombre' => $p_nombre,
                'apellido1' => $p_apellido1,
                'apellido2' => $p_apellido2,
                'idCargo' => $p_idCargo,
                'idEspecialidad' => $p_idEspecialidad,
                'imagen' => $p_imagen,
                'correo' => $p_correo
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
    $roles = array();
    $conn = $this->db;

    $stmt = oci_parse($conn, "BEGIN PAQUETE_COLABORADORES.getRoles(:p_cursor, :p_resultado); END;");

    $p_cursor = oci_new_cursor($conn);
    oci_bind_by_name($stmt, ":p_cursor", $p_cursor, -1, OCI_B_CURSOR);
    $p_resultado = 0;
    oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

    oci_execute($stmt);

    if ($p_resultado == 1) {
        oci_execute($p_cursor);
        while ($row = oci_fetch_assoc($p_cursor)) {
            array_push($roles, $row);
        }
    }

    oci_free_statement($p_cursor);
    oci_free_statement($stmt);

    return array('datos' => $roles, 'resultado' => $p_resultado);
}

public function verificarCorreoExistente($correo)
{
    if (is_resource($this->db)) {
        $stmt = oci_parse($this->db, "BEGIN PAQUETE_COLABORADORES.verificarCorreoExistente(:p_correo, :p_resultado); END;");
        $p_resultado = 0;

        oci_bind_by_name($stmt, ":p_correo", $correo);
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, 10, OCI_B_INT);

        oci_execute($stmt);

        return $p_resultado == 1;
    } else {
        die("Error: La conexión no es un recurso OCI8 válido.");
    }
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
        $conn = $this->db;

        $stmt = oci_parse($conn, "BEGIN PAQUETE_COLABORADORES.insertColaborador(:p_nombre, :p_apellido1, :p_apellido2, :p_idCargo, :p_idEspecialidad, :p_imagen, :p_correo, :p_contrasena, :p_idRol, :p_resultado); END;");

        oci_bind_by_name($stmt, ":p_nombre", $nombre);
        oci_bind_by_name($stmt, ":p_apellido1", $apellido1);
        oci_bind_by_name($stmt, ":p_apellido2", $apellido2);
        oci_bind_by_name($stmt, ":p_idCargo", $idCargo);
        oci_bind_by_name($stmt, ":p_idEspecialidad", $idEspecialidad);
        oci_bind_by_name($stmt, ":p_imagen", $imagen);
        oci_bind_by_name($stmt, ":p_correo", $correo);
        oci_bind_by_name($stmt, ":p_contrasena", $contrasena);
        oci_bind_by_name($stmt, ":p_idRol", $idRol);


        $p_resultado = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        return $p_resultado;
    }


    // Función para actualizar un colaborador
    public function updateColaborador($idColaborador, $nombre, $apellido1, $apellido2, $idCargo, $idEspecialidad, $imagen, $correo, $idRol)
{
    $conn = $this->db;
                                    
    $stmt = oci_parse($conn, "BEGIN PAQUETE_COLABORADORES.updateColaborador( :p_idColaborador, :p_nombre, :p_apellido1, :p_apellido2, :p_idCargo, :p_idEspecialidad, :p_imagen, :p_correo, :p_idRol,:p_resultado);END;");
    
    oci_bind_by_name($stmt, ":p_idColaborador", $idColaborador);
    oci_bind_by_name($stmt, ":p_nombre", $nombre);
    oci_bind_by_name($stmt, ":p_apellido1", $apellido1);
    oci_bind_by_name($stmt, ":p_apellido2", $apellido2);
    oci_bind_by_name($stmt, ":p_idCargo", $idCargo);
    oci_bind_by_name($stmt, ":p_idEspecialidad", $idEspecialidad);
    oci_bind_by_name($stmt, ":p_imagen", $imagen);
    oci_bind_by_name($stmt, ":p_correo", $correo);

    $resultado= null;
    oci_bind_by_name($stmt, ":p_idRol", $idRol);
    oci_bind_by_name($stmt, ":p_resultado", $resultado, -1, SQLT_INT);

    oci_execute($stmt);

    return $resultado; 
}


    public function deleteColaborador($idColaborador)
    {
        $conn = $this->db;
        $p_resultado = 0;
        
        $stmt = oci_parse($conn, "BEGIN PAQUETE_COLABORADORES.deleteColaborador(:p_idColaborador, :p_resultado); END;");
    
        oci_bind_by_name($stmt, ":p_idColaborador", $idColaborador);
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);
    
        oci_execute($stmt);
    
        oci_free_statement($stmt);
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
        $conn = $this->db;

        $stmt = oci_parse($conn, "BEGIN P_COLABORADOR.getMedicosPorServicio(:p_idServicio, :p_cursor, :p_resultado); END;");

        oci_bind_by_name($stmt, ":p_idServicio", $idServicio);
        $p_cursor = oci_new_cursor($conn);
        oci_bind_by_name($stmt, ":p_cursor", $p_cursor, -1, OCI_B_CURSOR);
        $p_resultado = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        $medicosServicios = [];
        if ($p_resultado == 0) {
            oci_execute($p_cursor);
            while ($row = oci_fetch_assoc($p_cursor)) {
                array_push($medicosServicios, $row);
            }
        }

        oci_free_statement($p_cursor);
        oci_free_statement($stmt);

        return ['datos' => $medicosServicios, 'resultado' => $p_resultado];
    }

    /* -----------------Login  ----------------- */
    public function validarCredenciales($correo, $contrasena)
    {
        $stmt = oci_parse($this->db, "BEGIN P_COLABORADOR.validarCredenciales(:p_Correo, :p_Contrasena, :p_resultado); END;");

        oci_bind_by_name($stmt, ":p_Correo", $correo);
        oci_bind_by_name($stmt, ":p_Contrasena", $contrasena);

        $p_resultado = null;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        return $p_resultado;
    }



    public function obtenerColaboradorPorCorreo($correo)
    {
        $stmt = oci_parse($this->db, "BEGIN P_COLABORADOR.obtenerColaboradorPorCorreo(:p_Correo, :p_idColaborador, :p_idRol, :p_nombre, :p_apellido1, :p_apellido2, :p_resultado); END;");

        oci_bind_by_name($stmt, ":p_Correo", $correo);

        $idColaborador = -1;
        $idRol = -1;
        $nombre = '';
        $apellido1 = '';
        $apellido2 = '';
        $resultado = null;

        oci_bind_by_name($stmt, ":p_idColaborador", $idColaborador, -1, SQLT_INT);
        oci_bind_by_name($stmt, ":p_idRol", $idRol, -1, SQLT_INT);
        oci_bind_by_name($stmt, ":p_nombre", $nombre, 200);
        oci_bind_by_name($stmt, ":p_apellido1", $apellido1, 200);
        oci_bind_by_name($stmt, ":p_apellido2", $apellido2, 200);
        oci_bind_by_name($stmt, ":p_resultado", $resultado, -1, SQLT_INT);

        oci_execute($stmt);

        $colaborador = array(
            'idColaborador' => $idColaborador,
            'idRol' => $idRol,
            'nombre' => $nombre,
            'apellido1' => $apellido1,
            'apellido2' => $apellido2
        );

        return array('datos' => $colaborador, 'resultado' => $resultado);
    }


}
?>