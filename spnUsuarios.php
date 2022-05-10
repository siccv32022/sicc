<?php
session_start();
if (ISSET( $_SESSION['rol']) !=null) {
    require 'elementos/header.php';
    include("class/usuarios_class.php");
    

    $ModulosPorUsuario = new Usuarios();
    $ModulosPorUsuario->setIdRol($_SESSION['id_rol']);
    $ModulosUsuario = $ModulosPorUsuario->ModulosPorRol();

    $Usuarios = new Usuarios();
    $UsuarioFull  = $Usuarios->ObtenerUsuarios();

    
?>
    

            <div class="content__boxed d-me-auto">

                <!-- Dashboard content -->
                <div class="content__wrap order-2 min-w-0">
                    <div class="row">
                         <!-- Tiles -->
                    <!-- END : Tiles -->
						<div class="col-xl-12">

                            <!-- Users Table -->
                            <div class="table-responsive mw-100">
                                <table class="table align-middle">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Usuario</th>
                                            <th>Nombre</th>
                                            <th>Correo electronico</th>
                                            <th>Descripción</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        if ($UsuarioFull['exitoso'] && count($UsuarioFull['resultado']) > 0) {
                                            
                                            foreach ($UsuarioFull['resultado'] as $row) {
                                        ?>
                                        <tr>
                                            <td class="min-w-td"><?php echo $row['id_usuario']; ?></td>
                                            <td><?php echo $row['usuario']; ?></td>
                                            <td><a class="btn-link text-info"><?php echo $row['nombre']; ?></a></td>
                                            <td class="text-muted"><?php echo $row['email']; ?></td>
                                            <td class="fs-5"><span class="d-block badge <?php echo $row['color']; ?>"><?php echo $row['descripcion']; ?></span></td>
                                            <td class="text-center text-nowrap">
                                                <a class="btn btn-icon btn-sm btn-primary btn-hover" href="#"><i class="demo-pli-pen-5 fs-5"></i></a>
                                                <a class="btn btn-icon btn-sm btn-danger btn-hover" href="#"><i class="demo-pli-trash fs-5"></i></a>
                                            </td>
                                        </tr>
                                        <?php                          
                                                }
                                            }

                                        ?>
                                        </tbody>
                                </table>
                                
                            </div>
                            <!-- END : Users Table -->

                        </div>
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