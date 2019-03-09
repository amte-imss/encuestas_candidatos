<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter Fechas helper
 *
 * @package		SIED_ad
 * @author		Miguel Guagnelli
 * @version		v1.0.0
 *
 * @usage 		$autoload['helper'] = array('fecha');	
 *
 */


/**
 * Obtener fecha
 * Obtiene la fecha especificada o actual con un formato específico
 * @access  public
 * @param   integer 
 *				1: Formato largo (México, D.F., dd de Mes de yyyy) default option
 *				2: Formato corto #1 (10 de Junio de 2014)
 *				3: Formato corto #2 (10/06/2014)
 *				4: Formato SIED (Lunes 10 de Junio de 2014; 04:47 pm)
 * @param 	Object DateTime, Current Date as default
 * @return  string
 */
if ( ! function_exists('get_fecha'))
{
    function get_fecha($nFormato = 1, $date = null)
    {
    	if(is_null($date)){
    		$date = new DateTime("now");
    	}
    	$sFormato = null;
    	$fecha = "";
    	switch ($nFormato){
    		case 1:
    			$fecha = "M&eacute;xico, D.F., ";
    		case 2:
    			$sFormato = 'd \d\e %\s \d\e Y';
				$fecha .= $date->format($sFormato);
				unset($date);
                $meses = unserialize(MESES);
				$fecha = sprintf($fecha,($meses[$date->format("m")-1]));
				break;
    		case 3:
    			$sFormato = 'd/m/Y';
				$fecha .= $date->format($sFormato);
				unset($date);
    			break;
    		case 4:
    			$fecha = '%\s d \d\e  %\s \d\e Y;  h:i a';
			    $fecha =  $date->format($fecha); 
                $dias = unserialize(DIAS);
                $meses = unserialize(MESES);
			    $fecha = sprintf($fecha,($dias[$date->format("N")]),($meses[$date->format("m")-1]));
			    unset($date);
    			break;
    		default: return FALSE;
    	}
    	return $fecha;
    }
}

/**
 * Obtener mes
 * Obtiene el nombre del mes en español
 * @access  public
 * @param   integer 
 * @return  string
 */
if ( ! function_exists('get_mesSp'))
{
    function get_mesSp($nMes = null)
    {
    	if(is_null($nMes)){
			$date = new DateTime();
    		$nMes = $date->format('m');
    		unset($date);
    	}elseif($nMes < 1 && $nMes > 12){
    		return false;
    	}
        $meses = unserialize(MESES);
    	return $meses[$nMes-1];
    }
}

/**
 * Obtener dia de la semana
 * Obtiene el nombre del dia de la semana en español 
 * @access  public
 * @param   integer 
 * @return  string
 */
if ( ! function_exists('get_dWeekSp'))
{
    function get_dWeekSp($nDay = null)
    {
    	if(is_null($nDay)){
			$date = new DateTime();
    		$nDay = $date->format('N');
    		unset($date);
    	}elseif($nMes < 1 && $nMes > 12){
    		return false;
    	}
        $dias = unserialize(DIAS);
    	return $dias[$nMes-1];
    }
}

/**
 * Obtener dia de la semana
 * Obtiene el nombre del dia de la semana en español 
 * @access  public
 * @param   String 
 * @return  string
 */
if ( ! function_exists('get_periodo'))
{
    function get_periodo($fInicial = null, $fFinal = null)
    {
    	$sPeriodo =  "Del %s al %s";
    	if(is_null($fInicial) && is_null($fFinal)){
    		return FALSE;
    	}
    	$fInicial = new DateTime($fInicial);
    	$fFinal = new DateTime($fFinal);
    	$sPeriodo .= sprintf($sPeriodo,get_fecha(2,$fInicial),get_fecha(2,$fFinal));
    	return $sPeriodo;
    }
}
