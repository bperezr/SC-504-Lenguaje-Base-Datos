<?php
require_once 'db_config.php';

class Servicio
{
    protected $db;

    public function __construct()
    {
        $this->connectDB();
    }

    /*public function connectDB()
    {
        global $host, $port, $user, $pass, $dbname;

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

   
// Función para obtener un servicio por su ID

public function getServicio($p_idServicio)
{
    $conn = $this->db;
    $stmt = oci_parse($conn, "BEGIN getServicio(:p_idServicio, :p_nombre, :p_descripcion, :p_resultado); END;");   
    oci_bind_by_name($stmt, ":p_idServicio", $p_idServicio);  
    $p_nombre = null;
    oci_bind_by_name($stmt, ":p_nombre", $p_nombre, 30); 
    $p_descripcion = null;
    oci_bind_by_name($stmt, ":p_descripcion", $p_descripcion, 100); 
    $p_resultado = 0;
    oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);
    oci_execute($stmt);
    oci_free_statement($stmt);
    if ($p_resultado == 1) {
        return array('resultado' => 1, 'nombreServicio' => $p_nombre, 'descripcionServicio' => $p_descripcion, 'mensaje' => 'Servicio encontrado exitosamente: ' . $p_nombre . ', Descripción: ' . $p_descripcion);
    } elseif ($p_resultado == 0) {
        return array('resultado' => 0, 'nombreServicio' => null, 'descripcionServicio' => null, 'mensaje' => 'Servicio no encontrado.');
    } else {
        return array('resultado' => 9, 'nombreServicio' => null, 'descripcionServicio' => null, 'mensaje' => 'Error en la búsqueda del servicio.');
    }
}





    // Función para obtener todos los servicios
    public function getServicios()
    {
        $conn = $this->db;
        $stmt = oci_parse($conn, "BEGIN GetServicios(:p_resultado); END;");        
        $p_resultado = oci_new_cursor($conn);
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, OCI_B_CURSOR);    
        oci_execute($stmt);    
        oci_execute($p_resultado);    
        oci_free_statement($stmt);   
        $servicios = array();
        while ($row = oci_fetch_assoc($p_resultado)) {
            array_push($servicios, $row);
        }
        oci_free_statement($p_resultado);    
        return $servicios;
    }
    
   

    // Función para insertar un nuevo servicio
    public function insertServicio($p_servicio, $p_descripcion)
    {
        $conn = $this->db; 
        $stmt = oci_parse($conn, "BEGIN insertServicio(:p_servicio, :p_descripcion, :p_resultado); END;");
        oci_bind_by_name($stmt, ":p_servicio", $p_servicio);
        oci_bind_by_name($stmt, ":p_descripcion", $p_descripcion);
        $p_resultado = null;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, 100); 
        oci_execute($stmt);
        oci_free_statement($stmt);
        if (strpos($p_resultado, 'Éxito') !== false) {
            return array('resultado' => 1, 'mensaje' => $p_resultado);
        } else {
            return array('resultado' => 0, 'mensaje' => $p_resultado);
        }
    }
    
    




// Función para actualizar un servicio
public function updateServicio($p_idServicio, $p_nuevoServicio, $p_nuevaDescripcion)
{
    $conn = $this->db;
    $stmt = oci_parse($conn, "BEGIN UpdateServicio(:p_idServicio, :p_nuevoServicio, :p_nuevaDescripcion, :p_resultado); END;");
    
    oci_bind_by_name($stmt, ":p_idServicio", $p_idServicio);
    oci_bind_by_name($stmt, ":p_nuevoServicio", $p_nuevoServicio);
    oci_bind_by_name($stmt, ":p_nuevaDescripcion", $p_nuevaDescripcion);
    $p_resultado = null;
    oci_bind_by_name($stmt, ":p_resultado", $p_resultado, 100); 
    oci_execute($stmt);
    oci_free_statement($stmt);
    if (strpos($p_resultado, 'Éxito') !== false) {
        return array('resultado' => 1, 'mensaje' => $p_resultado);
    } else {
        return array('resultado' => 0, 'mensaje' => $p_resultado);
    }
}



// Función para eliminar un servicio por su ID
public function deleteServicio($p_idServicio)
{
    $conn = $this->db;
    $stmt = oci_parse($conn, "BEGIN DeleteServicio(:p_idServicio, :p_resultado); END;"); 
    oci_bind_by_name($stmt, ":p_idServicio", $p_idServicio);   
    $p_resultado = null;
    oci_bind_by_name($stmt, ":p_resultado", $p_resultado, 100); 
    oci_execute($stmt);
    oci_free_statement($stmt);
    if (strpos($p_resultado, 'Éxito') !== false) {
        return array('resultado' => 1, 'mensaje' => $p_resultado);
    } else {
        return array('resultado' => 0, 'mensaje' => $p_resultado);
    }
}




// Función para buscar un servicio por su ID
public function buscarServicios($p_searchTerm)
{
    $conn = $this->db;
    $stmt = oci_parse($conn, "BEGIN BuscarServicios(:p_searchTerm, :p_resultado, :p_resultadoBusqueda); END;");    
    oci_bind_by_name($stmt, ":p_searchTerm", $p_searchTerm);    
    $p_resultado = oci_new_cursor($conn);
    oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, OCI_B_CURSOR);
    $p_resultadoBusqueda = null;
    oci_bind_by_name($stmt, ":p_resultadoBusqueda", $p_resultadoBusqueda, 100); 
    oci_execute($p_resultado);
    oci_free_statement($stmt);
    if (strpos($p_resultadoBusqueda, 'Éxito') !== false) {
        $servicios = array();
        while ($row = oci_fetch_assoc($p_resultado)) {
            array_push($servicios, $row);
        }
        return array('resultado' => 1, 'mensaje' => $p_resultadoBusqueda, 'servicios' => $servicios);
    } else {
        return array('resultado' => 0, 'mensaje' => $p_resultadoBusqueda);
    }
}









}

?>