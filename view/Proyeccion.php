<?php

header('Content-Type: text/html; charset=UTF-8');
session_start();
error_reporting(0);

include '../conexionbd.php';
if (isset($_SESSION['usuario'])) {
  require 'header.php';
  require '../function/funciones.php';

?>
  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml" lang="en">


  <meta http-equiv="Content-Language" content="en-gb" />

  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Plataforma Planta Beneficio" />
    <meta name="author" content="Yon Gonzalez" />
    <title>Proyeccion</title>
    <link rel="icon" type="image/x-icon" href="../assets/image/faviconplanta.png" />
    <link rel="stylesheet" href="../css/bootstrap.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>


    <!-- LINKS & SCRIPTS PARA CALENDARIO -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.2/css/uikit.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.uikit.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.uikit.min.js"></script>
    <script src="https://momentjs.com/downloads/moment.js"></script>


    <!-- para exportar documentos -->

    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css" rel="stylesheet" />



    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>


  </head>


  <style>

  </style>

  <body>


    <section class="sectionContenido">
      <div class="">
        <div class="row">
          <form class="container" method="POST">
            <section class="row mt-1">
              <section class="row col-12 mt-5">
                <div class="col-6">
                  <input class="form-control fechas" type="date" name="fecha" style="width: 100%;" id="datePickerId" required>
                </div>

                <div class=" col-6">
                  <input type="submit" class="btn btn-success" name='consultar' value="Consultar" id="btncolor">
                </div>
              </section>
            </section>
          </form>
        </div>
      </div>
      <?php
      $F = new funciones;

      if (isset($_POST['consultar'])) {

        $fecha = $_POST['fecha'];
        $ANIO = substr($fecha, 0, 4);
        $MES = substr($fecha, 5, 2);

        if (count($F->buscarprecionetofruta($fecha, $ANIO, $MES)) !== 0) { ?>
          <div class="">
            <div class="text-right mt-3">
              <div class="col-md-12">
                <table class="table table-bordered dt-responsive table-hover display nowrap" id="mtable" cellspacing="0" width="100%">
                  <thead>
                    <tr class="encabezado table-dark">
                      <th scope="col">NIT</th>
                      <th scope="col">NOMBRE Y/O FINCA</th>
                      <th scope="col">INGRESO RFF DIARIO</th>
                      <th scope="col">INGRESO RFF MENSUAL</th>
                      <th scope="col">PRESUPUESTO DEL MES</th>
                      <th scope="col">CUMPLIMIENTO</th>
                      <th scope="col">CUMPLIMIENTO PPTO</th>
                      <th scope="col">ESTADO</th>
                    </tr>
                  </thead>

                  <tbody>
                    <?php
                    $count = 1;

                    foreach ($F->buscarprecionetofruta($fecha, $ANIO, $MES) as $a) {




                      echo "<tr>
                                                          
                                                          <td style='width:10%'>" . $a['NIT'] . "</td>
                                                          <td style='width:30%'>" . $a['NOMBRE'] . "</td>
                                                          <td style='width:10%;text-align: right;' >" . $a['PESO_NETO_DIARIO'] . "</td>
                                                          <td style='width:10%;text-align: right;' >" . $a['PESO_NETO_MENSUAL'] . "</td>
                                                          <td style='width:10%;text-align: right;' >" . $a['PRESUPUESTO'] . "%</td>
                                                          <td style='width:10%;text-align: right;' >" . round($a['CUMPLIMIENTO'], -1) . "%</td>
                                                          <td style='width:10%;text-align: right;' >" . $a['CUMPLIMIENTO_PPTO'] . "%</td>
                                                          <td style='width:10%;text-align: right;' >" . $a['ESTADO'] . "</td>

                            </tr>";
                    } ?>
                  </tbody>
                </table>
              <?php } else { ?>
                <div class="alert alert-danger mt-5" role="alert" align="center">No hay registros</div>
            <?php }
          } ?>
              </div>
            </div>
          </div>



          <!-- prueba de exportacion -->



  </body>

  </html>


  <!-- Inicio DataTable -->
  <script type="text/javascript">
    $(document).ready(function() {


      
      var lenguaje = $('#mtable').DataTable({
        "language": {
          "lengthMenu": "Mostrar _MENU_ registros por página.",
          "zeroRecords": "Lo sentimos. No se encontraron registros.",
          "sInfo": "Mostrando: _START_ de _END_ - Total registros: _TOTAL_ ",
          "infoEmpty": "No hay registros aún.",
          "infoFiltered": "(filtrados de un total de _MAX_ registros)",
          "search": "Búsqueda",
          "LoadingRecords": "Cargando ...",
          "Processing": "Procesando...",
          "SearchPlaceholder": "Comience a teclear...",
          "paginate": {
            "previous": "Anterior",
            "next": "Siguiente",
          }
        }
      });


      var estados = $('#mtable').DataTable({
        searching: true,
        "createdRow": function(row, data, index) {
          //pintar una celda
          if (data[7] == "ALTO") {
            $('td', row).eq(7).css({
              'background-color': '#16A085',
              'color': 'white',
            });

          }
          if (data[7] == "MEDIO") {
            $('td', row).eq(7).css({
              'background-color': '#F4D03F',
              'color': 'white',
            });

          }
          if (data[7] == "BAJO") {
            $('td', row).eq(7).css({
              'background-color': '#F1948A',
              'color': 'white',
            });

          }

        },
        // "bServerSide": true, 
        "bDestroy": true,
        "bJQueryUI": true,
        "iDisplayLength": 20,

      });

      var exportacion = $('#mtable').DataTable({
        "bDestroy": true,
        dom: 'Bfrtip',
        buttons: [
          'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });


    });
  </script>
  <!-- Fin DataTable -->



  <script>
    $(document).ready(function() {
      datePickerId.max = new Date().toISOString().split("T")[0];
      datePickerId.min = new Date('2023').toISOString().split("T")[0];
     

    });
  </script>
  <!-- Script de los botones excel, PDP, Print -->


<?php } else { ?>
  <script languaje "JavaScript">
    alert("Acceso Incorrecto");
    window.location.href = "../login.php";
  </script><?php
          } ?>