<?php
session_start();

require_once '../include/database/db_config.php';
//require_once '../include/database/db_cita.php';
require_once '../include/database/db_contador.php';

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


$contador = new Contador();

$citasCanceladas = $contador->contarCitasCanceladas();
$citasAsignadas = $contador->contarCitasAsignadas();
$citasAtendidas = $contador->contarCitasAtendidas();
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <!-- styles -->
  <?php $rutaCSS = '../css/medical_home.css';
  include '../include/template/header.php'; ?>
</head>

<body>
  <!-- Nav template -->
  <?php $enlaceActivo = 'medico';
  include '../include/template/nav.php'; ?>
  <main class="contenedor">
    <section class="articles">
      <article>
        <div class="article-wrapper">
          <figure>
            <img src="../img/garrapata.png" alt="" />
          </figure>
          <div class="article-body">
            <h2>Citas Atendidas</h2>
            <p class="conteo">
              <?php
              echo $citasAtendidas;
              ?>
            </p>
            <a href="admin_citas.php" class="read-more">
              Más detalles <span class="sr-only"></span>
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                  d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                  clip-rule="evenodd" />
              </svg>
            </a>
          </div>
        </div>
      </article>

      <article>
        <div class="article-wrapper">
          <figure>
            <img src="../img/trabajo-en-progreso.png" alt="" />
          </figure>
          <div class="article-body">
            <h2>Citas Asignadas</h2>
            <p class="conteo">
              <?php
              echo $citasAsignadas;
              ?>
            </p>
            <a href="admin_citas.php" class="read-more">
              Más detalles <span class="sr-only"></span>
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                  d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                  clip-rule="evenodd" />
              </svg>
            </a>
          </div>
        </div>
      </article>

      <article>
        <div class="article-wrapper">
          <figure>
            <img src="../img/canceladas.png" alt="" />
          </figure>
          <div class="article-body">
            <h2>Citas Canceladas</h2>
            <p class="conteo">
              <?php
              echo $citasCanceladas;
              ?>
            </p>
            <a href="admin_citas.php" class="read-more">
              Más detalles <span class="sr-only"></span>
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                  d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                  clip-rule="evenodd" />
              </svg>
            </a>
          </div>
        </div>
      </article>
    </section>

  </main>
  <!-- Footer -->
  <?php include '../include/template/footer.php'; ?>
  <!-- JS -->
</body>

</html>