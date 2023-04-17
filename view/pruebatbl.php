<?php header('Content-Type: text/html; charset=UTF-8');

session_start();
error_reporting(0);

include '../conexionbd.php';
if (isset($_SESSION['usuario'])) {
    require 'header.php';
    require '../function/funciones.php';
 
    $data = funciones::buscarusuariop();

    


?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Plataforma Planta Beneficio" />
        <meta name="author" content="Yon Gonzalez" />
        <title>Portal Empleados</title>
        <link rel="icon" type="image/x-icon" href="../assets/image/faviconplanta.png"/>
        <link rel="stylesheet" href="../css/bootstrap.css"/>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
    </head>

    <body>
        <section id="sectionContenido">
                

        </section>

    </body>

    </html>

<?php } else { ?>
    <script languaje "JavaScript">
        alert("Acceso Incorrecto");
        window.location.href = "../login.php";
    </script><?php
            } ?>