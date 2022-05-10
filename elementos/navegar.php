<!-- HEADER -->
        <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
        <header class="header">
            <div class="header__inner">

                <!-- Brand -->
                <div class="header__brand">
                    <div class="brand-wrap">

                        <!-- Brand logo -->
                        <a href="spnDashboard.php" class="brand-img stretched-link">
                            <img src="./assets/img/stones1.png" alt="Stones piedras naturales" class="Stones logo">
                        </a>

                        <!-- Brand title -->
                        <div class="brand-title"><text class="text-danger">stones</text><text class="text-dark">piedras</text><text class="text-muted">naturales</text></div>

                        <!-- You can also use IMG or SVG instead of a text element. -->

                    </div>
                </div>
                <!-- End - Brand -->

                <div class="header__content">

                    <!-- Content Header - Left Side: -->
                    <div class="header__content-start">

                        <!-- Navigation Toggler -->
                        <button type="button" class="nav-toggler header__btn btn btn-icon btn-sm">
                            <i class="demo-psi-view-list"></i>
                        </button>

                        <!-- Searchbox -->
                        <div class="header-searchbox">

                            <!-- Searchbox toggler for small devices -->
                            <label for="header-search-input" class="header__btn d-md-none btn btn-icon rounded-pill shadow-none border-0 btn-sm" type="button">
                                <i class="demo-psi-magnifi-glass"></i>
                            </label>

                        </div>
                    </div>
                    <!-- End - Content Header - Left Side -->

                    <!-- Content Header - Right Side: -->
                    <div class="header__content-end">

                       
                    <!-- Profile Widget -->
                    <div class="mainnav__profile mt-3">

<!-- Profile picture 
<div class="mininav-toggle text-center py-2">
    <img class="mainnav__avatar img-md rounded-circle" src="./assets/img/profile-photos/1.png" alt="Profile Picture">
</div> -->

<div class="mininav-toggle text-center py-2">
    <div class="d-grid">

        <!-- User name and position -->
        <button class="d-block btn shadow-none p-2" data-bs-toggle="collapse" data-bs-target="#usernav" aria-expanded="false" aria-controls="usernav">
            <span class="dropdown-toggle d-flex justify-content-center align-items-center">
                <h6 class="mb-0 text-white me-2"><?php echo $_SESSION['nombre'];?></h6>
            </span>
            <small class="text-muted"><?php echo $_SESSION['rol'];?></small>
        </button>

    </div>
</div>
</div>
<!-- End - Profile widget -->


                    </div>
                </div>
            </div>
        </header>
        <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
        <!-- END - HEADER -->

        <!-- MAIN NAVIGATION -->
        <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
        <nav id="mainnav-container" class="mainnav">
            <div class="mainnav__inner">

                <!-- Navigation menu -->
                <div class="mainnav__top-content scrollable-content pb-5">
                    <!-- Navigation Category -->
                    <ul class="mainnav__menu nav flex-column">
                        <!-- Link with submenu -->
                        <?php
                            if ($ModulosUsuario['exitoso'] && count($ModulosUsuario['resultado']) > 0) {
                                
                                foreach ($ModulosUsuario['resultado'] as $row) {

                                    if( $row['submodulos']==1 ){
                            ?>

                                    <!-- Regular menu link -->
                                    <li class="nav-item has-sub">

                                    <a href="#" class="mininav-toggle nav-link collapsed"><i class="<?php echo $row['icono']; ?> fs-5 me-2"></i>
                                        <span class="nav-label ms-1"><?php echo $row['descripcion']; ?></span>
                                    </a>

                                    <ul class="mininav-content nav collapse">
                                    <!-- Layouts submenu list -->
                                    <?php 
                                                $Submodulos = new Usuarios();
                                                $submodulosResult = $Submodulos->getSubmodulos($row['id_modulo']);
                                                if ($submodulosResult['exitoso'] && count($submodulosResult['resultado']) > 0) {
                                
                                                    foreach ($submodulosResult['resultado'] as $row2){
                                     ?>
                                        <li class="nav-item">
                                            <a href="<?php echo $row2['archivo']; ?>" class="nav-link"> <?php echo str_replace($row['descripcion'], '' , $row2['descripcion']); ?></a>
                                        </li>                        
                            <?php   
                                                    }
                                                }     
                                                
                                                ?>
                                                </ul>
                                    <!-- END : Layouts submenu list -->
                                    </li>
                                <!-- END : Regular menu link -->

                                                <?php
                            }
                            else { 
                                ?>

                                    <!-- Regular menu link -->
                                <li class="nav-item">
                                    <a href="<?php echo $row['archivo']; ?>" class="nav-link mininav-toggle"><i class="<?php echo $row['icono']; ?> fs-5 me-2"></i>

                                        <span class="nav-label mininav-content"><?php echo $row['descripcion']; ?></span>
                                    </a>
                                </li>
                                <!-- END : Regular menu link -->
                        
                            <?php    
                            }  
                                                             
                                }
                            }

                        ?>
                        <!-- END : Link with submenu -->


                       

                    </ul>
                    <!-- END : Navigation Category -->

                   
                    <!-- Widget -->
                    <div class="mainnav__profile">

                        <!-- Widget buttton form small navigation -->
                        <div class="mininav-toggle text-center py-2 d-mn-min">
                            <i class="demo-pli-monitor-2"></i>
                        </div>

                        <div class="d-mn-max mt-5"></div>

                    </div>
                    <!-- End - Profile widget -->

                </div>
                <!-- End - Navigation menu -->

                <!-- Bottom navigation menu 
                <div class="mainnav__bottom-content border-top pb-2">
                    <ul id="mainnav" class="mainnav__menu nav flex-column">
                        <li class="nav-item has-sub">
                            <a href="#" class="nav-link mininav-toggle collapsed" aria-expanded="false">
                                <i class="demo-pli-unlock fs-5 me-2"></i>
                                <span class="nav-label">Logout</span>
                            </a>
                            <ul class="mininav-content nav flex-column collapse">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">This device only</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">All Devices</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Lock screen</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                 End - Bottom navigation menu -->

            </div>
        </nav>
        <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
        <!-- END - MAIN NAVIGATION -->

  