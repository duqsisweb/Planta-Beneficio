
<?php header('Content-Type: text/html; charset=UTF-8');

session_start();
error_reporting(0);

if (isset($_SESSION['usuario'])) {  
    
    header("Content-type: application/pdf");
    header("Content-Disposition: inline; filename=documento.pdf");
    readfile("../formatos/RIT DUQUESA ACTUALIZADO ENERO 2022.pdf");    
?>


<?php } else { ?>
    <script languaje "JavaScript">
        alert("Acceso Incorrecto");
        window.location.href = "../login.php";
    </script><?php
} ?>