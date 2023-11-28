<?php
require_once 'include/database/db_lugar.php';
require_once 'include/database/db_eventos.php';
$evento = new Evento();
$lugar = new Lugar();

//$respuesta = $lugar->getNombreProvinciaPorID(7);
//$respuesta = $lugar->getNombreCantonPorID(410);
//$respuesta = $lugar->getNombreDistritoPorID(10101);

//$respuesta = $lugar->getCantonesPorProvincia(7);
$respuesta = $lugar->getDistritosPorCanton(212);

//$respuesta = $lugar->getProvincias();
//$respuesta = $lugar->getCantones();
//$respuesta = $lugar->getDistritos();

//$respuesta = $evento->getEvento(1);
//$respuesta = $evento->getEventos();

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

            <h2>Respuesta</h2>
            <?php
            echo "<pre>";
            var_dump($respuesta);
            echo "</pre>";
            ?>

        </section>
    </main>
    <!-- Footer -->
    <?php include 'include/template/footer.php'; ?>
    <!-- JS -->
</body>

</html>