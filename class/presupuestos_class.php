<?php

include_once ("conexion_psql.class.php");

class Presupuestos
{
    public function  getPresupuestos(){
        $resultado = array();
        $resultado['exitoso'] = true;
        try {            
            $obj_conecion = new ConexionPDOSQL('sqlsrv');
            //$parameter=[date_create_from_format('Y-m-d',$_SESSION["presupuesto_fi"]),date_create_from_format('Y-m-d',$_SESSION["presupuesto_ff"])];            
            $parameter=[$_SESSION["presupuesto_fi"],$_SESSION["presupuesto_ff"]];            
            $query="
            Select DISTINCT 
                CV.DocNum AS '# PRE',
                CASE When CV.Series = 45 Then 'CF' Else 'CR' END AS 'AUX_TIPO',
                DV.TrgetEntry   AS '# PEDIDO',
                CONVERT(varchar,CV.DocDate,105) AS  'F DE DOC',
				CASE WHEN DATEDIFF(day, CV.DocDate , GETDATE()) > 30 THEN ' bg-danger ' ELSE (CASE WHEN DATEDIFF(day, CV.DocDate , GETDATE()) > 15 THEN ' bg-warning ' ELSE ' bg-success ' END) END  AS 'AUX_F DE DOC',
                CV.CardCode AS 'COD. CLIENTE',
                CV.CardName + '/'+ Convert(varchar(254),DM.AliasName) AS 'CLIENTE/ALIAS',
				CV.Project AS 'OBRA',			
                VD.SlpName AS 'VENDEDOR',
				CAST(ROUND(DV.DiscPrcnt,2,1) AS DECIMAL(20,2))  AS 'DESC POR PARTIDA',				
                CASE WHEN DV.Currency = 'MXP' THEN 
					 CAST(ROUND((select SUM(LineTotal) from QUT1 where QUT1.DocEntry=CV.DocNum)/TC.Rate,2,1) AS DECIMAL(20,2)) 
				ELSE 
					 CAST(ROUND((select SUM(TotalFrgn) from QUT1 where QUT1.DocEntry=CV.DocNum),2,1) AS DECIMAL(20,2)) END AS 'SUBTOTAL',
			    CAST(ROUND(CV.DiscPrcnt,2,1) AS DECIMAL(20,2)) AS 'DESC POR DOC.',
				CAST(ROUND(CV.VatSumFC,2,1) AS DECIMAL(20,2)) AS 'IVA',
                CASE WHEN DV.Currency = 'MXP' THEN  CAST(ROUND((CV.DocTotalFC/TC.Rate)+DV.LineVatS,2,1) AS DECIMAL(20,2)) ELSE  CAST(ROUND(CV.DocTotalFC,2,1) AS DECIMAL(20,2)) END AS 'TOTAL',
                CAST(ROUND(CV.DiscPrcnt,2,1) AS DECIMAL(20,2)) AS 'DESC POR DOC.s AUTO.',
                NULL AS 'DESC POR PARTIDA AUTO.',
                NULL AS 'DECUENTO POR DOC.s AUTO.',
                NULL AS 'OPCIONES'
                FROM QUT1 DV
            JOIN OQUT CV ON DV.DocEntry = CV.DocEntry
            Join ORTT TC ON CV.DocDate = TC.RateDate AND TC.Currency = 'USD'
            Left Join OSLP VD On CV.SlpCode = VD.SlpCode
            Left Join OCRD DM On  CV.CardCode =  DM.CardCode
            WHERE CV.DocStatus = 'O' And CV.DocDate Between  TRY_PARSE (? as datetime using 'es-ES') and TRY_PARSE (? as datetime using 'es-ES')
            Order By CV.DocNum;";
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