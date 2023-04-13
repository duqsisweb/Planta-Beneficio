<?php header('Content-Type: text/html; charset=UTF-8');

session_start();
error_reporting(0);

include '../conexionbd.php';
if (isset($_SESSION['usuario'])) {

  $email = $_SESSION['usuario'];
  $estadopass = $_SESSION['estadopass'];

?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Plataforma Planta Beneficio" />
    <meta name="author" content="Yon Gonzalez" />
    <title>Portal Empleados</title>
    <link rel="icon" type="image/x-icon" href="../assets/image/faviconplanta.png" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
  </head>

  <body>



    <nav class="navbar navbar-dark bg-dark fixed-top">
      <div class="container-fluid">
        <a class="navbar-brand" href="#"> <a href="./inicio-planta.php"><img class="logo" src="../assets/image/plamerasheader.png"></a></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
          <div class="offcanvas-header">
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
          </div>
          <div class="offcanvas-body">
            <div id="">
              <a href="./inicio.php"><img id="inicioavatar" class="logo" src="../assets/image/perfil.png"></a>
            </div>
            <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">
              <p class="user"><?php echo utf8_encode($_SESSION['NOMBRE']); ?></p>
            </h5>
            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Desarollo 1 </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#desarollo2">Desarollo 2</a>
              </li>
              <a class="btn btn-danger btnCloseSesion" href="../closeSesion.php" role="button">Cerrar Sesión</a>
            </ul>
          </div>
        </div>
      </div>
    </nav>

  </body>

  </html>

<?php } else { ?>
  <script languaje "JavaScript">
    alert("Acceso Incorrecto");
    window.location.href = "../login.php";
  </script><?php
          } ?>