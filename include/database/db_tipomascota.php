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


    // Función para obtener un tipo de mascota por su ID
    public function getTipoMascota($id)
    {
        $conn = $this->db;
        $stmt = oci_parse($conn, "BEGIN P_TIPOMASCOTA.getTipoMascota (:p_idTipoMascota, :p_Tipo, :p_resultado); END;");

        oci_bind_by_name($stmt, ":p_idTipoMascota", $id);
        $p_idTipoMascota = "";
        $p_Tipo = "";
        $p_resultado = 0;

        oci_bind_by_name($stmt, ":p_idTipoMascota", $p_idTipoMascota, 200);
        oci_bind_by_name($stmt, ":p_Tipo", $p_Tipo, 30);
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        $tipoMascota = null;
        if ($p_resultado == 1) {
            $tipoMascota = array(
                'idTipoMascota' => $id,
                'tipo' => $p_Tipo,
            );
        }

        return array('datos' => $tipoMascota, 'resultado' => $p_resultado);
    }

    // Función para obtener todos los tipos de mascotas
    public function getTipoMascotas()
    {
        $tipoMascotas = array();
        $conn = $this->db;

        $stmt = oci_parse($conn, "BEGIN P_TIPOMASCOTA.getTipoMascotas(:p_cursor, :p_resultado); END;");
        $p_cursor = oci_new_cursor($conn);
        oci_bind_by_name($stmt, ":p_cursor", $p_cursor, -1, OCI_B_CURSOR);
        $p_resultado = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        // Solo ejecuta el cursor si el resultado es 1
        if ($p_resultado == 1) {
            oci_execute($p_cursor);
            while ($row = oci_fetch_assoc($p_cursor)) {
                array_push($tipoMascotas, $row);
            }

        }
        oci_free_statement($p_cursor);
        oci_free_statement($stmt);

        return array('datos' => $tipoMascotas, 'resultado' => $p_resultado);
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

        $tipoMascotas = [];
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