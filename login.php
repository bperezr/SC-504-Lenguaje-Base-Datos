<?php
require_once 'include/database/db_colaborador.php';
require_once 'include/database/db_cliente.php';

$colaborador = new Colaborador();
$cliente = new Cliente();
$mensajeError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['signupForm'])) {
        $correo = $_POST['correo'];
        $contrasena = $_POST['contrasena'];
        $contrasena2 = $_POST['contrasena2'];

        if ($contrasena !== $contrasena2) {
            $mensajeError = "Error - Las contraseñas no coinciden. Por favor, inténtalo de nuevo.";
        } else {
            $correoExiste = $cliente->verificarCorreoExistente($correo);

            if ($correoExiste) {
                $mensajeError = "Error - El correo ya existe. Por favor, usa otro correo.";
            } else {
                $cliente->insertClienteNuevo($correo, $contrasena);
                $mensajeError = "¡Registro exitoso!";
                $registroCorrecto = true;

                if ($cliente->camposNull($correo)) {
                    header("Location: profile.php");
                    exit();
                } else {
                    header("Location: index.php");
                    exit();
                }
            }
        }
    } elseif (isset($_POST['loginForm'])) {
        $correo = $_POST['email'];
        $contrasena = $_POST['pswd'];

        $usuarioAutenticado = $cliente->validarCredenciales($correo, $contrasena);

        if ($usuarioAutenticado) {
            if ($cliente->camposNull($correo)) {
                header("Location: profile.php");
                exit();
            } else {
                header("Location: index.php");
                exit();
            }
        } else {
            // Autenticación fallida
            $mensajeError = "Error - Credenciales incorrectas.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <!-- styles -->
    <?php $rutaCSS = 'css//singUp_login.css';
    include 'include/template/header.php'; ?>
</head>

<body>

    <div class="main">
        <input type="checkbox" id="chk" aria-hidden="true">

        <div class="contenedor logo">
            <a href="index.php"><img src="img/logo_color.svg" alt="logo"></a>
        </div>

        <div class="signup error">
            <p class="error-message">
                <?php echo $mensajeError; ?>
            </p>
        </div>

        <div class="signup">
            <form id="signupForm" method="POST">
                <label for="chk" aria-hidden="true">Registrarse</label>
                <input type="correo" id="signupEmail" name="correo" placeholder="Correo" required>
                <input type="password" id="contrasena" name="contrasena" placeholder="Contraseña" required>
                <input type="password" id="contrasena2" name="contrasena2" placeholder="Repita la contraseña" required>
                <button type="submit" name="signupForm">Registrarse</button>
            </form>
        </div>

        <div class="login">
            <form id="loginForm" method="POST">
                <label for="chk" aria-hidden="true">Iniciar</label>
                <input type="email" id="loginEmail" name="email" placeholder="Correo" required>
                <input type="password" id="loginPassword" name="pswd" placeholder="Contraseña" required>
                <button type="submit" name="loginForm">Iniciar</button>
            </form>
        </div>

    </div>
</body>

</html>