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
  <meta http-equiv="Content-Language" content="en-gb" />
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Plataforma Planta Beneficio" />
    <meta name="author" content="Yon Gonzalez" />
    <title>Portal Empleados</title>
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

  </head>

  <body>



    <section class="sectionContenido">
      <div class="container">
        <div class="row">
          <form class="container" method="GET">
            <section class="row mt-1">
              <section class="row col-12 mt-5">
                <div class="col-6">
                  <input class="form-control fechas" type="date" name="fecha" style="width: 100%;" required>
                </div>
              
                <div class="col-6">
                  <input type="submit" class="btn btn-success" name='consultar' value="Consultar" style="width: 100%;">
                </div>
              </section>
            </section>
          </form>
        </div>
      </div>

      <?php

      $F = new funciones;

      if (isset($_GET['consultar'])) {

        $fecha = $_GET['fecha'];
        $ANIO = substr($fecha,0,4);
        $MES = substr($fecha,5,2);
 
        if (count($F->buscarprecionetofruta($fecha, $ANIO, $MES)) !== 0) { ?>

          <div class="container">
            <div class="text-right mt-3">
              <div class="col-md-12">

                <table class="table table-bordered table-striped table-hover ">
                  <thead>
                    <tr class="encabezado">
                      <th scope="col">NIT</th>
                      <th scope="col">NOMBRE Y/O FINCA</th>
                      <th scope="col">PESO NETO DIARIO</th>
                      <th scope="col">PESO NETO MENSUAL</th>
                      <th scope="col">PRESUPUESTO</th>
                      <th scope="col">CUMPLIMIENTO</th>
                      <th scope="col">CUMPLIMIENTO PPTO</th>
                      <th scope="col">ESTADO</th>
                    </tr>
                  </thead>

                  <tbody >
                    <?php
                    $count = 1;

                    foreach ($F->buscarprecionetofruta($fecha, $ANIO, $MES) as $a) {

                      
                        

                      echo "<tr>
                                                          
                                                          <td style='width:10%'>" . $a['NIT'] . "</td>
                                                          <td style='width:30%'>" . $a ['NOMBRE'] . "</td>
                                                          <td style='width:10%;text-align: right;' >" . $a['PESO_NETO_DIARIO'] . "</td>
                                                          <td style='width:10%;text-align: right;' >" . $a['PESO_NETO_MENSUAL'] . "</td>
                                                          <td style='width:10%;text-align: right;' >" . $a['PRESUPUESTO'] . "</td>
                                                          <td style='width:10%;text-align: right;' >" . $a['CUMPLIMIENTO'] . "</td>
                                                          <td style='width:10%;text-align: right;' >" . $a['CUMPLIMIENTO_PPTO'] . "%</td>
                                                          <td style='width:10%;text-align: right;' >" . $a['ESTADO'] . "</td>

                            </tr>";
                          }?> 
                          </tbody>
                  </table>
                  <?php } else { ?>
                      <div class="alert alert-danger mt-5" role="alert" align="center">No hay registros</div>
                  <?php } }?>    
                  </div>
              </div>
          </div>



      </body>
      </html>
      
      <?php } else { ?>
          <script languaje "JavaScript">
              alert("Acceso Incorrecto");
              window.location.href = "../login.php";
          </script><?php
      } ?>