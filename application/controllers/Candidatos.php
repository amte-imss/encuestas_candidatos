<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase que gestiona el login
 * @version 	: 1.0.0
 * @autor 	: LEAS
 * @date        : 12/03/2019
 */
class Candidatos extends MY_Controller {
    const name_tipo_carga = 'tipo_carga_sied', name_curso_registro_id = 'cursos_registro', name_clave_curso = 'cve_curso';  
    /**
     * * Carga de clases para el acceso a base de datos y para la creación de elementos del formulario
     * * @access 		: public
     * * @modified 	:
     */
    public function __construct() {
        parent::__construct();

        $this->load->database();
        $this->load->library('Form_complete');
    }

    public function cargar_candidatos($curso = null) {
        $this->load->library("Candidatos_cursos_control", null, "ccc");
//        $candidatos = new Candidatos();
        if ($this->input->is_ajax_request()) {//Valida que la petición sea po AJAX
            $this->ccc->setCurso_id($curso);
            $data['datos_cursos_registro'] = $this->ccc->getDetalle_curso();
            if (is_null($data['datos_cursos_registro'])) {//Valida que exista información del curso
                $view = 'Error';
            } else {
                $tmp = $this->ccc->busqueda_sied(null);
                pr('$tmp');
                pr($tmp);
                pr($data);
                $data['grid_candidatos'] = $this->load->view('candidatos_cursos/grid_candidatos.php', $data, true);
                $view = $this->load->view('candidatos_cursos/control_cargas.php', $data, true);
            }
            echo $view;
        } else {
            $param = null;
//            $param['where'] = ['cve_tipo_carga_candidatos'=>['typeWhere'=>'where_not_in', 'valueWhere'=>['3']]];//Aplica condiciones para omitir opciones, aplica para delegacionales y UMASE
            $tipo_carga = $this->ccc->get_calogo_tipo_cargas($param)['data'];
            $data['tipo_carga'] = dropdown_options($tipo_carga,"cve_tipo_carga_candidatos", "descripcion");//Catalogo de tipo de carga
            $data['cursos_registro'] = dropdown_options($this->ccc->getLista_cursos(), Candidatos_cursos_control::ID_CURSO, Candidatos_cursos_control::NOMBRE_CURSO);
            $data['cursos_registro'] = dropdown_options($this->ccc->getLista_cursos(), Candidatos_cursos_control::ID_CURSO, Candidatos_cursos_control::NOMBRE_CURSO);
            
            $data['btn_delegaciones'] = $this->load->view('candidatos_cursos/descarga_catalogo_delegaciones.php', $data, true);//Boton para descargar catalogo de delegaciones
            $data['btn_candidatos_formato'] = $this->load->view('candidatos_cursos/descarga_formato_candidatos_carga.php', $data, true);//Boton para descaragr formato de caraga de candidatos a cursos
//            
            $registro_candidato = $this->load->view('candidatos_cursos/registro_candidatos.php', $data, true);
            $this->template->setMainTitle('Candidatos nominativos');
            $this->template->setMainContent($registro_candidato);
            $this->template->getTemplate();
        }
    }

    public function cargar_candidatos_csv() {
        $post = $this->input->post(null, true);
        if ($this->input->post()) {     // SI EXISTE UN ARCHIVO EN POS
            $this->config->load('form_validation');
            $this->load->library('form_validation');
            $validations = $this->config->item('cargar_candidatos_csv');
            $post['candidatosfile'] = $_FILES['candidatosfile']['name'];
            $this->load->library("Candidatos_cursos_control", null, "ccc");
            $this->ccc->setCurso_id($this->input->post(Candidatos::name_curso_registro_id, true)); //Asigna el id del curso
            $this->ccc->setTmp_csv($this->carga_csv_datos('candidatosfile')); //Lee información del archivo CSV y asigana el array a una variable de la biblioteca
            pr($post);
//            pr($validations);
            $this->form_validation->set_data($post); //Asigna el valor del data que va a validar
            $this->form_validation->set_rules($validations);
            if ($this->form_validation->run() == TRUE) {
                pr('no error');
            } else {

                pr('validation_errors()');
                pr(validation_errors());
            }

            pr($this->ccc->getTmp_csv());
        }
    }

    public function listado_candidatos() {
        
    }

    public function generar_formato_sied() {
        
    }

    /**
     * candidatosfile
     * @param type $name_file
     * @return type
     */
    protected function carga_csv_datos($name_file = 'userfile') {
//        pr($_FILES);
        $output = [];
        $config['upload_path'] = './uploads/';      // CONFIGURAMOS LA RUTA DE LA CARGA PARA LA LIBRERIA UPLOAD
        $config['allowed_types'] = 'csv';           // CONFIGURAMOS EL TIPO DE ARCHIVO A CARGAR
        $config['max_size'] = '1000';               // CONFIGURAMOS EL PESO DEL ARCHIVO

        $this->load->library('upload', $config);    // CARGAMOS LA LIBRERIA UPLOAD
        if (!$this->upload->do_upload($name_file)) {
            // SI EL PROCESO DE CARGA ENCONTRO UN ERROR
            $output['status'] = FALSE;
            $output['error_upload']['carga_csv'] = $this->upload->display_errors();      // CARGAR EN LA VARIABLE ERROR LOS ERRORES ENCONTRADOS
        } else {                      // SI NO SE ENCONTRARON ERRORES EN EL PROCES
            $this->load->library('csvimport'); //Carga datos del csv, libreria
            $file_data = $this->upload->data();     //BUSCAMOS LA INFORMACIÓN DEL ARCHIVO CARGADO
            $file_path = './uploads/' . $file_data['file_name'];         // CARGAMOS LA URL DEL ARCHIVO
            $csv_array = $this->csvimport->get_array($file_path);   //SI EXISTEN DATOS, LOS CARGAMOS EN LA VARIABLE
            $output['status'] = TRUE;
            $output['csv'] = $csv_array;
            unlink($file_path);
        }
        return $output;
    }
    
    /**
     * Descargar catálogo de delegaciones 
     */
    public function get_delegaciones(){
        $this->load->library("Candidatos_cursos_control", null, "ccc");
        $result = $this->ccc->get_calogo_delegaciones();
        $filename = 'catalogo_delegaciones';
//        pr($result);
        $this->exportar_csv($result['header'], $result['data'], null, null, $filename);//Exportar el formato
        
    }
    
    /**
     * Descargar formato de candidatos 
     */
    public function get_formato_candidatos_csv(){
        $this->load->library("Candidatos_cursos_control", null, "ccc");
        $result = $this->ccc->get_formato_candidatos_csv();
        $filename = 'formato_carga_candidatos';
        $this->exportar_csv($result['headers'],null, null, null, $filename);//Exportar el formato
    }

}
