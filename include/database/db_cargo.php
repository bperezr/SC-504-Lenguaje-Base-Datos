<?php
require_once 'db_config.php';

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
    public function getCargo($id)
    {
        $conn = $this->db;
        $stmt = oci_parse($conn, "BEGIN  P_CARGO.getCargo (:p_idCargo, :p_Cargo, :p_resultado); END;");

        oci_bind_by_name($stmt, ":p_idCargo", $id);

        $p_Cargo = "";
        $p_resultado = 0;

        oci_bind_by_name($stmt, ":p_Cargo", $p_Cargo, 200);
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        $cargo = null;
        if ($p_resultado == 1) {
            $cargo = array(
                'idCargo' => $id,
                'cargo' => $p_Cargo,
            );
        }

        return array('datos' => $cargo, 'resultado' => $p_resultado);
    }

    // Función para obtener todos los cargos

    public function getCargos()
    {
        $cargos = array();
        $conn = $this->db;

        $stmt = oci_parse($conn, "BEGIN  P_CARGO.getCargos(:p_cursor, :p_resultado); END;");
        $p_cursor = oci_new_cursor($conn);
        oci_bind_by_name($stmt, ":p_cursor", $p_cursor, -1, OCI_B_CURSOR);
        $p_resultado = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        if ($p_resultado == 1) {
            oci_execute($p_cursor);
            while ($row = oci_fetch_assoc($p_cursor)) {
                array_push($cargos, $row);
            }

        }
        oci_free_statement($p_cursor);
        oci_free_statement($stmt);

        return array('datos' => $cargos, 'resultado' => $p_resultado);
    }

    // Función para insertar un nuevo cargo

    public function insertCargo($cargo)
    {
        $conn = $this->db;

        $stmt = oci_parse($conn, "BEGIN P_CARGO.insertCargo(:p_Cargo, :p_resultado); END;");

        oci_bind_by_name($stmt, ":p_Cargo", $cargo);

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

        oci_bind_by_name($stmt, ":p_idCargo", $id);
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

        $cargos = [];
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