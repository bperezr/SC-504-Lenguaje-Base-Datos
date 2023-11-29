<?php
require_once 'db_config.php';
define('SQL_INT', OCI_B_INT);

class Cargo
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

    // Función para obtener un cargo por su ID    
    public function getCargo()
    {
        $conn = $this->db;
        $stmt = oci_parse($conn, "BEGIN P_CARGO.getCargo (:p_idCargo, :p_Cargo, :p_resultado); END;");
    
        oci_bind_by_name($stmt, ":p_idCargo", $id);
        
        $p_cargo = "";
        $p_resultado = 0;
        
        oci_bind_by_name($stmt, ":p_Cargo", $p_cargo, 30);
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);
        
        oci_execute($stmt);
    
        $cargo = null;
        if ($p_resultado == 1) {
            $cargo = array(
                'idCargo' => $id,
                'cargo' => $p_cargo,
            );
        }
    
        return array('datos' => $cargo, 'resultado' => $p_resultado);
    }
    

    // Función para obtener todos los cargos

    public function getCargos()
    {
        $cargos = array();
        $conn = $this->db;
    
        $stmt = oci_parse($conn, "BEGIN P_CARGO.getCargos(:p_cursor, :p_resultado); END;");
        $p_cursor = oci_new_cursor($conn);
        oci_bind_by_name($stmt, ":p_cursor", $p_cursor, -1, OCI_B_CURSOR);
        $p_resultado = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);
    
        oci_execute($stmt);
    
        // Solo ejecuta el cursor si el resultado es 1
        if ($p_resultado == 1) {
            oci_execute($p_cursor);
            while ($row = oci_fetch_assoc($p_cursor)) {
                array_push($cargos, $row);
            }
            oci_free_statement($p_cursor);
        }
    
        oci_free_statement($stmt);
    
        return array('datos' => $cargos, 'resultado' => $p_resultado);
    }
    



    // Función para insertar un nuevo cargo
    
 public function insertCargo($cargos)
    {
        $conn = $this->db;
        $stmt = oci_parse($conn, "BEGIN P_CARGO.insertCargo(:p_cargo, :p_resultado); END;");    
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
        $stmt = oci_parse($conn, "BEGIN P_CARGO.updateCargo(:p_idCargo, :p_nuevoCargo, :p_resultado); END;");   
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
     $stmt = oci_parse($conn, "BEGIN P_CARGO.deleteCargo(:p_idCargo, :p_resultado); END;");    
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
    $stmt = oci_parse($conn, "BEGIN P_CARGO.buscarCargos(:p_idCargo, :p_nombreCargo, :p_resultado); END;");

    oci_bind_by_name($stmt, ":p_idCargo", $p_idCargo);
    $p_nombreCargo = null;
    oci_bind_by_name($stmt, ":p_nombreCargo", $p_nombreCargo, 30); 
    $p_resultado = 0;
    oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

    oci_execute($stmt);

    $error = oci_error($stmt);
    if ($error) {
        return array('resultado' => 9, 'nombreCargo' => null, 'mensaje' => 'Error en la búsqueda del cargo: ' . $error['message']);
    }

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