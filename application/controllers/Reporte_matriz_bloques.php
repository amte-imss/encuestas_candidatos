<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Reporte_matriz_bloques
 *
 * @author chrigarc
 */
class Reporte_matriz_bloques extends MY_Controller {

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
        $this->load->model('Curso_model', 'cur_mod'); // modelo de cursos
        $this->load->helper(array('form'));
    }

    public function index() {
        $this->load->model('Reporte_model', 'rep_mod'); // modelo de cursos
        $this->load->model('Reporte_matriz_bloques', 'rep_matriz_mod'); // modelo reporte matriz bloques
        $data = [];
        $data_extra['texto_titulo'] = 'Matriz de Bloques';
        $data_extra['curso_url'] = "site_url+'/reporte_matriz_bloques/get_data_report_ajax/" . ", '#form_curso', '#listado_resultado'";
        $data += $this->rep_mod->get_filtros_generales_reportes();
        $main_contet = $this->filtrosreportes_tpl->getCuerpo(FiltrosReportes_Tpl::RE_MATRIZ_BLOQUES_CURSO, $data_extra);
        $this->template->setMainContent($main_contet);
        $this->template->setMainTitle('Matriz de bloques');
        $this->template->getTemplate();
    }

    function report_bloques($curso = null) {
        $this->load->model('Reporte_model', 'rep_mod'); // modelo de cursos
        $this->load->model('Curso_model', 'cur_mod'); // modelo de cursos

        $data = [];
        $data_extra['texto_titulo'] = '';
        $datos_curso = $this->cur_mod->listado_cursos(array('cur_id' => $curso));
        $datos_curso += $this->cur_mod->getGruposBloques(array('vdc.idc' => $curso));
        if (!empty($datos_curso['data'])) {
            $data_extra['texto_titulo'] = $datos_curso['data'][0]['cur_clave'] . '-' . $datos_curso['data'][0]['cur_nom_completo'];
        }
        $data_extra['curso'] = $curso;
        $data_extra['info_extra']['curso'] = $datos_curso;

        $data_extra['curso_url'] = "site_url+'/reporte_matriz_bloques/get_data_ajax/'+" . $curso . ", '#form_curso', '#listado_resultado'";
        $data += $this->rep_mod->get_filtros_generales_reportes();
        $main_contet = $this->filtrosreportes_tpl->getCuerpo(FiltrosReportes_Tpl::RE_MATRIZ_BLOQUES_CURSO, $data_extra);
        $this->template->setMainContent($main_contet);
        $this->template->setMainTitle('Matriz de bloques');
        $this->template->getTemplate();
    }

    public function get_data_ajax($curso = null, $current_row = 0) {
        if ($this->input->is_ajax_request()) { //Sólo se accede al método a través de una petición ajax
            if (empty($curso)) {
                $curso = $this->input->post('curso');
            }
            if (isset($curso) && !empty($curso)) {
                $this->load->model('Curso_model', 'cur_mod'); // modelo de cursos
                $filtros['vdc.idc'] = $curso;
                $bloque = $this->input->post('bloque');
                $grupoid = $this->input->post('grupoid');
                $opciones['limit'] = $this->input->post('per_page');
                $opciones['order_type'] = $this->input->post('order_type');
                $opciones['current_row'] = $current_row;
                $opciones['ccs'] = $this->input->post('ccs');
                $opciones['cts'] = $this->input->post('cts');
                $opciones['tts'] = $this->input->post('tts');
                if (!empty($bloque)) {
                    $filtros['cbg.bloque'] = $this->input->post('bloque');
                }
                if (!empty($grupoid)) {
                    $filtros['mdlg.id'] = $this->input->post('grupoid');
                }
                $datos_curso = $this->cur_mod->getGruposBloques($filtros, $opciones);

                $data = [];
                $data += $datos_curso;
                $data['curso'] = $curso;
                $data['current_row'] = !empty($current_row) ? $current_row : 0;
                $data['total'] = $datos_curso['total_grupos'];
                $data['per_page'] = $this->input->post('per_page');
                $this->listado_resultado($data, array('form_recurso' => '#form_curso', 'elemento_resultado' => '#listado_resultado')); //Generar listado en caso de obtener datos
            }
        }
    }

    private function listado_resultado($data, $form) {
        $data['controller'] = 'reporte_matriz_bloques';
        $data['action'] = 'get_data_ajax/' . $data['curso'];
        $pagination = $this->template->pagination_data_general($data); //Crear mensaje y links de paginación
        $links = "<div class='col-sm-5 dataTables_info' style='line-height: 50px;'>" . $pagination['total'] . "</div>
                <div class='col-sm-7 text-right'>" . $pagination['links'] . "</div>";
        echo $links . $this->load->view('reporte/curso/matriz_bloques/listado_cursos', $data, TRUE) . $links . '
            <script>
            $("ul.pagination li a").click(function(event){
                data_ajax(this, "' . $form['form_recurso'] . '", "' . $form['elemento_resultado'] . '");
                event.preventDefault();
            });
            </script>';
    }

    public function export_by_curso() {
        $curso = $this->input->post('curso');

        if (isset($curso) && !empty($curso)) {
            $this->load->model('Reporte_model', 'rep_mod'); // modelo de cursos
            $this->load->model('Curso_model', 'cur_mod'); // modelo de cursos
            $filtros['vdc.idc'] = $curso;
            $datos_curso = $this->cur_mod->listado_cursos(array('cur_id' => $curso));
            $datos_curso += $this->cur_mod->getGruposBloques(array('vdc.idc' => $curso));
            $opciones['ccs'] = $this->input->post('ccs');
            $opciones['cts'] = $this->input->post('cts');
            $opciones['tts'] = $this->input->post('tts');
            $opciones['order_type'] = $this->input->post('order_type');
            if ($this->input->post('bloque')) {
                $filtros['cbg.bloque'] = $this->input->post('bloque');
            }
            if ($this->input->post('grupoid')) {
                $filtros['mdlg.id'] = $this->input->post('grupoid');
            }
            $datos_curso = $this->cur_mod->getGruposBloques($filtros, $opciones);
            $data = [];
            $data += $datos_curso;
            $data['curso'] = $curso;
            $data['total'] = $datos_curso['total_grupos'];
            $data['b_export'] = true;
            if ($data['total'] > 0) {
                //$this->listado_resultado($data_sesiones, array('form_recurso'=>'#form_buscador', 'elemento_resultado'=>'#listado_resultado')); //Generar listado en caso de obtener datos
                $filename = "Export_" . date("d-m-Y_H-i-s") . ".xls";
                header("Content-Type: application/vnd.ms-excel");
                header("Content-Disposition: attachment; filename=$filename");
                header("Content-Encoding: UTF-8");
                header("Pragma: no-cache");
                header("Expires: 0");
                echo "\xEF\xBB\xBF"; // UTF-8 BOM
                echo $this->load->view('reporte/curso/matriz_bloques/listado_cursos', $data, TRUE);
            } else {
                echo data_not_exist('No han sido encontrados datos con los criterios seleccionados. <script> $("#btn_export").hide(); </script>'); //Mostrar mensaje de datos no existentes
            }
        }
    }

}
