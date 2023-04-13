<?php header('Content-Type: text/html; charset=UTF-8');

class funciones {
    public static function buscarusuariop() {
        include '../conexionbd.php';
        $data = odbc_exec($conexion,"SELECT NOMBRE,CODUSUARIO FROM CONTROL_OFIMAEnterprise..MTUSUARIO ");
        while ($Element = odbc_fetch_array($data)) { $arr[] = $Element; }
        return $arr;
}


public static function buscarprecionetofruta($fecha,$ANIO,$MES) {
    include '../conexionbd.php';
 "SELECT 
TQ.TIQUENIT AS NIT, CLI.NOMBRE,        
'PESO_NETO_MENSUAL' = ROUND((SUM(TIQUECANTI))/1000,1), 
'PESO_NETO_DIARIO' = (SELECT ISNULL((SUM(TIQUECANTI))/1000, 0)
FROM PALMERAS2013.Dbo.TIQUETE AS TQI 
WHERE TQI.TIQUENIT <>'' AND TQI.TARA>'0' AND TQI.TIQUEFINCA=TQI.TIQUEFINCA 
     AND TQI.TIQUENIT = TQ.TIQUENIT AND convert(varchar,TQI.tiquefecha,23) = '$fecha'),
   PRESUPUESTO = ROUND(AVG(PRE.Cantidad*PRE.Porcentaje),0),
   CUMPLIMIENTO = ROUND((SUM(TIQUECANTI))/1000 - AVG(PRE.Cantidad*PRE.Porcentaje),1),
   CUMPLIMIENTO_PPTO = ROUND(((SUM(TIQUECANTI))/1000 / IIF( AVG(PRE.Cantidad*PRE.Porcentaje)=0,NULL,AVG(PRE.Cantidad*PRE.Porcentaje)))*100,-1),
   IIF(ROUND(((SUM(TIQUECANTI))/1000 / IIF( AVG(PRE.Cantidad*PRE.Porcentaje)=0,NULL,AVG(PRE.Cantidad*PRE.Porcentaje)))*100,-1)> 99, 'ALTO',
   IIF(ROUND(((SUM(TIQUECANTI))/1000 / IIF( AVG(PRE.Cantidad*PRE.Porcentaje)=0,NULL,AVG(PRE.Cantidad*PRE.Porcentaje)))*100,-1)>=51,'MEDIO', 
   IIF(ROUND(((SUM(TIQUECANTI))/1000 / IIF( AVG(PRE.Cantidad*PRE.Porcentaje)=0,NULL,AVG(PRE.Cantidad*PRE.Porcentaje)))*100,-1)<=50,'BAJO', 'SIN DATOS'
   ))) as ESTADO
FROM
PALMERAS2013.Dbo.TIQUETE AS TQ
INNER JOIN PALMERAS2013.Dbo.MTPROCLI AS CLI ON TQ.TIQUENIT=CLI.NIT
INNER JOIN PALMERAS2013.Dbo.PRESFRUTA AS PRE ON TQ.LOTEALTER=PRE.Proveedor AND PRE.Anio = YEAR(TQ.TIQUEFECHA) AND PRE.Mes = MONTH(TQ.TIQUEFECHA) AND PRE.Estado = 1
WHERE    
TQ.TIQUENIT <>''AND TQ.TARA>'0' AND TQ.TIQUEFINCA='90' AND TQ.tiquefecha Between  PALMERAS2013.dbo.Esp_F_PrimerDiaMes($ANIO,$MES) And PALMERAS2013.dbo.Esp_F_UltimoDiaMes($ANIO,$MES)
GROUP BY TQ.TIQUENIT,CLI.NOMBRE, PRE.Proveedor, MONTH(TQ.TIQUEFECHA),YEAR(TQ.TIQUEFECHA), PRE.Proveedor, TQ.LOTEALTER
ORDER BY CLI.NOMBRE ASC";

    $data = odbc_exec($conexion,"SELECT 
	TQ.TIQUENIT AS NIT, CLI.NOMBRE,        
   'PESO_NETO_MENSUAL' = ROUND((SUM(TIQUECANTI))/1000,1), 
   'PESO_NETO_DIARIO' = (SELECT ISNULL((SUM(TIQUECANTI))/1000, 0)
   FROM PALMERAS2013.Dbo.TIQUETE AS TQI 
   WHERE TQI.TIQUENIT <>'' AND TQI.TARA>'0' AND TQI.TIQUEFINCA=TQI.TIQUEFINCA 
		 AND TQI.TIQUENIT = TQ.TIQUENIT AND convert(varchar,TQI.tiquefecha,23) = '$fecha'),
	   PRESUPUESTO = ROUND(AVG(PRE.Cantidad*PRE.Porcentaje),0),
	   CUMPLIMIENTO = ROUND((SUM(TIQUECANTI))/1000 - AVG(PRE.Cantidad*PRE.Porcentaje),1),
	   CUMPLIMIENTO_PPTO = ROUND(((SUM(TIQUECANTI))/1000 / IIF( AVG(PRE.Cantidad*PRE.Porcentaje)=0,NULL,AVG(PRE.Cantidad*PRE.Porcentaje)))*100,-1),
	   IIF(ROUND(((SUM(TIQUECANTI))/1000 / IIF( AVG(PRE.Cantidad*PRE.Porcentaje)=0,NULL,AVG(PRE.Cantidad*PRE.Porcentaje)))*100,-1)> 99, 'ALTO',
	   IIF(ROUND(((SUM(TIQUECANTI))/1000 / IIF( AVG(PRE.Cantidad*PRE.Porcentaje)=0,NULL,AVG(PRE.Cantidad*PRE.Porcentaje)))*100,-1)>=51,'MEDIO', 
	   IIF(ROUND(((SUM(TIQUECANTI))/1000 / IIF( AVG(PRE.Cantidad*PRE.Porcentaje)=0,NULL,AVG(PRE.Cantidad*PRE.Porcentaje)))*100,-1)<=50,'BAJO', 'SIN DATOS'
	   ))) as ESTADO
FROM
   PALMERAS2013.Dbo.TIQUETE AS TQ
   INNER JOIN PALMERAS2013.Dbo.MTPROCLI AS CLI ON TQ.TIQUENIT=CLI.NIT
   INNER JOIN PALMERAS2013.Dbo.PRESFRUTA AS PRE ON TQ.LOTEALTER=PRE.Proveedor AND PRE.Anio = YEAR(TQ.TIQUEFECHA) AND PRE.Mes = MONTH(TQ.TIQUEFECHA) AND PRE.Estado = 1
WHERE    
   TQ.TIQUENIT <>''AND TQ.TARA>'0' AND TQ.TIQUEFINCA='90' AND TQ.tiquefecha Between  PALMERAS2013.dbo.Esp_F_PrimerDiaMes($ANIO,$MES) And PALMERAS2013.dbo.Esp_F_UltimoDiaMes($ANIO,$MES)
GROUP BY TQ.TIQUENIT,CLI.NOMBRE, PRE.Proveedor, MONTH(TQ.TIQUEFECHA),YEAR(TQ.TIQUEFECHA), PRE.Proveedor, TQ.LOTEALTER
ORDER BY CLI.NOMBRE ASC");
    while ($Element = odbc_fetch_array($data)) { $arr[] = $Element; }
    return $arr;
}


}