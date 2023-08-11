<?php
session_start();

if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    $correoUsuario = $usuario['correo'];
    $rolUsuario = $usuario['idRol'];
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <!-- styles -->
    <?php $rutaCSS = 'css/about_team_dr.css';
    include 'include/template/header.php'; ?>
</head>

<body>
    <!-- Nav template -->
    <?php $enlaceActivo = '';
    include 'include/template/nav.php'; ?>

    <main class="contenedor">

        <section class="hero">
            <div class="contact">
                <img src="img/dr2_ana.gif" alt="medico">
                <h2>Dra. Valentina Rodríguez</h2>
                <p>Cirugía Veterinaria.</p>
            </div>

            <div class="hero">
                <h2 class="centrar-texto no-margin">Acerca de mí</h2>
                <p class="justificar-texto">¡Hola a todos! Soy la Dra. Valentina Rodríguez y me emociona formar parte
                    del equipo de Happy Paws como especialista en Medicina Veterinaria General. Desde muy temprana edad,
                    supe que mi pasión por los animales me llevaría a dedicar mi vida a cuidar de ellos y a promover su
                    bienestar.</p>
                <p class="justificar-texto">
                    Mi amor por los animales comenzó con mi primer gato, a quien rescaté cuando era apenas un gatito.
                    Esta experiencia cambió mi vida y me inspiró a embarcarme en una carrera en la medicina veterinaria.
                    A lo largo de mi formación y experiencia profesional, he aprendido la importancia de brindar una
                    atención integral y compasiva a cada paciente peludo que llega a nuestra clínica.</p>
                <p class="justificar-texto">
                    En Happy Paws, encuentro el lugar perfecto para ejercer mi vocación, rodeada de un equipo
                    comprometido y apasionado por el bienestar animal. Cada día, me esfuerzo por establecer una conexión
                    especial con cada mascota y sus dueños, comprendiendo sus necesidades individuales y preocupándome
                    por su salud en general.</p>
                <p class="justificar-texto">
                    Mi enfoque es fomentar la prevención y la educación, lo que me permite trabajar junto a los
                    propietarios para asegurarme de que sus gatos y perros reciban la mejor atención posible en casa y
                    en nuestra clínica. Desde chequeos regulares hasta el manejo de enfermedades crónicas, mi objetivo
                    es proporcionar un enfoque integral y personalizado para mantener a nuestras mascotas felices y
                    saludables.</p>
                <p class="justificar-texto">
                    Fuera de la clínica, disfruto de la naturaleza y me encanta explorar senderos con mi perro
                    rescatado, Luna. Ella es mi fiel compañera y me recuerda constantemente la importancia de cuidar y
                    proteger a nuestros amigos de cuatro patas.</p>
                <p class="justificar-texto">
                    Gracias por permitirme formar parte de la vida de sus queridos gatos y perros. Estoy comprometida a
                    brindarles la atención y el cariño que se merecen, y espero ser parte de su viaje hacia una vida
                    llena de salud y alegría.</p>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <?php include 'include/template/footer.php'; ?>
    <!-- JS -->
</body>

</html>`