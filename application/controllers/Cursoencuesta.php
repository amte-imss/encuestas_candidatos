<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase que gestiona el login
 * @version     : 1.0.0
 * @autor       : Pablo José
 */
class Cursoencuesta extends MY_Controller {

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

    public function get_data_ajax($curso = null, $current_row = null) {
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
                    //$data['bactiva']=0;
                    //pr($filtros);
                    //Checar el tipo de curso
                    $datos_curso = $this->cur_mod->listado_cursos(array('cur_id' => $curso));

                    //pr($datos_curso);

                    $filtros['tutorizado'] = $datos_curso['data'][0]['tutorizado'];


                    if (isset($filtros['btn_submit'])) {
                        $data['error'] = 'Boton';
                    }

                    if (isset($filtros['encuestacve'])) {
                        //pr('hola');
                        //pr($data['encuestacve']);
                        $resultfinal = $this->guardar_asociacion($data['encuestacve'], $curso);
                        //pr($resultfinal);
                        if ($resultfinal['status'])
                        {
                            $this->session->set_flashdata('success', 'Los instrumentos seleccionados han sido asignados correctamente'); // devuelve mensaje flash
                        }else
                        {
                            $this->session->set_flashdata('danger', $resultfinal['msg']); // devuelve mensaje flash
                        }
                    }


                    $resultado = $this->encur_mod->listado_encuestas_curso($filtros); //Datos del formulario se envían para generar la consulta segun los filtros
                    //pr($resultado);
                    $data['total_empleados'] = $resultado['total'];
                    $data['empleados'] = $resultado['data'];
                    $data['modulos_acceso'] = $this->get_modulos_habilitados();


                    //$data['bactivo']=$filtros['bactivo'];
                    //pr($data);
                    //pr($data);
                    /* if(($data['bactiva'] == 1) && empty($data['encuestacve']))
                      {
                      $data['error']='Debe seleccionar al menos una encuesta a asignar';
                      }
                      else if(($data['bactiva'] == 1) && isset($data['encuestacve']))
                      {
                      $data['error']='hacer algo';
                      }
                      else {
                      $data['error']=$error;
                      //$data['bactivo']=0;
                      }
                     */

                    $this->listado_resultado($data, array('form_recurso' => '#form_curso', 'elemento_resultado' => '#listado_resultado')); //Generar listado en caso de obtener datos
                }
            } else {
                redirect(site_url()); //Redirigir al inicio del sistema si se desea acceder al método mediante una petición normal, no ajax
            }
        } else {

            redirect(site_url()); //Redirigir al inicio del sistema si se desea acceder al método mediante una petición normal, no ajax
        }
    }

    private function listado_resultado($data, $form) {
        echo $data['error'] . '<br>';
        $data['encuestacve'] = 0;


        $pagination = $this->template->pagination_data_enc_curso($data); //Crear mensaje y links de paginación
        $links = "<div class='col-sm-5 dataTables_info' style='line-height: 50px;'>" . $pagination['total'] . "</div>
                <div class='col-sm-7 text-right'>" . $pagination['links'] . "</div>";
        echo $links . $this->load->view('curso/listado_enccursos', $data, TRUE) . $links . '
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

    public function curso_encuesta($curso = null) {


        $anios = $this->lista_anios(2009, date('Y'));
//        $rol = $this->config->item('rol_docente');
        $datos_curso = $this->cur_mod->listado_cursos(array('cur_id' => $curso));
        $data['anios'] = dropdown_options($anios, 'anio_id', 'anio_desc');
//        $datos['order_columns'] = array('descrip' => 'Descripción', 'encuestaclavecorta' => 'Clave encuesta');
        $data['curso'] = $curso;
        $data['datos_curso'] = $datos_curso;
        $data['modulos_acceso'] = $this->get_modulos_habilitados();
        $main_contet = $this->load->view('curso/curso_encuesta', $data, true);
        $this->template->setMainContent($main_contet);
        $this->template->getTemplate();
    }

    private function guardar_asociacion($encuestacve = array(), $curso) {
        $this->load->model('Encuestas_model', 'encur_mod');

        // if ($this->input->post()) {
        /* var_dump($this->input->post('encuestacve'));
          var_dump($this->input->post('curso'));
          $encuesta= $this->input->post('encuestacve');
          $curso=$this->input->post('curso'); */
        //pr($encuestacve);
        $insertar = $this->encur_mod->insertar_asoc($encuestacve, $curso);
        // pr($insertar);

        return $insertar;
        /* }
          else
          {
          $data['error']="No hubo seleccion"; //mensaje de error en ventana pop up
          } */
    }

    public function desasociar_instrumento($id_instrumento = null, $id_curso = null) {
        if ($this->input->is_ajax_request()) {

            if ((isset($id_instrumento) && !empty($id_instrumento)) || (isset($id_curso) && !empty($id_curso))) {

                // var_dump($id_instrumento);
                // var_dump($id_curso);
                $datos = array();
                $result_desasociar = $this->encur_mod->desasociar_instrumento($id_instrumento, $id_curso);
                if ($result_desasociar == true) {
                    //echo "Ok";
                    $this->session->set_flashdata('success', 'El instrumento ha sido desasociado del curso correctamente'); // devuelve mensaje flash
                } else {
                    $this->session->set_flashdata('danger', 'El instrumento no puede ser desasociado porque tiene histórico'); // devuelve mensaje flash
                }
                echo '
                        <script type="text/javascript">
                            data_ajax(site_url+"/cursoencuesta/get_data_ajax/' . $id_curso . '", "#form_curso", "#listado_resultado");
                        </script>
                    ';
            }
        } else {
            redirect(site_url('encuestas'));
        }
    }

}
