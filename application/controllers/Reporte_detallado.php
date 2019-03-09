<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase que gestiona el login
 * @version 	: 1.0.0
 * @autor 		: JZDP
 */
class Reporte_detallado extends MY_Controller {

    /**
     * * Carga de clases para el acceso a base de datos y para la creación de elementos del formulario
     * * @access 		: public
     * * @modified 	: 
     */
    public function __construct() {
        parent::__construct();

        $this->load->database();
        $this->load->library('form_complete');
        $this->load->library('form_validation');
        $this->load->model('Reporte_detallado_model', 'rep_det_mod'); // modelo de reporte
        //$this->load->model('Curso_model', 'cur_mod'); // modelo de cursos
        //$this->load->model('Encuestas_model', 'enc_mod');
    }

    public function index() {
            $this->load->model('Reporte_model', 'rep_mod'); // modelo de reporte
            //Obtiene los filtros para reporte
            /* $data = $this->rep_mod->get_filtros_generales_reportes();
              //Quitar lo que no se utiliza
              $unset = array('buscar_por');
              foreach ($unset as $k_value) {
              unset($data[$k_value]);
              }
              $main_contet = $this->load->view('reporte/detalle/detalle', $data, true); */
            $main_content = $this->filtrosreportes_tpl->getCuerpo(FiltrosReportes_Tpl::RB_ENCUESTAS_DETALLE, array('js' => array('reporte_detallado.js')));
            $this->template->setMainTitle('Reporte detalle de encuestas');
            $this->template->setMainContent($main_content);
            $this->template->getTemplate();
    }

    public function get_buscar_cursos_encuestas($current_row = null) {
        if ($this->input->is_ajax_request()) { //Sólo se accede al método a través de una petición ajax
            if (!is_null($this->input->post())) { //Se verifica que se haya recibido información por método post
                $data_post = $this->input->post();
                //pr($data_post);
                //aqui va la nueva conexion a la base de datos del buscador
                //Se guarda lo que se busco asi como la matricula de quien realizo la busqueda
                $filtros = $this->input->post(null, true);
                $filtros['current_row'] = (isset($current_row) && !empty($current_row)) ? $current_row : 0;
                $data = array();
                //echo "-";pr($filtros);echo "-";
                $resultado = $this->rep_det_mod->reporte_detalle_encuesta($filtros); //Datos del formulario se envían para generar la consulta segun los filtros

                $data = $filtros;
                $data['total_empleados'] = $resultado['total'];
                $data['datos'] = $resultado['data'];
                $data['preguntas'] = $resultado['preguntas']['data'];
                $data['respuestas'] = (isset($resultado['respuestas']['data'])) ? $resultado['respuestas']['data'] : '';
                $data['current_row'] = $filtros['current_row'];
                $data['per_page'] = $this->input->post('per_page');
                //pr($data);
                $this->listado_resultado($data, array('form_recurso' => '#form_curso', 'elemento_resultado' => '#listado_resultado_empleado')); //Generar listado en caso de obtener datos
                //echo $this->load->view('reporte/detalle/tb_result_detalle', $data, TRUE);
            }
        } else {
            redirect(site_url()); //Redirigir al inicio del sistema si se desea acceder al método mediante una petición normal, no ajax
        }
    }

    public function reporte_detallado_export() {
        if ($this->input->post()) {
            $filtros = $this->input->post(null, true);
            //$filtros['current_row'] = (isset($current_row) && !empty($current_row)) ? $current_row : 0;
            $data['export'] = $filtros['export'] = true;
            //$data = array();
            //echo "-";pr($filtros);echo "-";
            $resultado = $this->rep_det_mod->reporte_detalle_encuesta($filtros); //Datos del formulario se envían para generar la consulta segun los filtros
            //$data = $filtros;
            $data['total_empleados'] = $resultado['total'];
            $data['datos'] = $resultado['data'];
            $data['preguntas'] = $resultado['preguntas']['data'];
            $data['respuestas'] = (isset($resultado['respuestas']['data'])) ? $resultado['respuestas']['data'] : '';
            //$data['current_row'] = $filtros['current_row'];
            //$data['per_page'] = $this->input->post('per_page');

            $filename = "Export_" . date("d-m-Y_H-i-s") . ".xls";
            header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
            header('Content-Encoding: UTF-8');
            header("Content-Disposition: attachment; filename=$filename");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo "\xEF\xBB\xBF"; // UTF-8 BOM
            $this->listado_resultado($data, array('form_recurso' => '#form_curso', 'elemento_resultado' => '#listado_resultado_empleado')); //Generar listado en caso de obtener datos
        } else {
            echo data_not_exist('No han sido encontrados datos con los criterios seleccionados. <script> $("#btn_export").hide(); </script>'); //Mostrar mensaje de datos no existentes
        }
    }

    private function listado_resultado($data, $form) {
        $links = "";
        if (!isset($data['export']) || (isset($data['export']) && $data['export'] == false)) {
            $pagination = $this->template->pagination_data_empleado($data, array('reporte_detallado', 'get_buscar_cursos_encuestas')); //Crear mensaje y links de paginación
            if ($data['total_empleados'] > 0) {
                $links = "<div class='col-sm-5 dataTables_info' style='line-height: 50px;'>" . $pagination['total'] . "</div>
                    <div class='col-sm-7 text-right'>" . $pagination['links'] . "</div>";
            }
        }
        echo $links . $this->load->view('reporte/detalle/tb_result_detalle', $data, TRUE) . $links;
        if (!isset($data['export']) || (isset($data['export']) && $data['export'] == false)) {
            echo '<script>
            $("ul.pagination li a").click(function(event){
                data_ajax(this, "' . $form['form_recurso'] . '", "' . $form['elemento_resultado'] . '");
                event.preventDefault();
            });
            </script>';
        }
    }

    public function get_view_ajax($tipo = null) {
        if ($this->input->is_ajax_request()) { //Sólo se accede al método a través de una petición ajax
            if (!is_null($this->input->post())) { //Se verifica que se haya recibido información por método post
                $filtros = $this->input->post(null, true);
                $data = array();
                switch ($tipo) {
                    case 'e':
                        //instrumento_regla, is_bono, anio
                        $data = $this->rep_det_mod->reporte_encuesta_data($filtros + array('fields' => "encuesta_cve, descripcion_encuestas||' ('||cve_corta_encuesta||')' as descripcion_encuestas_completa")); //Datos del formulario se envían para generar la consulta segun los filtros
                        $data['encuesta'] = dropdown_options($data['data'], 'encuesta_cve', 'descripcion_encuestas_completa');
                        ;
                        $vista = 'reporte/vistas_grupos/view_encuesta';
                        break;
                    default:
                        # code...
                        break;
                }
                echo $this->load->view($vista, $data, TRUE);
            }
        } else {
            redirect(site_url()); //Redirigir al inicio del sistema si se desea acceder al método mediante una petición normal, no ajax
        }
    }

    public function lista_anios($anio_inicio, $anio_fin) {
        $anios = array();
        for ($anio = $anio_inicio; $anio <= $anio_fin; $anio++) {
            $anios[] = array('anio_id' => $anio, 'anio_desc' => $anio);
        }
        return $anios;
    }

}
