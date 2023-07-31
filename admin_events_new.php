<?php
require 'include/database/database.php';
$db = ConectarDB();

echo ($_SERVER['REQUEST_METHOD']);

$requeridos = [];
$nombreEvento = '';
$lugar = '';
$fecha = '';
$horaInicio = '';
$horaFin = '';
$descripcion = '';
$provincia = '';
$canton = '';
$distrito = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombreEvento = $_POST['nombreEvento'];
    $lugar = $_POST['lugar'];
    $fecha = $_POST['fecha'];
    $horaInicio = $_POST['hora_inicio'];
    $horaFin = $_POST['hora_fin'];
    $descripcion = $_POST['descripcion'];
    $provincia = $_POST['idProvincia'];
    $canton = $_POST['idCanton'];
    $distrito = $_POST['idDistrito'];
    $imagen = $_FILES['imagen'];

    var_dump($imagen);

    if (!$nombreEvento) {
        $requeridos[] = "El nombre del evento es requerido";
    }

    if (!$lugar) {
        $requeridos[] = "Favor inserte el nombre del lugar";
    }

    if (!$fecha) {
        $requeridos[] = "Favor inserte la fecha del evento";
    }

    if (!$horaInicio) {
        $requeridos[] = "Favor inserte la hora de inicio";
    }

    if (!$horaFin) {
        $requeridos[] = "Favor inserte la hora Fin";
    }

    if (!$provincia) {
        $requeridos[] = "Favor seleccione la provincia";
    }

    if (!$canton) {
        $requeridos[] = "Favor seleccione el cantón";
    }

    if (!$distrito) {
        $requeridos[] = "Favor seleccione el distrito";
    }

    if (!$imagen['name'] || $imagen['error']) {
        $requeridos[] = "La imagen es obligatoria";
    }


    if (empty($requeridos)) {

        $carpetaImagenes = 'imagenes/';

        $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

        move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);


        $sqlInsert = "insert into eventos (nombreEvento,lugar,fecha,hora_inicio,hora_fin,descripcion,imagen,idProvincia,idCanton,idDistrito) values
        ('$nombreEvento','$lugar', '$fecha', '$horaInicio','$horaFin', '$descripcion','$nombreImagen','$provincia','$canton','$distrito')";

        $insertResult = mysqli_query($db, $sqlInsert);

        if ($insertResult) {
            header('Location: /SC-502-Proyecto/admin_events.php');
        }
    }
}

$queryProvincia = "SELECT idProvincia, nombre FROM provincia ORDER BY idProvincia";
$result = mysqli_query($db, $queryProvincia);

$queryCanton = "SELECT idCanton, nombre FROM canton ORDER BY idCanton";
$resultCanton = mysqli_query($db, $queryCanton);

$queryDistrito = "SELECT idDistrito, nombre FROM distrito ORDER BY idDistrito";
$resultDistrito = mysqli_query($db, $queryDistrito);

$db->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <!-- styles -->
    <?php $rutaCSS = 'css/admin_styless.css';
    include 'include/template/header.php'; ?>
</head>

<body>
    <!-- Nav template -->
    <?php $enlaceActivo = 'admin_events';
    include 'include/template/nav_admin.php'; ?>

    <main class="contenedor">
        <a href="admin_events.php" class="boton input-text">Atras</a>

        <?php foreach ($requeridos as $requerido) : ?>
            <div class="campos-requeridos">
                <?php echo $requerido; ?>
            </div>
        <?php endforeach ?>

        <form class="formulario" method="POST" action="admin_events_new.php" enctype="multipart/form-data">
            <fieldset>
                <legend>Evento</legend>

                <label for="nombreEvento">Nombre Evento:</label>
                <input type="text" id="nombreEvento" name="nombreEvento" value="<?php echo $nombreEvento; ?>"><br><br>

                <label for="lugar">Lugar</label>
                <input type="text" id="lugar" name="lugar" value="<?php echo $lugar; ?>"><br><br>

                <label for="fecha">Fecha</label>
                <input type="date" id="fecha" name="fecha" value="<?php echo $fecha; ?>"><br><br>

                <label for="hora_inicio">Hora Inicio</label>
                <input type="time" id="hora_inicio" name="hora_inicio" value="<?php echo $horaInicio; ?>"><br><br>

                <label for="hora_fin">Hora Fin</label>
                <input type="time" id="hora_fin" name="hora_fin" value="<?php echo $horaFin; ?>"><br><br>

                <label for="descripcion">Descripcion:</label>
                <textarea name="descripcion" id="descripcion"><?php echo $descripcion; ?></textarea>

                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen" name="imagen"><br><br>

                <label for="provincia">Provincia</label>
                <select type="number" name="idProvincia" id="idProvincia">
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<option  value="' . $row["idProvincia"] . '">' . $row["nombre"] . '</option>';
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
    <script src=""></script>
</body>

</html>