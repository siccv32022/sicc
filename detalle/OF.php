<html>
<head>
<title>ORDEN DE FABRICACION</title>
</head>
<link rel="stylesheet" type="text/css" href="style/spn.css" />
<link href="style/tabcontent_docs.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/tab-view.js"></script>
<script src="js/jquery.min.js" type="text/javascript"> </script>
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

if (isset($_SESSION['k_username'])) {
	
	include("conn.php");
	include("cs.php");
if (!$conn) {
    die('Unable to connect or select database!');
}
  
$result = sqlsrv_query($conn,$cortes_doc);
$grid = sqlsrv_query($conn,$cortes_doc);
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
						<td width="50%" valign="top">
							<table class="eti">
								<tr><td>Status:</td><td><input type="text" id="cab" size="6" value="'.$row['Status'].'" disabled></td></tr>
		        			   <tr><td>Material Cortado:</td><td><input type="text" id="cab" size="40" value="'.$row['Material_T'].'" disabled></td></tr>
								<tr><td>Cantidad a Cortar:</td><td><input type="text" id="cab" size="25" value="'.$row['Ctd_O'].'" disabled></td></tr>
								<tr><td>Almacen:</td><td><input type="text" id="cab" size="6" value="'.$row['Almacen'].'" disabled></td></tr>
							</table>
						</td>
						
						<td width="50%" align="right" valign="top">
							<table class="eti">
								<tr><td colspan = 2>Numero:</td><td><input type="text" id="cab" size="10" value="'.$row['Documento'].'" disabled></td></tr>
		        			   <tr><td colspan = 2>Creada:</td><td><input type="text" id="cab" size="10" value="'.date_format($row['Fcha_Crea'],"d/m/Y").'" disabled></td></tr>
								<tr><td colspan = 2>Finalizacion:</td><td><input type="text" id="cab" size="10" value="'.date_format($row['Fcha_Venc'],"d/m/Y").'" disabled></td></tr>
								<tr><td colspan = 2>Usuario:</td><td><input type="text" id="cab" title="'.$row['Usuario'].'" size="10" value="'.$row['CodUsr'].'" disabled></td></tr>
								<tr><td>Pedido:</td>';
								echo "<td><a href=./PE.php?nsap=".$row['Pedido']."&tsn=C target=\"_blank\" onClick=\"window.open(this.href, this.target,'width=800, height=600'); return false;\"><img src='/images/flecha.png' align=\"right\"></a></td>";
								echo '<td><input type="text" id="cab" size="10" value="'.$row['Pedido'].'" disabled></td></tr>
								<tr><td colspan = 2>Cliente:</td><td><input type="text" id="cab" title="'.$row['Cliente'].'" size="10" value="'.$row['CodCli'].'" disabled></td></tr>
								<tr><td colspan = 2>Obra:</td><td><input type="text" id="cab" size="10" value="'.$row['Obra'].'" disabled></td></tr>
							</table>
						</td>

							
					</tr>
					<tr height=70% valign="top">
						
						<td colspan=3 style="background-color:#FFFFFF; border: black 1px solid;">
							<ul class="tabs" style="background-image: url(./style/fa.png);">
										 <li><a href="#view1">Componentes</a></li>
										 <li><a href="#view2">Resumen</a></li>
									</ul>
									
									<div class="tabcontents">
									    <div id="view1">
							<table class="detalle"> 
							<thead>';

								echo'
								<th width="15%">Articulo</th>
								<th width="30%">Descripcion del Articulo</th>
								<th width="5%">Ctd Pedido</th>
								<th width="5%">Ctd Entregada</th>
								<th width="5%">Ctd Pendiente</th>';

							echo'	
							</thead>
							<tbody >';
								while($row2 = sqlsrv_fetch_array($grid)) 
								{
								echo'	
								<tr>';

								    		echo '
											<td style="text-align:left;">'.$row2['MatCod_O'].'</td>
											<td style="text-align:left;">'.$row2['Material_O'].'</td>
											<td>'.number_format(round((int)$row2['Ctd_Acor'],4),4).'</td>
											<td>'.number_format(round((int)$row2['Ctd_Entr'],4),4).'</td>
											<td>'.number_format(round((int)$row2['Ctd_Devu'],4),4).'</td>';

								echo '
								</tr>';
								}; // While
							echo '</tbody></table>
										 </div>
									    <div id="view2">
									        content 2
									    </div>
									</div>
						
						</td>
							
					</tr>	
					<tr height=10%>
						<td width="50%" colspan=2 valign="top">
							<table>
		        			   <tr><td valign="top">Comentarios:</td><td><textarea rows="5" cols="24">'.$row['Comments'].'</textarea></td></tr>
							</table>
						</td>

						<td width="50%" valign="top" align="right">
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
