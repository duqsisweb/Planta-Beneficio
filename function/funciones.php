<?php header('Content-Type: text/html; charset=UTF-8');

class funciones {

    public static function statechangepass($EMAILUSER) {
        include '../conexionbd.php'; 
        return odbc_exec($conexion, "SELECT estadopassword FROM DUQUESA..users where email = '$EMAILUSER'"); 
    }
    
    public static function obtenerInfoLaboral($EMAILUSER) {
        include '../conexionbd.php'; 
        return odbc_exec($conexion, "SELECT CONCAT(RTRIM(NOMBRE), ' ', RTRIM(NOMBRE2), ' ' , RTRIM(APELLIDO), ' ', RTRIM(APELLIDO2)) AS NOMBRECOMPLETO,
        CODIGO,CARGO,IIF(TIPCONTRA = 'INDEF', 'TERMINO INDEFINIDO', '') AS TIPOCONTRATO,CONVERT(VARCHAR,FECING,23) AS FECHAINGRESO, ROUND(VALORHORA * HORASMES,0) AS SUELDO, YEAR(FECING) AS ANO, MONTH(FECING) AS MES, DAY(FECING) AS DIA,
        YEAR(GETDATE()) AS ANOACTUAL, MONTH(GETDATE()) AS MESACTUAL, DAY(GETDATE()) AS DIAACTUAL
        FROM DUQUESA..MTEMPLEA WHERE FECRETIRO >= '2100-12-31' AND TIPCONTRA = 'INDEF' AND EMAIL = '$EMAILUSER'"); 
    }

    public static function certificadosNomiaMes($CODIGO) {
        include '../conexionbd.php'; 

        $data = odbc_exec($conexion, "SELECT RTRIM(MTL.NRODCTO) AS NRODCUTO, CONCAT(CONVERT(VARCHAR,MTL.FECINI,23) , ' / ' ,CONVERT(VARCHAR,MTL.FECFIN,23)) AS FECHA
		FROM DUQUESA..MTEMPLEA AS MTE
        INNER JOIN DUQUESA..MTLIQNOM AS MTL ON MTL.CODIGO = MTE.CODIGO
        WHERE MTL.TIPODCTO = 'LN' AND MTE.CODIGO = '$CODIGO' AND MTL.FECFIN BETWEEN GETDATE()-140 AND GETDATE()
		ORDER BY MTL.FECFIN ASC");
        while ($Element = odbc_fetch_array($data)) { $arr[] = $Element; }
        return $arr;
    
    }

    public static function infoNomina($NRODCTO) {
        include '../conexionbd.php'; 

        return odbc_exec($conexion, "SELECT MONTH(MTL.FECFIN) MES,CONCAT(RTRIM(MTE.APELLIDO), ' ', RTRIM(MTE.APELLIDO2), ' ' , RTRIM(MTE.NOMBRE2), ' ', RTRIM(MTE.NOMBRE)) AS NOMBRECOMPLETO,
        MTE.CODIGO,MTE.CODCARGO,MTE.DEPEND,MAX(BEMP.SALARIO) AS SUELDO ,MAX(CONVERT(INT,MTL.NRODCTO)) AS CODIGONOM,MTL.TIPODCTO,
        MTE.BANCO,MTL.DIASPAG,MAX(CONVERT(VARCHAR,MTL.FECINI,102)) AS FECHAIN, MAX(CONVERT(VARCHAR,MTL.FECFIN,102)) AS FECHAFIN, MAX(CONVERT(VARCHAR,MTL.FECFIN + 1,102)) AS FECHA
        FROM DUQUESA..MTEMPLEA AS MTE
        INNER JOIN DUQUESA..MTLIQNOM AS MTL ON MTL.CODIGO = MTE.CODIGO
		INNER JOIN DUQUESA..BaseEmpleadosIndicadorNomina AS BEMP ON BEMP.CODIGO = MTE.CODIGO AND BEMP.MES + 1 = MONTH(MTL.FECFIN)
        WHERE MTL.TIPODCTO = 'LN' AND MTL.NRODCTO = '$NRODCTO'
        GROUP BY MTE.NOMBRE, MTE.NOMBRE2, MTE.APELLIDO, MTE.APELLIDO2,MTE.CODIGO,MTE.CODCARGO,MTE.DEPEND,MTE.BANCO,MTL.DIASPAG,MTE.VALORHORA,
		MTL.TIPODCTO,MTE.HORASMES,MTL.FECFIN"); 
    }

    public static function datosNomina($CODNOMINA){
        include '../conexionbd.php';

        $data = odbc_exec($conexion, "SELECT MVL.CONCEP,MTC.DESCRIPCIO,MVL.NROHORAS,MVL.VALOR FROM DUQUESA..MVLIQNOM AS MVL
        INNER JOIN DUQUESA..MTCONCEP AS MTC ON MVL.CONCEP = MTC.CONCEP
        WHERE NRODCTO = '$CODNOMINA' AND TIPODCTO = 'LN'");
        while ($Element = odbc_fetch_array($data)) { $arr[] = $Element; }
        return $arr;
    }

    public static function vaciones($CODIGOUSER) {
        include '../conexionbd.php';
        return odbc_exec($conexion,"SELECT CONVERT(VARCHAR,FECING,23) AS FECHAIN,CONVERT(VARCHAR,GETDATE(),23) AS FECHACT, DIAS_DISFRUTADOS, DIAS_CORTE,DATEDIFF(DAY,FECING, GETDATE()) * 18 / 360 AS ACUMULADOS FROM DUQUESA..Esp_Fnv_Dias_Vacac(GETDATE(),18) WHERE CODIGO = '$CODIGOUSER'");
    }

    public static function buscarusuario(){
        include '../conexionbd.php';
        $datos = array();
        $i = 1;

        $data = odbc_exec($conexion, "SELECT CONCAT(RTRIM(CODIGO), ' -- ',RTRIM(NOMBRE), ' ', RTRIM(NOMBRE2), ' ' , RTRIM(APELLIDO), ' ', RTRIM(APELLIDO2)) AS NOMBRECOMPLETO
        FROM DUQUESA..MTEMPLEA WHERE FECRETIRO >= '2100-12-31' AND TIPCONTRA = 'INDEF' ORDER BY TIPCONTRA ASC");
        while ($row = odbc_fetch_array($data)) { $datos[] = mb_convert_encoding($row, "UTF-8", "iso-8859-1");$i++;} 
        
        $json = json_encode($datos);
        return $json;
    }

    public static function usuarioEspecifico($CODIGO){
        include '../conexionbd.php';

        $data = odbc_exec($conexion, "SELECT NOMBRE,CONCAT(RTRIM(NOMBRE), ' ', RTRIM(NOMBRE2), ' ' , RTRIM(APELLIDO), ' ', RTRIM(APELLIDO2)) AS NOMBRECOMPLETO,
        CODIGO,CARGO,TIPCONTRA,FECING,TELEFONO,EMAIL
        FROM DUQUESA..MTEMPLEA WHERE FECRETIRO >= '2100-12-31' AND TIPCONTRA = 'INDEF' AND CODIGO = '$CODIGO'");
        while ($row = odbc_fetch_array($data)) { $datos[] = mb_convert_encoding($row, "UTF-8", "iso-8859-1");$i++;} 
        
        $json = json_encode($datos);
        return $json;
    }

    public static function agregarArchivo ($nameFile,$TIPOFORMATO) {
        include '../conexionbd.php';
        odbc_exec($conexion,"INSERT INTO DUQUESA..FORMATOSEMP (NOMBREARCHIVO, TIPOFORMATO) VALUES ('$nameFile', $TIPOFORMATO)");
    }

    public static function mostrarFormatos () {
        include '../conexionbd.php';
        
        $data = odbc_exec($conexion, "SELECT * FROM DUQUESA..FORMATOSEMP");
        while ($Element = odbc_fetch_array($data)) { $arr[] = $Element; }
        return $arr;
    }

    public static function mostrarFormatosCategoria ($tipo) {
        include '../conexionbd.php';
        
        $data = odbc_exec($conexion, "SELECT * FROM DUQUESA..FORMATOSEMP WHERE TIPOFORMATO = $tipo");
        while ($Element = odbc_fetch_array($data)) { $arr[] = $Element; }
        return $arr;
    }
}

?>