<?php

require 'include/database/database.php';
$db = ConectarDB();
$queryCitas = "SELECT
                c.*,
                hi.horaInicio,
                hi.horaFin,
                m.tipo as tipoMascota,
                s.servicio as nombreServicio,
                n.nombre as nombreCliente
                FROM citas as c
                join horariocitas as hi on c.idHorario = hi.idHorario
                join tipomascota as m on c.idMascota =  m.idTipoMascota
                join servicios as s on c.idServicio = s.idServicio
                join cliente as n on c.idCliente = n.idCliente";

$result = mysqli_query($db, $queryCitas);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['idCita'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if ($id) {
        //Eliminar cita
        $queryDelete = "DELETE from citas where idCita = ${id}";
        $resultDel = mysqli_query($db, $queryDelete);

        if ($resultDel) {
            header('Location: /SC-502-Proyecto/admin_appointments.php');
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <!-- styles -->
    <?php $rutaCSS = 'css/admin_events.css';
    include 'include/template/header.php'; ?>
</head>

<body>
    <!-- Nav template -->
    <?php $enlaceActivo = 'admin_appointments';
    include 'include/template/nav_admin.php'; ?>

    <main class="contenedor">

        <h1 class="centrar-texto">Administrar Citas</h1>

        <!-- Buscador -->
        <form action="buscar" method="get">
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
                        <a href="admin_appointments.php"><ion-icon name="refresh-circle"></ion-icon></a>
                    </div>
                </div>
                <div class="buscador buscador_agregar">
                    <!---Agregar-->
                    <div class="agregar">
                        <a href="admin_appointments_new.php" class="btn_agregar"><ion-icon
                                name="add-circle-outline"></ion-icon>
                            Agregar</a>
                    </div>
                </div>
            </div>
            </div>
        </form>

        <section class="event__tarjetas">
            <?php while ($cita = mysqli_fetch_assoc($result)): ?>
                <!-- Evento 1 -->
                <div class="tarjeta">
                    <div class="tarjeta__detalle">
                        <h2>
                            <?php echo $cita['nombreServicio']; ?>
                        </h2>
                        <ul class="detalle-evento">
                            <li><strong>Cliente:</strong>
                                <?php echo $cita['idCliente']; ?> - <?php echo $cita['nombreCliente']; ?>
                            </li>
                            <li><strong>Fecha:</strong>
                                <?php echo $cita['fecha']; ?>
                            </li>
                            <li><strong>Horario:</strong>
                                <?php echo $cita['horaInicio']; ?> -
                                <?php echo $cita['horaFin']; ?>
                            </li>
                            <li><strong>Mascota:</strong>
                                <?php echo $cita['tipoMascota']; ?>
                            </li>
                        </ul>
                    </div>
                    <!-- Botones -->
                    <div class="tarjeta__btn">
                        <a href="admin_appointments_edit.php?id=<?php echo $cita['idCita']; ?>" class="editar"><ion-icon name="create-sharp"></ion-icon>Editar</a>

                        <form method="POST">
                            <input type="hidden" name="idCita" value="<?php echo $cita['idCita'] ?>">
                            <input type="submit" class="eliminar" value="Eliminar">
                        </form>
                    </div>
                </div>
            <?php endwhile; ?>
        </section>
    </main>

    <!-- Footer -->
    <?php include 'include/template/footer.php'; ?>
    <!-- JS -->
</body>

</html>