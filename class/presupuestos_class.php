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
            //$parameter=[date_create_from_format('Y-m-d',$_SESSION["presupuesto_fi"]),date_create_from_format('Y-m-d',$_SESSION["presupuesto_ff"])];            
            $parameter=[$_SESSION["presupuesto_fi"],$_SESSION["presupuesto_ff"]];            
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