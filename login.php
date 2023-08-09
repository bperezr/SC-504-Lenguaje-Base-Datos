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

        <div class="signup">
            <form id="signupForm">
                <label for="chk" aria-hidden="true">Registrarse</label>
                <input type="email" id="signupEmail" name="email" placeholder="Correo" required>
                <input type="password" id="signupPassword" name="pswd" placeholder="Contraseña" required>
                <input type="password" id="signupConfirmPassword" name="confirmPswd" placeholder="Repita la contraseña" required>
                <div id="StrengthDisp"></div>
                <button type="submit">Registrarse</button>
            </form>
        </div>

        <div class="login">
            <form id="loginForm">
                <label for="chk" aria-hidden="true">Iniciar</label>
                <input type="email" id="loginEmail" name="email" placeholder="Correo" required>
                <input type="password" id="loginPassword" name="pswd" placeholder="Contraseña" required>
                <button type="submit">Iniciar</button>
            </form>
        </div>
    </div>

    <script src="js/singUp_login.js"></script>
</body>

</html>