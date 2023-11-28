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
    header("Location: ../acceso_denegado.php");
    exit();
}*/

require '../include/connections/connect.php';

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

        <?php foreach ($requeridos as $requerido): ?>
            <div class="campos-requeridos">
                <?php echo $requerido; ?>
            </div>
        <?php endforeach ?>

        <form class="formulario" method="POST" action="admin_events_new.php"
            enctype="multipart/form-data">
            <section class="evento">
                <div class="evento__detalle">
                    <h2 class="centrar-texto">Editar evento</h2>
                    <div class="campo">
                        <label for="nombreEvento">Nombre de evento:</label>
                        <input type="text" id="nombreEvento" name="nombreEvento" value="<?php echo $nombreEvento; ?>">
                    </div>
                    <div class="campo">
                        <label for="lugar">Lugar:</label>
                        <input type="text" id="lugar" name="lugar" value="<?php echo $lugar; ?>">
                    </div>
                    <div class="campo">
                        <label for="fecha">Fecha:</label>
                        <input type="date" id="fecha" name="fecha" value="<?php echo $fecha; ?>">
                    </div>
                    <div class="campo">
                        <label for="hora_inicio">Hora de inicio:</label>
                        <input type="time" id="hora_inicio" name="hora_inicio" value="<?php echo $horaInicio; ?>">
                    </div>
                    <div class="campo">
                        <label for="hora_fin">Hora de fin:</label>
                        <input type="time" id="hora_fin" name="hora_fin" value="<?php echo $horaFin; ?>">
                    </div>
                    <div class="campo">
                        <label for="descripcion">Descripción:</label>
                        <textarea id="descripcion" name="descripcion" rows="4"
                            required><?php echo $descripcion; ?></textarea>
                    </div>
                    <div class="campo">
                        <label for="provincia">Provincia</label>
                        <select type="number" name="idProvincia" id="idProvincia">
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option  value="' . $row["idProvincia"] . '">' . $row["nombre"] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="campo">
                        <label for="canton">Cantón</label>
                        <select type="number" name="idCanton" id="idCanton">
                            <?php
                            if ($resultCanton->num_rows > 0) {
                                while ($row = $resultCanton->fetch_assoc()) {
                                    echo '<option value="' . $row["idCanton"] . '">' . $row["nombre"] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="campo">
                        <label for="distrito">Distrito</label>
                        <select type="number" name="idDistrito" id="idDistrito">
                            <?php
                            if ($resultDistrito->num_rows > 0) {
                                while ($row = $resultDistrito->fetch_assoc()) {
                                    echo '<option value="' . $row["idDistrito"] . '">' . $row["nombre"] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div id="formularioEvento" class="campo campo-imagen">
                        <label for="imagen">Imagen:</label>
                        <img id="preview" src="../img/no_disponible.webp" alt="no_image">
                        <input type="file" id="imagen" name="imagen" accept="image/*" required>
                    </div>
                    <div class="campo centrar-texto botones_evento">
                        <button class="enviar" type="submit">Crear evento</button>
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
</body>

</html>