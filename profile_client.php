<?php
session_start();

if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    $correoUsuario = $usuario['correo'];
    $rolUsuario = $usuario['idRol'];
    $rol = $usuario['rol'];
    $id = $usuario['id'];
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <!-- styles -->
    <?php $rutaCSS = 'css/client_profile.css';
    include 'include/template/header.php'; ?>
</head>

<body>
    <!-- Nav template -->
    <?php
    $enlaceActivo = 'perfil';
    include 'include/template/nav.php';
    ?>

    <main class="contenedor">

        <h1 class="centrar-texto">Perfil de Usuario</h1>

        <section class="perfil">
            <!-- Encabezado -->
            <div class="perfil__head">
                <div class="perfil__head-sec1">
                    <div class="imagen">
                        <img src="img/images_workers/14f597ebf1fd6cdceb59484b86234efc.jpg" alt="">
                    </div>
                    <div class="head-sec2">
                        <p class="nombre">Jorge</p>
                        <p class="apellido">Hernandez Araya</p>
                        <div class="detalle">
                            <p>Telefono: 6024-5117</p>
                            <p>Correo: correo@correo.com</p>
                            <div></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="perfil__bnt">
                <a href="" class="btn-1">Editar Perfil</a>
                <a href="" class="btn-2">Agendar cita</a>
            </div>

            <!-- Informacion -->

            <h2>Direccion</h2>

            <div class="perfil__detalle">
                <div class="perfil__detalle-info">
                    <p>Provincia: Alajuela</p>
                    <p>Canton: Atenas</p>
                    <p>Distrito: Mercedes</p>
                    <p>Direccion: 200m sur del hotel Villas de la Colina</p>
                </div>
            </div>

            <!-- Mascotas -->
            <h2>Mascotas</h2>

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

            <div class="perfil__mascota">

                <div class="perfil__mascota-card">
                    <div class="mascota__img">
                        <img src="img/img_1.jpg" alt="">
                    </div>
                    <div class="mascota__detalle">
                        <h4>Felix</h4>
                        <p>Gato</p>
                    </div>
                    <div class="mascota__btn">
                        <a href="mascota_edit.php" class="editar"><ion-icon name="create-sharp"></ion-icon>Editar</a>
                        <form action="" method="post" style="display: inline;">
                            <input type="hidden" name="id" value="">
                            <button type="submit" class="eliminar"
                                onclick="return confirm('¿Estás seguro de que deseas eliminar esta mascota?')">
                                <ion-icon name="trash-sharp"></ion-icon>Eliminar
                            </button>
                        </form>
                    </div>
                </div>

                <div class="perfil__mascota-card">
                    <div class="mascota__img">
                        <img src="img/img_1.jpg" alt="">
                    </div>
                    <div class="mascota__detalle">
                        <h4>Felix</h4>
                        <p>Gato</p>
                    </div>
                    <div class="mascota__btn">
                        <a href="mascota_edit.php" class="editar"><ion-icon name="create-sharp"></ion-icon>Editar</a>
                        <form action="" method="post" style="display: inline;">
                            <input type="hidden" name="id" value="">
                            <button type="submit" class="eliminar"
                                onclick="return confirm('¿Estás seguro de que deseas eliminar esta mascota?')">
                                <ion-icon name="trash-sharp"></ion-icon>Eliminar
                            </button>
                        </form>
                    </div>
                </div>

                <div class="perfil__mascota-card">
                    <div class="mascota__img">
                        <img src="img/img_1.jpg" alt="">
                    </div>
                    <div class="mascota__detalle">
                        <h4>Felix</h4>
                        <p>Gato</p>
                    </div>
                    <div class="mascota__btn">
                        <a href="mascota_edit.php" class="editar"><ion-icon name="create-sharp"></ion-icon>Editar</a>
                        <form action="" method="post" style="display: inline;">
                            <input type="hidden" name="id" value="">
                            <button type="submit" class="eliminar"
                                onclick="return confirm('¿Estás seguro de que deseas eliminar esta mascota?')">
                                <ion-icon name="trash-sharp"></ion-icon>Eliminar
                            </button>
                        </form>
                    </div>
                </div>

                <div class="perfil__mascota-card">
                    <div class="mascota__img">
                        <img src="img/img_1.jpg" alt="">
                    </div>
                    <div class="mascota__detalle">
                        <h2>Felix</h2>
                        <p>Gato</p>
                    </div>
                    <div class="mascota__btn">
                        <a href="mascota_edit.php" class="editar"><ion-icon name="create-sharp"></ion-icon>Editar</a>
                        <form action="" method="post" style="display: inline;">
                            <input type="hidden" name="id" value="">
                            <button type="submit" class="eliminar"
                                onclick="return confirm('¿Estás seguro de que deseas eliminar esta mascota?')">
                                <ion-icon name="trash-sharp"></ion-icon>Eliminar
                            </button>
                        </form>
                    </div>
                </div>

            </div>

        </section>
    </main>
    <!-- Footer -->
    <?php include 'include/template/footer.php'; ?>
    <!-- JS -->
</body>

</html>