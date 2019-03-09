<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase que gestiona el login
 * @version     : 1.0.0
 * @autor       : Pablo José
 */
class Resultadocursoencuesta extends MY_Controller {

    /**
     * * Carga de clases para el acceso a base de datos y para la creación de elementos del formulario
     * * @access        : public
     * * @modified  : 
     */
    public function __construct() {
        parent::__construct();

        $this->load->database();
        $this->load->library('form_complete');
        $this->load->library('form_validation');
        //$this->load->model('Reporte_model', 'rep_mod'); // modelo de reporte
        $this->load->model('Curso_model', 'cur_mod'); // modelo de cursos
        $this->load->model('Encuestas_model', 'encur_mod'); // modelo de cursos
        $this->load->helper(array('form'));
    }

    public function index() {
        redirect(site_url()); //Redirigir al inicio del sistema si se desea acceder al método mediante una petición normal, no ajax
    }

    public function exportar_enc_contestadas() {
        if ($this->input->post()) {
            $data_post = $this->input->post();
//                pr($data_post);
//                exit();
            $data_post['current_row'] = 0;
            unset($data_post['per_page']);

//            $resultado = $this->encur_mod->listado_evaluados($data_post); //Datos del formulario se envían para generar la consulta segun los filtros

            $this->load->model('Reporte_encuestas_contestadas', 'r_enc_cont'); // modelo de cursos
            $resultado = $this->r_enc_cont->getBusquedaEncContNoCont($data_post); //Datos del formulario se envían para generar la consulta segun los filtros

            $data['total'] = $resultado['total'];
            $data['evaluaciones'] = $resultado['data'];
            $data['tutorizado'] = $resultado['tutorizado'];

            $filename = $resultado["text_export"] . date("d-m-Y_H-i-s") . ".xls";
            header("Content-Type: application/vnd.ms-excel; charset=UTF-8;");
//            header("Content-Type: application/octet-stream; charset=UTF-8;");
            header("Content-Encoding: UTF-8");
            header("Content-Disposition: attachment; filename=$filename");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo "\xEF\xBB\xBF"; // UTF-8 BOM
            echo $this->load->view($resultado["view_res"], $data, TRUE);
//            $this->load->view('reporte/listado_usuariosrep_xsl', $data);
            //Mostrar resultados
        } else {
            echo data_not_exist('No han sido encontrados datos con los criterios seleccionados. <script> $("#btn_export").hide(); </script>'); //Mostrar mensaje de datos no existentes
        }
    }

    public function get_data_ajax($curso = null, $current_row = null) {
        if ($this->input->is_ajax_request()) { //Sólo se accede al método a través de una petición ajax
            if (isset($curso) && !empty($curso)) {
//                pr($this->input->post());
//exit();
                if ($this->input->post()) { //Se verifica que se haya recibido información por método post
                    //aqui va la nueva conexion a la base de datos del buscador
                    //Se guarda lo que se busco asi como la matricula de quien realizo la busqueda
                    $filtros = $this->input->post();

                    $filtros['current_row'] = (isset($current_row) && !empty($current_row)) ? $current_row : 0;
                    $filtros['curso'] = (isset($curso) && !empty($curso)) ? $curso : '';
                    $data = $filtros;
                    $data['current_row'] = $filtros['current_row'];
                    $data['per_page'] = $this->input->post('per_page');

                    //Checar el tipo de curso
//                    $datos_curso = $this->cur_mod->listado_cursos(array('cur_id' => $curso));
                    $this->load->model('Reporte_encuestas_contestadas', 'r_enc_cont'); // modelo de cursos
//                    $n_resultado = $this->r_enc_cont->listado_evaluados_($filtros); //Datos del formulario se envían para generar la consulta segun los filtros
//                    pr("saludos ");
//                    exit();
                    $resultado = $this->r_enc_cont->getBusquedaEncContNoCont($filtros); //Datos del formulario se envían para generar la consulta segun los filtros
                    //pr($this->db->last_query());
//                    $resultado = $this->encur_mod->listado_evaluados($filtros); //Datos del formulario se envían para generar la consulta segun los filtros
//                    pr($resultado);

                    $data['total'] = $resultado['total'];
                    $data['evaluaciones'] = $resultado['data'];
                    $data['tutorizado'] = $resultado['tutorizado'];
                    $data['controller'] = 'Resultadocursoencuesta';
                    $data['action'] = 'get_data_ajax/' . $curso;

                    $this->listado_resultado($data, array('form_recurso' => '#form_curso', 'elemento_resultado' => '#listado_resultado'), $resultado['view_res']); //Generar listado en caso de obtener datos

                    $sections = array(
                        'config' => TRUE,
                        'queries' => TRUE
                    );
                    $this->output->set_profiler_sections($sections);
                    $this->output->enable_profiler(TRUE);
                }
            } else {
                redirect(site_url()); //Redirigir al inicio del sistema si se desea acceder al método mediante una petición normal, no ajax
            }
        } else {

            redirect(site_url()); //Redirigir al inicio del sistema si se desea acceder al método mediante una petición normal, no ajax
        }
    }

