<?php

class dashboardModel extends Model
{
    public function __construct() {
        parent::__construct();
    }
    //contar reclamos por cantidad de resoluciones FIN=finalizado por los ultimos 30 dias   
    public function getDiaCant($diasMes,$columna1,$columna2,$valor2)
    {
    	$sql = "SELECT $columna1, COUNT(FECHA_RECLAMO) AS CANTIDAD FROM 
    			vw_reclamos WHERE ($columna2 = '$valor2') AND ($columna1 BETWEEN '".current($diasMes)."' AND '".end($diasMes)."') 
    			GROUP BY $columna1";
    	$query = OCIParse(Database::con(), $sql);
    	OCIExecute($query, OCI_DEFAULT);
    	$cantidad = array();
    	//andamio
    	for ($i=30;$i>=1;$i--) {
    		$ultimos30dias = date("d/m/y", time()-$i*24*60*60);
    		$andamio[$ultimos30dias]=0;
    	}
    	//Hacemos el match (ordenar)
    	while (OCIFetch($query)){
    		$fecha = ociresult($query, "FECHA_RECLAMO");
    		$valor = ociresult($query, "CANTIDAD");
    		$andamio[$fecha]= $valor;
    	}
    	return $andamio;
    }
    
    //retornara un array con todos los reclamos en el cual el campo FECHA_SOLUCION este dentro 
    //de los ultimos 30 dias, y si hay cerrados en ese dia quedara con el valor 0
    //el array a retornar puede ser mayor a 30
    public function getReclDia($diasMes) {
    	/*
    	$sql = "SELECT FECHA_SOLUCION AS FS,TO_DATE(FECHA_SOLUCION, 'dd/mm/yy')-TO_DATE(FECHA_RECLAMO, 'dd/mm/yy') DIAS 
    			FROM vw_reclamos WHERE (FECHA_SOLUCION IS NOT NULL) AND (FECHA_SOLUCION BETWEEN '".current($diasMes)."' AND '".end($diasMes)."') 
    			ORDER BY FECHA_SOLUCION";
    	*/
    	$sql = "SELECT FECHA_SOLUCION AS FS,TO_DATE(FECHA_SOLUCION, 'dd/mm/yy')-TO_DATE(FECHA_RECLAMO, 'dd/mm/yy') DIAS 
    			FROM vw_reclamos WHERE (ESTADO_RECLAMO = 'FIN') AND (FECHA_SOLUCION IS NOT NULL) AND (FECHA_SOLUCION BETWEEN '".current($diasMes)."' AND '".end($diasMes)."') 
    			ORDER BY FECHA_SOLUCION";
    	$query = OCIParse(Database::con(), $sql);
    	OCIExecute($query, OCI_DEFAULT);
    	//Hacemos el match (ordenar)
    	while (OCIFetch($query)){
    		$reg["FS"][] = ociresult($query, "FS");
    		$reg["DIAS"][] = ociresult($query, "DIAS");    		
    	}  
    	$menosde30 = 0;
    	$menosde60 = 0;
    	$masde60 = 0;
    	$grupo1 = array();
    	$grupo2 = array();
    	$grupo3 = array();
		$restDia = 30;
		$i = 0;
		$hoy = date("d/m/y", time());
		$ayer = date("d/m/y", time()-1*24*60*60);
		$dia = date("d/m/y", time()-$restDia*24*60*60);
		$contador = 1;
		while ($hoy != $dia) {
			$dia = date("d/m/y", time()-$restDia*24*60*60);
			//echo '<script type="text/javascript">alert("Contador = '.$contador++.'");</script>' ;
			//echo '<script type="text/javascript">alert("dia = '.$dia.'");</script>' ;
			if (!in_array($dia, $reg["FS"], true)) {
				//echo '<script type="text/javascript">alert("1-Guardar en 0 '.$contador++.'");</script>' ;
    			$grupo1[] = 0;
    			$grupo2[] = 0;
    			$grupo3[] = 0;
    			$menosde30 = 0;
    			$menosde60 = 0;
    			$masde60 = 0;
    			$restDia--; //-->avanzar un dia en $dia
			} elseif ($dia == $reg["FS"][$i]) {
				//echo '<script type="text/javascript">alert("i  = '.$i.'");</script>' ;
				if ($reg["DIAS"][$i] <= 2) {
					$menosde30++;
				} elseif ($reg["DIAS"][$i] <= 5) {
					$menosde60++;
				} elseif ($reg["DIAS"][$i] > 5) {
					$masde60++;
				}
				if (!isset($reg["FS"][$i+1])) {
					//echo '<script type="text/javascript">alert("No existe");</script>' ;
					$grupo1[] = $menosde30;
					$grupo2[] = $menosde60;
					$grupo3[] = $masde60;	
					$desde_grupo = count($grupo1);
					for ($j = $desde_grupo; $j < 30; $j++) {
						$grupo1[] = 0;
						$grupo2[] = 0;
						$grupo3[] = 0;
					}				
	    			//$restDia--;
	    			$dia = $hoy;
	    			//$i--; 
				} else {
					//echo '<script type="text/javascript">alert("Si existe");</script>' ;
				    if ($reg["FS"][$i] != $reg["FS"][$i+1]) {
				    	//echo '<script type="text/javascript">alert("Guardar DISTINTO DE CERO '.$contador++.'");</script>' ;
		    			$grupo1[] = $menosde30;
		    			$grupo2[] = $menosde60;
		    			$grupo3[] = $masde60;
		    			$menosde30 = 0;
		    			$menosde60 = 0;
		    			$masde60 = 0;	    			
		    			$restDia--;
    				}
				}
				$i++;
			} else {
				$i++;
			}
		} //fin while
		
		/*
		while ($hoy != $dia) {
		    $dia = date("d/m/y", time()-$restDia*24*60*60);
		    echo '<script type="text/javascript">alert("PROCESAR Dia '.$dia.'");</script>' ;
		    echo '<script type="text/javascript">alert("PROCESAR Dia '.$reg["FECHA_SOLUCION"][$i].'");</script>' ;
		    
    		if ($dia == $reg["FS"][$i]) {
    			if ($reg["DIAS"][$i] <= 30) {
    				$menosde30++;
    			} elseif ($reg["DIAS"][$i] <= 60) {
    				$menosde60++;
    			} elseif ($reg["DIAS"][$i] > 60) {
    				$masde60++;
    			}
    			if ($reg["FS"][$i] != @$reg["FS"][$i+1] OR end($diasMes)== $reg["FS"][$i+1]) {
	    			$grupo1[] = $menosde30;
	    			$grupo2[] = $menosde60;
	    			$grupo3[] = $masde60;
	    			$menosde30 = 0;
	    			$menosde60 = 0;
	    			$masde60 = 0;	    			
	    			$restDia--;
    			}
    		} elseif (!in_array($dia, $reg["FS"], true)) {
    			$grupo1[] = 0;
    			$grupo2[] = 0;
    			$grupo3[] = 0;
    			$menosde30 = 0;
    			$menosde60 = 0;
    			$masde60 = 0;
    			$restDia--;
    			$i--;
    		}
    		$i++;
		}
		*/		
		$grupos = array($grupo1,$grupo2,$grupo3);
    	return $grupos;
    }
    
