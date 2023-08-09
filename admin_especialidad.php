<?php
require_once 'include/database/db_especialidad.php'; 
$especialidad = new Especialidad(); 

$especialidades = $especialidad->getEspecialidades();
$hayResultados = true;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idEspecialidad = $_POST['id'];
    $especialidad->deleteEspecialidad($idEspecialidad); 
    header('Location: admin_especialidad.php');
    exit;
}

if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
    $especialidades = $especialidad->buscarEspecialidades($searchTerm);
    if (count($especialidades) === 0) {
        $hayResultados = false;
    } else {
        $hayResultados = true;
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <!-- styles -->
    <?php $rutaCSS = 'css/admin_workers.css';
    include 'include/template/header.php'; ?>
</head>

<body>
    <!-- Nav template -->
    <?php $enlaceActivo = 'admin_especialidad';
    include 'include/template/nav_admin.php'; ?>

    <main class="contenedor">

        <h1 class="centrar-texto">Administrar Especialidades</h1>

        <!-- Buscador -->
        <form action="" method="get">
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
                        <a href="admin_especialidades.php"><ion-icon name="refresh-circle"></ion-icon></a>
                    </div>
                </div>
                <div class="buscador buscador_agregar">
                    <!---Agregar-->
                    <div class="agregar">
                        <a href="admin_especialidades_new.php" class="btn_agregar"><ion-icon
                                name="add-circle-outline"></ion-icon>
                            Agregar</a>
                    </div>
                </div>
            </div>
        </form>

        <?php if ($hayResultados): ?>
            <section class="event__tarjetas">
                <?php foreach ($especialidades as $especialidad): ?>
                    <!-- Tarjeta de cada especialidad -->
                    <div class="tarjeta">
                        <div class="tarjeta__detalle">
                            <h2>
                                <?php echo $especialidad['idEspecialidad']; ?>
                            </h2>
                            <ul class="detalle-evento">
                                <li><strong>Especialidad:</strong>
                                    <?php echo $especialidad['especialidad']; ?>
                                </li>
                                <li><strong>Descripción:</strong>
                                    <?php echo $especialidad['descripcion']; ?>
                                </li>
                            </ul>
                        </div>
                        <!-- Botones -->
                        <div class="tarjeta__btn">
                            <a href="admin_especialidades_edit.php?id=<?php echo $especialidad['idEspecialidad']; ?>"
                                class="editar"><ion-icon name="create-sharp"></ion-icon>Editar</a>
                            <form action="" method="post" style="display: inline;">
                                <input type="hidden" name="id" value="<?php echo $especialidad['idEspecialidad']; ?>">
                                <button type="submit" class="eliminar"
                                    onclick="return confirm('¿Estás seguro de que deseas eliminar esta especialidad?')">
                                    <ion-icon name="trash-sharp"></ion-icon>Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </section>
        <?php else: ?>
            <div class="err_busqueda">
                <h2 class="brincar">No se encontraron especialidades que coincidan con la búsqueda.</h2>
                <img class="" src="img/dog1.webp" alt="">
            </div>
        <?php endif; ?>

    </main>

    <!-- Footer -->
    <?php include 'include/template/footer.php'; ?>
    <!-- JS -->
</body>

</html>
