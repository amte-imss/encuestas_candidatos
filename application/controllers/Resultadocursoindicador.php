<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase que gestiona el login
 * @version     : 1.0.0
 * @autor       : Pablo José
 */
class Resultadocursoindicador extends MY_Controller
{

    /**
     * * Carga de clases para el acceso a base de datos y para la creación de elementos del formulario
     * * @access        : public
     * * @modified  : 
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->library('form_complete');
        $this->load->library('form_validation');
        $this->load->model('Reporte_model', 'rep_mod'); // modelo de reporte
        $this->load->model('Curso_model', 'cur_mod'); // modelo de cursos
        $this->load->model('Encuestas_model', 'encur_mod'); // modelo de cursos
        $this->load->helper(array('form'));
    }

    public function index($curso = null)
    {
        $this->load->model('Reporte_model', 'rep_mod'); // modelo de reporte
        //Obtiene los filtros para reporte
        $data = $this->rep_mod->get_filtros_generales_reportes();
        //$data['datos_curso'] = $this->cur_mod->listado_cursos(array('cur_id' => $curso));
        //Quitar lo que no se utiliza
        $unset = array('buscar_por');
        foreach ($unset as $k_value)
        {
            unset($data[$k_value]);
        }
        $data['curso'] = $curso;
        $main_contet = $this->load->view('curso/cur_enc_indicador', $data, true);
        $this->template->setMainTitle('Reporte de encuestas por indicador');
        $this->template->setMainContent($main_contet);
        $this->template->getTemplate();
    }

    public function get_data_ajax($current_row = null)
    {
        if ($this->input->is_ajax_request())
        { //Sólo se accede al método a través de una petición ajax
            if ($this->input->post())
            { //Se verifica que se haya recibido información por método post
                $filtros = $this->input->post(null, true);
                $filtros['current_row'] = (isset($current_row) && !empty($current_row)) ? $current_row : 0;
                $data = $filtros;
                $data['current_row'] = $filtros['current_row'];
                $data['curso'] = $filtros['curso'];

                $resultado = $this->encur_mod->get_promedio_encuesta_indicador($filtros); //Datos del formulario se envían para generar la consulta segun los filtros
                //pr($resultado);

                $data['total'] = $resultado['total'];
                $data['registros'] = $resultado['data'];
                $data['indicadores'] = $resultado['indicadores'];
                $data['indicadores_disponibles'] = $resultado['indicadores_disponibles'];
                $data['per_page'] = $this->input->post('per_page');
                $this->listado_resultado($data, array('form_recurso' => '#form_curso', 'elemento_resultado' => '#listado_resultado')); //Generar listado en caso de obtener datos
            } else
            {

                redirect(site_url()); //Redirigir al inicio del sistema si se desea acceder al método mediante una petición normal, no ajax
            }
        } else
        {

            redirect(site_url()); //Redirigir al inicio del sistema si se desea acceder al método mediante una petición normal, no ajax
        }
    }

    private function listado_resultado($data, $form)
    {
        $data['controller'] = 'resultadocursoindicador';
        $data['action'] = 'get_data_ajax/';
        $data['encuestacve'] = 0;

        $pagination = $this->template->pagination_data_general($data); //Crear mensaje y links de paginación
        //$links = "<div class='col-sm-5 dataTables_info' style='line-height: 50px;'>".$pagination['total']."</div><div class='col-sm-7 text-right'>".$pagination['links']."</div>";
        $links = "<div class='col-sm-5 dataTables_info' style='line-height: 50px;'>" . $pagination['total'] . "</div>
                <div class='col-sm-7 text-right'>" . $pagination['links'] . "</div>";
        echo $links . $this->load->view('curso/listado_indicador', $data, TRUE) . $links . '
            <script>
            $("ul.pagination li a").click(function(event){
                data_ajax($(this).attr("href"), "' . $form['form_recurso'] . '", "' . $form['elemento_resultado'] . '");
                event.preventDefault();
            });
            </script>';
    }

    private function lista_anios()
    {
        $anios = $this->rep_mod->get_anios();
        foreach ($anios as $key => $value)
        {
            $anios[] = array('anio_id' => $value['fecha'], 'anio_desc' => $value['fecha']);
        }
        return $anios;
    }

    public function export_data($curso = null)
    {
        if ($this->input->post())
        {
            $filtros = $this->input->post(null, true);
            $data = $filtros;
            $data['curso'] = $filtros['curso'];

            $resultado = $this->encur_mod->get_promedio_encuesta_indicador($filtros); //Datos del formulario se envían para generar la consulta segun los filtros
            //pr($resultado);

            $data['total'] = $resultado['total'];
            $data['registros'] = $resultado['data'];
            $data['indicadores'] = $resultado['indicadores'];
            $data['indicadores_disponibles'] = $resultado['indicadores_disponibles'];

            if ($data['total'] > 0)
            {
                //$this->listado_resultado($data_sesiones, array('form_recurso'=>'#form_buscador', 'elemento_resultado'=>'#listado_resultado')); //Generar listado en caso de obtener datos
                $filename = "Export_" . date("d-m-Y_H-i-s"). ".xls";
                header("Content-Type: application/vnd.ms-excel");
                header("Content-Disposition: attachment; filename=$filename");
                header("Pragma: no-cache");
                header("Expires: 0");
                echo $this->load->view('curso/listado_indicador', $data, TRUE);
            } else
            {
                echo data_not_exist('No han sido encontrados datos con los criterios seleccionados. <script> $("#btn_export").hide(); </script>'); //Mostrar mensaje de datos no existentes
            }
        }
    }

}
