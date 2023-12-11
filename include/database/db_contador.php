<?php
require_once 'db_config.php';

class Contador
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


    public function contarCitasAtendidas()
    {
        try {
            $stmt = oci_parse($this->db, "BEGIN :total_citas := contar_citas_atendidas; END;");
            oci_bind_by_name($stmt, ':total_citas', $total_citas, 10, SQLT_INT);
            oci_execute($stmt);
        
            return $total_citas;
        } catch (Exception $e) {
            die('Error al ejecutar la función contar_citas_atendidas: ' . $e->getMessage());
        }
    }

    public function contarCitasCanceladas()
    {
        try {
            $stmt = oci_parse($this->db, "BEGIN :total_citas := contar_citas_canceladas; END;");
            oci_bind_by_name($stmt, ':total_citas', $total_citas, 10, SQLT_INT);
            oci_execute($stmt);
    
            return $total_citas;
        } catch (Exception $e) {
            die('Error al ejecutar la función contar_citas_canceladas: ' . $e->getMessage());
        }
    }   
    
    public function contarCitasAsignadas()
    {
        try {
            $stmt = oci_parse($this->db, "BEGIN :total_citas := contar_citas_asignadas; END;");
            oci_bind_by_name($stmt, ':total_citas', $total_citas, 10, SQLT_INT);
            oci_execute($stmt);
    
            return $total_citas;
        } catch (Exception $e) {
            die('Error al ejecutar la función contar_citas_asignadas: ' . $e->getMessage());
        }
    }
    

    public function contarCitasAsignadasColaborador($idColaborador)
{
    try {
        $stmt = oci_parse($this->db, "BEGIN :total_citas := contar_citas_asignadas_colaborador(:id_colaborador); END;");
        oci_bind_by_name($stmt, ':total_citas', $totalCitas, 10, SQLT_INT);
        oci_bind_by_name($stmt, ':id_colaborador', $idColaborador, 10, SQLT_INT);
        oci_execute($stmt);

        return $totalCitas;
    } catch (Exception $e) {
        die('Error al ejecutar la función contar_citas_asignadas_colaborador: ' . $e->getMessage());
    }
}

public function contarCitasCanceladasColaborador($idColaborador)
{
    try {
        $stmt = oci_parse($this->db, "BEGIN :total_citas := contar_citas_canceladas_colaborador(:id_colaborador); END;");
        oci_bind_by_name($stmt, ':total_citas', $totalCitas, 10, SQLT_INT);
        oci_bind_by_name($stmt, ':id_colaborador', $idColaborador, 10, SQLT_INT);
        oci_execute($stmt);

        return $totalCitas;
    } catch (Exception $e) {
        die('Error al ejecutar la función contar_citas_canceladas_colaborador: ' . $e->getMessage());
    }
}

public function contarCitasAtendidasColaborador($idColaborador)
{
    try {
        $stmt = oci_parse($this->db, "BEGIN :total_citas := contar_citas_atendidas_colaborador(:id_colaborador); END;");
        oci_bind_by_name($stmt, ':total_citas', $totalCitas, 10, SQLT_INT);
        oci_bind_by_name($stmt, ':id_colaborador', $idColaborador, 10, SQLT_INT);
        oci_execute($stmt);

        return $totalCitas;
    } catch (Exception $e) {
        die('Error al ejecutar la función contar_citas_atendidas_colaborador: ' . $e->getMessage());
    }
}


}