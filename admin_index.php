<!DOCTYPE html>
<html lang="es">

<head>
    <!-- styles -->
    <?php $rutaCSS = 'css/admin_styles.css';
    include 'include/template/header.php'; ?>
</head>

<body>
    <!-- Nav template -->
    <?php $enlaceActivo = 'administrar';
    include 'include/template/nav_admin.php'; ?>

    <main class="contenedor">
        <div class="bg">
            <h1 class="centrar-texto">Panel Administrativo</h1>
            <div style="display: flex; justify-content: center; align-items: center;">
                <img src="img/logo_color.svg" alt="Happy Paws">
            </div>
        </div>
    </main>

    <!-- Footer -->
    <?php include 'include/template/footer.php'; ?>
    <!-- JS -->
    <script src=""></script>
</body>

</html>