    //SEMESTRE
    //obtener la cantidad de reclamos por cantidad de resoluciones FIN=finalizado
    public function getMesCant($mesAnio,$col1,$val1)
    {
        $sql = "SELECT to_char(FECHA_RECLAMO, 'MM/yy' ) AS FR, 
        		COUNT(FECHA_RECLAMO) AS CANTIDAD 
        		FROM vw_reclamos 
        		WHERE  $col1 ='$val1' AND FECHA_RECLAMO > TO_DATE('$mesAnio[0]','MM/YY') 
        		GROUP BY to_char(FECHA_RECLAMO, 'MM/yy' ) 
        		ORDER BY to_char(FECHA_RECLAMO, 'MM/yy' )";
        $query = OCIParse(Database::con(), $sql);
    	OCIExecute($query, OCI_DEFAULT);
    	$cantidad = array();
    	while (OCIFetch($query)){
    		$reg["FR"][] = ociresult($query, "FR");
    		$reg["CANTIDAD"][] = ociresult($query, "CANTIDAD");
    	}
    	for ($i = 0; $i < count($mesAnio); $i++) {
    		if (!in_array($mesAnio[$i], $reg["FR" ], true)) {
    			$cantMeses["FR"][$i] = 0;
    			$cantMeses["CANTIDAD"][$i] = 0;
    		} else {
    			while ($mesactual = current($reg["FR"])) {
    				if ($mesactual == $mesAnio[$i]) {
    					$indice = key($reg["FR"]);
    				}
    				next($reg["FR"]);
    			}
    			reset($reg["FR"]);
    			$cantMeses["FR"][$i] = $reg["FR"][$indice];
    			$cantMeses["CANTIDAD"][$i] = $reg["CANTIDAD"][$indice];
    		}
    		
    	}
    	//retorna los 6 valores ordenados
    	return $cantMeses['CANTIDAD'];
    	
    }//fin funcion
    
