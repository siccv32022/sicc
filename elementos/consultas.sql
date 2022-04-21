

   SELECT CONCAT ('(',UPPER(DATENAME(month,  GETDATE ())),' ',YEAR(GETDATE ()),')')
   SELECT CONCAT ('(',UPPER(DATENAME(month,  DATEADD(MM, -1,GETDATE()))),' ',YEAR(GETDATE ()),')')
   SELECT CONCAT ('(',UPPER(DATENAME(month,  DATEADD(MM, -2,GETDATE()))),' ',YEAR(GETDATE ()),')')
   SELECT CONCAT ('(HASTA ',UPPER(DATENAME(month,  DATEADD(MM, -3,GETDATE()))),'-',YEAR(GETDATE ()),')')
   SELECT CONCAT ('(2o SEM ',DATENAME(YEAR,  DATEADD(YY, -1,GETDATE())),')')
   SELECT CONCAT ('(1er SEM ',DATENAME(YEAR,  DATEADD(YY, -1,GETDATE())),')')
   SELECT CONCAT ('(ANTES DE ',DATENAME(YEAR,  DATEADD(YY, -1,GETDATE())),')')


   SELECT DATEADD(MM, -1,GETDATE())

   CONVERT(varchar,CV.DocDate,105) 
   CAST(ROUND(      DV.DiscPrcnt     ,2,1) AS DECIMAL(20,2))  
   Between TRY_PARSE (? as datetime using 'es-ES') and TRY_PARSE (? as datetime using 'es-ES');



----------------------------to update
update sicc.mod_modulos set query="" where id_modulo=19

----------------------------------------------------Presupuestos
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
            Order By CV.DocNum;
			
			
			
----------------------------------------------------------Pedidos

                    Select CP.DocNum 'PEDIDO',
                    (SELECT concat(FileName,'.',FileExt) as adj FROM ATC1 where AbsEntry= CP.AtcEntry FOR XML PATH ('Archivo'),Type, Root('Archivos')) AS ADJ,
                    convert(varchar, CP.DocDate, 105)  'FECHA CREADO',
                    convert(varchar, CP.DocDueDate, 105) 'FECHA VENCIMIENTO',
                    CP.CardCode 'CÓDIGO',
                    CP.Project 'OBRA',
                    CONCAT(CP.CardName,' / ', Convert(varchar(254),DM.AliasName))  'CLIENTE / ALIAS',        
                    VE.SlpName   'VENDEDOR',
                    CAST(ROUND(SUM(DP.Quantity),2,1) AS DECIMAL(20,4)) 'CANTIDAD PEDIDO',
                    CAST(ROUND(SUM(DP.DelivrdQty),2,1) AS DECIMAL(20,4)) 'CANTIDAD ENTREGADA',
                    CAST(ROUND(SUM(DP.OpenCreQty),2,1) AS DECIMAL(20,4)) 'CANTIDAD PENDIENTE'
            From RDR1 DP
            Join ORDR CP On DP.DocEntry = CP.DocEntry
            Left Join OSLP VE On CP.SlpCode = VE.SlpCode
            Left Join OITM AR On DP.Itemcode = AR.Itemcode And AR.Phantom <> 'Y'
            Left Join OCRD CL On CP.CardCode = CL.CardCode And  CL.GroupCode <> 116
            Left Join OCRD DM On CP.CardCode =  DM.CardCode
            Where CP.DocStatus = 'O'
            Group By CP.DocNum, CP.DocDate, CP.DocDueDate, CP.CardCode, CP.CardName, Convert(varchar(254),DM.AliasName), VE.SlpName,CP.Project, CP.AtcEntry 
            Order by CP.DocNum;


