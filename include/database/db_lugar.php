<?php
require_once 'db_config.php';

class Lugar
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
    //done
    public function getNombreProvinciaPorID($idProvincia)
    {
        $conn = $this->db;
        $stmt = oci_parse($conn, "BEGIN P_LUGAR.getNombreProvinciaPorID(:p_idProvincia, :p_nombreProvincia, :p_resultado); END;");

        oci_bind_by_name($stmt, ":p_idProvincia", $idProvincia, -1, SQLT_INT);

        $p_nombreProvincia = "";
        $p_resultado = 0;

        oci_bind_by_name($stmt, ":p_nombreProvincia", $p_nombreProvincia, 100);
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        $nombreProvincia = null;
        if ($p_resultado == 1) {
            $nombreProvincia = $p_nombreProvincia;
        }

        return array('datos' => $nombreProvincia, 'resultado' => $p_resultado);
    }

    //done
    public function getNombreCantonPorID($idCanton)
    {
        $conn = $this->db;
        $stmt = oci_parse($conn, "BEGIN P_LUGAR.getNombreCantonPorID(:p_idCanton, :p_nombreCanton, :p_resultado); END;");

        oci_bind_by_name($stmt, ":p_idCanton", $idCanton, -1, SQLT_INT);

        $p_nombreCanton = "";
        $p_resultado = 0;

        oci_bind_by_name($stmt, ":p_nombreCanton", $p_nombreCanton, 200);
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        $nombreCanton = null;
        if ($p_resultado == 1) {
            $nombreCanton = $p_nombreCanton;
        }

        return array('datos' => $nombreCanton, 'resultado' => $p_resultado);
    }

    //done
    public function getNombreDistritoPorID($idDistrito)
    {
        $conn = $this->db;
        $stmt = oci_parse($conn, "BEGIN P_LUGAR.getNombreDistritoPorID(:p_idDistrito, :p_nombreDistrito, :p_resultado); END;");

        oci_bind_by_name($stmt, ":p_idDistrito", $idDistrito, -1, SQLT_INT);

        $p_nombreDistrito = "";
        $p_resultado = 0;

        oci_bind_by_name($stmt, ":p_nombreDistrito", $p_nombreDistrito, 200);
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        $nombreDistrito = null;
        if ($p_resultado == 1) {
            $nombreDistrito = $p_nombreDistrito;
        }

        return array('datos' => $nombreDistrito, 'resultado' => $p_resultado);
    }

    //done
    public function getCantonesPorProvincia($idProvincia)
    {
        $conn = $this->db;

        $stmt = oci_parse($conn, "BEGIN P_LUGAR.getCantonesPorProvincia(:p_idProvincia, :p_cursor, :p_resultado); END;");

        oci_bind_by_name($stmt, ":p_idProvincia", $idProvincia, -1, SQLT_INT);
        $p_cursor = oci_new_cursor($conn);

        oci_bind_by_name($stmt, ":p_cursor", $p_cursor, -1, OCI_B_CURSOR);
        $p_resultado = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        oci_execute($p_cursor);

        $cantones = [];
        while (($row = oci_fetch_assoc($p_cursor)) != false) {
            $cantones[] = $row;
        }

        oci_free_statement($p_cursor);
        oci_free_statement($stmt);

        return array('datos' => $cantones, 'resultado' => $p_resultado);
    }
    //done
    public function getDistritosPorCanton($idCanton)
    {
        $conn = $this->db;
        $stmt = oci_parse($conn, "BEGIN P_LUGAR.getDistritosPorCanton(:p_idCanton, :p_cursor, :p_resultado); END;");

        oci_bind_by_name($stmt, ":p_idCanton", $idCanton);
        $p_cursor = oci_new_cursor($conn);
        oci_bind_by_name($stmt, ":p_cursor", $p_cursor, -1, OCI_B_CURSOR);
        $p_resultado = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        $distritos = [];
        if ($p_resultado == 1) {
            oci_execute($p_cursor);
            while ($row = oci_fetch_assoc($p_cursor)) {
                array_push($distritos, $row);
            }
        }

        oci_free_statement($p_cursor);
        oci_free_statement($stmt);

        return array('datos' => $distritos, 'resultado' => $p_resultado);
    }

    public function getProvincias()
    {
        $conn = $this->db;

        $stmt = oci_parse($conn, "BEGIN P_LUGAR.getProvincias(:p_cursor, :p_resultado); END;");

        $p_cursor = oci_new_cursor($conn);

        $p_resultado = 0;
        oci_bind_by_name($stmt, ":p_cursor", $p_cursor, -1, OCI_B_CURSOR);
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        oci_execute($p_cursor);

        $provincias = [];
        while (($row = oci_fetch_assoc($p_cursor)) != false) {
            $provincias[] = $row;
        }

        oci_free_statement($p_cursor);
        oci_free_statement($stmt);

        return array('datos' => $provincias, 'resultado' => $p_resultado);
    }
    public function getCantones()
    {
        $conn = $this->db;

        $stmt = oci_parse($conn, "BEGIN P_LUGAR.getCantones(:p_cursor, :p_resultado); END;");

        $p_cursor = oci_new_cursor($conn);
        $p_resultado = 0;

        oci_bind_by_name($stmt, ":p_cursor", $p_cursor, -1, OCI_B_CURSOR);
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);
        oci_execute($p_cursor);

        $cantones = [];
        while (($row = oci_fetch_assoc($p_cursor)) != false) {
            $cantones[] = $row;
        }

        oci_free_statement($p_cursor);
        oci_free_statement($stmt);

        return array('datos' => $cantones, 'resultado' => $p_resultado);
    }

    public function getDistritos()
    {
        $conn = $this->db;

        $stmt = oci_parse($conn, "BEGIN P_LUGAR.getDistritos(:p_cursor, :p_resultado); END;");

        $p_cursor = oci_new_cursor($conn);
        $p_resultado = 0;

        oci_bind_by_name($stmt, ":p_cursor", $p_cursor, -1, OCI_B_CURSOR);
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);
        oci_execute($p_cursor);

        $distritos = [];
        while (($row = oci_fetch_assoc($p_cursor)) != false) {
            $distritos[] = $row;
        }

        oci_free_statement($p_cursor);
        oci_free_statement($stmt);

        return array('datos' => $distritos, 'resultado' => $p_resultado);
    }

    public function getLugares()
    {
        $conn = $this->db;

        $stmt = oci_parse($conn, "BEGIN P_LUGAR.getLugares(:p_cursor, :p_resultado); END;");

        $p_cursor = oci_new_cursor($conn);
        $p_resultado = 0;

        oci_bind_by_name($stmt, ":p_cursor", $p_cursor, -1, OCI_B_CURSOR);
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);
        oci_execute($p_cursor);

        $lugares = [];
        while (($row = oci_fetch_assoc($p_cursor)) != false) {
            $lugares[] = $row;
        }

        oci_free_statement($p_cursor);
        oci_free_statement($stmt);

        return array('datos' => $lugares, 'resultado' => $p_resultado);
    }


}
?>