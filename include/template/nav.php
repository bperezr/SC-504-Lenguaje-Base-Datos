<!-- No Login -->
<?php if (empty($correoUsuario)): ?>

    <header>
        <!-- Logo -->
        <a class="logo" href="index.php"><img src="img/logo2_color.svg" alt="Happy-Paws" /></a>

        <?php if (!empty($correoUsuario)): ?>
            <p>
                <?php echo $correoUsuario; ?>
            </p>
        <?php else: ?>
            <p></p>
        <?php endif; ?>

        <!-- Menu 2 -->
        <input type="checkbox" id="menu-bar" />
        <label for="menu-bar"><ion-icon name="menu-outline"></ion-icon></label>
        <!-- Navegacion -->
        <nav class="navbar">
            <ul>
                <li>
                    <a href="services.php" <?php if ($enlaceActivo == 'services')
                        echo 'class="active"'; ?>>Servicios</a>
                    <ul>
                        <li><a href="service_medical_check.php" <?php if ($enlaceActivo == 'medical_check')
                            echo 'class="active"'; ?>>Medicina</a></li>
                        <li><a href="service_surgery.php" <?php if ($enlaceActivo == 'surgery')
                            echo 'class="active"'; ?>>Cirugía</a></li>
                        <li><a href="service_neutering.php" <?php if ($enlaceActivo == 'neutering')
                            echo 'class="active"'; ?>>Castración</a></li>
                        <li><a href="service_grooming.php" <?php if ($enlaceActivo == 'grooming')
                            echo 'class="active"'; ?>>Aseo</a></li>
                    </ul>
                </li>
                <li><a href="about.php" <?php if ($enlaceActivo == 'about')
                    echo 'class="active"'; ?>>Nosotros</a></li>
                <li><a href="events.php" <?php if ($enlaceActivo == 'events')
                    echo 'class="active"'; ?>>Eventos</a></li>
                <li><a href="contact.php" <?php if ($enlaceActivo == 'contact')
                    echo 'class="active"'; ?>>Contacto</a></li>
                <li class="login">
                    <p><ion-icon name="person-circle-outline"></ion-icon></p>
                    <ul>
                        <li><a href="login.php" <?php if ($enlaceActivo == 'iniciar')
                            echo 'class="active"'; ?>>Iniciar</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>

    <!-- Cliente -->
<?php elseif (!empty($correoUsuario) && $rolUsuario == 3): ?>

    <header>
        <!-- Logo -->
        <a class="logo" href="index.php"><img src="img/logo2_color.svg" alt="Happy-Paws" /></a>

        <?php if (!empty($correoUsuario)): ?>
            <p>
                <?php
                $nombreUsuario = substr($correoUsuario, 0, strpos($correoUsuario, '@'));
                echo $nombreUsuario;
                ?>
            </p>
        <?php else: ?>
            <p></ion-icon></p>
        <?php endif; ?>

        <!-- Menu 2 -->
        <input type="checkbox" id="menu-bar" />
        <label for="menu-bar"><ion-icon name="menu-outline"></ion-icon></label>
        <!-- Navegacion -->
        <nav class="navbar">
            <ul>
                <li>
                    <a href="services.php" <?php if ($enlaceActivo == 'services')
                        echo 'class="active"'; ?>>Servicios</a>
                    <ul>
                        <li><a href="service_medical_check.php" <?php if ($enlaceActivo == 'medical_check')
                            echo 'class="active"'; ?>>Medicina</a></li>
                        <li><a href="service_surgery.php" <?php if ($enlaceActivo == 'surgery')
                            echo 'class="active"'; ?>>Cirugía</a></li>
                        <li><a href="service_neutering.php" <?php if ($enlaceActivo == 'neutering')
                            echo 'class="active"'; ?>>Castración</a></li>
                        <li><a href="service_grooming.php" <?php if ($enlaceActivo == 'grooming')
                            echo 'class="active"'; ?>>Aseo</a></li>
                    </ul>
                </li>
                <li><a href="about.php" <?php if ($enlaceActivo == 'about')
                    echo 'class="active"'; ?>>Nosotros</a></li>
                <li><a href="events.php" <?php if ($enlaceActivo == 'events')
                    echo 'class="active"'; ?>>Eventos</a></li>
                <li><a href="contact.php" <?php if ($enlaceActivo == 'contact')
                    echo 'class="active"'; ?>>Contacto</a></li>
                <li class="login">
                    <p><ion-icon name="person-circle-outline"></ion-icon></p>
                    <ul>
                        <li><a href="profile_client.php" <?php if ($enlaceActivo == 'perfil')
                            echo 'class="active"'; ?>>Perfil</a>
                        </li>
                        <li><a href="cita_vista.php" <?php if ($enlaceActivo == 'cita_vista')
                            echo 'class="active"'; ?>>Mis Cita</a></li>
                        <li><a href="cita.php" <?php if ($enlaceActivo == 'cita')
                            echo 'class="active"'; ?>>Nueva Cita</a>
                        </li>
                        <li><a href="logout.php" <?php if ($enlaceActivo == 'salir')
                            echo 'class="active"'; ?>>Salir</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>

    <!-- Medico -->
