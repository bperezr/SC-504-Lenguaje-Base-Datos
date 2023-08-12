<?php
session_start();

if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    $correoUsuario = $usuario['correo'];
    $rolUsuario = $usuario['idRol'];
}

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['idRol'] != 3) {
    header("Location: acceso_denegado.php");
    exit();
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
    <?php
    $enlaceActivo = 'perfil';
    $nombreUsuario = $correoUsuario;
    $rol = $rolUsuario;
    include 'include/template/nav.php';
    ?>

    <main class="contenedor">

        <section class="evento">
            <div class="evento__detalle">

                <form id="formularioEvento" class="formulario-evento" enctype="multipart/form-data" method="POST">

                    <h1 class="centrar-texto">Perfil de Usuario</h1>

                    <div class="campo">
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" required>
                    </div>

                    <div class="campo">
                        <label for="apellido1">Apellido 1:</label>
                        <input type="text" id="apellido1" name="apellido1" required>
                    </div>

                    <div class="campo">
                        <label for="apellido2">Apellido 2:</label>
                        <input type="text" id="apellido2" name="apellido2" required>
                    </div>

                    <div class="campo">
                        <label for="telefono">Telefono:</label>
                        <input type="number" id="telefono" name="telefono" required>
                    </div>

                    <div class="campo">
                        <label for="correo">Correo:</label>
                        <input type="text" id="correo" name="correo" required readonly>
                    </div>

                    <div class="campo">
                        <label for="contrasena">Contraseña:</label>
                        <input type="password" id="contrasena" name="contrasena" required>
                    </div>

                    <div class="campo">
                        <!--                         <label for="contrasena">Dirección:</label>
                        <textarea id="mensaje" name="mensaje" class="input-text" placeholder="Ingrese su mensaje">
                    </textarea> -->
                    </div>

                    <div class="campo">
                        <label for="rol">Provincia:</label>
                        <select id="rol" name="rol" required>
                            <?php foreach ($colaborador->getRoles() as $rol): ?>
                                <option value="<?php echo $rol['idRol']; ?>"><?php echo $rol['nombreRol']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="campo">
                        <label for="rol">Canton:</label>
                        <select id="rol" name="rol" required>
                            <?php foreach ($colaborador->getRoles() as $rol): ?>
                                <option value="<?php echo $rol['idRol']; ?>"><?php echo $rol['nombreRol']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="campo">
                        <label for="rol">Distrito:</label>
                        <select id="rol" name="rol" required>
                            <?php foreach ($colaborador->getRoles() as $rol): ?>
                                <option value="<?php echo $rol['idRol']; ?>"><?php echo $rol['nombreRol']; ?></option>
                            <?php endforeach; ?>
                        </select>
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
</body>

</html>