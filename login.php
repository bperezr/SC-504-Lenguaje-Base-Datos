<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Happy Paw</title>
    <link rel="icon" type="image/svg+xml" href="/img/favicon.png">
    <link rel="icon" type="image/png" href="/img/favicon.svg">
    <meta name="description" content="Página web Happy Paws">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- normalize -->
    <link rel="preload" href="css/normalize.css" as="style">
    <link rel="stylesheet" href="css/normalize.css">

    <!-- Fonts -->
    <link rel="preload"
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&family=Staatliches&display=swap"
        crossorigin="crossorigin" as="font">

    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&family=Staatliches&display=swap"
        rel="stylesheet">

    <!-- styles -->
    <link rel="preload" href="css/singUp_login.css" as="style">
    <link rel="stylesheet" href="css/singUp_login.css">

    <!--Icons-->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</head>

<body>
    <div class="main">
        <input type="checkbox" id="chk" aria-hidden="true">

        <div class="contenedor logo">
            <a href="index.html"><img src="img/logo_color.svg" alt="logo"></a>
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