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
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['idRol'] != 1) {
    header("Location: ../acceso_denegado.php");
    exit();
}

$cita = new Cita();

$citaDetalle = $cita->getAllDetalleCitaMedico();

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
                    <th>Médico</th>
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
                foreach ($citaDetalle as $cdetalle) {                
                        echo "<tr>";
                        echo "<td>" . $cdetalle['idcita'] . "</td>";
                        echo "<td>" . $cdetalle['nombreMedico'] . "</td>";
                        echo "<td>" . $cdetalle['nombre'] . " ".  $cdetalle['apellido1'] . " ".  $cdetalle['apellido2'] . "</td>";
                        echo "<td>" . $cdetalle['nombreMascota'] . "</td>";
                        echo "<td>" . $cdetalle['fecha'] . "</td>";
                        echo "<td>" . $cdetalle['horaInicio'] . " - " . $cdetalle['horaFin'] . "</td>";
                        // Aplica una clase CSS específica basada en el estado
                        $estadoClass = ($cdetalle['estado'] == 'Atendida' ? 'atendida' : ($cdetalle['estado'] == 'Asignada' ? 'asignada' : 'cancelada'));
                        echo "<td class='$estadoClass'>" . $cdetalle['estado'] . "</td>";
                       
                        if ($cdetalle['estado'] == 'Asignada') {
                            echo "<td>";                           
                            echo "<a href='admin_verCitas.php?id=" . $cdetalle['idcita'] . "'class='detalleCita'>Detalle Cita</a>";
                            echo "</td>"; 
                            echo "<td>";
                            echo "<form action='medical_appointments.php' method='post' onsubmit='return confirm(\"¿Estás seguro de cancelar esta cita?\")'>";
                            echo "<input type='hidden' name='idCita' value='" . $cdetalle['idcita'] . "'>";
                            echo "<button  class='cancelarCita' type='submit'>Cancelar</button>";
                            echo "</form>";                           
                            echo "</td>";
                        } else{
                            echo "<td>";                           
                            echo "<a href='admin_verCitas.php?id=" . $cdetalle['idcita'] . "'class='detalleCita'>Detalle Cita</a>";
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