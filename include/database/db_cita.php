<?php
require_once 'db_config.php';

class Cita
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

     public function getMascotasCliente($idCliente)
    {
        $stmt = oci_parse($this->db,"BEGIN P_CITA.getMascotasCliente(:p_IDCLIENTE, :P_IDMASCOTA, :p_NOMBRE, :p_DESCRIPCION, :p_IMAGEN, :p_IDTIPOMASCOTA, :p_resultado);END;");
    
        oci_bind_by_name($stmt, ":p_idCliente", $idCliente);
        $p_idMascota = 0;
        $p_nombre = '';
        $p_descripcion = '';
        $p_imagen = '';
        $p_idTipoMascota = 0;
        $p_resultado =0;

        oci_bind_by_name($stmt, ":p_idMascota", $p_idMascota,-1,SQLT_INT);
        oci_bind_by_name($stmt, ":p_nombre", $p_nombre, 200);
        oci_bind_by_name($stmt, ":p_descripcion", $p_descripcion, 400);
        oci_bind_by_name($stmt, ":p_imagen", $p_imagen, 400);
        oci_bind_by_name($stmt, ":p_idTipoMascota", $p_idTipoMascota, 200);
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        $mascota = array();
        if ($p_resultado == 0) {
            $mascota = array(
                'idMascota' => $p_idMascota,
                'nombre' => $p_nombre,
                'descripcion' => $p_descripcion,
                'imagen' => $p_imagen,
                'idTipoMascota' => $p_idTipoMascota
            );
        }

        return array('datos' => $mascota, 'resultado' => $p_resultado);
    }

     public function getServicios()
    {
        $stmt = oci_parse($this->db, "BEGIN P_CITA.getServicios(:p_cursor, :p_resultado); END;");
        $p_cursor = oci_new_cursor($this->db);
        oci_bind_by_name($stmt, ":p_cursor", $p_cursor, -1, OCI_B_CURSOR);

        $p_resultado = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        $servicios = array();

        if ($p_resultado == 0) {
            oci_execute($p_cursor);
            while ($row = oci_fetch_assoc($p_cursor)) {
                array_push($servicios, $row);
            }
        }

        oci_free_statement($p_cursor);
        oci_free_statement($stmt);

        return array('datos' => $servicios, 'resultado' => $p_resultado);

    }

     public function getEstados()
    {
        $stmt = oci_parse($this->db, "BEGIN P_CITA.getEstados(:p_cursor, :p_resultado); END;");
        $p_cursor = oci_new_cursor($this->db);
        oci_bind_by_name($stmt, ":p_cursor", $p_cursor, -1, OCI_B_CURSOR);

        $p_resultado = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        $estados = array();

        if ($p_resultado == 0) {
            oci_execute($p_cursor);
            while ($row = oci_fetch_assoc($p_cursor)) {
                array_push($estados, $row);
            }
        }

        oci_free_statement($p_cursor);
        oci_free_statement($stmt);

        return array('datos' => $estados, 'resultado' => $p_resultado);
    }
 
     public function getMedicosPorServicio($idServicio)
    {
        $stmt = oci_parse($this->db,"BEGIN P_CITA.getMedicosPorServicio(:p_idServicio, :p_idColaborador, :p_NOMBRE, :p_apellido1, :p_apellido2, :p_resultado);END;");
    
        oci_bind_by_name($stmt, ":p_idServicio", $idServicio);
        $p_idColaborador = 0;
        $p_nombre = '';
        $p_apellido1 = '';
        $p_apellido2 = '';
        $p_resultado =0;

        oci_bind_by_name($stmt, ":p_idColaborador", $p_idColaborador,-1,SQLT_INT);
        oci_bind_by_name($stmt, ":p_nombre", $p_nombre, 200);
        oci_bind_by_name($stmt, ":p_apellido1", $p_apellido1, 50);
        oci_bind_by_name($stmt, ":p_apellido2", $p_apellido2, 50);
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        $medicos = array();
        if ($p_resultado == 0) {
            $medicos = array(
                'idColaborador' => $p_idColaborador,
                'nombre' => $p_nombre,
                'apellido1' => $p_apellido1,
                'apellido2' => $p_apellido2
            );
        }

        return array('datos' => $medicos, 'resultado' => $p_resultado);
    }

    public function insertCita($idCliente, $idMascota, $idServicio, $fecha, $idHorario, $idEstado)
    {
        $stmt = oci_parse($this->db, "BEGIN P_CITA.insertCita(:p_idCliente, :p_idMascota, :p_idServicio, TO_DATE(:p_fecha, 'YYYY-MM-DD'), :p_idHorario, :p_idEstado, :p_resultado); END;");

        $resultado = null;

        oci_bind_by_name($stmt, ":p_idCliente", $idCliente);
        oci_bind_by_name($stmt, ":p_idMascota", $idMascota);
        oci_bind_by_name($stmt, ":p_idServicio", $idServicio);
        oci_bind_by_name($stmt, ":p_fecha", $fecha);
        oci_bind_by_name($stmt, ":p_idHorario", $idHorario);
        oci_bind_by_name($stmt, ":p_idEstado", $idEstado);
        oci_bind_by_name($stmt, ":p_resultado", $resultado, -1, SQLT_INT);

        oci_execute($stmt);

        oci_free_statement($stmt);

        return $resultado;
    }


    public function updateCita($idCita, $idCliente, $idMascota, $idServicio, $fecha, $idHorario, $idEstado)
    {
        $stmt = oci_parse($this->db, "BEGIN P_CITA.updateCita(:p_idCita, :p_idCliente, :p_idMascota, :p_idServicio, :p_fecha :p_idHorario, :p_idEstado, :p_resultado); END;");
        
        oci_bind_by_name($stmt, ":p_idCita", $idCita);
        oci_bind_by_name($stmt, ":p_idCliente", $idCliente);
        oci_bind_by_name($stmt, ":p_idMascota", $idMascota);
        oci_bind_by_name($stmt, ":p_idServicio", $idServicio);
        oci_bind_by_name($stmt, ":p_fecha", $fecha);
        oci_bind_by_name($stmt, ":p_idHorario", $idHorario);
        oci_bind_by_name($stmt, ":p_idEstado", $idEstado);

        $p_resultado = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        return $p_resultado;
    }

    public function updateEstadoCita($idCita, $idEstado)    
    {
        $stmt = oci_parse($this->db, "BEGIN P_CITA.updateEstadoCita(:p_idCita, :p_idEstado, :p_resultado); END;");

        $p_resultado = null;
        oci_bind_by_name($stmt, ":p_idCita", $idCita);
        oci_bind_by_name($stmt, ":p_idEstado", $idEstado);
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        $p_resultado = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        return $p_resultado;
    }

    public function insertAsignacionCita($idCita, $idColaborador)
    {      
        $stmt = oci_parse($this->db, "BEGIN P_CITA.insertAsignacionCita(:p_idCita, :p_idColaborador, :p_resultado); END;");
        
        oci_bind_by_name($stmt, ":p_idCita", $idCita);
        oci_bind_by_name($stmt, ":p_idColaborador", $idColaborador);

        $p_resultado = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        return $p_resultado;
    }

    public function updateAsignacionCita($idAsignacionCita, $idCita, $idColaborador)
    {
        $stmt = oci_parse($this->db, "BEGIN P_CITA.updateAsignacionCita(:p_idAsignacionCita,:p_idCita, :p_idColaborador, :p_resultado); END;");
        
        oci_bind_by_name($stmt, ":p_idAsignacionCita", $idAsignacionCita);
        oci_bind_by_name($stmt, ":p_idCita", $idCita);
        oci_bind_by_name($stmt, ":p_idColaborador", $idColaborador);

        $p_resultado = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        return $p_resultado;
    }

    public function insertHistorialMedico($detalleCita, $costo, $idMascota, $idColaborador, $idCita)
    {        
        $stmt = oci_parse($this->db, "BEGIN P_CITA.insertHistorialMedico(:p_detalleCita, :p_costo, :p_idMascota, :p_idColaborador, :p_idCita, :p_resultado); END;");
        
        oci_bind_by_name($stmt, ":p_detalleCita", $detalleCita);
        oci_bind_by_name($stmt, ":p_costo", $costo);
        oci_bind_by_name($stmt, ":p_idMascota", $idMascota);
        oci_bind_by_name($stmt, ":p_idColaborador", $idColaborador);
        oci_bind_by_name($stmt, ":p_idCita", $idCita);

        $p_resultado = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        return $p_resultado;
    }
    

     public function getLastInsertId()
    {
        return $this->db->lastInsertId();
     } 
 
     public function getDetalleCitaMedico($idColaborador)
{
    $conn = $this->db;

    // Preparar la llamada al procedimiento almacenado
    $stmt = oci_parse($conn, "BEGIN P_CITA.getDetalleCitaMedico(:p_idColaborador, :p_resultado, :p_cursor); END;");

    // Vincular los parámetros
    $p_resultado = null;
    oci_bind_by_name($stmt, ":p_idColaborador", $idColaborador);
    $p_cursor = oci_new_cursor($conn);
    oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);
    oci_bind_by_name($stmt, ":p_cursor", $p_cursor, -1, OCI_B_CURSOR);

    // Ejecutar el procedimiento almacenado
    oci_execute($stmt);

    // Recuperar los resultados del cursor
    $detalleCita = [];
    if ($p_resultado == 0) {
        oci_execute($p_cursor);
        while ($row = oci_fetch_assoc($p_cursor)) {
            $detalleCita[] = $row;
        }
    }

    // Liberar recursos
    oci_free_statement($p_cursor);
    oci_free_statement($stmt);

    // Devolver los resultados
    return ['datos' => $detalleCita, 'resultado' => $p_resultado];
}

