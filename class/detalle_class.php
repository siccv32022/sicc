<?php

include_once ("conexion_psql.class.php");

class Detalle
{
    private $idConsulta;
    private $query;
    

    public function setQuery($query) {
        $this->query = $query;
    }
    public function getQuery() {
        return $this->query;
    }

    public function setidConsulta($idConsulta) {
        $this->idConsulta = $idConsulta;
    }
    public function getidConsulta() {
        return $this->idConsulta;
    }



    public function  getReport($id){
        $resultado = array();
        $resultado['exitoso'] = true;
        try {            
            $obj_conecion = new ConexionPDOSQL('sqlsrv');         
            $parameter=[$id];            
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