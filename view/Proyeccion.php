<?php header('Content-Type: text/html; charset=UTF-8');

session_start();
error_reporting(0);

include '../conexionbd.php';
if (isset($_SESSION['usuario'])) {
  require 'header.php';
  require '../function/funciones.php';

  $data = funciones::buscarprecionetofruta();




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
    <link rel="stylesheet" href="../css/bootstrap.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>


    <!-- LINKS & SCRIPTS PARA CALENDARIO -->

    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

  </head>

  <body>
    <!-- 
    <section id="sectionContenido">
      <label for="from">From</label>
      <input type="text" id="from" name="from">
      <label for="to">to</label>
      <input type="text" id="to" name="to">

    </section>

 -->





    <section id="sectionContenido">


      <div>

        <form action="" method="GET">

          <div class="row">

            <div class="col-md-4">

              <div class="form-group">
                <label><b>Del Dia</b></label>
                <input type="date" name="from_date" value="<?php if (isset($_GET['from_date'])) {
                                                              echo $_GET['from_date'];
                                                            } ?>" class="form-control">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label><b> Hasta el Dia</b></label>
                <input type="date" name="to_date" value="<?php if (isset($_GET['to_date'])) {
                                                            echo $_GET['to_date'];
                                                          } ?>" class="form-control">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label><b></b></label> <br>
                <button type="submit" class="btn btn-primary">Buscar</button>
              </div>
            </div>
          </div>
          <br>
        </form>
      </div>


      <table class="table table-Light table-striped-columns table-hover">
        <thead>
          <tr>
            <th scope="col">FRUTA</th>
            <th scope="col">NIT</th>
            <th scope="col">NOMBRE</th>
            <th scope="col">PESO BRUTO</th>
            <th scope="col">TARA</th>
            <th scope="col">PESO_NETO</th>

          </tr>
        </thead>
        <tbody>
          <?php foreach ($data as $fila) : ?>
            <tr>
              <td><?php echo $fila['FRUTA']; ?></td>
              <td><?php echo $fila['NIT']; ?></td>
              <td><?php echo $fila['NOMBRE']; ?></td>
              <td><?php echo $fila['PESO_BRUTO']; ?></td>
              <td><?php echo $fila['TARA']; ?></td>
              <td><?php echo $fila['PESO_NETO']; ?></td>
            </tr>
          <?php endforeach; ?>
          
        </tbody>
      </table>
    </section>






    <section class="sectionContenido">












  </body>

  </html>

<?php } else { ?>
  <script languaje "JavaScript">
    alert("Acceso Incorrecto");
    window.location.href = "../login.php";
  </script><?php
          } ?>



<script>
  $(function() {
    var dateFormat = "mm/dd/yy",
      from = $("#from")
      .datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 3
      })
      .on("change", function() {
        to.datepicker("option", "minDate", getDate(this));
      }),
      to = $("#to").datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 3
      })
      .on("change", function() {
        from.datepicker("option", "maxDate", getDate(this));
      });

    function getDate(element) {
      var date;
      try {
        date = $.datepicker.parseDate(dateFormat, element.value);
      } catch (error) {
        date = null;
      }

      return date;
    }
  });
</script>