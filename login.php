<?php header('Content-Type: text/html; charset=UTF-8');
    error_reporting(0);?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Plataforma portal empleados" />
    <meta name="author" content="Santiago Guillen" />
    <title>Portal empleados</title>
    <link rel="icon" type="image/x-icon" href="" />
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <span id="alertEmail">Esto no es un correo valido</span>

    <article class="containerLogin">
        <section class="sectionTitle">
            <h2>Selecciona un tipo de cuenta</h2>
        </section>

        <section class="cardsTypeUser">
            <div id="user2" class="cardUser" onclick="getTypeUser(2)">
                <img src="./assets/image/usuario.png" title="userEmployee">
                <p>Usuario</p>
            </div>
            <div id="user1" class="cardUser" onclick="getTypeUser(1)">
                <img src="./assets/image/grupo.png" title="userEmployee">
                <p>Administrador</p>
            </div>
        </section>

        <form autocomplete="off" action="aute.php" method="POST">
            <section class="sectionInputs">
                <input id="email" class="inputsLogin" type="text" name="usuario" placeholder="Ingrese su usuario" onkeyup="verifyEmail(event)" autocomplete="off" required> 
                <input class="inputsLogin" type="password" name="password" placeholder="Ingrese su contraseña" onkeyup="verifyPassword(event)" autocomplete="off" required>
                <input id="type" type="hidden" name="typeUser">
            </section>
            <input class="btnLogin" id="btnLogin" type="submit" name="iniciar" value="Ingresar" disabled />
        </form>
        <p class="textInfo">Sistema portal de nomina Duquesa S.A</p>
    </article>

    <script>
        
        let regex = /(\s*([\0\b\'\"\n\r\t\%\_\\]*\s*(((select\s*.+\s*from\s*.+)|(insert\s*.+\s*into\s*.+)|(update\s*.+\s*set\s*.+)|(delete\s*.+\s*from\s*.+)|(drop\s*.+)|(truncate\s*.+)|(alter\s*.+)|(exec\s*.+)|(\s*(all|any|not|and|between|in|like|or|some|contains|containsall|containskey)\s*.+[\=\>\<=\!\~]+.+)|(let\s+.+[\=]\s*.*)|(begin\s*.*\s*end)|(\s*[\/\*]+\s*.*\s*[\*\/]+)|(\s*(\-\-)\s*.*\s+)|(\s*(contains|containsall|containskey)\s+.*)))(\s*[\;]\s*)*)+)/i;

        // document.oncontextmenu = function(){return false;}
        
        // Asignar el identificador de tipo de usuario
        function getTypeUser(value) { 
            document.getElementById('type').value = value;
            document.getElementById('btnLogin').disabled = false;
            document.getElementById('btnLogin').style.cursor = 'pointer';

            if(value == 2) {
                document.getElementById(`user${value}`).style.background = '#000000';
                document.getElementById(`user1`).style.background = '#ffffff';   
            } else {
                document.getElementById(`user${value}`).style.background = '#000000';   
                document.getElementById(`user2`).style.background = '#ffffff';   
            }

        }

        const verifyEmail = (event) => {
            if (regex.test(event.target.value)) { location.reload();}
            let emailRex = /^[^@]+@[^@]+\.[a-zA-Z]{2,}$/;

            if (!emailRex.test(event.target.value)){
                document.getElementById('email').style.background = 'red';
                document.getElementById('email').style.color = 'white';
                document.getElementById('alertEmail').style.display = 'block';
            } else {
                document.getElementById('email').style.background = 'white';
                document.getElementById('email').style.color = 'black';
                document.getElementById('alertEmail').style.display = 'none';
            }
        }

        const verifyPassword = (event) => {
            if (regex.test(event.target.value)) { location.reload();}
        }


    </script>
</body>
</html>

















<!-- jose.casilimas@hotmail.com -->