    private function listado_resultado($data, $form, $view = '') {
        $pagination = $this->template->pagination_data_general($data); //Crear mensaje y links de paginación
        $links = "<div class='col-sm-5 dataTables_info' style='line-height: 50px;'>" . $pagination['total'] . "</div>
                <div class='col-sm-7 text-right'>" . $pagination['links'] . "</div>";
        echo $links . $this->load->view($view, $data, TRUE) . $links . '
            <script>
            $("ul.pagination li a").click(function(event){
                data_ajax($(this).attr("href"), "' . $form['form_recurso'] . '", "' . $form['elemento_resultado'] . '");
                event.preventDefault();
            });
            </script>';
    }

    public function lista_anios($anio_inicio, $anio_fin) {
        $anios = array();
        for ($anio = $anio_inicio; $anio <= $anio_fin; $anio++) {
            $anios[] = array('anio_id' => $anio, 'anio_desc' => $anio);
        }
        return $anios;
    }

    /**
     * 
     * @param type $curso
     * @update LEAS 28/11/2017
     */
    public function curso_encuesta_resultado($curso = null) {
        if (is_numeric($curso)) {//Valida que la entrada de curso sea numerica 
            $datos_curso = $this->cur_mod->get_detalle_curso($curso);
            if (isset($datos_curso) and ! empty($datos_curso)) {
                $this->load->model('Reporte_model', 'rep_mod'); // modelo de cursos
                $data = $this->rep_mod->get_filtros_grupo([Reporte_model::GF_ENCUESTA_CONTESTADAS]); //Elementos para filtros
//                $data = $this->rep_mod->get_filtros_grupo([Reporte_model::GF_ENCUESTA_CONTESTADAS], array('instrumento' => ['reg.tutorizado' => $tutorizado])); //Obtiene filtros
                $data['datos_curso'] = $datos_curso; //Agraga datos del curso
//                pr($data);
                $main_contet = $this->load->view('curso/cur_enc_resultado', $data, TRUE);
                $this->template->setMainContent($main_contet);
                $this->template->setMainTitle('Encuestas contestadas y no contestadas');
                $this->template->getTemplate();
            } else {
                //No se encontro información del curso
            }
        } else {
            //No se encontro información del curso
        }
    }

    public function get_registros_encuestas_curso($curso = null) {
        $result['data'] = [];
        if (!is_null($curso) and is_numeric($curso) ) {//Valida que el curso y tipo de reporte sea no null
            $datos_curso = $this->cur_mod->get_detalle_curso($curso);
            if (!empty($datos_curso)) {//Valida que existe un curso relacionado
                $result['data'] = $this->get_reporte_encuestas($datos_curso);
//                pr($result);
            }
        }
        echo json_encode($result);
    }

    /**
     * @author LEAS
     * @fecha 28/11/2017
     * @param type $detalle_curso
     * Array
      (
      [cur_id] => 1215
      [clave_curso] => CES-DGDE-I3-17
      [nombre_curso] => Gestión Directiva para Enfermería
      [clave_categoria] => 1233
      [nombre_categoria] => I3
      [fecha_inicio] => 2018-07-03 00:00:00-05
      [anio] => 2018
      [horascur] => 120
      [modalidad] => 3
      [tipocur] => 1
      [startdatepre] => 2017-06-19
      [tutorizado] => 1
      [en_bloque] =>
      )
     * @param type $tipo_reporte string encuestas contestadas = e_c;
     *  encuestas no contestadas = e_nc;
     * 
     */
    private function get_reporte_encuestas($detalle_curso) {
        $this->load->model('Reporte_encuestas_contestadas', 're');
        $param['curso'] = $detalle_curso[0]['cur_id'];
        $param['tutorizado'] = $detalle_curso[0]['tutorizado'];
        $result = $this->re->getBusquedaEncContNoCont($param);
//        pr($result);
        return $result;
    }

