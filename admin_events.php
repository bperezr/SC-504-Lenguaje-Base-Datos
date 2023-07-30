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
            <!-- Evento 1 -->
            <div class="tarjeta">
                <div class="tarjeta__imagen">
                    <img src="img/imagen_evento1.jpg" alt="Evento 1">
                </div>
                <div class="tarjeta__detalle">
                    <h2>Campaña de Castración Felina y Canina</h2>
                    <ul class="detalle-evento">
                        <li><strong>Fecha:</strong> 10 de agosto de 2023</li>
                        <li><strong>Hora:</strong> 9:00 AM - 4:00 PM</li>
                    </ul>
                </div>
                <!-- Botones -->
                <div class="tarjeta__btn">
                    <a href="admin_events_edit.php" class="editar"><ion-icon name="create-sharp"></ion-icon>Editar</a>
                    <a href="" class="eliminar"><ion-icon name="trash-sharp"></ion-icon>Eliminar</a>
                </div>
            </div>

            <!-- Evento 2 -->
            <div class="tarjeta">
                <div class="tarjeta__imagen">
                    <img src="img/imagen_evento2.jpg" alt="Evento 2">
                </div>
                <div class="tarjeta__detalle">
                    <h2>Día de Adopción Responsable</h2>
                    <ul class="detalle-evento">
                        <li><strong>Fecha:</strong> 22 de septiembre de 2023</li>
                        <li><strong>Hora:</strong> 10:00 AM - 2:00 PM</li>
                    </ul>
                </div>
                <!-- Botones -->
                <div class="tarjeta__btn">
                    <a href="admin_events_edit.php" class="editar"><ion-icon name="create-sharp"></ion-icon>Editar</a>
                    <a href="" class="eliminar"><ion-icon name="trash-sharp"></ion-icon>Eliminar</a>
                </div>
            </div>

            <!-- Evento 3 -->
            <div class="tarjeta">
                <div class="tarjeta__imagen">
                    <img src="img/imagen_evento3.jpg" alt="Evento 3">
                </div>
                <div class="tarjeta__detalle">
                    <h2>Charla sobre Nutrición y Salud Animal</h2>
                    <ul class="detalle-evento">
                        <li><strong>Fecha:</strong> 30 de septiembre de 2023</li>
                        <li><strong>Hora:</strong> 6:00 PM - 8:00 PM</li>
                    </ul>
                </div>
                <!-- Botones -->
                <div class="tarjeta__btn">
                    <a href="admin_events_edit.php" class="editar"><ion-icon name="create-sharp"></ion-icon>Editar</a>
                    <a href="" class="eliminar"><ion-icon name="trash-sharp"></ion-icon>Eliminar</a>
                </div>
            </div>

            <!-- Evento 4 -->
            <div class="tarjeta">
                <div class="tarjeta__imagen">
                    <img src="img/imagen_evento4.jpg" alt="Evento 4">
                </div>
                <div class="tarjeta__detalle">
                    <h2>Exposición de Razas Caninas</h2>
                    <ul class="detalle-evento">
                        <li><strong>Fecha:</strong> 15 de octubre de 2023</li>
                        <li><strong>Hora:</strong> 10:00 AM - 5:00 PM</li>
                    </ul>
                </div>
                <!-- Botones -->
                <div class="tarjeta__btn">
                    <a href="admin_events_edit.php" class="editar"><ion-icon name="create-sharp"></ion-icon>Editar</a>
                    <a href="" class="eliminar"><ion-icon name="trash-sharp"></ion-icon>Eliminar</a>
                </div>
            </div>

            <!-- Evento 5 -->
            <div class="tarjeta">
                <div class="tarjeta__imagen">
                    <img src="img/imagen_evento5.jpg" alt="Evento 5">
                </div>
                <div class="tarjeta__detalle">
                    <h2>Vacunación Gratuita</h2>
                    <ul class="detalle-evento">
                        <li><strong>Fecha:</strong> 25 de octubre de 2023</li>
                        <li><strong>Hora:</strong> 9:00 AM - 1:00 PM</li>
                    </ul>
                </div>
                <!-- Botones -->
                <div class="tarjeta__btn">
                    <a href="admin_events_edit.php" class="editar"><ion-icon name="create-sharp"></ion-icon>Editar</a>
                    <a href="" class="eliminar"><ion-icon name="trash-sharp"></ion-icon>Eliminar</a>
                </div>
            </div>

            <!-- Evento 6 -->
            <div class="tarjeta">
                <div class="tarjeta__imagen">
                    <img src="img/imagen_evento6.jpg" alt="Evento 5">
                </div>
                <div class="tarjeta__detalle">
                    <h2>Taller de Adiestramiento Canino</h2>
                    <ul class="detalle-evento">
                        <li><strong>Fecha:</strong> 5 de noviembre de 2023</li>
                        <li><strong>Hora:</strong> 2:00 PM - 4:00 PM</li>
                    </ul>
                </div>
                <!-- Botones -->
                <div class="tarjeta__btn">
                    <a href="admin_events_edit.php" class="editar"><ion-icon name="create-sharp"></ion-icon>Editar</a>
                    <a href="" class="eliminar"><ion-icon name="trash-sharp"></ion-icon>Eliminar</a>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <?php include 'include/template/footer.php'; ?>
    <!-- JS -->
    <script src=""></script>
</body>

</html>