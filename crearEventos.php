<?php
require 'include/database/database.php';
$db = ConectarDB();

echo ($_SERVER['REQUEST_METHOD']);

$requeridos = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<pre>";
    var_dump($_POST);
    echo "</pre>";
    $nombreEvento = $_POST['nombreEvento'];
    $lugar = $_POST['lugar'];
    $fecha = $_POST['fecha'];
    $horaInicio = $_POST['hora_inicio'];
    $horaFin = $_POST['hora_fin'];
    $descripcion = $_POST['descripcion'];
    $provincia = $_POST['idProvincia'];
    $canton = $_POST['idCanton'];
    $distrito = $_POST['idDistrito'];
    $sqlInsert = "insert into eventos (nombreEvento,lugar,fecha,hora_inicio,hora_fin,descripcion,imagen,idProvincia,idCanton,idDistrito) values
           ('$nombreEvento','$lugar', '$fecha', '$horaInicio','$horaFin', '$descripcion','','$provincia','$canton','$distrito')";

    if(!$nombreEvento){
        $requeridos[] = "El nombre del evento es requerido";
    }
     exit;
   
    $insertResult = mysqli_query($db,$sqlInsert); 

    if($insertResult){
      echo "Insertado correctamente";
    }

    $db->close();

}

$queryProvincia = "SELECT idProvincia, nombre FROM provincia ORDER BY idProvincia";
$result = mysqli_query($db, $queryProvincia);

$queryCanton = "SELECT idCanton, nombre FROM canton ORDER BY idCanton";
$resultCanton = mysqli_query($db, $queryCanton);

$queryDistrito = "SELECT idDistrito, nombre FROM distrito ORDER BY idDistrito";
$resultDistrito = mysqli_query($db, $queryDistrito);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <!-- styles -->
    <?php $rutaCSS = 'css/admin_styless.css';
    include 'include/template/header.php'; ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

</head>

<body>
    <!-- Nav template -->
    <?php $enlaceActivo = 'administrar';
    include 'include/template/nav_admin.php'; ?>

    <main class="contenedor">

        <form class="formulario" method="POST" action="crearEventos.php">
            <fieldset>
                <legend>Evento</legend>

                <label for="nombreEvento">Nombre Evento:</label>
                <input type="text" id="nombreEvento" name="nombreEvento"><br><br>

                <label for="lugar">Lugar</label>
                <input type="text" id="lugar" name="lugar"><br><br>

                <label for="fecha">Fecha</label>
                <input type="date" id="fecha" name="fecha"><br><br>

                <label for="hora_inicio">Hora Inicio</label>
                <input type="time" id="hora_inicio" name="hora_inicio"><br><br>

                <label for="hora_fin">Hora Fin</label>
                <input type="time" id="hora_fin" name="hora_fin"><br><br>

                <label for="descripcion">Descripcion:</label>
                <textarea name="descripcion" id="descripcion"></textarea>

                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen" name="imagen"><br><br>

                <label for="provincia">Provincia</label>
                <select type="number" name="idProvincia" id="idProvincia">
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row["idProvincia"] . '">' . $row["nombre"] . '</option>';
                        }
                    } 
                    ?>
                </select>

                <label for="canton">Cantón</label>
                <select type="number" name="idCanton" id="idCanton">
                <?php
                    if ($resultCanton->num_rows > 0) {
                        while ($row = $resultCanton->fetch_assoc()) {
                            echo '<option value="' . $row["idCanton"] . '">' . $row["nombre"] . '</option>';
                        }
                    }
                    ?>
                </select>

                <label for="distrito">Distrito</label>
                <select type="number" name="idDistrito" id="idDistrito">
                <?php
                    if ($resultDistrito->num_rows > 0) {
                        while ($row = $resultDistrito->fetch_assoc()) {
                            echo '<option value="' . $row["idDistrito"] . '">' . $row["nombre"] . '</option>';
                        }
                    }
                    ?>
                </select>

                <input type="submit" value="Crear Evento">

            </fieldset>
        </form>
    </main>

    <!-- Footer -->
    <?php include 'include/template/footer.php'; ?>
    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>