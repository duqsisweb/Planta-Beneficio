<?php header('Content-Type: text/html; charset=UTF-8');

class funciones
{
    public static function buscarusuariop()
    {
        include '../conexionbd.php';
        $data = odbc_exec($conexion, "SELECT NOMBRE,CODUSUARIO FROM CONTROL_OFIMAEnterprise..MTUSUARIO ");
        while ($Element = odbc_fetch_array($data)) {
            $arr[] = $Element;
        }
        return $arr;
    }


    public static function buscarprecionetofruta($fecha, $ANIO, $MES)
    {
        include '../conexionbd.php';

        $data = odbc_exec($conexion, "SELECT 
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
        while ($Element = odbc_fetch_array($data)) {
            $arr[] = $Element;
        }
        return $arr;
    }



    public static function beneficioFruta($fechainical, $fechafinal, $labor)
    {
        include '../conexionbd.php';

        $nlabor = ($labor == 0) ? '' : $labor; //condicion ternaria
        $data = odbc_exec($conexion, "SELECT 
        tq.idtiquete as TIQUETE,
        tq.tiquefecha as FECHA,
        rtrim(tq.tiquefinca)+'-'+rtrim(FC.fincadesc) as FINCA,
        rtrim(tq.tiquelote)+'-'+rtrim(LT.lotenomb) as LOTE,
        rtrim(tq.tiquecodcc)+'-'+rtrim(CC.nombre)  as SIEMBRA, 
        rtrim(tq.tiquelabor)+'-'+rtrim(LB.labonomb) as LABOR,
        tq.tiquedeta as DETALLE,
        tq.tiquecanti as CANTIDAD,
        TQ.REMOLQUES AS REMOLQUES,
        rtrim(tq.tiqueping) as Ingreso,
        tq.tiquefechi as F_Ingreso,
        rtrim(tq.passwordmo) as Modifico,
        tq.fecmod as F_Modifico,
        convert(decimal,tq.fecmod-tq.tiquefecha) as 'FECHA TIQ vs MODIFI',
        convert(decimal,tq.fecmod-tq.tiquefechi) as 'INGRESO vs MODIFI',
        'Valor Promedio HORA'=CASE WHEN tq.tiquehora=0 THEN 0 ELSE (tq.tiquecanti*tq.tiquevalor)+tq.tiquehora END, 
        Extratora=CASE WHEN tiquefinca in('03','09') or tiquecodcc='20101' THEN 'Extractora Porvenir' ELSE 'Extractora Palmeras' END, 
        Productiva=CASE WHEN CC.productivo=1 THEN 'SI' ELSE 'NO' END,
        'Palma Adulta /Joven'=CASE WHEN year(LT.lotefechas)=1900 THEN 'na' WHEN year(LT.lotefechas)<=2023-10 THEN 'Adulta' ELSE 'Joven' END,
        TQ.TARA AS TARA, 
        TQ.PESOBRUTO AS PESO_BRUTO,
        TQ.TIQUEPACT AS CAPTURA,
        RTRIM(lb.labounid) as Unidad,
        SUBSTRING(convert(char,TQ.TIQUEFECHA,100),1,3) as MES,
        substring(tq.tiquecodcc,1,1)+'-'+cc1.NOMBRE as 'CC MAYOR', TQ.CANTIDAD2, LB.UNIDAD2
             From PALMERAS2013.Dbo.tiquete as TQ
         LEFT JOIN PALMERAS2013.Dbo.labores as LB on TQ.tiquelabor=LB.labocodi
         LEFT JOIN PALMERAS2013.Dbo.fincas as FC on TQ.tiquefinca=FC.fincacodi
         LEFT JOIN PALMERAS2013.Dbo.lotes as LT on TQ.tiquefinca=LT.fincacodi and TQ.tiquelote=LT.lotecodi 
         LEFT JOIN PALMERAS2013.Dbo.contrati as CT on TQ.tiquecontr=CT.contrcodi
         LEFT JOIN PALMERAS2013.Dbo.patronos as PT on TQ.tiquepatro=PT.patrocodi
         LEFT JOIN PALMERAS2013.Dbo.centcos as CC on TQ.tiquecodcc=CC.codcc
         LEFT JOIN PALMERAS2013.Dbo.RA_GRUPO_LABORES as GL on LB.codgrup=GL.codigo
         LEFT JOIN PALMERAS2013.Dbo.mtmercia as ME on TQ.prod_aplic=ME.codigo
         LEFT JOIN PALMERAS2013.Dbo.mtmaqui as MQ on TQ.tiqueplaca=MQ.placa
         LEFT JOIN PALMERAS2013.Dbo.CENTCOS as cc1 on substring(tq.tiquecodcc,1,1) = cc1.CODCC
        /* LEFT JOIN (
                    SELECT Tiquete, sum(CASE WHEN (convert(numeric,datediff(minute,HoraInicia,HoraFin))/60)>5 THEN (convert(NUMERIC,datediff(minute,HoraInicia,HoraFin))/60)-0.5 ELSE (convert(NUMERIC,datediff(minute,HoraInicia,HoraFin))/60) END) AS Horas, count(*) AS NumEmpleados 
                    FROM PALMERAS2013.Dbo.RA_NOVEDADES
                              WHERE fecha Between  '01/06/2023' And '30/06/2023'
                              GROUP BY Tiquete
                            ) AS ND ON ND.tiquete=TQ.idtiquete */
              WHERE TQ.tiquefecha Between  CONVERT(datetime,'$fechainical',120) 
			  And CONVERT(datetime,'$fechafinal',120)
			  and TQ.tiquelabor like  '%$nlabor%'
              and TQ.tiquefinca like '%51%'
              and (LB.labonomb like '%%')
              and LB.codgrup like '%%'
              and TQ.tiquepatro like '%%' 
             and TQ.tiquecontr like '%%' ORDER BY TIQUETE ASC;
");
        while ($Element = odbc_fetch_array($data)) {
            $arr[] = $Element;
        }
        return $arr;
    }
}
