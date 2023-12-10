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
    header("Location: ../acceso_denegado.php");
    exit();
}

require_once '../include/database/db_auditoria.php';
$auditoria = new Auditoria();

$resultado = $auditoria->getAuditoriasCitas();
$datosAuditoria = $resultado['datos'];
$resultadoSP = $resultado['resultado'];

$hayResultados = true;

if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
    $respuesta = $auditoria->buscarAuditoriasCitas($searchTerm);
    $datosAuditoria = $respuesta['datos'];
    $resultado = $respuesta['resultado'];

    if ($resultado == 1) {
        // No se encontraron auditorías de citas
        $hayResultados = false;
    } elseif ($resultado == 0) {
        // Se encontraron auditorías de citas
        $hayResultados = true;
    } else {
        // Ocurrió un error
        // Puedes manejar el error aquí, por ejemplo, mostrar un mensaje de error.
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <!-- styles -->
    <?php $rutaCSS = '../css/admin_workers.css';
    include '../include/template/header.php'; ?>
</head>

<body>
    <!-- Nav template -->
    <?php $enlaceActivo = 'admin_audit';
    include '../include/template/nav.php'; ?>

    <main class="contenedor">

        <h1 class="centrar-texto">Auditoria Citas</h1>

        <!-- Buscador -->
        <form action="" method="get">
            <div class="contenedor_buscar">
                <div class="buscador buscador_buscar">
                    <!-- Texto buscar -->
                    <div class="textBuscar">
                        <input type="text" placeholder="Buscar..." name="search">
                    </div>
                    <!-- Buscar -->
                    <div class="buscar">
                        <button class="btn_buscar" type="submit">Buscar</button>
                    </div>
                    <!-- Recargar -->
                    <div class="recargar">
                        <a href="admin_audit.php"><ion-icon name="refresh-circle"></ion-icon></a>
                    </div>
                </div>
            </div>
        </form>

        <?php if ($hayResultados): ?>

            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Fecha de Modificación</th>
                        <th>ID Cita</th>
                        <th>Modificador</th>
                        <th>Nuevo Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($datosAuditoria as $auditoria): ?>
                        <tr>
                            <td>
                                <?php echo $auditoria['FECHAMODIFICACION']; ?>
                            </td>
                            <td>
                                <?php echo $auditoria['IDCITA']; ?>
                            </td>
                            <td>
                                <?php echo $auditoria['MODIFICADOR']; ?>
                            </td>
                            <td>
                                <?php echo $auditoria['NUEVOESTADO']; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        <?php else: ?>
            <div class="err_busqueda">
                <h2 class="brincar">No se encontraron clientes que coincidan con la búsqueda.</h2>
                <img class="" src="../img/dog1.webp" alt="">
            </div>
        <?php endif; ?>

    </main>

    <!-- Footer -->
    <?php include '../include/template/footer.php'; ?>
    <!-- JS -->
</body>

</html>