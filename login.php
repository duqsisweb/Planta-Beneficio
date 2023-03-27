<?php header('Content-Type: text/html; charset=UTF-8');
    error_reporting(0);?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Plataforma Planta Beneficio" />
    <meta name="author" content="Yon Gonzalez" />
    <title>Portal empleados</title>
    <link rel="icon" type="image/x-icon" href="../assets/image/faviconplanta.png" />
    <link rel="stylesheet" href="./css/bootstrap.css">

<!-- Fuentes -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">

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
                            <input type="text" class="form-control" id="" aria-describedby="" name="usuario"  autocomplete="off" required>
                            <div id="textoformulario" class="form-text">We'll never share your email with anyone else.</div>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label" id="textoformulario">Contraseña</label>
                            <input type="password" class="form-control" id="textoformulario" name="password"  autocomplete="off" required>
                        </div>
                        <button type="submit" class="btn btn-success" name="iniciar" value="Ingresar" >Iniciar</button>
                    </form>
                </div>
                <div class="col-md-4"></div>
            </div>
        </div>
    </section>

</body>
</html>

















<!-- desarrolladorweb@duquesa.com.co -->