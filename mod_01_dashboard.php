<?php
session_start();
if (ISSET( $_SESSION['rol']) !=null) {
    require 'elementos/header.php';
    include("class/usuarios_class.php");

    $ModulosPorUsuario = new Usuarios();
    $ModulosPorUsuario->setIdRol($_SESSION['id_rol']);
    $ModulosUsuario = $ModulosPorUsuario->ModulosPorRol();

    $Usuarios = new Usuarios();
    $UsuarioFull = $Usuarios->ObtenerUsuarios();
?>
    

            <div class="content__boxed d-me-auto">

                <!-- Dashboard content -->
                <div class="content__wrap order-2 min-w-0">
                    <div class="row">
                         <!-- Tiles -->
                    <div class="row">
                        

                        <?php
                            if ($ModulosUsuario['exitoso'] && count($ModulosUsuario['resultado']) > 0) {
                                
                                foreach ($ModulosUsuario['resultado'] as $row) {
                                    if($row['descripcion']!='Dashboard')
                                    {
                            ?>
                            <div class="col-sm-6 col-lg-3">
                            <!-- Stat widget -->
                           
                            <div class="card <?php echo $row['color']; ?> text-white mb-4 mb-xl-3">
                                <div class="card-body py-3 d-flex align-items-stretch">                                
                                    <div class="d-flex align-items-center justify-content-center flex-shrink-0 rounded-start">
                                        <i class="<?php echo $row['icono']; ?>  fs-1"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-0">                                        
                                            <?php if( $row['submodulos']==1 ){?>
                                                <h1 class="h5 mb-0"> 
                                                <?php echo $row['descripcion']; ?>
                                                </h1>

                                            <?php 
                                                $Submodulos = new Usuarios();
                                                $submodulosResult = $Submodulos->getSubmodulos($row['id_modulo']);
                                                if ($submodulosResult['exitoso'] && count($submodulosResult['resultado']) > 0) {
                                
                                                    foreach ($submodulosResult['resultado'] as $row2){
                                                        ?>
                                                        <a href="<?php echo $row2['archivo']; ?>" class="nav-link mininav-toggle">
                                                            <?php echo str_replace($row['descripcion'], '' , $row2['descripcion']); ?>
                                                        </a>
                                                        <?php
                                                    }
                                                }
                                            }
                                            else { 
                                                ?>
                                                <h1 class="h5 mb-0"> 
                                                <a href="<?php echo $row['archivo']; ?>" class="nav-link mininav-toggle">
                                                <?php echo $row['descripcion']; ?>
                                                </a>
                                                </h1>
                                            <?php } ?>

                                        
                                    </div>                                   
                                </div>
                            </div>
                                    
                            <!-- END : Stat widget -->
                            </div>
                            <?php      
                                    }                          
                                }
                            }

                        ?>                        
                    </div>
                    <!-- END : Tiles -->
                    </div>
                </div>
                <!-- END : Dashboard content -->


            </div>

 <?php
    require 'elementos/footer.php';
} else {
    header("location:index.php");
}
?>