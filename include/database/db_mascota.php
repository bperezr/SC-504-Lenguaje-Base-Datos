<?php
require_once 'db_config.php';

class Mascota
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

    public function getMascota($idMascota)
    {
        $stmt = oci_parse($this->db, "BEGIN P_MASCOTA.getMascota(:p_idMascota, :p_nombre, :p_descripcion, :p_imagen, :p_idTipoMascota, :p_idCliente, :p_resultado); END;");

        oci_bind_by_name($stmt, ":p_idMascota", $idMascota);

        // Declarar variables para los parámetros OUT
        $p_nombre = '';
        $p_descripcion = '';
        $p_imagen = '';
        $p_idTipoMascota = -1;
        $p_idCliente = -1;
        $p_resultado = null;

        // Vincular parámetros OUT
        oci_bind_by_name($stmt, ":p_nombre", $p_nombre, 200);
        oci_bind_by_name($stmt, ":p_descripcion", $p_descripcion, 1000);
        oci_bind_by_name($stmt, ":p_imagen", $p_imagen, 400);
        oci_bind_by_name($stmt, ":p_idTipoMascota", $p_idTipoMascota, -1, SQLT_INT);
        oci_bind_by_name($stmt, ":p_idCliente", $p_idCliente, -1, SQLT_INT);
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        $mascota = null;
        if ($p_resultado == 0) {
            $mascota = array(
                'idMascota' => $idMascota,
                'nombre' => $p_nombre,
                'descripcion' => $p_descripcion,
                'imagen' => $p_imagen,
                'idTipoMascota' => $p_idTipoMascota,
                'idCliente' => $p_idCliente
            );
        }

        return array('datos' => $mascota, 'resultado' => $p_resultado);
    }

    public function getMascotas()
    {
        $stmt = oci_parse($this->db, "BEGIN P_MASCOTA.getMascotas(:p_cursor, :p_resultado); END;");

        $p_cursor = oci_new_cursor($this->db);
        oci_bind_by_name($stmt, ":p_cursor", $p_cursor, -1, OCI_B_CURSOR);

        $p_resultado = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        $mascotas = array();
        if ($p_resultado == 0) {
            oci_execute($p_cursor);
            while ($row = oci_fetch_assoc($p_cursor)) {
                array_push($mascotas, $row);
            }
        }

        oci_free_statement($p_cursor);
        oci_free_statement($stmt);

        return array('datos' => $mascotas, 'resultado' => $p_resultado);
    }


    public function insertMascota($nombre, $descripcion, $imagen, $idTipoMascota, $idCliente)
    {
        $stmt = oci_parse($this->db, "BEGIN P_MASCOTA.insertMascota(:p_nombre, :p_descripcion, :p_imagen, :p_idTipoMascota, :p_idCliente, :p_resultado); END;");

        oci_bind_by_name($stmt, ":p_nombre", $nombre);
        oci_bind_by_name($stmt, ":p_descripcion", $descripcion);
        oci_bind_by_name($stmt, ":p_imagen", $imagen);
        oci_bind_by_name($stmt, ":p_idTipoMascota", $idTipoMascota);
        oci_bind_by_name($stmt, ":p_idCliente", $idCliente);

        // Declarar variable para el parámetro OUT
        $p_resultado = null;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        if ($p_resultado == 0) {
            // Inserción exitosa
            return array('resultado' => $p_resultado);
        } else {
            // Error
            return array('resultado' => $p_resultado, 'error' => oci_error($stmt));
        }
    }

    public function updateMascota($idMascota, $nombre, $descripcion, $imagen, $idTipoMascota, $idCliente)
    {
        $stmt = oci_parse($this->db, "BEGIN P_MASCOTA.updateMascota(:p_idMascota, :p_nombre, :p_descripcion, :p_imagen, :p_idTipoMascota, :p_idCliente, :p_resultado); END;");

        oci_bind_by_name($stmt, ":p_idMascota", $idMascota);
        oci_bind_by_name($stmt, ":p_nombre", $nombre);
        oci_bind_by_name($stmt, ":p_descripcion", $descripcion);
        oci_bind_by_name($stmt, ":p_imagen", $imagen);
        oci_bind_by_name($stmt, ":p_idTipoMascota", $idTipoMascota);
        oci_bind_by_name($stmt, ":p_idCliente", $idCliente);

        $p_resultado = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        return $p_resultado;
    }

    public function deleteMascota($idMascota)
    {
        $stmt = oci_parse($this->db, "BEGIN P_MASCOTA.deleteMascota(:p_idMascota, :p_resultado); END;");

        oci_bind_by_name($stmt, ":p_idMascota", $idMascota);

        $p_resultado = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        return $p_resultado;
    }

    public function buscarMascotas($searchTerm)
    {
        $conn = $this->db;

        $stmt = oci_parse($conn, "BEGIN P_MASCOTA.buscarMascotas(:p_searchTerm, :p_cursor, :p_resultado, :p_numFilas); END;");

        oci_bind_by_name($stmt, ":p_searchTerm", $searchTerm);
        $p_cursor = oci_new_cursor($conn);
        oci_bind_by_name($stmt, ":p_cursor", $p_cursor, -1, OCI_B_CURSOR);
        $p_resultado = 0;
        $p_numFilas = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);
        oci_bind_by_name($stmt, ":p_numFilas", $p_numFilas, -1, SQLT_INT);

        oci_execute($stmt);

        $mascotas = [];
        if ($p_resultado == 0) {
            oci_execute($p_cursor);
            while ($row = oci_fetch_assoc($p_cursor)) {
                array_push($mascotas, $row);
            }
        }

        oci_free_statement($p_cursor);
        oci_free_statement($stmt);

        return ['datos' => $mascotas, 'numFilas' => $p_numFilas];
    }

    public function buscarMascotasPorCliente($idCliente, $searchTerm)
    {
        $conn = $this->db;

        $stmt = oci_parse($conn, "BEGIN P_MASCOTA.buscarMascotasPorCliente(:p_idCliente, :p_searchTerm, :p_cursor, :p_resultado, :p_numFilas); END;");

        oci_bind_by_name($stmt, ":p_idCliente", $idCliente);
        oci_bind_by_name($stmt, ":p_searchTerm", $searchTerm);
        $p_cursor = oci_new_cursor($conn);
        oci_bind_by_name($stmt, ":p_cursor", $p_cursor, -1, OCI_B_CURSOR);
        $p_resultado = 0;
        $p_numFilas = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);
        oci_bind_by_name($stmt, ":p_numFilas", $p_numFilas, -1, SQLT_INT);

        oci_execute($stmt);

        $mascotas = [];
        if ($p_resultado == 0) {
            oci_execute($p_cursor);
            while ($row = oci_fetch_assoc($p_cursor)) {
                array_push($mascotas, $row);
            }
        }

        oci_free_statement($p_cursor);
        oci_free_statement($stmt);

        return ['datos' => $mascotas, 'numFilas' => $p_numFilas];
    }

    public function getMascotasPorCliente($idCliente)
    {
        $stmt = oci_parse($this->db, "BEGIN P_MASCOTA.getMascotasPorCliente(:p_idCliente, :p_cursor, :p_resultado); END;");

        oci_bind_by_name($stmt, ":p_idCliente", $idCliente);
        $p_cursor = oci_new_cursor($this->db);
        oci_bind_by_name($stmt, ":p_cursor", $p_cursor, -1, OCI_B_CURSOR);

        $p_resultado = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        $mascotas = array();
        if ($p_resultado == 0) {
            oci_execute($p_cursor);
            while ($row = oci_fetch_assoc($p_cursor)) {
                array_push($mascotas, $row);
            }
        }

        oci_free_statement($p_cursor);
        oci_free_statement($stmt);

        return array('datos' => $mascotas, 'resultado' => $p_resultado);
    }

    /* -----------------Images Cliente ----------------- */

    public function uploadImagen($imagen)
    {
        $carpetaImagenes = 'img/images_pets/';
        $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
        move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);
        return $nombreImagen;
    }

    public function deleteImagen($nombreImagen)
    {
        $rutaImagen = "img/images_pets/" . $nombreImagen;
        if (file_exists($rutaImagen)) {
            unlink($rutaImagen);
            return true;
        }
        return false;
    }

}
?>