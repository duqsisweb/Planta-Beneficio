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
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Plataforma portal empleados" />
    <meta name="author" content="Santiago Guillen" />
    <title>Portal Empleados</title>
    <link rel="icon" type="image/x-icon" href="../assets/image/duquesa-logo-blanco.svg" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <button class="btnMenu" onclick="showMenu()"><i class="material-icons">menu</i></button>
    <button class='btnCloseMenu' onclick="hiddeMenu()"><i class="material-icons">reply</i></button>
    <nav>
        <a href="./inicio.php"><img class="logo" src="../assets/image/duquesa-logo-blanco.svg" ></a>
        <p class="user"><?php echo utf8_encode($_SESSION['Name']); ?></p>
        <hr class="lineUser">
        <ul>

            <li>Certificados
                <ul class="children">
                    <li><a href="./CertificadoLaboral.php">Certificado Laboral</a></li>
                    <li><a href="./CertificadoRetencion.php">Certificado Retencion</a></li>
                    <li><a href="./desprendibleNomina.php">Desprendible de nomina</a></li>
                </ul>
            </li>
            <li><a class="listOption" href="./vacaciones.php">Vacaciones</a></li>
            <li><a class="listOption" href="./formatosDuquesa.php">Formatos</a></li>
            <li><a class="listOption" href="./reglamentoInterno.php" target="_blank">Reglamento Interno</a></li>
            <li><a class="listOption" onclick="openmodal()">Cambiar Contraseña</a></li>
        </ul>
        <a href="../closeSesion.php"><button class="btnCloseSesion">Cerrar Sesión</button></a>
    </nav>

    <section id="modalopass" class="containerchangepassword">
        <button class="closeModalPass" onclick="closemodalpassword()">❌</button>
        <form action="../function/cambiarContraseña.php" method="POST">
            <div class="sectioninputs">
                <label>Contraseña</label>
                <input id="password" class="inputpass" type="password" name="newpassword" onkeyup="verifyPassword(event)" autocomplete="new-password">
            </div>

            <article class="containerinfo">
                <p><span id="longpassword"></span>Minimo 8 caracteres</p>
                <p><span id="verifyPass"></span>Minimo una letra mayuscula, un numero y un caracter especial</p>
            </article> 
            
            <div class="sectioninputs">
                <label>Confirmar Contraseña</label>
                <input class="inputpass" type="password" name="matchPassword" onchange="matchpass(event)" autocomplete="new-password">
                <p id="menssagematch" class="containermatch"></p>
            </div>

            <input type="hidden" name="emailuser" value="<?php echo $email;?>">

            <div class="changepass">
                <input id="btnchangepass" type="submit" name="changepassword" value="Cambiar contraseña" disabled>
            </div>
        </form>
    </section>

    <?php if ($estadopass == 0){ ?>
            <script languaje "JavaScript">
                alert("Debe cambiar su contraseña");
                document.getElementById('modalopass').style.display = 'block';
                document.querySelector('.closeModalPass').disabled = true;
            </script><?php
        }?>

    <script src="../js/main.js"></script>
    <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.2.146/pdf.min.js" integrity="sha512-hA0/Bv8+ywjnycIbT0xuCWB1sRgOzPmksIv4Qfvqv0DOKP02jSor8oHuIKpweUCsxiWGIl+QaV0E82mPQ7/gyw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>

<?php } else { ?>
    <script languaje "JavaScript">
        alert("Acceso Incorrecto");
        window.location.href = "../login.php";
    </script><?php
} ?>