<?php header('Content-Type: text/html; charset=UTF-8');

    session_start();
    error_reporting(0);

    include '../conexionbd.php';
    if (isset($_SESSION['usuario'])) {
        $_SESSION['estadopass']= 2; 
        $email = $_SESSION['usuario'];

        ?>

    <html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Plataforma portal empleados" />
        <meta name="author" content="Santiago Guillen" />
        <link rel="icon" type="image/x-icon" href="../assets/image/duquesa-logo-blanco.svg" />
        <link rel="stylesheet" href="../css/style.css">
        <title>Administracion Empleados</title>
    </head>
    <body>
    <div class="backgroundModal">
        <a href="../closeSesion.php"><img class="btncloseAdmin" src="../assets/image/apagar.png"></a>
        <a class="btnChangePassword" onclick="openmodal()">Cambiar Contraseña</a>

        <p class="textinfoadmin">Bienvenidos al apartado administrativo<br><span>portal de empleados</span></p>
        <section class="sectionBtns">
            <div class="btnsadmin">
                <a href="../view/editarFormatos.php"><button class="btns">Editar Formatos</button></a>
                <button class="btns" onclick="showInput()">Buscar Usuario</button>

                <section class="formsearchuser">
                    <input id="userSelect" class="searchuser" type="search" list="listamodelos" placeholder="Buscar usuario">
                <button class="btnsearchuser" onclick="buscarUsuario()">Editar<?php echo $estadopass;?></button>
                </section> 

                <datalist id="listamodelos"></datalist>
            </div>
        </section>

        <div id="modalEditUser"></div>
    </div>
    <img class="backgraundadmin" src="../assets/image/entrevista-trabajo-seleccion-candidatos-empleo.jpg" alt="imagen gestion humana">

    <section id="modalopass" class="containerchangepasswordAdmin">
            <button class="closeModalPass" onclick="closemodalpassword()">❌</button>
            <form action="../function/cambiarContraseña.php" method="POST">
                <div class="sectioninputs">
                    <label>Contraseña</label>
                    <input id="password" class="inputpass" type="password" name="newpassword" onkeyup="verifyPassword(event)" autocomplete="new-password">
                </div>

                <article class="containerinfo">
                    <p><span id="longpassword"></span>Minimo 8 caracteres</p>
                    <p><span id="verifyPass"></span>Minimo una letra mayuzcula, un numero y un caracter especial</p>
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

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="../js/main.js"></script>
    </body>
    </html>
<?php } else { ?>
    <script languaje "JavaScript">
        alert("Acceso Incorrecto");
        window.location.href = "../login.php";
    </script><?php
} ?>