<?php
header('Content-Type: text/html; charset=UTF-8');

session_start();
error_reporting(0);

if (isset($_SESSION['usuario'])) {

    require '../function/funciones.php';

?>

    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Plataforma portal empleados" />
        <meta name="author" content="Santiago Guillen" />
        <link rel="stylesheet" href="../css/style.css">
        <link rel="icon" type="image/x-icon" href="../assets/image/duquesa-logo-blanco.svg" />
        <title>Administracion Empleados</title>
    </head>
    <body>

        <header class="headerFormats">
            <a href="administracion.php"><button class="btnbackHome">Regresar al inicio</button></a>
            <h2>Formatos portal empleados</h2>
            <button class="btnAddNewFormat" onclick="showFormNewFormat()">Agregar Formato</button>
        </header>

        <div id="formFormat"></div>

        <section class='containerCards'>
            <?php foreach (funciones::mostrarFormatos() as $val) {
                echo "<article class='cardFormat'>
                        <div class='gradientCard'>
                            <p class='nombredoc". $val['ID'] ."'>". $val['NOMBREARCHIVO'] ."</p>
                        </div>
                        <button class='btnEditFormat' onclick='editFormat(". $val['ID'] .")'>✏️</button>
                    </article>";
            }
            ?>
        </section>

        <script src="../js/main.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.2.146/pdf.min.js" integrity="sha512-hA0/Bv8+ywjnycIbT0xuCWB1sRgOzPmksIv4Qfvqv0DOKP02jSor8oHuIKpweUCsxiWGIl+QaV0E82mPQ7/gyw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <?php

        if (isset($_FILES['documento']) && $_FILES['documento']['type'] == 'application/pdf') {

            $url = '../formatos/' . $_FILES['documento']['name'];

            if (file_exists($url)) { ?>
                <script languaje "JavaScript">
                    alert("Este documento ya existe");
                </script>

            <?php } else {
                move_uploaded_file( $_FILES['documento']['tmp_name'], $url);
                
                funciones::agregarArchivo($_FILES['documento']['name'], $_POST['tipoFormato']); ?>

                <script languaje "JavaScript">
                    alert("Documento cargado con exito");
                    if (window.history.replaceState) { // verificamos disponibilidad
                        window.history.replaceState(null, null, window.location.href);
                        location.reload();
                    }
                </script>
            <?php }
            
        } else if (isset($_FILES['documento']) && $_FILES['documento']['type'] != 'application/pdf') { ?>
            <script languaje "JavaScript">
                alert("El documento no es valido, debe ser un pdf");
            </script>
        <?php } ?>
    </body>
    </html>

<?php } else { ?>
    <script languaje "JavaScript">
        alert("Acceso Incorrecto");
        window.location.href = "../login.php";
    </script>
<?php } ?>