--------------------------------------------------------Ventas
            SELECT
                    CG.DocNum AS '# VENTA',
                    convert(varchar, CG.Fecha, 105) AS 'FECHA',
                    CONCAT(CG.Cliente, ' / ',CG.ClienteF) AS 'CLIENTE / ALIAS',
                    CG.Vendedor AS 'VENDEDOR',
                    CAST(ROUND(CG.Subtotal_USD,2,1) AS DECIMAL(20,2)) AS 'SUBTOTAL (USD)',
                    CAST(ROUND(CG.Impuesto_USD,2,1) AS DECIMAL(20,2)) AS 'IMPUESTO (USD)',
                    CAST(ROUND(CG.Total_USD,2,1) AS DECIMAL(20,2)) AS 'TOTAL (USD)',
                    -- CAST(ROUND((CG.Ganancia_USD/(CG.Subtotal_USD))*100,2,1) AS DECIMAL(20,2)) [Utilidad (USD)],
                    -- CAST(ROUND(CG.Ganancia_USD,2,1) AS DECIMAL(20,2)) [Ganancia (USD)],
                    ' bg-success ' AS 'AUX_TOTAL (USD)',
                    CAST(ROUND(CG.Subtotal_MXP,2,1) AS DECIMAL(20,2)) AS 'SUBTOTAL (MXN)',
                    CAST(ROUND( CG.Impuesto_MXP,2,1) AS DECIMAL(20,2)) AS 'IMPUESTO (MXN)',
                    CAST(ROUND(CG.Total_MXP,2,1) AS DECIMAL(20,2)) AS 'TOTAL (MXN)',
                    ' bg-success ' AS 'AUX_TOTAL (MXN)'
                    -- CAST(ROUND((CG.Ganancia_MXP/(CG.Subtotal_MXP))*100,2,1) AS DECIMAL(20,2)) [Utilidad (MXP)],
                    -- CAST(ROUND(CG.Ganancia_MXP,2,1) AS DECIMAL(20,2)) [Ganancia (MXP)]
                FROM(
                SELECT 
                    J0.DocNum,  
                    J0.DocDate                                           Fecha,
                    J0.CardName                                                              Cliente,
                    Convert(varchar(254),DM.AliasName) 												  ClienteF,
                    J1.SlpName                                                               Vendedor,
                    SUM(CASE When J0.DocCur = 'USD' Then DV.TotalFrgn Else 0 END)            Subtotal_USD,
                    SUM(CASE When J0.DocCur = 'USD' Then DV.VatSumFrgn Else 0 END)           Impuesto_USD,
                    SUM(CASE When J0.DocCur = 'USD' Then DV.TotalFrgn+DV.VatSumFrgn Else 0 END)       Total_USD,
                    SUM(CASE When J0.DocCur = 'USD' Then DV.GrssProfFC Else 0 END)           Ganancia_USD,
                    SUM(CASE When J0.DocCur = 'MXP' Then DV.LineTotal Else 0 END)            Subtotal_MXP,
                    SUM(CASE When J0.DocCur = 'MXP' Then DV.VatSum Else 0 END)               Impuesto_MXP,
                    SUM(CASE When J0.DocCur = 'MXP' Then DV.LineTotal+DV.VatSum Else 0 END)  Total_MXP,
                    SUM(CASE When J0.DocCur = 'MXP' Then DV.GrssProfit Else 0 END)         Ganancia_MXP
                FROM ODLN J0
                    join DLN1 DV On J0.DocEntry = DV.DocEntry
                    Join OITM AR On DV.Itemcode = AR.Itemcode And AR.Phantom <> 'Y'
                    Left Join OSLP J1 On J0.SlpCode = J1.SlpCode
                    Left Join OCRD DM On  J0.CardCode =  DM.CardCode
                Where DV.TargetType <> 16 AND J0.DocDate Between TRY_PARSE (? as datetime using 'es-ES') and TRY_PARSE (? as datetime using 'es-ES')
                Group By J0.DocNum, J0.DocDate, J0.CardName, J1.SlpName,Convert(varchar(254),DM.AliasName)) CG; 
				
				
   --------------------------------------------------Inventario
     
            Select CG.ItemCode AS 'CÓDIGO DEL ARTICULO',
                CG.Material AS 'DESCRIPCION',
                CG.proveedor AS 'NOMBRE EXTRANJERO',
                CG.Placas AS 'PLACA' ,
                CAST(ROUND(CG.M2,2,1) AS DECIMAL(20,2)) AS 'CANTIDAD M2',
                CAST(ROUND(CG.[M2 Apartados],2,1) AS DECIMAL(20,2)) AS 'M2 APARTADOS' ,
                CAST(ROUND(CG.[M2 Disponibles],2,1) AS DECIMAL(20,2)) AS 'M2 DISPONIBLES',
                CAST(ROUND(CG.[Antiguedad (Dias)],2,1) AS DECIMAL(20,2))  AS 'DIAS ULTIMA COMPRA',
                -- CG.[CostoMXP]/CG.TC [Costo Mex USD] ,
                -- CG.TC TC, 
                (select TOP 1 CONCAT( CAST(ROUND(ITM1.Price,2,1) AS DECIMAL(20,2)) , ' (', Currency,')') from ITM1 where ItemCode LIKE CG.ItemCode) 'COSTO EN ORIGEN',
                    CAST(ROUND(CG.[CompraMXP]/CG.TC,2,1) AS DECIMAL(20,2)) 'ÚLTIMA COMPRA C/GASTOS (USD)',
                    CAST(ROUND(CG.[ValorINMXP]/CG.TC,2,1) AS DECIMAL(20,2)) AS 'VALOR INVENTARIO',
                    CAST(ROUND(CG.PVP,2,1) AS DECIMAL(20,2)) as 'PVP',
                    CAST(ROUND(CG.[Valor Venta],2,1) AS DECIMAL(20,2)) 'VALOR VENTA',
                    CG.Moneda_PVP 'MONEDA PVP',
                    Case When CG.TC = 0 then 0 Else 
                    Case When CG.PVP = 0 then 0 Else 
                    Case When CG.Moneda_PVP = 'USD' Then CAST(ROUND(((CG.PVP-(CG.[CompraMXP]/CG.TC))/CG.PVP)*100,2,1) AS DECIMAL(20,2)) Else CAST(ROUND(((CG.PVP-(CG.[CompraMXP]))/CG.PVP)*100,2,1) AS DECIMAL(20,2)) End
                    End 
                End  AS 'UTILIDAD'   
            From(
            Select
                AR.ItemCode,
                DM.ItemName Material,
            DM.FrgnName proveedor,
                pl.Placas ,
                Round(Sum(AR.OnHand),2) M2,
                Round(Sum(AR.IsCommited),2) [M2 Apartados],
                Round(Sum(AR.OnHand)-Sum(AR.IsCommited),2) [M2 Disponibles],
                DateDiff(dd, pl.InDate, Convert(Date,GetDate())) [Antiguedad (Dias)],
                (SELECT Rate FROM ORTT WHERE RateDate = cast(GETDATE()as date) AND  Currency = 'USD') TC,
                Round (DM.LstEvlPric,2) [CostoMXP],
                --Round (DM.LastPurPrc,2) [CompraMXP],
                DM.U_Costo [CompraMXP],
                Round(Sum(AR.OnHand),2)*DM.LstEvlPric [ValorINMXP],
                pr.PVP,
                Round(Sum(AR.OnHand),2)*pr.PVP [Valor Venta],
                pr.Moneda_PVP
                    
                From OITW AR
                Join OITM DM On AR.ItemCode = DM.ItemCode
            Left Join (Select ItemCode,Count(*) Placas,MAX(InDate) InDate From OIBT Where Quantity > 0 and WhsCode in('BODEGA','BODEGA_G','PROTON','CORTADO','MUEBLES')  Group By ItemCode) pl On AR.ItemCode = pl.ItemCode
            Left Join (Select  ItemCode,Cast(Price As DECIMAL(18,4)) PVP,Currency Moneda_PVP From ITM1 Where PriceList = 3)pr On AR.ItemCode = pr.ItemCode
            Where DM.U_Formato IN('CO','PL','--') And DM.ItmsGrpCod <> 115 And frozenFor ='N' and WhsCode in('BODEGA','BODEGA_G','PROTON','CORTADO','MUEBLES')  
                Group By AR.ItemCode, DM.ItemName,pl.Placas,pl.InDate,pr.PVP,pr.Moneda_PVP,DM.LstEvlPric,DM.LastPurPrc,DM.FrgnName,DM.U_Costo
                ) CG where CG.M2>0
                Order By  CG.[Antiguedad (Dias)];


  --------------------------------------------------Entradas
     
            Select
                EE.DocNum '# ENTRADA',
                (SELECT concat(FileName,'.',FileExt) as adj FROM ATC1 where AbsEntry=EE.AtcEntry FOR XML PATH ('Archivo'),Type, Root('Archivos'))  AS 'ADJ',
                EE.CardName as 'PROVEEDOR',
                CONVERT(varchar,EE.DocDate,105) 'FECHA',
                ED.ItemCode 'CÓDIGO MATERIAL',
                ED.Dscription 'MATERIAL',
                CAST(ROUND(ED.Quantity,2,1) AS DECIMAL(20,4)) 'CANTIDAD M2',
                EE.U_CONTENEDOR 'CONTENEDOR',
                EE.Project 'DESTINO'
                --,EE.AtcEntry,
                --EE.DocDate
            From
                OPDN EE  Join
                PDN1 ED On EE.DocEntry = ED.DocEntry And ED.TargetType <> 21
                Left Join OPOR OC On ED.BaseRef = OC.DocNum and  OC.CANCELED like 'N'
            Where
                EE.DocDate Between TRY_PARSE (? as datetime using 'es-ES') and TRY_PARSE (? as datetime using 'es-ES') And
                ED.AcctCode Like '1170-0001-%'
                GROUP BY EE.DocNum, EE.CardName, EE.DocDate , ED.ItemCode , ED.Dscription ,ED.Quantity ,EE.U_CONTENEDOR ,EE.U_DESTINO , EE.Project , EE.AtcEntry, EE.DocDate  
                Order By EE.DocDate Desc ;
    

    ---------------------------------------------------------OfertaCompras
            Select
                OC.DocNum AS '#',
                (SELECT concat(FileName,'.',FileExt) as adj FROM ATC1 where AbsEntry=OC.AtcEntry FOR XML PATH ('Archivo'),Type, Root('Archivos'))  AS 'ADJ',
                OC.CardName 'PROVEEDOR',
                DC.Dscription 'MATERIAL',
                CAST(ROUND(DC.Price,2,1) AS DECIMAL(20,2)) 'P/U',
                CAST(ROUND(Case OC.DocCur When 'USD' Then DC.Quantity * DC.Price Else Null End,2,1) AS DECIMAL(20,2)) 'USD',
                CAST(ROUND(Case OC.DocCur When 'EUR' Then DC.Quantity * DC.Price Else Null End,2,1) AS DECIMAL(20,2)) 'EUR',
                CONVERT(varchar,OC.ReqDate,105) 'FECHA COLOCACIÓN',
                CONVERT(varchar,OC.DocDueDate,105) 'FECHA PROBABLE EMBARQUE',
                CAST(ROUND(DC.Quantity,2,1) AS DECIMAL(20,2)) 'CTD SOLICITADA',
                CAST(ROUND(DC.OpenCreQty,2,1) AS DECIMAL(20,2)) 'CTD ENTREGADA',
                CAST(ROUND((DC.Quantity - DC.OpenCreQty),2,1) AS DECIMAL(20,2)) 'CTD FALTANTE',
                OC.Comments 'COMENTARIOS',
                Convert(varchar(254),OC.U_Status) 'STATUS'
                ,'MAT' Tipo_Gasto
                , DC.TrgetEntry Ex_Orden 
                , Case OC.DocCur When 'MXP' Then DC.Quantity * DC.Price Else Null End MXP
                -- OC.AtcEntry
                From
                OPQT OC Join
                PQT1 DC On OC.DocEntry = DC.DocEntry Join
                OCTG CP On OC.GroupNum = CP.GroupNum Join
                OITM AR On DC.ItemCode = AR.ItemCode
                Where
                OC.DocStatus = 'O' And
                (AR.ItmsGrpCod <> 111 And
                AR.ItmsGrpCod <> 115) And 
                DC.LineStatus = 'O'
                Union All
                Select
                OC.DocNum AS '#',
                (SELECT concat(FileName,'.',FileExt) as adj FROM ATC1 where AbsEntry=OC.AtcEntry FOR XML PATH ('Archivo'),Type, Root('Archivos'))  AS 'ADJ',
                OC.CardName 'PROVEEDOR',
                DC.Dscription 'MATERIAL',
                CAST(ROUND(DC.Price,2,1) AS DECIMAL(20,2)) 'P/U',
                CAST(ROUND(Case OC.DocCur When 'USD' Then 1 * DC.Price Else Null End,2,1) AS DECIMAL(20,2)) USD,
                CAST(ROUND(Case OC.DocCur When 'EUR' Then 1 * DC.Price Else Null End,2,1) AS DECIMAL(20,2)) EUR,  
                CONVERT(varchar,OC.ReqDate,105) 'FECHA COLOCACIÓN',
                CONVERT(varchar,OC.DocDueDate,105) 'FECHA PROBABLE EMBARQUE',
                1 'CTD SOLICITADA',
                0 'CTD ENTREGADA',
                0 'CTD FALTANTE',
                OC.Comments 'COMENTARIOS',
                Convert(varchar(254),OC.U_Status) 'STATUS',
                'GASTO' Tipo_Gasto,
                DC.TrgetEntry Ex_Orden,
                Case OC.DocCur When 'MXP' Then 1 * DC.Price Else Null End MXP
                --OC.AtcEntry
                From
                OPQT OC Join
                PQT1 DC On OC.DocEntry = DC.DocEntry Join
                OCTG CP On OC.GroupNum = CP.GroupNum Left Join
                OPCH FC On DC.TrgetEntry = FC.DocEntry
                Where
                (OC.DocStatus = 'O') And
                OC.DocType = 'S';


   -----------------------------------------------------------Importaciones
            select 
            *,
            (SELECT concat(FileName,'.',FileExt) as adj FROM ATC1 where AbsEntry=AtcEntry FOR XML PATH ('Archivo'),Type, Root('Archivos'))  AS 'ADJ'
            from (
            Select
                           OC.DocNum #,
                           NULL AS 'OFERTA COMPRA',
                          -- (SELECT concat(FileName,'.',FileExt) as adj FROM ATC1 where AbsEntry=OC.AtcEntry FOR XML PATH ('Archivo'),Type, Root('Archivos'))  AS 'ADJ',
                           OC.CardName PROVEEDOR,
                           DC.Dscription MATERIAL,
                           CAST(ROUND(DC.Quantity,2,1) AS DECIMAL(20,2)) M2,
                           CAST(ROUND(DC.Price,2,1) AS DECIMAL(20,2)) as 'P/U',
                           CAST(ROUND(Case OC.DocCur When 'USD' Then DC.Quantity * DC.Price Else Null End,2,1) AS DECIMAL(20,2)) USD,
                           CAST(ROUND(Case OC.DocCur When 'EUR' Then DC.Quantity * DC.Price Else Null End,2,1) AS DECIMAL(20,2)) EUR,
                           CAST(ROUND(Case OC.DocCur When 'MXP' Then DC.Quantity * DC.Price Else Null End,2,1) AS DECIMAL(20,2)) MXP,
                           CONVERT(varchar,OC.DocDueDate,105) 'FECHA PROBABLE LLEGADA',
                           CONVERT(varchar,OC.TaxDate + CP.ExtraDays,105) 'PLAZO DE PAGO',
                           OC.U_CONTENEDOR CONTENEDOR,
                           concat(OC.U_DESTINO,' / ',OC.Project) DESTINO,
                           OC.NumAtCard referencia,
                           'MAT' Tipo_Gasto,                  
                           OC.Comments COMENTARIOS,
                           OC.U_FPUERTO Fecha_Puerto,
                           OC.AtcEntry,
                           OC.U_VENDEDOR
                       From
                           OPOR OC Join
                           POR1 DC On OC.DocEntry = DC.DocEntry Join
                           OCTG CP On OC.GroupNum = CP.GroupNum Join
                           OITM AR On DC.ItemCode = AR.ItemCode
                       Where
                           OC.DocStatus = 'O' And
                           (AR.ItmsGrpCod <> 111 And
                           AR.ItmsGrpCod <> 115)
                       Union
                       Select
                           OC.DocNum #,
                           NULL AS 'OFERTA COMPRA',
                          -- (SELECT concat(FileName,'.',FileExt) as adj FROM ATC1 where AbsEntry= OC.AtcEntry FOR XML PATH ('Archivo'),Type, Root('Archivos')) AS ADJ,
                           OC.CardName PROVEEDOR,
                           DC.Dscription MATERIAL,
                           CAST(ROUND(1,2,1) AS DECIMAL(20,2)) M2,
                           CAST(ROUND(DC.Price,2,1) AS DECIMAL(20,2)) as 'P/U',
                           CAST(ROUND(Case OC.DocCur When 'USD' Then 1 * DC.Price Else Null End,2,1) AS DECIMAL(20,2)) USD,
                           CAST(ROUND(Case OC.DocCur When 'EUR' Then 1 * DC.Price Else Null End,2,1) AS DECIMAL(20,2)) EUR,
                           CAST(ROUND(Case OC.DocCur When 'MXP' Then 1 * DC.Price Else Null End,2,1) AS DECIMAL(20,2)) MXP,
                           CONVERT(varchar,OC.DocDueDate,105) 'FECHA PROBABLE LLEGADA',
                           CONVERT(varchar,OC.TaxDate + CP.ExtraDays,105) 'PLAZO DE PAGO',
                           OC.U_CONTENEDOR CONTENEDOR,
                           concat(OC.U_DESTINO,' / ',OC.Project) DESTINO,
                       
                           OC.NumAtCard referencia,
                           'GASTO' Tipo_Gasto,  
                           OC.Comments Comentarios,
                           OC.U_FPUERTO Fecha_Puerto,  
                           OC.AtcEntry,
                           OC.U_VENDEDOR
                       From
                           OPOR OC Join
                           POR1 DC On OC.DocEntry = DC.DocEntry Join
                           OCTG CP On OC.GroupNum = CP.GroupNum Left Join
                           OPCH FC On DC.TrgetEntry = FC.DocEntry
                       Where
                           (OC.DocStatus = 'O' OR FC.DocStatus = 'O') And
                           OC.DocType = 'S'
                           ) AS RF;

   ---------------------------------------------------------NotaEntregas
            Select 
                CV.DocNum '# NOTA DE ENTREGA',
                CASE When CV.Series = 45 Then 'CF' Else 'CR' END TIPO,
                CF.DocNum  '# FACTURA',
                (SELECT concat(FileName,'.',FileExt) as adj FROM ATC1 where AbsEntry= CV.AtcEntry FOR XML PATH ('Archivo'),Type, Root('Archivos')) AS ADJ,
                CONVERT(varchar,CV.DocDate,105) FECHA,
                CV.CardCode 'COD/CLIENTE',
                concat(CV.CardName,' / ',Convert(varchar(254),DC.AliasName)) CLIENTE,
                DV.ItemCode MATERIAL,
                DV.Dscription DESCRIPCION,
                CAST(ROUND(DV.Quantity,2,1) AS DECIMAL(20,2)) M2,
                CAST(ROUND(CASE WHEN DV.Currency = 'MXP' THEN DV.Price/TC.Rate ELSE DV.Price END,2,1) AS DECIMAL(20,2)) PU,
                CAST(ROUND(CASE WHEN DV.Currency = 'MXP' THEN DV.LineTotal/TC.Rate ELSE DV.TotalFrgn END,2,1) AS DECIMAL(20,2)) SUBTOTAL,
                CAST(ROUND(DV.LineVatS,2,1) AS DECIMAL(20,2)) IVA,
                CAST(ROUND(CASE WHEN DV.Currency = 'MXP' THEN (DV.LineTotal/TC.Rate)+DV.LineVatS ELSE DV.TotalFrgn+DV.LineVatS END,2,1) AS DECIMAL(20,2)) TOTAL,
                CV.DocCur AS MONEDA,
                T2.SlpName as VENDEDOR,
                CV.U_Soporte_doc Soporte
            FROM DLN1 DV
            JOIN ODLN CV ON DV.DocEntry = CV.DocEntry
            join OCRD DC ON CV.CardCode = DC.CardCode
            Join ORTT TC ON CV.DocDate = TC.RateDate AND TC.Currency = 'USD'
            left Join OINV CF on CF.DocEntry = DV.TrgetEntry
            INNER JOIN OSLP T2 ON T2.SlpCode = CV.SlpCode
            WHERE  CV.DocDate  Between  TRY_PARSE (? as datetime using 'es-ES') and TRY_PARSE (? as datetime using 'es-ES')
            Order By CV.DocNum;

  ----------------------------------------------------------Pagos
            Select CG.Codigo CÓDIGO,
                CG.SN PROVEEDOR,
                CASE When CG.MDA ='EUR' Then CAST(ROUND(SUM(CG.Importe),2,1) AS DECIMAL(20,2)) Else NULL end as EUR,
                CASE When CG.MDA ='USD' Then CAST(ROUND(SUM(CG.Importe),2,1) AS DECIMAL(20,2)) Else NULL end as USD,
                CASE When CG.MDA ='MXP' Then CAST(ROUND(SUM(CG.Importe),2,1) AS DECIMAL(20,2)) Else NULL end as MXP
                --CG.MDA Moneda,
                --SUM(CG.Importe) [Total Cartera],
                --SUM(CG.PP) [Pendiente de Pago],
                --Case When SUM(CG.R07)  = 0 Then Null Else SUM(CG.R07)  End [Semana 1],
                --Case When SUM(CG.R814) = 0 Then Null Else SUM(CG.R814) End [Semana 2]
            From 
            (Select
            T1.CardCode Codigo,
            T1.CardName SN,
            T1.Currency MDA,
            Case When T0.TransType = 18 Then 'FACTURA' 
                When T0.TransType = 19 Then 'NC'
                When T0.TransType = 204 Then 'F ANTICIPO'
                Else 'PAGO'
            End Tipo_Operacion,
            T0.BaseRef SAP,
            T0.DueDate Vence,
            Case When T0.BalFcCred <> 0 Then T0.BalFcCred Else -T0.BalFcDeb End Importe,
            Case
                When DateDiff(dd, Convert(Date,(getdate()- (datepart(dw,getdate())-1))), T0.DueDate) >= 0 Then DateDiff(dd,
                Convert(Date,(getdate()- (datepart(dw,getdate())-1))), T0.DueDate) Else Null End [Dias por Vencer],
            Case When DateDiff(dd, Convert(Date,(getdate()- (datepart(dw,getdate())-1))), T0.DueDate) > 0 Then Null
                else 
                Case When T0.BalFcCred = 0 Then -T0.BalFcDeb Else T0.BalFcCred End
            End PP,
            Case When DateDiff(dd, Convert(Date,(getdate()- (datepart(dw,getdate())-1))), T0.DueDate) < 0 Then Null
                When DateDiff(dd, Convert(Date,(getdate()- (datepart(dw,getdate())-1))), T0.DueDate) Between 0 And 6 Then
                Case When T0.BalFcCred = 0 Then -T0.BalFcDeb Else T0.BalFcCred End Else Null
            End R07,
            Case When DateDiff(dd, Convert(Date,(getdate()- (datepart(dw,getdate())-1))), T0.DueDate) < 0 Then Null
                When DateDiff(dd, Convert(Date,(getdate()- (datepart(dw,getdate())-1))), T0.DueDate) >= 7 Then
                Case When T0.BalFcCred = 0 Then -T0.BalFcDeb Else T0.BalFcCred End Else Null
            End R814
            From
            JDT1 T0 Join
            OCRD T1 On T0.ShortName = T1.CardCode
            Where
            T1.CardType = 'S' And
            (T0.BalFcDeb <> 0 Or
                T0.BalFcCred <> 0)
            Union
            Select
                T1.CardCode Codigo,
                T1.CardName SN,
                T1.Currency MDA,
                Case When T0.TransType = 18 Then 'FAC' When T0.TransType = 19 Then 'NC'
                When T0.TransType = 204 Then 'ANT' Else 'PAGO' End Tipo_Operacion,
                T0.BaseRef SAP,
                T0.DueDate Vence,
                Case When T0.BalDueCred <> 0 Then T0.BalDueCred Else -T0.BalDueDeb End Importe,
                Case When DateDiff(dd, Convert(Date,(GetDate() - (DatePart(dw, GetDate()) -1))), T0.DueDate) >= 0 
                Then DateDiff(dd, Convert(Date,(GetDate() - (DatePart(dw, GetDate()) - 1))), T0.DueDate) 
                Else Null End [Dias por Vencer],
                Case When DateDiff(dd, Convert(Date,(GetDate() - (DatePart(dw, GetDate()) -1))), T0.DueDate) > 0 
                        Then Null Else Case When T0.BalDueCred = 0 Then -T0.BalDueDeb Else T0.BalDueCred End 
                End PP,
                Case When DateDiff(dd, Convert(Date,(GetDate() - (DatePart(dw, GetDate()) -1))), T0.DueDate) < 0 
                        Then Null When DateDiff(dd, Convert(Date,(GetDate() - (DatePart(dw, GetDate()) -1))), T0.DueDate) Between 0 And 6 
                        Then Case When T0.BalDueCred = 0 Then -T0.BalDueDeb Else T0.BalDueCred End Else Null 
                End R07,
                Case When DateDiff(dd, Convert(Date,(GetDate() - (DatePart(dw, GetDate()) -1))), T0.DueDate) < 0 
                        Then Null When DateDiff(dd, Convert(Date,(GetDate() - (DatePart(dw, GetDate()) -1))), T0.DueDate) Between 7 And 13 
                        Then Case When T0.BalDueCred = 0 Then -T0.BalDueDeb Else T0.BalDueCred End Else Null 
                End R814
            From
                JDT1 T0 Join
                OCRD T1 On T0.ShortName = T1.CardCode
            Where
                T1.CardType = 'S' And T1.Currency = 'MXP' And
                (T0.BalDueDeb <> 0 Or
                T0.BalDueCred <> 0)
                ) CG
            Where CG.MDA <> '##'
            Group By CG.Codigo,CG.SN,CG.MDA
            Order By CG.SN;

 -------------------------------------------------Taller
            Select COF.DocNum '# ORDEN DE CORTE',
            CONVERT(varchar,COF.PostDate,105) 'FECHA CREADO',
            CONVERT(varchar,COF.DueDate,105) 'FECHA VENCIMIENTO',
            Case COF.Status When 'P' Then 'Planificado' When 'R' Then 'Cortando' Else '' End ETAPA,       
            VEN.SlpName VENDEDOR,
            DMA.ItemName MATERIAL,
            CAST(ROUND(DOF.PlannedQty,4,1) AS DECIMAL(20,4)) 'CANTIDAD A CORTAR',
            CAST(ROUND(DOF.IssuedQty,4,1) AS DECIMAL(20,4)) 'CANTIDAD ENTREGADA',
            CAST(ROUND(COF.CmpltQty,4,1) AS DECIMAL(20,4)) 'CANTIDAD RECIBIDA',
            COF.Comments 'STATUS',
            CASE WHEN DATEDIFF(day, COF.DueDate , GETDATE()) > 0 THEN ' bg-danger ' ELSE (CASE WHEN DATEDIFF(day, COF.DueDate , GETDATE()) >= -2 THEN ' bg-warning ' ELSE ' bg-success ' END) END  AS 'AUX_STATUS'
        From WOR1 DOF
        Join OITM DMA On DMA.ItemCode = DOF.ItemCode
        Join OWOR COF On DOF.DocEntry = COF.DocEntry
        Left Join ORDR PED On PED.DocNum = COF.OriginNum
        Left Join OSLP VEN On VEN.SlpCode = PED.SlpCode
        Where (COF.Status <> 'L' AND COF.Status <> 'C') And DOF.IssueType = 'M';
		

   -------------------------------------------------OCCerradas
            Select
                OC.DocNum AS #,
                (SELECT concat(FileName,'.',FileExt) as adj FROM ATC1 where AbsEntry=OC.AtcEntry FOR XML PATH ('Archivo'),Type, Root('Archivos'))  AS ADJ,
                OC.CardName PROVEEDOR,
                DC.Dscription MATERIAL,
                DC.Price 'P/U',
                Case OC.DocCur When 'USD' Then DC.Quantity * DC.Price Else Null End USD,
                Case OC.DocCur When 'EUR' Then DC.Quantity * DC.Price Else Null End EUR,
                CONVERT(varchar,OC.ReqDate,105) 'FECHA COLOCACIÓN',
                CONVERT(varchar,OC.DocDate,105) 'FECHA PROBABLE EMBARQUE',
                --Case OC.DocCur When 'MXP' Then DC.Quantity * DC.Price Else Null End MXP,
                DC.Quantity 'CTD SOLICITADA',
                DC.OpenCreQty 'CTD ENTREGADA',
                (DC.Quantity - DC.OpenCreQty) 'CTD FALTANTE',
                OC.Comments COMENTARIOS,
                Convert(varchar(254),OC.U_Status) STATUS,
                CASE WHEN DATEDIFF(day, OC.DocDueDate , GETDATE()) > 0 THEN ' bg-danger ' ELSE (CASE WHEN DATEDIFF(day, OC.DocDueDate , GETDATE()) >= -2 THEN ' bg-warning ' ELSE ' bg-success ' END) END  AS 'AUX_STATUS',
                DC.TrgetEntry Ex_Orden,  
                OC.AtcEntry,  
                'MAT' Tipo_Gasto
                From
                OPQT OC Join
                PQT1 DC On OC.DocEntry = DC.DocEntry Join
                OCTG CP On OC.GroupNum = CP.GroupNum Join
                OITM AR On DC.ItemCode = AR.ItemCode    
                Where
                OC.DocStatus = 'c' And
                (AR.ItmsGrpCod <> 111 And
                AR.ItmsGrpCod <> 115) And 
                DC.LineStatus = 'c' and 
                DATEDIFF(DD, OC.DocDate, getdate()) < = 365   order by OC.DocDate desc;

 ---------------------------------------------------------FactProv
            SELECT T0.DocNum '# FACTURA',
                (SELECT concat(FileName,'.',FileExt) as adj FROM ATC1 where AbsEntry=T0.AtcEntry  FOR XML PATH ('Archivo'),Type, Root('Archivos'))  AS 'ADJ',
                T0.NumAtCard 'REFERENCIA #',
                CONVERT(varchar,T0.DocDate,105) 'FECHA',
                T0.CardCode 'COD PROVEEDOR',
                T0.CardName 'PROVEEDOR',
                T1.Dscription 'DESCRIPCIÓN',
                CAST(ROUND(T1.Quantity,2,1) AS DECIMAL(20,4)) 'CANTIDAD',
                CAST(ROUND(T1.Price,2,1) AS DECIMAL(20,2)) 'P/U',
                T1.Currency 'MONEDA',
                T0.U_CONTENEDOR 'CONTENEDOR'
                FROM OPCH T0  INNER JOIN PCH1 T1 ON T0.DocEntry = T1.DocEntry
                WHERE  T0.DocType = 'I' 
                and T0.DocDate  Between TRY_PARSE (? as datetime using 'es-ES') and TRY_PARSE (? as datetime using 'es-ES');



        ------------------------------------------------------------Entrega-Dev
