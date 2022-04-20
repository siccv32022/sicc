<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


//$user= 'sa';
//$pass= 'SAPB1Admin';

$ldapconn=ldap_connect('192.168.1.56') or die ("Error en BBDD SAP!\n"); 

// Puesto que no se han especificado UID ni PWD en el array  $connectionInfo,
// La conexión se intentará utilizando la autenticación Windows.
$connectionInfo = array( "Database"=>"SPN_NEW", "UID"=>$user, "PWD"=>$pass);

?>