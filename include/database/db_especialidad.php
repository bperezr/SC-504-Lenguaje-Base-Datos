<?php
require_once 'db_config.php';

class Especialidad
{
    protected $db;

    public function __construct()
    {
        $this->connectDB();
    }

   /* public function connectDB()
    {
        global $host, $port, $user, $pass, $dbname;

        $dsn = "mysql:host=$host;port=$port;dbname=$dbname";
        try {
            $this->db = new PDO($dsn, $user, $pass);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Error al conectar a la base de datos: ' . $e->getMessage());
        }
    }
    //fgff
    // Función para obtener una especialidad por su ID
    public function getEspecialidad($id)
    {
        $conn = $this->db;
        $stmt = oci_parse($conn, "BEGIN  P_ESPECIALIDAD.getEspecialidad(:p_idEspecialidad, :p_Especialidad, :p_Descripcion, :p_resultado); END;");

        oci_bind_by_name($stmt, ":p_idEspecialidad", $id);

        $p_Especialidad = "";
        $p_Descripcion = "";
        $p_resultado = 0;

        oci_bind_by_name($stmt, ":p_Especialidad", $p_Especialidad, 200);
        oci_bind_by_name($stmt, ":p_Descripcion", $p_Descripcion, 200);
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        $especialidad = null;
        if ($p_resultado == 1) {
            $especialidad = array(
                'idEspecialidad' => $id,
                'especialidad' => $p_Especialidad,
                'descripcion' => $p_Descripcion
            );
        }

        return array('datos' => $especialidad, 'resultado' => $p_resultado);
    }

    // Función para obtener todas las especialidades
    public function getEspecialidades()
    {
        $especialidades = array();
        $conn = $this->db;

        $stmt = oci_parse($conn, "BEGIN  P_ESPECIALIDAD.getEspecialidades(:p_cursor, :p_resultado); END;");
        $p_cursor = oci_new_cursor($conn);
        oci_bind_by_name($stmt, ":p_cursor", $p_cursor, -1, OCI_B_CURSOR);
        $p_resultado = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        if ($p_resultado == 1) {
            oci_execute($p_cursor);
            while ($row = oci_fetch_assoc($p_cursor)) {
                array_push($especialidades, $row);
            }
        }

        oci_free_statement($p_cursor);
        oci_free_statement($stmt);

        return array('datos' => $especialidades, 'resultado' => $p_resultado);
    }


    // Función para insertar una nueva especialidad
    public function insertEspecialidad($especialidad, $descripcion)
    {
        $conn = $this->db;

        $stmt = oci_parse($conn, "BEGIN P_ESPECIALIDAD.insertEspecialidad(:p_Especialidad, :p_Descripcion, :p_resultado); END;");

        oci_bind_by_name($stmt, ":p_Especialidad", $especialidad);
        oci_bind_by_name($stmt, ":p_Descripcion", $descripcion);

        $p_resultado = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        return $p_resultado;
    }


    // Función para actualizar una especialidad
    public function updateEspecialidad($id, $especialidad, $descripcion)
    {
        $conn = $this->db;

        $stmt = oci_parse($conn, "BEGIN P_ESPECIALIDAD.updateEspecialidad(:p_idEspecialidad, :p_Especialidad, :p_Descripcion, :p_resultado); END;");

        oci_bind_by_name($stmt, ":p_idEspecialidad", $id);
        oci_bind_by_name($stmt, ":p_Especialidad", $especialidad);
        oci_bind_by_name($stmt, ":p_Descripcion", $descripcion);

        $p_resultado = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        return $p_resultado;
    }


    // Función para eliminar una especialidad por su ID
    public function deleteEspecialidad($id)
    {
        $conn = $this->db;

        $stmt = oci_parse($conn, "BEGIN P_ESPECIALIDAD.deleteEspecialidad(:p_idEspecialidad, :p_resultado); END;");

        oci_bind_by_name($stmt, ":p_idEspecialidad", $id);
        $p_resultado = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        return $p_resultado;
    }

    //Función para buascar especialidades
    public function buscarEspecialidades($searchTerm)
    {
        $conn = $this->db;

        $stmt = oci_parse($conn, "BEGIN P_ESPECIALIDAD.buscarEspecialidades(:p_searchTerm, :p_cursor, :p_resultado); END;");

        oci_bind_by_name($stmt, ":p_searchTerm", $searchTerm);
        $p_cursor = oci_new_cursor($conn);
        oci_bind_by_name($stmt, ":p_cursor", $p_cursor, -1, OCI_B_CURSOR);
        $p_resultado = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        $especialidades = [];
        if ($p_resultado == 1) {
            oci_execute($p_cursor);
            while ($row = oci_fetch_assoc($p_cursor)) {
                array_push($especialidades, $row);
            }
        }

        oci_free_statement($p_cursor);
        oci_free_statement($stmt);

        return $especialidades;
    }


}

?>