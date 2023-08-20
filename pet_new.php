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
require_once 'include/database/db_mascota.php';
require_once 'include/database/db_tipomascota.php';

$mascota = new Mascota();
$tipoMascota = new TipoMascota();

$tiposMascotaData = $tipoMascota->getTipoMascotas();

echo "<pre>";
print_r($tiposMascotaData);
echo "</pre>";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombreMascota = $_POST['nombre'];
    $descripcionMascota = $_POST['descripcion'];
    $idTipoMascota = $_POST['idTipoMascota'];
    $idCliente = $id;
    $imagenMascota = $_FILES['imagen'];

    $nombreImagen = $mascota->uploadImagen($imagenMascota);
    $mascota->insertMascota($nombreMascota, $descripcionMascota, $idTipoMascota, $idCliente, $nombreImagen);

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

                <form id="formularioMascota" class="formulario-mascota" enctype="multipart/form-data" method="POST">

                    <h1 class="centrar-texto">Agregar Mascota</h1>
                    <p>Nueva mascota del Usuario:
                        <?php echo $correoUsuario; ?>.
                    </p>

                    <div class="campo">
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" required>
                    </div>

                    <div class="campo">
                        <label for="descripcion">Descripción:</label>
                        <textarea id="descripcion" name="descripcion" rows="4" required></textarea>
                    </div>

                    <div class="campo">
                        <label for="descripcion">Tipo de Mascota:</label>
                        <select id="idTipoMascota" name="idTipoMascota" required>
                            <?php foreach ($tiposMascotaData as $tipoMascotaItem) { ?>
                                <option value="<?php echo $tipoMascotaItem['idTipoMascota']; ?>">
                                    <?php echo $tipoMascotaItem['tipo']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div id="formularioMascota" class="campo campo-imagen">
                        <label for="imagen">Imagen:</label>
                        <img id="preview" src="img/no_disponible.webp" alt="no_image">
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
</body>

</html>