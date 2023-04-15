<?php

header('Content-Type: text/html; charset=UTF-8');
session_start();
error_reporting(0);

include '../conexionbd.php';
if (isset($_SESSION['usuario'])) {
  require 'header.php';
  require '../function/funciones.php';

?>

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
                      <th scope="col">PRESUPUESTO DEL MES(TON)</th>
                      <th scope="col">CUMPLIMIENTO (TON)</th>
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
                                                          <td style='width:30%'>" . utf8_encode($a['NOMBRE'] ). "</td>
                                                          <td style='width:10%;text-align: right;' >" . $a['PESO_NETO_DIARIO'] . "</td>
                                                          <td style='width:10%;text-align: right;' >" . $a['PESO_NETO_MENSUAL'] . "</td>
                                                          <td style='width:10%;text-align: right;' >" . $a['PRESUPUESTO'] . "</td>
                                                          <td style='width:10%;text-align: right;' >" . round($a['CUMPLIMIENTO'], -1) . "</td>
                                                          <td style='width:10%;text-align: right;' >" . $a['CUMPLIMIENTO_PPTO'] . "%</td>
                                                          <td style='width:10%;text-align: right;' >" . $a['ESTADO'] . "</td>

                            </tr>";
                    } ?>
                  </tbody>
                  <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
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
    $(document).ready(function() {

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


      var estados = $('#mtable').DataTable({
        
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
        // "bDestroy": true,
        // "bJQueryUI": true,
        // "paginate":false,
        // "iDisplayLength": 30,
        // searching: false,

      });

      var exportacion = $('#mtable').DataTable({
        "bDestroy": true,
        "bJQueryUI": true,
        "paginate":false,
        "iDisplayLength": 30,
        searching: false,
        dom: 'Bfrtip',
        buttons: [
          'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });

      
      // var sumatbl = $('#mtable').DataTable({
      //   "drawCallback":function(){
      //                 //alert("La tabla se está recargando"); 
      //                 var api = this.api();
      //                 $(api.column(3).footer()).html(
      //                     'Total: '+api.column(3, {page:'current'}).data().sum()
      //                 )
      //           },
      // });

    });
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


<?php } else { ?>
  <script languaje "JavaScript">
    alert("Acceso Incorrecto");
    window.location.href = "../login.php";
  </script><?php
          } ?>