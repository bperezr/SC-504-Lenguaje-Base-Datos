<?php
require 'include/connections/connect.php';
$db = ConectarDB();
$queryEventos = "SELECT * FROM eventos";
$result = mysqli_query($db, $queryEventos);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['idEvento'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if ($id) {
        //Eliminar imagen
        $queryImagen = "SELECT imagen FROM eventos where idEvento = ${id}";
        $resultImg = mysqli_query($db, $queryImagen);
        $eventoImagen = mysqli_fetch_assoc($resultImg);

        unlink('img/images/' . $eventoImagen['imagen']);

        //Eliminar evento
        $queryDelete = "DELETE from eventos where idEvento = ${id}";
        $result = mysqli_query($db, $queryDelete);

        if ($result) {
            header('Location: /SC-502-Proyecto/admin_events.php');
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
            </div>
        </form>

        <section class="event__tarjetas">
            <?php while ($eventos = mysqli_fetch_assoc($result)): ?>
                <!-- Evento -->
                <div class="tarjeta">
                <div class="tarjeta__imagen">
                        <?php if (file_exists("img/images/" . $eventos['imagen'])): ?>
                            <img src="img/images/<?php echo $eventos['imagen']; ?>" alt="Evento 1">
                        <?php else: ?>
                            <img src="img/no_disponible.webp" alt="Imagen no disponible">
                        <?php endif; ?>
                    </div>
                    <div class="tarjeta__detalle">
                        <h2>
                            <?php echo $eventos['nombreEvento']; ?>
                        </h2>
                        <ul class="detalle-evento">
                            <li><strong>Fecha:</strong>
                                <?php echo $eventos['fecha']; ?>
                            </li>
                            <li><strong>Hora:</strong>
                                <?php echo $eventos['hora_inicio']; ?> -
                                <?php echo $eventos['hora_fin'] ?>
                            </li>
                        </ul>
                    </div>

                    <!-- Botones -->
                    <div class="tarjeta__btn">
                        <a href="admin_events_edit.php?id=<?php echo $eventos['idEvento']; ?>" class="editar">
                            <ion-icon name="create-sharp"></ion-icon>Editar
                        </a>

                        <form class="tarjeta__btn" method="POST"
                            onsubmit="return confirm('¿Estás seguro de que quieres eliminar este evento?');">
                            <input type="hidden" name="idEvento" value="<?php echo $eventos['idEvento'] ?>">
                            <button type="submit" class="eliminar">
                                <ion-icon name="trash-sharp"></ion-icon>Eliminar
                            </button>
                        </form>
                    </div>

                </div>
            <?php endwhile; ?>
        </section>
    </main>

    <!-- Footer -->
    <?php include 'include/template/footer.php'; ?>
</body>

</html>