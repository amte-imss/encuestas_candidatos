<?php   defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase de prueba para las ventanas modales
 * @version 	: 1.0.0
 * @autor 		: Pablo José J.
 */
class Ventana_modal
{

     public function __construct()
     {
     	    $this->CI =& get_instance();
     }

    public function carga_modal($params_modal = array())
    {
          $datos_modal = array(
              'ver_titulo'    => true,
              'ver_mensaje'   => false,
              'ver_footer'    => false,
              'titulo_modal'  => '',
              'cuerpo_modal'  => '',
              'msg_modal'     => '',
              'pie_modal'     => ''
          );

          $datos_modal = $params_modal;

          return $this->CI->load->view('modal.tpl.php', $datos_modal, TRUE);
    }

}
