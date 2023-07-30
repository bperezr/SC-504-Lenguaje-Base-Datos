<header>
    <!-- Logo -->
    <a class="logo" href="index.php"><img src="img/logo2_color.svg" alt="Happy-Paws" /></a>
    <!-- Menu 2 -->
    <input type="checkbox" id="menu-bar" />
    <label for="menu-bar"><ion-icon name="menu-outline"></ion-icon></label>
    <!-- Navegacion -->
    <nav class="navbar">
        <ul>
            <li>
                <a href="services.php"<?php if ($enlaceActivo == 'services') echo 'class="active"'; ?>>Servicios</a>
                <ul>
                    <li><a href="service_medical_check.php" <?php if ($enlaceActivo == 'medical_check') echo 'class="active"'; ?>>Medicia</a></li>
                    <li><a href="service_surgery.php" <?php if ($enlaceActivo == 'surgery') echo 'class="active"'; ?>>Cirugía</a></li>
                    <li><a href="service_neutering.php" <?php if ($enlaceActivo == 'neutering') echo 'class="active"'; ?>>Castración</a></li>
                    <li><a href="service_grooming.php" <?php if ($enlaceActivo == 'grooming') echo 'class="active"'; ?>>Aceo</a></li>
                </ul>
            </li>
            <li><a href="about.php" <?php if ($enlaceActivo == 'about') echo 'class="active"'; ?>>Nosotros</a></li>
            <li><a href="events.php" <?php if ($enlaceActivo == 'events') echo 'class="active"'; ?>>Eventos</a></li>
            <li><a href="contact.php" <?php if ($enlaceActivo == 'contact') echo 'class="active"'; ?>>Contacto</a></li>
            <li class="login">
                <p><ion-icon name="person-circle-outline"></ion-icon></p>
                <ul>
                    <li><a href="login.php" <?php if ($enlaceActivo == 'iniciar') echo 'class="active"'; ?>>Iniciar</a></li>
                    <li><a href="login.php" <?php if ($enlaceActivo == 'salir') echo 'class="active"'; ?>>Salir</a></li>
                    <li><a href="profile.php" <?php if ($enlaceActivo == 'perfil') echo 'class="active"'; ?>>Perfil</a></li>
                    <li><a href="admin_index.php" <?php if ($enlaceActivo == 'administrar') echo 'class="active"'; ?>>Admin</a></li>
                    <li><a href="medical_index.php" <?php if ($enlaceActivo == 'medico') echo 'class="active"'; ?>>Médico</a></li>
                </ul>
            </li>
        </ul>
    </nav>
</header>