<?php elseif (!empty($correoUsuario) && $rolUsuario == 2): ?>
    <header>
        <!-- Logo -->
        <a class="logo" href="medical_index.php"><img src="../img/logo2_color.svg" alt="Happy-Paws" /></a>
        <!-- Usuario -->
        <?php if (!empty($correoUsuario)): ?>
            <p>
                <?php
                $nombreUsuario = substr($correoUsuario, 0, strpos($correoUsuario, '@'));
                echo $nombreUsuario;
                ?>
            </p>
        <?php else: ?>
            <p>Médico: </p>
        <?php endif; ?>
        <!-- Menu 2 -->
        <input type="checkbox" id="menu-bar" />
        <label for="menu-bar"><ion-icon name="menu-outline"></ion-icon></label>
        <!-- Navegacion -->
        <nav class="navbar">
            <ul>
                <li><a href="medical_appointments.php" <?php if ($enlaceActivo == 'mecical_appointments')
                    echo 'class="active"'; ?>>Citas</a></li>
                <li><a href="historialMedico.php" <?php if ($enlaceActivo == 'pacientes')
                    echo 'class="active"'; ?>>Historial Medico</a></li>
                <li class="login">
                    <p><ion-icon name="person-circle-outline"></ion-icon></p>
                    <ul>
                        <li><a href="profile.php" <?php if ($enlaceActivo == 'perfil')
                            echo 'class="active"'; ?>>Perfil</a>
                        </li>
                        <li><a href="../logout.php" <?php if ($enlaceActivo == 'salir')
                            echo 'class="active"'; ?>>Salir</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>

    <!-- Admin -->
<?php elseif (!empty($correoUsuario) && $rolUsuario == 1): ?>

    <header>
        <!-- Logo -->
        <a class="logo" href="admin_index.php"><img src="../img/logo2_color.svg" alt="Happy-Paws" /></a>
        <!-- Usuario -->
        <?php if (!empty($correoUsuario)): ?>
            <p>
                <?php
                $nombreUsuario = substr($correoUsuario, 0, strpos($correoUsuario, '@'));
                echo $nombreUsuario;
                ?>
            </p>

        <?php else: ?>
            <p> </p>
        <?php endif; ?>
        <!-- Menu 2 -->
        <input type="checkbox" id="menu-bar" />
        <label for="menu-bar"><ion-icon name="menu-outline"></ion-icon></label>
        <!-- Navegacion -->
        <nav class="navbar">
            <ul>
                <!-- Personal -->
                <li>
                    <a href="admin_workers.php" <?php if ($enlaceActivo == 'admin_workers')
                        echo 'class="active"'; ?>>Personal
                    </a>
                </li>
                <!-- Clientes -->
                <li>
                    <a href="admin_clientes.php" <?php if ($enlaceActivo == 'admin_clientes')
                        echo 'class="active"'; ?>>Clientes
                    </a>
                </li>
                <!-- Eventos -->
                <li>
                    <a href="admin_events.php" <?php if ($enlaceActivo == 'admin_events')
                        echo 'class="active"'; ?>>Eventos
                    </a>
                </li>
                <!-- Otros -->
                <li><a href="" <?php if ($enlaceActivo == 'admin_otros')
                    echo 'class="active"'; ?>>Otros</a>
                    <ul>
                        <!-- Servicios -->
                        <li><a href="admin_services.php" <?php if ($enlaceActivo == 'admin_servicios')
                            echo 'class="active"'; ?>>Servicios</a></li>
                        <!-- Cargos -->
                        <li><a href="admin_cargos.php" <?php if ($enlaceActivo == 'admin_cargos')
                            echo 'class="active"'; ?>>Cargos</a></li>
                        <!-- Especialidad -->
                        <li><a href="admin_especialidad.php" <?php if ($enlaceActivo == 'admin_especialidad')
                            echo 'class="active"'; ?>>Especialidad</a></li>
                        <!-- Mascotas -->
                        <li><a href="admin_mascotas.php" <?php if ($enlaceActivo == 'admin_mascotas')
                            echo 'class="active"'; ?>>Tipos de Mascotas</a></li>
                    </ul>
                </li>
                <!-- Cita -->
                <li><a href="admin_cita.php"> <ion-icon name="medkit"></ion-icon></a></li>
                <!-- Login -->
                <li class="login">
                    <p><ion-icon name="person-circle-outline"></ion-icon></p>
                    <ul>
                        <li><a href="../logout.php" <?php if ($enlaceActivo == 'salir')
                            echo 'class="active"'; ?>>Salir</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>

<?php else: ?>

<?php endif; ?>