<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase que muestra información (porcentaje general y datos de las implementaciones) almacenadas en la base de datos, mostrará cálculos considerando si la pregunta aplica para bono o no.
 * @version 	: 1.0.0
 * @autor 	: JZDP
 */
class Reporte_general extends MY_Controller 
{
    /**
     * Carga de clases para el acceso a base de datos y para la creación de elementos del formulario
     */
    public function __construct() 
    {
        parent::__construct();

        $this->load->database();
        $this->load->library('form_complete'); //Carga elementos que permite la creación de formularios
        $this->load->library('form_validation'); //Carga funciones de validación
        $this->load->model('Reporte_general_model', 'rep_gen_mod'); // modelo de reporte
    }
    
    /**
     * Muestra los filtros correspondientes al reporte general. No muestra datos del evaluado y evaluador, solo del curso.
     */
    public function index() 
    {
        $reglas_evaluacion = $this->rep_mod->get_lista_roles_regla_evaluacion('roles', 'excepcion'); //Agregar reglas de evaluación a sesión, para ser utilizadas en la muestra de resultados
        $this->session->set_userdata('reglas_evaluacion', $reglas_evaluacion);
        
        $main_content = $this->filtrosreportes_tpl->getCuerpo(FiltrosReportes_Tpl::RB_GENERAL, array('js' => array('reporte_general.js')));
        $this->template->setMainTitle("General");
        $this->template->setMainContent($main_content);
        $this->template->getTemplate();
    }
    
    /**
     * Método que recibe una petición ajax para obtener los porcentajes generales de las encuestas de acuerdo a los filtros seleccionados por el usuario
     * @param integer $current_row Dato utilizado para la paginación. Límite inicial del cual se van a mostrar los registros.
     * @return html Tabla conteniendo los resultados de la búsqueda
     */
    public function get_reporte_general_datos($current_row = null)
    {
        if (!$this->input->is_ajax_request()) //Sólo se accede al método a través de una petición ajax
        {
            redirect(site_url()); //Redirigir al inicio del sistema si se desea acceder al método mediante una petición normal, no ajax
        }
        if (!is_null($this->input->post())) //Se verifica que se haya recibido información por método post
        {
            $filtros = $this->input->post(null, true); //Se obtienen datos enviados por POST, se limpian los valores con el parámetro TRUE
            $filtros['current_row'] = (isset($current_row) && !empty($current_row)) ? $current_row : 0;
            $data = array();
            $resultado = $this->rep_gen_mod->get_reporte_general_datos($filtros); //Datos del formulario se envían para generar la consulta según los filtros seleccionados
            
            $data['total_empleados'] = $resultado['total'];
            $data['datos'] = $resultado['data'];
            $data['reglas_evaluacion'] = $this->session->userdata('reglas_evaluacion'); //Obtener de sesión
            $data['result_promedio'] = $resultado['promedio'];
            $data['current_row'] = $filtros['current_row'];
            $data['per_page'] = $filtros['per_page'];
            //pr($data);
            $c_r = $this->filtrosreportes_tpl->getArrayVistasReportes(FiltrosReportes_Tpl::RB_GENERAL); //Configuracion del reporte
            $this->listado_resultado($data, array('form_recurso' => $c_r[FiltrosReportes_Tpl::C_NAME_FORMULARIO], 'elemento_resultado' => '#listado_resultado')); //Generar listado en caso de obtener datos. Mostrar resultados
        }
    }
    
    /**
     * Método que generá la paginación y el contenedor de la tabla resultante. Así como el método que agrega funcionalidad a las ligas de la paginación.
     * @param array $data Datos de la consulta y datos necesarios para obtener la paginación.
     * @param array $form Datos enviados del formulario. Como nombre del formulario, nombre del elemento donde se mostrará el resultado, entre otros.
     * @return html Tabla html conteniendo los resultados de la búsqueda
     */
    private function listado_resultado($data, $form) 
    {
        $links = "";
        if (!isset($data['export']) || (isset($data['export']) && $data['export'] == FALSE)) 
        {
            $pagination = $this->template->pagination_data_empleado($data, array('reporte_general', 'get_reporte_general_datos')); //Crear mensaje y links de paginación
            if ($data['total_empleados'] > 0)
            {
                $links = "<div class='col-sm-5 dataTables_info' style='line-height: 50px;'>" . $pagination['total'] . "</div>
                    <div class='col-sm-7 text-right'>" . $pagination['links'] . "</div>";
                
            }
            echo '<script>
                $( document ).ready(function() {
                    $("ul.pagination li a").click(function(event){
                        data_ajax(this, "' . $form['form_recurso'] . '", "' . $form['elemento_resultado'] . '");
                        event.preventDefault();
                    });
                });
            </script>';
        }
        echo $links . $this->load->view('reporte/general/listado_resultado', $data, TRUE) . $links;
    }
    
    /**
     * Método exporta los porcentajes generales de las encuestas de acuerdo a los filtros seleccionados por el usuario.
     * @return xls Archivo con extensión xls, conteniendo los resultados de la búsqueda.
     */
    public function exportar_reporte_general()
    {
        
        if (!is_null($this->input->post())) //Se verifica que se haya recibido información por método post
        {
            $filtros = $this->input->post(null, true); //Se obtienen datos enviados por POST, se limpian los valores con el parámetro TRUE
            $data = array();
            $data['current_row'] = $filtros['current_row'] = 0;
            $filtros['export'] = TRUE;
            $resultado = $this->rep_gen_mod->get_reporte_general_datos($filtros); //Datos del formulario se envían para generar la consulta según los filtros seleccionados
            
            $data['total_empleados'] = $resultado['total'];
            $data['datos'] = $resultado['data'];
            $data['reglas_evaluacion'] = $this->session->userdata('reglas_evaluacion'); //Obtener de sesión
            $data['result_promedio'] = $resultado['promedio'];
            //pr($data);
            
            $filename = "ExportReporteGeneral_" . date("d-m-Y_H-i-s") . ".xls";
            header("Content-Type: application/vnd.ms-excel; charset=UTF-8;");
            header("Content-Encoding: UTF-8");
            header("Content-Disposition: attachment; filename=$filename");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo "\xEF\xBB\xBF"; // UTF-8 BOM
            echo $this->load->view('reporte/general/listado_resultado', $data, TRUE);
        }
    }
}