    public function export_data($curso = null) {
        //echo "entra";
        //echo "entra1"; //Sólo se accede al método a través de una petición ajax
        if (isset($curso) && !empty($curso)) {
            //echo "entra2";            
            if ($this->input->post()) {
                //echo "entra3";  //Se verifica que se haya recibido información por método post
                $filtros = $this->input->post();

                $filtros['current_row'] = (isset($current_row) && !empty($current_row)) ? $current_row : 0;
                $filtros['curso'] = (isset($curso) && !empty($curso)) ? $curso : '';
                $data = $filtros;
                $data['current_row'] = $filtros['current_row'];
                $data['per_page'] = $this->input->post('per_page');
                $data['curso'] = $filtros['curso'];
                //$data['encuestacve']='';
                $error = "";
                $data['error'] = $error;

                //Checar el tipo de curso
                $datos_curso = $this->cur_mod->listado_cursos(array('cur_id' => $curso));
                //pr($datos_curso);
                //die();

                $resultado = $this->encur_mod->listado_evaluados($filtros); //Datos del formulario se envían para generar la consulta segun los filtros
                //pr($resultado);

                $data['total_empleados'] = $resultado['total'];
                $data['empleados'] = $resultado['data'];
                //pr($data['total_empleados']);

                if ($data['total_empleados'] > 0) {
                    //echo "emtra4";
                    //die();
                    //$this->listado_resultado($data_sesiones, array('form_recurso'=>'#form_buscador', 'elemento_resultado'=>'#listado_resultado')); //Generar listado en caso de obtener datos
                    $filename = "Export_" . date("d-m-Y_H-i-s") . "_" . $datos_curso['data'][0]['cur_id'] . ".xls";
                    header("Content-Type: application/vnd.ms-excel");
                    header("Content-Encoding: UTF-8");
                    header("Content-Disposition: attachment; filename=$filename");
                    header("Pragma: no-cache");
                    header("Expires: 0");
                    echo "\xEF\xBB\xBF"; // UTF-8 BOM
                    echo $this->load->view('curso/listado_evaluados', $data, TRUE);
                } else {
                    echo data_not_exist('No han sido encontrados datos con los criterios seleccionados. <script> $("#btn_export").hide(); </script>'); //Mostrar mensaje de datos no existentes
                }
            }
        }
    }

    public function curso_encuesta_resultado_detalle($curso = null) {


        $anios = $this->lista_anios(2009, date('Y'));
        $rol = $this->config->item('rol_docente');
        $rol_evalua = $this->config->item('ENCUESTAS_ROL_EVALUA');
        $rol_evaluador = $this->config->item('ENCUESTAS_ROL_EVALUADOR');

        $datos_curso = $this->cur_mod->listado_cursos(array('cur_id' => $curso));
        $data['datos_curso'] = $datos_curso;


        //$datos['order_columns'] = array('nombre'=>'Nombre','nrolevaluador'=>'Rol evaluador','nrolevaluado' => 'Rol evaluado', 'ngrupo' => 'Grupo');
        $data['curso'] = $curso;
        $data['listado_evaluados'] = $this->encur_mod->listado_evaluados(array('curso' => $curso));
        //pr($listado_evaluados);

        $main_contet = $this->load->view('curso/cur_enc_resultado_detalle', $data, true);
        $this->template->setMainContent($main_contet);
        $this->template->getTemplate();
    }

