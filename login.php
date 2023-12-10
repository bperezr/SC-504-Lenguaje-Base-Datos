<?php
session_start();

if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    $correoUsuario = $usuario['correo'];
    $rolUsuario = $usuario['idRol'];
}

require_once 'include/database/db_colaborador.php';
require_once 'include/database/db_cliente.php';

$colaborador = new Colaborador();
$cliente = new Cliente();
$mensajeError = '';
$resultadoSP = 0;
$resultadoObtenerCorreo = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['signupForm'])) {
        $correo = $_POST['correo'];
        $contrasena = $_POST['contrasena'];
        $contrasena2 = $_POST['contrasena2'];

        // Verificar que el correo no tiene el dominio @happypaws.com
        if (strpos($correo, '@happypaws.com') !== false) {
            $mensajeError = "Error - No puedes registrarte como cliente con este correo.";
        } elseif ($contrasena !== $contrasena2) {
            $mensajeError = "Error - Las contraseñas no coinciden. Por favor, inténtalo de nuevo.";
        } else {
            $correoExiste = $cliente->verificarCorreoExistente($correo);

            if ($correoExiste != 0) {
                $cliente->insertClienteNuevo($correo, $contrasena, $resultadoSP);

                if ($resultadoSP == 0) {
                    $mensajeError = "¡Registro exitoso!";
                } else {
                    $mensajeError = "¡Error al registrar el usuario! SQLCODE: " . $resultadoSP;
                }
            } else {
                $mensajeError = "El correo ya esta registrado. Por favor, usa otro correo.";
            }
        }
    }
    if (isset($_POST['loginForm'])) {
        $correo = $_POST['email'];
        $contrasena = $_POST['pswd'];

        // Verificar si el correo tiene el dominio @happypaws.com
        if (strpos($correo, '@happypaws.com') !== false) {
            // Es un colaborador
            $resultadoColaborador = $colaborador->validarCredenciales($correo, $contrasena);

            if ($resultadoColaborador === 0) {
                $colaboradorInfo = $colaborador->obtenerColaboradorPorCorreo($correo);


                if ($colaboradorInfo['datos']['idRol'] === 1) {
                    $_SESSION['usuario'] = array(
                        'rol' => 'admin',
                        'id' => $colaboradorInfo['datos']['idColaborador'],
                        'idRol' => $colaboradorInfo['datos']['idRol'],
                        'correo' => $correo
                    );
                } else {
                    $_SESSION['usuario'] = array(
                        'rol' => 'colaborador',
                        'id' => $colaboradorInfo['datos']['idColaborador'],
                        'idRol' => $colaboradorInfo['datos']['idRol'],
                        'correo' => $correo
                    );
                }

                echo "<pre>";
                print_r($_SESSION['usuario']);
                echo "</pre>";

                if ($colaboradorInfo['datos']['idRol'] == 1) {
                    header("Location: admin/admin_index.php");
                    exit();
                } elseif ($colaboradorInfo['datos']['idRol'] == 2) {
                    header("Location: medical/medical_index.php");
                    exit();
                }
            } else {
                $mensajeError = "Usuario o contraseña incorrecta.";
            }
        } else {
            // Es un clientes
            $resultadoSP = $cliente->validarCredenciales($correo, $contrasena);

            if ($resultadoSP === 0) {
                $idCliente = 0;
                $idRol = 0;
                $nombre = "";
                $apellido1 = null;
                $apellido2 = null;
                $clienteInfo = $cliente->obtenerClientePorCorreo($correo);

                $_SESSION['usuario'] = array(
                    'rol' => 'cliente',
                    'id' => $clienteInfo['datos']['idCliente'],
                    'idRol' => $clienteInfo['datos']['idRol'],
                    'correo' => $correo,
                    'nombre' => $clienteInfo['datos']['nombre'],
                    'apellido1' => $clienteInfo['datos']['apellido1'],
                    'apellido2' => $clienteInfo['datos']['apellido2']
                );

                $resultadoValidacion = $cliente->camposNull($correo);
                if ($resultadoValidacion === 0) {
                    header("Location: profile_client_new.php");
                    exit();
                } else {
                    header("Location: index.php");
                    exit();
                }

            } else {
                $mensajeError = "Usuario o contraseña incorrecta.";
            }
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
                <input type="text" id="signupEmail" name="correo" placeholder="Correo" required>
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

        </form>



    </div>
    <!-- JS -->
    <script src="js/singUp_login.js"></script>
</body>

</html>