<?php

$usuario= "PalmaWeb";
$clave= "BogotaCalle100"; 

if(!$conexion=odbc_connect('DRIVER={SQL Server};SERVER=192.168.1.245;DATABASE=CONTROL_OFIMAEnterprise', $usuario, $clave)){
    die('Error al conectarse a la base de datos');
}

return $conexion;

?>