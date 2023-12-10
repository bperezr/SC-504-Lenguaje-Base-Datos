<?php
session_start();

if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    $correoUsuario = $usuario['correo'];
    $rolUsuario = $usuario['idRol'];
    $rol = $usuario['rol'];
    $id = $usuario['id'];
}

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['idRol'] != 3) {
    header("Location: acceso_denegado.php");
    exit();
}

require_once 'include/database/db_cliente.php';
require_once 'include/database/db_lugar.php';

$cliente = new Cliente();
$lugares = new Lugar();

$datosCliente = null;
$mensajeAlerta = "";

$respuesta = $cliente->getCliente($id);
if ($respuesta['resultado'] == 0) {
    $datosCliente = $respuesta['datos'];
} else {
    // Redireccionar si no se encuentra el cliente
    header('Location: profile_client.php');
    $_SESSION['mensaje'] = "No se encontró el cliente.";
    exit;
}

$lugares = $lugares->getLugares();
$lugaresDatos = $lugares['datos'];
$lugaresResultado = $lugares['resultado'];

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idCliente = $id;
    $nombre = $_POST['nombre'];
    $apellido1 = $_POST['apellido1'];
    $apellido2 = $_POST['apellido2'];
    $telefono = $_POST['telefono'];
    $domicilio = $_POST['domicilio'];
    $idProvincia = $_POST['provincia'];
    $idCanton = $_POST['canton'];
    $idDistrito = $_POST['distrito'];

    // Verificar si se ha subido una nueva imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
        $imagen = $_FILES['imagen'];
        $nombreImagen = $cliente->uploadImagen($imagen);

        // Eliminar la imagen anterior si existe
        if ($datosCliente && file_exists("img/images_clients/" . $datosCliente['imagen'])) {
            unlink("img/images_clients/" . $datosCliente['imagen']);
        }
    } else {
        // Si no se sube una nueva imagen, mantener la imagen existente
        $nombreImagen = $datosCliente['imagen'];
    }

    // Llama a la función updateClienteNuevo para actualizar los datos del cliente
    $resultado = $cliente->updateClienteNuevo($idCliente, $nombre, $apellido1, $apellido2, $telefono, $domicilio, $idProvincia, $idCanton, $idDistrito, $nombreImagen);

    if ($resultado === 0) {
        header('Location: profile_client.php');
        exit;
    } else {
        $mensajeAlerta = 'Error al actualizar los datos del cliente.';
    }
}

$nombre = $datosCliente['nombre'];
$apellido1 = $datosCliente['apellido1'];
$apellido2 = $datosCliente['apellido2'];
$telefono = $datosCliente['telefono'];
$domicilio = $datosCliente['domicilio'];
$imagen = $datosCliente['imagen'];

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <!-- styles -->
    <?php $rutaCSS = 'css/admin_workers.css';
    include 'include/template/header.php'; ?>
</head>

<body>

    <main class="contenedor">

        <section class="evento">
            <div class="evento__detalle">

                <form id="formularioEvento" class="formulario-evento" enctype="multipart/form-data" method="POST">

                    <h1 class="centrar-texto">Completar Perfil</h1>
                    <p>Usuario:
                        <?php echo $correoUsuario; ?>, llene los campos faltantes para completar su perfil.
                    </p>

                    <div class="campo">
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>" required>
                    </div>

                    <div class="campo">
                        <label for="apellido1">Apellido 1:</label>
                        <input type="text" id="apellido1" name="apellido1" value="<?php echo $apellido1; ?>" required>
                    </div>

                    <div class="campo">
                        <label for="apellido2">Apellido 2:</label>
                        <input type="text" id="apellido2" name="apellido2" value="<?php echo $apellido2; ?>" required>
                    </div>

                    <div class="campo">
                        <label for="telefono">Telefono:</label>
                        <input type="number" id="telefono" name="telefono" value="<?php echo $telefono; ?>" required>
                    </div>

                    <div class="campo">
                        <label for="domicilio">Domicilio:</label>
                        <textarea id="domicilio" name="domicilio" rows="4" required><?php echo $domicilio; ?></textarea>
                    </div>

                    <!-- Provincia -->
                    <div class="campo">
                        <label for="provincia">Provincia:</label>
                        <select id="provincia" name="provincia">
                            <?php foreach ($provincias as $idProvincia => $provincia): ?>
                                <option value="<?php echo $idProvincia; ?>">
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
                    <div id="formularioEvento" class="campo campo-imagen">
                        <label for="imagen">Imagen:</label>
                        <?php if (file_exists("img/images_clients/" . $imagen)): ?>
                            <img id="preview" src="img/images_clients/<?php echo $imagen; ?>" alt="Imagen actual">
                        <?php else: ?>
                            <img id="preview" src="img/no_disponible.webp" alt="Imagen no disponible">
                        <?php endif; ?>
                        <input type="file" id="imagen" name="imagen" accept="image/*">
                    </div>


                    <div class="campo centrar-texto botones_evento">
                        <button class="enviar" type="submit">Enviar</button>
                    </div>

                </form>
            </div>
        </section>
    </main>
    <!-- Footer -->
    <?php include 'include/template/footer.php'; ?>
    <!-- JS -->
    <script src="js/clienteNuevo.js"></script>
    <!--  -->
    <script>
        // Variables
        var provincias = <?php echo json_encode($provincias); ?>;

        document.addEventListener('DOMContentLoaded', function () {
            var selectProvincia = document.getElementById('provincia');
            var selectCanton = document.getElementById('canton');
            var selectDistrito = document.getElementById('distrito');

            // Actualizar cantones basado en la provincia seleccionada
            function actualizarCantones() {
                var cantones = provincias[selectProvincia.value]['cantones'];
                selectCanton.innerHTML = '';

                for (var idCanton in cantones) {
                    var opcionCanton = document.createElement('option');
                    opcionCanton.value = idCanton;
                    opcionCanton.textContent = cantones[idCanton]['nombre'];
                    selectCanton.appendChild(opcionCanton);
                }

                actualizarDistritos();
            }

            // Actualizar distritos basado en el cantón seleccionado
            function actualizarDistritos() {
                var distritos = provincias[selectProvincia.value]['cantones'][selectCanton.value]['distritos'];
                selectDistrito.innerHTML = '';

                for (var idDistrito in distritos) {
                    var opcionDistrito = document.createElement('option');
                    opcionDistrito.value = idDistrito;
                    opcionDistrito.textContent = distritos[idDistrito]['nombre'];
                    selectDistrito.appendChild(opcionDistrito);
                }
            }

            selectProvincia.addEventListener('change', actualizarCantones);
            selectCanton.addEventListener('change', actualizarDistritos);

            // Inicializar los selects con los primeros valores disponibles
            if (Object.keys(provincias).length > 0) {
                selectProvincia.value = Object.keys(provincias)[0];
                actualizarCantones();
            }
        });
    </script>
    <!-- Mensaje -->
    <?php if (!empty($mensajeAlerta)) { ?>
        <div class="alerta">
            <?php echo $mensajeAlerta; ?>
        </div>
    <?php } ?>
</body>

</html>