
<?php header('Content-Type: text/html; charset=UTF-8');

    session_start();
    error_reporting(0);
    
    if (isset($_SESSION['usuario'])) {
    require 'menu.php';
    
    $CODIGOUSER = trim($_SESSION['cedula']);

    $anio = Date("Y");

    if(strpos($CODIGOUSER,'-') !== false) {
        $newcode = substr(trim($CODIGOUSER), 0, -2);
    } else {
        $newcode = $CODIGOUSER;
    }

    if (isset($_GET['filterdate'])) {
        $anio = $_GET['Anio'];
    }
?>

<div class="sectionInformacion">
    <article class="sectionyear">
        <form>
            <select list="Anio" class="selectYear" type="text" name="Anio">
                <option selected>selecciona un año</option>
                <?php for ($i=2020; $i <= Date("Y"); $i++) { echo '<option value="'.$i.'" required>'.$i.'</option>'; } ?>
            </select>
            <input class="btnyear" type="submit" name="filterdate" value="buscar">
        </form>
        <p>Fecha de consulta: <?php echo $anio;?></p>
    </article>

    
    <a href="../RETENCIONDUQUESA/<?php echo $anio.'/'.$newcode;?>.pdf" download="Certificado Retencion"><img class="btnGetPdf" src="../assets/image/pdf.png"></a>
    
    <div class="canvas_container">
        <canvas id="canvasPdf"></canvas>
    </div>

    <div id="alertDocument"></div>
</div>

<script src="../js/main.js"></script>

        <?php
        $filename = '../RETENCIONDUQUESA/'.$anio.'/'.$newcode.'.pdf';

        if (file_exists($filename)) { ?>

            <script>
            document.oncontextmenu = function(){return false;}

            // Ver pdf certificado retencion
            let loadingTask = pdfjsLib.getDocument('../RETENCIONDUQUESA/' + <?php echo $anio;?> + '/' + <?php echo $newcode; ?> + '.pdf');

            loadingTask.promise.then(function(pdf) {
                pdf.getPage(1).then(function(page) {
                    let scale = 1.5;
                    let viewport = page.getViewport({ scale: scale, });
                    // Support HiDPI-screens.
                    let outputScale = window.devicePixelRatio || 1;

                    let canvas = document.getElementById('canvasPdf');
                    let context = canvas.getContext('2d');

                    canvas.width = Math.floor(viewport.width * outputScale);
                    canvas.height = Math.floor(viewport.height * outputScale);
                    canvas.style.width = Math.floor(viewport.width) + "px";
                    canvas.style.height =  Math.floor(viewport.height) + "px";

                    let transform = outputScale !== 1
                    ? [outputScale, 0, 0, outputScale, 0, 0]
                    : null;

                    let renderContext = {
                    canvasContext: context,
                    transform: transform,
                    viewport: viewport
                    };
                    page.render(renderContext);
                });
            });
            </script> <?php } else { ?>
            <script>
                document.getElementById('alertDocument').innerHTML = '<p>No existe un certificado por favor acérquese al area de gestion humana para solicitar este documento</p>';
            </script>
        <?php } ?>

<?php } else { ?>
<script languaje "JavaScript">
    alert("Acceso Incorrecto");
    window.location.href = "../login.php";
</script><?php
} ?>