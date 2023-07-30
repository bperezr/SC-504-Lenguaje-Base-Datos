<!DOCTYPE html>
<html lang="es">

<head>
    <!-- styles -->
    <?php $rutaCSS = 'css/admin_medicals.css';
    include 'include/template/header.php'; ?>
</head>

<body>
    <!-- Nav template -->
    <?php $enlaceActivo = 'admin_medicals';
    include 'include/template/nav_admin.php'; ?>

    <main class="contenedor">
        <section class="evento">
            <div class="evento__detalle">
                <h2 class="centrar-texto">Editar nuevo Médico</h2>
                <form id="formularioEvento" class="formulario-evento" enctype="multipart/form-data">
                    <div class="campo">
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" required>
                    </div>
                    <div class="campo">
                        <label for="especialidad">Especialidad:</label>
                        <input type="text" id="especialidad" name="especialidad" required>
                    </div>
                    <div class="campo">
                        <label for="descripcion">Descripción:</label>
                        <textarea id="descripcion" name="descripcion" rows="4" required></textarea>
                    </div>
                    <div class="campo campo-imagen">
                        <label for="imagen">Imagen:</label>
                        <img id="preview" src="img/no_disponible.webp" alt="no_image">
                        <input type="file" id="imagen" name="imagen" accept="image/*" required>
                    </div>
                    <div class="campo centrar-texto botones_evento">
                        <button class="enviar" type="submit">Agregar Médico</button>
                        <a class="cancelar" href="#" onclick="window.history.back();">Cancelar</a>
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