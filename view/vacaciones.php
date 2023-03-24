<?php header('Content-Type: text/html; charset=UTF-8');
    session_start();
    error_reporting(0);
    
    if (isset($_SESSION['usuario'])) {
    require 'menu.php';
    require '../function/funciones.php';

    $CODIGOUSER = trim($_SESSION['cedula']);

    $data = funciones::vaciones($CODIGOUSER); 

    $FECING = odbc_result($data, 'FECHAIN');
    $FECHACT = odbc_result($data, 'FECHACT');
    $DIAS_DISFRUTADOS = odbc_result($data, 'DIAS_DISFRUTADOS');
    $DIAS_CORTE = odbc_result($data, 'DIAS_CORTE');
    $ACUMULADOS = odbc_result($data, 'ACUMULADOS');
?>

<div class="sectionInformacion">
    <article>
        <h2>Consulta Vacaciones</h2>
        <section class="sectionHolidays">
            <label>Fecha ingreso
                <input class="numberholidays" value="<?php echo $FECING;?>" disabled>
            </label>

            <label>Fecha Actual
                <input class="numberholidays" value="<?php echo $FECHACT;?>" disabled>
            </label>
            
            <label>Dias Acumulados
                <input class="numberholidays" value="<?php echo $ACUMULADOS;?>" disabled>
            </label>
            
            <label>Dias Disfrutados
                <input class="numberholidays" value="<?php echo number_format($DIAS_DISFRUTADOS,0);?>" disabled>
            </label>

            <label>Dias Pendientes
                <input class="numberholidays" value="<?php echo $DIAS_CORTE;?>" disabled>
            </label>
        </section>
        <section class="sectionHolidays2">
            <p class="textInfoHolidays">¡Consulta cuantos dias tienes para disfrutar de tus vacaciones!</p>
            <img class="holidays" src="../assets/image/vacaciones.png">
        </section>
    </article>

</div>

<?php } else { ?>
<script languaje "JavaScript">
    alert("Acceso Incorrecto");
    window.location.href = "../login.php";
</script><?php
} ?>