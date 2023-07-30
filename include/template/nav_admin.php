<header>
    <!-- Logo -->
    <a class="logo" href="admin_index.php"><img src="img/logo2_color.svg" alt="Happy-Paws" /></a>
    <p>Panel Administrativo</p>
    <!-- Menu 2 -->
    <input type="checkbox" id="menu-bar" />
    <label for="menu-bar"><ion-icon name="menu-outline"></ion-icon></label>
    <!-- Navegacion -->
    <nav class="navbar">
        <ul>
            <li><a href="" <?php if ($enlaceActivo == 'medicos') echo 'class="active"'; ?>>Medicos</a></li>
            <li><a href="admin_eventos.php" <?php if ($enlaceActivo == 'eventos') echo 'class="active"'; ?>>Eventos</a></li>
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