    //obtendra los reclamos solucionados(SOL Y FIN) hoy
    public function getReclMes($fechas_agrupadas,$cantDiasXmes) {
    	//$sql=("select fecha_reclamo, fecha_solucion from tickets where fecha_solucion like '".$fecha_dinamica."%';");
    	$sql = "SELECT FECHA_SOLUCION AS FS,TO_DATE(FECHA_SOLUCION, 'dd/mm/yy')-TO_DATE(FECHA_RECLAMO, 'dd/mm/yy') DIAS 
    			FROM vw_reclamos 
    			WHERE FECHA_SOLUCION > TO_DATE('".current($fechas_agrupadas)."','DD-MM-YYYY') 
    			ORDER BY FECHA_SOLUCION";

    	$query = OCIParse(Database::con(), $sql);
    	OCIExecute($query, OCI_DEFAULT);
    	
    	while (OCIFetch($query)){
    		$reg["FS"][] = ociresult($query, "FS");
    		$reg["DIAS"][] = ociresult($query, "DIAS");
    	}
    	
    	#$tiempoRespuesta
    	# creara UN SOLO array con los dias consecutivos, desde el primer
    	# dia de hace 6 meses, hasta que termine el sexto mes
    	for ($i = 0; $i < count($fechas_agrupadas); $i++) {
    		if (!in_array ($fechas_agrupadas[$i], $reg["FS"], true)) {
    			//echo "La fecha ".$fechas_agrupadas[$i]." NO esta en el array <br>";
    			$tiempoRespuesta["FS"][$i] = 0;
    			$tiempoRespuesta["DIAS"][$i] = 0;
    		} else {
    			/*
    			echo "La fecha ".$fechas_agrupadas[$i]." SI esta en el array <br>";
    			$tiempoRespuesta["FS"][$i] = 0;
    			$tiempoRespuesta["DIAS"][$i] = 0;    
    			*/
    			while ($diaactual = current($reg["FS"])) {
    				if ($diaactual == $fechas_agrupadas[$i]) {
    					$indice = key($reg["FS"]);
    				}
    				next($reg["FS"]);
    			}    
    			reset($reg["FS"]);
    			$tiempoRespuesta["FS"][$i] = $reg["FS"][$indice];
    			$tiempoRespuesta["DIAS"][$i] = $reg["DIAS"][$indice];			
    					
    		}
    	} //fin

    	#$mesesFS cuando no hay ningun registro el valor es 0, cuando en esa fecha aparece un valor es distinto a 0
    	# por ejemplo echo $mesesFS[0][3]; imprime 09/03/13, siendo el $mesesFS[0], el primer mes
    	//divide el array $tiempoRespuesta tiempo de respuesta en 6 meses
    	$desde = 0;
    	for ($i = 0; $i < count($cantDiasXmes); $i++) {
    		$hasta = $cantDiasXmes[$i];
    		$mesesFS[$i] = array_slice($tiempoRespuesta["FS"],$desde, $hasta);
    		$mesesDIAS[$i] = array_slice($tiempoRespuesta["DIAS"],$desde, $hasta);
    		$mesesFSfechas[$i] = array_slice($fechas_agrupadas,$desde, $hasta);
    		$desde += $cantDiasXmes[$i];
    	}
    	
    	for ($i = 0; $i < count($cantDiasXmes); $i++) {
    		$tiempoRespCant[] = $this->calcularDiasTiemResp($mesesFSfechas[$i],$reg);
    	}
    	for ($i = 0; $i < count($cantDiasXmes); $i++) {
    		for ($j = 0; $j < 3; $j++) {
    			switch ($j) {
    				case 0:
    					$totMenos30[] = $tiempoRespCant[$i][$j];
    					break;
    				case 1:
    					$totMenos60[] = $tiempoRespCant[$i][$j];
    					break;
    				case 2:
    					$totMas60[] = $tiempoRespCant[$i][$j];
    					break;

    			}
    		}
    	}
    	$totalesTiempoRespuesta = array($totMenos30,$totMenos60,$totMas60);
    	return $totalesTiempoRespuesta;
    }//fin funcion
    
