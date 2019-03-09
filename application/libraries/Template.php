<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase que contiene métodos para la carga de la plantilla base del sistema y creación de la paginación
 * @version 	: 1.1.0
 * @author 		: Jesús Díaz P.
 * @author      : Miguel Guagnelli
 * @property    : mixed[] Data arreglo de datos de plantilla con la siguisnte estructura array("title"=>null,"nav"=>null,"main_title"=>null,"main_content"=>null);
 * */
class Template {

    protected $elements;

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->helper('html');
        $this->elements = array(
            "title" => null,
            "menu" => null,
            "main_title" => 'Encuestas de satisfacción',
            "main_content" => null,
            "css_files" => null,
            "js_files" => null,
            "css_script" => null,
            "cuerpo_modal" => null,
        );
    }

    /* Retorna el atributo elements
     * @method: array getData()
     * @return: mixed[] Data arreglo de datos de plantilla con la siguiente estructura array("title"=>null,"nav"=>null,"main_title"=>null,"main_content"=>null);
     */

    function getElements() {

        return $this->elements;
    }

    /* regresa en pantalla el contenido de la plantilla
     * @method: array getData()
     * @return: mixed[] Data arreglo de datos de plantilla con la siguisnte estructura array("title"=>null,"nav"=>null,"main_title"=>null,"main_content"=>null);
     */

    function getTemplate($tipo = FALSE) {

        if ($tipo) {
            $this->CI->load->view('template/home.tpl.php', $this->elements, TRUE);
        }
        $this->CI->load->view('template/home.tpl.php', $this->elements);
    }

    /**
     * Método que carga datos en la plantilla base del sistema
     * @author 		: Jesús Díaz P.
     * @modified 	: Miguel Guagnelli
     * @access 		: public
     * @method:     : void
     * @param 		: mixed[] $elements Elementos configurables en la plantilla
     */
    public function setTemplate($elements = array()) {
        $this->elements['title'] = (array_key_exists('title', $elements)) ? $elements['title'] : null;
        $this->elements['menu'] = $this->templete_menu(); //(array_key_exists('menu', $elements)) ? $elements['menu'] : null;
        $this->elements['main_title'] = (array_key_exists('main_title', $elements)) ? $elements['main_title'] : null;
        $this->elements['main_content'] = (array_key_exists('main_content', $elements)) ? $elements['main_content'] : null;
        $this->elements['css_files'] = (array_key_exists('css_files', $elements)) ? $elements['css_files'] : null;
        $this->elements['js_files'] = (array_key_exists('js_files', $elements)) ? $elements['js_files'] : null;
        $this->elements['css_script'] = (array_key_exists('css_script', $elements)) ? $elements['css_script'] : null;
        $this->elements['cuerpo_modal'] = (array_key_exists('cuerpo_modal', $elements)) ? $elements['cuerpo_modal'] : null;
    }

    /**
     * Método que generación del menú
     * @author 		: Pablo José
     * @modified 	: Miguel Guagnelli
     * @access 		: public
     * @method:     : string menu html del meú principal
     * @deprecated  : 17 de junio de 2015
     * */
    public function templete_menu() { /*
      $logeado = $this->CI->session->userdata('usuario_logeado');
      if($logeado === true){
      $menu_templete = $this->CI->load->view('template/menu_admin', null, TRUE);
      return $menu_templete;
      }else{
      $menu_templete = $this->CI->load->view('template/menu', null, TRUE);
      return $menu_templete;
      } */
        trigger_error('Función descontinuada!', E_NOTICE);
    }

    /**
     * Método que crea links de paginación y mensaje sobre registros mostrados
     * @autor 		: Jesús Díaz P.
     * @modified 	:
     * @access 		: public
     * @param 		: mixed[] $pagination_data Parámetros usados para generar las ligas
     * @return 		: midex[] links -> Ligas para la paginación
     * 						total -> Mensaje sobre registros mostrados
     */
    function pagination_data($pagination_data) {
        $this->CI->load->library(array('pagination', 'table'));
        $config['base_url'] = site_url(array('buscador', 'get_data_ajax')); //Path que se utilizará en la generación de los links
        $config['total_rows'] = $pagination_data['total']; //Número total de registros
        $config['per_page'] = $pagination_data['per_page']; //Sobreescribir número de registros a mostrar
        $this->CI->pagination->initialize($config);

        return array('links' => "<div class='dataTables_paginate paging_simple_numbers'>" . $this->CI->pagination->create_links() . "</div>",
            'total' => "Mostrando " . ($pagination_data['current_row'] + 1) . " a " . ((($pagination_data['current_row'] + $config['per_page']) > $pagination_data['total']) ? $pagination_data['total'] : $pagination_data['current_row'] + $config['per_page']) . " de " . $pagination_data['total']
        );
    }

    /**
     * Método que crea links de paginación y mensaje sobre registros mostrados
     * @autor 		: Jesús Díaz P.
     * @modified 	:
     * @access 		: public
     * @param 		: mixed[] $pagination_data Parámetros usados para generar las ligas
     * @return 		: midex[] links -> Ligas para la paginación
     * 						total -> Mensaje sobre registros mostrados
     */
    function pagination_data_general($pagination_data) {
        $this->CI->load->library(array('pagination', 'table'));
        $config['base_url'] = (array_key_exists('controller', $pagination_data) && array_key_exists('action', $pagination_data)) ? site_url(array($pagination_data['controller'], $pagination_data['action'])) : site_url(array('buscador', 'get_data_ajax')); //Path que se utilizará en la generación de los links
        $config['total_rows'] = $pagination_data['total']; //Número total de registros
        $config['per_page'] = $pagination_data['per_page']; //Sobreescribir número de registros a mostrar
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="disabled"><span><strong>';
        $config['cur_tag_close'] = '</strong></span></li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $this->CI->pagination->initialize($config);

        return array('links' => "<div class='dataTables_paginate paging_simple_numbers  pull-right'>" . $this->CI->pagination->create_links() . "</div>",
            'total' => "Mostrando " . ($pagination_data['current_row'] + 1) . " a " . ((($pagination_data['current_row'] + $config['per_page']) > $pagination_data['total']) ? $pagination_data['total'] : $pagination_data['current_row'] + $config['per_page']) . " de " . $pagination_data['total']
        );
    }

    /*
     * Asigna valores a la propiedad Titulo de la plantilla
     * @author  : Miguel Guagnelli
     * @method  : void setTitle($title)
     * @access  : public
     * @param   : string $title Es el título de la pestaña de la plantilla.
     */

    function setTitle($title = null) {
        $this->elements["title"] = $title;
    }

    /*
     * Asigna la propiedad de opciones de menú de la plantilla
     * @author  : Miguel Guagnelli
     * @method  : void setNav($nav)
     * @access  : public
     * @param   : mixed[] $nav Arreglo compuesto de n elementos con la sig estructura array("link"=>"","titulo"=>"","attribs"=>array())",
     */

    public function setNav($menu = null) {
        $this->elements["menu"] = $menu;
    }

    /*
     * Obtiene la propiedad de opciones de menú de la plantilla
     * @fecha 07/11/2017
     * @author  : LEAS
     * @method  : elementos del menú
     * @access  : public
     * @param   : mixed[] $nav Arreglo compuesto de n elementos con la sig estructura array("secciones_acceso"=>"",
     * "modulos_acceso"=>"")". son todos los menus y las rutas de acceso
     */

    public function get_nav() {
        return $this->elements["menu"];
    }

    /*
     * Asigna la propiedad de cuerpo_modal de la sección en la plantilla
     * @author  : Pablo José
     * @method: void setMainTitle($cuerpo_modal)
     * @param: string $cuerpo_modal Modal de la sección en la que se encuentra el usuario
     */

    public function setCuerpoModal($cuerpo_modal = null) {
        $this->elements["cuerpo_modal"] = $cuerpo_modal;
    }

    /*
     * Asigna la propiedad de título de la sección en la plantilla
     * @author  : Miguel Guagnelli
     * @method: void setMainTitle($main_title)
     * @param: string $main_title Titulo de la sección en la que se encuentra el usuario
     */

    public function setMainTitle($main_title = null) {
        $this->elements["main_title"] = $main_title;
    }

    /*
     * Asigna la propiedad de contenido principal en la plantilla
     * @author  : Miguel Guagnelli
     * @method: void setMainContent($main_content)
     * @param: string $main_content Contenido principal de la plantill
     */

    public function setMainContent($main_content = null) {
        $this->elements["main_content"] = $main_content;
    }

    /*
     * Asigna la propiedad de contenido principal en la plantilla
     * @author  : Miguel Guagnelli
     * @method: void setMainContent($main_content)
     * @param: string $main_content Contenido principal de la plantill
     */

    function setCSSFiles($main_content = null) {
        $this->elements["main_content"] = $main_content;
    }

    /*
    * Asigna la propiedad de cuerpo_modal de la sección en la plantilla
    * @author  : LEAS
    * @method: void setMainTitle($cuerpo_modal)
    * @param: string $cuerpo cuerpo del modal HTML
    * @descripcion: Asigna el cuerpo del modal HTML para definir modal
    */

    function set_cuerpo_modal($cuerpo = '') {
        $this->elements_modal["modal_cuerpo"] = $cuerpo;
    }

    /**
    *
    * @author  : LEAS
    * @fecha 15/05/2017
    * @param type $tpl ruta del template modal
    * @descripcion: pinta el esquema Html del modal dividido en las secciones
    * de ttulo, cuerpo y píe
    */
    function get_modal($tpl = 'tc_template/modal/modal_template') {
        $this->CI->load->view($tpl, $this->elements_modal, FALSE);
    }

    /*
     * Asigna la propiedad de cuerpo_modal de la sección en la plantilla
     * @author  : LEAS
     * @method: void setMainTitle($cuerpo_modal)
     * @param: String $titulo titulo del modal
     * @descripcion: Asigna un titulo al modal
     */

    function set_titulo_modal($titulo = '') {
        $this->elements_modal["modal_titulo"] = $titulo;
    }


    public function template_buscador($elements = array()) {
        $elements['css_files'] = (array_key_exists('css_files', $elements)) ? $elements['css_files'] : null;
        $elements['js_files'] = (array_key_exists('js_files', $elements)) ? $elements['js_files'] : null;
        $elements['css_script'] = (array_key_exists('css_script', $elements)) ? $elements['css_script'] : null;
        //$elements['menu'] = $this->templete_menu();
        $elements['main_content'] = (array_key_exists('main_content', $elements)) ? $elements['main_content'] : null;
        $this->CI->load->view('template/home.tpl.php', $elements);
    }

    public function pagination_data_buscador($pagination_data) {
        $this->CI->load->library(array('pagination', 'table'));
        $config['base_url'] = site_url(array('reporte', 'get_data_ajax')); //Path que se utilizará en la generación de los links
        $config['total_rows'] = $pagination_data['total_empleados']; //Número total de registros
        $config['per_page'] = $pagination_data['per_page']; //Sobreescribir número de registros a mostrar
        $this->CI->pagination->initialize($config);

        return array('links' => "<div class='dataTables_paginate paging_simple_numbers'>" . $this->CI->pagination->create_links() . "</div>",
            'total' => "Mostrando " . ($pagination_data['current_row'] + 1) . " a " . ((($pagination_data['current_row'] + $config['per_page']) > $pagination_data['total_empleados']) ? $pagination_data['total_empleados'] : $pagination_data['current_row'] + $config['per_page']) . " de " . $pagination_data['total_empleados']
        );
    }

    public function pagination_data_empleado($pagination_data, $url = null) {
        if (is_null($url))
            $url = 'get_data_ajax';
        $this->CI->load->library(array('pagination', 'table'));
        $path = (is_array($url)) ? $url : array('reporte', $url);
        $config['base_url'] = site_url($path); //Path que se utilizará en la generación de los links
        //        $config['total_rows'] = $pagination_data['alumnos']['total']; //Número total de registros
        $config['total_rows'] = $pagination_data['total_empleados']; //Número total de registros $pagination_data['alumnos']['total'];
        //        $config['per_page'] = $pagination_data['per_page']; //Sobreescribir número de registros a mostrar
        $config['per_page'] = $pagination_data['per_page']; //Sobreescribir número de registros a mostrar  $pagination_data['per_page'];
        $this->CI->pagination->initialize($config);
//        pr($pagination_data);
//        exit();
        //        return array('links'=>"<div class='dataTables_paginate paging_simple_numbers'>".$this->CI->pagination->create_links()."</div>",
        //                'total'=>"Mostrando ".($pagination_data['current_row']+1)." a ".((($pagination_data['current_row']+$config['per_page'])>$pagination_data['alumnos']['total']) ? $pagination_data['alumnos']['total'] : $pagination_data['current_row']+$config['per_page'])." de ".$pagination_data['alumnos']['total']
        //            );
        /* return array('links' => "<div class='dataTables_paginate paging_simple_numbers'>" . $this->CI->pagination->create_links() . "</div>",
          'total' => "Mostrando " . ($pagination_data['current_row'] + 1) . " a 6 de 6"
          ); */
        return array('links' => "<div class='dataTables_paginate paging_simple_numbers'>" . $this->CI->pagination->create_links() . "</div>",
            'total' => "Mostrando " . ($pagination_data['current_row'] + 1) . " a " . ((($pagination_data['current_row'] + $config['per_page']) > $pagination_data['total_empleados']) ? $pagination_data['total_empleados'] : $pagination_data['current_row'] + $config['per_page']) . " de " . $pagination_data['total_empleados']
        );
//
    }

    public function pagination_data_curso($pagination_data) {
        $this->CI->load->library(array('pagination', 'table'));
        $config['base_url'] = site_url(array('curso', 'get_data_ajax')); //Path que se utilizará en la generación de los links
        //        $config['total_rows'] = $pagination_data['alumnos']['total']; //Número total de registros
        $config['total_rows'] = $pagination_data['total_empleados']; //Número total de registros $pagination_data['alumnos']['total'];
        //        $config['per_page'] = $pagination_data['per_page']; //Sobreescribir número de registros a mostrar
        $config['per_page'] = $pagination_data['per_page']; //Sobreescribir número de registros a mostrar  $pagination_data['per_page'];
        $this->CI->pagination->initialize($config);
//        pr($pagination_data);
//        exit();
        //        return array('links'=>"<div class='dataTables_paginate paging_simple_numbers'>".$this->CI->pagination->create_links()."</div>",
        //                'total'=>"Mostrando ".($pagination_data['current_row']+1)." a ".((($pagination_data['current_row']+$config['per_page'])>$pagination_data['alumnos']['total']) ? $pagination_data['alumnos']['total'] : $pagination_data['current_row']+$config['per_page'])." de ".$pagination_data['alumnos']['total']
        //            );
        /* return array('links' => "<div class='dataTables_paginate paging_simple_numbers'>" . $this->CI->pagination->create_links() . "</div>",
          'total' => "Mostrando " . ($pagination_data['current_row'] + 1) . " a 6 de 6"
          ); */
        return array('links' => "<div class='dataTables_paginate paging_simple_numbers'>" . $this->CI->pagination->create_links() . "</div>",
            'total' => "Mostrando " . ($pagination_data['current_row'] + 1) . " a " . ((($pagination_data['current_row'] + $config['per_page']) > $pagination_data['total_empleados']) ? $pagination_data['total_empleados'] : $pagination_data['current_row'] + $config['per_page']) . " de " . $pagination_data['total_empleados']
        );
//
    }

    public function pagination_data_encuestas($pagination_data) {
        $this->CI->load->library(array('pagination', 'table'));
        $config['base_url'] = site_url(array('encuestas', 'get_encuestas_ajax')); //Path que se utilizará en la generación de los links
        $config['total_rows'] = $pagination_data['total_encuestas']; //Número total de registros
        $config['per_page'] = $pagination_data['per_page']; //Sobreescribir número de registros a mostrar
        $this->CI->pagination->initialize($config);

        return array('links' => "<div class='dataTables_paginate paging_simple_numbers'>" . $this->CI->pagination->create_links() . "</div>",
            'total' => "Mostrando " . ($pagination_data['current_row'] + 1) . " a " . ((($pagination_data['current_row'] + $config['per_page']) > $pagination_data['total_encuestas']) ? $pagination_data['total_encuestas'] : $pagination_data['current_row'] + $config['per_page']) . " de " . $pagination_data['total_encuestas']
        );
    }

    public function pagination_data_enc_curso($pagination_data) {

        $this->CI->load->library(array('pagination', 'table'));
        $config['base_url'] = site_url(array('cursoencuesta', 'get_data_ajax/' . $pagination_data['curso'] . '')); //Path que se utilizará en la generación de los links
        //        $config['total_rows'] = $pagination_data['alumnos']['total']; //Número total de registros
        $config['total_rows'] = $pagination_data['total_empleados']; //Número total de registros $pagination_data['alumnos']['total'];
        //        $config['per_page'] = $pagination_data['per_page']; //Sobreescribir número de registros a mostrar
        $config['per_page'] = $pagination_data['per_page']; //Sobreescribir número de registros a mostrar  $pagination_data['per_page'];
        $this->CI->pagination->initialize($config);
        return array('links' => "<div class='dataTables_paginate paging_simple_numbers'>" . $this->CI->pagination->create_links() . "</div>",
            'total' => "Mostrando " . ($pagination_data['current_row'] + 1) . " a " . ((($pagination_data['current_row'] + $config['per_page']) > $pagination_data['total_empleados']) ? $pagination_data['total_empleados'] : $pagination_data['current_row'] + $config['per_page']) . " de " . $pagination_data['total_empleados']
        );
//
    }

    public function pagination_data_reporte($pagination_data) {
        $this->CI->load->library(array('pagination', 'table'));
        $config['base_url'] = site_url(array('resultadocurenrealizada', 'get_data_ajax/' . $pagination_data['curso'] . '')); //Path que se utilizará en la generación de los links
        //        $config['total_rows'] = $pagination_data['alumnos']['total']; //Número total de registros
        $config['total_rows'] = $pagination_data['total_empleados']; //Número total de registros $pagination_data['alumnos']['total'];
        //        $config['per_page'] = $pagination_data['per_page']; //Sobreescribir número de registros a mostrar
        $config['per_page'] = $pagination_data['per_page']; //Sobreescribir número de registros a mostrar  $pagination_data['per_page'];
        $this->CI->pagination->initialize($config);
        return array('links' => "<div class='dataTables_paginate paging_simple_numbers'>" . $this->CI->pagination->create_links() . "</div>",
            'total' => "Mostrando " . ($pagination_data['current_row'] + 1) . " a " . ((($pagination_data['current_row'] + $config['per_page']) > $pagination_data['total_empleados']) ? $pagination_data['total_empleados'] : $pagination_data['current_row'] + $config['per_page']) . " de " . $pagination_data['total_empleados']
        );
    }

    public function pagination_data_curso_encuesta($pagination_data) {
        $this->CI->load->library(array('pagination', 'table'));
        $config['base_url'] = site_url(array('resultadocursoencuesta', 'get_data_ajax/' . $pagination_data['curso'] . '')); //Path que se utilizará en la generación de los links
        //        $config['total_rows'] = $pagination_data['alumnos']['total']; //Número total de registros
        $config['total_rows'] = $pagination_data['total_empleados']; //Número total de registros $pagination_data['alumnos']['total'];
        //        $config['per_page'] = $pagination_data['per_page']; //Sobreescribir número de registros a mostrar
        $config['per_page'] = $pagination_data['per_page']; //Sobreescribir número de registros a mostrar  $pagination_data['per_page'];
        $this->CI->pagination->initialize($config);
        return array('links' => "<div class='dataTables_paginate paging_simple_numbers'>" . $this->CI->pagination->create_links() . "</div>",
            'total' => "Mostrando " . ($pagination_data['current_row'] + 1) . " a " . ((($pagination_data['current_row'] + $config['per_page']) > $pagination_data['total_empleados']) ? $pagination_data['total_empleados'] : $pagination_data['current_row'] + $config['per_page']) . " de " . $pagination_data['total_empleados']
        );
    }

    public function pagination_data_curso_encuesta_detalle($pagination_data) {
        $this->CI->load->library(array('pagination', 'table'));
        $config['base_url'] = site_url(array('resultadocursoencuesta', 'get_datos/' . $pagination_data['curso'] . '')); //Path que se utilizará en la generación de los links
        //        $config['total_rows'] = $pagination_data['alumnos']['total']; //Número total de registros
        $config['total_rows'] = $pagination_data['total_empleados']; //Número total de registros $pagination_data['alumnos']['total'];
        //        $config['per_page'] = $pagination_data['per_page']; //Sobreescribir número de registros a mostrar
        $config['per_page'] = $pagination_data['per_page']; //Sobreescribir número de registros a mostrar  $pagination_data['per_page'];
        $this->CI->pagination->initialize($config);
        return array('links' => "<div class='dataTables_paginate paging_simple_numbers'>" . $this->CI->pagination->create_links() . "</div>",
            'total' => "Mostrando " . ($pagination_data['current_row'] + 1) . " a " . ((($pagination_data['current_row'] + $config['per_page']) > $pagination_data['total_empleados']) ? $pagination_data['total_empleados'] : $pagination_data['current_row'] + $config['per_page']) . " de " . $pagination_data['total_empleados']
        );
    }

}
