<?php
header('Content-Type: text/html; charset=UTF-8');
error_reporting(0);

if ($_POST['iniciar']) {

	header("Cache-control: private");
	include("./conexionbd.php"); 
	$usuario1=(utf8_decode($_POST['usuario']));
	$usuario=rtrim($usuario1);
	$password1=$_POST['password'];
	$password=rtrim($password1);
	$typeUser=$_POST['typeUser'];
	$result;

	if ($typeUser == 1) {
		$resul = odbc_exec($conexion, "SELECT name, RTRIM(email) AS emailUsuario, RTRIM(password) AS CLAVE, TipoUsuario,estadoPassword
		FROM DUQUESA..users WHERE email =  '$usuario' AND TipoUsuario = 2 AND 
		sistemaClasificador = 'ADMIN' AND Estado = 1")or die(exit("Error al ejecutar consulta"));
	} else {
		$resul = odbc_exec($conexion, "SELECT name, RTRIM(US.email) AS emailUsuario, RTRIM(US.password) AS CLAVE, US.TipoUsuario, RTRIM(MTE.CODIGO) AS CEDULA, estadoPassword
		FROM DUQUESA..users AS US INNER JOIN DUQUESA..MTEMPLEA AS MTE ON MTE.EMAIL = US.email
		WHERE US.email = '$usuario' AND US.sistemaClasificador = 'EMPLEADO' AND US.Estado = 1 AND FECRETIRO >= '2100-12-31'")or die(exit("Error al ejecutar consulta"));
	}

	$Nombre=odbc_result($resul, 'name');
	$usua=rtrim(odbc_result($resul, 'emailUsuario')); 
	$pass=rtrim(odbc_result($resul, 'CLAVE'));
	$TipoUsuario=rtrim(odbc_result($resul, 'TipoUsuario'));
	$cedula=rtrim(odbc_result($resul, 'CEDULA'));
	$estadopass=rtrim(odbc_result($resul, 'estadoPassword'));

	$usua=strtoupper($usua);
	$usuario=strtoupper($usuario);

	if (($usua==$usuario) && (password_verify($password,$pass)) && ($estadopass == 1)){
		session_start();
		$_SESSION['usuario']=$usua;
		$_SESSION['Name']=$Nombre;
		$_SESSION['cedula']=$cedula;
		$_SESSION['estadopass']=$estadopass;

		$TipoUsuario == 2 && $typeUser == 1 ? $url = 'administracion.php' : $url = 'inicio.php' ?>
		
		<script>
			alert("Bienvenido <?php echo $Nombre ?>");
			window.location.href="./view/<?php echo $url; ?>"; 
		</script>
		<?php 
	} else if ($usua==$usuario and $password == $pass and $estadopass == 0){

		session_start();
		$_SESSION['usuario']=$usua;
		$_SESSION['Name']=$Nombre;
		$_SESSION['cedula']=$cedula;
		$_SESSION['estadopass']=$estadopass;

		$TipoUsuario == 2 && $typeUser == 1 ? $url = 'administracion.php' : $url = 'inicio.php' ?>
		
		<script>
			window.location.href="./view/<?php echo $url; ?>"; 
		</script>
		<?php 

	}else if ($typeUser == 1){
		?><script>
			alert("No tienes perfil administrador");
			window.location.href="login.php"; 
		</script><?php 
		
	} else {
		?><script>
			alert("Credenciales incorrectas");
			window.location.href="login.php"; 
		</script><?php 
	}

}else{ 
	?><script>
		alert("Ingreso Erroneo");
		window.location.href="login.php"; 
	</script><?php
}
