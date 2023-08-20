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


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idMascota = $_GET['id'];
    $nombreMascota = $_POST['nombre'];
    $descripcionMascota = $_POST['descripcion'];
    $idTipoMascota = $_POST['idTipoMascota'];
    $imagenMascota = $_FILES['imagen'];

    if ($_FILES['imagen']['tmp_name']) {
        $imagen = $_FILES['imagen'];
        $nombreImagen = $mascota->uploadImagen($imagen);
        $mascotaData = $mascota->getMascota($idMascota);

        if ($mascotaData && file_exists("img/images_pets/" . $mascotaData['imagen'])) {
            unlink("img/images_pets/" . $mascotaData['imagen']);
        }
    } else {
        $mascotaData = $mascota->getMascota($idMascota);
        $nombreImagen = $mascotaData['imagen'];
    }

    $mascota->updateMascota($idMascota, $nombreMascota, $descripcionMascota, $idTipoMascota, $nombreImagen);

    header('Location: profile_client.php');
    exit;
} else {
    if (isset($_GET['id'])) {
        $idMascota = $_GET['id'];
        $mascotaData = $mascota->getMascota($idMascota);

/* echo "<pre>";
print_r($mascotaData);
echo "</pre>"; */

        if (!$mascotaData) {
            header('Location: profile_client.php');
            exit;
        }
        $tiposMascota = $tipoMascota->getTipoMascotas();
    } else {
        header('Location: profile_client.php');
        exit;
    }
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
    <h1 class="centrar-texto">Editar Mascota</h1>
    <p>Editando mascota del Usuario: <?php echo $correoUsuario; ?>.</p>

    <div class="campo">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo $mascotaData['nombre']; ?>" required>
    </div>

    <div class="campo">
        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" rows="4" required><?php echo $mascotaData['descripcion']; ?></textarea>
    </div>

    <div class="campo">
        <label for="idTipoMascota">Tipo de Mascota:</label>
        <select id="idTipoMascota" name="idTipoMascota" required>
            <?php foreach ($tiposMascotaData as $tipoMascotaItem) { ?>
                <option value="<?php echo $tipoMascotaItem['idTipoMascota']; ?>"
                    <?php if ($tipoMascotaItem['idTipoMascota'] == $mascotaData['idTipoMascota']) { echo 'selected'; } ?>>
                    <?php echo $tipoMascotaItem['tipo']; ?>
                </option>
            <?php } ?>
        </select>
    </div>

    <div class="campo campo-imagen">
        <label for="imagen">Imagen:</label>
        <?php if (isset($mascotaData['imagen']) && file_exists("img/images_pets/" . $mascotaData['imagen'])): ?>
            <img id="preview" src="img/images_pets/<?php echo $mascotaData['imagen']; ?>" alt="Imagen actual">
        <?php else: ?>
            <img id="preview" src="img/no_disponible.webp" alt="Imagen no disponible">
        <?php endif; ?>
        <input type="file" id="imagen" name="imagen" accept="image/*">
    </div>

    <div class="campo centrar-texto botones_evento">
        <button class="enviar" type="submit">Guardar Cambios</button>
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