    public function getTabla() {
    	$sql = "SELECT * FROM vw_reclamos";
    	$query = OCIParse(Database::con(), $sql);
    	OCIExecute($query, OCI_DEFAULT);
    		    	 
    	while (OCIFetch($query)){
    		$reg["ID_RECLAMO"][] = ociresult($query, "ID_RECLAMO");
    		$reg["NOMBRE_RECLAMANTE"][] = ociresult($query, "NOMBRE_RECLAMANTE");
    		$reg["FECHA_RECLAMO"][] = ociresult($query, "FECHA_RECLAMO");
    		$reg["FECHA_SOLUCION"][] = ociresult($query, "FECHA_SOLUCION");
    		$reg["ESTADO_RECLAMO"][] = ociresult($query, "ESTADO_RECLAMO");
    		$reg["DIAS_TRANSCURRIDO"][] = ociresult($query, "DIAS_TRANSCURRIDO");
    		$reg["FERIADOS"][] = ociresult($query, "FERIADOS");
    		$reg["TIPO"][] = ociresult($query, "TIPO");
    		$reg["SUB_CLASIF"][] = ociresult($query, "SUB_CLASIF");
    	}    	
    	return $reg;
    }
    
    public function getDetalle($id) {
    	$reg = array();
    	//$sql= "select * FROM system.tickets where ID_RECLAMO ='".$id."'";
    	$sql= "select ID_RECLAMO, MOTIVO_DETALLE FROM vw_reclamos where ID_RECLAMO =$id";
    	$query = OCIParse(Database::con(), $sql);
    	OCIExecute($query, OCI_DEFAULT);
    	
    	while (OCIFetch($query)){
    		$reg["MOTIVO_DETALLE"] = ociresult($query, "MOTIVO_DETALLE");
    		$reg["ID_RECLAMO"] = ociresult($query, "ID_RECLAMO");
    	}
    	return $reg;
    }       

    public function calcularDiasTiemResp($mesesFSfechas,$reg) {

    	/**PROBAR PARA VER SI FUNCIONA**/
    	$menosde30 = 0;
    	$menosde60 = 0;
    	$masde60 = 0;
    	$grupo1 = array();
    	$grupo2 = array();
    	$grupo3 = array();
    	//$restDia = 30;
    	$i = 0;
    	$imes = 0;
    	//$ayer = date("d/m/y", time()-1*24*60*60);
    	$dia = current($mesesFSfechas);
    	$ayer = end($mesesFSfechas);
    	//ahora--> $ayer es el dia hasta el cual tiene que llegar
    	//ahora--> $dia es el dia que esta procesando
    	while ($ayer != $dia) {
    		$dia = $mesesFSfechas[$imes];
    		//echo '<script type="text/javascript">alert("Esta fecha '.$dia.' Guardados : '.count($grupo1).'");</script>' ;
    		if ($dia == @$reg["FS"][$i]) {
    			//echo '<script type="text/javascript">alert("Sumar");</script>';
    			if ($reg["DIAS"][$i] <= 30) {
    				$menosde30++;
    			} elseif ($reg["DIAS"][$i] <= 60) {
    				$menosde60++;
    			} elseif ($reg["DIAS"][$i] > 60) {
    				$masde60++;
    			}
    			//echo '<script type="text/javascript">alert("Imprime variable i+1 '.$reg["FS"][$i+1].'");</script>';
    			 
    			if ($reg["FS"][$i] != @$reg["FS"][$i+1] OR end($mesesFSfechas)== $reg["FS"][$i+1]) {
    				//echo '<script type="text/javascript">alert("GuardarB");</script>' ;
    				$grupo1[] = $menosde30;
    				$grupo2[] = $menosde60;
    				$grupo3[] = $masde60;
    				$menosde30 = 0;
    				$menosde60 = 0;
    				$masde60 = 0;
    				$imes++;
    			}
    	
    		} elseif (!in_array($dia, $reg["FS"], true)) {
    			//echo '<script type="text/javascript">alert("No esta: GuardarC");</script>' ;
    			$grupo1[] = 0;
    			$grupo2[] = 0;
    			$grupo3[] = 0;
    			$menosde30 = 0;
    			$menosde60 = 0;
    			$masde60 = 0;
    			$imes++;
    			$i--;
    		}
    		$i++;
    	}
    	$grupos = array(array_sum($grupo1),array_sum($grupo2),array_sum($grupo3));
    	return $grupos;
    	/**PROBAR PARA VER SI FUNCIONA**/    	
    }
    
    function getLabel($demora) {
    	$sql = "SELECT count(FECHA_RECLAMO) AS CANT FROM vw_reclamos WHERE (ESTADO_RECLAMO='ENV' AND (TRUNC(SYSDATE - FECHA_RECLAMO)) ".$demora.")";
    	$query = OCIParse(Database::con(), $sql);
    	OCIExecute($query, OCI_DEFAULT);
    	while (OCIFetch($query)){
    		$cantidad = ociresult($query, "CANT");
    	}
    	return $cantidad;    	
    }
}

?>
 