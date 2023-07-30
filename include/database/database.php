<?php

function ConectarDB(){
    $db = mysqli_connect('localhost','root','admin','happypaws');

    if(!$db){
        echo "Ocurrió un error al conectarse a la base de datos";
        exit;
    } else {
        echo "Conexión exitosa";
    }

    return $db;
}
?>