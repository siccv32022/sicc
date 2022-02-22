<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Datos para establecer la conexion con la base de mysql.
////////////////////////////////////////////////////////
///	Actualización de funciones para la conexión de MySQLi
////////////////////////////////////////////////////////
//datos para establecer la conexion con la base de mysql.

$db_host = "127.0.0.1";
$db_username = "root";
$db_passwd = "";
$db_name= "sicc";
$db_mysql=@mysqli_connect($db_host, $db_username, $db_passwd,$db_name) or die ("Error en BBDD SICC!\n");
//echo "<h1> <font color=green>Coneccióm establecida.<br>"; 

//Conexión al 192.168.1.111
//$ldap['conn']=ldap_connect('192.168.1.111')or die("Could not connect to "); 

//Datos para establecer conexion base de datos SAP
$serverName = '192.168.1.160';
$user= 'sa';
$pass= 'Cpn21da';

//$user= 'sa';
//$pass= 'SAPB1Admin';

$ldap['conn']=ldap_connect('192.168.1.56') or die ("Error en BBDD SAP!\n"); 

// Puesto que no se han especificado UID ni PWD en el array  $connectionInfo,
// La conexión se intentará utilizando la autenticación Windows.
$connectionInfo = array( "Database"=>"SPN_NEW", "UID"=>$user, "PWD"=>$pass);
$conn = sqlsrv_connect( $serverName, $connectionInfo) or die ("Error en servidor de dominio \n");


if( $conn ) {
	echo("<script>console.log('PHP: Conexión establecida');</script>");
}else{
    echo "<script>console.log('PHP: Conexión NO establecida');</script>";
                          die( print_r( sqlsrv_errors(), true));
                          echo "</br>FINISH<br />";
}
?>