update sicc.mod_modulos set query="
  Select 
       concat ('E ',CV.DocNum) '# ENTREGA - DEVOLUCION',
	   --CV.DocNum 'Entrega',
       CASE When CV.Series = 45 Then 'CF' Else 'CR' END TIPO,
       CF.DocNum  'FACTURA #',
	   (SELECT concat(FileName,'.',FileExt) as adj FROM ATC1 where AbsEntry= CV.AtcEntry  FOR XML PATH ('Archivo'),Type, Root('Archivos'))  AS 'ADJ',
        CONVERT(varchar,CV.DocDate,105) FECHA,
       CV.CardCode 'COD/CLIENTE',
       CONCAT(CV.CardName, ' / ',Convert(varchar(254),DC.AliasName) ) CLIENTE,
       DV.ItemCode MATERIAL,
       DV.Dscription DESCRIPCIÓN,
       CAST(ROUND(DV.Quantity,2,1) AS DECIMAL(20,4)) M2,
	   CAST(ROUND( CASE WHEN DV.Currency = 'MXP' THEN DV.PriceBefDi ELSE DV.PriceBefDi END,2,1) AS DECIMAL(20,2)) 'P/U',
	   CAST(ROUND(CASE WHEN DV.Currency = 'MXP' THEN DV.LineTotal ELSE DV.TotalFrgn-CV.DiscSumFC END,2,1) AS DECIMAL(20,2)) SUBTOTAL,
       CAST(ROUND(CASE WHEN DV.Currency = 'MXP' THEN DV.LineVat  ELSE  DV.LineVatS END,2,1) AS DECIMAL(20,2)) IVA,
	   CAST(ROUND(CASE WHEN DV.Currency = 'MXP' THEN DV.LineTotal+DV.LineVat ELSE DV.TotalFrgn+DV.LineVatS-CV.DiscSumFC END,2,1) AS DECIMAL(20,2)) TOTAL,
	   T2.SlpName as VENDEDOR,
	   CAST(ROUND((DV.VatPrcnt/100),2,1) AS DECIMAL(20,2)) '% Iva',	 
	   CV.U_Soporte_doc Soporte,
       CV.AtcEntry,
	   CV.DocCur AS MON
	    
  FROM DLN1 DV
  JOIN ODLN CV ON DV.DocEntry = CV.DocEntry
   join OCRD DC ON CV.CardCode = DC.CardCode
  Join ORTT TC ON CV.DocDate = TC.RateDate AND TC.Currency = 'USD'
  left Join OINV CF on CF.DocEntry = DV.TrgetEntry
  INNER JOIN OSLP T2 ON T2.SlpCode = CV.SlpCode
  WHERE  CV.DocDate  Between TRY_PARSE (? as datetime using 'es-ES') and TRY_PARSE (? as datetime using 'es-ES');
