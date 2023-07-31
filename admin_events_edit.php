<?php

$id = $_GET['id'];

require 'include/database/database.php';
$db = ConectarDB();

$queryEventos = "SELECT  
                 e.*,
                 p.nombre as NombreProvincia , 
                 c.nombre as NombreCanton, 
                 d.nombre as NombreDistrito 
                 FROM eventos as e 
                 join provincia as p on e.idProvincia = p.idProvincia 
                 join canton as c on e.idCanton =  c.idCanton 
                 join distrito as d on e.idDistrito = d.idDistrito 
                 where idEvento = ${id}";
$resultEventos = mysqli_query($db, $queryEventos);
$evento = mysqli_fetch_assoc($resultEventos);

$queryProvincia = "SELECT idProvincia, nombre FROM provincia ORDER BY idProvincia";
$result = mysqli_query($db, $queryProvincia);

$queryCanton = "SELECT idCanton, nombre FROM canton ORDER BY idCanton";
$resultCanton = mysqli_query($db, $queryCanton);

$queryDistrito = "SELECT idDistrito, nombre FROM distrito ORDER BY idDistrito";
$resultDistrito = mysqli_query($db, $queryDistrito);

//Se inicializan las variables de acuerdo a los valores dentro de la base de datos de acuerdo al Id dato en 
//el queryEventos
$requeridos = [];
$nombreEvento = $evento['nombreEvento'];
$lugar = $evento['Lugar'];
$fecha = $evento['fecha'];
$horaInicio = $evento['hora_inicio'];
$horaFin = $evento['hora_fin'];
$descripcion = $evento['descripcion'];
$provincia = $evento['idProvincia'];
$canton = $evento['idCanton'];
$distrito = $evento['idDistrito'];
$imagen = $evento['imagen'];

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

    if (empty($requeridos)) {

        /* $carpetaImagenes = 'img/images';

        $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

        move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen); */

        $sqlUpdate = "Update eventos set nombreEvento = '${nombreEvento}', lugar = '${lugar}',fecha = '${fecha}',hora_inicio = '${horaInicio}'
        ,hora_fin = '${horaFin}',descripcion = '${descripcion}',idProvincia = ${provincia}, idCanton = ${canton},idDistrito = ${distrito}
         where idEvento = ${id}";

        $insertResult = mysqli_query($db, $sqlUpdate);

        if ($insertResult) {
            header('Location: /SC-502-Proyecto/admin_events.php');
        }
    }
}

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <!-- styles -->
    <?php $rutaCSS = 'css/admin_events.css';
    include 'include/template/header.php'; ?>
</head>

<body>
    <!-- Nav template -->
    <?php $enlaceActivo = 'admin_events';
    include 'include/template/nav_admin.php'; ?>

    <main class="contenedor">

        <?php foreach ($requeridos as $requerido) : ?>
            <div class="campos-requeridos">
                <?php echo $requerido; ?>
            </div>
        <?php endforeach ?>

        <form class="formulario" method="POST" enctype="multipart/form-data">
            <section class="evento">
                <div class="evento__detalle">
                    <h2 class="centrar-texto">Editar evento</h2>
                    <form id="formularioEvento" method="POST" class="formulario-evento" enctype="multipart/form-data">
                        <div class="campo">
                            <label for="nombreEvento">Nombre de evento:</label>
                            <input type="text" id="nombreEvento" name="nombreEvento" value="<?php echo $nombreEvento; ?>">
                        </div>
                        <div class="campo">
                            <label for="lugar">Lugar:</label>
                            <input type="text" id="lugar" name="lugar" value="<?php echo $lugar; ?>">
                        </div>
                        <div class="campo">
                            <label for="fecha">Fecha:</label>
                            <input type="date" id="fecha" name="fecha" value="<?php echo $fecha; ?>">
                        </div>
                        <div class="campo">
                            <label for="hora_inicio">Hora de inicio:</label>
                            <input type="time" id="hora_inicio" name="hora_inicio" value="<?php echo $horaInicio; ?>">
                        </div>
                        <div class="campo">
                            <label for="hora_fin">Hora de fin:</label>
                            <input type="time" id="hora_fin" name="hora_fin" value="<?php echo $horaFin; ?>">
                        </div>
                        <div class="campo">
                            <label for="descripcion">Descripción:</label>
                            <textarea id="descripcion" name="descripcion" rows="4"><?php echo $descripcion; ?></textarea>
                        </div>
                        <div class="campo">
                            <label for="provincia">Provincia</label>
                            <select type="number" name="idProvincia" id="provincia">
                                <option value="<?php echo $evento['idProvincia']; ?>"><?php echo $evento['NombreProvincia']; ?></option>
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        if ($row["idProvincia"] != $evento['idProvincia']) {
                                            echo '<option  value="' . $row["idProvincia"] . '">' . $row["nombre"] . '</option>';
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="campo">
                            <label for="canton">Cantón</label>
                            <select type="number" name="idCanton" id="idCanton">
                                <!-- Se deja la opcion seleccionada por el usuario cuando registro el evento en la base de datos,
                                     si deseea cambiar el canton se pueden escoger las opciones que estan dentro del while -->
                                <option value="<?php echo $evento['idCanton']; ?>"><?php echo $evento['NombreCanton']; ?></option>
                                <?php
                                if ($resultCanton->num_rows > 0) {
                                    while ($row = $resultCanton->fetch_assoc()) {
                                        if ($row["idCanton"] != $evento['idCanton']) {
                                            echo '<option value="' . $row["idCanton"] . '">' . $row["nombre"] . '</option>';
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="campo">
                            <label for="distrito">Distrito</label>
                            <select type="number" name="idDistrito" id="idDistrito">
                                <option value="<?php echo $evento['idDistrito']; ?>"><?php echo $evento['NombreDistrito']; ?></option>
                                <?php
                                if ($resultDistrito->num_rows > 0) {
                                    while ($row = $resultDistrito->fetch_assoc()) {
                                        if ($row["idDistrito"] != $evento['idDistrito']) {
                                            echo '<option value="' . $row["idDistrito"] . '">' . $row["nombre"] . '</option>';
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="campo campo-imagen">
                            <label for="imagen">Imagen:</label>
                            <input type="file" id="imagen" name="imagen" accept="image/*">
                            <img src="img/images/<?php echo $imagen; ?>" alt="">


                        </div>
                        <div class="campo centrar-texto botones_evento">
                            <button class="enviar" type="submit">Crear evento</button>
                            <a class="cancelar" href="#" onclick="window.history.back();">Cancelar</a>
                        </div>
                    </form>
                </div>
            </section>
        </form>
        </div>
        </section>
        </form>
    </main>
    <!-- Footer -->
    <?php include 'include/template/footer.php'; ?>
    <!-- JS -->
    <script src="js/evento.js"></script>
</body>

</html>