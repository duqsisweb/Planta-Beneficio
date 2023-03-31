<?php header('Content-Type: text/html; charset=UTF-8');

class funciones {
    public static function buscarusuariop() {
        include '../conexionbd.php';
        $data = odbc_exec($conexion,"SELECT NOMBRE,CODUSUARIO FROM CONTROL_OFIMAEnterprise..MTUSUARIO ");
        while ($Element = odbc_fetch_array($data)) { $arr[] = $Element; }
        return $arr;
}


public static function buscarprecionetofruta() {
    include '../conexionbd.php';

    if(isset($_GET['from_date']) && isset($_GET['to_date']))
    {
        $from_date = $_GET['tiquefecha'];
        $to_date = $_GET['tiquefecha'];

    // $date1 = date("dd-mm-aaaa", strtotime($_POST['tiquefecha']));
    // $date2 = date("dd-mm-aaaa", strtotime($_POST['tiquefecha']));

    $data = odbc_exec($conexion,"SELECT FRUTA = 'TERCERO NETO',TQ.TIQUENIT AS NIT,CLI.NOMBRE,(SUM(PESOBRUTO))/1000 AS 'PESO_BRUTO',(SUM(TARA))/1000 AS 'TARA',(SUM(TIQUECANTI))/1000 AS 'PESO_NETO' 
    FROM PALMERAS2013.Dbo.TIQUETE AS TQ
    INNER JOIN PALMERAS2013.Dbo.MTPROCLI AS CLI ON TQ.TIQUENIT=CLI.NIT
    WHERE TIQUENIT <>''AND TARA>'0' AND  TIQUEFINCA='90' AND tiquefecha Between  '$from_date' And '$to_date'
    GROUP BY TQ.TIQUENIT,CLI.NOMBRE
    ORDER BY CLI.NOMBRE ASC");
      while ($Element = odbc_fetch_array($data)) { $arr[] = $Element; }
      return $arr;

}
else{
    return printf("No se encontraron resultados");
}
}






}