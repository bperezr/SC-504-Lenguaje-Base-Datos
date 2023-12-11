<?php

$user = "happypaws";
$pass = "12345";
$host = "localhost/orcldb";
$dbconn = oci_connect($user, $pass, $host);
if(!$dbconn){
 $e = oci_error(); trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR); 
} else {
  echo "Conexión exitosa a la base de datos de Oracle 19C";
} 

?>




