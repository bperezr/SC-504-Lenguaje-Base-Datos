<?php
if (isset($_POST['buscarCliente'])) {
    $correoCliente = $_POST['correoCliente'];

    $cliente = $cliente->obtenerClientePorCorreo($correoCliente);

    if ($cliente) {
        echo "<p>Cliente encontrado:</p>";
        echo "<p>ID de Cliente: " . $cliente['idCliente'] . "</p>";
        echo "<p>Nombre: " . $cliente['nombre'] . " " . $cliente['apellido1'] . " " . $cliente['apellido2'] . "</p>";

    } else {
        echo "<p>Cliente no encontrado.</p>";
    }
}
?>