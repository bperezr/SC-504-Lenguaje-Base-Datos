<?php
$paginasPermitidas = array(
    1 => array(
        'admin_appointments.php',
        'admin_appointments_edit.php',
        'admin_appointments_new.php',
        'admin_cargos.php',
        'admin_cargos_edit.php',
        'admin_cargos_new.php',
        'admin_clientes.php',
        'admin_contactos.php',
        'admin_especialidad.php',
        'admin_especialidades_edit.php',
        'admin_especialidades_new.php',
        'admin_events.php',
        'admin_events_edit.php',
        'admin_events_new.php',
        'admin_index.php',
        'admin_mascotas.php',
        'admin_mascotas_edit.php',
        'admin_mascotas_new.php',
        'admin_servicios.php',
        'admin_tipos.php',
        'admin_workers.php',
        'admin_worker_edit.php',
        'admin_worker_new.php'
    ),
    2 => array(
        'medical_index.php',
    ),
    3 => array(
        'index.php',
        'about.php',
        'contact.php',
        'about.php',
        'about_team_dr1.php',
        'about_team_dr2.php',
        'contact.php',
        'events.php',
        'events_post.php',
        'index.php',
        'login.php',
        'logout.php',
        'services.php',
        'service_grooming.php',
        'service_medical_check.php',
        'service_neutering.php',
        'service_surgery.php'
    ),
    'todos' => array(
        '404.php',
        'acceso_denegado.php'
    )
);

function validarAcceso($pagina, $rolUsuario)
{
    global $paginasPermitidas;

    if (isset($paginasPermitidas[$rolUsuario]) && in_array($pagina, $paginasPermitidas[$rolUsuario])) {
        return true;
    }

    if (in_array($pagina, $paginasPermitidas['todos'])) {
        return true;
    }

    return false;
}
?>