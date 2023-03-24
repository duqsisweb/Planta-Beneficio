<?php header('Content-Type: text/html; charset=UTF-8');

session_start();
error_reporting(0);

if (isset($_SESSION['usuario'])) {
    require 'menu.php';

    require '../function/funciones.php';

    $CODIGOUSER = trim($_SESSION['cedula']);

?>
        <form class="formSelectFormatNomina">
            <p>Selecciona el certificado</p>
            <select name="NRODOC">
                <option value="" selected>Seleccione una fecha</option>
                <?php foreach (funciones::certificadosNomiaMes($CODIGOUSER) as $val) {
                    echo "<option value='". $val['NRODCUTO'] ."'>". $val['FECHA']. "</option>";
                }?>
            </select>
            <input type="submit" name="NRODOCSUBMIT" value="Buscar">
        </form>

        <?php

if (isset($_GET['NRODOCSUBMIT'])) {

        $data = funciones::infoNomina($_GET['NRODOC']);
       
        $CODIGO = odbc_result($data, 'CODIGO');
        $CODIGONOM = odbc_result($data, 'CODIGONOM');
        $NOMBRECOMPLETO = odbc_result($data, 'NOMBRECOMPLETO');
        $CODCARGO = odbc_result($data, 'CODCARGO');
        $DEPEND = odbc_result($data, 'DEPEND');
        $SUELDO = odbc_result($data, 'SUELDO');
        $BANCO = odbc_result($data, 'BANCO');
        $DIASPAG = odbc_result($data, 'DIASPAG');
        $FECHAIN = odbc_result($data, 'FECHAIN');
        $FECHAFIN = odbc_result($data, 'FECHAFIN');
        $FECHA = odbc_result($data, 'FECHA');
        $TIPODCTO = odbc_result($data, 'TIPODCTO');
        ?>

        <div class="sectionInformacion">
            <img id="activepdfNomina" class="btnGetPdf" src="../assets/image/pdf.png">

            <article id="previewHtmlContent" class="containerDoc2">
                <section class="headerPayroll">
                    <img src="../assets/image/logoencabezado.jpg">
                    <p>DUQUESA S.A. BIC<br>
                        NIT. 860.501.145-1</p>
                    <p>NOMINA<br>
                        <?php echo $TIPODCTO . ' ' . $CODIGONOM; ?></p>
                </section>
                <p class="dataInfo">datos del empleado</p>
                <section class="sectionInfoEmployed">
                    <div>
                        <p><span>empleado: </span><?php echo utf8_encode($NOMBRECOMPLETO); ?></p>
                        <p><span>cargo: </span><?php echo $CODCARGO; ?></p>
                        <p><span>periodo: </span><?php echo $FECHAIN; ?> al <?php echo $FECHAFIN; ?></p>
                    </div>
                    <div>
                        <p><span>codigo: </span><?php echo $CODIGO; ?></p>
                        <p><span>salario: </span>$<?php echo number_format(trim($SUELDO), 0); ?></p>
                        <p><span>dependencia: </span><?php echo $DEPEND; ?></p>
                    </div>
                    <div>
                        <p><span>fecha: </span><?php echo $FECHA; ?></p>
                        <p><span>banco: </span><?php echo $BANCO; ?></p>
                        <p><span>dia de pago: </span><?php echo number_format($DIASPAG, 0); ?></p>
                    </div>
                </section>

                <table class="tablePayroll">
                    <thead class="headerTable">
                        <tr>
                            <th>Código</th>
                            <th>Descripción</th>
                            <th>Horas</th>
                            <th>Devengados</th>
                            <th>Deducciones</th>
                        </tr>
                    </thead>
                    <tbody class="bodyTable">
                        <?php foreach (funciones::datosNomina($CODIGONOM) as $val) {
                            $DEDUCCIONES = "";
                            $DEVENGADO = "";

                            $val['VALOR'] < 0 ? $DEDUCCIONES = substr($val['VALOR'], 1) : $DEVENGADO = $val['VALOR'];

                            number_format($val['NROHORAS'], 0) == 0 ? $HORA = ' ' : $HORA = number_format($val['NROHORAS'], 0);

                            echo "<tr>
                            <td>" . $val['CONCEP'] . "</td>
                            <td>" . $val['DESCRIPCIO'] . "</td>
                            <td style='text-align: right;'>" . $HORA . "</td>
                            <td style='text-align: right;'>" . number_format($DEVENGADO, 0) . "</td>
                            <td style='text-align: right;'>" . number_format($DEDUCCIONES, 0) . "</td>
                        </tr>";

                            $resultDevengados = intval($resultDevengados) + intval($DEVENGADO);
                            $resultDeducciones = intval($resultDeducciones) + intval($DEDUCCIONES);
                            $nomiApagar = $resultDevengados - $resultDeducciones;
                        } ?>
                    </tbody>
                </table>

                <section class="footerPayroll">
                    <div class="textMoney">
                        <p>Son:<br><span id="descriptionNomina" class="paragraphPayroll"></span></p>
                    </div>
                    <table class="tableTotal">
                        <tr>
                            <th>Total Devengados</th>
                            <td><?php echo number_format($resultDevengados, 0); ?></td>
                        </tr>
                        <tr>
                            <th>Total Deducciones</th>
                            <td><?php echo number_format($resultDeducciones, 0); ?></td>
                        </tr>
                        <tr>
                            <th>Nómina Por Pagar</th>
                            <td><?php echo number_format($nomiApagar, 0); ?></td>
                        </tr>
                    </table>
                </section>
                <section class="sectionFirm">
                    <p>Firma del empleado:</p>
                    <p>C. de C.</p>
                </section>

            </article>
        </div>

        <script src="../js/main.js"></script>
        <script>
            // document.oncontextmenu = function(){return false;

            function converHTMLToPDF() {
                const $elementoParaConvertir = document.getElementById('previewHtmlContent'); // <-- Aquí puedes elegir cualquier elemento del DOM
                html2pdf()
                    .set({
                        margin: -0,
                        filename: 'DesprendibleNomina.pdf',
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
                            format: [22, 22],
                            orientation: 'portrait' // landscape o portrait
                        }
                    })
                    .from($elementoParaConvertir)
                    .save()
                    .catch(err => console.log(err));
            }

            document.getElementById('activepdfNomina').addEventListener('click', function() {
                converHTMLToPDF();
            })

            let letras = numeroALetras(<?php echo $SUELDO; ?>, {
                plural: "PESOS",
                singular: "PESO",
                centPlural: "CENTAVOS",
                centSingular: "CENTAVO"
            });

            document.getElementById('descriptionNomina').textContent = letras;
        </script>

    <?php } else { ?>

        <p>Seleccione el certificado de nomina</p>

    <?php } ?>

<?php } else { ?>
    <script languaje "JavaScript">
        alert("Acceso Incorrecto");
        window.location.href = "../login.php";
    </script>
<?php } ?>