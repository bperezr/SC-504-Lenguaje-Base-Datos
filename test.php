<?php
require_once 'include/database/db_lugar.php';
$lugar = new Lugar();

//$respuesta1 = $lugar->getNombreProvinciaPorID(7);
//$respuesta2 = $lugar->getNombreCantonPorID(410);
//$respuesta3 = $lugar->getNombreDistritoPorID(10101);

//$respuesta4 = $lugar->getCantonesPorProvincia(7);
//$respuesta5 = $lugar->getDistritosPorCanton(101);

$respuesta6 = $lugar->getProvincias();
//$respuesta7 = $lugar->getCantones();
//$respuesta8 = $lugar->getDistritos();


/* $resultadoSP = $respuesta1['resultado'];
$lugar = $respuesta1['datos'];

$mensaje = "";
if ($resultadoSP == 1) {
    $mensaje = "Se encontraron resultados.";
} elseif ($resultadoSP == 0) {
    $mensaje = "No se encontraron resultados.";
    $hayResultados = false;
} else {
    $mensaje = "Ocurrió un error al recuperar el resultados.";
    $hayResultados = false;
} */


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <!-- styles -->
    <?php $rutaCSS = 'css/client_profile.css';
    include 'include/template/header.php'; ?>
</head>

<body>
    <!-- Nav template -->
    <?php
    $enlaceActivo = 'perfil';
    include 'include/template/nav.php';
    ?>

    <main class="contenedor">
        <h1 class="centrar-texto">TEST</h1>
        <section class="perfil">

            <h2>getCantones</h2>
            <?php
            echo "<pre>";
            var_dump($respuesta6);
            echo "</pre>";
            ?>

        </section>
    </main>
    <!-- Footer -->
    <?php include 'include/template/footer.php'; ?>
    <!-- JS -->
</body>

</html>