<?php

require_once 'include/database/db_colaborador.php'; // Si tienes una clase para Colaborador
require_once 'include/database/db_cliente.php'; // Si tienes una clase para Cliente

$colaborador = new Colaborador();
$cliente = new Cliente();
$mensajeError = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["signupEmail"]) && isset($_POST["signupPassword"]) && isset($_POST["signupConfirmPassword"])) {

        $email = $_POST["signupEmail"];
        $password = $_POST["signupPassword"];
        $confirmPassword = $_POST["signupConfirmPassword"];

        if ($password !== $confirmPassword) {
            $mensajeError = "Las contraseñas no coinciden.";
        } else {

            $cliente->insertClienteNuevo($email, $password);

            header('Location: index.php');
            exit;
        }

    } elseif (isset($_POST["loginEmail"]) && isset($_POST["loginPassword"])) {
        $email = $_POST["loginEmail"];
        $password = $_POST["loginPassword"];

    }
}

/* if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signupForm'])) {

    $correo = $_POST['email'];
    $contrasena = $_POST['pswd'];

    $clienteData = $cliente->getClientePorCorreo($correo);
    echo "Valido";

    if ($clienteData) {
        // El correo ya está registrado
        $mensajeError = "El correo ya está registrado. Por favor, use otro correo.";
        echo "Ya existe";
    } else {
        // Realiza el registro como cliente
        if ($cliente->insertClienteNuevo($correo, $contrasena)) {
            $registroExitoso = true;
            echo "exito";

            // Redirige al cliente a la página de inicio de sesión
        } else {
            $mensajeError = "Hubo un problema al registrar el cliente. Por favor, inténtalo nuevamente.";
            echo "problema";
        }
    }
} elseif (isset($_POST['loginForm'])) {
    // Inicio de sesión
    $correo = $_POST['email'];
    $contrasena = $_POST['pswd'];

    // Verifica si es colaborador o cliente
    $colaboradorData = $colaborador->getColaboradorPorCorreo($correo);
    $clienteData = $cliente->getClientePorCorreo($correo);

    if ($colaboradorData && password_verify($contrasena, $colaboradorData['contrasena'])) {
        // Inicio de sesión exitoso para colaborador
        // Guardar datos de la sesión o redirigir
    } elseif ($clienteData && password_verify($contrasena, $clienteData['contrasena'])) {
        // Inicio de sesión exitoso para cliente
        // Guardar datos de la sesión o redirigir
    } else {
        // Credenciales inválidas, mostrar mensaje de error
        $mensajeError = "Credenciales inválidas. Por favor, verifica tu correo y contraseña.";
    }
} */
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
                <input type="email" id="signupEmail" name="email" placeholder="Correo" required>
                <input type="password" id="signupPassword" name="pswd" placeholder="Contraseña" required>
                <input type="password" id="signupConfirmPassword" name="confirmPswd" placeholder="Repita la contraseña"
                    required>
                <div id="StrengthDisp"></div>
                <button type="submit">Registrarse</button>
            </form>
        </div>

<!--         <div class="login">
            <form id="loginForm" method="POST">
                <label for="chk" aria-hidden="true">Iniciar</label>
                <input type="email" id="loginEmail" name="email" placeholder="Correo" required>
                <input type="password" id="loginPassword" name="pswd" placeholder="Contraseña" required>
                <button type="submit">Iniciar</button>
            </form>
        </div> -->
    </div>

    <!-- <script src="js/singUp_login.js"></script> -->
</body>

</html>