<?php

class Buscar_control extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("reporte_model", "rep");
        $this->config->load('general');
    }

    public function index() {
        $main_contet = $this->load->view('pruebas/buscador', null, true);
        $this->template->setMainTitle('Buscar');
        $this->template->setMainContent($main_contet);
        $this->template->getTemplate();
    }

    public function buscar() {
        $data_post = $this->input->post(null, true);
//        pr($data_post['b']);
        $row['res_busqueda'] = $this->rep->get_busca_cursos_nombre($data_post['b']);
//        pr($row);
        $main_contet = $this->load->view('pruebas/lista_res', $row, true);
        echo $main_contet;
    }

}
