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


    /*  public function getMascotasCliente($idCliente)
    {
         $sql = "SELECT * from mascota where idCliente = :idCliente";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':idCliente', $idCliente, PDO::PARAM_INT);
        $stmt->execute();
        $mascotas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $mascotas;
     } */

    /* public function getServicios()
    {
        $query = "SELECT * FROM servicios";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } */

    /* public function getEstados()
    {
        $query = "SELECT * FROM estado";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
 */
    /* public function getMedicosPorServicio($idServicio)
    {
        $query = "SELECT c.idColaborador, c.nombre, c.apellido1, c.apellido2
            FROM colaborador c
            INNER JOIN colaboradorservicio cs ON c.idColaborador = cs.idColaborador
            WHERE cs.idServicio = :idServicio";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idServicio', $idServicio, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } */

    public function insertCita($idCliente, $idMascota, $idServicio, $fecha, $idHorario, $idEstado)
    {
        $stmt = oci_parse($this->db, "BEGIN P_CITA.insertCita(:p_idCliente, :p_idMascota, :p_idServicio, :p_fecha, :p_idHorario, :p_idEstado, :p_resultado); END;");

        oci_bind_by_name($stmt, ":p_idCliente", $idCliente);
        oci_bind_by_name($stmt, ":p_idMascota", $idMascota);
        oci_bind_by_name($stmt, ":p_idServicio", $idServicio);
        oci_bind_by_name($stmt, ":p_fecha", $fecha);
        oci_bind_by_name($stmt, ":p_idHorario", $idHorario);
        oci_bind_by_name($stmt, ":p_idEstado", $idEstado);

        // Declarar variable para el parámetro OUT
        $p_resultado = null;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        return $p_resultado;
    }

    /* public function updateCita($idCita, $idCliente, $idMascota, $idServicio, $fecha, $idHorario)
    {
        $query = "UPDATE citas SET idCliente = :idCliente, idMascota = :idMascota, idServicio = :idServicio, fecha = :fecha, idHorario = :idHorario WHERE idCita = :idCita";
        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':idCita', $idCita, PDO::PARAM_INT);
        $stmt->bindValue(':idCliente', $idCliente, PDO::PARAM_INT);
        $stmt->bindValue(':idMascota', $idMascota, PDO::PARAM_INT);
        $stmt->bindValue(':idServicio', $idServicio, PDO::PARAM_INT);
        $stmt->bindValue(':fecha', $fecha, PDO::PARAM_STR);
        $stmt->bindValue(':idHorario', $idHorario, PDO::PARAM_INT);

        return $stmt->execute();
    } */

    /* public function updateEstadoCita($idCita, $idEstado)
    {
        $query = "UPDATE citas SET idestado = :idEstado WHERE idCita = :idCita";
        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':idCita', $idCita, PDO::PARAM_INT);
        $stmt->bindValue(':idEstado', $idEstado, PDO::PARAM_INT);

        return $stmt->execute();
    } */

    /* public function insertAsignacionCita($idCita, $idColaborador)
    {
        $query = "INSERT INTO asignacioncitas (idcita, idColaborador) VALUES (:idCita, :idColaborador)";
        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':idCita', $idCita, PDO::PARAM_INT);
        $stmt->bindValue(':idColaborador', $idColaborador, PDO::PARAM_INT);

        return $stmt->execute();
    } */


    /* public function insertHistorialMedico($detalleCita, $costo, $idMascota, $idColaborador, $idCita)
    {
        $query = "INSERT into historialmedico (detalleCita,costo,idMascota,idColaborador,idCita) VALUES (:detalleCita, :costo, :idMascota, :idColaborador, :idCita)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':detalleCita', $detalleCita, PDO::PARAM_STR);
        $stmt->bindValue(':costo', $costo, PDO::PARAM_INT);
        $stmt->bindValue(':idMascota', $idMascota, PDO::PARAM_INT);
        $stmt->bindValue(':idColaborador', $idColaborador, PDO::PARAM_INT);
        $stmt->bindValue(':idCita', $idCita, PDO::PARAM_INT);

        return $stmt->execute();
    } */

    /* public function updateAsignacionCita($idasignacionCita, $idCita, $idColaborador)
    {
        $query = "UPDATE asignacioncitas SET idcita = :idCita, idColaborador = :idColaborador WHERE idasignacionCita = :idasignacionCita";
        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':idasignacionCita', $idasignacionCita, PDO::PARAM_INT);
        $stmt->bindValue(':idCita', $idCita, PDO::PARAM_INT);
        $stmt->bindValue(':idColaborador', $idColaborador, PDO::PARAM_INT);

        return $stmt->execute();
    } */

    /*  public function getLastInsertId()
    {
        return $this->db->lastInsertId();
     } */

    /* public function getDetalleCitaMedico($idColaborador)
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
    join estado as e on c.idestado = e.idestado WHERE ac.idColaborador = :idColaborador order by c.fecha desc";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idColaborador', $idColaborador, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } */

    /* public function getAllDetalleCitaMedico()
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

    } */

    /*  public function getCitaMedica($idCita)
    {
        $query = "select ac.idcita,ac.idColaborador,m.idMascota,col.nombre as nombreMedico, m.nombre as nombreMascota, m.descripcion, cli.nombre,
        cli.apellido1, cli.apellido2, cli.correo, cli.telefono, s.servicio, c.fecha, c.idestado, hc.horaInicio, hc.horaFin, e.estado
        from asignacioncitas AS ac
        join citas as c on ac.idcita = c.idcita
        join colaborador as col on ac.idColaborador = col.idColaborador
        oin mascota as m on c.idMascota = m.idmascota
        join cliente as cli on c.idCliente = cli.idCliente
        join servicios as s on c.idServicio = s.idServicio
        join horariocitas as hc on c.idHorario = hc.idHorario
        join estado as e on c.idestado = e.idestado WHERE ac.idcita  = :idCita";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idCita', $idCita, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

     } */


    /* public function getHistorialMedico($idCita)
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
    } */

    /*     public function getAllHistorialMedico($idColaborador)
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
        } */
    /*     public function getCitasCliente($idCliente)
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
        } */

    /*     public function getCitasPorEstado($idEstado)
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
        } */


    /*     function getCitasPorEstadoYColaborador($idEstado, $idColaborador)
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
        } */

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