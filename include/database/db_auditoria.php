<?php
require_once 'db_config.php';

class Auditoria
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

    // Función para obtener un por su ID
    public function getAuditoriaCita($idAuditoria)
    {
        $stmt = oci_parse($this->db, "BEGIN P_AUDITORIA.getAuditoriaCita(:p_idAuditoria, :p_fechaModificacion, :p_idCita, :p_modificador, :p_nuevoEstado, :p_resultado); END;");

        oci_bind_by_name($stmt, ":p_idAuditoria", $idAuditoria);

        // Declarar variables para los parámetros OUT
        $p_fechaModificacion = '';
        $p_idCita = -1;
        $p_modificador = '';
        $p_nuevoEstado = '';
        $p_resultado = null;

        // Vincular parámetros OUT
        oci_bind_by_name($stmt, ":p_fechaModificacion", $p_fechaModificacion, 100);
        oci_bind_by_name($stmt, ":p_idCita", $p_idCita, -1, SQLT_INT);
        oci_bind_by_name($stmt, ":p_modificador", $p_modificador, 100);
        oci_bind_by_name($stmt, ":p_nuevoEstado", $p_nuevoEstado, 100);
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        $auditoriaCita = null;
        if ($p_resultado == 0) {
            $auditoriaCita = array(
                'idAuditoria' => $idAuditoria,
                'fechaModificacion' => $p_fechaModificacion,
                'idCita' => $p_idCita,
                'modificador' => $p_modificador,
                'nuevoEstado' => $p_nuevoEstado
            );
        }

        return array('datos' => $auditoriaCita, 'resultado' => $p_resultado);
    }

    // Función para obtener todos
    public function getAuditoriasCitas()
    {
        $stmt = oci_parse($this->db, "BEGIN P_AUDITORIA.getAuditoriasCitas(:p_cursor, :p_resultado); END;");

        $p_cursor = oci_new_cursor($this->db);
        oci_bind_by_name($stmt, ":p_cursor", $p_cursor, -1, OCI_B_CURSOR);

        $p_resultado = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        $auditoriasCitas = array();
        if ($p_resultado == 0) {
            oci_execute($p_cursor);
            while ($row = oci_fetch_assoc($p_cursor)) {
                array_push($auditoriasCitas, $row);
            }
        }

        oci_free_statement($p_cursor);
        oci_free_statement($stmt);

        return array('datos' => $auditoriasCitas, 'resultado' => $p_resultado);
    }

    // Función para buscar
    public function buscarAuditoriasCitas($searchTerm)
    {
        $conn = $this->db;

        $stmt = oci_parse($conn, "BEGIN P_AUDITORIA.buscarAuditoriasCitas(:p_searchTerm, :p_cursor, :p_resultado, :p_numFilas); END;");

        oci_bind_by_name($stmt, ":p_searchTerm", $searchTerm);
        $p_cursor = oci_new_cursor($conn);
        oci_bind_by_name($stmt, ":p_cursor", $p_cursor, -1, OCI_B_CURSOR);
        $p_resultado = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);
        $p_numFilas = 0;
        oci_bind_by_name($stmt, ":p_numFilas", $p_numFilas, -1, SQLT_INT);

        oci_execute($stmt);

        $auditoriasCitas = [];
        if ($p_resultado == 0) {
            oci_execute($p_cursor);
            while ($row = oci_fetch_assoc($p_cursor)) {
                array_push($auditoriasCitas, $row);
            }
        }

        oci_free_statement($p_cursor);
        oci_free_statement($stmt);

        return ['datos' => $auditoriasCitas, 'numFilas' => $p_numFilas, 'resultado' => $p_resultado];
    }


}
?>