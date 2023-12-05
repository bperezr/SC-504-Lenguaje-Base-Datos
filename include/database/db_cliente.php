<?php
require_once 'db_config.php';

class Cliente
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

    public function getCliente($id)
    {
        $stmt = oci_parse($this->db, "BEGIN P_CLIENTE.getCliente(:p_idCliente, :p_nombre, :p_apellido1, :p_apellido2, :p_telefono, :p_imagen, :p_domicilio, :p_idProvincia, :p_idCanton, :p_idDistrito, :p_idRol, :p_correo, :p_resultado); END;");

        oci_bind_by_name($stmt, ":p_idCliente", $id);

        $p_nombre = '';
        $p_apellido1 = '';
        $p_apellido2 = '';
        $p_telefono = '';
        $p_imagen = '';
        $p_domicilio = '';
        $p_idProvincia = -1;
        $p_idCanton = -1;
        $p_idDistrito = -1;
        $p_idRol = -1;
        $p_correo = '';
        $p_resultado = -1;

        oci_bind_by_name($stmt, ":p_nombre", $p_nombre, 200);
        oci_bind_by_name($stmt, ":p_apellido1", $p_apellido1, 200);
        oci_bind_by_name($stmt, ":p_apellido2", $p_apellido2, 200);
        oci_bind_by_name($stmt, ":p_telefono", $p_telefono, 200);
        oci_bind_by_name($stmt, ":p_imagen", $p_imagen, 400);
        oci_bind_by_name($stmt, ":p_domicilio", $p_domicilio, 200);
        oci_bind_by_name($stmt, ":p_idProvincia", $p_idProvincia);
        oci_bind_by_name($stmt, ":p_idCanton", $p_idCanton);
        oci_bind_by_name($stmt, ":p_idDistrito", $p_idDistrito);
        oci_bind_by_name($stmt, ":p_idRol", $p_idRol);
        oci_bind_by_name($stmt, ":p_correo", $p_correo, 200);
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        $cliente = null;
        if ($p_resultado == 0) {
            $cliente = array(
                'idCliente' => $id,
                'nombre' => $p_nombre,
                'apellido1' => $p_apellido1,
                'apellido2' => $p_apellido2,
                'telefono' => $p_telefono,
                'imagen' => $p_imagen,
                'domicilio' => $p_domicilio,
                'idProvincia' => $p_idProvincia,
                'idCanton' => $p_idCanton,
                'idDistrito' => $p_idDistrito,
                'idRol' => $p_idRol,
                'correo' => $p_correo
            );
        }

        return array('datos' => $cliente, 'resultado' => $p_resultado);
    }

    //DONE
    public function getClientes()
    {
        $stmt = oci_parse($this->db, "BEGIN P_CLIENTE.getClientes(:p_cursor, :p_resultado); END;");

        $p_cursor = oci_new_cursor($this->db);
        oci_bind_by_name($stmt, ":p_cursor", $p_cursor, -1, OCI_B_CURSOR);

        $p_resultado = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        $clientes = array();
        if ($p_resultado == 0) {
            oci_execute($p_cursor);
            while ($row = oci_fetch_assoc($p_cursor)) {
                array_push($clientes, $row);
            }
        }

        oci_free_statement($p_cursor);
        oci_free_statement($stmt);

        return array('datos' => $clientes, 'resultado' => $p_resultado);
    }

    //DONE
    public function getVerClientes()
    {
        $stmt = oci_parse($this->db, "BEGIN P_CLIENTE.getVerClientes(:p_cursor, :p_resultado); END;");

        $p_cursor = oci_new_cursor($this->db);
        oci_bind_by_name($stmt, ":p_cursor", $p_cursor, -1, OCI_B_CURSOR);

        $p_resultado = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        $clientes = array();
        if ($p_resultado == 0) {
            oci_execute($p_cursor);
            while ($row = oci_fetch_assoc($p_cursor)) {
                array_push($clientes, $row);
            }
        }

        oci_free_statement($p_cursor);
        oci_free_statement($stmt);

        return array('datos' => $clientes, 'resultado' => $p_resultado);
    }


    //DONE
    public function insertCliente($nombre, $apellido1, $apellido2, $telefono, $domicilio, $idProvincia, $idCanton, $idDistrito, $idRol, $correo, $contrasena)
    {
        $stmt = oci_parse($this->db, "BEGIN P_CLIENTE.insertClienteNuevo(:p_nombre, :p_apellido1, :p_apellido2, :p_telefono, :p_domicilio, :p_idProvincia, :p_idCanton, :p_idDistrito, :p_idRol, :p_correo, :p_contrasena, :p_resultado); END;");

        oci_bind_by_name($stmt, ":p_nombre", $nombre);
        oci_bind_by_name($stmt, ":p_apellido1", $apellido1);
        oci_bind_by_name($stmt, ":p_apellido2", $apellido2);
        oci_bind_by_name($stmt, ":p_telefono", $telefono);
        oci_bind_by_name($stmt, ":p_domicilio", $domicilio);
        oci_bind_by_name($stmt, ":p_idProvincia", $idProvincia);
        oci_bind_by_name($stmt, ":p_idCanton", $idCanton);
        oci_bind_by_name($stmt, ":p_idDistrito", $idDistrito);
        oci_bind_by_name($stmt, ":p_idRol", $idRol);
        oci_bind_by_name($stmt, ":p_correo", $correo);
        oci_bind_by_name($stmt, ":p_contrasena", $contrasena);

        $p_resultado = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        return $p_resultado;
    }

    //DONE
    public function updateCliente($idCliente, $nombre, $apellido1, $apellido2, $telefono, $domicilio, $idProvincia, $idCanton, $idDistrito, $idRol, $correo)
    {
        $stmt = oci_parse($this->db, "BEGIN P_CLIENTE.updateCliente(:p_idCliente, :p_nombre, :p_apellido1, :p_apellido2, :p_telefono, :p_imagen, :p_domicilio, :p_idProvincia, :p_idCanton, :p_idDistrito, :p_idRol, :p_correo, :p_resultado); END;");

        oci_bind_by_name($stmt, ":p_idCliente", $idCliente);
        oci_bind_by_name($stmt, ":p_nombre", $nombre);
        oci_bind_by_name($stmt, ":p_apellido1", $apellido1);
        oci_bind_by_name($stmt, ":p_apellido2", $apellido2);
        oci_bind_by_name($stmt, ":p_telefono", $telefono);
        oci_bind_by_name($stmt, ":p_domicilio", $domicilio);
        oci_bind_by_name($stmt, ":p_idProvincia", $idProvincia);
        oci_bind_by_name($stmt, ":p_idCanton", $idCanton);
        oci_bind_by_name($stmt, ":p_idDistrito", $idDistrito);
        oci_bind_by_name($stmt, ":p_idRol", $idRol);
        oci_bind_by_name($stmt, ":p_correo", $correo);

        $p_resultado = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        return $p_resultado;
    }


    //DONE
    public function updateClienteNuevo($idCliente, $nombre, $apellido1, $apellido2, $telefono, $domicilio, $idProvincia, $idCanton, $idDistrito, $imagen)
    {
        $stmt = oci_parse($this->db, "BEGIN P_CLIENTE.updateClienteNuevo(:p_idCliente, :p_nombre, :p_apellido1, :p_apellido2, :p_telefono, :p_domicilio, :p_idProvincia, :p_idCanton, :p_idDistrito, :p_imagen, :p_resultado); END;");

        oci_bind_by_name($stmt, ":p_idCliente", $idCliente);
        oci_bind_by_name($stmt, ":p_nombre", $nombre);
        oci_bind_by_name($stmt, ":p_apellido1", $apellido1);
        oci_bind_by_name($stmt, ":p_apellido2", $apellido2);
        oci_bind_by_name($stmt, ":p_telefono", $telefono);
        oci_bind_by_name($stmt, ":p_domicilio", $domicilio);
        oci_bind_by_name($stmt, ":p_idProvincia", $idProvincia);
        oci_bind_by_name($stmt, ":p_idCanton", $idCanton);
        oci_bind_by_name($stmt, ":p_idDistrito", $idDistrito);
        oci_bind_by_name($stmt, ":p_imagen", $imagen);

        $p_resultado = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        return $p_resultado;
    }

    //DONE
    public function deleteCliente($idCliente)
    {
        $stmt = oci_parse($this->db, "BEGIN P_CLIENTE.deleteCliente(:p_idCliente, :p_resultado); END;");

        oci_bind_by_name($stmt, ":p_idCliente", $idCliente);

        $p_resultado = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        return $p_resultado;
    }


    //DONE
    public function buscarClientes($searchTerm)
    {

        $stmt = oci_parse($this->db, "BEGIN P_CLIENTE.buscarClientes(:p_searchTerm, :p_cursor, :p_resultado, :p_numFilas); END;");

        oci_bind_by_name($stmt, ":p_searchTerm", $searchTerm);

        $p_cursor = oci_new_cursor($this->db);
        oci_bind_by_name($stmt, ":p_cursor", $p_cursor, -1, OCI_B_CURSOR);

        $p_resultado = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);
        $p_numFilas = 0;
        oci_bind_by_name($stmt, ":p_numFilas", $p_numFilas, -1, SQLT_INT);

        oci_execute($stmt);

        $clientes = [];
        if ($p_resultado == 0 && $p_numFilas > 0) {
            oci_execute($p_cursor);
            while ($row = oci_fetch_assoc($p_cursor)) {
                $clientes[] = $row;
            }
        }

        oci_free_statement($p_cursor);
        oci_free_statement($stmt);

        return $clientes;
    }


    /* -----------------Login Cliente ----------------- */

    public function getRoles()
    {
        $stmt = oci_parse($this->db, "BEGIN P_CLIENTE.getRoles(:p_cursor, :p_resultado); END;");

        $p_cursor = oci_new_cursor($this->db);
        oci_bind_by_name($stmt, ":p_cursor", $p_cursor, -1, OCI_B_CURSOR);

        $p_resultado = 0;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        $roles = [];
        if ($p_resultado == 0) {
            oci_execute($p_cursor);
            while ($row = oci_fetch_assoc($p_cursor)) {
                $roles[] = $row;
            }
        }

        oci_free_statement($p_cursor);
        oci_free_statement($stmt);

        return $roles;
    }


    //DONE
    public function verificarCorreoExistente($correo)
    {
        $stmt = oci_parse($this->db, "BEGIN P_CLIENTE.verificarCorreoExistente(:p_correo, :p_resultado); END;");

        oci_bind_by_name($stmt, ":p_correo", $correo);
        $p_resultado = null;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        return $p_resultado;
    }

    //DONE
    public function validarCredenciales($correo, $contrasena)
    {
        $stmt = oci_parse($this->db, "BEGIN P_CLIENTE.validarCredenciales(:p_Correo, :p_Contrasena, :p_resultado); END;");

        oci_bind_by_name($stmt, ":p_Correo", $correo);
        oci_bind_by_name($stmt, ":p_Contrasena", $contrasena);

        $p_resultado = null;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        return $p_resultado;
    }

    public function obtenerClientePorCorreo($correo)
    {
        $stmt = oci_parse($this->db, "BEGIN P_CLIENTE.obtenerClientePorCorreo(:p_Correo, :p_idCliente, :p_idRol, :p_nombre, :p_apellido1, :p_apellido2, :p_resultado); END;");

        oci_bind_by_name($stmt, ":p_Correo", $correo);

        $idCliente = -1;
        $idRol = -1;
        $nombre = '';
        $apellido1 = '';
        $apellido2 = '';
        $resultado = -1;

        oci_bind_by_name($stmt, ":p_idCliente", $idCliente, -1, SQLT_INT);
        oci_bind_by_name($stmt, ":p_idRol", $idRol, -1, SQLT_INT);
        oci_bind_by_name($stmt, ":p_nombre", $nombre, 200);
        oci_bind_by_name($stmt, ":p_apellido1", $apellido1, 200);
        oci_bind_by_name($stmt, ":p_apellido2", $apellido2, 200);
        oci_bind_by_name($stmt, ":p_resultado", $resultado, -1, SQLT_INT);

        oci_execute($stmt);

        $cliente = array(
            'idCliente' => $idCliente,
            'idRol' => $idRol,
            'nombre' => $nombre,
            'apellido1' => $apellido1,
            'apellido2' => $apellido2
        );

        return array('datos' => $cliente, 'resultado' => $resultado);
    }

    //DONE
    public function insertClienteNuevo($correo, $contrasena, &$resultado)
    {
        $stmt = oci_parse($this->db, "BEGIN P_CLIENTE.insertClienteNuevo(:p_correo, :p_contrasena, :p_resultado); END;");

        oci_bind_by_name($stmt, ":p_correo", $correo);
        oci_bind_by_name($stmt, ":p_contrasena", $contrasena);

        $p_resultado = null;
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        $resultado = $p_resultado;
    }

    public function camposNull($correo)
    {
        $stmt = oci_parse($this->db, "BEGIN P_CLIENTE.camposNull(:p_correo, :p_nombre, :p_apellido1, :p_apellido2, :p_telefono, :p_domicilio, :p_idProvincia, :p_idCanton, :p_idDistrito, :p_resultado); END;");

        oci_bind_by_name($stmt, ":p_correo", $correo);

        $p_nombre = '';
        $p_apellido1 = '';
        $p_apellido2 = '';
        $p_telefono = '';
        $p_domicilio = '';
        $p_idProvincia = -1;
        $p_idCanton = -1;
        $p_idDistrito = -1;
        $p_resultado = -1;

        oci_bind_by_name($stmt, ":p_nombre", $p_nombre, 200);
        oci_bind_by_name($stmt, ":p_apellido1", $p_apellido1, 200);
        oci_bind_by_name($stmt, ":p_apellido2", $p_apellido2, 200);
        oci_bind_by_name($stmt, ":p_telefono", $p_telefono, 200);
        oci_bind_by_name($stmt, ":p_domicilio", $p_domicilio, 200);
        oci_bind_by_name($stmt, ":p_idProvincia", $p_idProvincia);
        oci_bind_by_name($stmt, ":p_idCanton", $p_idCanton);
        oci_bind_by_name($stmt, ":p_idDistrito", $p_idDistrito);
        oci_bind_by_name($stmt, ":p_resultado", $p_resultado, -1, SQLT_INT);

        oci_execute($stmt);

        if ($p_nombre == '' || $p_apellido1 == '' || $p_apellido2 == '' || $p_telefono == '' || $p_domicilio == '' || $p_idProvincia == -1 || $p_idCanton == -1 || $p_idDistrito == -1) {
            return 0;
        } else {
            return 1;
        }
    }

    /* -----------------Images Cliente ----------------- */
    public function uploadImagen($imagen)
    {
        $carpetaImagenes = 'img/images_clients/';
        $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
        move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);
        return $nombreImagen;
    }

    public function deleteImagen($nombreImagen)
    {
        $rutaImagen = "img/images_clients/" . $nombreImagen;
        if (file_exists($rutaImagen)) {
            unlink($rutaImagen);
            return true;
        }
        return false;
    }
}