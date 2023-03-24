<?php header('Content-Type: text/html; charset=UTF-8');

session_start();
error_reporting(0);

if (isset($_SESSION['usuario'])) {
    require 'menu.php';
    require '../function/funciones.php';

    if(isset($_GET['tipoFormato'])){
        $tipo = $_GET['tipoFormato'] == 1 ? 'Pacto colectivo' :'Otros Formatos Gestion Humana'; 
    } else {
        $tipo = '';
    }
?>

    <div class="sectionInformacion">
        <a id="downloadPdf" download="Formato"><img class="btnGetPdf" src="../assets/image/pdf.png"></a>

        <h2>Selecciona un tipo de formato para descargar</h2>
        <p class="tipoFormatoSelect"><?php echo $tipo;?></p>

        <form id="formSelectFormat" method="GET">
            <select class="selectOptionFormat" name="tipoFormato" onchange="showSelect()">
                <option selected>Selecciona un tipo de formato</option>
                <option value="1">Pacto colectivo</option>
                <option value="2">Otros Formatos Gestion Humana</option>
            </select>
        </form>

        <select class="selectformat" onchange="showFormat(event)">
            <option selected>seleccionar un formato</option>
            <?php foreach (funciones::mostrarFormatosCategoria($_GET['tipoFormato']) as $val) {
                echo "<option value='". $val['NOMBREARCHIVO'] ."'>". $val['NOMBREARCHIVO']. "</option>";
            }?>
        </select>
            
        <div class="canvas_containerFormat">
            <canvas id="canvasPdfFormat"></canvas>
        </div>

        <div id="alertDocument"></div>
    </div>

    <script src="../js/main.js"></script>

    <script>
        document.oncontextmenu = function() {return false;}

        const showSelect = () => {
            document.getElementById('formSelectFormat').submit();
        }

        <?php if(isset($_GET['tipoFormato'])){ ?>
            document.querySelector('.selectformat').style.display = 'block';
        <?php } ?>
 
        // Visualizar pdf
        function showFormat(event) {

            let value = event.target.value;

            let loadingTask = pdfjsLib.getDocument(`../formatos/${value}`);

            loadingTask.promise.then(function(pdf) {
                pdf.getPage(1).then(function(page) {
                    let scale = 1.5;
                    let viewport = page.getViewport({
                        scale: scale,
                    });
                    // Support HiDPI-screens.
                    let outputScale = window.devicePixelRatio || 1;
                    let canvas = document.getElementById('canvasPdfFormat');
                    let context = canvas.getContext('2d');

                    canvas.width = Math.floor(viewport.width * outputScale);
                    canvas.height = Math.floor(viewport.height * outputScale);
                    canvas.style.width = Math.floor(viewport.width) + "px";
                    canvas.style.height = Math.floor(viewport.height) + "px";

                    let transform = outputScale !== 1 ? [outputScale, 0, 0, outputScale, 0, 0] :
                        null;

                    let renderContext = {
                        canvasContext: context,
                        transform: transform,
                        viewport: viewport
                    };
                    page.render(renderContext);
                });
            });

            document.getElementById('downloadPdf').href = `../formatos/${value}`;
        }
    </script>

<?php } else { ?>
    <script languaje "JavaScript">
        alert("Acceso Incorrecto");
        window.location.href = "../login.php";
    </script><?php
            } ?>