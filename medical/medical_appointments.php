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

$citaDetalle = $cita->getDetalleCitaMedico($id);
$citaData = $citaDetalle['datos'];
 

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
                    <th>Horario</th>
                    <th>Estado</th>
                    <th>Acción</th>
                    <th></th>
                </tr>
            </thead>
            <tbody> 
            <?php
                foreach ($citaData as $cdetalle) {                
                        echo "<tr>";
                        echo "<td>" . $cdetalle['IDCITA'] . "</td>";
                        echo "<td>" . $cdetalle['NOMBRE'] . " ".  $cdetalle['APELLIDO1'] . " ".  $cdetalle['APELLIDO2'] . "</td>";
                        echo "<td>" . $cdetalle['NOMBREMASCOTA'] . "</td>";
                        echo "<td>" . $cdetalle['FECHA'] . "</td>";
                        echo "<td>" . $cdetalle['HORAINICIO'] . " - " . $cdetalle['HORAFIN'] . "</td>";
                        // Aplica una clase CSS específica basada en el estado
                        $estadoClass = ($cdetalle['ESTADO'] == 'Atendida' ? 'atendida' : ($cdetalle['ESTADO'] == 'Asignada' ? 'asignada' : 'cancelada'));
                        echo "<td class='$estadoClass'>" . $cdetalle['ESTADO'] . "</td>";
                       
                        if ($cdetalle['ESTADO'] == 'Asignada') {
                            echo "<td>";                           
                            echo "<a href='citas.php?id=" . $cdetalle['IDCITA'] . "'class='detalleCita'>Detalle Cita</a>";
                            echo "</td>"; 
                            echo "<td>";
                            echo "<form action='medical_appointments.php' method='post' onsubmit='return confirm(\"¿Estás seguro de cancelar esta cita?\")'>";
                            echo "<input type='hidden' name='idCita' value='" . $cdetalle['IDCITA'] . "'>";
                            echo "<button  class='cancelarCita' type='submit'>Cancelar</button>";
                            echo "</form>";                           
                            echo "</td>";
                        } else{
                            echo "<td>";                           
                            echo "<a href='citas.php?id=" . $cdetalle['IDCITA'] . "'class='detalleCita'>Detalle Cita</a>";
                            echo "</td>"; 
                        }                    
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