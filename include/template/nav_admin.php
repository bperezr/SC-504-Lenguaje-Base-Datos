<header>
    <!-- Logo -->
    <a class="logo" href="admin_index.php"><img src="img/logo2_color.svg" alt="Happy-Paws" /></a>

    <!-- Menu 2 -->
    <input type="checkbox" id="menu-bar" />
    <label for="menu-bar"><ion-icon name="menu-outline"></ion-icon></label>
    <!-- Navegacion -->
    <nav class="navbar">
        <ul>
            <!-- Mascotas -->
            <li>
                <a href="" <?php if ($enlaceActivo == 'admin_mascotas')
                    echo 'class="active"'; ?>>Mascotas</a>
                <ul>
                    <li><a href="admin_tipos.php" <?php if ($enlaceActivo == 'admin_tipos')
                        echo 'class="active"'; ?>>Tipo</a></li>
                    <li><a href="admin_razas.php" <?php if ($enlaceActivo == 'admin_razas')
                        echo 'class="active"'; ?>>Raza</a>
                    </li>
                </ul>
            </li>
            <!-- Personal -->
            <li>
                <a href="admin_workers.php" <?php if ($enlaceActivo == 'admin_workers')
                    echo 'class="active"'; ?>>Personal
                </a>
                <ul>
                    <li><a href="admin_cargos.php" <?php if ($enlaceActivo == 'admin_cargos')
                        echo 'class="active"'; ?>>Cargos</a></li>
                    <li><a href="admin_especialidad.php" <?php if ($enlaceActivo == 'admin_especialidad')
                        echo 'class="active"'; ?>>Especialidad</a></li>
                </ul>
            </li>
            <!-- Citas -->
            <li><a href="admin_appointments.php" <?php if ($enlaceActivo == 'admin_appointments')
                echo 'class="active"'; ?>>Citas</a>
                <ul>
                    <!-- Servicios -->
                    <li><a href="admin_servicios.php" <?php if ($enlaceActivo == 'admin_servicios')
                        echo 'class="active"'; ?>>Servicios</a></li>
                </ul>
            </li>
            <!-- Otros -->
            <li><a href="" <?php if ($enlaceActivo == 'admin_otros')
                echo 'class="active"'; ?>>Otros</a>
                <ul>
                    <!-- Eventos -->
                    <li><a href="admin_events.php" <?php if ($enlaceActivo == 'admin_events')
                        echo 'class="active"'; ?>>Eventos</a></li>
                    <!-- Contacto -->
                    <li><a href="admin_contactos.php" <?php if ($enlaceActivo == 'admin_contactos')
                        echo 'class="active"'; ?>>Contacto</a></li>
                </ul>
            </li>

            <li class="login">
                <p><ion-icon name="person-circle-outline"></ion-icon></p>
                <ul>
                    <li><a href="login.php" <?php if ($enlaceActivo == 'iniciar')
                        echo 'class="active"'; ?>>Iniciar</a>
                    </li>
                    <li><a href="login.php" <?php if ($enlaceActivo == 'salir')
                        echo 'class="active"'; ?>>Salir</a></li>
                    <li><a href="profile.php" <?php if ($enlaceActivo == 'perfil')
                        echo 'class="active"'; ?>>Perfil</a>
                    </li>
                    <li><a href="admin_index.php" <?php if ($enlaceActivo == 'administrar')
                        echo 'class="active"'; ?>>Admin</a></li>
                    <li><a href="medical_index.php" <?php if ($enlaceActivo == 'medico')
                        echo 'class="active"'; ?>>Médico</a></li>
                </ul>
            </li>
        </ul>
    </nav>
</header>