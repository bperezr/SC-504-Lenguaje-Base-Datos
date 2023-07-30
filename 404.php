<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Header template -->
    <?php include 'include/template/header.php'; ?>
    <!-- styles -->
    <link rel="preload" href="css/404.css" as="style">
    <link rel="stylesheet" href="css/404.css">
</head>

<body>
    <!-- Header temmplate-->
    <?php include 'include/template/nav.php'; ?>

    <main class="contenedor">
        <section class="hero">
            <h1 class="hero__error centrar-texto">404</h1>
            <h2 class="hero__mensaje centrar-texto">¡Ups! Página no
                encontrada</h2>
            <img class="hero__imagen" src="img/en_costruccion.png" alt="page_not_fout">
            <a class="boton centrar-texto" href="index.php">Volver a la
                página de inicio</a>
        </section>
    </main>

    <!-- Footer -->
    <?php include 'include/template/footer.php'; ?>
    <!-- JS -->
    <script src="js/modernizr.js"></script>
</body>

</html>`