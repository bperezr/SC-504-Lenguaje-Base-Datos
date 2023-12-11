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

$idCita = $_GET['id'];
$cita = new Cita();
$citasDetalle = $cita->getCitaMedica($idCita);
$citaData = $citasDetalle['datos'];


$estados = $cita->getEstados();
$estadoData = $estados['datos'];

$historialMedico = $cita->getHistorialMedico($idCita);
$hmedicodata = $historialMedico['datos'];


$costo = "";
$idEstado = "";
$nombreEstado="";
$detalleCita ="";

if($idCita){
    foreach($hmedicodata as $hm){
        $detalleCita = $hm['DETALLECITA'];
        $costo = $hm['COSTO']; 
    }
}

if($idCita){
    foreach($citaData as $cd){
        $idEstado = $cd['IDESTADO'];
        $nombreEstado = $cd['ESTADO'];
    }
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $detalleCita = $_POST['detalleCita'];
    $costo = $_POST['costo'];
    $idMascota = $_POST['idMascota'];
    $idColaborador =$_POST['idColaborador'];
    $id= $_POST['idcita'];
    $idEstado =$_POST['idestado'];

    $cita->insertHistorialMedico($detalleCita, $costo,$idMascota,$idColaborador,$id);
    $cita->updateEstadoCita($id,$idEstado);
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

    <link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/cita.css">
    <?php $rutaCSS = '../css/medical_styles.css';
    include '../include/template/header.php'; ?>
</head>

<body>
    <?php $enlaceActivo = 'medico';
    include '../include/template/nav.php'; ?>
    
    <section class="ftco-section">
        <div class="container">
           
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="wrapper">
                        <div class="row no-gutters">
                            <div class="col-lg-8 col-md-7 order-md-last d-flex align-items-stretch">
                                <div class="contact-wrap w-100 p-md-5 p-4">
                                    <h3 class="mb-4">Cita</h3>
                                    <div id="form-message-warning" class="mb-4"></div>

                                    <form method="POST" id="contactForm" name="contactForm" class="contactForm" action="citas.php">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="label" for="costo">Costo del servicio</label>
                                                    <input type="text" class="form-control" name="costo" id="costo" placeholder="" value="<?php echo $costo; ?>" required>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="label" for="detalleCita">Detalle de la  Cita</label>
                                                    <textarea name="detalleCita" class="form-control" id="detalleCita" cols="30" rows="12" placeholder="" required><?php echo $detalleCita; ?></textarea>
                                                </div>
                                            </div>

                                            <?php if($nombreEstado!="Atendida") : ?>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="estado">Estado</label>
                                                    <select type="number" name="idestado" id="idestado">
                                                    <option value="<?php echo $idEstado; ?>"><?php echo $nombreEstado; ?>
                                                        <?php
                                                        foreach ($estadoData as $estado) {
                                                            if($estado["ESTADO"] != $nombreEstado && $estado["ESTADO"] != "Cancelada" ){
                                                                echo '<option  value="' . $estado["IDESTADO"] . '">' . $estado["ESTADO"] . '</option>';
                                                            }
                                                            
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <?php endif ?>

                                            <?php foreach ($citaData as $enviardetalle) : ?>
                                                <div>
                                                    <!-- informacion para enviar en el insert de historial medico -->
                                                    <input type="hidden" name="idMascota" id="idMascota" value="<?php echo $enviardetalle['IDMASCOTA']; ?>">
                                                    <input type="hidden" name="idColaborador" id="idColaborador" value="<?php echo $enviardetalle['IDCOLABORADOR']; ?>">
                                                    <input type="hidden" name="idcita" id="idcita" value="<?php echo $enviardetalle['IDCITA']; ?>">
                                                </div>
                                            <?php endforeach; ?>

                                            <?php if($nombreEstado!="Atendida") : ?>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input type="submit" value="Completar cita" class="btn btn-primary">
                                                    <div class="submitting"></div>
                                                </div>
                                            </div>
                                            <?php endif ?>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-5 d-flex align-items-stretch">
                                <div class="info-wrap bg-primary w-100 p-md-5 p-4">
                                    <h3 align="center">Detalle de cita</h3>
                                    <?php foreach ($citaData as $citaDetalle) : ?>
                                        <div class="dbox w-100 d-flex align-items-start">
                                            <div class="icon d-flex align-items-center justify-content-center">
                                                <span class="fa fa-user"></span>
                                            </div>
                                            <div class="text pl-3">
                                                <p><?php echo $citaDetalle['NOMBRE'] . " " . $citaDetalle['APELLIDO1'] . " " . $citaDetalle['APELLIDO1']; ?></p>
                                                <?php echo "Correo: " . $citaDetalle['CORREO'] ?></p>
                                                <?php echo "Teléfono: " . $citaDetalle['TELEFONO'] ?></p>
                                            </div>
                                        </div>

                                        <div class="dbox w-100 d-flex align-items-center">
                                            <div class="icon d-flex align-items-center justify-content-center">
                                                <span class="fa fa-stethoscope"></span>
                                            </div>
                                            <div class="text pl-3">
                                                <p><?php echo "Paciente: " . $citaDetalle['NOMBREMASCOTA'] ?></p>
                                                <p><?php echo "Informacion del paciente: " . $citaDetalle['DESCRIPCION'] ?></p>
                                            </div>
                                        </div>

                                        <div class="dbox w-100 d-flex align-items-center">
                                            <div class="icon d-flex align-items-center justify-content-center">
                                                <span class="fa fa-info-circle"></span>
                                            </div>
                                            <div class="text pl-3">
                                                <p><?php echo "Detalle de la cita: " ?></p>
                                                <p><?php echo "Fecha: " . $citaDetalle['FECHA'] ?></p>
                                                <p><?php echo "Hora: " . $citaDetalle['HORAINICIO'] . " - " . $citaDetalle['HORAFIN'] ?></p>
                                                <p><?php echo "Servicio: " . $citaDetalle['SERVICIO'] ?></p>
                                            </div>
                                        </div>

                                        <div class="dbox w-100 d-flex align-items-center">
                                            <div class="icon d-flex align-items-center justify-content-center">
                                                <span class="fa fa-check-square-o"></span>
                                            </div>
                                            <div class="text pl-3">
                                                <p><?php echo "Estado de la cita: " . $citaDetalle['ESTADO'] ?></p>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include '../include/template/footer2.php'; ?>
    <!-- JS -->

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/main.js"></script>


</body>

</html>