<?php
// Conexión a la base de datos Oracle
$usuario = 'happypaws';
$contrasena = '12345';
$base_datos = 'localhost/orcl';
$conexion = oci_connect($usuario, $contrasena, $base_datos);
// Verificar la conexión
if (!$conexion) {
    $error = oci_error();
    die('No se pudo conectar a la base de datos: ' . $error['message']);
}
// Procesar el formulario si se ha enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idTipoMascota = $_POST['idTipoMascota'];
    // Llamada al procedimiento almacenado GETTIPOMASCOTA
    $stmt = oci_parse($conexion, 'BEGIN GETTIPOMASCOTA(:idTipoMascota, :tipo); END;');
    oci_bind_by_name($stmt, ':idTipoMascota', $idTipoMascota);
    oci_bind_by_name($stmt, ':tipo', $tipo, 256);
    // Ejecutar el procedimiento almacenado
    oci_execute($stmt);
    // Cerrar el cursor
    oci_free_statement($stmt);
}
// Comenzar la salida HTML
echo '<html>';
echo '<head><title>Consulta de Tipo de Mascota por ID</title></head>';
echo '<body>';
// Formulario para ingresar el IDTIPOMASCOTA
echo '<form method="post" action="">';
echo 'IDTIPOMASCOTA: <input type="text" name="idTipoMascota">';
echo '<input type="submit" value="Consultar">';
echo '</form>';
// Mostrar el resultado
if (isset($tipo)) {
    echo '<p>Resultado:</p>';
    echo '<p>IDTIPOMASCOTA: ' . $idTipoMascota . '</p>';
    echo '<p>Tipo: ' . $tipo . '</p>';
}
// Finalizar la salida HTML
echo '</body>';
echo '</html>';
// Cerrar conexiones
oci_close($conexion);
?>
