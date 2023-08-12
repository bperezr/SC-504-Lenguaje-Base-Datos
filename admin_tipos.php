<?php
session_start();

if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    $correoUsuario = $usuario['correo'];
    $rolUsuario = $usuario['idRol'];
    $rol = $usuario['rol'];
    $id = $usuario['id'];
}

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['idRol'] != 1) {
    header("Location: acceso_denegado.php");
    exit();
}

/*  */
require_once 'include/database/db_colaborador.php';

$c = new Colaborador();
$resultados = $c->getColaboradores();
$hayResultados = true;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idColaborador = $_POST['id'];
    $c->deleteColaborador($idColaborador);
    header('Location: admin_workers.php');
    exit;
}

if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
    $resultados = $c->buscarColaboradores($searchTerm);
    if (count($resultados) === 0) {
        $hayResultados = false;
    } else {
        $hayResultados = true;
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <!-- styles -->
    <?php $rutaCSS = 'css/admin_workers.css';
    include 'include/template/header.php'; ?>
</head>

<body>
    <!-- Nav template -->
    <?php $enlaceActivo = 'admin_tipos';
    include 'include/template/nav.php'; ?>

    <main class="contenedor">

        <h1 class="centrar-texto">Administrar Tipos</h1>

    </main>

    <!-- Footer -->
    <?php include 'include/template/footer.php'; ?>
    <!-- JS -->
</body>

</html>