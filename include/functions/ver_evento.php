<?php
$id = $_GET['id'];
require 'include/connections/connect.php';
$db = ConectarDB();

$queryEventos = "SELECT
                e.*,
                p.nombre AS NombreProvincia,
                c.nombre AS NombreCanton,
                d.nombre AS NombreDistrito
                FROM eventos AS e
                JOIN provincia AS p ON e.idProvincia = p.idProvincia
                JOIN canton AS c ON e.idCanton = c.idCanton
                JOIN distrito AS d ON e.idDistrito = d.idDistrito
                WHERE idEvento = ${id}";
$resultEventos = mysqli_query($db, $queryEventos);
$evento = mysqli_fetch_assoc($resultEventos);

$queryProvincia = "SELECT idProvincia, nombre FROM provincia ORDER BY idProvincia";
$result = mysqli_query($db, $queryProvincia);

$queryCanton = "SELECT idCanton, nombre FROM canton ORDER BY idCanton";
$resultCanton = mysqli_query($db, $queryCanton);

$queryDistrito = "SELECT idDistrito, nombre FROM distrito ORDER BY idDistrito";
$resultDistrito = mysqli_query($db, $queryDistrito);

$requeridos = [];
$nombreEvento = $evento['nombreEvento'];
$lugar = $evento['Lugar'];
$fecha = $evento['fecha'];
$horaInicio = $evento['hora_inicio'];
$horaFin = $evento['hora_fin'];
$descripcion = $evento['descripcion'];
$provincia = $evento['idProvincia'];
$canton = $evento['idCanton'];
$distrito = $evento['idDistrito'];
$imagen = $evento['imagen'];
$nombreProvincia = $evento['NombreProvincia'];
$nombreCanton = $evento['NombreCanton'];
$nombreDistrito = $evento['NombreDistrito'];

?>