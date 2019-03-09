<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Clase que contiene métodos para siap
 * @version 	: 1.0.0
 * @author      : Pablo José
 **/
class Soap_library {
   
    public function __construct() {
    	$this->CI =& get_instance();
        include APPPATH.'third_party/nusoap/nusoap.php';
    }
    
    /***********Buscar usuario siap
    *Función que genera una imagen captcha
    * recibe dos parametros (informacion de registro de aspirantes)
    *@method: void buscar_usuario_siap()
    */
    
    function check_session($wsdl){
        //include("nusoap.php");
        $client = new soapclient("http://11.32.41.13/kio/sied/app/login/check_session.php?wsdl");
        $result    =    $client->gethelloworld("Milap Patel");
        echo "<pre>";
        print_r($result);
        echo "</pre>";

        /*$return_info = false;
        $result = array('resp_info'=>null, 'resultado' => 'false');
        $params = array("Delegacion"=>"{$data_siap['reg_delegacion']}","Matricula"=>"{$data_siap['asp_matricula']}","RFC"=>'');
        
        $client = new SoapClient("http://172.26.18.156/ServiciosWeb/wsSIED.asmx?WSDL");
        $resultado_siap = $client->__soapCall("ConsultaSIED", array($params));
        $resultado = simplexml_load_string($resultado_siap->ConsultaSIEDResult->any); //obtenemos la consulta xml
        $res_json = json_encode($resultado); // la codificamos en json
        $array_result = json_decode($res_json); // y la decodificamos en un arreglo compatible php
        
        $result['resp_info']=$array_result;
        if (isset($resultado->EMPLEADOS)){
            $result['resultado']=  true;
            
            $return_info = $this->regresa_datos($result, $data_siap['reg_delegacion']);
            
        }
        return $return_info;*/
    }
	  
}