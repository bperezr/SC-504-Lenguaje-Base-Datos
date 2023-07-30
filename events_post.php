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
    <?php include 'include/template/footer.php'; ?>
    <!-- JS -->
</body>

</html>`