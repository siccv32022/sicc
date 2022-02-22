<?php
if(trim($_POST["usuario"]) != "" && trim($_POST["password"]) != "")
{
    include("../class/conn.php");
    include("../class/usuarios_class.php");

    if (isset($ldap['bind']) || true){
   //session_destroy();
   session_start();
   //session_cache_limiter('nocache,private');    
 
   $_SESSION['k_username']= strtolower($_POST['usuario']);
   
   //Obtener datos del usuario
    $User = new Usuarios();
    $User->setUsuario($_SESSION['k_username']);
    $DatosUsuario = $User->Login();

    $_SESSION['rol'] =null;
    if ($DatosUsuario['exitoso'] && count($DatosUsuario['resultado']) > 0) {
        
        foreach ($DatosUsuario['resultado'] as $row) {
        $_SESSION['rol'] = $row['descripcion'];
        $_SESSION['nombre'] = $row['nombre'];
        $_SESSION['id_rol'] = $row['id_rol'];
        $_SESSION['foto'] = $row['foto'];
        
        $_SESSION["presupuesto_fi"]=date("Y-m-d",strtotime('-10 days'));
		$_SESSION["presupuesto_ff"]=date('Y-m-d');

        $dn = "CN=users,DC=stones,DC=corp";
        $attrs = array("displayname","mail");  
        }

        Header("Location: ../mod_01_dashboard.php");
    }
    else{  
	    session_destroy();
        Header("Location: ../index.php?error=1");
    }

    }
    else{  
	    session_destroy();
        Header("Location: ../index.php?error=2");
    }
}
else 
{
	session_destroy();
        Header("Location: ../index.php?error=3");       
}
?>