<?php
/* session_start();

if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    $correoUsuario = $usuario['correo'];
    $rolUsuario = $usuario['idRol'];
    $rol = $usuario['rol'];
    $id = $usuario['id'];
}
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['idRol'] != 2) {
    header("Location: acceso_denegado.php");
    exit();
} */
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <!-- styles -->
    <?php $rutaCSS = '../css/medical_styles.css';
    include '../include/template/header.php'; ?>
    <link rel="stylesheet" href="../css/evo-calendar.min.css">
    <link rel="stylesheet" href="../css/evo-calendar.royal-navy.css">
</head>

<body>
    <!-- Nav template -->
    <?php $enlaceActivo = 'medico';
    include '../include/template/nav.php'; ?>

    <div id="calendar">
    </div>


    <!-- Footer -->
    <?php include '../include/template/footer.php'; ?>
    <!-- JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="../js/evo-calendar.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#calendar').evoCalendar({
               
            })
        })
    </script>

</body>

</html>