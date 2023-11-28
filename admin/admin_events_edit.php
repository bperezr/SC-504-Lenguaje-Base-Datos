<?php
session_start();

/*if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    $correoUsuario = $usuario['correo'];
    $rolUsuario = $usuario['idRol'];
    $rol = $usuario['rol'];
    $id = $usuario['id'];
}

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['idRol'] != 1) {
    header("Location: acceso_denegado.php");
    exit();
}*/

require_once '../include/database/db_eventos.php';
require_once '../include/database/db_lugar.php';
$evento = new Evento();
$lugares = new Lugar();

$datosEvento = null;
$mensajeAlerta = "";

// Verificar si estamos obteniendo un evento para editar
if (isset($_GET['id'])) {
    $idEvento = $_GET['id'];
    $respuesta = $evento->getEvento($idEvento);
    if ($respuesta['resultado'] == 1) {
        $datosEvento = $respuesta['datos'];
    } else {
        // Redireccionar si no se encuentra el evento
        header('Location: admin_events.php');
        $_SESSION['mensaje'] = "No se encontro el evento.";
        exit;
    }
}

$lugares = $lugares->getLugares();
$lugaresDatos = $lugares['datos'];
$lugaresResultado = $lugares['resultado'];

$lugaresDatos = $lugares['datos'];

$provincias = [];
foreach ($lugaresDatos as $lugar) {
    $idProvincia = $lugar['IDPROVINCIA'];
    $idCanton = $lugar['IDCANTON'];
    $idDistrito = $lugar['IDDISTRITO'];

    // Si la provincia no existe en el arreglo, la añadimos
    if (!isset($provincias[$idProvincia])) {
        $provincias[$idProvincia] = [
            'nombre' => $lugar['NOMBREPROVINCIA'],
            'cantones' => []
        ];
    }

    // Si el cantón no existe en la provincia, lo añadimos
    if (!isset($provincias[$idProvincia]['cantones'][$idCanton])) {
        $provincias[$idProvincia]['cantones'][$idCanton] = [
            'nombre' => $lugar['NOMBRECANTON'],
            'distritos' => []
        ];
    }

    // Añadir el distrito al cantón
    $provincias[$idProvincia]['cantones'][$idCanton]['distritos'][$idDistrito] = [
        'nombre' => $lugar['NOMBREDISTRITO']
    ];
}

// Obtener los IDs actuales de provincia, cantón y distrito del evento
$idProvinciaActual = $datosEvento['idProvincia'];
$idCantonActual = $datosEvento['idCanton'];
$idDistritoActual = $datosEvento['idDistrito'];

//Formato ver fecha
$fechaOriginal = $datosEvento['fecha'];
$partes = explode("/", $fechaOriginal);

if (count($partes) === 3) {
    $anio = strlen($partes[2]) === 2 ? '20' . $partes[2] : $partes[2];

    $fechaFormato = $anio . "-" . $partes[1] . "-" . $partes[0];
} else {
    $fechaFormato = "";
}

// Parsear la fecha y hora de inicio
$fechaHoraInicio = DateTime::createFromFormat('d/m/y H:i:s.u', $datosEvento['horaInicio']);
$horaInicioFormato = $fechaHoraInicio ? $fechaHoraInicio->format('H:i') : 'Formato no válido';

// Parsear la fecha y hora de fin
$fechaHoraFin = DateTime::createFromFormat('d/m/y H:i:s.u', $datosEvento['horaFin']);
$horaFinFormato = $fechaHoraFin ? $fechaHoraFin->format('H:i') : 'Formato no válido';


//POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombreEvento = $_POST['nombreEvento'];
    $fecha = $_POST['fecha'];
    $horaInicio = $_POST['hora_inicio'];
    $horaFin = $_POST['hora_fin'];
    $descripcion = $_POST['descripcion'];
    $lugar = $_POST['lugar'];
    $idProvincia = $_POST['provincia'];
    $idCanton = $_POST['canton'];
    $idDistrito = $_POST['distrito'];


    // Convertir la fecha y la hora al formato de Oracle
    $fechaFormat = date('Y-m-d', strtotime($fecha));
    $horaInicioFormat = date('Y-m-d H:i:s', strtotime($fechaFormat . ' ' . $horaInicio));
    $horaFinFormat = date('Y-m-d H:i:s', strtotime($fechaFormat . ' ' . $horaFin));


    // Validación de la imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $imagen = $_FILES['imagen'];
        $nombreImagen = $evento->uploadImagen($imagen);

        // Eliminar imagen anterior si existe
        if ($datosEvento && file_exists("../img/images_events/" . $datosEvento['imagen'])) {
            unlink("../img/images_events/" . $datosEvento['imagen']);
        }
    } else {
        $nombreImagen = $datosEvento['imagen'];
    }

    // Llamada al método para actualizar el evento
    $resultadoSP = $evento->updateEvento($idEvento, $lugar, $fechaFormat, $horaInicioFormat, $horaFinFormat, $descripcion, $nombreImagen, $idProvincia, $idCanton, $idDistrito, $nombreEvento);

    if ($resultadoSP == 1) {
        $_SESSION['mensaje'] = "Evento actualizado con éxito.";
    } else {
        $_SESSION['mensaje'] = "Error al actualizar el evento.";
    }

    header('Location: admin_events.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <!-- styles -->
    <?php $rutaCSS = '../css/admin_events.css';
    include '../include/template/header.php'; ?>
</head>

<body>
    <!-- Nav template -->
    <?php $enlaceActivo = 'admin_events';
    include '../include/template/nav.php'; ?>

    <main class="contenedor">

        <div class="btn_atras">
            <a href="admin_events.php" class="boton input-text">Atras</a>
        </div>

        <form class="formulario" method="POST" enctype="multipart/form-data">
            <section class="evento">
                <div class="evento__detalle">
                    <h2 class="centrar-texto">Editar evento</h2>
                    <!-- nombreEvento -->
                    <div class="campo">
                        <label for="nombreEvento">Nombre de evento:</label>
                        <input type="text" id="nombreEvento" name="nombreEvento"
                            value="<?php echo $datosEvento['nombreEvento']; ?>">
                    </div>
                    <!-- lugar -->
                    <div class="campo">
                        <label for="lugar">Lugar:</label>
                        <input type="text" id="lugar" name="lugar" value="<?php echo $respuesta['datos']['lugar']; ?>">
                    </div>
                    <!-- fecha -->
                    <div class="campo">
                        <label for="fecha">Fecha:</label>
                        <input type="date" id="fecha" name="fecha"
                            value="<?php echo htmlspecialchars($fechaFormato); ?>">
                    </div>

                    <!-- Hora inicio -->
                    <div class="campo">
                        <label for="hora_inicio">Hora de inicio:</label>
                        <input type="time" id="hora_inicio" name="hora_inicio"
                            value="<?php echo htmlspecialchars($horaInicioFormato); ?>">
                    </div>

                    <!-- Hora fin -->
                    <div class="campo">
                        <label for="hora_fin">Hora de fin:</label>
                        <input type="time" id="hora_fin" name="hora_fin"
                            value="<?php echo htmlspecialchars($horaFinFormato); ?>">
                    </div>

                    <!-- descripcion -->
                    <div class="campo">
                        <label for="descripcion">Descripción:</label>
                        <textarea id="descripcion" name="descripcion"
                            rows="4"><?php echo $datosEvento['descripcion']; ?></textarea>
                    </div>

                    <!-- Provincia -->
                    <div class="campo">
                        <label for="provincia">Provincia:</label>
                        <select id="provincia" name="provincia">
                            <?php foreach ($provincias as $idProvincia => $provincia): ?>
                                <option value="<?php echo $idProvincia; ?>" <?php echo $idProvinciaActual == $idProvincia ? 'selected' : ''; ?>>
                                    <?php echo $provincia['nombre']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Cantón -->
                    <div class="campo">
                        <label for="canton">Cantón:</label>
                        <select id="canton" name="canton">
                            <!-- Las opciones de cantón se cargarán mediante JS basadas en la provincia seleccionada -->
                        </select>
                    </div>

                    <!-- Distrito -->
                    <div class="campo">
                        <label for="distrito">Distrito:</label>
                        <select id="distrito" name="distrito">
                            <!-- Las opciones de distrito se cargarán mediante JS basadas en el cantón seleccionado -->
                        </select>
                    </div>

                    <!-- Imagen -->
                    <div id="formularioEvento" class="campo campo-imagen">
                        <label for="imagen">Imagen:</label>

                        <!-- Lógica condicional para mostrar la imagen -->
                        <?php if (file_exists("../img/images_events/" . $datosEvento['imagen'])): ?>
                            <img id="preview" src="../img/images_events/<?php echo $datosEvento['imagen']; ?>" alt="">
                        <?php else: ?>
                            <!-- Si la imagen no existe, muestra una imagen alternativa -->
                            <img id="preview" src="../img/images_events/no_disponible.webp" alt="Imagen no disponible">
                        <?php endif; ?>

                        <input type="file" id="imagen" name="imagen" accept="image/*">
                    </div>

                    <div class="campo centrar-texto botones_evento">
                        <button class="enviar" type="submit">Actualizar evento</button>
                        <a class="cancelar" href="#" onclick="window.history.back();">Cancelar</a>
                    </div>
                </div>
            </section>
        </form>
    </main>
    <!-- Footer -->
    <?php include '../include/template/footer.php'; ?>
    <!-- JS -->
    <script src="../js/evento.js"></script>
    <script>
    // variables
    var provincias = <?php echo json_encode($provincias); ?>;
    var provinciaActual = "<?php echo $idProvinciaActual; ?>";
    var cantonActual = "<?php echo $idCantonActual; ?>";
    var distritoActual = "<?php echo $idDistritoActual; ?>";

    document.addEventListener('DOMContentLoaded', function () {
        var selectProvincia = document.getElementById('provincia');
        var selectCanton = document.getElementById('canton');
        var selectDistrito = document.getElementById('distrito');

        // Cantones provincia seleccionada
        function actualizarCantones() {
            var cantones = provincias[selectProvincia.value]['cantones'];
            selectCanton.innerHTML = '';

            for (var idCanton in cantones) {
                var opcionCanton = document.createElement('option');
                opcionCanton.value = idCanton;
                opcionCanton.textContent = cantones[idCanton]['nombre'];
                selectCanton.appendChild(opcionCanton);
            }

            // cantón actual si está disponible
            if (cantonActual) {
                selectCanton.value = cantonActual;
            }

            actualizarDistritos();
        }

        // Cantón seleccionado
        function actualizarDistritos() {
            var distritos = provincias[selectProvincia.value]['cantones'][selectCanton.value]['distritos'];
            selectDistrito.innerHTML = '';

            for (var idDistrito in distritos) {
                var opcionDistrito = document.createElement('option');
                opcionDistrito.value = idDistrito;
                opcionDistrito.textContent = distritos[idDistrito]['nombre'];
                selectDistrito.appendChild(opcionDistrito);
            }

            // distrito actual si está disponible
            if (distritoActual) {
                selectDistrito.value = distritoActual;
            }
        }

        selectProvincia.addEventListener('change', actualizarCantones);
        selectCanton.addEventListener('change', actualizarDistritos);

        // selects con los valores actuales al cargar la página
        if (provinciaActual) {
            selectProvincia.value = provinciaActual;
            actualizarCantones();
        } else {
            actualizarCantones();
        }
    });
</script>

</body>

</html>