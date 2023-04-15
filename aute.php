<?php
header('Content-Type: text/html; charset=UTF-8');
error_reporting(0);

if ($_POST['iniciar']) {

	header("Cache-control: private");
	include("./conexionbd.php"); 
	$usuario1=('utf8_decode'($_POST['usuario']));
	$usuario=rtrim($usuario1);
	$password1=$_POST['password'];
	$password=rtrim($password1);
	$typeUser=$_POST['typeUser'];
	$result;

	$resul = odbc_exec($conexion, " SELECT MV.NOMBRE, RTRIM(MV.CODUSUARIO) AS CODUSUARIO, RTRIM(MV.PASSWORD) AS CLAVE FROM CONTROL_OFIMAEnterprise..MTUSUARIO AS MV WHERE (MV.CODUSUARIO = '$usuario' AND MV.CODUSUARIO IN ('HRODRIGUEZ','JQUINTERO', 'LPACHON', 'SVERA', 'YTANGARIFE', 'DHENAO', 'JYDIAZ', 'YCHAVERRA', 'SGUILLEN', 'JCASILIMAS', 'YFGONZALEZ' )) AND MV.PASSWORD = '$password'") or die(exit("Error al ejecutar consulta"));
	$Nombre=odbc_result($resul, 'NOMBRE');
	$usua=rtrim(odbc_result($resul, 'CODUSUARIO')); 
	$pass=rtrim(odbc_result($resul, 'CLAVE'));

	$usua=strtoupper($usua);
	$usuario=strtoupper($usuario);

	if ($usua==$usuario and $pass==$password){
		session_start();
		$_SESSION['usuario']=$usua;
		$_SESSION['NOMBRE']=$Nombre;
		?><script>
			alert("Hola <?php echo $Nombre ?>");
			window.location.href="view/inicio.php"; 
		</script><?php 
	}else{
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
