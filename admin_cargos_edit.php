<?php
require_once 'include/database/db_cargo.php';

$cargo = new Cargo();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_GET['id'];
    $nuevoCargo = $_POST['cargo']; 
    $cargo->updateCargo($id, $nuevoCargo);  // Agregado para actualizar el cargo
    header('Location: admin_cargos.php');  // Redirigir después de la actualización
    exit;
} else {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $cargoData = $cargo->getCargo($id);
        if (!$cargoData) {
            header('Location: admin_cargos.php');
            exit;
        }
    } else {
        header('Location: admin_cargos.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <!-- styles -->
    <?php $rutaCSS = 'css/admin_workers.css';
    include 'include/template/header.php'; ?>
</head>

<body>
    <!-- Nav template -->
    <?php $enlaceActivo = 'admin_cargos';
    include 'include/template/nav_admin.php'; ?>

    <main class="contenedor">

        <div class="btn_atras">
            <a href="admin_cargos.php" class="boton input-text">Atras</a>
        </div>

        <section class="evento">
            <div class="evento__detalle">
                <h2 class="centrar-texto">Editar Cargos</h2>
                <form id="formularioEvento" class="formulario-evento" enctype="multipart/form-data" method="POST">
                    <div class="campo">
                        <label for="nombre">Cargo:</label>
                        <input type="text" id="cargo" name="cargo" value="<?php echo $cargoData['cargo']; ?>"
                            required>
                    </div>                  
                    <div class="campo centrar-texto botones_evento">
                        <button class="enviar" type="submit">Guardar Cambios</button>
                        <a class="cancelar" href="admin_cargos.php">Cancelar</a>
                    </div>
                </form>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <?php include 'include/template/footer.php'; ?>
    <!-- JS -->
    <script src="js/medico.js"></script>
</body>

</html>
