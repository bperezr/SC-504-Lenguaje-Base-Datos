<!DOCTYPE html>
<html lang="es">

<head>
    <!-- styles -->
    <?php $rutaCSS = 'css/events.css';
    include 'include/template/header.php'; ?>
</head>

<body>
    <!-- Nav template -->
    <?php $enlaceActivo = '';
    include 'include/template/nav.php'; ?>

    <main class="contenedor">
        <section class="evento">
            <div class="evento__detalle">
                <h2 class="centrar-texto">Campaña de Castración Felina y Canina</h2>
                <ul class="evento__detalle-hora">
                    <li><strong>Fecha:</strong> 10 de agosto de 2023</li>
                    <li><strong>Hora:</strong> 9:00 AM - 4:00 PM</li>
                    <li><strong>Lugar:</strong> San José, Costa Rica.</li>
                </ul>
                <p class="justificar-texto">Únete a nuestra campaña de castración para gatos y perros, donde promovemos la esterilización como
                    una medida responsable y beneficiosa para el bienestar de nuestras mascotas. Contaremos con
                    veterinarios especializados que brindarán una atención cuidadosa y amorosa a cada animal. ¡Ayúdanos
                    a controlar la población de animales y a proteger su salud!</p>
                    <img src="img/imagen_evento1.jpg" alt="Evento 1">
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="fcontenedor">
            <!-- Seccion 1-->
            <div class="fcontenedor__seccion">
                <img class="fcontenedor__imagen" src="img/logo_color.svg" alt="Happy-Paws" />
                <p>Dedicados a la salud y bienestar de tus mejores amigos.</p>
            </div>
            <!-- Seccion 2-->
            <div class="fcontenedor__seccion">
                <h4 class="ftitulo">Redes Sociales</h4>
                <a href="#!" class="fcontenedor__info"><ion-icon name="logo-instagram"></ion-icon> Happy-Paws</a>
                <a href="#!" class="fcontenedor__info"><ion-icon name="logo-facebook"></ion-icon> Happy-Paws</a>
                <a href="#!" class="fcontenedor__info"><ion-icon name="logo-whatsapp"></ion-icon> +506 8888-8888</a>
            </div>
            <!-- Seccion 3-->
            <div class="fcontenedor__seccion">
                <h4 class="ftitulo">Contáctenos</h4>
                <a href="#!" class="fcontenedor__info"><ion-icon name="call-sharp"></ion-icon> +506 2532-3577</a>
                <a href="#!" class="fcontenedor__info"><ion-icon name="navigate-circle-sharp"></ion-icon> San José,
                    Costa Rica.</a>
                <a href="mailto:happyPaws@email.com" class="fcontenedor__info"><ion-icon name="mail-sharp"></ion-icon>
                    happyPaws@email.com</a>
            </div>
        </div>
        <!-- Copyright -->
        <div class="copyright">
            <p>&copy; Happy Paws — Todos los derechos Reservados 2023.</p>
        </div>
    </footer>

    <script src="js/card.js"></script>
</body>

</html>`