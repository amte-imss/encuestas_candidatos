<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Prototipos extends MY_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('Curso_model', 'cur_mod');
    }

    public function index(){
    	$data = array();

    	$main_contet = $this->load->view('prototipos/listado_cursos', $data, true);
        $this->template->setMainContent($main_contet);
        $this->template->getTemplate();
    }

    public function info_curso($curso = null) {
     	$data = null;
        $main_contet = $this->load->view('prototipos/info_implementacion', $data, true);
        $this->template->setMainContent($main_contet);
        $this->template->getTemplate();
    }

    public function reportes($curso=null){
    	$data = null;
        $main_contet = $this->load->view('prototipos/reportes', $data, true);
        $this->template->setMainContent($main_contet);
        $this->template->getTemplate();	
    }

    public function detalle_participante(){
    	$data = null;
        $main_contet = $this->load->view('prototipos/detalle_participante', $data, true);
        $this->template->setMainContent($main_contet);
        $this->template->getTemplate();
    }

    public function notificacion(){
    	$output = [];
    	$modal = $this->load->view('prototipos/notificacion',$output, true);
    	$this->template->set_titulo_modal('Enviar notificación');
        $this->template->set_cuerpo_modal($modal);
        $this->template->get_modal();
    }
}

?>