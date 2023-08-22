<?php
session_start();

require_once '../include/database/db_config.php';
require_once '../include/database/db_cita.php';

if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    $correoUsuario = $usuario['correo'];
    $rolUsuario = $usuario['idRol'];
    $rol = $usuario['rol'];
    $id = $usuario['id'];
}
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['idRol'] != 2) {
    header("Location: ../acceso_denegado.php");
    exit();
}

$cita = new Cita();

$citaDetalle = $cita->getAllHistorialMedico($id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {   
    $id= $_POST['idCita'];
    $idEstado =3;

    $cita->updateEstadoCita($id,$idEstado);
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <!-- styles -->
    <?php $rutaCSS = '../css/medical_styles.css';
    include '../include/template/header.php'; ?>
</head>

<body>
    <!-- Nav template -->
    <?php $enlaceActivo = 'medico';
    include '../include/template/nav.php'; ?>
<center>

<main class="contenedor">
<table >
            <thead>
                <tr>
                    <th>ID de Cita</th>
                    <th>Cliente</th>
                    <th>Mascota</th>                    
                    <th>Fecha</th>   
                    <th>Detalle Cita</th>
                    <th>Costo</th>
                    <th>Información detallada</th>
                    <th></th>
                </tr>
            </thead>
            <tbody> 
            <?php
                foreach ($citaDetalle as $cdetalle) {                
                        echo "<tr>";
                        echo "<td>" . $cdetalle['idCita'] . "</td>";
                        echo "<td>" . $cdetalle['nombre'] . " ".  $cdetalle['apellido1'] . " ".  $cdetalle['apellido2'] . "</td>";
                        echo "<td>" . $cdetalle['nombreMascota'] . "</td>";
                        echo "<td>" . $cdetalle['fecha'] . "</td>";
                        echo "<td>" . $cdetalle['detalleCita'] . "</td>";
                        echo "<td>" . "₡" . $cdetalle['costo'] . "</td>";
                        echo "<td>";
                        echo "<a href='citas.php?id=" . $cdetalle['idCita'] . "'class='detalleCita'>Detalle Cita</a>";
                        echo "</td>";
                        echo "</tr>";                   
                }
                ?>        
                
            </tbody>
        </table>
        </main>

    <!-- Footer -->
     <?php include '../include/template/footer2.php'; ?> 
    <!-- JS -->
    </center>
</body>

</html>