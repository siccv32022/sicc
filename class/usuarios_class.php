<?php

include_once ("conexion_ps.class.php");

class Usuarios
{
    private $usuario;
    private $idRol;
    private $idModulo;
   
   public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }
   
    public function setIdRol($idRol) {
        $this->idRol = $idRol;
    }
    public function setIdModulo($idModulo) {
        $this->idModulo = $idModulo;
    }
    
    
    public function getUsuario() {
        return $this->usuario;
    }
    public function getIdRol() {
        return $this->idRol;
    }
    public function getIdModulo() {
        return $this->idModulo;
    }
   
     public function  Login(){
        $resultado = array();
        $resultado['exitoso'] = true;
        try {            
            $obj_conecion = new ConexionPDO('mysql');
            $parameter=[$this->getUsuario()];            
            $query = "call sicc.sp_getUserLogin(?)";
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
    
    public function  ModulosPorRol(){
        $resultado = array();
        $resultado['exitoso'] = true;
        try {            
            $obj_conecion = new ConexionPDO('mysql');
            $parameter=[$this->getIdRol()];
            $query = "call sicc.sp_getModulosPorRol(?);"; 
                   
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
    
 public function  ObtenerUsuarios(){
        $resultado = array();
        $resultado['exitoso'] = true;
        try {            
            $obj_conecion = new ConexionPDO('mysql');
            $parameter=null;
            $query = "call sicc.sp_getUsuarios();"; 
                   
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

    public function  ColumnasPorRol(){
        $resultado = array();
        $resultado['exitoso'] = true;
        try {            
            $obj_conecion = new ConexionPDO('mysql');
            //$parameter=[$this->getIdModulo()];
            $parameter=[2];
            $query = "call sicc.sp_getModulosColumnas(?);"; 
                   
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