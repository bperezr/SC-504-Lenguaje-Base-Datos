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

        try {
            $this->db = oci_connect($user, $pass, "//{$host}:{$port}/{$sid}");
            if (!$this->db) {
                die('Error al conectar a la base de datos Oracle: ' . oci_error());
            }
        } catch (Exception $e) {
            die('Error al conectar a la base de datos Oracle: ' . $e->getMessage());
        }
    }

    // Función para obtener un cargo por su ID    
    public function getCargo($id)
    {
        $conn = $this->db;
        $stmt = oci_parse($conn, "BEGIN :result := P_CARGO.GetCargo(:p_idCargo); END;");       
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
    
        $p_resultado = 0;
    
        $stmt = oci_parse($conn, "BEGIN P_CARGO.GetCargos(:p_cargos, :p_resultado); END;");
    
        $p_cargos = oci_new_cursor($conn);
        oci_bind_by_name($stmt, ":p_cargos", $p_cargos, -1, OCI_B_CURSOR);
    
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);
    
        oci_execute($stmt);
    
        if ($p_resultado == 1) {
            oci_execute($p_cargos);
            while ($row = oci_fetch_assoc($p_cargos)) {
                array_push($cargos, $row);
            }
            oci_free_statement($p_cargos);
        } else {
            $cargos = array();
        }
    
        oci_free_statement($stmt);
    
        return array('datos' => $cargos, 'resultado' => $p_resultado);
    }
    


    // Función para insertar un nuevo cargo
    
 public function insertCargo($cargo)
    {
        $conn = $this->db;

        $stmt = oci_parse($conn, "BEGIN P_CARGO.insertCargo(:p_cargo, :p_resultado); END;");    

        oci_bind_by_name($stmt, ":p_cargo", $cargo);    
        
        $p_resultado = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);
        oci_execute($stmt);
        
        return $p_resultado;
}
    
    



    // Función para actualizar un cargo

public function updateCargo($id, $cargo)
    {
        $conn = $this->db;
        $stmt = oci_parse($conn, "BEGIN P_CARGO.updateCargo(:p_idCargo, :p_Cargo, :p_resultado); END;");   
        
        oci_bind_by_name($stmt, ":p_idCargo", $id);
        oci_bind_by_name($stmt, ":p_Cargo", $cargo);  

        $p_resultado = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);
        
        oci_execute($stmt);
        
       return $p_resultado;
    }
    
    

 // Función para eliminar un cargo por su ID
 public function deleteCargo($id)
 {
     $conn = $this->db;
     $stmt = oci_parse($conn, "BEGIN P_CARGO.deleteCargo(:p_idCargo, :p_resultado); END;");    
     oci_bind_by_name($stmt, ":p_idCargo", $p_id);    
     $p_resultado = 0;
     oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);
     
     oci_execute($stmt);
     
     return $p_resultado;
 }
 
 

// Función para buscar cargos
public function buscarCargos($searchTerm)
{
    $conn = $this->db;
    $stmt = oci_parse($conn, "BEGIN P_CARGO.buscarCargos(:p_searchTerm, :p_cursor, :p_resultado); END;");

    oci_bind_by_name($stmt, ":p_searchTerm", $searchTerm);
    $p_cursor = oci_new_cursor($conn);

    oci_bind_by_name($stmt, ":p_cursor", $p_cursor, -1, OCI_B_CURSOR); 
    $p_resultado = 0;
    
    oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

    oci_execute($stmt);

    $cargos =[];
    if ($p_resultado == 1) {
        oci_execute($p_cursor);
        while ($row = oci_fetch_assoc($p_cursor)) {
            array_push($cargos, $row);
        }
    }

    oci_free_statement($p_cursor);
    oci_free_statement($stmt);

    return $cargos;

}

}
?>