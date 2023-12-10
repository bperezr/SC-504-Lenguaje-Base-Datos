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

/*  */
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

// Obtener los IDs actuales de provincia, cantón y distrito del evento
$idProvinciaActual = $datosCliente['idProvincia'];
$idCantonActual = $datosCliente['idCanton'];
$idDistritoActual = $datosCliente['idDistrito'];

$nombre = $datosCliente['nombre'];
$apellido1 = $datosCliente['apellido1'];
$apellido2 = $datosCliente['apellido2'];
$telefono = $datosCliente['telefono'];
$domicilio = $datosCliente['domicilio'];
$imagen = $datosCliente['imagen'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $apellido1 = $_POST['apellido1'];
    $apellido2 = $_POST['apellido2'];
    $telefono = $_POST['telefono'];
    $domicilio = $_POST['domicilio'];
    $idProvincia = $_POST['provincia'];
    $idCanton = $_POST['canton'];
    $idDistrito = $_POST['distrito'];
    $imagenCliente = $_FILES['imagen'];

    // Validación de la imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $imagen = $_FILES['imagen'];
        $nombreImagen = $cliente->uploadImagen($imagen);

        // Eliminar imagen anterior si existe
        if ($datosCliente && file_exists("img/images_clients/" . $datosCliente['imagen'])) {
            unlink("img/images_clients/" . $datosCliente['imagen']);
        }
    } else {
        $nombreImagen = $datosCliente['imagen'];
    }

    // Llama a la función updateCliente para actualizar el cliente en la base de datos
    $resultado = $cliente->updateCliente($id, $nombre, $apellido1, $apellido2, $telefono, $domicilio, $idProvincia, $idCanton, $idDistrito, $rolUsuario, $correoUsuario);

    if ($resultadoSP == 0) {
        $_SESSION['mensaje'] = "Cliente actualizado con éxito.";
    } else {
        $_SESSION['mensaje'] = "Error al actualizar el cliente.";
    }

    header('Location: profile_client.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <!-- styles -->
    <?php $rutaCSS = 'css/client_profile.css';
    include 'include/template/header.php'; ?>
</head>

<body>
    <!-- Nav template -->
    <?php
    $enlaceActivo = 'perfil';
    include 'include/template/nav.php';
    ?>

    <main class="contenedor">


        <div class="btn_atras">
            <a href="profile_client.php" class="boton input-text">Atras</a>
        </div>

        <section class="evento">
            <div class="evento__detalle">

                <form id="formularioEvento" class="formulario-evento" enctype="multipart/form-data" method="POST">

                    <h1 class="centrar-texto">Editar Perfil</h1>
                    <p>Usuario:
                        <?php echo $correoUsuario; ?>.
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
                        <label class="telefono" for="telefono">Telefono:</label>
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
                        <a class="cancelar" href="#" onclick="window.history.back();">Cancelar</a>
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