<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no">
    <meta name="description" content="The login page allows a user to gain access to an application by entering their username and password or by authenticating using a social media login.">
    <title>SICC | stones piedras naturales</title>

    <!-- STYLESHEETS -->
      <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&family=Ubuntu:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/color-schemes/all-headers/cherry/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/color-schemes/all-headers/cherry/nifty.min.css">
    <link rel="stylesheet" href="assets/css/demo-purpose/demo-icons.min.css">
    <link rel="stylesheet" href="assets/css/demo-purpose/demo-settings.min.css">

</head>

<body class="">

    <!-- PAGE CONTAINER -->
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    <div id="root" class="root front-container">

        <!-- CONTENTS -->
        <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
        <section id="content" class="content">
            <div class="content__boxed w-100 min-vh-100 d-flex flex-column align-items-center justify-content-center">
                <div class="content__wrap">

                    <!-- Login card -->
                    <div class="card shadow-lg">
                        <div class="card-body">

                            <div class="text-center">							
                                <h1 class="h1 mb-0 text-danger"><text class="text-danger">stones</text><text class="text-dark">piedras</text><text class="text-muted">naturales</text></h1>
                                <p>Sistema Integral de Comunicación y Consulta</p>
                            </div>

                            <form class="mt-4" action="elementos/login.php" method="post">

                                <div class="mb-3">
                                    <input type="text" class="form-control" placeholder="Usuario" autofocus  name="usuario">
                                </div>

                                <div class="mb-3">
                                    <input type="password" class="form-control" placeholder="Contraseña"  name="password">
                                </div>

                                <div class="form-check">
                                    <input id="_dm-loginCheck" class="form-check-input" type="checkbox">
                                    <label for="_dm-loginCheck" class="form-check-label">
                                        Recordarme
                                    </label>
                                </div>

                                <div class="d-grid mt-5">
                                    <button class="btn btn-primary btn-lg" type="submit">Iniciar sesión</button>
                                </div>
                            </form>

                        </div>
                    </div>
                    <!-- END : Login card -->
                </div>
            </div>
        </section>

        <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
        <!-- END - CONTENTS -->
    </div>
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    <!-- END - PAGE CONTAINER -->

    <!-- Popper JS [ OPTIONAL ] -->
    <script src="./assets/vendors/popperjs/popper.min.js" defer></script>

    <!-- Bootstrap JS [ OPTIONAL ] -->
    <script src="./assets/vendors/bootstrap/bootstrap.min.js" defer></script>

    <!-- Nifty JS [ OPTIONAL ] -->
    <script src="./assets/js/nifty.js" defer></script>

    <!-- Nifty Settings [ DEMO ] -->
    <script src="./assets/js/demo-purpose-only.js" defer></script>

</body>

</html>