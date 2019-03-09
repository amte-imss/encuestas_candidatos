<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase que gestiona el login
 * @version 	: 1.0.0
 * @autor 		: Pablo José
 */
class Reporte_bonos extends MY_Controller {

    /**
     * * Carga de clases para el acceso a base de datos y para la creación de elementos del formulario
     * * @access 		: public
     * * @modified 	: 
     */
    public function __construct() {
        parent::__construct();

//        $this->load->database();
        $this->load->library('form_complete');
        $this->load->library('form_validation');
        $this->load->model('Reporte_model', 'rep_mod'); // modelo de reporte
        $this->load->model('Reporte_bonos_implementacion_model', 'rbi_mod'); // modelo de reporte
    }

    public function index() {
        //Obtiene los filtros para reporte
//        $data = $this->rep_mod->get_filtros_generales_reportes();
//        pr($data);
////Quitar lo que no se utiliza
//        $unset = array('buscar_por', 'buscar_categoria', 'grupos_p', 'bloques_p');
//        foreach ($unset as $k_value) {
//            unset($data[$k_value]);
//        }
        /*
          [2] => emp_matricula
          [3] => emp_nombre
          [11] => cat_nombre
          [15] => fch_pre_registro
          [17] => cur_clave
          [18] => cur_nom_completo
          [19] => fecha_inicio
          [20] => horascur
          [21] => fecha_fin
          [24] => grup_nom
          [25] => tutorizado
          [26] => curso_alcance
          [27] => rol_nom
          [28] => tipocur
         */

        /*
          $data['profesores'] = $this->rep_mod->reporte_usuarios(array('per_page'=>10, 'current_row'=>1));
          pr($data['profesores']);

         */

//        $main_contet = $this->load->view('reporte/bonos/bonos', $data, true);
//        $this->template->setMainTitle('Reporte de bonos');
//        $this->template->setMainContent($main_contet);
//        $this->template->getTemplate();
//         $this->filtrosreportes_tpl->getVista(FiltrosReportes_Tpl::RB_IMPLEMENTACION);

        $reglas_evaluacion = $this->rep_mod->get_lista_roles_regla_evaluacion('roles', 'excepcion');
        $this->session->set_userdata('reglas_evaluacion', $reglas_evaluacion);
//        pr($reglas_evaluacion);
//        $this->session->set_userdata('reglas_evaluacion', $reglas_evaluacion);

        $main_contet = $this->filtrosreportes_tpl->getCuerpo(FiltrosReportes_Tpl::RB_IMPLEMENTACION);
        $this->template->setMainTitle('Reporte de implementación');
        $this->template->setMainContent($main_contet);
        $this->template->getTemplate();
    }

    public function get_buscar_cursos_encuestas($current_row = null) {
        if (!is_null($this->input->post())) { //Se verifica que se haya recibido información por método post
            $data_post = $this->input->post();
            $data_post['current_row'] = (isset($current_row) && !empty($current_row)) ? $current_row : 0;
            $data = array();
            $resultado = $this->rbi_mod->get_reporte_bonos_implementacion($data_post);
//            pr($resultado);
//            exit();
            $data['total'] = $resultado['total'];
//                pr($data['total']);
            $data['result'] = $resultado['result'];
            $data['result_promedio'] = $resultado['result_promedio']['datos'];
            $data['num_rows'] = $resultado['num_rows'];
            $data['current_row'] = $data_post['current_row'];
            $data['per_page'] = $data_post['per_page'];
            $data['reglas_evaluacion'] = $this->session->userdata('reglas_evaluacion');
//                pr($data['reglas_evaluacion']);
            //Configuracion del reporte
            $c_r = $this->filtrosreportes_tpl->getArrayVistasReportes(FiltrosReportes_Tpl::RB_IMPLEMENTACION);
            //Mostrar resultados
            $this->listado_resultado($data, array('form_recurso' => $c_r[FiltrosReportes_Tpl::C_NAME_FORMULARIO], 'elemento_resultado' => $c_r[FiltrosReportes_Tpl::C_NAME_DIV_RESULTADO])); //Generar listado en caso de obtener datos
//                echo $this->load->view('reporte/bonos/tb_result_bnos_1', $data, TRUE);
            $this->load->view('reporte/bonos/tb_result_bnos', $data, TRUE);
        }
    }

    private function listado_resultado($data, $form) {
        $data['controller'] = 'reporte_bonos';
        $data['action'] = 'get_buscar_cursos_encuestas';
        $pagination = $this->template->pagination_data_general($data); //Crear mensaje y links de paginación
        //$pagination = $this->template->pagination_data_buscador_asignar_validador($data); //Crear mensaje y links de paginación
        $links = "<div class='col-sm-5 dataTables_info' style='line-height: 50px;'>" . $pagination['total'] . "</div>
                    <div class='col-sm-7 text-right'>" . $pagination['links'] . "</div>";
//        $datos['lista_docentes_validar'] = $data['lista_docentes_validar'];
        echo $links . $this->load->view('reporte/bonos/tb_result_bnos', $data, TRUE) . $links . '
                <script>
                $("ul.pagination li a").click(function(event){
                    data_ajax(this, "' . $form['form_recurso'] . '", "' . $form['elemento_resultado'] . '");
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

    public function exportar_implementacion() {
        if ($this->input->post()) {
            $data_post = $this->input->post();
//                pr($data_post);
            $data_post['current_row'] = 0;
            unset($data_post['per_page']);
            $data = array();
            $resultado = $this->rbi_mod->get_reporte_bonos_implementacion($data_post);
            $data['total'] = $resultado['total'];
//                pr($data['total']);
            $data['result'] = $resultado['result'];
            $data['result_promedio'] = $resultado['result_promedio']['datos'];
            $data['num_rows'] = $resultado['num_rows'];
            $data['current_row'] = $data_post['current_row'];
//            $data['per_page'] = $data_post['per_page'];
            $data['reglas_evaluacion'] = $this->session->userdata('reglas_evaluacion');

            $filename = "ExportReporteImplementacion_" . date("d-m-Y_H-i-s") . ".xls";
            header("Content-Type: application/vnd.ms-excel; charset=UTF-8;");
//            header("Content-Type: application/octet-stream; charset=UTF-8;");
            header("Content-Encoding: UTF-8");
            header("Content-Disposition: attachment; filename=$filename");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo "\xEF\xBB\xBF"; // UTF-8 BOM
            echo $this->load->view('reporte/bonos/tb_result_bnos', $data, TRUE);
//            $this->load->view('reporte/listado_usuariosrep_xsl', $data);
            //Mostrar resultados
        } else {
            echo data_not_exist('No han sido encontrados datos con los criterios seleccionados. <script> $("#btn_export").hide(); </script>'); //Mostrar mensaje de datos no existentes
        }
    }

}