public function getAllDetalleCitaMedico()
{
    $conn = $this->db;

    // Preparar la llamada al procedimiento almacenado
    $stmt = oci_parse($conn, "BEGIN P_CITA.getAllDetalleCitaMedico(:p_resultado, :p_citas); END;");

    // Vincular los parámetros
    $p_resultado = null;
    $p_citas = oci_new_cursor($conn);
    oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);
    oci_bind_by_name($stmt, ":p_citas", $p_citas, -1, OCI_B_CURSOR);

    // Ejecutar el procedimiento almacenado
    oci_execute($stmt);

    // Recuperar los resultados del cursor
    $detalleCitas = [];
    if ($p_resultado == 0) {
        oci_execute($p_citas);
        while ($row = oci_fetch_assoc($p_citas)) {
            $detalleCitas[] = $row;
        }
    }

    // Liberar recursos
    oci_free_statement($p_citas);
    oci_free_statement($stmt);

    // Devolver los resultados
    return ['datos' => $detalleCitas, 'resultado' => $p_resultado];
}


    public function getCitaMedica($idCita)
    {
        $conn = $this->db;
    
        // Preparar la llamada al procedimiento almacenado
        $stmt = oci_parse($conn, "BEGIN P_CITA.getCitaMedica(:p_idCita, :p_resultado, :p_cursor); END;");
    
        // Vincular los parámetros
        $p_resultado = null;
        oci_bind_by_name($stmt, ":p_idCita", $idCita);
        $p_cursor = oci_new_cursor($conn);
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);
        oci_bind_by_name($stmt, ":p_cursor", $p_cursor, -1, OCI_B_CURSOR);
    
        // Ejecutar el procedimiento almacenado
        oci_execute($stmt);
    
        // Recuperar los resultados del cursor
        $citaMedica = [];
        if ($p_resultado == 0) {
            oci_execute($p_cursor);
            while ($row = oci_fetch_assoc($p_cursor)) {
                $citaMedica[] = $row;
            }
        }
    
        // Liberar recursos
        oci_free_statement($p_cursor);
        oci_free_statement($stmt);
    
        // Devolver los resultados
        return ['datos' => $citaMedica, 'resultado' => $p_resultado];
    }

    public function getHistorialMedico($idCita)
{
    $conn = $this->db;

    // Preparar la llamada al procedimiento almacenado
    $stmt = oci_parse($conn, "BEGIN P_CITA.getHistorialMedico(:p_idCita, :p_resultado, :p_cursor); END;");

    // Vincular los parámetros
    $p_resultado = null;
    oci_bind_by_name($stmt, ":p_idCita", $idCita);
    $p_cursor = oci_new_cursor($conn);
    oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);
    oci_bind_by_name($stmt, ":p_cursor", $p_cursor, -1, OCI_B_CURSOR);

    // Ejecutar el procedimiento almacenado
    oci_execute($stmt);

    // Recuperar los resultados del cursor
    $historialMedico = [];
    if ($p_resultado == 0) {
        oci_execute($p_cursor);
        while ($row = oci_fetch_assoc($p_cursor)) {
            $historialMedico[] = $row;
        }
    }

    // Liberar recursos
    oci_free_statement($p_cursor);
    oci_free_statement($stmt);

    // Devolver los resultados
    return ['datos' => $historialMedico, 'resultado' => $p_resultado];
}

