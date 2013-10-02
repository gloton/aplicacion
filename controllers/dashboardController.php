<?php
class dashboardController extends Controller
{
	private $_dashboard;
	private $_helper;
	static $_labelMenos30;
	

    public function __construct() {
        parent::__construct();
        $this->_dashboard = $this->loadModel('dashboard');
        
        //cargar helper
        $this->__helper = $this->loadHelper('fechas');
    }
    public function index()
    {
    	//->empieza imprimiendo 07/28/2013 hasta 08/26/2013
    	$diasMes = array();
    	
    	$entre0y30 = 0;
    	$entre30y60 = 0;
    	$masde60 = 0;
		/* DIAS DE LA SEMANA L-D INICIO*/
    	//recorrer mes
    	for ($i=30;$i>=1;$i--) {

    		$diasMes[] = date("d/m/Y", time()-$i*24*60*60);
    		//$fecha_recl_mmddaaaa = $this->_dashboard->getReclDia($fecha_mmddaaaa);

    		//Pasar dia de la semana ingles, a la primer letra en español
    		$get_dia = date("l", time()-$i*24*60*60);
    		switch ($get_dia){
    			case "Monday":
    				$dia = "'L<br>".date("d/m/Y", time()-$i*24*60*60)."'";
    				break;
    			case "Tuesday":
    				$dia = "'M<br>".date("d/m/Y", time()-$i*24*60*60)."'";
    				break;
    			case "Wednesday":
    				$dia = "'M<br>".date("d/m/Y", time()-$i*24*60*60)."'";
    				break;
    			case "Thursday":
    				$dia = "'J<br>".date("d/m/Y", time()-$i*24*60*60)."'";
    				break;
    			case "Friday":
    				$dia = "'V<br>".date("d/m/Y", time()-$i*24*60*60)."'";
    				break;
    			case "Saturday":
    				$dia = "'S<br>".date("d/m/Y", time()-$i*24*60*60)."'";
    				break;
    			case "Sunday":
    				$dia = "'D<br>".date("d/m/Y", time()-$i*24*60*60)."'";
    				break;
    		}
    		//crea un array con los ultimos 7 dias, nombrandolo con la primer letra de la semana
    		$dias_semana[] = $dia;
    	}//fin for
    	/* DIAS DE LA SEMANA L-D FIN*/

		/* TABLA TIEMPO DE RESPUESTA INICIO*/
    	$fecha_recl_mmddaaaa = $this->_dashboard->getReclDia($diasMes);
 	
    	$menosde30 = $fecha_recl_mmddaaaa[0];
    	$menosde60 = $fecha_recl_mmddaaaa[1];
    	$masde60 = $fecha_recl_mmddaaaa[2];
    	$grupo1_ordenados = implode(',',$menosde30);
    	$grupo2_ordenados = implode(',',$menosde60);
    	$grupo3_ordenados = implode(',',$masde60);
		/* TABLA TIEMPO DE RESPUESTA FIN*/
		/* LABELS DEL INDEX INICIO*/		
		//rellenar los label
    	$this->_view->label_entre0y2 = $this->_dashboard->getLabel("<= 2");
    	$this->_view->label_entre3y5 = $this->_dashboard->getLabel("> 2 AND (TRUNC(SYSDATE - FECHA_RECLAMO)) <= 5");
    	$this->_view->label_mayora5 = $this->_dashboard->getLabel(" > 5");

		/* LABELS DEL INDEX FIN*/		
		
    	/* DIAS DE LA SEMANA L-D INICIO*/
    	//variable obtendra los dias de la semana, en formato L,M,M,J,V,S,D pero para los ultimos 30 dias
    	$dias_semana_ordenados = implode(',',$dias_semana);	
    	/* DIAS DE LA SEMANA L-D FIN*/
    	/* TABLA CANTIDAD DE RESOLUCIONES INICIO*/
    	$cantEstEnv = $this->_dashboard->getDiaCant($diasMes,'FECHA_RECLAMO','ESTADO_RECLAMO','ENV');
    	$cantEstEnv_ordenados = implode(',',$cantEstEnv);
    	$cantEstFin = $this->_dashboard->getDiaCant($diasMes,'FECHA_RECLAMO','ESTADO_RECLAMO','FIN');
    	$cantEstFin_ordenados = implode(',',$cantEstFin);
    	$cantEstSol = $this->_dashboard->getDiaCant($diasMes,'FECHA_RECLAMO','ESTADO_RECLAMO','SOL');
    	$cantEstSol_ordenados = implode(',',$cantEstSol);
    	/* TABLA CANTIDAD DE RESOLUCIONES FIN*/
    	/* TABLA MOTIVO TIPO INICIO*/
    	$cantMotivoErr = $this->_dashboard->getDiaCant($diasMes,'FECHA_RECLAMO','TIPO','ERROR');
    	$cantMotivoErr_ordenados = implode(',',$cantMotivoErr);
    	$cantMotivoAse = $this->_dashboard->getDiaCant($diasMes,'FECHA_RECLAMO','TIPO','ASESORIA');
    	$cantMotivoAse_ordenados = implode(',',$cantMotivoAse);
    	/* TABLA MOTIVO TIPO FIN*/
    	/* TABLA SUBCLASIFICACION INICIO*/
    	$cantReclRCE = $this->_dashboard->getDiaCant($diasMes,'FECHA_RECLAMO','SUB_CLASIF','RCE');
    	$cantReclRCE_ordenados = implode(',',$cantReclRCE);
    	$cantReclMS = $this->_dashboard->getDiaCant($diasMes,'FECHA_RECLAMO','SUB_CLASIF','MEDISYN-ESTANDAR');
    	$cantReclMS_ordenados = implode(',',$cantReclMS);
    	/* TABLA SUBCLASIFICACION INICIO*/
    	
    	//rellenara los datos de los cuales se alimenta el grafico
    	$ruta_diajs = ROOT . "views".DS."dashboard".DS."js".DS."graficos".DS."dia.js";
    	$guiDia = file_get_contents($ruta_diajs);
    	$patronesDia[0] = '{{DIASDELASEMANA}}';
    	$patronesDia[1] = '{{ESTENVDIA}}';
    	$patronesDia[2] = '{{ESTFINDIA}}';
    	$patronesDia[3] = '{{ESTSOLDIA}}';
    	$patronesDia[4] = '{{MOTIVOERRDIA}}';
    	$patronesDia[5] = '{{MOTIVOASEDIA}}';
    	$patronesDia[6] = '{{CANTRECLRCEDIA}}';
    	$patronesDia[7] = '{{CANTRECLMSDIA}}';
    	$patronesDia[8] = '{{GRUPO1DIA}}';
    	$patronesDia[9] = '{{GRUPO2DIA}}';
    	$patronesDia[10] = '{{GRUPO3DIA}}';
    	$sustitucionesDia[0] = $dias_semana_ordenados;
    	$sustitucionesDia[1] = $cantEstEnv_ordenados;
    	$sustitucionesDia[2] = $cantEstFin_ordenados;
    	$sustitucionesDia[3] = $cantEstSol_ordenados;
    	$sustitucionesDia[4] = $cantMotivoErr_ordenados;
    	$sustitucionesDia[5] = $cantMotivoAse_ordenados;    	
    	$sustitucionesDia[6] = $cantReclRCE_ordenados;
    	$sustitucionesDia[7] = $cantReclMS_ordenados;
    	$sustitucionesDia[8] = $grupo1_ordenados;
    	$sustitucionesDia[9] = $grupo2_ordenados;
    	$sustitucionesDia[10] = $grupo3_ordenados;
    	    	
    	$htmlDia = str_replace($patronesDia,$sustitucionesDia, $guiDia);
    	$this->_view->cod_diajs = $htmlDia;
    	$this->_view->renderizar('index', 'dashboard');
    }
    
