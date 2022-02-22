<?php
session_start();
if (ISSET( $_SESSION['rol']) !=null) {
    require 'elementos/header.php';
    include("class/usuarios_class.php");
    include("class/presupuestos_class.php");

    $ModulosPorUsuario = new Usuarios();
    $ModulosPorUsuario->setIdRol($_SESSION['id_rol']);
    $ModulosUsuario = $ModulosPorUsuario->ModulosPorRol();

    $Usuarios = new Usuarios();
    $UsuarioFull = $Usuarios->ObtenerUsuarios();

    $Presupuestos = new Presupuestos();
    $PresupuestosFull = $Presupuestos->getPresupuestos();

?>
    
<div style="float:left;">
  <table id="demo" cellpadding="0" cellspacing="0" class="">
    <thead>
      <tr> 
      <th class="text-center" style="width: 5%;"># PRE</th>
      <th class="text-center" style="width: 5%;"># PEDIDO</th>
      <th class="text-center" style="width: 6%;">FECHA DE DOC.</th>    
      <th class="text-center" style="width: 9%;">CODIGO <br> CLIENTE</th>
      <th class="text-center" style="width: 9%;">CLIENTE / ALIAS</th>
      <th class="text-center" style="width: 9%;">OBRA</th> 
      <th class="text-center" style="width: 9%;">VENDEDOR</th> 
      <th class="text-center" style="width: 6%;">DESCUENTO POR PARTIDA</th>
      <th class="text-center" style="width: 6%;">SUBTOTAL</th>
      <th class="text-center" style="width: 6%;">DESCUENTO POR DOC.</th>
      <th class="text-center" style="width: 6%;">IVA</th>
      <th class="text-center" style="width: 6%;">TOTAL</th>
      <th class="text-center" style="width: 6%;">TOTAL 2</th>
      <th class="text-center" style="width: 6%;">DESCUENTO POR PARTIDA AUTO.</th>
      <th class="text-center" style="width: 6%;">DECUENTO POR DOC.s AUTO.</th>
      <th class="text-center" style="width: 6%;">OPCIONES</th>
      </tr>
    </thead>
    <tbody>
    <?php
                                        if ($PresupuestosFull['exitoso'] && count($PresupuestosFull['resultado']) > 0) {
                                            
                                            foreach ($PresupuestosFull['resultado'] as $row) {
                                        ?>
    <tr> 
      <td style="width: 5%;"><?php echo $row['Entrega'];?></td>
      <td style="width: 5%;"><?php echo $row['Factura_N'];?></td>
      <td style="width: 6%;"><?php echo $row['Fecha'];?>.</td>    
      <td style="width: 9%;"><?php echo utf8_encode($row['Cliente'])."/".utf8_encode($row['ClienteF']);?></td>
      <td style="width: 9%;"><?php echo utf8_encode($row['obra']);?></td>
      <td style="width: 9%;"><?php echo utf8_encode($row['Vendedor']);?></td> 
      <td style="width: 9%;"><?php echo $row['descuento']; ?></td> 
      <td style="width: 6%;"><?php echo $row['descuento']; ?></td>
      <td style="width: 6%;"><?php echo $row['Subtotal'];?></td>
      <td style="width: 6%;"><?php echo $row['descuento_documento']; ?></td>
      <td style="width: 6%;"><?php echo $row['Iva'];?></td>
      <td style="width: 6%;"><?php echo $row['Total'] ;?></td>
      <td style="width: 6%;"><?php echo $row['Entrega'];?></td>
      <td style="width: 6%;"><?php echo $row['Entrega'];?></td>
      <td style="width: 6%;"><?php echo $row['Entrega'];?></td>
      <td style="width: 6%;"><?php echo $row['Entrega'];?></td>
      </tr>

      <?php                          
                                                }
                                            }

                                        ?>
      
    </tbody>
  </table>
</div>
<script language="javascript" type="text/javascript">
//<![CDATA[	
	var props = {
		remember_grid_values: true,
		remember_page_number: true,
		alternate_rows: true,
		rows_counter: true,
		btn_reset: true,
		btn_reset_text: "Clear",
		loader: true,
		status_bar: true,
		col_number_format: [null,null,'US','US','US','US','US','US','US'],
		col_0: "select",
		col_1: "select",
		col_2: "select",
		col_3: "select",
		display_all_text: "< Show all >",
		custom_slc_options: {
			cols:[3],
			texts: [['na','0 - 50','50 - 500','500 - 15000','15000 - 25000','25000 - 100000','100000 - 1500000','not na']],
			values: [
						['na','>0 && <=50','>50 && <=500','>500 && <=15000','>15000 && <=25000','>25000 && <=100000','>100000 && <=1500000','!na']
					],
			sorts: [false]
		},
		col_width: ["5%","5%","6%","9%","9%","9%","9%","6%","6%","6%","6%","6%","6%","6%","6%","6%"],
		paging: false,
		//paging_length: 25,
		
		selectable: true,
		editable: true,
		ezEditTable_config: {
			default_selection: 'both'
		},
		
		//Grid layout properties
		grid_layout: true,
		//grid_width: '100%',
		
		/*** Extensions manager ***/
		extensions: { 
			/*** Columns Visibility Manager extension load ***/	
			name:['ColsVisibility'], 
			src:['TableFilter/TFExt_ColsVisibility/TFExt_ColsVisibility.js'], 
			description:['Show/hide columns'],
			initialize:[function(o){o.SetColsVisibility('ColsVisibility');}] 
		},
		btn_showHide_cols_text: 'Columns&red;'
	}
	var tf = setFilterGrid("demo",props);

//]]>
</script>

<div style="clear:both;"></div>

<?php
    require 'elementos/footer.php';
} else {
    header("location:index.php");
}
?>