<?php header('Content-Type: text/html; charset=UTF-8');

session_start();
error_reporting(0);

include '../conexionbd.php';
if (isset($_SESSION['usuario'])) {
    require 'header.php';
    require '../function/funciones.php';
    $data = funciones::buscarusuariop();

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Plataforma Planta Beneficio" />
        <meta name="author" content="Yon Gonzalez" />
        <title>Portal Empleados</title>
        <link rel="icon" type="image/x-icon" href="../assets/image/faviconplanta.png" />
        <link rel="stylesheet" href="../css/bootstrap.css" />
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>

        <link href="../css/mobiscroll.javascript.min.css" rel="stylesheet" />
        <script src="../js/mobiscroll.javascript.min.js"></script>

    </head>

    <style type="text/css">
        #global {
            height: 800px;
            width: 100%;
            border: 1px solid #ddd;
            background: #f1f1f1;
            overflow-y: scroll;
        }
    </style>


    <body>
        <section class="sectionContenido" id="global">
            <div class="">
                <div class="row">
                    <form class="container" method="POST">
                        <section class="row mt-1">
                            <section class="row col-12 mt-5">
                                <div class="col-md-3"></div>
                                <div class="col-md-2">
                                    <h5 style="text-align: center;margin-top: 50px;">Desde</h><br><br>
                                        <input class="form-control" type="date" name="fechainicial" style="width: 100%;" id="datePickerId" required>
                                </div>
                                <div class="col-md-2">
                                    <h5 style="text-align: center;margin-top: 50px;">Hasta</h><br><br>
                                        <input class="form-control" type="date" name="fechafinal" style="width: 100%;" id="datePickerId2" required>
                                </div>
                                <div class="col-md-2">
                                    <h5 style="text-align: center;margin-top: 50px;">Labor</h><br><br>
                                        <select name='labor' class="form-select" aria-label="Default select example">
                                            <option selected>SELECCIONE LA LABOR</option>
                                            <option value="902">902-SALIDA DE TUZA</option>
                                            <option value="903">903-SALIDA DE LODOS</option>
                                            <option value="0">TODOS</option>
                                        </select>
                                </div>
                                <div class="col-2">
                                    <h5 style="text-align: center;margin-top: 100px;">
                                        </h>
                                        <input type="submit" class="btn btn-success" name='consultar' value="Consultar" id="btncolor">
                                </div>
                                <div class="col-md-3"></div>
                            </section>
                        </section>
                    </form>
                </div>
            </div>



            <?php
            $F = new funciones;
            if (isset($_POST['consultar'])) {

                $fechainicial = $_POST['fechainicial'];
                $fechafinal = $_POST['fechafinal'];
                $labor = $_POST['labor'];
                

                // $ANIO = substr($fecha, 0, 4);
                // $MES = substr($fecha, 5, 2);

                if (count($F->beneficioFruta($fechainicial, $fechafinal, $labor)) !== 0) { ?>
                    <div class="">
                        <div class="text-right mt-3">
                            <div class="col-md-12">
                                <table class="table table-bordered dt-responsive table-hover display nowrap" id="mtable" cellspacing="0" width="100%" style="white-space: nowrap; overflow-x: auto;">
                                    <thead>
                                        <tr class="encabezado table-dark ">

                                            <th class="col">TIQUETE</th>
                                            <th class="col">FECHA</th>
                                            <th class="col">LABOR</th>
                                            <th class="col">DETALLE</th>
                                            <th class="col">CANTIDAD</th>
                                            <th class="col">REMOLQUES</th>
                                            <th class="col">INGRESO</th>
                                            <th class="col">FECHA INGRESO</th>
                                            <th class="col">TARA</th>
                                            <th class="col">PESO BRUTO</th>


                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $count = 1;
                                        

                                        foreach ($F->beneficioFruta($fechainicial, $fechafinal, $labor) as $a) {
                                            $sumaTotal = 0;
                                            $sumaTotalTara = 0;
                                            $sumaTotalPeso_Bruto = 0;
                                            echo "<tr>
                                                          
                                                          <td style='width:10%'>" . $a['TIQUETE'] . "</td>
                                                          <td style='width:10%'>" . date('d F Y', strtotime($a['FECHA'])) . "</td>
                                                          <td style='width:10%'>" . $a['LABOR'] . "</td>
                                                          <td style='width:10%'>" . utf8_encode($a['DETALLE']) . "</td>
                                                          <td style='width:10%'>" . number_format($a['CANTIDAD']) . "</td>
                                                          <td style='width:10%'>" . utf8_encode($a['REMOLQUES']) . "</td>
                                                          <td style='width:10%'>" . $a['Ingreso'] . "</td>
                                                          <td style='width:10%'>" . $a['F_Ingreso'] . "</td>
                                                          <td style='width:10%'>" . number_format($a['TARA']) . "</td>
                                                          <td style='width:10%'>" . number_format($a['PESO_BRUTO']) . "</td>
                                                          <input style='width:10%' type='hidden' class='CANTIDAD' value='" . $a['CANTIDAD'] . "'>
                                                          <input style='width:10%' type='hidden' class='TARA' value='" . $a['TARA'] . "'>
                                                          <input style='width:10%' type='hidden' class='PESO_BRUTO' value='" . $a['PESO_BRUTO'] . "'>
                                                          
                                                          

                            </tr>";
                            $sumaTotal += $a['CANTIDAD'];
                            $sumaTotalTara += $a['TARA'];
                            $sumaTotalPeso_Bruto += $a['PESO_BRUTO'];
                                        } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th id="CANTIDAD"></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th id="TARA"></th>
                                            <th id="PESO_BRUTO"></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            <?php } else { ?>
                                <div class="alert alert-danger mt-5" role="alert" align="center">No hay registros</div>
                        <?php }
                    } ?>
                            </div>
                        </div>
                    </div>
    </body>



    </html>
    <!-- Inicio DataTable -->
    <script type="text/javascript">
        $(document).ready(function buscar() {

            var filtros = $('#mtable').DataTable({
                initComplete: function() {
                    this.api()
                        .columns([0, 1, 2, 3, 5, 6, 7])
                        .every(function() {
                            var column = this;
                            var select = $('<select><option value=""></option></select>')
                                .appendTo($(column.footer()).empty())
                                .on('change', function() {
                                    var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                    column.search(val ? '^' + val + '$' : '', true, false).draw();
                                });

                            column
                                .data()
                                .unique()
                                .sort()
                                .each(function(d, j) {
                                    select.append('<option value="' + d + '">' + d + '</option>');
                                });
                        });
                },
            });

            var exportacion = $('#mtable').DataTable({
                info: false,
                select: true,
                "bDestroy": true,
                "bJQueryUI": true,
                "paginate": true,
                "iDisplayLength": 30,
                searching: true,
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel'
                ]
            });

        });




        // var lenguaje = $('#mtable').DataTable({

        //   "language": {
        //     "lengthMenu": "Mostrar _MENU_ registros por página.",
        //     "zeroRecords": "Lo sentimos. No se encontraron registros.",
        //     "sInfo": "Mostrando: _START_ de _END_ - Total registros: _TOTAL_ ",
        //     "infoEmpty": "No hay registros aún.",
        //     "infoFiltered": "(filtrados de un total de _MAX_ registros)",
        //     "search": "Búsqueda",
        //     "LoadingRecords": "Cargando ...",
        //     "Processing": "Procesando...",
        //     "SearchPlaceholder": "Comience a teclear...",
        //     "paginate": {
        //       "previous": "Anterior",
        //       "next": "Siguiente",
        //     }
        //   }
        // });
    </script>
    <!-- Fin DataTable -->


    <!-- Script rango de fechas -->
    <script>
        $(document).ready(function() {
            datePickerId.max = new Date().toISOString().split("T")[0];
            datePickerId.min = new Date('2023').toISOString().split("T")[0];
        });
    </script>
    <!-- fn script de rango de fechas -->

    <!-- Script rango de fechas -->
    <script>
        $(document).ready(function() {
            datePickerId2.max = new Date().toISOString().split("T")[0];
            datePickerId2.min = new Date('2023').toISOString().split("T")[0];
        });
    </script>
    <!-- fn script de rango de fechas -->

    <!-- SCRIPT SUMA TOTAL CANTIDAD -->
    <script>
    // para convertir el resultado y cada tres números poner un punto	
    const formatNumber = (number) => {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    const sumatotal = () => {
        let baseData = document.querySelectorAll('.CANTIDAD');
        let sumaTotalBase = 0;
        baseData.forEach((value) => {
            sumaTotalBase += parseFloat(value.value.substring(0));
        })

        const resultadoFormateado = formatNumber(sumaTotalBase);
        document.getElementById('CANTIDAD').innerText = resultadoFormateado;
    }

    sumatotal();
</script>

    <!-- SCRIPT SUMA TOTAL TARA -->
    <script>
    // para convertir el resultado y cada tres números poner un punto	
    const formatNumberTara = (number) => {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    const sumatotalTara = () => {
        let baseData = document.querySelectorAll('.TARA');
        let sumaTotalBase = 0;
        baseData.forEach((value) => {
            sumaTotalBase += parseFloat(value.value.substring(0));
        })

        const resultadoFormateado = formatNumberTara(sumaTotalBase);
        document.getElementById('TARA').innerText = resultadoFormateado;
    }

    sumatotalTara();
</script>


    <!-- SCRIPT SUMA TOTAL PESO_BRUTO -->
    <script>
    // para convertir el resultado y cada tres números poner un punto	
    const formatNumberPeso_BRUTO = (number) => {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    const sumatotalPeso_BRUTO = () => {
        let baseData = document.querySelectorAll('.PESO_BRUTO');
        let sumaTotalBase = 0;
        baseData.forEach((value) => {
            sumaTotalBase += parseFloat(value.value.substring(0));
        })

        const resultadoFormateado = formatNumberPeso_BRUTO(sumaTotalBase);
        document.getElementById('PESO_BRUTO').innerText = resultadoFormateado;
    }

    sumatotalPeso_BRUTO();
</script>



<?php } else { ?>
    <script languaje "JavaScript">
        alert("Acceso Incorrecto");
        window.location.href = "../login.php";
    </script><?php
            } ?>