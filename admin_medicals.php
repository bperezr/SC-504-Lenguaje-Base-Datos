<!DOCTYPE html>
<html lang="es">

<head>
    <!-- styles -->
    <?php $rutaCSS = 'css/admin_medicals.css';
    include 'include/template/header.php'; ?>
</head>

<body>
    <!-- Nav template -->
    <?php $enlaceActivo = 'admin_medicals';
    include 'include/template/nav_admin.php'; ?>

    <main class="contenedor">

        <h1 class="centrar-texto">Administrar Médicos</h1>

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
                        <a href="admin_medicals.php"><ion-icon name="refresh-circle"></ion-icon></a>
                    </div>
                </div>
                <div class="buscador buscador_agregar">
                    <!---Agregar-->
                    <div class="agregar">
                        <a href="admin_medicals_new.php" class="btn_agregar"><ion-icon
                                name="add-circle-outline"></ion-icon>
                            Agregar</a>
                    </div>
                </div>
            </div>
        </form>

        <section class="event__tarjetas">
            <!-- C 1 -->
            <div class="tarjeta">
                <div class="tarjeta__imagen">
                    <img src="img/dr1_luis.png" alt="Evento 1">
                </div>
                <div class="tarjeta__detalle">
                    <h2>Dr. Juan Carlos Morales</h2>
                    <ul class="detalle-evento">
                        <li><strong>Especialidad:</strong> Medicina Interna Veterinaria.</li>
                    </ul>
                </div>
                <!-- Botones -->
                <div class="tarjeta__btn">
                    <a href="admin_medicals_edit.php" class="editar"><ion-icon name="create-sharp"></ion-icon>Editar</a>
                    <a href="" class="eliminar"><ion-icon name="trash-sharp"></ion-icon>Eliminar</a>
                </div>
            </div>

            <!-- C 2 -->
            <div class="tarjeta">
                <div class="tarjeta__imagen">
                    <img src="img/dr2_ana.gif" alt="Evento 2">
                </div>
                <div class="tarjeta__detalle">
                    <h2>Valentina Rodríguez</h2>
                    <ul class="detalle-evento">
                        <li><strong>Especialidad:</strong> Cirugía Veterinaria.</li>
                    </ul>
                </div>
                <!-- Botones -->
                <div class="tarjeta__btn">
                    <a href="admin_medicals_edit.php" class="editar"><ion-icon name="create-sharp"></ion-icon>Editar</a>
                    <a href="" class="eliminar"><ion-icon name="trash-sharp"></ion-icon>Eliminar</a>
                </div>
            </div>

            <!-- C 3 -->
            <div class="tarjeta">
                <div class="tarjeta__imagen">
                    <img src="img/dr3_elizabeth.webp" alt="Evento 3">
                </div>
                <div class="tarjeta__detalle">
                    <h2>Dra. Martina Gómez</h2>
                    <ul class="detalle-evento">
                        <li><strong>Especialidad:</strong> Medicina Veterinaria General y Estética.</li>
                    </ul>
                </div>
                <!-- Botones -->
                <div class="tarjeta__btn">
                    <a href="admin_medicals_edit.php" class="editar"><ion-icon name="create-sharp"></ion-icon>Editar</a>
                    <a href="" class="eliminar"><ion-icon name="trash-sharp"></ion-icon>Eliminar</a>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <?php include 'include/template/footer.php'; ?>
    <!-- JS -->
</body>

</html>