<?php   defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase de prueba para las ventanas modales
 * @version 	: 1.0.0
 * @autor 		: Pablo José J.
 */
class Modal extends MY_Controller {

    /**
     * Carga de clases para el acceso a base de datos y obtencion de las variables de session
     * @access 		: public
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper(array('form','captcha','general'));
        $this->load->library('form_complete');
        $this->load->library('form_validation');
        $this->load->library('Ventana_modal');
        $this->load->model('Encuestas_model', 'enc_mod');


    }

    public function mod_encuestas($id_instrumento=null)
    {
        if ($this->input->is_ajax_request()) {    
            if (isset($id_instrumento) && !empty($id_instrumento)) {
                    # code...
                    $datos1['instrumento']=$this->enc_mod->get_instrumento_detalle($id_instrumento);
                    $datos1['preguntas'] = $this->enc_mod->preguntas_instrumento($id_instrumento);
                    //$datos['listado_preguntas'] = $this->enc_mod->get_preguntas_encuesta(array('encuesta_cve'=>1));
                    //$datos['listado_cursos'] = $this->cur_mod->get_cursos();
                    //pr($datos);
                    $parametros = array(); // se crea una variable parametros de ejemplo para llenar algun metodo
                    //$datos['titulo_modal'] = "Instrumento"; // las variables importantes son titulo_modal y cuerpo_modal
                    $datos['cuerpo_modal'] = $this->load->view('encuesta/prev_encur', $datos1, true);// uso de algún metodo para llenar el cuerpo de la ventana modal

                    //$cuerpo_modal = $this->ventana_modal->carga_modal($datos);
                    echo $this->ventana_modal->carga_modal($datos);
                    //$main_contet = $this->load->view('encuesta/prev', $datos, true);
                    //$this->template->setMainContent($main_contet);
                    //$this->template->getTemplate();
            }
       }
        else {
            redirect(site_url()); //Redirigir al inicio del sistema si se desea acceder al método mediante una petición normal, no ajax
        }
    }

}
