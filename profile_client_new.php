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
$lugar = new Lugar();

$provincias = $lugar->getProvincias();
$cantones = $lugar->getCantones();
$distritos = $lugar->getDistritos();

$mensajeError = '';

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

    if ($_FILES['imagen']['tmp_name']) {
        $imagen = $_FILES['imagen'];
        $nombreImagen = $cliente->uploadImagen($imagen);
        $clienteData = $cliente->getCliente($id);

        if ($clienteData && file_exists("img/images_clients/" . $clienteData['imagen'])) {
            unlink("img/images_workers/" . $clienteData['imagen']);
        }
    } else {
        $clienteData = $cliente->getCliente($id);
        $nombreImagen = $clienteData['imagen'];
    }


    if ($cliente->updateClienteNuevo($idCliente, $nombre, $apellido1, $apellido2, $telefono, $domicilio, $idProvincia, $idCanton, $idDistrito, $nombreImagen)) {
        header('Location: profile_client.php');
        exit;
    } else {
        $mensajeError = 'Error al actualizar los datos del cliente.';
    }
}

$clienteData = $cliente->getCliente($id);
/* echo "<pre>";
print_r($clienteData);
echo "</pre>"; */

$nombre = $clienteData['nombre'];
$apellido1 = $clienteData['apellido1'];
$apellido2 = $clienteData['apellido2'];
$telefono = $clienteData['telefono'];
$domicilio = $clienteData['domicilio'];
$idProvincia = $clienteData['idProvincia'];
$idCanton = $clienteData['idCanton'];
$idDistrito = $clienteData['idDistrito'];
$imagen = $clienteData['imagen'];
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
                        <input type="text" id="nombre" name="nombre" value="<?php echo $clienteData['nombre']; ?>"
                            required>
                    </div>

                    <div class="campo">
                        <label for="apellido1">Apellido 1:</label>
                        <input type="text" id="apellido1" name="apellido1"
                            value="<?php echo $clienteData['apellido1']; ?>" required>
                    </div>

                    <div class="campo">
                        <label for="apellido2">Apellido 2:</label>
                        <input type="text" id="apellido2" name="apellido2"
                            value="<?php echo $clienteData['apellido2']; ?>" required>
                    </div>

                    <div class="campo">
                        <label for="telefono">Telefono:</label>
                        <input type="number" id="telefono" name="telefono"
                            value="<?php echo $clienteData['telefono']; ?>" required>
                    </div>

                    <div class="campo">
                        <label for="domicilio">Domicilio:</label>
                        <textarea id="domicilio" name="domicilio" rows="4"
                            required><?php echo $clienteData['domicilio']; ?></textarea>
                    </div>

                    <div class="campo">
                        <label for="provincia">Provincia:</label>
                        <select id="provincia" name="provincia" required>
                            <?php foreach ($provincias as $provincia) { ?>
                                <option value="<?php echo $provincia['idProvincia']; ?>"><?php echo $provincia['nombre']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="campo">
                        <label for="canton">Cantón:</label>
                        <select id="canton" name="canton" required>
                            <?php foreach ($cantones as $canton) { ?>
                                <option value="<?php echo $canton['idCanton']; ?>"><?php echo $canton['nombre']; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="campo">
                        <label for="distrito">Distrito:</label>
                        <select id="distrito" name="distrito" required>
                            <?php foreach ($distritos as $distrito) { ?>
                                <option value="<?php echo $distrito['idDistrito']; ?>"><?php echo $distrito['nombre']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div id="formularioEvento" class="campo campo-imagen">
                        <label for="imagen">Imagen:</label>
                        <?php if (file_exists("img/images_clients/" . $clienteData['imagen'])): ?>
                            <img id="preview" src="img/images_clients/<?php echo $clienteData['imagen']; ?>"
                                alt="Imagen actual">
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
</body>

</html>