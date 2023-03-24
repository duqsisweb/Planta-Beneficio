<?php header('Content-Type: text/html; charset=UTF-8');

    session_start();
    error_reporting(0);

    include '../conexionbd.php';
    if (isset($_SESSION['usuario'])) {
        require 'menu.php';
        
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Plataforma portal empleados" />
    <meta name="author" content="Santiago Guillen" />
    <title>Portal Empleados</title>
    <link rel="icon" type="image/x-icon" href="../assets/image/duquesa-logo-blanco.svg" />
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="sectionHome">
        <h1 class="titleSystem">bienvenido al portal de empleados</h1>
        <article class="home">
            <section class="infoHome">
                <p>Aqui podras generar los certificados de nomina y laboral, consultar tus vacaciones...</p>
                <p>Para mas informacion acercate al area de Gestion Humana o contacta al correo:</p>
                <br><span class="correo"><a href="mailto:nomina@duquesa.com.co">nomina@duquesa.com.co</a></span>
                <br>
                <br><span class="correo"><a href="mailto:gestionhumana@duquesa.com.co">gestionhumana@duquesa.com.co</a></span>
            </section>
            <img src="../assets/image/contrato.png" title="imagen principal">
        </article>
    </div>
</body>
</html>

<?php } else { ?>
    <script languaje "JavaScript">
        alert("Acceso Incorrecto");
        window.location.href = "../login.php";
    </script><?php
} ?>