<?php
require_once 'db_config.php';

class Cargo
{
    protected $db;

    public function __construct()
    {
        $this->connectDB();
    }

    /*public function connectDB()
    {
        //global $host, $port, $user, $pass, $dbname;

        $dsn = "mysql:host=$host;port=$port;dbname=$dbname";
        try {
            $this->db = new PDO($dsn, $user, $pass);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Error al conectar a la base de datos: ' . $e->getMessage());
        }
    }*/

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


    // Función para obtener un cargo por su ID
    public function getCargo($p_idCargo)
    {
        $conn = $this->db;
        $stmt = oci_parse($conn, "BEGIN :result := GetCargo(:p_idCargo); END;");       
        $result = oci_new_cursor($conn);
        oci_bind_by_name($stmt, ":result", $result, -1, OCI_B_CURSOR);
        oci_bind_by_name($stmt, ":p_idCargo", $p_idCargo);
        oci_execute($stmt);  
        oci_execute($result); 
        oci_free_statement($stmt);
        $cargo = oci_fetch_assoc($result);  
        oci_free_statement($result);
        return $cargo;
    }

    // Función para obtener todos los cargos

public function getCargos()
{
    $cargos = array();
    $conn = $this->db;
    $stmt = oci_parse($conn, "BEGIN GetCargos(:p_cargos); END;");
    $p_cargos = oci_new_cursor($conn);
    oci_bind_by_name($stmt, ":p_cargos", $p_cargos, -1, OCI_B_CURSOR);
    oci_execute($stmt);
    oci_execute($p_cargos);
    while ($row = oci_fetch_assoc($p_cargos)) {
        array_push($cargos, $row);
    }
    oci_free_statement($p_cargos);
    oci_free_statement($stmt);

    return array('datos' => $cargos);
}



    // Función para insertar un nuevo cargo
    
 public function insertCargo($p_cargo)
    {
        $conn = $this->db;
        $stmt = oci_parse($conn, "BEGIN insertCargo(:p_cargo, :p_resultado); END;");    
        oci_bind_by_name($stmt, ":p_cargo", $p_cargo);    
        $p_resultado = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);
        oci_execute($stmt);
        oci_free_statement($stmt);
    
        if ($p_resultado == 1) {
            return array('resultado' => 1, 'mensaje' => 'Nuevo cargo insertado exitosamente: ' . $p_cargo);
        } else {
            return array('resultado' => 0, 'mensaje' => 'Error en la inserción del nuevo cargo.');
        }
}
    
    



    // Función para actualizar un cargo

public function updateCargo($p_idCargo, $p_nuevoCargo)
    {
        $conn = $this->db;
        $stmt = oci_parse($conn, "BEGIN updateCargo(:p_idCargo, :p_nuevoCargo, :p_resultado); END;");   
        oci_bind_by_name($stmt, ":p_idCargo", $p_idCargo);
        oci_bind_by_name($stmt, ":p_nuevoCargo", $p_nuevoCargo);  
        $p_resultado = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);
        oci_execute($stmt);
        oci_free_statement($stmt);
        if ($p_resultado > 0) {
            return array('resultado' => 1, 'mensaje' => 'Cargo actualizado exitosamente: ' . $p_nuevoCargo);
        } else {
            return array('resultado' => 0, 'mensaje' => 'Error al actualizar el cargo.');
        }
    }
    
    

 // Función para eliminar un cargo por su ID
 public function deleteCargo($p_idCargo)
 {
     $conn = $this->db;
     $stmt = oci_parse($conn, "BEGIN deleteCargo(:p_idCargo, :p_resultado); END;");    
     oci_bind_by_name($stmt, ":p_idCargo", $p_idCargo);    
     $p_resultado = 0;
     oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);
     oci_execute($stmt);
     oci_free_statement($stmt);
     if ($p_resultado > 0) {
         return array('resultado' => 1, 'mensaje' => 'Cargo eliminado exitosamente.');
     } else {
         return array('resultado' => 0, 'mensaje' => 'Error en la eliminación del cargo o el cargo no existe.');
     }
 }
 
 

// Función para buscar un cargo por su ID
public function buscarCargos($p_idCargo)
{
    $conn = $this->db;
    $stmt = oci_parse($conn, "BEGIN BuscarCargos(:p_idCargo, :p_nombreCargo, :p_resultado); END;");
    oci_bind_by_name($stmt, ":p_idCargo", $p_idCargo);
    $p_nombreCargo = null;
    oci_bind_by_name($stmt, ":p_nombreCargo", $p_nombreCargo, 30); // Assuming VARCHAR2(30) 
    $p_resultado = 0;
    oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);
    oci_execute($stmt);
    oci_free_statement($stmt);
    if ($p_resultado == 1) {
        return array('resultado' => 1, 'nombreCargo' => $p_nombreCargo, 'mensaje' => 'Cargo encontrado exitosamente: ' . $p_nombreCargo);
    } elseif ($p_resultado == 0) {
        return array('resultado' => 0, 'nombreCargo' => null, 'mensaje' => 'Cargo no encontrado.');
    } else {
        return array('resultado' => 9, 'nombreCargo' => null, 'mensaje' => 'Error en la búsqueda del cargo.');
    }
}
}
?>