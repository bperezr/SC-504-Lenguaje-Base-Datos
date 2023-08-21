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

require_once '../include/database/db_cita.php';

$cita = new Cita();
/* $citasCliente = $cita->getCitasCliente($id); */
$citasCanceladas = $cita->getCitasPorEstado(3);
$citasAsignadas = $cita->getCitasPorEstado(1);
$citasAtendidas = $cita->getCitasPorEstado(2);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ... (Código para cancelar citas) ...
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <!-- styles -->
    <?php $rutaCSS = '../css/admin_styles.css';
    include '../include/template/header.php'; ?>
</head>

<body>
    <!-- Nav template -->
    <?php $enlaceActivo = 'administrar';
    include '../include/template/nav.php'; ?>

    <main class="contenedor">
        <div class="bg">
            <h1 class="centrar-texto">Panel Administrativo</h1>

            <div class="card-container">
                <div class="card ca">
                    <h2 class="centrar-texto">Atendidas</h2>
                    <p class="total-citas">
                        <?php echo count($citasAtendidas); ?>
                    </p>
                    <!-- Tabla de citas atendidas -->
                </div>
                <div class="card as">
                    <h2 class="centrar-texto">Asignadas</h2>
                    <p class="total-citas">
                        <?php echo count($citasAsignadas); ?>
                    </p>
                    <!-- Tabla de citas asignadas -->
                </div>
                <div class="card at">
                    <h2 class="centrar-texto">Canceladas</h2>
                    <p class="total-citas">
                        <?php echo count($citasCanceladas); ?>
                    </p>
                    <!-- Tabla de citas canceladas -->
                </div>
            </div>

            <h2 class="centrar-texto">Citas Asignadas</h2>
            <table>
            <thead>
                <tr>
                    <th>ID de Cita</th>
                    <th>Mascota</th>
                    <th>Servicio</th>
                    <th>Fecha</th>
                    <th>Horario</th>
                    <th>Médico</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($citasAsignadas as $citasAsignadas) {
                        echo "<tr>";

                        echo "<td>" . $citasAsignadas['idCita'] . "</td>";
                        echo "<td>" . $citasAsignadas['nombreMascota'] . "</td>";
                        echo "<td>" . $citasAsignadas['nombreServicio'] . "</td>";
                        echo "<td>" . $citasAsignadas['fecha'] . "</td>";
                        echo "<td>" . $citasAsignadas['horaInicio'] . " - " . $citasAsignadas['horaFin'] . "</td>";
                        echo "<td>" . $citasAsignadas['nombreMedico'] . "</td>";

                        echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        </div>
    </main>

    <!-- Footer -->
    <?php include '../include/template/footer2.php'; ?>
    <!-- JS -->
</body>

</html>