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

$idCita = $_GET['id'];
$cita = new Cita();
$citasDetalle = $cita->getCitaMedica($idCita);
$estados = $cita->getEstados();
$historialMedico = $cita->getHistorialMedico($idCita);

$detalleCita = "";
$costo = "";
$idEstado = "";
$nombreEstado = "";

if ($idCita) {
    foreach ($historialMedico as $hm) {
        $detalleCita = $hm['detalleCita'];
        $costo = $hm['costo'];
    }
}

if ($idCita) {
    foreach ($citasDetalle as $cd) {
        $idEstado = $cd['idestado'];
        $nombreEstado = $cd['estado'];
    }
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $detalleCita = $_POST['detalleCita'];
    $costo = $_POST['costo'];
    $idMascota = $_POST['idMascota'];
    $idColaborador = $_POST['idColaborador'];
    $id = $_POST['idcita'];
    $idEstado = $_POST['idestado'];

    $cita->insertHistorialMedico($detalleCita, $costo, $idMascota, $idColaborador, $id);
    $cita->updateEstadoCita($id, $idEstado);
    header('Location: medical_appointments.php');
    exit;
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Citas</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <?php $rutaCSS = '../css/admin_styles.css';
    include '../include/template/header.php'; ?>
</head>

<body>
    <?php $enlaceActivo = 'medico';
    include '../include/template/nav.php'; ?>
    <main class="contenedor">
        <section class="ftco-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-5 d-flex align-items-stretch">
                        <div class="info-wrap bg-primary w-100 p-md-5 p-4">
                        <div class="btn_atras">
                                        <a href="admin_citas.php" class="boton input-text">Atras</a>
                                    </div>
                            <h3 align="center">Detalle de cita</h3>
                            <?php foreach ($citasDetalle as $citaDetalle): ?>
                                <div class="dbox w-100 d-flex align-items-start">
                                    <div class="icon d-flex align-items-center justify-content-center">
                                        <span class="fa fa-user"></span>
                                    </div>
                                    <div class="text pl-3">
                                        <p>
                                            <?php echo $citaDetalle['nombre'] . " " . $citaDetalle['apellido1'] . " " . $citaDetalle['apellido2']; ?>
                                        </p>
                                        <?php echo "Correo: " . $citaDetalle['correo'] ?>
                                        </p>
                                        <?php echo "Teléfono: " . $citaDetalle['telefono'] ?>
                                        </p>
                                    </div>
                                </div>

                                <div class="dbox w-100 d-flex align-items-center">
                                    <div class="icon d-flex align-items-center justify-content-center">
                                        <span class="fa fa-stethoscope"></span>
                                    </div>
                                    <div class="text pl-3">
                                        <p>
                                            <?php echo "Paciente: " . $citaDetalle['nombreMascota'] ?>
                                        </p>
                                        <p>
                                            <?php echo "Informacion del paciente: " . $citaDetalle['descripcion'] ?>
                                        </p>
                                    </div>
                                </div>

                                <div class="dbox w-100 d-flex align-items-center">
                                    <div class="icon d-flex align-items-center justify-content-center">
                                        <span class="fa fa-info-circle"></span>
                                    </div>
                                    <div class="text pl-3">
                                        <p>
                                            <?php echo "Detalle de la cita: " ?>
                                        </p>
                                        <p>
                                            <?php echo "Fecha: " . $citaDetalle['fecha'] ?>
                                        </p>
                                        <p>
                                            <?php echo "Hora: " . $citaDetalle['horaInicio'] . " - " . $citaDetalle['horaFin'] ?>
                                        </p>
                                        <p>
                                            <?php echo "Servicio: " . $citaDetalle['servicio'] ?>
                                        </p>
                                    </div>
                                </div>

                                <div class="dbox w-100 d-flex align-items-center">
                                    <div class="icon d-flex align-items-center justify-content-center">
                                        <span class="fa fa-check-square-o"></span>
                                    </div>
                                    <div class="text pl-3">
                                        <p>
                                            <?php echo "Estado de la cita: " . $citaDetalle['estado'] ?>
                                        </p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!-- Footer -->
    <?php include '../include/template/footer.php'; ?>
    <!-- JS -->
</body>

</html>