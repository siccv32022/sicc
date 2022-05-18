<?php
session_start();
if (isset($_SESSION['rol']) != null) {
    include("../class/usuarios_class.php");
    include("../class/reportes_class.php");

    $idModulo = $_GET['id'];
    $idModuloDetalle=$idModulo+1000;
    $noFiltrar = $_GET['no'];
    $query = "";
    $queryDetalle = "";
    $reportName = "";
    $repotIcon = "";

    //Variables del detalle

    $detalleConsulta=null;
    
    $informaciónModulo = new Usuarios();
    $informaciónModulo->setIdModulo($idModulo);
    $informaciónModuloResult = $informaciónModulo->GetInformacionModulo($idModulo);


    if ($informaciónModuloResult['exitoso'] && count($informaciónModuloResult['resultado']) > 0) {
        foreach ($informaciónModuloResult['resultado'] as $row) {
            $query = $row['query'];
            $reportName = $row['descripcion'];
            $repotIcon = $row['icono'];
        }
    }
    $informaciónModulo = new Usuarios();
    $informaciónModulo->setIdModulo($idModuloDetalle);
    $informaciónModuloResult = $informaciónModulo->GetInformacionModulo($idModuloDetalle);


    if ($informaciónModuloResult['exitoso'] && count($informaciónModuloResult['resultado']) > 0) {
        foreach ($informaciónModuloResult['resultado'] as $row) {
            $queryDetalle = $row['query'];
        }
    }
    $ModulosPorUsuario = new Usuarios();
    $ModulosPorUsuario->setIdRol($_SESSION['id_rol']);
    $ModulosUsuario = $ModulosPorUsuario->ModulosPorRol();


    if ($query != "") {

        $Reports = new Reportes();
        $Reports->setQuery($query);
        $GetReport = $Reports->getReportFilter($noFiltrar);

        $ColumnasModulosPorDetalle = new Usuarios();
        $ColumnasModulosPorDetalle->setIdModulo($idModulo);
        $ColumnasModulosDetalle = $ModulosPorUsuario->ColumnasPorRol($idModulo);   
        
        
        if ($GetReport['exitoso'] && count($GetReport['resultado']) > 0) {
            $detalleConsulta=reset($GetReport['resultado']);
        }

        $Reports = new Reportes();
        $Reports->setQuery($queryDetalle);
        $GetReport = $Reports->getReportFilter($noFiltrar);

        $ColumnasModulosPorUsuario = new Usuarios();
        $ColumnasModulosPorUsuario->setIdModulo($idModuloDetalle);
        $ColumnasModulosUsuario = $ModulosPorUsuario->ColumnasPorRol($idModuloDetalle);    
        
    }
?>
<!DOCTYPE html PUBLIC>
<html lang="es" xml:lang="es" xmlns="http://www.w3.org/1999/xhtml">
<head>
   <title>PRESUPUESTO | SICC</title>
    <!-- STYLESHEETS -->   
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&family=Ubuntu:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/color-schemes/all-headers/cherry/bootstrap.min.css">
   <script src="TableFilter/tablefilter_all_min.js" language="javascript" type="text/javascript"></script>


    <link rel="stylesheet" type="text/css" href="../assets/css/detalle/spn.css" />
    <link href="../assets/css/detalle/tabcontent_docs.css" rel="stylesheet" type="text/css" />
    <script src="../assets/js/detalle/tabcontent.js" type="text/javascript"></script>
</head>

<div align="center">
    <table width=100% height=100%>
        <tr height=20%>
            <td width="40%" valign="top">
                <table class="eti">
                <?php
                                if ($ColumnasModulosDetalle['exitoso'] && count($ColumnasModulosDetalle['resultado']) > 0) {
                                    foreach ($ColumnasModulosDetalle['resultado'] as $row) {
                                        $area='A';
                                        if($row['area']== $area){
                                ?>
                                    <tr>
                                        <td><?php echo $row['nombre']; ?></td>
                                        <td><input type="text" id="cab" size="<?php echo $row['nombre']; ?>" value="<?php if (isset($row['format_text']) && $row['format_text'] == 'number_format') {
                                                echo number_format($detalleConsulta[$row['nombre']], 2);
                                            } else {
                                                    echo $detalleConsulta[$row['nombre']];
                                            }
                                            if (isset($row['concat']) && $row['format_text'] != '' ) echo $row['concat'];
                                        ?>" disabled></td>
                                    </tr>
                                <?php
                                        }
                                    }
                                }
                                ?>
                </table>
            </td>

            <td width="20%">

            </td>
            <td width="40%" align="right" valign="top">
                <table class="eti">
                <?php
                                if ($ColumnasModulosDetalle['exitoso'] && count($ColumnasModulosDetalle['resultado']) > 0) {
                                    foreach ($ColumnasModulosDetalle['resultado'] as $row) {
                                        $area='B';
                                        if($row['area']== $area){
                                ?>
                                    <tr>
                                        <td><?php echo $row['nombre']; ?></td>
                                        <td><input type="text" id="cab" size="<?php echo $row['nombre']; ?>" value="<?php if (isset($row['format_text']) && $row['format_text'] == 'number_format') {
                                                echo number_format($detalleConsulta[$row['nombre']], 2);
                                            } else {
                                                    echo $detalleConsulta[$row['nombre']];
                                            }
                                            if (isset($row['concat']) && $row['format_text'] != '' ) echo $row['concat'];
                                        ?>" disabled></td>
                                    </tr>
                                <?php
                                        }
                                    }
                                }
                                ?>
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
                        <thead>
                            <tr>
                                <?php
                                if ($ColumnasModulosUsuario['exitoso'] && count($ColumnasModulosUsuario['resultado']) > 0) {
                                    foreach ($ColumnasModulosUsuario['resultado'] as $row) {
                                ?>
                                        <th class="text-center" style="width: <?php
                                                                                if (isset($row['col_width'])) {
                                                                                    echo $row['col_width'];
                                                                                }
                                                                                ?>">
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
                    if ($GetReport['exitoso'] && count($GetReport['resultado']) > 0) {
                        foreach ($GetReport['resultado'] as $rowSQL) {
                    ?>
                            <tr>
                                <?php
                                if ($ColumnasModulosUsuario['exitoso'] && count($ColumnasModulosUsuario['resultado']) > 0) {
                                    foreach ($ColumnasModulosUsuario['resultado'] as $row) {
                                        $nombreColumna = $row['nombre'];
                                ?>
                                        <td style="width: <?php
                                                            if (isset($row['col_width'])) {
                                                                echo $row['col_width'];
                                                            }
                                                            ?>" class="<?php
                                                    if (isset($row['align']) && $row['align'] != '') {
                                                        echo $row['align'];
                                                    }
                                                    ?>">
                                            <?php
                                            if (isset($row['format_text']) && $row['format_text'] == 'number_format') {
                                                echo number_format($rowSQL[$nombreColumna], 2);
                                            } else {
                                                    echo $rowSQL[$nombreColumna];
                                            }
                                            if (isset($row['concat']) && $row['format_text'] != '' ) echo $row['concat'];
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
                    <div id="view2">                        
                    </div>
                    <div id="view3">                        
                    </div>
                </div>
            </td>
        </tr>
        <tr height=30%>
            <td width="50%" colspan=2 valign="top">
                <table>
                <?php
                                if ($ColumnasModulosDetalle['exitoso'] && count($ColumnasModulosDetalle['resultado']) > 0) {
                                    foreach ($ColumnasModulosDetalle['resultado'] as $row) {
                                        $area='C';
                                        if($row['area']== $area){
                                ?>
                                    <tr>
                                        <td><?php echo $row['nombre']; ?></td>
                                        <td>
                                            <?php  if($row['col_0']== 'input') { ?>
                                            <input type="text" id="cab" size="<?php echo $row['nombre']; ?>" value="<?php if (isset($row['format_text']) && $row['format_text'] == 'number_format') {
                                                echo number_format($detalleConsulta[$row['nombre']], 2);
                                            } else {
                                                    echo $detalleConsulta[$row['nombre']];
                                            }
                                            if (isset($row['concat']) && $row['format_text'] != '' ) echo $row['concat'];
                                        ?>" disabled>

                                    <?php  } else {?>
                                    <textarea rows="7" cols="30"> <?php echo  $detalleConsulta[$row['nombre']]; ?> </textarea> 
                                    <?php  } ?>   
                                    </td>
                                    </tr>
                                <?php
                                        }
                                    }
                                }
                                ?>
                </table>
            </td>
            <td width="50%" valign="top" align="right">
                <table class="eti">
                <?php
                                if ($ColumnasModulosDetalle['exitoso'] && count($ColumnasModulosDetalle['resultado']) > 0) {
                                    foreach ($ColumnasModulosDetalle['resultado'] as $row) {
                                        $area='D';
                                        if($row['area']== $area){
                                ?>
                                    <tr>
                                        <td><?php echo $row['nombre']; ?></td>
                                        <td><input type="text" id="cab" size="<?php echo $row['nombre']; ?>" value="<?php if (isset($row['format_text']) && $row['format_text'] == 'number_format') {
                                                echo number_format($detalleConsulta[$row['nombre']], 2);
                                            } else {
                                                    echo $detalleConsulta[$row['nombre']];
                                            }
                                            if (isset($row['concat']) && $row['format_text'] != '' ) echo " ". $row['concat'];
                                        ?>" disabled></td>
                                    </tr>
                                <?php
                                        }
                                    }
                                }
                                ?>
                </table>
            </td>
        </tr>
    </table>
    </tbody>
    </table>
    <script type="text/javascript">
        var Opciones = Array("Contenido", "Logistica", "Finanzas")
        initTabs("Tab", Opciones, 0, "", "");
    </script>
</div>
</html>

<?php
}
?>