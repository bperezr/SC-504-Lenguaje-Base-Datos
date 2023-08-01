<?php

function ConectarDB()
{
    $db = mysqli_connect('localhost', 'root', '1234567', 'happypaws');

    if (!$db) {
        echo "Ocurrió un error al conectarse a la base de datos";
        exit;
    }
    return $db;
}
?>