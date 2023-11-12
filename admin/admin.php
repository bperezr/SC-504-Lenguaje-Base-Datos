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
// Llamada al procedimiento almacenado
$cursor = oci_new_cursor($conexion);
$stid = oci_parse($conexion, 'BEGIN GETTIPOMASCOTAS(:cursor); END;');
oci_bind_by_name($stid, ':cursor', $cursor, -1, OCI_B_CURSOR);
oci_execute($stid);
// Recuperar datos del cursor
oci_execute($cursor);
// Comenzar la salida HTML
echo '<html>';
echo '<head><title>Datos del Procedimiento Almacenado</title></head>';
echo '<body>';
// Mostrar los datos en una tabla HTML
echo '<table border="1">';
echo '<tr><th>ID</th><th>Tipo</th></tr>';
while ($row = oci_fetch_assoc($cursor)) {
    echo '<tr>';
    echo '<td>' . $row['IDTIPOMASCOTA'] . '</td>';
    echo '<td>' . $row['TIPO'] . '</td>';
    echo '</tr>';
}
echo '</table>';
// Finalizar la salida HTML
echo '</body>';
echo '</html>';
// Cerrar conexiones
oci_free_statement($stid);
oci_free_statement($cursor);
oci_close($conexion);
?>