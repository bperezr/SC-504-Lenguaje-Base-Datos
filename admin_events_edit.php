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
        <section class="evento">
            <div class="evento__detalle">
                <h2 class="centrar-texto">Editar evento</h2>
                <form id="formularioEvento" class="formulario-evento" enctype="multipart/form-data">
                    <div class="campo">
                        <label for="titulo">Título del evento:</label>
                        <input type="text" id="titulo" name="titulo" required>
                    </div>
                    <div class="campo">
                        <label for="fecha">Fecha:</label>
                        <input type="date" id="fecha" name="fecha" required>
                    </div>
                    <div class="campo">
                        <label for="hora_inicio">Hora de inicio:</label>
                        <input type="time" id="hora_inicio" name="hora_inicio" required>
                    </div>
                    <div class="campo">
                        <label for="hora_fin">Hora de fin:</label>
                        <input type="time" id="hora_fin" name="hora_fin" required>
                    </div>
                    <div class="campo">
                        <label for="lugar">Lugar:</label>
                        <input type="text" id="lugar" name="lugar" required>
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
                        <button class="enviar" type="submit">Crear evento</button>
                        <a class="cancelar" href="#" onclick="window.history.back();">Cancelar</a>
                    </div>
                </form>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <?php include 'include/template/footer.php'; ?>
    <!-- JS -->
    <script src=""></script>
</body>

</html>