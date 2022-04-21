<?php
session_start();
if (ISSET($_SESSION['rol']) != null) {
    require 'elementos/header.php';
    include("class/usuarios_class.php");
    include("class/presupuestos_class.php");

    $idModulo = $_GET['id'];

    $informaciónModulo = new Usuarios();
    $informaciónModulo->setIdModulo($idModulo);
    $informaciónModuloResult = $informaciónModulo->GetInformacionModulo( $idModulo);
    $query="";
    if ($informaciónModuloResult['exitoso'] && count($informaciónModuloResult['resultado']) > 0) {
         foreach ($informaciónModuloResult['resultado'] as $row) {
            $query=$row['query'];
        }
    }
    echo $query;
    
    $ModulosPorUsuario = new Usuarios();
    $ModulosPorUsuario->setIdRol($_SESSION['id_rol']);
    $ModulosUsuario = $ModulosPorUsuario->ModulosPorRol();

    $ColumnasModulosPorUsuario = new Usuarios();
    $ColumnasModulosPorUsuario->setIdModulo($idModulo);
    $ColumnasModulosUsuario = $ModulosPorUsuario->ColumnasPorRol( $idModulo);

    $Usuarios = new Usuarios();
    $UsuarioFull = $Usuarios->ObtenerUsuarios();

    $Presupuestos = new Presupuestos();
    $PresupuestosFull = $Presupuestos->getPresupuestos();


    switch ($idModulo) {
        case 2:
            $PresupuestosFull = $Presupuestos->getPresupuestos();
            break;
        case 3:
            $PresupuestosFull = $Presupuestos->getPedidos();
            break;
        case 4:
            $PresupuestosFull = $Presupuestos->getNotaEntregas();
             break;
        case 6:
            $PresupuestosFull = $Presupuestos->getInventario();
            break;
        case 7:
            $PresupuestosFull = $Presupuestos->getInventario();
            break;
        case 9:
            $PresupuestosFull = $Presupuestos->getEntradas();
             break;
        case 10:
            $PresupuestosFull = $Presupuestos->getOfertaCompras();
            break;
        case 11:
            $PresupuestosFull = $Presupuestos->getOfertaCompras();
            break;
        case 12:
            $PresupuestosFull = $Presupuestos->getImportaciones();
            break;
        case 13:
            $PresupuestosFull = $Presupuestos->getImportaciones();
            break;
        case 14:
            $PresupuestosFull = $Presupuestos->getVentas();
            break;
        case 15:
            $PresupuestosFull = $Presupuestos->getVentas();
             break;
        case 16:
            $PresupuestosFull = $Presupuestos->getPagos();
            break;
        case 17:
            $PresupuestosFull = $Presupuestos->getTaller();
            break;
        case 18:
            $PresupuestosFull = $Presupuestos->getoOCCerradas();
            break;
        case 19:
            $PresupuestosFull = $Presupuestos->getoFactProv();
             break;
        
    }
    ?>

    <div style="float:left;">
        <table id="demo" cellpadding="0" cellspacing="0" class="">
            <thead>
                <tr> 
                    <?php
                    if ($ColumnasModulosUsuario['exitoso'] && count($ColumnasModulosUsuario['resultado']) > 0) {
                        foreach ($ColumnasModulosUsuario['resultado'] as $row) {
                            ?>
                            <th class="text-center" 
                                style="width: <?php
                                if (isset($row['col_width'])) {
                                    echo $row['col_width'];
                                }
                                ?>"
                                > 
                                    <?php echo $row['nombre']; ?>
                            </th>

                            <?php
                        }
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($PresupuestosFull['exitoso'] && count($PresupuestosFull['resultado']) > 0) {
                    foreach ($PresupuestosFull['resultado'] as $rowSQL) {
                        ?>
                        <tr> 
                             <?php
                            if ($ColumnasModulosUsuario['exitoso'] && count($ColumnasModulosUsuario['resultado']) > 0) {
                                foreach ($ColumnasModulosUsuario['resultado'] as $row) {
                                    $nombreColumna = $row['nombre'];
                                    $fondoColumna = 'AUX_' . $row['nombre']
                                    ?>
                                    <td 
                                        style="width: <?php
                                        if (isset($row['col_width'])) {
                                            echo $row['col_width'];
                                        }
                                        ?>" 
                                        class="<?php
                                        if (isset($row['align']) && $row['align'] != '') 
                                        {
                                            echo $row['align'];
                                        }
                                        
                                        if (isset($row['class_background']) and $row['class_background'] == 1) 
                                        {
                                            echo $rowSQL[$fondoColumna];
                                        }
                                        ?>" >

                                        <?php if (isset($row['class_files']) && $row['class_files'] != '' && $rowSQL[$nombreColumna] != '') { ?>
                                            <a href="<?php echo $row['class_files'] . '' . $rowSQL[$nombreColumna]; ?>" class="h6 text-decoration-none ms-1" target="_blank" onclick="window.open(this.href, this.target, 'width=900, height=700'); return false;" >
                                                <text class="text-danger"><i class="demo-pli-right-4"></i></text></a>
                                        <?php } ?>
                                        <?php 
                                        if (isset($row['format_text']) && $row['format_text'] == 'number_format')
                                        { 
                                            echo number_format($rowSQL[$nombreColumna], 2);                                                
                                        }
                                        else 
                                        {
                                            if(isset($row['esAdjunto']) && $row['esAdjunto'] == '1' and $rowSQL[$nombreColumna]!= null)
                                            {
                                                $XML = simplexml_load_string($rowSQL[$nombreColumna], "SimpleXMLElement", LIBXML_NOCDATA);
                                                $json = json_encode($XML);
                                                $arr = json_decode($json,TRUE); 

                                                foreach ($arr["Archivo"] as $adjunto) {

                                                    if(is_array( $adjunto))
                                                    {
                                                        foreach ($adjunto as $adjunto2) {
                                                                ?>
                                                                    <a href='/adjuntos/<?php echo $adjunto2; ?>' target='_blank' rel='noopener noreferrer' onClick="window.open(this.href, this.target, 'width=900,height=700'); return false;" >
                                                                        <i class="demo-pli-file" rel="tooltip" title="<?php echo $adjunto2; ?>" id="blah" ></i>                                                          
                                                                    </a>
                                                                <?php
                                                            }     
                                                    }
                                                    else{
                                                        ?>
                                                            <a href='/adjuntos/<?php echo $adjunto; ?>' target='_blank' rel='noopener noreferrer' onClick="window.open(this.href, this.target, 'width=900,height=700'); return false;" >
                                                                <i class="demo-pli-file" rel="tooltip" title="<?php echo $adjunto; ?>" id="blah" ></i>                                                          
                                                            </a>
                                                        <?php
                                                    }                                                   
                                                }
                                            }
                                            else
                                            {
                                                echo $rowSQL[$nombreColumna];
                                            }
                                            
                                        }
                                         if (isset($row['concat']) && $row['format_text'] != '' && ($rowSQL[$nombreColumna]!= null ||$rowSQL[$nombreColumna] != '') )echo $row['concat'];
                                        ?>      
                                        

                                      
                                    </td>
                                    <?php
                                }
                            }
                            ?>
                        </tr>
                        <?php
                    }
                } else {
                    echo 'Sin información';
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
                col_number_format: [
    <?php
    if ($ColumnasModulosUsuario['exitoso'] && count($ColumnasModulosUsuario['resultado']) > 0) {
        foreach ($ColumnasModulosUsuario['resultado'] as $row) {
            if (isset($row['col_number_format'])) {
                echo '"' . $row['col_number_format'] . '",';
            }
        }
    }
    ?>
                ],
    <?php
    $numeroColumna = 0;
    if ($ColumnasModulosUsuario['exitoso'] && count($ColumnasModulosUsuario['resultado']) > 0) {
        foreach ($ColumnasModulosUsuario['resultado'] as $row) {
            ?>
                col_<?php echo $numeroColumna; ?>: "<?php echo $row['col_0']; ?>",
                        // echo 'col_'.$numeroColumna.': "'.$row['col_0'] .'",';
            <?php
            $numeroColumna++;
        }
    }
    ?>

        display_all_text: "Mostrar todo",
                //	custom_slc_options: {
                //		cols:[3],
                //		texts: [['na','0 - 50','50 - 500','500 - 15000','15000 - 25000','25000 - 100000','100000 - 1500000','not na']],
                //		values: [
                //					['na','>0 && <=50','>50 && <=500','>500 && <=15000','>15000 && <=25000','>25000 && <=100000','>100000 && <=1500000','!na']
                //				],
                //		sorts: [false]
                //	},
                col_width: [
        <?php
        if ($ColumnasModulosUsuario['exitoso'] && count($ColumnasModulosUsuario['resultado']) > 0) {
            foreach ($ColumnasModulosUsuario['resultado'] as $row) {
                if (isset($row['col_width'])) {
                    echo '"' . $row['col_width'] . '",';
                }
            }
        }
        ?>
                ],
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
                        initialize:[function(o){o.SetColsVisibility('ColsVisibility'); }]
                },
                btn_showHide_cols_text: 'Columns&red;'
        }
        var tf = setFilterGrid("demo", props);
    //]]>
    </script>

    <div style="clear:both;"></div>

    <?php
    require 'elementos/footer.php';
} else {
    header("location:index.php");
}
?>