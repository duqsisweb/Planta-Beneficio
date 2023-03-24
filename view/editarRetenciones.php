<?php 
    header('Content-Type: text/html; charset=UTF-8');

    session_start();
    error_reporting(0);
    
    if (isset($_SESSION['usuario'])) {
    
    $anio = Date("Y");

    $CODIGOUSER = $_GET['codigo'];

    if(strpos($CODIGOUSER,'-') !== false) {
        $newcode = substr(trim($CODIGOUSER), 0, -2);
    } else {
        $newcode = $CODIGOUSER;
    }

    if (isset($_GET['filterdate'])) {
        $anio = $_GET['Anio'];
        $newcode = $_GET['newcode'];
    }

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
    <div class="containerAdminRetencion">
        <article class="formDatesReten">
            <form>
                <input type="hidden" name="newcode" value="<?php echo $newcode; ?>">
                <select list="Anio" class="selectYear" type="text" name="Anio">
                    <option selected>selecciona un año</option>
                    <?php for ($i=2020; $i <= Date("Y"); $i++) { echo '<option value="'.$i.'" required>'.$i.'</option>'; } ?>
                </select>
                <input class="btnyear" type="submit" name="filterdate" value="buscar">
            </form>
        </article>

        <button class="btnRefresh" onclick="refreshPage()">Actualizar Página</button>

        <article class="sectionsReten">
            <div class="canvas_containerReten">
                <div id="upDocunent"></div>
                <canvas id="canvasPdfAdminRete"></canvas>
            </div>
            <section class="options">
                <a class="btnOptions" href="../RETENCIONDUQUESA/<?php echo $anio.'/'.$newcode;?>.pdf" download="Certificado Retencion"><button>descargar</button></a>
                <a class="btnOptions" onclick="deleteReten(2)"><button>borrar archivo</button></a>
                <a class="btnOptions" href="../view/administracion.php"><button>volver</button></a>
            </section>
        </article>

        <section id="alertDelete" class="alertConfirmDelete">
            <p>Esta seguro que desea eliminar este documentento</p>
            <div class="btnsConfirm">
                <button onclick="deleteReten(1)">Aceptar</button>
                <button onclick="closeAlertDelete()">Cancelar</button>
            </div>
        </section>

        <div id="alertRetenc"></div>
        <input id="url" type="hidden">
    </div>
    
<script src="../js/main.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.2.146/pdf.min.js" integrity="sha512-hA0/Bv8+ywjnycIbT0xuCWB1sRgOzPmksIv4Qfvqv0DOKP02jSor8oHuIKpweUCsxiWGIl+QaV0E82mPQ7/gyw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <?php
        $filename = '../RETENCIONDUQUESA/'.$anio.'/'.$newcode.'.pdf';

        if (file_exists($filename)) { ?>

            <script>
            // document.oncontextmenu = function(){return false;}

            document.getElementById('url').value = '<?php echo $filename;?>';
            document.querySelector('.btnRefresh').style.display = 'none';

            // Ver pdf certificado retencion
            let loadingTask = pdfjsLib.getDocument('../RETENCIONDUQUESA/' + <?php echo $anio;?> + '/' + <?php echo $newcode; ?> + '.pdf');

            loadingTask.promise.then(function(pdf) {
                pdf.getPage(1).then(function(page) {
                    let scale = 1.3;
                    let viewport = page.getViewport({ scale: scale, });
                    // Support HiDPI-screens.
                    let outputScale = window.devicePixelRatio || 1;

                    let canvas = document.getElementById('canvasPdfAdminRete');
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
                let formInput = `
                <form class="container-input" action="" method="post" enctype="multipart/form-data">
                    <h2>Sube el certificado de retencion del usuario</h2>
                    <input type="file" name="documento" id="file-5" class="inputfile inputfile-5"/>
                    <label for="file-5">
                        <figure>
                            <svg xmlns="http://www.w3.org/2000/svg" class="iborrainputfile" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path></svg>
                        </figure>
                    </label>
                    <input class="btnUpDoc" type="submit" value='Subir'>
                </form>`;

                document.getElementById('upDocunent').innerHTML = formInput;
            </script>
        <?php }
            
            $tamanio = 300;

            if(isset($_FILES['documento']) && $_FILES['documento']['type'] == 'application/pdf'){

                if( $_FILES['documento']['size'] < ($tamanio * 1024) ){
                    move_uploaded_file( $_FILES['documento']['tmp_name'], '../RETENCIONDUQUESA/'. $anio . '/' . $_FILES['documento']['name']);
                    ?>
                    <script languaje "JavaScript">
                        let message = 'El documento fue cargado con exito';
                        showAlertReten(message);
                    </script>
                <?php }else{ ?>
                    <script languaje "JavaScript">
                        alert("El documento supera la capacitadad de tamaño permitida");
                    </script>
                <?php 
                }

            }else if(isset($_FILES['documento']) && $_FILES['documento']['type'] != 'application/pdf'){ ?>
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
</script><?php
} ?>