<?php header('Content-Type: text/html; charset=UTF-8');
error_reporting(0); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Plataforma Planta Beneficio" />
    <meta name="author" content="Yon Gonzalez" />
    <title>Portal empleados</title>
    <link rel="icon" type="image/x-icon" href="./assets/image/faviconplanta.png" />
    <link rel="stylesheet" href="./css/bootstrap.css">

    <!-- Fuentes -->


</head>

<body>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4 " id="cajaloginformulario">
                    <div class="cssFont_1" style="font-family:'Montserrat', sans-serif">Planta Beneficio</div>
                    <div id="logopalmerasform">
                        <img src="./assets/image/palmerasdelllanologoform.png" alt="Palmeras" href="">
                    </div>
                    <form autocomplete="off" action="aute.php" method="POST">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label" id="textoformulario">Usuario</label>
                            <input type="text" class="form-control" id="" aria-describedby="" name="usuario" autocomplete="off" required>
                            <div id="textoformulario" class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label" id="textoformulario">Contraseña</label>
                            <input type="password" class="form-control" id="textoformulario" name="password" autocomplete="off" required>
                        </div>
                        <button type="submit" class="btn btn-success" name="iniciar" value="Ingresar">Iniciar</button>
                    </form>
                </div>
                <div class="col-md-4"></div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container-fluid" id="footerloginGlobal">
            <div class="row">
                <div class="col-md-6" id="footerlogin">
                    <img src="./assets/image/palmerasdelllanofooter1.png" alt=" Palmeras" href="" style="width: 100%;">
                </div>
                <div class="col-md-6" id="footerlogin2">
                    <div>
                        <p id="textofooter">| Sistemas | Correo: desarrolladorweb@duquesa.com. ©2023 All Rights Reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

</body>

</html>

















<!-- desarrolladorweb@duquesa.com.co -->