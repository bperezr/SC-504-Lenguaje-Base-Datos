<?php 
require 'include/database/database.php';
$db = ConectarDB();

$queryEventos = "SELECT * FROM eventos ";

$result = mysqli_query($db, $queryEventos);

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
    <?php $enlaceActivo = 'admin_events';
    include 'include/template/nav_admin.php'; ?>

    <main class="contenedor">

        <h1 class="centrar-texto">Administrar Eventos</h1>

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
                        <a href="admin_events.php"><ion-icon name="refresh-circle"></ion-icon></a>
                    </div>
                </div>
                <div class="buscador buscador_agregar">
                        <!---Agregar-->
                        <div class="agregar">
                            <a href="admin_events_new.php" class="btn_agregar"><ion-icon
                                    name="add-circle-outline"></ion-icon>
                                Agregar</a>
                        </div>
                    </div>
            </div>
        </form>

        <section class="event__tarjetas">
            <?php while($eventos = mysqli_fetch_assoc($result)): ?>
            <!-- Evento 1 -->
            <div class="tarjeta">
                <div class="tarjeta__imagen">
                    <img src="imagenes/<?php echo $eventos['imagen']; ?>" alt="Evento 1">
                </div>
                <div class="tarjeta__detalle">
                    <h2><?php echo $eventos['nombreEvento']; ?></h2>
                    <ul class="detalle-evento">
                        <li><strong>Fecha:</strong><?php echo $eventos['fecha']; ?></li>
                        <li><strong>Hora:</strong> <?php echo $eventos['hora_inicio']; ?> - <?php echo $eventos['hora_fin'] ?></li>
                    </ul>
                </div>
                <!-- Botones -->
                <div class="tarjeta__btn">
                    <a href="events_post.php" class="editar"><ion-icon name="create-sharp"></ion-icon>Editar</a>
                    <a href="" class="eliminar"><ion-icon name="trash-sharp"></ion-icon>Eliminar</a>
                </div>
            </div>
            <?php endwhile; ?>   
        </section>
    </main>

    <!-- Footer -->
    <?php include 'include/template/footer.php'; ?>
    <!-- JS -->
    <script src=""></script>
</body>

</html>