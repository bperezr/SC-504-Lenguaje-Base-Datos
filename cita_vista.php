<?php
session_start();

if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    $correoUsuario = $usuario['correo'];
    $rolUsuario = $usuario['idRol'];
    $rol = $usuario['rol'];
    $id = $usuario['id'];
}

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['idRol'] != 3) {
    header("Location: acceso_denegado.php");
    exit();
}

require_once 'include/database/db_cita.php';

$cita = new Cita();
$citasCliente = $cita->getCitasCliente($id);

/* echo "<pre>";
print_r($citasCliente);
echo "</pre>"; */



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idCita = $_POST['idCita'];
    $idEstadoCancelado = 3; // ID de estado para "cancelado"

    $cita = new Cita();
    $cita->updateEstadoCita($idCita, $idEstadoCancelado);

    header('Location: cita_vista.php'); // Redirigir a la página de citas
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <!-- styles -->
    <?php $rutaCSS = 'css/services_info.css';
    include 'include/template/header.php'; ?>
</head>

<body>
    <!-- Nav template -->
    <?php $enlaceActivo = 'cita_vista';
    include 'include/template/nav.php'; ?>

    <main class="contenedor">

        <h2 class="centrar-texto">Citas Agendadas</h2>

        <table>
            <thead>
                <tr>
                    <th>ID de Cita</th>
                    <th>Mascota</th>
                    <th>Servicio</th>
                    <th>Fecha</th>
                    <th>Horario</th>
                    <th>Médico</th>
                    <th>Estado</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($citasCliente as $citaCliente) {
                    if ($citaCliente['idEstado'] != 'Cancelada') {
                        echo "<tr>";

                        echo "<td>" . $citaCliente['idCita'] . "</td>";
                        echo "<td>" . $citaCliente['nombreMascota'] . "</td>";
                        echo "<td>" . $citaCliente['nombreServicio'] . "</td>";
                        echo "<td>" . $citaCliente['fecha'] . "</td>";
                        echo "<td>" . $citaCliente['horaInicio'] . " - " . $citaCliente['horaFin'] . "</td>";
                        echo "<td>" . $citaCliente['nombreMedico'] . "</td>";
                        echo "<td>" . $citaCliente['nombreEstado'] . "</td>";
                        echo "<td>";

                        echo "<form action='cita_vista.php' method='post' onsubmit='return confirm(\"¿Estás seguro de cancelar esta cita?\")'>";
                        echo "<input type='hidden' name='idCita' value='" . $citaCliente['idCita'] . "'>";
                        echo "<button type='submit'>Cancelar</button>";
                        echo "</form>";
                        echo "</td>";

                        echo "</tr>";
                    }

                }
                ?>
            </tbody>
        </table>

        <h2 class="centrar-texto">Citas Canceladas</h2>
        <table>
            <thead>
                <tr>
                    <th>ID de Cita</th>
                    <th>Mascota</th>
                    <th>Servicio</th>
                    <th>Fecha</th>
                    <th>Horario</th>
                    <th>Médico</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($citasCliente as $citaCliente) {
                    if ($citaCliente['idEstado'] == 'Cancelada') {
                        echo "<tr>";
                        echo "<td>" . $citaCliente['idCita'] . "</td>";
                        echo "<td>" . $citaCliente['nombreMascota'] . "</td>";
                        echo "<td>" . $citaCliente['nombreServicio'] . "</td>";
                        echo "<td>" . $citaCliente['fecha'] . "</td>";
                        echo "<td>" . $citaCliente['horaInicio'] . " - " . $citaCliente['horaFin'] . "</td>";
                        echo "<td>" . $citaCliente['nombreMedico'] . "</td>";
                        echo "<td>" . $citaCliente['nombreEstado'] . "</td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>


    </main>

    <!-- Footer -->
    <?php include 'include/template/footer.php'; ?>
    <!-- JS -->
</body>

</html>