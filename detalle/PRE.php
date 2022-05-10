<?php session_start(); 
if (isset($_SESSION['k_username'])) {
    include("conn.php");
    if( $conn===false) {
                          echo "Conexión no se pudo establecer OK";
                          die( print_r( sqlsrv_errors(), true));
                      }
	} //sesion
else {
    session_destroy();
    Header("Location: index.php");
}
?>
<html>
    <head>
        <title>PEDIDO</title>
    </head>
    <link rel="stylesheet" type="text/css" href="style/spn.css" />
    <link href="style/tabcontent_docs.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/tab-view.js"></script>
    <script src="js/jquery.min.js" type="text/javascript"></script>
    <script src="js/tabcontent.js" type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.tbl').fixedtableheader({
                headerrowsize: 1}
            );
        }
        );
    </script>

    <div align="center">
        <?php
        $DOC = $_GET['nsap'];

	



        $query_det = "Select TOP 1 
       CV.DocNum Entrega,
       CASE When CV.Series = 45 Then 'FACTURA' Else 'REMISION' END Tipo,
       DV.TrgetEntry  Factura_N,
       CV.DocDate FechaContabilizacion,
       CV.DocDueDate FechaValido,
       CV.CreateDate FechaCreacion,	   
       CV.CardCode Ccliente,
       CV.CardName Cliente,
       Convert(varchar(254),DM.AliasName) ClienteF,
       VD.SlpName Vendedor,
       DV.ItemCode Material,
       DV.Dscription Descripcion,
       DV.Quantity M2,
       CASE WHEN DV.Currency = 'MXP' THEN DV.Price/TC.Rate ELSE DV.Price END Pu,
       CASE WHEN DV.Currency = 'MXP' THEN DV.LineTotal/TC.Rate ELSE DV.TotalFrgn END Subtotal,
       DV.LineVatS Iva,
       CASE WHEN DV.Currency = 'MXP' THEN (DV.LineTotal/TC.Rate)+DV.LineVatS ELSE DV.TotalFrgn+DV.LineVatS END Total,
       CV.U_Soporte_doc Soporte,
	   DV.DiscPrcnt descuento,
       CV.Project obra,
       CV.DiscPrcnt descuento_documento,
	   CV.NumAtCard referencia,
	   DV.Currency moneda,
	   CV.Comments
  FROM QUT1 DV
  JOIN OQUT CV ON DV.DocEntry = CV.DocEntry
  Join ORTT TC ON CV.DocDate = TC.RateDate AND TC.Currency = 'USD'
  Left Join OSLP VD On CV.SlpCode = VD.SlpCode
  Left Join OCRD DM On  CV.CardCode =  DM.CardCode
 WHERE CV.DocStatus = 'O' And CV.DocNum=?
 Order By CV.DocNum";

    $params = array($DOC);
    
    $result = sqlsrv_query($conn, $query_det, $params);
   
    
    if( $result === false ) {
     die( print_r( sqlsrv_errors(), true));
    }    else {

            // CReacion de la Tabla HTML apartir de Consulta
            $row = sqlsrv_fetch_array($result);
            echo '
				<table width=100% height=100% >
					<tr height=20%>
						<td width="40%" valign="top">
							<table class="eti">
								<tr><td>Cliente:</td><td><input type="text" id="cab" size="30" value="' . $row['Ccliente'] . '" disabled></td></tr>
		        			   <tr><td>Nombre:</td><td><input type="text" id="cab" size="30" value="' . $row['Cliente'] . '" disabled></td></tr>
								<tr><td>Referencia:</td><td><input type="text" id="cab" size="25" value="' . $row['referencia'] . '" disabled></td></tr>
								<tr><td>Moneda:</td><td><input type="text" id="cab" size="6" value="' . $row['moneda'] . '" disabled><input type="text" id="cab" size="6" value="' . $row['TC']. '" disabled></td></tr>
							</table>
						</td>
						
						<td width="20%">
							
						</td>
						<td width="40%" align="right" valign="top">
							<table class="eti">
								<tr><td>Numero:</td><td><input type="text" id="cab" size="10" value="' . $row['Entrega'] . '" disabled></td></tr>
                                                                <tr><td>Fecha de Contabilizacion:</td><td><input type="text" id="cab" size="10" value="' . date_format(date_create($row['FechaContabilizacion']->format('Y-m-d')), "d/m/Y") . '" disabled></td></tr>
								<tr><td>Fecha de Vencimiento:</td><td><input type="text" id="cab" size="10" value="' . date_format(date_create($row['FechaValido']->format('Y-m-d')), "d/m/Y") . '" disabled></td></tr>
								<tr><td>Fecha de Documento:</td><td><input type="text" id="cab" size="10" value="' . date_format(date_create($row['FechaCreacion']->format('Y-m-d')), "d/m/Y") . '" disabled></td></tr>
								
							</table>
						</td>

							
					</tr>
					<tr height=40% valign="top">
						
						<td colspan=3 style="background-color:#FFFFFF; border: black 1px solid;">
							<ul class="tabs" style="background-image: url(./style/fa.png);">
										 <li><a href="#view1">Contenido</a></li>
										 <li><a href="#view2">Logistica</a></li>
										 <li><a href="#view3">Finanzas</a></li>
									</ul>
									<div class="tabcontents">
									    <div id="view1">
							<table class="detalle"> 
							<thead>';

            echo'
								<th width="15%">Articulo</th>
								<th width="30%">Descripcion del Articulo</th>
								<th width="5%">Cantidad Pedido</th>
                                                                <th width="5%">Precio por unidad</th>
                                                                <th width="5%">% de descuento</th>
                                                                <th width="5%">Indicador de impuesto</th>
							</thead>
							<tbody >';

            $query_detallado = "Select
       CV.DocNum Entrega,
       CASE When CV.Series = 45 Then 'FACTURA' Else 'REMISION' END Tipo,
       DV.TrgetEntry  Factura_N,
       CV.DocDate FechaContabilizacion,
	   CV.DocDueDate FechaValido,
	   CV.CreateDate FechaCreacion,	   
       CV.CardCode Ccliente,
       CV.CardName Cliente,
       Convert(varchar(254),DM.AliasName) ClienteF,
       VD.SlpName Vendedor,
       DV.ItemCode Material,
       DV.Dscription Descripcion,
       DV.Quantity M2,
       CASE WHEN DV.Currency = 'MXP' THEN DV.Price/TC.Rate ELSE DV.Price END Pu,
       CASE WHEN DV.Currency = 'MXP' THEN DV.LineTotal/TC.Rate ELSE DV.TotalFrgn END Subtotal,
       DV.LineVatS Iva,
       CASE WHEN DV.Currency = 'MXP' THEN (DV.LineTotal/TC.Rate)+DV.LineVatS ELSE DV.TotalFrgn+DV.LineVatS END Total,
       CV.U_Soporte_doc Soporte,
	   DV.DiscPrcnt descuento,
       CV.Project obra,
       CV.DiscPrcnt descuento_documento,
	   CV.NumAtCard referencia,
	   DV.Currency moneda,
	   CV.Comments,
	   DV.TaxCode
  FROM QUT1 DV
  JOIN OQUT CV ON DV.DocEntry = CV.DocEntry
  Join ORTT TC ON CV.DocDate = TC.RateDate AND TC.Currency = 'USD'
  Left Join OSLP VD On CV.SlpCode = VD.SlpCode
  Left Join OCRD DM On  CV.CardCode =  DM.CardCode
 WHERE CV.DocStatus = 'O' And CV.DocNum=?;";
            $params2 = array($DOC);
            $grid = sqlsrv_query($conn, $query_detallado, $params2);
            
            
            if( $result === false ) {
             die( print_r( sqlsrv_errors(), true));
            }   
            while ($row2 = sqlsrv_fetch_array($grid)) {
                echo'	
			<tr>';
                    echo '
                        <td style="text-align:left;">' . $row2['Material'] . '</td>
                        <td style="text-align:left;">' . $row2['Descripcion'] . '</td>
                        <td>' . number_format(round((int)$row2['M2'], 2), 2) . '</td>
                        <td>' . number_format(round((int)$row2['Pu'], 2), 2) . '</td>
                        <td> &nbsp;&nbsp;&nbsp; ' . number_format(round((int)$row2['descuento'], 2), 2) . ' %</td>
                        <td>' . $row2['TaxCode'] . '</td>';
                echo '</tr>';
            }; // While
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
						<td width="50%" colspan=2 valign="top">
							<table>
								<tr><td>Vendedor:</td><td><input type="text" id="codigo" size="30" value="' . $row['Vendedor'] . '" disabled></td></tr>
		        			   <tr><td valign="top">Comentarios:</td><td><textarea rows="5" cols="24">' . $row['Comments'] . '</textarea></td></tr>
							</table>
						</td>

						<td width="50%" valign="top" align="right">
							<table class="eti">
								<tr><td>Total antes del descuento:</td><td><input type="text" id="tot" size="10" value="' . number_format(round((int)$row['Subtotal'], 2), 2) . '" disabled></td></tr>
		        			                <tr><td>Descuento:  ' . number_format(round((int)$row['descuento_documento'], 2), 2) . ' %</td><td><input type="text" id="tot" size="10" value="' . number_format(round(($row['descuento_documento'] * $row['Subtotal']), 2), 2) . '" disabled></td></tr>
								
								<tr><td>Impuesto:</td><td><input type="text" id="tot" size="10" value="' . number_format(round((int)$row['Iva'], 2), 2) . '" disabled></td></tr>
								<tr><td>Total del Documento:</td><td><input type="text" id="tot" size="10" value="' . number_format(round((int)$row['Total'], 2), 2) . '" disabled></td></tr>
								
							</table>
						</td>
					</tr>
				</table>';
        } //Consulta SQL
//} //sesion
//else{
//	session_destroy();
//	Header("Location: index.php");
//	}
        ?>

    </tbody>

</table>
<script type="text/javascript">

    var Opciones = Array("Contenido", "Logistica", "Finanzas")
    initTabs("Tab", Opciones, 0, "", "");

</script>

</div>

</html>
