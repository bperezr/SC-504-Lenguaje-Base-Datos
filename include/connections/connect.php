<?php

function ConectarDB()
{
    $db = mysqli_connect('localhost', 'root', 'admin01', 'happypaws');

    if (!$db) {
        echo "Ocurrió un error al conectarse a la base de datos";
        exit;
    }
    return $db;
}
?>