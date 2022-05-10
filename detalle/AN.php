<html>
<head>
<title>FACTURA ANTICIPO</title>
</head>
<link rel="stylesheet" type="text/css" href="style/spn.css" />
<link href="style/tabcontent_docs.css" rel="stylesheet" type="text/css" />
<script src="js/jquery.min.js" type="text/javascript"> </script>
<script src="js/jquery.fixedtableheader-1-0-2-m.min.js" type="text/javascript"></script>
<script src="js/tabcontent.js" type="text/javascript"></script>

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
       DF.ItemCode NUM_ART,
       DF.Dscription ART,
       DF.AcctCode CANTIDAD,
       Cast(DF.Price As Decimal(10,2)) PU,
       DF.Currency MON_LIN,
       DF.DiscPrcnt POR_DES,
       DF.TaxCode IND_IMPUESTO,
       CAST(Cast(Case When FA.CurSource = 'L' Then DF.LineTotal Else DF.TotalFrgn End As Decimal(10,2)) AS Varchar) + ' ' + CAST(DF.Currency As Varchar) TOTAL_LIN,
       EM.SlpName EMPLEADO,
       CAST(Cast(Case When FA.CurSource = 'L' Then FA.DocTotal+FA.WTSum-FA.VatSum+FA.RoundDif+FA.DiscSum Else FA.DocTotalFC+FA.WTSumFC-FA.VatSumFC+FA.RoundDifFC+FA.DiscSumFC End As Decimal(10,2)) AS Varchar) + ' ' + CAST(FA.DocCur AS Varchar) SUB_TOT,
       CAST(Cast(Case When FA.CurSource = 'L' Then FA.DiscSum Else FA.DiscSumFC End As Decimal(10,2)) AS Varchar) + ' ' + CAST(FA.DocCur AS Varchar) DESCUENTO,
       CAST(Cast(Case When FA.CurSource = 'L' Then FA.DpmAmnt Else FA.DpmAmntFC End As Decimal(10,2)) AS Varchar) + ' ' + CAST(FA.DocCur AS Varchar) ANTICIPO,
       CAST(Cast(Case When FA.CurSource = 'L' Then FA.RoundDif Else FA.RoundDifFC End As Decimal(10,2)) AS Varchar) + ' ' + CAST(FA.DocCur AS Varchar) REDONDEO,
       CAST(Cast(Case When FA.CurSource = 'L' Then FA.VatSum Else FA.VatSumFC End As Decimal(10,2)) AS Varchar) + ' ' + CAST(FA.DocCur AS Varchar) IMPUESTO,
       CAST(Cast(Case When FA.CurSource = 'L' Then FA.WTSum Else FA.WTSumFC End As Decimal(10,2)) AS Varchar) + ' ' + CAST(FA.DocCur AS Varchar) RETENCION,
       CAST(Cast(Case When FA.CurSource = 'L' Then FA.DocTotal Else FA.DocTotalFC End As Decimal(10,2)) AS Varchar) + ' ' + CAST(FA.DocCur AS Varchar) TOTAL,
       CAST(Cast(Case When FA.CurSource = 'L' Then FA.PaidSum Else FA.PaidSumFc End As Decimal(10,2)) AS Varchar) + ' ' + CAST(FA.DocCur AS Varchar) IMPORTE_APL,
       CAST(Cast(Case When FA.CurSource = 'L' Then FA.DocTotal - FA.PaidSum Else FA.DocTotalFC - FA.PaidSumFc End As Decimal(10,2)) AS Varchar) + ' ' + CAST(FA.DocCur AS Varchar) SALDO_PEN,
       FA.Comments COMENTARIOS
  From      ODPO FA
  Join      DPO1 DF On FA.DocEntry = DF.DocEntry
  Left Join OSLP EM ON FA.SlpCode = EM.SlpCode
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
       DF.ItemCode NUM_ART,
       DF.Dscription ART,
       DF.AcctCode CANTIDAD,
       Cast(DF.Price As Decimal(10,2)) PU,
       DF.Currency MON_LIN,
       DF.DiscPrcnt POR_DES,
       DF.TaxCode IND_IMPUESTO,
       CAST(Cast(Case When FA.CurSource = 'L' Then DF.LineTotal Else DF.TotalFrgn End As Decimal(10,2)) AS Varchar) + ' ' + CAST(DF.Currency As Varchar) TOTAL_LIN,
       EM.SlpName EMPLEADO,
       CAST(Cast(Case When FA.CurSource = 'L' Then FA.DocTotal+FA.WTSum-FA.VatSum+FA.RoundDif+FA.DiscSum Else FA.DocTotalFC+FA.WTSumFC-FA.VatSumFC+FA.RoundDifFC+FA.DiscSumFC End As Decimal(10,2)) AS Varchar) + ' ' + CAST(FA.DocCur AS Varchar) SUB_TOT,
       CAST(Cast(Case When FA.CurSource = 'L' Then FA.DiscSum Else FA.DiscSumFC End As Decimal(10,2)) AS Varchar) + ' ' + CAST(FA.DocCur AS Varchar) DESCUENTO,
       CAST(Cast(Case When FA.CurSource = 'L' Then FA.DpmAmnt Else FA.DpmAmntFC End As Decimal(10,2)) AS Varchar) + ' ' + CAST(FA.DocCur AS Varchar) ANTICIPO,
       CAST(Cast(Case When FA.CurSource = 'L' Then FA.RoundDif Else FA.RoundDifFC End As Decimal(10,2)) AS Varchar) + ' ' + CAST(FA.DocCur AS Varchar) REDONDEO,
       CAST(Cast(Case When FA.CurSource = 'L' Then FA.VatSum Else FA.VatSumFC End As Decimal(10,2)) AS Varchar) + ' ' + CAST(FA.DocCur AS Varchar) IMPUESTO,
       CAST(Cast(Case When FA.CurSource = 'L' Then FA.WTSum Else FA.WTSumFC End As Decimal(10,2)) AS Varchar) + ' ' + CAST(FA.DocCur AS Varchar) RETENCION,
       CAST(Cast(Case When FA.CurSource = 'L' Then FA.DocTotal Else FA.DocTotalFC End As Decimal(10,2)) AS Varchar) + ' ' + CAST(FA.DocCur AS Varchar) TOTAL,
       CAST(Cast(Case When FA.CurSource = 'L' Then FA.PaidSum Else FA.PaidSumFc End As Decimal(10,2)) AS Varchar) + ' ' + CAST(FA.DocCur AS Varchar) IMPORTE_APL,
       CAST(Cast(Case When FA.CurSource = 'L' Then FA.DocTotal - FA.PaidSum Else FA.DocTotalFC - FA.PaidSumFc End As Decimal(10,2)) AS Varchar) + ' ' + CAST(FA.DocCur AS Varchar) SALDO_PEN,
       FA.Comments COMENTARIOS
  From      ODPI FA
  Join      DPI1 DF On FA.DocEntry = DF.DocEntry
  Left Join OSLP EM ON FA.SlpCode = EM.SlpCode
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
				<table width=100% height=100%>
					<tr height=20%>
						<td width="50%" colspan="2" valign="top">
							<table class="eti">
								<tr><td>Proveedor:</td><td><input type="text" id="cab" size="6" value="'.$row['CODIGO'].'" disabled></td></tr>
		        			   <tr><td>Nombre:</td><td><input type="text" id="cab" size="40" value="'.$row['NOMBRE'].'" disabled></td></tr>
								<tr><td>Referencia:</td><td><input type="text" id="cab" size="25" value="'.$row['REFERENCIA'].'" disabled></td></tr>
								<tr><td>Moneda:</td><td><input type="text" id="cab" size="6" value="'.$row['MONEDA'].'" disabled><input type="text" id="cab" size="6" value="'.$row['TC'].'" disabled></td></tr>
							</table>
						</td>
						<td width="50%" align="right" valign="top">
							<table class="eti">
								<tr><td>Numero:</td><td><input type="text" id="cab" size="10" value="'.$row['DOCUMENTO'].'" disabled></td></tr>
		        			   <tr><td>Fecha de Contabilizacion:</td><td><input type="text" id="cab" size="10" value="'.date_format($row['FECHA_CON'],"d/m/Y").'" disabled></td></tr>
								<tr><td>Fecha de Vencimiento:</td><td><input type="text" id="cab" size="10" value="'.date_format($row['FECHA_VEN'],"d/m/Y").'" disabled></td></tr>
								<tr><td>Fecha de Documento:</td><td><input type="text" id="cab" size="10" value="'.date_format($row['FECHA_DOC'],"d/m/Y").'" disabled></td></tr>
								<tr><td>Numero Folio:</td><td><input type="text" id="cab" size="10" value="'.$row['NUM_FOL'].'" disabled></td></tr>
							</table>
						</td>
					</tr>
					<tr height=50% valign="top">
						
						<td colspan=3 style="background-color:#FFFFFF;">
									<ul class="tabs" style="background-image: url(./style/fa.png);">
										 <li><a href="#view1">Contenido</a></li>
										 <li><a href="#view2">Logistica</a></li>
										 <li><a href="#view3">Finanzas</a></li>
									</ul>
									<div class="tabcontents">
									    <div id="view1">
									        <table class="detalle"> 
													<thead>
													<th width="40%">Descripcion</th>
													<th width="12%">Cuenta de mayor</th>
													<th width="10%">PU</th>
													<th width="5%">Impuesto</th>
													<th width="10%">Total</th>
													</thead>
													<tbody >';
														while($row2 = sqlsrv_fetch_array($grid)) 
														{
														echo'	
														<tr>
															<td style="text-align:left;">'.$row2['ART'].'</td>
															<td>'.$row2['CANTIDAD'].'</td>
															<td>'.number_format(round((int)$row2['PU'],2),2).' '.$row2['MON_LIN'].'</td>
															<td>'.$row2['IND_IMPUESTO'].'</td>
															<td> '.number_format(round((int)$row2['TOTAL_LIN'],2),2).'</td>
														</tr>';
														};
													echo '</tbody></table>
									    </div>
									    <div id="view2">
									        content 2
									    </div>
									    <div id="view3">
									        content 3
									    </div>
									</div>
						</td>

					</tr>
					<tr height=30%>
						<td width="60%" colspan=2 valign="top">
							<table>
								<tr><td>Encargado de Compras:</td><td><input type="text" id="codigo" size="30" value="'.$row['EMPLEADO'].'" disabled></td></tr>
		        			   <tr><td valign="top">Comentarios:</td><td><textarea rows="5" cols="24">'.$row['COMENTARIOS'].'</textarea></td></tr>
							</table>
						</td>

						<td width="40%" align="right" valign="top">
							<table class="eti">
								<tr><td>Total antes del descuento:</td><td><input type="text" id="tot" size="10" value="'.number_format(round((int)$row['SUB_TOT'],2),2).'" disabled></td></tr>
		        			   <tr><td>Descuento:</td><td><input type="text" id="tot" size="10" value="'.number_format(round((int)$row['DESCUENTO'],2),2).'" disabled></td></tr>
								<tr><td>Anticipo Total:</td><td><input type="text" id="tot" size="10" value="'.number_format(round((int)$row['ANTICIPO'],2),2).'" disabled></td></tr>
								<tr><td>Redondeo:</td><td><input type="text" id="tot" size="10" value="'.number_format(round((int)$row['REDONDEO'],2),2).'" disabled></td></tr>
								<tr><td>Impuesto:</td><td><input type="text" id="tot" size="10" value="'.number_format(round((int)$row['IMPUESTO'],2),2).'" disabled></td></tr>
								<tr><td>Retencion:</td><td><input type="text" id="tot" size="10" value="'.number_format(round((int)$row['RETENCION'],2),2).'" disabled></td></tr>
								<tr><td>Total del Documento:</td><td><input type="text" id="tot" size="10" value="'.number_format(round((int)$row['TOTAL'],2),2).'" disabled></td></tr>
								<tr><td>Importe aplicado:</td><td><input type="text" id="tot" size="10" value="'.number_format(round((int)$row['IMPORTE_APL'],2),2).'" disabled></td></tr>
								<tr><td>Saldo Pendiente:</td><td><input type="text" id="totv" size="10" value="'.number_format(round((int)$row['SALDO_PEN'],2),2).'" disabled></td></tr>
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
