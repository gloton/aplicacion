<?php
class fechas {

	function mifuncion3 () {
		echo '<script type="text/javascript">alert("jorge2");</script>' ;
	}
	
	/***RESTAR FECHAS***/
	function dateDiff2 ($d1, $d2) {
	
		// retorna el numero de dias entre 2 fechas
		return round(abs(strtotime($d1)-strtotime($d2))/86400);
	
	}  // end function dateDiff
	//echo dateDiff2("2006-04-05", "2006-04-01");	<<<< como usar la resta	

	//cambiar el formato de fecha
	//parametro con valor tipo string 04/25/2012 17:16:40 o 04/25/2012
	function format_date_aaaammdd($fecha_old) {
	
		$get_fecha = $fecha_old;
		$get_fecha = substr($get_fecha,0,10);//>>> retorna string mm/dd/aaaa
		$get_fecha = explode('/', $get_fecha);
		$dia = $get_fecha[1];
		$mes = $get_fecha[0];
		$anio = $get_fecha[2];
		$format_aaaammdd = $anio."-".$mes."-".$dia;
		return $format_aaaammdd;
	}
	
	function format_date_mm__aaaa($fecha_old) {
		$get_fecha = $fecha_old;
		$get_fecha = substr($get_fecha,0,7);//>>> retorna string mm/dd/aaaa
		$get_fecha = explode('-', $get_fecha);
		$mes = $get_fecha[1];
		$anio = $get_fecha[0];
		$format_mm__aaaa = $mes."/__/".$anio;
		return $format_mm__aaaa;
	}	

	function lstDiasEntre2Fechas ($fecha_inicial,$fecha_final) {
		$fechaInicio=strtotime($fecha_inicial);
		$fechaFin=strtotime($fecha_final);
		
		for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){
			$lstFechas[] = date("m/d/Y", $i);
		}
		return $lstFechas;
	}
	
	function getUltimoDiaMes($elAnio,$elMes) {
		return date("d",(mktime(0,0,0,$elMes+1,1,$elAnio)-1));
	}	
}
?>