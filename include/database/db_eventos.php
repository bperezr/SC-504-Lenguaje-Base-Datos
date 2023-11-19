<?php
require_once 'db_config.php';

class Evento
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


    // Función para obtener una evento por su ID
    public function getEvento($id)
    {
        $conn = $this->db;
        $stmt = oci_parse($conn, "BEGIN getEvento(:p_idEvento, :p_Lugar, :p_Fecha, :p_HoraInicio, :p_HoraFin, :p_Descripcion, :p_Imagen, :p_IdProvincia, :p_IdCanton, :p_IdDistrito, :p_NombreEvento, :p_resultado); END;");

        oci_bind_by_name($stmt, ":p_idEvento", $id);

        $p_Lugar = "";
        $p_Fecha = "";
        $p_HoraInicio = "";
        $p_HoraFin = "";
        $p_Descripcion = "";
        $p_Imagen = "";
        $p_IdProvincia = "";
        $p_IdCanton = "";
        $p_IdDistrito = "";
        $p_NombreEvento = "";
        $p_resultado = 0;

        oci_bind_by_name($stmt, ":p_Lugar", $p_Lugar, 400);
        oci_bind_by_name($stmt, ":p_Fecha", $p_Fecha, 100);
        oci_bind_by_name($stmt, ":p_HoraInicio", $p_HoraInicio, 100);
        oci_bind_by_name($stmt, ":p_HoraFin", $p_HoraFin, 100);
        oci_bind_by_name($stmt, ":p_Descripcion", $p_Descripcion, 4000);
        oci_bind_by_name($stmt, ":p_Imagen", $p_Imagen, 400);
        oci_bind_by_name($stmt, ":p_IdProvincia", $p_IdProvincia, -1, SQLT_INT);
        oci_bind_by_name($stmt, ":p_IdCanton", $p_IdCanton, -1, SQLT_INT);
        oci_bind_by_name($stmt, ":p_IdDistrito", $p_IdDistrito, -1, SQLT_INT);
        oci_bind_by_name($stmt, ":p_NombreEvento", $p_NombreEvento, 400);
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        $evento = null;
        if ($p_resultado == 1) {
            $evento = array(
                'idEvento' => $id,
                'lugar' => $p_Lugar,
                'fecha' => $p_Fecha,
                'horaInicio' => $p_HoraInicio,
                'horaFin' => $p_HoraFin,
                'descripcion' => $p_Descripcion,
                'imagen' => $p_Imagen,
                'idProvincia' => $p_IdProvincia,
                'idCanton' => $p_IdCanton,
                'idDistrito' => $p_IdDistrito,
                'nombreEvento' => $p_NombreEvento
            );
        }

        return array('datos' => $evento, 'resultado' => $p_resultado);
    }


    // Función para obtener todos los eventos
    public function getEventos()
    {
        $eventos = array();
        $conn = $this->db;

        $stmt = oci_parse($conn, "BEGIN getEventos(:p_cursor, :p_resultado); END;");
        $p_cursor = oci_new_cursor($conn);
        oci_bind_by_name($stmt, ":p_cursor", $p_cursor, -1, OCI_B_CURSOR);
        $p_resultado = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        if ($p_resultado == 1) {
            oci_execute($p_cursor);
            while ($row = oci_fetch_assoc($p_cursor)) {
                array_push($eventos, $row);
            }
        }

        oci_free_statement($p_cursor);
        oci_free_statement($stmt);

        return array('datos' => $eventos, 'resultado' => $p_resultado);
    }



    // Función para insertar un nuevo evento
    public function insertEvento($lugar, $fecha, $horaInicio, $horaFin, $descripcion, $imagen, $idProvincia, $idCanton, $idDistrito, $nombreEvento)
    {
        $conn = $this->db;

        $stmt = oci_parse($conn, "BEGIN insertEvento(:p_Lugar, :p_Fecha, :p_HoraInicio, :p_HoraFin, :p_Descripcion, :p_Imagen, :p_IdProvincia, :p_IdCanton, :p_IdDistrito, :p_NombreEvento, :p_resultado); END;");

        oci_bind_by_name($stmt, ":p_Lugar", $lugar);
        oci_bind_by_name($stmt, ":p_Fecha", $fecha);
        oci_bind_by_name($stmt, ":p_HoraInicio", $horaInicio);
        oci_bind_by_name($stmt, ":p_HoraFin", $horaFin);
        oci_bind_by_name($stmt, ":p_Descripcion", $descripcion);
        oci_bind_by_name($stmt, ":p_Imagen", $imagen);
        oci_bind_by_name($stmt, ":p_IdProvincia", $idProvincia);
        oci_bind_by_name($stmt, ":p_IdCanton", $idCanton);
        oci_bind_by_name($stmt, ":p_IdDistrito", $idDistrito);
        oci_bind_by_name($stmt, ":p_NombreEvento", $nombreEvento);

        $p_resultado = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        return $p_resultado;
    }



    // Función para actualizar un evento
    public function updateEvento($id, $lugar, $fecha, $horaInicio, $horaFin, $descripcion, $imagen, $idProvincia, $idCanton, $idDistrito, $nombreEvento)
    {
        $conn = $this->db;

        $stmt = oci_parse($conn, "BEGIN updateEvento(:p_idEvento, :p_Lugar, :p_Fecha, :p_HoraInicio, :p_HoraFin, :p_Descripcion, :p_Imagen, :p_IdProvincia, :p_IdCanton, :p_IdDistrito, :p_NombreEvento, :p_resultado); END;");

        oci_bind_by_name($stmt, ":p_idEvento", $id);
        oci_bind_by_name($stmt, ":p_Lugar", $lugar);
        oci_bind_by_name($stmt, ":p_Fecha", $fecha);
        oci_bind_by_name($stmt, ":p_HoraInicio", $horaInicio);
        oci_bind_by_name($stmt, ":p_HoraFin", $horaFin);
        oci_bind_by_name($stmt, ":p_Descripcion", $descripcion);
        oci_bind_by_name($stmt, ":p_Imagen", $imagen);
        oci_bind_by_name($stmt, ":p_IdProvincia", $idProvincia);
        oci_bind_by_name($stmt, ":p_IdCanton", $idCanton);
        oci_bind_by_name($stmt, ":p_IdDistrito", $idDistrito);
        oci_bind_by_name($stmt, ":p_NombreEvento", $nombreEvento);

        $p_resultado = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        return $p_resultado;
    }

    // Función para eliminar una especialidad por su ID
    public function deleteEvento($id)
    {
        $conn = $this->db;

        $stmt = oci_parse($conn, "BEGIN deleteEvento(:p_idEvento, :p_resultado); END;");

        oci_bind_by_name($stmt, ":p_idEvento", $id);
        $p_resultado = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        return $p_resultado;
    }


    //Función para buascar especialidades
    public function buscarEventos($searchTerm)
    {
        $conn = $this->db;

        $stmt = oci_parse($conn, "BEGIN buscarEventos(:p_searchTerm, :p_cursor, :p_resultado, :p_numFilas); END;");

        oci_bind_by_name($stmt, ":p_searchTerm", $searchTerm);
        $p_cursor = oci_new_cursor($conn);
        oci_bind_by_name($stmt, ":p_cursor", $p_cursor, -1, OCI_B_CURSOR);
        $p_resultado = 0;
        $p_numFilas = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);
        oci_bind_by_name($stmt, ":p_numFilas", $p_numFilas, -1, SQLT_INT);

        oci_execute($stmt);

        $eventos = [];
        if ($p_resultado == 1) {
            oci_execute($p_cursor);
            while ($row = oci_fetch_assoc($p_cursor)) {
                array_push($eventos, $row);
            }
        }

        oci_free_statement($p_cursor);
        oci_free_statement($stmt);

        return ['datos' => $eventos, 'numFilas' => $p_numFilas];
    }

    public function uploadImagen($imagen)
    {
        $carpetaImagenes = '../img/images_events/';
        $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
        move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);
        return $nombreImagen;
    }

    public function deleteImagen($nombreImagen)
    {
        $rutaImagen = "../img/images_events/" . $nombreImagen;
        if (file_exists($rutaImagen)) {
            unlink($rutaImagen);
            return true;
        }
        return false;
    }

}

?>