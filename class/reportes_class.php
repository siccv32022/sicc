<?php

include_once ("conexion_psql.class.php");

class Reportes
{

    private $query;

    public function setQuery($query) {
        $this->query = $query;
    }
    public function getQuery() {
        return $this->query;
    }

    public function  getReport(){
        $resultado = array();
        $resultado['exitoso'] = true;
        try {            
            $obj_conecion = new ConexionPDOSQL('sqlsrv');         
            $parameter=[$_SESSION["fecha_inicio"],$_SESSION["fecha_fin"]];            
            $query=$this->getQuery();
            $result = $obj_conecion->ejecutarSentenciaPreparada($query,$parameter);
          
            if(!$result['exitoso'] || empty($result['exitoso'])){
                $resultado['exitoso'] = false;
            }
            if($resultado['exitoso']){
                $resultado['resultado'] = $result['resultado']; 
            }
                    
        } catch (Exception $fallo) {
            $resultado['exitoso'] = false;
            $resultado['mensaje'] = 'Fallo en la conexion PDO';
            echo $fallo->getMessage();
        }
        
        return $resultado;
    }
}