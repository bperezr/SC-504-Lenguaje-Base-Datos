<?php
require_once 'db_config.php';

class Cargo
{
    protected $db;

    public function __construct()
    {
        $this->connectDB();
    }

    /*public function connectDB()
    {
        //global $host, $port, $user, $pass, $dbname;

        $dsn = "mysql:host=$host;port=$port;dbname=$dbname";
        try {
            $this->db = new PDO($dsn, $user, $pass);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Error al conectar a la base de datos: ' . $e->getMessage());
        }
    }*/

    public function connectDB()
    {
        global $host, $user, $pass , $port, $sid;

        try {
            $this->db = new PDO("oci:dbname=//$host:$port/$sid", $user, $pass );
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Error al conectar a la base de datos Oracle: ' . $e->getMessage());
        }
}


    // Función para obtener un cargo por su ID
   /* public function getCargo($id)
    {
        $query = "SELECT * FROM cargo WHERE idCargo = :idCargo";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idCargo', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }*/



   /*Primer SP */
    public function getCargo($id,$resultado)
    {
        $sql = "BEGIN getCargo(:id, resultado); END;";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':resultado', $resultado, PDO::PARAM_INT, 1);
        $stmt->execute();
    }


    // Función para obtener todos los cargos

    /*public function getCargos()
    {
        $query = "SELECT * FROM cargo";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }*/


   /* Segundo SP*/ 
    public function getCargos($id)
    {
        $sql = "BEGIN getCargos(:id); END;";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':resultado', $resultado, PDO::PARAM_INT, 1);
        $stmt->execute();
    }




    // Función para insertar un nuevo cargo
    
 
    /*public function insertCargo($cargo)
    {
        $query = "INSERT INTO cargo (cargo) VALUES (:cargo)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':cargo', $cargo);
        return $stmt->execute();
    }*/

  /* Tercer SP*/ 
  public function insertCargo($cargo,$resultado)
  {
      $sql = "BEGIN insertCargo(:cargo, :resultado); END;";
      $stmt = $this->db->prepare($sql);

      $stmt->bindParam(':cargo', $cargo);
      $stmt->bindParam(':resultado', $resultado, PDO::PARAM_INT, 1);

      $stmt->execute();
  }



    // Función para actualizar un cargo


    /*public function updateCargo($id, $cargo)
    {
        $query = "UPDATE cargo SET cargo = :cargo WHERE idCargo = :idCargo";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idCargo', $id);
        $stmt->bindParam(':cargo', $cargo);
        return $stmt->execute();
    }*/

/* Cuarto SP*/ 

public function updateCargo($id, $cargo,&$resultado)
    {
        $sql = "BEGIN updateCargo(:id, :cargo, :resultado); END;";
        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':cargo', $cargo);
        $stmt->bindParam(':resultado', $resultado, PDO::PARAM_INT, 1);

        $stmt->execute();
    }




    // Función para eliminar un cargo por su ID
    /*public function deleteCargo($id)
    {
        $query = "DELETE FROM cargo WHERE idCargo = :idCargo";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idCargo', $id);
        return $stmt->execute();
    }*/

    /* Quinto SP*/ 
    public function deleteCargo($id, $resultado)
    {
        $sql = "BEGIN deleteCargo(:id, :resultado); END;";
        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':resultado', $resultado, PDO::PARAM_INT, 1);
        $stmt->execute();
    }





/* Sexto SP*/ 
    /*public function buscarCargos($searchTerm)
    {
        $query = "SELECT c.*
                FROM cargo c            
                WHERE c.cargo LIKE :searchTerm";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%', PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }*/


    public function buscarCargos($cargo, $resultado)
    {
        $sql = "BEGIN deleteCargo(:cargo, :resultado); END;";
        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':cargo', $cargo);
        $stmt->bindParam(':resultado', $resultado, PDO::PARAM_INT, 1);
        $stmt->execute();
    }


}

?>