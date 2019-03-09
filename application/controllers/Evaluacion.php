<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Muestra listado de usuarios y su prefil a encuestar
 * @version   : 1.0.0
 * @autor     : Christian Garcia
 */
class Evaluacion extends MY_Controller
{
    /**
     * * Carga de clases para el acceso a base de datos y para la creación de elementos del formulario
     * * @access    : public
     * * @modified  :
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Encuestas_model', 'enc_mod');
        $this->load->model('Curso_model', 'cur_mod'); // modelo de cursos
        $this->load->model('Evaluacion_model', 'evaluacion');
        $this->load->library('form_validation'); //implemantación de la libreria form validation
        $this->load->library('form_complete'); // form complete
        $this->config->load('form_validation'); // abrir el archivo general de validaciones
        $this->config->load('general'); // instanciamos el archivo de constantes generales
    }

    public function instrumento_asignado()
    {
        if ($this->input->post())
        {
            $post = $this->input->post(null, true);
            $filtros['encuesta_cve'] = $post['idencuesta'];
            $filtros['course_cve'] = $post['idcurso'];
            $filtros['group_id'] = $post['idgrupo'];
            $filtros['evaluador_user_cve'] = $post['iduevaluador'];
            $filtros['evaluado_user_cve'] = $post['iduevaluado'];
            if (!is_null($this->input->post('grupos_ids_text', true)))
            {
                $filtros['grupos_ids_text'] = $this->input->post('grupos_ids_text', true);
            }
            if (!is_null($this->input->post('des_autoevaluacion_cve', true)))
            {
                $filtros['des_autoevaluacion_cve'] = $post['des_autoevaluacion_cve'];
            }
            $encuestas = $this->evaluacion->get_encuestas_evaluadas($filtros);
            if(!empty($encuestas))
            {
                redirect();
            }else
            {
                $id_instrumento = $post['idencuesta'];
                $datos['instrumento'] = $this->enc_mod->get_instrumento_detalle($id_instrumento);
                $datos['preguntas'] = $this->enc_mod->preguntas_instrumento($id_instrumento);
                $datos['curso'] = $this->cur_mod->listado_cursos(array('cur_id' => $post['idcurso']));
                $datos['boton'] = TRUE;
                $datos['encuesta_cve'] = $post['idencuesta'];
                $datos['evaluado_user_cve'] = $post['iduevaluado'];
                $datos['evaluador_user_cve'] = $post['iduevaluador'];
                $datos['curso_cve'] = $post['idcurso'];
                $datos['des_autoevaluacion_cve'] = isset($post['des_autoevaluacion_cve'])?$post['des_autoevaluacion_cve']:null;
                $datos['grupo_cve'] = $post['idgrupo'];
                if (!is_null($this->input->post('bloque', true)))
                {
                    $datos['bloque'] = $this->input->post('bloque', true);
                }
                if (!is_null($this->input->post('grupos_ids_text', true)))
                {
                    $datos['grupos_ids_text'] = $this->input->post('grupos_ids_text', true);
                }
                $main_contet = $this->load->view('evaluacion/encuesta.tpl.php', $datos, true);
                $this->template->setMainContent($main_contet);
                $this->template->getTemplate();
            }
        } else
        {
            redirect(site_url()); //Redirigir al inicio del sistema si se desea acceder al método mediante una petición normal, no ajax
        }
    }

    public function guardar_encuesta_usuario()
    {
        if ($this->input->post())
        {
            $output['salida'] = array('status' => true, 'errores' => []);
            $post = $this->input->post(null, true);
            $filtros['encuesta_cve'] = $post['idencuesta'];
            $encuestas = $this->evaluacion->get_encuestas_evaluadas($filtros);                    
            $post['regla_evaluacion'] = $this->enc_mod->get_reglas_encuesta($filtros['encuesta_cve'])[0];
            $post['plantilla_preguntas'] = $this->enc_mod->get_preguntas_encuesta($filtros)['data'];
            //pr($post);
            $this->evaluacion->guardar_respuestas($post, $output['salida']);
            //pr($output);
            if ($output['salida']['status']) {
                $datos['tipo_msj'] = $this->config->item('alert_msg')['SUCCESS']['class']; //Selecciona el tipo de mensaje
                $datos['mensaje'] = 'El registro de la evaluación ha sido guardado correctamente';
                $datos['idusuario'] = $post['iduevaluador'];
                $datos['idcurso'] = $post['idcurso'];
                $main_content = $this->load->view('encuesta/final', $datos, true);
                $output['html'] = $main_content;
            }
            echo json_encode($output);
            // $this->output->enable_profiler(true);
        }
    }

    /*
    *   solo utilizo este metodo para pintar en pantalla el codigo que genera CodeIgniter con las estadisitcas de guardar una encuesta
    **/
    private function profiler(){
        $main_content = $this->load->view('evaluacion/profiler.tpl.php', null, true);
        echo $main_content;
    }
}