    function semestre () {
		/*(TEMPORAL) LABELS DEL INDEX INICIO*/	
    	for ($i=30;$i>=1;$i--) {
    		$diasMes[] = date("d/m/Y", time()-$i*24*60*60);
    		//$fecha_recl_mmddaaaa = $this->_dashboard->getReclDia($fecha_mmddaaaa);
    	
    	}
    	$fecha_recl_mmddaaaa = $this->_dashboard->getReclDia($diasMes);
    	$menosde30 = $fecha_recl_mmddaaaa[0];
    	$menosde60 = $fecha_recl_mmddaaaa[1];
    	$masde60 = $fecha_recl_mmddaaaa[2];
    	
		/* LABELS DEL INDEX INICIO*/		
		//rellenar los label
    	$this->_view->label_entre0y2 = $this->_dashboard->getLabel("<= 2");
    	$this->_view->label_entre3y5 = $this->_dashboard->getLabel("<= 5");
    	$this->_view->label_mayora5 = $this->_dashboard->getLabel(" > 5");

		/* LABELS DEL INDEX FIN*/		
		
    	    	
    	//echo "hola semestre";
    	//6 ultimos meses
    	for ($i=6;$i>=1;$i--) {
    		/* MESES DEL SEMESTRE INICIO*/	
    		//Pasar dia de la semana ingles, a la primer letra en español
    		$get_mes = substr(date ( 'Y-m' , strtotime ( '-'.$i.' month' , strtotime ( date('Y-m') ) ) ), 5,2);
    		$get_anio = substr(date ( 'Y' , strtotime ( '-'.$i.' month' , strtotime ( date('Y-m') ) ) ), 0,2);;
    		switch ($get_mes){
    			case "01":
    				$mes = "'Enero'";
    				$get_mesanio = substr(date ( 'm/y' , strtotime ( '-'.$i.' month' , strtotime ( date('m/y') ) ) ), 0,5);
    				$cantDiasMes = $this->__helper->getUltimoDiaMes($get_anio,'01');
    				break;
    			case "02":
    				$mes = "'Febrero'";
    				$get_mesanio = substr(date ( 'm/y' , strtotime ( '-'.$i.' month' , strtotime ( date('m/y') ) ) ), 0,5);
    				$cantDiasMes = $this->__helper->getUltimoDiaMes($get_anio,'02');
    				break;
    			case "03":
    				$mes = "'Marzo'";
    				$get_mesanio = substr(date ( 'm/y' , strtotime ( '-'.$i.' month' , strtotime ( date('m/y') ) ) ), 0,5);
    				$cantDiasMes = $this->__helper->getUltimoDiaMes($get_anio,'03');
    				break;
    			case "04":
    				$mes = "'Abril'";
    				$get_mesanio = substr(date ( 'm/y' , strtotime ( '-'.$i.' month' , strtotime ( date('m/y') ) ) ), 0,5);
    				$cantDiasMes = $this->__helper->getUltimoDiaMes($get_anio,'04');
    				break;
    			case "05":
    				$mes = "'Mayo'";
    				$get_mesanio = substr(date ( 'm/y' , strtotime ( '-'.$i.' month' , strtotime ( date('m/y') ) ) ), 0,5);
    				$cantDiasMes = $this->__helper->getUltimoDiaMes($get_anio,'05');
    				break;
    			case "06":
    				$mes = "'Junio'";
    				$get_mesanio = substr(date ( 'm/y' , strtotime ( '-'.$i.' month' , strtotime ( date('m/y') ) ) ), 0,5);
    				$cantDiasMes = $this->__helper->getUltimoDiaMes($get_anio,'06');
    				break;
    			case "07":
    				$mes = "'Julio'";
    				$get_mesanio = substr(date ( 'm/y' , strtotime ( '-'.$i.' month' , strtotime ( date('m/y') ) ) ), 0,5);
    				$cantDiasMes = $this->__helper->getUltimoDiaMes($get_anio,'07');
    				break;
    			case "08":
    				$mes = "'Agosto'";
    				$get_mesanio = substr(date ( 'm/y' , strtotime ( '-'.$i.' month' , strtotime ( date('m/y') ) ) ), 0,5);
    				$cantDiasMes = $this->__helper->getUltimoDiaMes($get_anio,'08');
    				break;
    			case "09":
    				$mes = "'Septiembre'";
    				$get_mesanio = substr(date ( 'm/y' , strtotime ( '-'.$i.' month' , strtotime ( date('m/y') ) ) ), 0,5);
    				$cantDiasMes = $this->__helper->getUltimoDiaMes($get_anio,'09');
    				break;
    			case "10":
    				$mes = "'Octubre'";
    				$get_mesanio = substr(date ( 'm/y' , strtotime ( '-'.$i.' month' , strtotime ( date('m/y') ) ) ), 0,5);
    				$cantDiasMes = $this->__helper->getUltimoDiaMes($get_anio,'10');
    				break;
    			case "11":
    				$mes = "'Noviembre'";
    				$get_mesanio = substr(date ( 'm/y' , strtotime ( '-'.$i.' month' , strtotime ( date('m/y') ) ) ), 0,5);
    				$cantDiasMes = $this->__helper->getUltimoDiaMes($get_anio,'11');
    				break;
    			case "12":
    				$mes = "'Diciembre'";
    				$get_mesanio = substr(date ( 'm/y' , strtotime ( '-'.$i.' month' , strtotime ( date('m/y') ) ) ), 0,5);
    				$cantDiasMes = $this->__helper->getUltimoDiaMes($get_anio,'12');
    				break;
    		}
    		//crea un array con los ultimos 7 dias, nombrandolo con la primer letra de la semana
    		$mes_semestre[] = $mes;
    		//contiene los ultimos 6 meses, del tipo mm/aa
    		$mes_semestre_mesanio[] = $get_mesanio;
    		//contiene la cantidad de dias de cada mies (de los ultimos 6 meses completos)
    		$cantDiasXmes[] = $cantDiasMes;

    		$mes_semestre_ordenados = implode(',',$mes_semestre);
    		/* MESES DEL SEMESTRE FIN*/	
    		
    		//$fecha_aaaamm = date ( 'Y-m' , strtotime ( '-'.$i.' month' , strtotime ( date('Y-m') ) ) );
    		
    		//obtener: el primer dia de hace 6 meses
    		if (!isset($first6month)) {
    			//$first6month = date ( 'd-m-Y' , strtotime ( '-'.$i.' month' , strtotime ( date('Y-m') ) ) );
    		}
    		//obtener el segundo mes. Lo ocupare para calcular el tiempo de respuesta
    		if (!isset($hace6meses)) {
    			//$hace6meses = date ( 'm/d/Y' , strtotime ( '-'.$i.' month' , strtotime ( date('Y-m') ) ) );
    		}
    		//$fecha_mm__aaaa[] = $this->__helper->format_date_mm__aaaa($fecha_aaaamm);   		
    		
    	}//fin for
 	
    	//$fecha_desde el primer dia de hace 6 meses
    	$fecha_desde = date ( 'Y/m/d' , strtotime ( '-6 month' , strtotime ( date('Y-m') ) ) );
    	$esteAnio = date ( 'Y' , strtotime ( '-1 month' , strtotime ( date('Y-m') ) ) );
    	$mesPasado = date ( 'm' , strtotime ( '-1 month' , strtotime ( date('Y-m') ) ) );
    	$diasDelMes = $this->__helper->getUltimoDiaMes($esteAnio,$mesPasado);
    	//$fecha_desde el primer dia de hace 6 meses
    	$fecha_desde = date ( 'Y/m/d' , strtotime ( '-6 month' , strtotime ( date('Y-m') ) ) );
    	//$fecha_hasta ayer
    	$fecha_hasta = $esteAnio.'/'.$mesPasado.'/'.$diasDelMes;
    	$dias_transcurridos = $this->__helper->dateDiff2($fecha_hasta,$fecha_desde);
    	for ($i = 0; $i <= $dias_transcurridos; $i++) {
    		$nuevafecha = strtotime ( '+'.$i.' day' , strtotime ( $fecha_desde ) ) ;
    		$nuevafecha = date ( 'd/m/y' , $nuevafecha );
    		$fechas_agrupadas[] = $nuevafecha;
    	}
    	//obtiene los reclamos solucionados los ultimos 6 meses, inclusive si no se cerro ningun reclamo
    	//en tal caso ese dia devolvera 0
    	
    	/*TABLA TIEMPO DE RESPUESTA INICIO*/

    	$fecha_recl_mmddaaaa_mes = $this->_dashboard->getReclMes($fechas_agrupadas,$cantDiasXmes);
    	$menosDe30_ordenados = implode(',',$fecha_recl_mmddaaaa_mes[0]);
    	$menosDe60_ordenados = implode(',',$fecha_recl_mmddaaaa_mes[1]);
    	$masDe60_ordenados = implode(',',$fecha_recl_mmddaaaa_mes[2]);

    	/*TABLA TIEMPO DE RESPUESTA FIN*/

    	//tabla cantidad de resoluciones
    	//$cantEstFin = $this->_dashboard->getMesCant($fecha_mm__aaaa,'ESTADO_RECLAMO','FIN');
    	$cantEstFin = $this->_dashboard->getMesCant($mes_semestre_mesanio,'ESTADO_RECLAMO','FIN');
    	$cantEstFin_ordenados = implode(',',$cantEstFin);
    	$cantEstSol = $this->_dashboard->getMesCant($mes_semestre_mesanio,'ESTADO_RECLAMO','SOL');
    	$cantEstSol_ordenados = implode(',',$cantEstSol);

    	//tabla motivo tipo
    	$cantEstErr = $this->_dashboard->getMesCant($mes_semestre_mesanio,'TIPO','ERROR');
    	$cantEstErr_ordenados = implode(',',$cantEstErr);
    	$cantEstAse = $this->_dashboard->getMesCant($mes_semestre_mesanio,'TIPO','ASESORIA');
    	$cantEstAse_ordenados = implode(',',$cantEstAse);

    	//tabla sub-clasificacion
    	$cantEstRce = $this->_dashboard->getMesCant($mes_semestre_mesanio,'SUB_CLASIF','RCE');
    	$cantEstRce_ordenados = implode(',',$cantEstRce);
    	$cantEstMed = $this->_dashboard->getMesCant($mes_semestre_mesanio,'SUB_CLASIF','MEDISYN-ESTANDAR');
    	$cantEstMed_ordenados = implode(',',$cantEstMed);
    	
    	$ruta_mesSemjs = ROOT . "views".DS."dashboard".DS."js".DS."graficos".DS."mes.js";
    	$guiMesSem = file_get_contents($ruta_mesSemjs);
    	$patronesMesSem[0] = '{{MESESSEMESTRE}}';    	
    	$patronesMesSem[1] = '{{CANTRECLFINSEMESTRE}}';
    	$patronesMesSem[2] = '{{CANTRECLSOLSEMESTRE}}';    	
    	$patronesMesSem[3] = '{{CANTRECLERRSEMESTRE}}';
    	$patronesMesSem[4] = '{{CANTRECLASESEMESTRE}}';    	
    	$patronesMesSem[5] = '{{CANTRECLRCESEMESTRE}}';
    	$patronesMesSem[6] = '{{CANTRECLMSSEMESTRE}}';
    	$patronesMesSem[7] = '{{CANTENTRE0Y30SEME}}';
    	$patronesMesSem[8] = '{{CANTENTRE30Y60SEME}}';
    	$patronesMesSem[9] = '{{CANTMASDE60SEME}}';
    	$sustitucionesMesSem[0] = $mes_semestre_ordenados;
    	$sustitucionesMesSem[1] = $cantEstFin_ordenados;
    	$sustitucionesMesSem[2] = $cantEstSol_ordenados;    	
    	$sustitucionesMesSem[3] = $cantEstErr_ordenados;
    	$sustitucionesMesSem[4] = $cantEstAse_ordenados;    	
    	$sustitucionesMesSem[5] = $cantEstRce_ordenados;
    	$sustitucionesMesSem[6] = $cantEstMed_ordenados;
    	$sustitucionesMesSem[7] = $menosDe30_ordenados;
    	$sustitucionesMesSem[8] = $menosDe60_ordenados;
    	$sustitucionesMesSem[9] = $masDe60_ordenados;
    	
    	$htmlMesSem = str_replace($patronesMesSem,$sustitucionesMesSem, $guiMesSem);

    	$this->_view->cod_mesSemjs = $htmlMesSem;
    	$this->_view->renderizar('semestre', 'semestre');
    }
    
