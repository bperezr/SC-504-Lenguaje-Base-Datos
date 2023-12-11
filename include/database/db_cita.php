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
        $stmt = oci_parse($this->db, "BEGIN P_CITA.insertCita(:p_idCliente, :p_idMascota, :p_idServicio, :p_fecha :p_idHorario, p_idEstado, :p_resultado); END;");
        
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
        $stmt = oci_parse($this->db, "BEGIN P_CITA.updateEstadoCita(:p_idCita, :p_idEstado); END; ");

        oci_bind_by_name($stmt, ":p_idCita", $idCita);
        oci_bind_by_name($stmt, ":p_idEstado", $idEstado);

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

        $stmt = oci_parse($conn, "BEGIN P_CITAS.getDetalleCitaMedico(:p_idColaborador, :p_cursor, :p_resultado); END;");

        oci_bind_by_name($stmt, ":p_idColaborador", $idColaborador);
        $p_cursor = oci_new_cursor($conn);
        oci_bind_by_name($stmt, ":p_cursor", $p_cursor, -1, OCI_B_CURSOR);
        $p_resultado = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        $detalleCita = [];
        if ($p_resultado == 0) {
            oci_execute($p_cursor);
            while ($row = oci_fetch_assoc($p_cursor)) {
                array_push($detalleCita, $row);
            }
        }

        oci_free_statement($p_cursor);
        oci_free_statement($stmt);

        return ['datos' => $detalleCita, 'resultado' => $p_resultado];
    }

    public function getAllDetalleCitaMedico()
    {
        $query = "select ac.idcita,ac.idColaborador,m.idMascota,col.nombre as nombreMedico, m.nombre as nombreMascota, m.descripcion, cli.nombre, 
      cli.apellido1, cli.apellido2, cli.correo, cli.telefono, s.servicio, c.fecha, c.idestado, hc.horaInicio, hc.horaFin, e.estado  
      from asignacioncitas AS ac 
      join citas as c on ac.idcita = c.idcita
      join colaborador as col on ac.idColaborador = col.idColaborador
      join mascota as m on c.idMascota = m.idmascota 
      join cliente as cli on c.idCliente = cli.idCliente
      join servicios as s on c.idServicio = s.idServicio
      join horariocitas as hc on c.idHorario = hc.idHorario
      join estado as e on c.idestado = e.idestado  order by c.fecha desc";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function getCitaMedica($idCita)
    {
        $query = "select ac.idcita,ac.idColaborador,m.idMascota,col.nombre as nombreMedico, m.nombre as nombreMascota, m.descripcion, cli.nombre,
         cli.apellido1, cli.apellido2, cli.correo, cli.telefono, s.servicio, c.fecha, c.idestado, hc.horaInicio, hc.horaFin, e.estado  
        from asignacioncitas AS ac 
        join citas as c on ac.idcita = c.idcita
        join colaborador as col on ac.idColaborador = col.idColaborador
        join mascota as m on c.idMascota = m.idmascota 
        join cliente as cli on c.idCliente = cli.idCliente
        join servicios as s on c.idServicio = s.idServicio
        join horariocitas as hc on c.idHorario = hc.idHorario
        join estado as e on c.idestado = e.idestado WHERE ac.idcita  = :idCita";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idCita', $idCita, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }


    public function getHistorialMedico($idCita)
    {
        $query = "SELECT h.*, c.fecha, s.servicio, m.nombre as nombreMascota, c.idestado , c.idCliente, cli.nombre, cli.apellido1,cli.apellido2, e.estado
    from historialmedico as h 
    JOIN  mascota as m on h.idMascota = m.idmascota 
    join citas as c on h.idCita = c.idcita
    join cliente as cli on c.idCliente = cli.idCliente
    join estado as e on c.idestado = e.idestado
    join servicios as s on c.idServicio = s.idServicio WHERE h.idcita  = :idCita";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idCita', $idCita, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllHistorialMedico($idColaborador)
    {
        $query = "SELECT h.*, c.fecha, s.servicio, m.nombre as nombreMascota, c.idestado , c.idCliente, cli.nombre, cli.apellido1,cli.apellido2, e.estado
    from historialmedico as h 
    JOIN  mascota as m on h.idMascota = m.idmascota 
    join citas as c on h.idCita = c.idcita
    join cliente as cli on c.idCliente = cli.idCliente
    join estado as e on c.idestado = e.idestado
    join servicios as s on c.idServicio = s.idServicio WHERE h.idColaborador  = :idColaborador";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idColaborador', $idColaborador, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getCitasCliente($idCliente)
    {
        $query = "SELECT c.idCita, m.nombre AS nombreMascota, s.servicio AS nombreServicio, c.fecha, h.horaInicio, h.horaFin, co.nombre AS nombreMedico, e.estado AS nombreEstado,  e.estado AS idEstado
                FROM citas c
                JOIN mascota m ON c.idMascota = m.idMascota
                JOIN servicios s ON c.idServicio = s.idServicio
                JOIN horariocitas h ON c.idHorario = h.idHorario
                JOIN asignacioncitas ac ON c.idCita = ac.idCita
                JOIN colaborador co ON ac.idColaborador = co.idColaborador
                JOIN estado e ON c.idestado = e.idestado
                WHERE c.idCliente = :idCliente";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":idCliente", $idCliente, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCitasPorEstado($idEstado)
    {
        $query = "SELECT c.idCita, m.nombre AS nombreMascota, s.servicio AS nombreServicio, c.fecha, h.horaInicio, h.horaFin, co.nombre AS nombreMedico, e.estado AS nombreEstado
                    FROM citas c
                    JOIN mascota m ON c.idMascota = m.idMascota
                    JOIN servicios s ON c.idServicio = s.idServicio
                    JOIN horariocitas h ON c.idHorario = h.idHorario
                    JOIN asignacioncitas ac ON c.idCita = ac.idCita
                    JOIN colaborador co ON ac.idColaborador = co.idColaborador
                    JOIN estado e ON c.idestado = e.idestado
                    WHERE c.idestado = :idEstado";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":idEstado", $idEstado, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    function getCitasPorEstadoYColaborador($idEstado, $idColaborador)
    {
        $query = "SELECT c.idCita, m.nombre AS nombreMascota, s.servicio AS nombreServicio, c.fecha, h.horaInicio, h.horaFin, e.estado AS nombreEstado
            FROM citas c
            JOIN mascota m ON c.idMascota = m.idMascota
            JOIN servicios s ON c.idServicio = s.idServicio
            JOIN horariocitas h ON c.idHorario = h.idHorario
            JOIN asignacioncitas ac ON c.idCita = ac.idcita
            JOIN colaborador co ON ac.idColaborador = co.idColaborador
            JOIN estado e ON c.idestado = e.idestado
            WHERE c.idestado = :idEstado AND co.idColaborador = :idColaborador";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":idEstado", $idEstado, PDO::PARAM_INT);
        $stmt->bindParam(":idColaborador", $idColaborador, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}