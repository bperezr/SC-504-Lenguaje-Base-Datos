<?php
require_once 'db_config.php';

class Colaborador
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
    // Función para obtener un solo colaborador por su ID
    public function getColaborador($id)
    {
        $conn = $this->db;
        $stmt = oci_parse($conn, "BEGIN  P_COLABORADOR.getColaborador(:p_idColaborador, :p_nombre, :p_apellido1, :p_apellido2, :p_idCargo, :p_idEspecialidad, :p_imagen, :p_correo, :p_resultado); END;");

        oci_bind_by_name($stmt, ":p_idColaborador", $id, 200);

        $p_idColaborador = $id;
        $p_nombre = "";
        $p_apellido1 = "";
        $p_apellido2 = "";
        $p_idCargo = "";
        $p_idEspecialidad = "";
        $p_imagen = "";
        $p_correo = "";
        $p_resultado = 0;

        oci_bind_by_name($stmt, ":p_idColaborador", $p_idColaborador, 200);
        oci_bind_by_name($stmt, ":p_nombre", $p_nombre, 200);
        oci_bind_by_name($stmt, ":p_apellido1", $p_apellido1, 200);
        oci_bind_by_name($stmt, ":p_apellido2", $p_apellido2, 200);
        oci_bind_by_name($stmt, ":p_idCargo", $p_idCargo, 200);
        oci_bind_by_name($stmt, ":p_idEspecialidad", $p_idEspecialidad, 200);
        oci_bind_by_name($stmt, ":p_imagen", $p_imagen, 200);
        oci_bind_by_name($stmt, ":p_correo", $p_correo, 200);
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        $colaborador = null;
        if ($p_resultado == 0) {
            $colaborador = array(
                'idColaborador' => $p_idColaborador,
                'nombre' => $p_nombre,
                'apellido1' => $p_apellido1,
                'apellido2' => $p_apellido2,
                'idCargo' => $p_idCargo,
                'idEspecialidad' => $p_idEspecialidad,
                'imagen' => $p_imagen,
                'correo' => $p_correo
            );
        }

        return array('datos' => $colaborador, 'resultado' => $p_resultado);
    }

    public function getColaboradores()
    {
        $colaboradores = array();
        $conn = $this->db;

        $stmt = oci_parse($conn, "BEGIN P_COLABORADOR.getColaboradores(:p_cursor, :p_resultado); END;");

        $p_cursor = oci_new_cursor($conn);
        oci_bind_by_name($stmt, ":p_cursor", $p_cursor, -1, OCI_B_CURSOR);
        $p_resultado = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        if ($p_resultado == 1) {
            oci_execute($p_cursor);
            while ($row = oci_fetch_assoc($p_cursor)) {
                array_push($colaboradores, $row);
            }
        }

        oci_free_statement($p_cursor);
        oci_free_statement($stmt);

        return array('datos' => $colaboradores, 'resultado' => $p_resultado);
    }

    public function getRoles()
    {
        $roles = array();
        $conn = $this->db;

        $stmt = oci_parse($conn, "BEGIN P_COLABORADOR.getRoles(:p_cursor, :p_resultado); END;");

        $p_cursor = oci_new_cursor($conn);
        oci_bind_by_name($stmt, ":p_cursor", $p_cursor, -1, OCI_B_CURSOR);
        $p_resultado = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        if ($p_resultado == 1) {
            oci_execute($p_cursor);
            while ($row = oci_fetch_assoc($p_cursor)) {
                array_push($roles, $row);
            }
        }

        oci_free_statement($p_cursor);
        oci_free_statement($stmt);

        return array('datos' => $roles, 'resultado' => $p_resultado);
    }

    public function verificarCorreoExistente($correo)
    {
        if (is_resource($this->db)) {
            $stmt = oci_parse($this->db, "BEGIN P_COLABORADOR.verificarCorreoExistente(:p_correo, :p_resultado); END;");
            $p_resultado = 0;

            oci_bind_by_name($stmt, ":p_correo", $correo);
            oci_bind_by_name($stmt, ":p_resultado", $p_resultado, 10, OCI_B_INT);

            oci_execute($stmt);

            return $p_resultado == 1;
        } else {
            die("Error: La conexión no es un recurso OCI8 válido.");
        }
    }

    // Función para insertar un nuevo colaborador
    public function insertColaborador($nombre, $apellido1, $apellido2, $idCargo, $idEspecialidad, $imagen, $correo, $contrasena, $idRol)
    {
        $conn = $this->db;

        $stmt = oci_parse($conn, "BEGIN P_COLABORADOR.insertColaborador(:p_nombre, :p_apellido1, :p_apellido2, :p_idCargo, :p_idEspecialidad, :p_imagen, :p_correo, :p_contrasena, :p_idRol, :p_resultado); END;");

        oci_bind_by_name($stmt, ":p_nombre", $nombre);
        oci_bind_by_name($stmt, ":p_apellido1", $apellido1);
        oci_bind_by_name($stmt, ":p_apellido2", $apellido2);
        oci_bind_by_name($stmt, ":p_idCargo", $idCargo);
        oci_bind_by_name($stmt, ":p_idEspecialidad", $idEspecialidad);
        oci_bind_by_name($stmt, ":p_imagen", $imagen);
        oci_bind_by_name($stmt, ":p_correo", $correo);
        oci_bind_by_name($stmt, ":p_contrasena", $contrasena);
        oci_bind_by_name($stmt, ":p_idRol", $idRol);


        $p_resultado = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        return $p_resultado;
    }

    // Función para actualizar un colaborador
    public function updateColaborador($idColaborador, $nombre, $apellido1, $apellido2, $idCargo, $idEspecialidad, $imagen, $correo, $idRol)
    {
        $conn = $this->db;

        $stmt = oci_parse($conn, "BEGIN P_COLABORADOR.updateColaborador( :p_idColaborador, :p_nombre, :p_apellido1, :p_apellido2, :p_idCargo, :p_idEspecialidad, :p_imagen, :p_correo, :p_idRol,:p_resultado);END;");

        oci_bind_by_name($stmt, ":p_idColaborador", $idColaborador);
        oci_bind_by_name($stmt, ":p_nombre", $nombre);
        oci_bind_by_name($stmt, ":p_apellido1", $apellido1);
        oci_bind_by_name($stmt, ":p_apellido2", $apellido2);
        oci_bind_by_name($stmt, ":p_idCargo", $idCargo);
        oci_bind_by_name($stmt, ":p_idEspecialidad", $idEspecialidad);
        oci_bind_by_name($stmt, ":p_imagen", $imagen);
        oci_bind_by_name($stmt, ":p_correo", $correo);

        $resultado = null;
        oci_bind_by_name($stmt, ":p_idRol", $idRol);
        oci_bind_by_name($stmt, ":p_resultado", $resultado, -1, SQLT_INT);

        oci_execute($stmt);

        return $resultado;
    }

    public function deleteColaborador($idColaborador)
    {
        $conn = $this->db;
        $p_resultado = 0;

        $stmt = oci_parse($conn, "BEGIN P_COLABORADOR.deleteColaborador(:p_idColaborador, :p_resultado); END;");

        oci_bind_by_name($stmt, ":p_idColaborador", $idColaborador);
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        oci_free_statement($stmt);

        return $p_resultado;
    }

    public function buscarColaboradores($searchTerm)
    {
        $conn = $this->db;

        $stmt = oci_parse($conn, "BEGIN P_COLABORADOR.buscarcolaboradores(:p_searchTerm, :p_cursor, :p_resultado, :p_numFilas); END;");

        oci_bind_by_name($stmt, ":p_searchTerm", $searchTerm);
        $p_cursor = oci_new_cursor($conn);
        oci_bind_by_name($stmt, ":p_cursor", $p_cursor, -1, OCI_B_CURSOR);
        $p_resultado = 0;
        $p_numFilas = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);
        oci_bind_by_name($stmt, ":p_numFilas", $p_numFilas, -1, SQLT_INT);

        oci_execute($stmt);

        $colaboradores = [];
        if ($p_resultado == 0) {
            oci_execute($p_cursor);
            while ($row = oci_fetch_assoc($p_cursor)) {
                array_push($colaboradores, $row);
            }
        }

        oci_free_statement($p_cursor);
        oci_free_statement($stmt);

        return ['datos' => $colaboradores, 'numFilas' => $p_numFilas];
    }

    public function getMedicosPorServicio($idServicio)
    {
        $conn = $this->db;

        // Declarar los parámetros del procedimiento almacenado
        $p_idServicio = $idServicio;
        $p_cursor = oci_new_cursor($conn);
        $p_resultado = 0;

        // Preparar y ejecutar el procedimiento almacenado
        $stmt = oci_parse($conn, "BEGIN P_COLABORADOR.getMedicosPorServicio(:p_idServicio, :p_cursor, :p_resultado); END;");
        oci_bind_by_name($stmt, ":p_idServicio", $p_idServicio);
        oci_bind_by_name($stmt, ":p_cursor", $p_cursor, -1, OCI_B_CURSOR);
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);
        oci_execute($stmt);

        // Crear un array para almacenar los resultados
        $medicos = [];

        // Comprobar el resultado del procedimiento almacenado
        if ($p_resultado == 0) {
            // Recuperar los datos del cursor
            oci_execute($p_cursor);
            while ($row = oci_fetch_assoc($p_cursor)) {
                array_push($medicos, $row);
            }
        }

        // Liberar recursos
        oci_free_statement($p_cursor);
        oci_free_statement($stmt);

        // Devolver los datos y el resultado
        return ['datos' => $medicos, 'resultado' => $p_resultado];
    }

    public function getColaboradorPorCorreo($correo)
    {
        $conn = $this->db;

        $stmt = oci_parse($conn, "BEGIN P_COLABORADOR.getColaboradorPorCorreo(:p_correo, :p_cursor, :p_resultado); END;");

        oci_bind_by_name($stmt, ":p_correo", $correo);
        $p_cursor = oci_new_cursor($conn);
        oci_bind_by_name($stmt, ":p_cursor", $p_cursor, -1, OCI_B_CURSOR);
        $p_resultado = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        $colaborador = [];

        if ($p_resultado == 0) {
            oci_execute($p_cursor);
            while ($row = oci_fetch_assoc($p_cursor)) {
                $colaborador = $row;
            }
        }

        oci_free_statement($p_cursor);
        oci_free_statement($stmt);

        return $colaborador;
    }

    /* -----------------Login  ----------------- */
    public function validarCredenciales($correo, $contrasena)
    {
        $stmt = oci_parse($this->db, "BEGIN P_COLABORADOR.validarCredenciales(:p_Correo, :p_Contrasena, :p_resultado); END;");

        oci_bind_by_name($stmt, ":p_Correo", $correo);
        oci_bind_by_name($stmt, ":p_Contrasena", $contrasena);

        $p_resultado = null;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        return $p_resultado;
    }

    public function obtenerColaboradorPorCorreo($correo)
    {
        $stmt = oci_parse($this->db, "BEGIN P_COLABORADOR.obtenerColaboradorPorCorreo(:p_Correo, :p_idColaborador, :p_idRol, :p_nombre, :p_apellido1, :p_apellido2, :p_resultado); END;");

        oci_bind_by_name($stmt, ":p_Correo", $correo);

        $idColaborador = -1;
        $idRol = -1;
        $nombre = '';
        $apellido1 = '';
        $apellido2 = '';
        $resultado = null;

        oci_bind_by_name($stmt, ":p_idColaborador", $idColaborador, -1, SQLT_INT);
        oci_bind_by_name($stmt, ":p_idRol", $idRol, -1, SQLT_INT);
        oci_bind_by_name($stmt, ":p_nombre", $nombre, 200);
        oci_bind_by_name($stmt, ":p_apellido1", $apellido1, 200);
        oci_bind_by_name($stmt, ":p_apellido2", $apellido2, 200);
        oci_bind_by_name($stmt, ":p_resultado", $resultado, -1, SQLT_INT);

        oci_execute($stmt);

        $colaborador = array(
            'idColaborador' => $idColaborador,
            'idRol' => $idRol,
            'nombre' => $nombre,
            'apellido1' => $apellido1,
            'apellido2' => $apellido2
        );

        return array('datos' => $colaborador, 'resultado' => $resultado);
    }

    /* -----------------Colaborador Servicio  ----------------- */

    public function getColaboradoresEspecialidad()
    {
        $colaboradores = array();
        $conn = $this->db;

        $stmt = oci_parse($conn, "BEGIN P_COLABORADOR.getColaboradoresEspecialidad(:p_cursor, :p_resultado); END;");

        $p_cursor = oci_new_cursor($conn);
        oci_bind_by_name($stmt, ":p_cursor", $p_cursor, -1, OCI_B_CURSOR);
        $p_resultado = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        if ($p_resultado == 1) {
            oci_execute($p_cursor);
            while ($row = oci_fetch_assoc($p_cursor)) {
                array_push($colaboradores, $row);
            }
        }

        oci_free_statement($p_cursor);
        oci_free_statement($stmt);

        return array('datos' => $colaboradores, 'resultado' => $p_resultado);
    }

    public function getServiciosPorColaborador($idColaborador)
    {
        $servicios = array();
        $conn = $this->db;

        $stmt = oci_parse($conn, "BEGIN P_COLABORADOR.getServiciosPorColaborador(:p_idColaborador, :p_servicios, :p_resultado); END;");

        $p_servicios = oci_new_cursor($conn);
        oci_bind_by_name($stmt, ":p_idColaborador", $idColaborador, -1, SQLT_INT);
        oci_bind_by_name($stmt, ":p_servicios", $p_servicios, -1, OCI_B_CURSOR);
        $p_resultado = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        if ($p_resultado == 1) {
            oci_execute($p_servicios);
            while ($row = oci_fetch_assoc($p_servicios)) {
                array_push($servicios, $row);
            }
        }

        oci_free_statement($p_servicios);
        oci_free_statement($stmt);

        return array('datos' => $servicios, 'resultado' => $p_resultado);
    }

    public function insertColaboradorServicio($idServicio, $idColaborador)
    {
        $conn = $this->db;

        $stmt = oci_parse($conn, "BEGIN P_COLABORADOR.insertColaboradorServicio(:p_idServicio, :p_idColaborador, :p_resultado); END;");

        oci_bind_by_name($stmt, ":p_idServicio", $idServicio);
        oci_bind_by_name($stmt, ":p_idColaborador", $idColaborador);

        $p_resultado = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        return $p_resultado;
    }

    public function deleteColaboradorServicio($idServicio, $idColaborador)
    {
        $conn = $this->db;
        $p_resultado = 0;

        $stmt = oci_parse($conn, "BEGIN P_COLABORADOR.deleteColaboradorServicio(:p_idServicio, :p_idColaborador, :p_resultado); END;");

        oci_bind_by_name($stmt, ":p_idServicio", $idServicio);
        oci_bind_by_name($stmt, ":p_idColaborador", $idColaborador);

        $p_resultado = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        oci_free_statement($stmt);

        return $p_resultado;
    }
    public function getServiciosNoAsignados($idColaborador)
    {
        $conn = $this->db;
        $stmt = oci_parse($conn, "BEGIN P_COLABORADOR.getServiciosNoAsignados(:p_idColaborador, :p_resultado, :p_servicios); END;");

        oci_bind_by_name($stmt, ":p_idColaborador", $idColaborador, SQLT_INT);

        $p_idColaborador = $idColaborador;
        $p_resultado = 0;

        // Bind del parámetro de salida p_servicios
        $p_servicios = oci_new_cursor($conn);
        oci_bind_by_name($stmt, ":p_servicios", $p_servicios, -1, OCI_B_CURSOR);

        oci_execute($stmt);

        $servicios = array();

        if ($p_resultado == 0) {
            // Recorremos el cursor para obtener los servicios
            oci_execute($p_servicios);
            while (($row = oci_fetch_assoc($p_servicios)) !== false) {
                $servicios[] = $row;
            }
        }

        // Cerramos el cursor
        oci_free_statement($stmt);

        return array('datos' => $servicios, 'resultado' => $p_resultado);
    }


    /* ------------IMAGEN------------ */

    //PENDIENTE
    public function uploadImagen($imagen)
    {
        $carpetaImagenes = '../img/images_workers/';
        $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
        move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);
        return $nombreImagen;
    }

    //PENDIENTE
    public function deleteImagen($nombreImagen)
    {
        $rutaImagen = "../img/images_workers/" . $nombreImagen;
        if (file_exists($rutaImagen)) {
            unlink($rutaImagen);
            return true;
        }
        return false;
    }

}
?>