    function anual () {
    	/*(TEMPORAL) LABELS DEL INDEX INICIO*/
    	for ($i=30;$i>=1;$i--) {
    		$diasMes[] = date("d/m/Y", time()-$i*24*60*60);
    		//$fecha_recl_mmddaaaa = $this->_dashboard->getReclDia($fecha_mmddaaaa);
    		 
    	}
    	$fecha_recl_mmddaaaa = $this->_dashboard->getReclDia($diasMes);
    	$menosde30 = $fecha_recl_mmddaaaa[0];
    	$menosde60 = $fecha_recl_mmddaaaa[1];
    	$masde60 = $fecha_recl_mmddaaaa[2];
    	 
		/* LABELS DEL INDEX INICIO*/		
		//rellenar los label
    	$this->_view->label_entre0y2 = $this->_dashboard->getLabel("<= 2");
    	$this->_view->label_entre3y5 = $this->_dashboard->getLabel("<= 5");
    	$this->_view->label_mayora5 = $this->_dashboard->getLabel(" > 5");

		/* LABELS DEL INDEX FIN*/		
		
    	/*COLOCAR MESES INICIO*/
    	//12 ultimos meses
    	for ($i=12;$i>=1;$i--) {
    	 				
    	 	//Pasar dia de la semana ingles, a la primer letra en español
    		$get_mes_anio = substr(date ( 'Y-m' , strtotime ( '-'.$i.' month' , strtotime ( date('Y-m') ) ) ), 5,2);
    		$get_anio = substr(date ( 'Y' , strtotime ( '-'.$i.' month' , strtotime ( date('Y-m') ) ) ), 0,2);;
    		switch ($get_mes_anio){
    			case "01":
    				$mesAnio = "'Ene'";
    				$get_mesanio = substr(date ( 'm/y' , strtotime ( '-'.$i.' month' , strtotime ( date('m/y') ) ) ), 0,5);
    				$cantDiasMes = $this->__helper->getUltimoDiaMes($get_anio,'01');
    				break;
    			case "02":
    				$mesAnio = "'Feb'";
    				$get_mesanio = substr(date ( 'm/y' , strtotime ( '-'.$i.' month' , strtotime ( date('m/y') ) ) ), 0,5);
    				$cantDiasMes = $this->__helper->getUltimoDiaMes($get_anio,'02');
    				break;
    			case "03":
    				$mesAnio = "'Mar'";
    				$get_mesanio = substr(date ( 'm/y' , strtotime ( '-'.$i.' month' , strtotime ( date('m/y') ) ) ), 0,5);
    				$cantDiasMes = $this->__helper->getUltimoDiaMes($get_anio,'03');
    				break;
    			case "04":
    				$mesAnio = "'Abr'";
    				$get_mesanio = substr(date ( 'm/y' , strtotime ( '-'.$i.' month' , strtotime ( date('m/y') ) ) ), 0,5);
    				$cantDiasMes = $this->__helper->getUltimoDiaMes($get_anio,'04');
    				break;
    			case "05":
    				$mesAnio = "'May'";
    				$get_mesanio = substr(date ( 'm/y' , strtotime ( '-'.$i.' month' , strtotime ( date('m/y') ) ) ), 0,5);
    				$cantDiasMes = $this->__helper->getUltimoDiaMes($get_anio,'05');
    				break;
    			case "06":
    				$mesAnio = "'Jun'";
    				$get_mesanio = substr(date ( 'm/y' , strtotime ( '-'.$i.' month' , strtotime ( date('m/y') ) ) ), 0,5);
    				$cantDiasMes = $this->__helper->getUltimoDiaMes($get_anio,'06');
    				break;
    			case "07":
    				$mesAnio = "'Jul'";
    				$get_mesanio = substr(date ( 'm/y' , strtotime ( '-'.$i.' month' , strtotime ( date('m/y') ) ) ), 0,5);
    				$cantDiasMes = $this->__helper->getUltimoDiaMes($get_anio,'07');
    				break;
    			case "08":
    				$mesAnio = "'Ago'";
    				$get_mesanio = substr(date ( 'm/y' , strtotime ( '-'.$i.' month' , strtotime ( date('m/y') ) ) ), 0,5);
    				$cantDiasMes = $this->__helper->getUltimoDiaMes($get_anio,'08');
    				break;
    			case "09":
    				$mesAnio = "'Sep'";
    				$get_mesanio = substr(date ( 'm/y' , strtotime ( '-'.$i.' month' , strtotime ( date('m/y') ) ) ), 0,5);
    				$cantDiasMes = $this->__helper->getUltimoDiaMes($get_anio,'09');
    				break;
    			case "10":
    				$mesAnio = "'Oct'";
    				$get_mesanio = substr(date ( 'm/y' , strtotime ( '-'.$i.' month' , strtotime ( date('m/y') ) ) ), 0,5);
    				$cantDiasMes = $this->__helper->getUltimoDiaMes($get_anio,'10');
    				break;
    			case "11":
    				$mesAnio = "'Nov'";
    				$get_mesanio = substr(date ( 'm/y' , strtotime ( '-'.$i.' month' , strtotime ( date('m/y') ) ) ), 0,5);
    				$cantDiasMes = $this->__helper->getUltimoDiaMes($get_anio,'11');
    				break;
    			case "12":
    				$mesAnio = "'Dic'";
    				$get_mesanio = substr(date ( 'm/y' , strtotime ( '-'.$i.' month' , strtotime ( date('m/y') ) ) ), 0,5);
    				$cantDiasMes = $this->__helper->getUltimoDiaMes($get_anio,'12');
    				break;
    		}
	    	$meses_Anio[] = $mesAnio;
    		//contiene los ultimos  meses, del tipo mm/aa
    		$mes_anio_mesanio[] = $get_mesanio;
    		//contiene la cantidad de dias de cada mies (de los ultimos 6 meses completos)
    		$cantDiasXmes[] = $cantDiasMes;
    		    		    		
	    	$fecha_aaaamm = date ( 'Y-m' , strtotime ( '-'.$i.' month' , strtotime ( date('Y-m') ) ) );
	    	$fecha_mm__aaaa[] = $this->__helper->format_date_mm__aaaa($fecha_aaaamm);
	    	if (!isset($firstDayFirstmonth)) {
	    		$firstDayFirstmonth = date ( 'd-m-Y' , strtotime ( '-'.$i.' month' , strtotime ( date('Y-m') ) ) );
	    	}	    	
    	}//fin for

    	$mes_Anio_ordenados = implode(',',$meses_Anio);
    	
    	/*TABLA TIEMPO DE RESPUESTA INICIO*/
    	//$fecha_desde el primer dia de hace 12 meses
    	$fecha_desde = date ( 'Y/m/d' , strtotime ( '-12 month' , strtotime ( date('Y-m') ) ) );
    	$esteAnio = date ( 'Y' , strtotime ( '-1 month' , strtotime ( date('Y-m') ) ) );
    	$mesPasado = date ( 'm' , strtotime ( '-1 month' , strtotime ( date('Y-m') ) ) );
    	$diasDelMes = $this->__helper->getUltimoDiaMes($esteAnio,$mesPasado);
    	//$fecha_hasta ayer
    	$fecha_hasta = $esteAnio.'/'.$mesPasado.'/'.$diasDelMes;
    	$dias_transcurridos = $this->__helper->dateDiff2($fecha_hasta,$fecha_desde);
    	for ($i = 0; $i <= $dias_transcurridos; $i++) {
    		$nuevafecha = strtotime ( '+'.$i.' day' , strtotime ( $fecha_desde ) ) ;
    		$nuevafecha = date ( 'd/m/y' , $nuevafecha );
    		$fechas_agrupadas[] = $nuevafecha;
    	}
    	//obtiene los reclamos solucionados los ultimos 6 meses, inclusive si no se cerro ningun reclamo
    	//en tal caso ese dia devolvera 0
    	 
    	
    	$fecha_recl_mmddaaaa_mes = $this->_dashboard->getReclMes($fechas_agrupadas,$cantDiasXmes);
    	$menosDe30_ordenados = implode(',',$fecha_recl_mmddaaaa_mes[0]);
    	$menosDe60_ordenados = implode(',',$fecha_recl_mmddaaaa_mes[1]);
    	$masDe60_ordenados = implode(',',$fecha_recl_mmddaaaa_mes[2]);
    	/*TABLA TIEMPO DE RESPUESTA FIN*/    	
    	
    	//tabla cantidad de resoluciones
    	//$cantEstFin = $this->_dashboard->getMesCant($mes_semestre_mesanio,'ESTADO_RECLAMO','FIN');
    	$cantEstFin = $this->_dashboard->getMesCant($mes_anio_mesanio,'ESTADO_RECLAMO','FIN');
    	$cantEstFin_ordenados = implode(',',$cantEstFin);
    	$cantEstSol = $this->_dashboard->getMesCant($mes_anio_mesanio,'ESTADO_RECLAMO','SOL');
    	$cantEstSol_ordenados = implode(',',$cantEstSol);
    	
    	//tabla motivo tipo
    	$cantEstErr = $this->_dashboard->getMesCant($mes_anio_mesanio,'TIPO','ERROR');
    	$cantEstErr_ordenados = implode(',',$cantEstErr);
    	$cantEstAse = $this->_dashboard->getMesCant($mes_anio_mesanio,'TIPO','ASESORIA');
    	$cantEstAse_ordenados = implode(',',$cantEstAse);
    	
    	//tabla sub-clasificacion
    	$cantEstRce = $this->_dashboard->getMesCant($mes_anio_mesanio,'SUB_CLASIF','RCE');
    	$cantEstRce_ordenados = implode(',',$cantEstRce);
    	$cantEstMed = $this->_dashboard->getMesCant($mes_anio_mesanio,'SUB_CLASIF','MEDISYN-ESTANDAR');
    	$cantEstMed_ordenados = implode(',',$cantEstMed);
    	    	
    	/*COLOCAR MESES FIN*/
    	/***INICIO ANIO***/
    	$ruta_mesAniojs = ROOT . "views".DS."dashboard".DS."js".DS."graficos".DS."anual.js";
    	$guiMesAnio = file_get_contents($ruta_mesAniojs);
    	$patronesMesAnio[0] = '{{MESESANIO}}';
    	$patronesMesAnio[1] = '{{CANTRECLFINANIO}}';
    	$patronesMesAnio[2] = '{{CANTRECLSOLANIO}}';
    	$patronesMesAnio[3] = '{{MOTIVOERRANIO}}';
    	$patronesMesAnio[4] = '{{MOTIVOASEANIO}}';
    	$patronesMesAnio[5] = '{{CANTRECLRCEANIO}}';
    	$patronesMesAnio[6] = '{{CANTRECLMSANIO}}';
    	$patronesMesAnio[7] = '{{GRUPO1ANIO}}';
    	$patronesMesAnio[8] = '{{GRUPO2ANIO}}';
    	$patronesMesAnio[9] = '{{GRUPO3ANIO}}';
    	$sustitucionesMesAnio[0] = $mes_Anio_ordenados;
    	$sustitucionesMesAnio[1] = $cantEstFin_ordenados;
    	$sustitucionesMesAnio[2] = $cantEstSol_ordenados;
    	$sustitucionesMesAnio[3] = $cantEstErr_ordenados;
    	$sustitucionesMesAnio[4] = $cantEstAse_ordenados;
    	$sustitucionesMesAnio[5] = $cantEstRce_ordenados;
    	$sustitucionesMesAnio[6] = $cantEstMed_ordenados;
    	$sustitucionesMesAnio[7] = $menosDe30_ordenados;
    	$sustitucionesMesAnio[8] = $menosDe60_ordenados;
    	$sustitucionesMesAnio[9] = $masDe60_ordenados;
    	$htmlMesAnio = str_replace($patronesMesAnio,$sustitucionesMesAnio, $guiMesAnio);
    	//sera invocada desde index.phtml
    	$this->_view->cod_mesAniojs = $htmlMesAnio;
    	 
    	$this->_view->renderizar('anual', 'anual');
    	/***FIN ANIO***/    	
	}

	function tabla() {
		$this->_view->registrosTabla =  $this->_dashboard->getTabla();
		$this->_view->renderizar('tabla', 'tabla');
	}
	function detalle($id) {
		$detalle = $this->_dashboard->getDetalle($id);
		echo "<pre>";
		echo $detalle["MOTIVO_DETALLE"];
		echo "</pre>";
		//echo "ddsfdfsdfsdfsd";
	}
	function titulomodal($id) {
		$detalle = $this->_dashboard->getDetalle($id);
		//echo "ID del Ticket : ".$detalle[0]["id_reclamo"];
		echo "ID del Ticket : ".$detalle["ID_RECLAMO"];
	}
}
?>