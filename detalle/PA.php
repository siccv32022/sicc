<html>
<head>
<title>PAGO</title>
</head>
<link rel="stylesheet" type="text/css" href="style/spn.css" />
<link rel="stylesheet" href="css/tab-view.css" type="text/css" media="screen">
<script type="text/javascript" src="js/tab-view.js"></script>
<script src="js/jquery.min.js" type="text/javascript"> </script>
<script src="js/jquery.fixedtableheader-1-0-2-m.min.js" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function() {
$('.tbl').fixedtableheader({
		headerrowsize:1}
		);
		}
		);
</script>

<div align="center">
<?php session_start();
$DOC=$_GET['nsap'];
$TS=$_GET['tsn'];

if (isset($_SESSION['k_username'])) {
	
	include("conn.php");
if (!$conn) {
    die('Unable to connect or select database!');
}

if($TS=='S') 
	{
	  $query_det="Select FA.CardCode CODIGO,
       FA.CardName NOMBRE,
       FA.NumAtCard REFERENCIA,
       FA.DocCur MONEDA,
       FA.DocRate TC,
       FA.DocNum DOCUMENTO,
       FA.DocDate FECHA_CON,
       FA.DocDueDate FECHA_VEN,
       FA.TaxDate FECHA_DOC,
       FA.FolioPref + '-' + CAST(FA.FolioNum AS Varchar) NUM_FOL,
       FA.DocType TIPO,
       DF.ItemCode NUM_ART,
       DF.Dscription ART,
       DF.Quantity CANTIDAD,
       DF.AcctCode CANTIDADS,
       Cast(DF.Price As Decimal(10,2)) PU,
       DF.Currency MON_LIN,
       DF.DiscPrcnt POR_DES,
       DF.TaxCode IND_IMPUESTO,
       CAST(Cast(Case When FA.CurSource = 'L' Then DF.LineTotal Else DF.TotalFrgn End As Decimal(10,2)) AS Varchar) + ' ' + CAST(DF.Currency As Varchar) TOTAL_LIN,
       CAST(Cast(Case When FA.CurSource = 'L' Then FA.DocTotal+FA.WTSum-FA.VatSum+FA.RoundDif+FA.DpmAmnt+FA.DiscSum Else FA.DocTotalFC+FA.WTSumFC-FA.VatSumFC+FA.RoundDifFC+FA.DpmAmntFC+FA.DiscSumFC End As Decimal(10,2)) AS Varchar) + ' ' + CAST(FA.DocCur AS Varchar) SUB_TOT,
       CAST(Cast(Case When FA.CurSource = 'L' Then FA.DiscSum Else FA.DiscSumFC End As Decimal(10,2)) AS Varchar) + ' ' + CAST(FA.DocCur AS Varchar) DESCUENTO,
       CAST(Cast(Case When FA.CurSource = 'L' Then FA.DpmAmnt Else FA.DpmAmntFC End As Decimal(10,2)) AS Varchar) + ' ' + CAST(FA.DocCur AS Varchar) ANTICIPO,
       CAST(Cast(Case When FA.CurSource = 'L' Then FA.RoundDif Else FA.RoundDifFC End As Decimal(10,2)) AS Varchar) + ' ' + CAST(FA.DocCur AS Varchar) REDONDEO,
       CAST(Cast(Case When FA.CurSource = 'L' Then FA.VatSum Else FA.VatSumFC End As Decimal(10,2)) AS Varchar) + ' ' + CAST(FA.DocCur AS Varchar) IMPUESTO,
       CAST(Cast(Case When FA.CurSource = 'L' Then FA.WTSum Else FA.WTSumFC End As Decimal(10,2)) AS Varchar) + ' ' + CAST(FA.DocCur AS Varchar) RETENCION,
       CAST(Cast(Case When FA.CurSource = 'L' Then FA.DocTotal Else FA.DocTotalFC End As Decimal(10,2)) AS Varchar) + ' ' + CAST(FA.DocCur AS Varchar) TOTAL,
       CAST(Cast(Case When FA.CurSource = 'L' Then FA.PaidSum Else FA.PaidSumFc End As Decimal(10,2)) AS Varchar) + ' ' + CAST(FA.DocCur AS Varchar) IMPORTE_APL,
       CAST(Cast(Case When FA.CurSource = 'L' Then FA.DocTotal - FA.PaidSum Else FA.DocTotalFC - FA.PaidSumFc End As Decimal(10,2)) AS Varchar) + ' ' + CAST(FA.DocCur AS Varchar) SALDO_PEN,
       FA.Comments COMENTARIOS
  From      OVPM FA
  Join      VPM2 DF On FA.DocEntry = DF.DocEntry
 Where FA.DocNum =".$DOC."";}
  
 else {
 			$query_det="Select FA.CardCode CODIGO,
       FA.CardName NOMBRE,
       FA.NumAtCard REFERENCIA,
       FA.DocCur MONEDA,
       FA.DocRate TC,
       FA.DocNum DOCUMENTO,
       FA.DocDate FECHA_CON,
       FA.DocDueDate FECHA_VEN,
       FA.TaxDate FECHA_DOC,
       FA.FolioPref + '-' + CAST(FA.FolioNum AS Varchar) NUM_FOL,
       FA.DocType TIPO,
       DF.ItemCode NUM_ART,
       DF.Dscription ART,
       DF.Quantity CANTIDAD,
       DF.AcctCode CANTIDADS,
       Cast(DF.Price As Decimal(10,2)) PU,
       DF.Currency MON_LIN,
       DF.DiscPrcnt POR_DES,
       DF.TaxCode IND_IMPUESTO,
       CAST(Cast(Case When FA.CurSource = 'L' Then DF.LineTotal Else DF.TotalFrgn End As Decimal(10,2)) AS Varchar) + ' ' + CAST(DF.Currency As Varchar) TOTAL_LIN,
       CAST(Cast(Case When FA.CurSource = 'L' Then FA.DocTotal+FA.WTSum-FA.VatSum+FA.RoundDif+FA.DpmAmnt+FA.DiscSum Else FA.DocTotalFC+FA.WTSumFC-FA.VatSumFC+FA.RoundDifFC+FA.DpmAmntFC+FA.DiscSumFC End As Decimal(10,2)) AS Varchar) + ' ' + CAST(FA.DocCur AS Varchar) SUB_TOT,
       CAST(Cast(Case When FA.CurSource = 'L' Then FA.DiscSum Else FA.DiscSumFC End As Decimal(10,2)) AS Varchar) + ' ' + CAST(FA.DocCur AS Varchar) DESCUENTO,
       CAST(Cast(Case When FA.CurSource = 'L' Then FA.DpmAmnt Else FA.DpmAmntFC End As Decimal(10,2)) AS Varchar) + ' ' + CAST(FA.DocCur AS Varchar) ANTICIPO,
       CAST(Cast(Case When FA.CurSource = 'L' Then FA.RoundDif Else FA.RoundDifFC End As Decimal(10,2)) AS Varchar) + ' ' + CAST(FA.DocCur AS Varchar) REDONDEO,
       CAST(Cast(Case When FA.CurSource = 'L' Then FA.VatSum Else FA.VatSumFC End As Decimal(10,2)) AS Varchar) + ' ' + CAST(FA.DocCur AS Varchar) IMPUESTO,
       CAST(Cast(Case When FA.CurSource = 'L' Then FA.WTSum Else FA.WTSumFC End As Decimal(10,2)) AS Varchar) + ' ' + CAST(FA.DocCur AS Varchar) RETENCION,
       CAST(Cast(Case When FA.CurSource = 'L' Then FA.DocTotal Else FA.DocTotalFC End As Decimal(10,2)) AS Varchar) + ' ' + CAST(FA.DocCur AS Varchar) TOTAL,
       CAST(Cast(Case When FA.CurSource = 'L' Then FA.PaidSum Else FA.PaidSumFc End As Decimal(10,2)) AS Varchar) + ' ' + CAST(FA.DocCur AS Varchar) IMPORTE_APL,
       CAST(Cast(Case When FA.CurSource = 'L' Then FA.DocTotal - FA.PaidSum Else FA.DocTotalFC - FA.PaidSumFc End As Decimal(10,2)) AS Varchar) + ' ' + CAST(FA.DocCur AS Varchar) SALDO_PEN,
       FA.Comments COMENTARIOS
  From      OVPM FA
  Join      VPM2 DF On FA.DocEntry = DF.DocEntry
 Where FA.DocNum =".$DOC."";
 	   }   

$result = sqlsrv_query($conn,$query_det);
$grid = sqlsrv_query($conn,$query_det);
	if($result==false)
	{
		echo 'No se puede conectar con la base de datos';
	}
	else
	{

		// CReacion de la Tabla HTML apartir de Consulta
        $row = sqlsrv_fetch_array($result);
				echo '
				<table width=100% height=100% >
					<tr height=20%>
						<td width="40%" valign="top">
							<table class="eti">
								<tr><td>Proveedor:</td><td><input type="text" id="cab" size="6" value="'.$row['CODIGO'].'" disabled></td></tr>
		        			   <tr><td>Nombre:</td><td><input type="text" id="cab" size="30" value="'.$row['NOMBRE'].'" disabled></td></tr>
								<tr><td>Referencia:</td><td><input type="text" id="cab" size="25" value="'.$row['REFERENCIA'].'" disabled></td></tr>
								<tr><td>Moneda:</td><td><input type="text" id="cab" size="6" value="'.$row['MONEDA'].'" disabled><input type="text" id="cab" size="6" value="'.$row['TC'].'" disabled></td></tr>
							</table>
						</td>
						
						<td width="20%">
							
						</td>
						<td width="40%" align="right" valign="top">
							<table class="eti">
								<tr><td>Numero:</td><td><input type="text" id="cab" size="8" value="'.$row['DOCUMENTO'].'" disabled></td></tr>
		        			   <tr><td>Fecha de Contabilizacion:</td><td><input type="text" id="cab" size="8" value="'.date("d/m/Y",strtotime($row['FECHA_CON'])).'" disabled></td></tr>
								<tr><td>Fecha de Vencimiento:</td><td><input type="text" id="cab" size="8" value="'.date("d/m/Y",strtotime($row['FECHA_VEN'])).'" disabled></td></tr>
								<tr><td>Fecha de Documento:</td><td><input type="text" id="cab" size="8" value="'.date("d/m/Y",strtotime($row['FECHA_DOC'])).'" disabled></td></tr>
								<tr><td>Numero Folio:</td><td><input type="text" id="cab" size="8" value="'.$row['NUM_FOL'].'" disabled></td></tr>
							</table>
						</td>

							
					</tr>
					<tr height=40% valign="top">
						
						<td colspan=3 style="background-color:#FFFFFF;">
							<div id="Tab" style="background-image: url(./style/fa.png);">
									<div class="dhtmlgoodies_aTab" >
							<table class="detalle"> 
							<thead>';
							if($row['TIPO']=='I') 
							{
								echo'
								<th width="15%">Articulo</th>
								<th width="40%">Descripcion del Articulo</th>
								<th width="5%">Cantidad</th>';
							}
							else 
							{
								echo'
								<th width="40%">Descripcion</th>
								<th width="12%">Cuenta de mayor</th>';
							};
							echo'	
							<th width="10%">PU</th>
							<th width="8%">% Desc</th>
							<th width="5%">Impuesto</th>
							<th width="10%">Total</th>
							</thead>
							<tbody >';
								while($row2 = sqlsrv_fetch_array($grid)) 
								{
								echo'	
								<tr>';
								    if($row['TIPO']=='I')
								    	{
								    		echo '
											<td style="text-align:left;">'.$row2['NUM_ART'].'</td>
											<td style="text-align:left;">'.$row2['ART'].'</td>
											<td>'.number_format(round((int)$row2['CANTIDAD'],2),2).'</td>';
										}
									  else 
									   {
									   	echo '
											<td style="text-align:left;">'.$row2['ART'].'</td>
											<td>'.$row2['CANTIDADS'].'</td>';
									   }; // If de TIPO
								echo '
								<td>'.number_format(round((int)$row2['PU'],2),2).' '.$row2['MON_LIN'].'</td>
								<td>'.number_format(round((int)$row2['POR_DES'],2),2).'</td>
								<td>'.$row2['IND_IMPUESTO'].'</td>
								<td> '.number_format(round((int)$row2['TOTAL_LIN'],2),2).'</td>
								</tr>';
								}; // While
							echo '</tbody></table>
						</div>
							<div class="dhtmlgoodies_aTab">
										Direccion
								</div>
							<div class="dhtmlgoodies_aTab" >
										Finanzas
								</div>
						</div>
						
						</td>
							
					</tr>	
					<tr height=30%>
						<td width="50%" colspan=2 valign="top">
							<table>
								<tr><td>Encargado de Compras:</td><td><input type="text" id="codigo" size="30" value="'.$row['EMPLEADO'].'" disabled></td></tr>
		        			   <tr><td valign="top">Comentarios:</td><td><textarea rows="5" cols="24">'.$row['COMENTARIOS'].'</textarea></td></tr>
							</table>
						</td>

						<td width="50%" valign="top" align="right">
							<table class="eti">
								<tr><td>Total antes del descuento:</td><td><input type="text" id="tot" size="10" value="'.number_format(round((int)$row['SUB_TOT'],2),2).'" disabled></td></tr>
		        			   <tr><td>Descuento:</td><td><input type="text" id="tot" size="10" value="'.number_format(round((int)$row['DESCUENTO'],2),2).'" disabled></td></tr>
								<tr><td>Anticipo Total:</td><td><input type="text" id="tot" size="10" value="'.number_format(round((int)$row['ANTICIPO'],2),2).'" disabled></td></tr>
								<tr><td>Redondeo:</td><td><input type="text" id="tot" size="10" value="'.number_format(round((int)$row['REDONDEO'],2),2).'" disabled></td></tr>
								<tr><td>Impuesto:</td><td><input type="text" id="tot" size="10" value="'.number_format(round((int)$row['IMPUESTO'],2),2).'" disabled></td></tr>
								<tr><td>Retencion:</td><td><input type="text" id="tot" size="10" value="'.number_format(round((int)$row['RETENCION'],2),2).'" disabled></td></tr>
								<tr><td>Total del Documento:</td><td><input type="text" id="tot" size="10" value="'.number_format(round((int)$row['TOTAL'],2),2).'" disabled></td></tr>
								<tr><td>Importe aplicado:</td><td><input type="text" id="tot" size="10" value="'.number_format(round((int)$row['IMPORTE_APL'],2),2).'" disabled></td></tr>
							</table>
						</td>
					</tr>
				</table>';        

        
	} //Consulta SQL
} //sesion
else{
	session_destroy();
	Header("Location: index.php");
	}
?>

</tbody>

</table>
<script type="text/javascript">

var Opciones=Array("Contenido","Logistica","Finanzas")
initTabs("Tab",Opciones,0,"","");

</script>

</div>

</html>
