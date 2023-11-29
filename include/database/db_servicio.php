<?php
require_once 'db_config.php';

class Servicio
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

   
// Función para obtener un servicio por su ID

public function getServicio($p_id)
{
    $conn = $this->db;
    $stmt = oci_parse($conn, "BEGIN P:SERVICIOS.getServicio(:p_idServicio, :p_Servicio, :p_Descripcion, :p_resultado); END;");   
   
    oci_bind_by_name($stmt, ":p_idServicio", $id);  

        $p_Servicio = "";
        $p_Descripcion = "";
        $p_resultado = 0;

        oci_bind_by_name($stmt, ":p_Servicio", $p_Servicio, 200);
        oci_bind_by_name($stmt, ":p_Descripcion", $p_Descripcion, 200);
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        $servicio = null;
        if ($p_resultado == 1) {
            $servicio = array(
                'idServicio' => $id,
                'servicio' => $p_Servicio,
                'descripcion' => $p_Descripcion
            );
        }

        return array('datos' => $servicio, 'resultado' => $p_resultado);
}





    // Función para obtener todos los servicios
    public function getServicios()
    {
        $servicios = array();
        $conn = $this->db;

        $stmt = oci_parse($conn, "BEGIN P_SERVICIOS.getServicios(:p_cursor, :p_resultado); END;");        
        $p_cursor = oci_new_cursor($conn);
        oci_bind_by_name($stmt, ":p_cursor", $p_cursor, -1, OCI_B_CURSOR);  
        $p_resultado =0;  
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        if ($p_resultado == 1) {
            oci_execute($p_cursor);
            while ($row = oci_fetch_assoc($p_cursor)) {
                array_push($servicios, $row);
            }
        }

        oci_free_statement($p_cursor);
        oci_free_statement($stmt);

        return array('datos' => $servicios, 'resultado' => $p_resultado);
    }
    
   

    // Función para insertar un nuevo servicio
    public function insertServicio($servicio, $descripcion)
    {
        $conn = $this->db; 

        $stmt = oci_parse($conn, "BEGIN P_SERVICIOS.insertServicio(:p_Servicio, :p_Descripcion, :p_resultado); END;");
        
        oci_bind_by_name($stmt, ":p_Especialidad", $servicio);
        oci_bind_by_name($stmt, ":p_Descripcion", $descripcion);

        $p_resultado = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT); 

        oci_execute($stmt);
        
        return $p_resultado;
    }
    
    




// Función para actualizar un servicio
public function updateServicio($id, $servicio, $descripcion)
{
    $conn = $this->db;

    $stmt = oci_parse($conn, "BEGIN P_SERVICIOS.updateServicio(:p_idServicio, :p_Servicio, :p_Descripcion, :p_resultado); END;");
    
    oci_bind_by_name($stmt, ":p_idServicio", $pido);
    oci_bind_by_name($stmt, ":p_Servicio", $p_servicio);
    oci_bind_by_name($stmt, ":p_Descripcion", $descripcion);

    $p_resultado = 0;
    oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT); 
    oci_execute($stmt);
    
    return $p_resultado;
}



// Función para eliminar un servicio por su ID
public function deleteServicio($p_idServicio)
{
    $conn = $this->db;

    $stmt = oci_parse($conn, "BEGIN P_SERVICIOS.deleteServicio(:p_idServicio, :p_resultado); END;"); 
    
    oci_bind_by_name($stmt, ":p_idServicio", $id);   
    $p_resultado = 0;

    oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT); 
   
    oci_execute($stmt);
    
    return $p_resultado;
}




// Función para buscar un servicio por su ID
public function buscarServicios($p_searchTerm)
{
    $conn = $this->db;
    $stmt = oci_parse($conn, "BEGIN P_SERVICIOS.buscarServicios(:p_searchTerm, :p_cursor, :p_resultado); END;");    
   
    oci_bind_by_name($stmt, ":p_searchTerm", $p_searchTerm);    
    $p_cursor = oci_new_cursor($conn);
    oci_bind_by_name($stmt, ":p_cursor", $p_cursor, -1, OCI_B_CURSOR);
    $p_resultado = 0;
    oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT); 

    oci_execute($p_resultado);

    $servicios = [];
    if ($p_resultado == 1) {
        oci_execute($p_cursor);
        while ($row = oci_fetch_assoc($p_cursor)) {
            array_push($servicios, $row);
        }
    }

    oci_free_statement($p_cursor);
    oci_free_statement($stmt);

    return $servicios;
}
}
?>