
<?php header('Content-Type: text/html; charset=UTF-8');

    session_start();
    error_reporting(0);
    
    if (isset($_SESSION['usuario'])) {
    require 'menu.php';

    require '../function/funciones.php';

    $CODIGOUSER = trim($_SESSION['usuario']);

    $data = funciones::obtenerInfoLaboral($CODIGOUSER); 
    $CODIGO = odbc_result($data, 'CODIGO');
    $NOMBRECOMPLETO = odbc_result($data, 'NOMBRECOMPLETO');
    $CARGO = odbc_result($data, 'CARGO');
    $TIPCONTRA = odbc_result($data, 'TIPOCONTRATO');
    $SUELDO = odbc_result($data, 'SUELDO');
    $ANO = odbc_result($data, 'ANO');
    $MES = odbc_result($data, 'MES');
    $DIA = odbc_result($data, 'DIA');
    $ANOACTUAL = odbc_result($data, 'ANOACTUAL');
    $MESACTUAL = odbc_result($data, 'MESACTUAL');
    $DIAACTUAL = odbc_result($data, 'DIAACTUAL');

    if(strpos($CODIGO,'-') !== false) {
        $newcode = substr(trim($CODIGO), 0, -2);
    } else {
        $newcode = $CODIGO;
    }

    date_default_timezone_set('UTC');
    
    $Fecha = date('F');

    $meses = array("Enero", "Febrero", "Marzo", "Abril","Mayo", "Junio", "Julio", "Agosto","Septiembre","Octubre","Noviembre","Diciembre");
?>

<div class="sectionInformacion">
    <img id="activepdf" class="btnGetPdf" src="../assets/image/pdf.png" >
    
    <article id="previewHtmlContent" class="containerDoc">
        <img class="marcaAgua" src="../assets/image/Duquesamarca.png" >
        <section class="imageHeader">
            <div>
                <img src="../assets/image/logoencabezado.jpg">
                <img src="../assets/image/Iso.png">
            </div>
            <img class="imgCalidad" src="../assets/image/calidad.png">
        </section>    

        <section class="textHeader">
            <p>DUQUESA S.A. BIC<br>
            NIT. 860.501.145-1</p>
            <p>Carrera 106 N° 17B 86 Fontibón, Bogotá - Colombia<br>
            PBX: (57-1) 7957930<br>
            www.duquesa.com.co e-mail: duquesa@duquesa.com.co</p>
        </section>

        <h2 class="titleoDoc">EL DEPARTAMENTO DE GESTIÓN HUMANA CERTIFICA:</h2>

        <p class="paragraph">Que el (la) señora(a) <strong><?php echo utf8_encode($NOMBRECOMPLETO);?></strong>, identificado(a) con la cédula de ciudadanía <strong>No.
        <?php echo $newcode;?></strong> labora en la empresa <strong>DUQUESA S.A</strong>, desempeñando el cargo <strong><?php echo $CARGO;?></strong>,mediante un contrato a <strong><?php echo $TIPCONTRA;?></strong> desde el dia <strong><?php echo $DIA;?> de <?php echo $meses[intval($MES)-1] ?> de <?php echo $ANO;?></strong>
        </p>

        <p id="description" class="paragraph"></p>

        <p class="paragraph">La presente certificación se expide a solicitud del <strong>INTERESADO</strong>, en Bogotá D.C, el dia <?php echo $DIAACTUAL;?> de <?php echo $meses[intval($MESACTUAL)-1];?> de <?php echo $ANOACTUAL;?> - (<?php echo $DIAACTUAL;?>/<?php echo $MESACTUAL;?>/<?php echo $ANOACTUAL;?>)</p>

        <p class="paragraphgreeting">Cordialmente</p>

        <section class="firm">
            <img src="../assets/image/firmaGestionHumana.png">
            <p>Julieth Montañez Zuñiga<br>
            Jefe de Gestion Humana y Administrativa</p>
        </section>
    </article>

    <section id="modalmessage" class="message">
        <p>Si requiere que el certificado laboral contenga valor de comisión, variable, auxilios, rodamiento y/o otra especificación adicional se debe solicitar directamente al área de nómina</p>
        <button class="btnclosemodal" onclick="closeMessage()">cerrar</button> 
    </section>


</div>

<script src="../js/main.js"></script>
<script>

    // document.oncontextmenu = function(){return false;}

    const closeMessage = () => {
        document.getElementById('modalmessage').style.display = 'none';
    }

    function converHTMLToPDF() {
        const $elementoParaConvertir = document.getElementById('previewHtmlContent'); // <-- Aquí puedes elegir cualquier elemento del DOM
        html2pdf()
        .set({
            margin: -1,
            filename: 'CertificadoLaboral.pdf',
            image: {
                type: 'jpeg',
                quality: 0.98,
            },
            html2canvas: {
                scale: 2, // A mayor escala, mejores gráficos, pero más peso
                letterRendering: true,
            },
            jsPDF: {
                unit: "cm",
                format: [24, 24],
                orientation: 'portrait' // landscape o portrait
            }
        })
        .from($elementoParaConvertir)
        .save()
        .catch(err => console.log(err));
    }

    document.getElementById('activepdf').addEventListener('click', function () {
        converHTMLToPDF()
    })

    let letras = numeroALetras(<?php echo $SUELDO;?>, {
		plural: "PESOS",
		singular: "PESO",
		centPlural: "CENTAVOS",
		centSingular: "CENTAVO"
	});

    document.getElementById('description').innerHTML = `Asignación mensual de <strong> ${letras} ($<?php echo number_format($SUELDO, 0)?>)</strong>`;
</script>

<?php } else { ?>
<script languaje "JavaScript">
    alert("Acceso Incorrecto");
    window.location.href = "../login.php";
</script><?php
} ?>