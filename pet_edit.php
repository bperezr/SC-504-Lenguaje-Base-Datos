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

$datosMascota = null;
$mensajeAlerta = "";

if (isset($_GET['id'])) {
    $idMascota = $_GET['id'];
    $respuesta = $mascota->getMascota($idMascota);
    if ($respuesta['resultado'] == 0) {
        $datosMascota = $respuesta['datos'];
    } else {
        header('Location: profile_client.php');
        exit;
    }
}
$mascotaData = $respuesta['datos'];

$tiposMascotaData = $tipoMascota->getTipoMascotas();
$tipos = $tiposMascotaData['datos'];

/* echo "<pre>";
print_r($mascotaData);
echo "</pre>";
 */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idMascota = $_GET['id'];
    $nombreMascota = $_POST['nombre'];
    $descripcionMascota = $_POST['descripcion'];
    $idTipoMascota = $_POST['idTipoMascota'];
    $imagenMascota = $_FILES['imagen'];

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $imagen = $_FILES['imagen'];
        $nombreImagen = $mascota->uploadImagen($imagen);

        // Eliminar imagen anterior si existe
        if ($mascotaData && file_exists("img/images_pets/" . $mascotaData['imagen'])) {
            unlink("img/images_pets/" . $mascotaData['imagen']);
        }
    } else {
        // Si no se sube una nueva imagen, mantener la imagen existente
        $nombreImagen = $mascotaData['imagen'];
    }

    // Llama a la función updateMascota para actualizar la mascota en la base de datos
    $resultado = $mascota->updateMascota($idMascota, $nombreMascota, $descripcionMascota, $nombreImagen, $idTipoMascota, $id);

    if ($resultado === 0) {
        header('Location: profile_client.php');
        exit;
    } else {
        $mensajeAlerta = "Error al actualizar la mascota. Por favor, inténtelo de nuevo.";
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
                    <p>Editando mascota del Usuario:
                        <?php echo $correoUsuario; ?>.
                    </p>

                    <div class="campo">
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" value="<?php echo $mascotaData['nombre']; ?>"
                            required>
                    </div>

                    <div class="campo">
                        <label for="descripcion">Descripción:</label>
                        <textarea id="descripcion" name="descripcion" rows="4"
                            required><?php echo $mascotaData['descripcion']; ?></textarea>
                    </div>

                    <div class="campo">
                        <label for="idTipoMascota">Tipo de Mascota:</label>
                        <select id="idTipoMascota" name="idTipoMascota" required>
                            <?php foreach ($tipos as $tipoMascotaItem) { ?>
                                <option value="<?php echo $tipoMascotaItem['IDTIPOMASCOTA']; ?>"
                                    <?php if ($mascotaData['idTipoMascota'] == $tipoMascotaItem['IDTIPOMASCOTA']) { echo 'selected'; } ?>>
                                    <?php if (isset($tipoMascotaItem['TIPO'])) {
                                        echo $tipoMascotaItem['TIPO'];
                                    } else {
                                        echo "Tipo no disponible";
                                    } ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="campo campo-imagen">
                        <label for="imagen">Imagen:</label>
                        <?php if (isset($mascotaData['imagen']) && file_exists("img/images_pets/" . $mascotaData['imagen'])): ?>
                            <img id="preview" src="img/images_pets/<?php echo $mascotaData['imagen']; ?>"
                                alt="Imagen actual">
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
    <!-- Mensaje -->
    <?php if (!empty($mensajeAlerta)) { ?>
        <div class="alerta">
            <?php echo $mensajeAlerta; ?>
        </div>
    <?php } ?>
</body>

</html>