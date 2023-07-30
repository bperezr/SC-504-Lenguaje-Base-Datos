<!DOCTYPE html>
<html lang="es">

<head>
    <!-- styles -->
    <?php $rutaCSS = 'css/admin_styless.css';
    include 'include/template/header.php'; ?>
</head>

<body>
    <!-- Nav template -->
    <?php $enlaceActivo = 'admin_medicals';
    include 'include/template/nav_admin.php'; ?>

    <main class="contenedor">

    <h1 class="centrar-texto">Administrar Medicos</h1>

    <a href="admin_medicals_post.php" class="boton input-text">Medico</a>

    </main>

    <!-- Footer -->
    <?php include 'include/template/footer.php'; ?>
    <!-- JS -->
    <script src=""></script>
</body>

</html>