public function getAllHistorialMedico()
{
    $conn = $this->db;

    // Preparar la llamada al procedimiento almacenado
    $stmt = oci_parse($conn, "BEGIN P_CITA.getAllHistorialMedico(:p_resultado, :p_cursor); END;");

    // Vincular los parámetros
    $p_resultado = null;
    $p_cursor = oci_new_cursor($conn);
    oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);
    oci_bind_by_name($stmt, ":p_cursor", $p_cursor, -1, OCI_B_CURSOR);

    // Ejecutar el procedimiento almacenado
    oci_execute($stmt);

    // Recuperar los resultados del cursor
    $allHistorialMedico = [];
    if ($p_resultado == 0) {
        oci_execute($p_cursor);
        while ($row = oci_fetch_assoc($p_cursor)) {
            $allHistorialMedico[] = $row;
        }
    }

    // Liberar recursos
    oci_free_statement($p_cursor);
    oci_free_statement($stmt);

    // Devolver los resultados
    return ['datos' => $allHistorialMedico, 'resultado' => $p_resultado];
}
public function getCitasCliente($idCliente)
{
    $conn = $this->db;

    // Preparar la llamada al procedimiento almacenado
    $stmt = oci_parse($conn, "BEGIN P_CITA.getCitasCliente(:p_idCliente, :p_resultado, :p_citasCliente); END;");

    // Vincular los parámetros
    $p_resultado = null;
    $p_citasCliente = oci_new_cursor($conn);
    oci_bind_by_name($stmt, ":p_idCliente", $idCliente);
    oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);
    oci_bind_by_name($stmt, ":p_citasCliente", $p_citasCliente, -1, OCI_B_CURSOR);

    // Ejecutar el procedimiento almacenado
    oci_execute($stmt);

    // Recuperar los resultados del cursor
    $citasCliente = [];
    if ($p_resultado == 0) {
        oci_execute($p_citasCliente);
        while ($row = oci_fetch_assoc($p_citasCliente)) {
            $citasCliente[] = $row;
        }
    }

    // Liberar recursos
    oci_free_statement($p_citasCliente);
    oci_free_statement($stmt);

    // Devolver los resultados
    return ['datos' => $citasCliente, 'resultado' => $p_resultado];
}

        public function getCitasPorEstado($idEstado)
        {
            $conn = $this->db;
        
            // Preparar la llamada al procedimiento almacenado
            $stmt = oci_parse($conn, "BEGIN P_CITA.getCitasPorEstado(:p_idEstado, :p_resultado, :p_cursor); END;");
        
            // Vincular los parámetros
            $p_resultado = null;
            $p_cursor = oci_new_cursor($conn);
            oci_bind_by_name($stmt, ":p_idEstado", $idEstado);
            oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);
            oci_bind_by_name($stmt, ":p_cursor", $p_cursor, -1, OCI_B_CURSOR);
        
            // Ejecutar el procedimiento almacenado
            oci_execute($stmt);
        
            // Recuperar los resultados del cursor
            $citasPorEstado = [];
            if ($p_resultado == 0) {
                oci_execute($p_cursor);
                while ($row = oci_fetch_assoc($p_cursor)) {
                    $citasPorEstado[] = $row;
                }
            }
        
            // Liberar recursos
            oci_free_statement($p_cursor);
            oci_free_statement($stmt);
        
            // Devolver los resultados
            return ['datos' => $citasPorEstado, 'resultado' => $p_resultado];
        }


 public function getCitasPorEstadoYColaborador($idEstado, $idColaborador)
{
    $conn = $this->db;

    // Preparar la llamada al procedimiento almacenado
    $stmt = oci_parse($conn, "BEGIN P_CITA.getCitasPorEstadoYColaborador(:p_idEstado, :p_idColaborador, :p_resultado, :p_cursor); END;");

    // Vincular los parámetros
     $p_resultado = null;
    $p_cursor = oci_new_cursor($conn);
    oci_bind_by_name($stmt, ":p_idEstado", $idEstado);
    oci_bind_by_name($stmt, ":p_idColaborador", $idColaborador);
    oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);
    oci_bind_by_name($stmt, ":p_cursor", $p_cursor, -1, OCI_B_CURSOR);

    // Ejecutar el procedimiento almacenado
    oci_execute($stmt);

    // Recuperar los resultados del cursor
    $citasPorEstadoYColaborador = [];
    if ($p_resultado == 0) {
        oci_execute($p_cursor);
        while ($row = oci_fetch_assoc($p_cursor)) {
            $citasPorEstadoYColaborador[] = $row;
        }
    }

    // Liberar recursos
    oci_free_statement($p_cursor);
    oci_free_statement($stmt);

    // Devolver los resultados
    return ['datos' => $citasPorEstadoYColaborador, 'resultado' => $p_resultado];
}

    public function getHorariosDisponibles($fecha, $medicoId)
    {
        // Preparar la sentencia SQL con el procedimiento almacenado
        $stmt = oci_parse($this->db, "BEGIN P_CITA.GetHorariosDisponibles(:p_fecha, :p_medicoId, :p_cursor, :p_resultado); END;");

        // Crear cursores y enlazar parámetros
        $p_cursor = oci_new_cursor($this->db);
        oci_bind_by_name($stmt, ":p_fecha", $fecha, 200);
        oci_bind_by_name($stmt, ":p_medicoId", $medicoId, SQLT_INT);
        oci_bind_by_name($stmt, ":p_cursor", $p_cursor, -1, OCI_B_CURSOR);
        $p_resultado = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        // Ejecutar la sentencia SQL
        oci_execute($stmt);

        $horariosDisponibles = array();
        if ($p_resultado == 0) {
            oci_execute($p_cursor);
            while ($row = oci_fetch_assoc($p_cursor)) {
                $horariosDisponibles[] = $row;
            }
        }

        // Liberar recursos
        oci_free_statement($p_cursor);
        oci_free_statement($stmt);

        return array('datos' => $horariosDisponibles, 'resultado' => $p_resultado);
    }

    public function getHorariosCitas()
    {
        // Preparar la llamada al procedimiento almacenado
        $stmt = oci_parse($this->db, "BEGIN P_CITA.GetHorariosCitas(:p_cursor, :p_resultado); END;");

        // Declarar parámetros de salida
        $p_cursor = oci_new_cursor($this->db);
        oci_bind_by_name($stmt, ":p_cursor", $p_cursor, -1, OCI_B_CURSOR);

        $p_resultado = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        // Ejecutar el procedimiento almacenado
        oci_execute($stmt);

        $horariosCitas = array();
        if ($p_resultado == 0) {
            // Recuperar los resultados del cursor
            oci_execute($p_cursor);
            while ($row = oci_fetch_assoc($p_cursor)) {
                array_push($horariosCitas, $row);
            }
        }

        // Liberar recursos
        oci_free_statement($p_cursor);
        oci_free_statement($stmt);

        // Devolver resultados
        return array('datos' => $horariosCitas, 'resultado' => $p_resultado);
    }


}