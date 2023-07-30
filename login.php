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
            <form>
                <label for="chk" aria-hidden="true">Registrarse</label>
                <input type="text" name="name" placeholder="Nombre Completo" required="">
                <input type="email" name="email" placeholder="Correo" required="">
                <input type="password" name="pswd" placeholder="Contraseña" required="">
                <input type="password" name="pswd" placeholder="Repita la contraseña" required="">
                <button>Registrarse</button>
            </form>
        </div>

        <div class="login">
            <form>
                <label for="chk" aria-hidden="true">Iniciar</label>
                <input type="email" name="email" placeholder="Correo" required="">
                <input type="password" name="pswd" placeholder="Contraseña" required="">
                <button>Iniciar</button>
            </form>
        </div>
    </div>

</body>

</html>`