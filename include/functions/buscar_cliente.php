<?php
require_once '../database/db_cliente.php';

$response = array();

if (isset($_POST['buscarCliente'])) {
    $correoCliente = $_POST['correoCliente'];

    $cliente = new Cliente();
    $clienteEncontrado = $cliente->obtenerClientePorCorreo($correoCliente);

    if ($clienteEncontrado) {
        $response['clienteEncontrado'] = true;
        $response['idCliente'] = $clienteEncontrado['idCliente'];
        $response['nombre'] = $clienteEncontrado['nombre'];
        $response['apellido1'] = $clienteEncontrado['apellido1'];
        $response['apellido2'] = $clienteEncontrado['apellido2'];
    } else {
        $response['clienteEncontrado'] = false;
    }
}

echo json_encode($response);
?>
