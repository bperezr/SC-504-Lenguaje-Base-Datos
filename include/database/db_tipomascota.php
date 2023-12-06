<?php
require_once 'db_config.php';
define('SQL_INT', OCI_B_INT); 

class TipoMascota
{
    protected $db;

    public function __construct()
    {
        $this->connectDB();
    }

                                                        /* public function connectDB()
                                            {
                                                global $host, $port, $user, $pass, $dbname;

                                                $dsn = "mysql:host=$host;port=$port;dbname=$dbname";
                                                try {
                                                    $this->db = new PDO($dsn, $user, $pass);
                                                    $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                                } catch (PDOException $e) {
                                                    die('Error al conectar a la base de datos: ' . $e->getMessage());
                                                }
                                            } */

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


    // Función para obtener un tipo de mascota por su ID
    /*public function getTipoMascota($id)
    {
        $query = "SELECT * FROM tipomascota WHERE idTipoMascota = :idTipoMascota";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idTipoMascota', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }*/

    

    // Función para obtener todos los tipos de mascotas
                                      /*   public function getTipoMascotas()
                                     {
                                            $query = "SELECT * FROM tipomascota";
                                            $stmt = $this->db->query($query);
                                            return $stmt->fetchAll(PDO::FETCH_ASSOC);
                                        }*/





public function getTipoMascotas()
{
    try {
        // Llamada al procedimiento almacenado
        $cursor = $this->db->prepare("BEGIN GETTIPOMASCOTAS(:cursor); END;");
        $cursor->bindParam(':cursor', $result, PDO::PARAM_STMT);
        $cursor->execute();

        // Recuperar datos del cursor
        $result = oci_new_cursor($this->db);  // Mover esta línea antes del execute
        oci_execute($result);

        $data = array();
        while ($row = oci_fetch_assoc($result)) {
            $data[] = $row;
        }

        return $data;
        $this->db = new PDO("oci:dbname=//$host:$port/$sid", $user, $pass);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die('Error al conectar a la base de datos Oracle: ' . $e->getMessage());
    } catch (PDOException $e) {
        die('Error al obtener datos: ' . $e->getMessage() . ' (SQLSTATE ' . $e->getCode() . ')');
    }
}





    // Función para insertar un nuevo tipo de mascota
    public function insertTipoMascota($tipo)
    {
        $conn = $this->db;

        $stmt = oci_parse($conn, "BEGIN P_TIPOMASCOTA.insertTipoMascota(:p_Tipo, :p_resultado); END;");    

        oci_bind_by_name($stmt, ":p_Tipo", $tipo);    
        
        $p_resultado = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);
        oci_execute($stmt);
        
        return $p_resultado;
    }
    
    // Función para actualizar un tipo de mascota
    public function updateTipoMascota($id, $tipo)
    {
        $conn = $this->db;
        $stmt = oci_parse($conn, "BEGIN P_TIPOMASCOTA.updateTipoMascota(:p_idTipoMascota, :p_Tipo, :p_resultado); END;");   
        
        oci_bind_by_name($stmt, ":p_idTipoMascota", $id);
        oci_bind_by_name($stmt, ":p_Tipo", $tipo);  

        $p_resultado = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);
        
        oci_execute($stmt);
        
       return $p_resultado;
    }

    // Función para eliminar un tipo de mascota por su ID
    public function deleteTipoMascota($id)
    {
        $conn = $this->db;
        $stmt = oci_parse($conn, "BEGIN P_TIPOMASCOTA.deleteTipoMascota(:p_idTipoMascota, :p_resultado); END;");    
        oci_bind_by_name($stmt, ":p_idTipoMascota", $p_id);    
        $p_resultado = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);
        
        oci_execute($stmt);
        
        return $p_resultado;
    }

    // Función para buscar tipos de mascota
    public function buscarTipoMascotas($searchTerm)
    {
        $conn = $this->db;
        $stmt = oci_parse($conn, "BEGIN P_TIPOMASCOTA.buscarTipoMascotas(:p_searchTerm, :p_cursor, :p_resultado); END;");
    
        oci_bind_by_name($stmt, ":p_searchTerm", $searchTerm);
        $p_cursor = oci_new_cursor($conn);
    
        oci_bind_by_name($stmt, ":p_cursor", $p_cursor, -1, OCI_B_CURSOR); 
        $p_resultado = 0;
        
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);
    
        oci_execute($stmt);
    
        $tipoMascotas =[];
        if ($p_resultado == 1) {
            oci_execute($p_cursor);
            while ($row = oci_fetch_assoc($p_cursor)) {
                array_push($tipoMascotas, $row);
            }
        }
    
        oci_free_statement($p_cursor);
        oci_free_statement($stmt);
    
        return $tipoMascotas;
    
    }
}

?>