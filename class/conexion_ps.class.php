<?php

/**
 * Clase que establece las conexiones con la base de datos
 *
 * @author Eemendoza
 */
class ConexionPDO extends PDO {
    
    function __construct() {
         //$inicializacion = parse_ini_file("/home/sicc/sicc.ini", true); //PROD
         $inicializacion = parse_ini_file("C:/xampp/htdocs/sicc.ini", true);
        
        $conexion['server'] = $inicializacion['conexion']['server'];
        $conexion['base'] = $inicializacion['conexion']['database'];
        $conexion['user'] = $inicializacion['conexion']['userSession'];
        $conexion['pass'] = $inicializacion['conexion']['passwordSession'];
        parent::__construct("mysql:host=".$conexion['server'].";dbname=".$conexion['base'].";charset=utf8", $conexion['user'], $conexion['pass'], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }
    
    function ejecutarSentenciaPreparada($query, $parametros = null) {
        $resultado = array();
        $resultado['exitoso'] = true;
        
        try {
            $sentencia = $this->prepare($query);
            $sentencia->execute($parametros);
            $resultado['resultado'] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException  $exception) {
            $resultado['exitoso'] = false;
            $resultado['mensaje'] = $exception->getMessage();
        }

        return $resultado;
    }
	
  
      
    function ejecutarSentenciaPreparadaSalidas($query, $parametrosEntrada = null, &$parametrosSalida = null) {
        $resultado = array();
        $resultado['exitoso'] = true;
        
        try {
            $sentencia = $this->prepare($query);
            $resultado['exitoso'] = $sentencia->execute($parametrosEntrada);
            if($resultado['exitoso'] && $parametrosSalida != null && count($parametrosSalida) > 0) {
                $datosSalida = "SELECT ";
                for ($index = 0; $index < count($parametrosSalida); $index++) {
                    $datosSalida .= "@_".($index+1)." AS salida_".($index+1).", ";
                }
                $datosSalida = substr($datosSalida, 0, count($datosSalida) - 3) . ";";
                $resultadoSalida = $this->query($datosSalida)->fetchAll(PDO::FETCH_ASSOC);
                for ($index = 0; $index < count($parametrosSalida); $index++) {
                    $parametrosSalida[$index] = $resultadoSalida[0]['salida_'.($index+1)];
                }
            }
            
        } catch (PDOException $exception) {
            $resultado['exitoso'] = false;
            $resultado['mensaje'] = $exception->getTraceAsString();
            throw $exception;
        }
        
        return $resultado;
    }
}
?>