    public function get_datos($curso = null, $current_row = null) {
        if ($this->input->is_ajax_request()) { //Sólo se accede al método a través de una petición ajax
            if (isset($curso) && !empty($curso)) {

                if ($this->input->post()) { //Se verifica que se haya recibido información por método post
                    //aqui va la nueva conexion a la base de datos del buscador
                    //Se guarda lo que se busco asi como la matricula de quien realizo la busqueda
                    $filtros = $this->input->post();

                    $filtros['current_row'] = (isset($current_row) && !empty($current_row)) ? $current_row : 0;
                    $filtros['curso'] = (isset($curso) && !empty($curso)) ? $curso : '';
                    $data = $filtros;
                    $data['current_row'] = $filtros['current_row'];
                    $data['per_page'] = $this->input->post('per_page');
                    $data['curso'] = $filtros['curso'];
                    //$data['encuestacve']='';
                    $error = "";
                    $data['error'] = $error;

                    //Checar el tipo de curso
                    $datos_curso = $this->cur_mod->listado_cursos(array('cur_id' => $curso));

                    $resultado = $this->encur_mod->listado_evaluados_detalle($filtros); //Datos del formulario se envían para generar la consulta segun los filtros
                    //pr($resultado);

                    $data['total_empleados'] = $resultado['total'];
                    $data['empleados'] = $resultado['data'];



                    $this->listado_resultado_detalle($data, array('form_recurso' => '#form_curso', 'elemento_resultado' => '#listado_resultado')); //Generar listado en caso de obtener datos
                }
            } else {
                redirect(site_url()); //Redirigir al inicio del sistema si se desea acceder al método mediante una petición normal, no ajax
            }
        } else {

            redirect(site_url()); //Redirigir al inicio del sistema si se desea acceder al método mediante una petición normal, no ajax
        }
    }

    private function listado_resultado_detalle($data, $form) {
        //echo $data['error'].'<br>';
        $data['encuestacve'] = 0;

        $pagination = $this->template->pagination_data_curso_encuesta_detalle($data); //Crear mensaje y links de paginación
        $links = "<div class='col-sm-5 dataTables_info' style='line-height: 50px;'>" . $pagination['total'] . "</div>
                <div class='col-sm-7 text-right'>" . $pagination['links'] . "</div>";
        echo $links . $this->load->view('curso/listado_evaluados_detalle', $data, TRUE) . $links . '
            <script>
            $("ul.pagination li a").click(function(event){
                data_ajax($(this).attr("href"), "' . $form['form_recurso'] . '", "' . $form['elemento_resultado'] . '");
                event.preventDefault();
            });
            </script>';
    }

    public function export_data_detalle($curso = null) {
        //echo "entra";
        //echo "entra1"; //Sólo se accede al método a través de una petición ajax
        if (isset($curso) && !empty($curso)) {
            //echo "entra2";            
            if ($this->input->post()) {
                //echo "entra3";  //Se verifica que se haya recibido información por método post
                $filtros = $this->input->post();

                $filtros['current_row'] = (isset($current_row) && !empty($current_row)) ? $current_row : 0;
                $filtros['curso'] = (isset($curso) && !empty($curso)) ? $curso : '';
                $data = $filtros;
                $data['current_row'] = $filtros['current_row'];
                $data['per_page'] = $this->input->post('per_page');
                $data['curso'] = $filtros['curso'];
                //$data['encuestacve']='';
                $error = "";
                $data['error'] = $error;

                //Checar el tipo de curso
                $datos_curso = $this->cur_mod->listado_cursos(array('cur_id' => $curso));
                //pr($datos_curso);
                //die();

                $resultado = $this->encur_mod->listado_evaluados_detalle($filtros); //Datos del formulario se envían para generar la consulta segun los filtros
                //pr($resultado);

                $data['total_empleados'] = $resultado['total'];
                $data['empleados'] = $resultado['data'];
                //pr($data['total_empleados']);

                if ($data['total_empleados'] > 0) {
                    //echo "emtra4";
                    //die();
                    //$this->listado_resultado($data_sesiones, array('form_recurso'=>'#form_buscador', 'elemento_resultado'=>'#listado_resultado')); //Generar listado en caso de obtener datos
                    $filename = "Export_" . date("d-m-Y_H-i-s") . "_" . $datos_curso['data'][0]['cur_id'] . ".xls";
                    header("Content-Type: application/vnd.ms-excel");
                    header("Content-Disposition: attachment; filename=$filename");
                    header("Pragma: no-cache");
                    header("Expires: 0");
                    echo $this->load->view('curso/listado_evaluados_detalle', $data, TRUE);
                } else {
                    echo data_not_exist('No han sido encontrados datos con los criterios seleccionados. <script> $("#btn_export").hide(); </script>'); //Mostrar mensaje de datos no existentes
                }
            }
        }
    }

}