" where id_modulo=20


        -----------------------------------------------------------PEFA
update sicc.mod_modulos set query="
 SELECT 
    Ccliente AS CCLIENTE, Nombre AS NOMBRE, Proyecto AS PROYECTO, Moneda AS MONEDA,
     CAST(ROUND( sum (CASE WHEN Datos = 'Entregas' THEN MXP ELSE 0 END),2,1) AS DECIMAL(20,2)) 'ENTREGAS MXP',
     CAST(ROUND(sum (CASE WHEN Datos = 'Entregas' THEN USD ELSE 0 END),2,1) AS DECIMAL(20,2)) 'ENTREGAS USD',
     CAST(ROUND(sum (CASE WHEN Datos = 'Entregas' THEN EUR ELSE 0 END),2,1) AS DECIMAL(20,2)) 'ENTREGAS EUR',
     CAST(ROUND(sum (CASE WHEN Datos = 'Facturas' THEN MXP ELSE 0 END),2,1) AS DECIMAL(20,2)) 'FACTURAS MXP',
     CAST(ROUND(sum (CASE WHEN Datos = 'Facturas' THEN USD ELSE 0 END),2,1) AS DECIMAL(20,2)) 'FACTURAS USD',
     CAST(ROUND(sum (CASE WHEN Datos = 'Facturas' THEN EUR ELSE 0 END),2,1) AS DECIMAL(20,2)) 'FACTURAS EUR',
     CAST(ROUND(sum (CASE WHEN Datos = 'Pedidos' THEN MXP ELSE 0 END),2,1) AS DECIMAL(20,2)) 'PEDIDOS MXP',
     CAST(ROUND(sum (CASE WHEN Datos = 'Pedidos' THEN USD ELSE 0 END),2,1) AS DECIMAL(20,2)) 'PEDIDOS USD',
     CAST(ROUND(sum (CASE WHEN Datos = 'Pedidos' THEN EUR ELSE 0 END),2,1) AS DECIMAL(20,2)) 'PEDIDOS EUR',
     CAST(ROUND(sum (CASE WHEN Datos = 'Anticipos' THEN MXP ELSE 0 END),2,1) AS DECIMAL(20,2)) 'ANTICIPOS MXP',
     CAST(ROUND(sum (CASE WHEN Datos = 'Anticipos' THEN USD ELSE 0 END),2,1) AS DECIMAL(20,2)) 'ANTICIPOS USD',
     CAST(ROUND(sum (CASE WHEN Datos = 'Anticipos' THEN EUR ELSE 0 END),2,1) AS DECIMAL(20,2)) 'ANTICIPOS EUR'
    FROM View_DetalleClientes
    WHERE Moneda NOT IN (SELECT Moneda FROM View_DetalleClientes WHERE Moneda = '##') AND Ccliente NOT like 'P%'
    group by Ccliente, Nombre, Proyecto, Moneda
" where id_modulo=22



