<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase que gestiona el login
 * @version 	: 1.0.0
 * @autor 		: Pablo José
 */
class Encuestas extends MY_Controller {

    /**
     * * Carga de clases para el acceso a base de datos y para la creación de elementos del formulario
     * * @access 		: public
     * * @modified 	:
     */
    public function __construct() {
        parent::__construct();

        $this->load->database();
        $this->load->library('form_validation'); //implemantación de la libreria form validation
        $this->load->library('form_complete'); // form complete
        $this->config->load('form_validation'); // abrir el archivo general de validaciones
        $this->config->load('general'); // instanciamos el archivo de constantes generales
        $this->load->model('Encuestas_model', 'enc_mod');
        $this->load->model('Curso_model', 'cur_mod');
        $this->load->library('csvimport');
    }

    public function index() {

        //$modulos_acceso = $this->session->userdata("modulos_acceso");
        $modulos_acceso = $this->get_modulos_habilitados();
//        pr($modulos_acceso);
        $datos['encuestas'] = $this->enc_mod->listado_instrumentos();
        $datos['secciones_acceso'] = $modulos_acceso;

        $main_contet = $this->load->view('encuesta/encuestas', $datos, true);
        $this->template->setMainContent($main_contet);
        $this->template->getTemplate();

    }

    public function cargar_instrumento() {
        if ($this->input->post()) {     // SI EXISTE UN ARCHIVO EN POST
            $this->carga_csv_datos();
        }else{
            $datos = [];
            $main_contet = $this->load->view('encuesta/carga_encuestas', $datos, true);
            $this->template->setMainTitle('Cargar instrumento por archivo CSV');
            $this->template->setMainContent($main_contet);
            $this->template->getTemplate();
        }
    }

    private function carga_csv_datos() {
        $this->load->model('Catalogos_model', 'catalogo');
        $this->load->model('CSV_Encuestas_model', 'csv_model');
        $output = [];
        $config['upload_path'] = './uploads/';      // CONFIGURAMOS LA RUTA DE LA CARGA PARA LA LIBRERIA UPLOAD
        $config['allowed_types'] = 'csv';           // CONFIGURAMOS EL TIPO DE ARCHIVO A CARGAR
        $config['max_size'] = '1000';               // CONFIGURAMOS EL PESO DEL ARCHIVO

        $this->load->library('upload', $config);    // CARGAMOS LA LIBRERIA UPLOAD
        if (!$this->upload->do_upload())
        {
            // SI EL PROCESO DE CARGA ENCONTRO UN ERROR
            $output['status']['status'] = false;
            $output['status']['msg'] = 'Ocurrió un error al cargar el instrumento';
            $output['error_upload']['carga_csv'] = $this->upload->display_errors();      // CARGAR EN LA VARIABLE ERROR LOS ERRORES ENCONTRADOS
        } else
        {                      // SI NO SE ENCONTRARON ERRORES EN EL PROCES
            $file_data = $this->upload->data();     //BUSCAMOS LA INFORMACIÓN DEL ARCHIVO CARGADO
            $file_path = './uploads/' . $file_data['file_name'];         // CARGAMOS LA URL DEL ARCHIVO
            $csv_array = $this->csvimport->get_array($file_path);   //SI EXISTEN DATOS, LOS CARGAMOS EN LA VARIABLE
            $output['status'] = $this->csv_model->guarda_encuesta($csv_array);
            $output['csv'] = $csv_array;
            unlink($file_path);
        }
        // pr($output);
        $output['mensajes'] = $tipo_msg = $this->config->item('alert_msg');
        $main_content = $this->load->view('encuesta_v2/carga_csv.tpl.php', $output, true);
        $this->template->setMainContent($main_content);
        $this->template->getTemplate();
        // $this->output->enable_profiler(true);
    }

    public function ordenar_preguntas($id_instrumento = null, $seccion = null) {
        if (isset($id_instrumento) && !empty($id_instrumento)) {
            $datos = array();
            $busqueda = array('encuesta_cve' => $id_instrumento, 'seccion_cve' => $seccion);
            $datos['instrumento'] = $id_instrumento;
            $datos['preguntas'] = $this->enc_mod->get_preguntas_encuesta($busqueda);
            $main_contet = $this->load->view('encuesta/lista_preguntas', $datos, true);
            $this->template->setMainContent($main_contet);
            $this->template->getTemplate();
        }
    }

    public function ajax_orden() {
        if ($this->input->is_ajax_request()) { //Sólo se accede al método a través de una petición ajax
            if (!is_null($this->input->post())) { //Se verifica que se haya recibido información por método post
                $preguntas_ordenadas = $_POST['pregunta'];

                $pos = 1;
                $orden_preguntas = array();
                foreach ($preguntas_ordenadas as $key) {
                    $orden_preguntas[] = array('preguntas_cve' => $key, 'orden' => $pos);

                    $pos++;
                }

                $guardado_orden = $this->enc_mod->guarda_orden_preguntas($orden_preguntas);

                $this->config->load('general');
                $tipo_msg = $this->config->item('alert_msg');

                if ($guardado_orden == TRUE) {
                    echo html_message("El orden de las preguntas se ha actualizado", $tipo_msg['SUCCESS']['class']);
                } else {
                    echo html_message("No se ha podido actualizar el orden de las preguntas", $tipo_msg['WARNING']['class']);
                }
            }
        }
    }

    public function edita_instrumento($id_instrumento = null) {
        if (isset($id_instrumento) && !empty($id_instrumento)) {

            $tiene_evaluaciones = $this->enc_mod->tiene_evaluaciones($id_instrumento);

            $arre = $this->config->item('EVA_TIPO');
            foreach ($arre as $key => $value) {
                $arrol[$value['valor']] = $value['text'];
            }



            $datos = array();
            if (isset($tiene_evaluaciones[0]['tiene_evaluacion']) && $tiene_evaluaciones[0]['tiene_evaluacion'] == 0) {
                $reglas = $this->enc_mod->get_reglas_evaluacion();
                $datos['reglas_evaluacion'] = dropdown_options($reglas, 'reglas_evaluacion_cve', 'nom_regla_desc');
                $datos['instrumento'] = $this->enc_mod->get_instrumento_detalle($id_instrumento);
                $datos['tipo_instrumento'] = $this->config->item('TIPO_INSTRUMENTOV');
                $datos['eva_tipo'] = $arrol;


                if ($this->input->post()) {
                    /*
                      [is_bono] => 1
                      [status] => 1
                      [descripcion_encuestas] => Encuesta ccttna prueba 2016
                      [cve_corta_encuesta] => CCTTNA2016
                      [regla_evaluacion_cve] => 1
                      [btn_submit] => Guardar instrumento

                     */
                    //pr($_POST);
                    $this->load->library('form_validation');

                    //
                    //$this->form_validation->set_data($campos_pregunta);

                    $validations = $this->config->item('edita_instrumento');

                    //pr($validations);
                    //echo"estamos aqui";
                    $this->form_validation->set_rules($validations);

                    if ($this->form_validation->run() == TRUE) { //Se ejecuta la validación de datos
                        $campos_edita = $this->input->post(null, true);
                        $resultEdit = $this->enc_mod->guarda_edita_instrumento($id_instrumento, $campos_edita);

                        if ($resultEdit == true) {
                            $this->session->set_flashdata('success', 'El instrumento ha sido modificado correctamente'); // devuelve mensaje flash
                        } else {
                            /* falta mensaje de que no fue actualizado */
                        }
                    }
                }
                //edit
                //pr($datos);
                $main_contet = $this->load->view('encuesta/edita_instrumento', $datos, true);
                $this->template->setMainTitle('Editar instrumento');
                $this->template->setMainContent($main_contet);
                $this->template->getTemplate();
            } else {
                $this->session->set_flashdata('warning', 'No puede editar el instrumento ya que tiene historial'); // devuelve mensaje flash
                redirect(site_url('encuestas'));
            }
        }
    }

    public function drop_instrumento($id_instrumento = null) {
        if ($this->input->is_ajax_request()) {

            if (isset($id_instrumento) && !empty($id_instrumento)) {
                //$datos=array();
                $tiene_evaluaciones = $this->enc_mod->tiene_evaluaciones($id_instrumento);

                //pr($tiene_evaluaciones);
                //exit();
                if (isset($tiene_evaluaciones[0]['tiene_evaluacion']) && $tiene_evaluaciones[0]['tiene_evaluacion'] == 0) {

                    if ($this->enc_mod->drop_instrumento($id_instrumento)) {
                        $this->session->set_flashdata('success', 'El instrumento ha sido eliminado correctamente'); // devuelve mensaje flash
                    }
                } else {
                    $this->session->set_flashdata('warning', 'No puede eliminar el instrumento ya que tiene historial'); // devuelve mensaje flash
                }

                echo '
                <script type="text/javascript">
                    data_ajax(site_url + "/encuestas/get_encuestas_ajax", "#form_listado_encuestas", "#listado_resultado");
                </script>
                ';
                //$datos['encuestas'] = $this->enc_mod->listado_instrumentos();
                //redirect(site_url('encuestas'));
            }
        } else {
            redirect(site_url());
        }
    }

    public function delete_data_ajax_pregunta($pregunta_cve = null, $encuesta_cve = null) {
        if ($this->input->is_ajax_request()) {
            if (isset($pregunta_cve) && !empty($pregunta_cve)) {
                $drop_pregunta = $this->enc_mod->drop_pregunta($pregunta_cve);

                if ($drop_pregunta == TRUE) {
                    $this->session->set_flashdata('success', 'La pregunta ha sido eliminada'); // devuelve mensaje flash
                }

                $datos['instrumento'] = $this->enc_mod->get_instrumento_detalle($encuesta_cve);
                $datos['preguntas'] = $this->enc_mod->preguntas_instrumento($encuesta_cve);

                echo $this->load->view('encuesta/encuesta_preguntas', $datos, true);
            }
        }
    }

    public function block_instrumento($id_instrumento = null) {
        if ($this->input->is_ajax_request()) {

            if (isset($id_instrumento) && !empty($id_instrumento)) {
                //$datos=array();
                $result_block = $this->enc_mod->block_instrumento($id_instrumento);
                if ($result_block == true) {
                    //echo "Ok";
                    $this->session->set_flashdata('success', 'El instrumento ha sido desactivado correctamente'); // devuelve mensaje flash
                } else {
                    // error desconocido, no se pudo desactivar la encuesta
                }
                echo '
                        <script type="text/javascript">
                            data_ajax(site_url + "/encuestas/get_encuestas_ajax", "#form_listado_encuestas", "#listado_resultado");
                        </script>
                    ';
            }
        } else {
            redirect(site_url('encuestas'));
        }
    }

    public function unlock_instrumento($id_instrumento = null) {
        if ($this->input->is_ajax_request()) {

            if (isset($id_instrumento) && !empty($id_instrumento)) {
                //$datos=array();
                $result_block = $this->enc_mod->unlock_instrumento($id_instrumento);
                if ($result_block == true) {
                    //echo "Ok";
                    $this->session->set_flashdata('success', 'El instrumento ha sido activado correctamente'); // devuelve mensaje flash
                } else {
                    // error desconocido, no se pudo desactivar la encuesta
                }
                echo '
                        <script type="text/javascript">
                            data_ajax(site_url + "/encuestas/get_encuestas_ajax", "#form_listado_encuestas", "#listado_resultado");
                        </script>
                    ';
            }
        } else {
            redirect(site_url('encuestas'));
        }
    }

    public function edita_pregunta($id_pregunta = null, $id_instrumento = null, $fromNueva = false) {
        if (isset($id_pregunta) && !empty($id_pregunta)) {

            $tiene_evaluaciones = $this->enc_mod->tiene_evaluaciones($id_instrumento);

            $datos = array();

            if (isset($tiene_evaluaciones[0]['tiene_evaluacion']) && $tiene_evaluaciones[0]['tiene_evaluacion'] == 0) {

                $datos = array('preguntas_cve' => $id_pregunta, 'encuesta_cve' => $id_instrumento);

                $datos['pregunta'] = $this->enc_mod->get_pregunta_detalle($id_pregunta, $id_instrumento);
                if (!isset($datos['pregunta'][0])) {
                    $this->session->set_flashdata('warning', 'No se han encontrado los datos solicitados'); // devuelve mensaje flash
                    redirect(site_url('encuestas'));
                }
                $datos['tipo_pregunta'] = $this->enc_mod->get_tipo_pregunta();

                $secciones = $this->enc_mod->get_secciones();
                $datos['secciones'] = dropdown_options($secciones, 'seccion_cve', 'descripcion');

                $indicadores = $this->enc_mod->get_indicadores();
                $datos['indicadores'] = dropdown_options($indicadores, 'indicador_cve', 'descripcion');

                $preguntas_padre = $this->enc_mod->listado_preguntas_seccion($id_instrumento, $datos['pregunta'][0]['seccion_cve'], $id_pregunta);
                $datos['preguntas_padre'] = dropdown_options($preguntas_padre, 'preguntas_cve', 'pregunta');

                if ($this->input->post() && $fromNueva == false) {

                    /*
                      $datos=array(
                      'seccion_cve'=>$params['seccion_cve'],
                      'tipo_pregunta_cve'=>$params['tipo_pregunta_cve'],
                      'pregunta'=>$params['pregunta'],
                      'obligada'=>$params['obligada'],
                      'is_bono'=>$params['is_bono'],
                      'pregunta_padre'=>$params['pregunta_padre'],
                      'val_ref'=>$params['val_ref'],
                      );
                     */

                    /*
                     *  [seccion_cve] => 56
                      [pregunta] => En caso de problema de acceso se comunicó por correo electrónico o vía telefónica a mesa de ayuda
                      [is_bono] => 1
                      [obligada] => 1
                      [no_obligatoria] => 1
                      [tipo_pregunta_radio] => 2
                     *
                     */


                    $this->load->library('form_validation');

                    //
                    //$this->form_validation->set_data($campos_pregunta);

                    $validations = $this->config->item('edit_pregunta');

                    //pr($validations);
                    //echo"estamos aqui";
                    $this->form_validation->set_rules($validations);

                    if ($this->form_validation->run() == TRUE) { //Se ejecuta la validación de datos
                        $this->config->load('general');
                        $respuestas = $this->config->item('ENCUESTAS_RESPUESTAS_PREGUNTA');

                        $campos_pregunta = $this->input->post(null, true);
                        //pr($campos_pregunta);
                        $tipos_pregunta = array(
                            1 => array('id' => 1, 'descripcion' => 'si|no'),
                            2 => array('id' => 3, 'descripcion' => 'siempre|nunca'),
                            3 => array('id' => 5, 'descripcion' => 'respuesta abierta'),
                        );

                        $pregunta_tipo_opcion = $tipos_pregunta[$campos_pregunta['tipo_pregunta']]['id'];
                        $no_obligatoria = isset($campos_pregunta['no_obligatoria']) ? $campos_pregunta['no_obligatoria'] : 0;
                        $tipo_pregunta = ($pregunta_tipo_opcion + $no_obligatoria);
                        $is_bono = isset($campos_pregunta['is_bono']) ? $campos_pregunta['is_bono'] : 0;
                        $campos_pregunta['tipo_pregunta_cve'] = $tipo_pregunta;
                        $campos_pregunta['respuestas'] = $respuestas[$tipo_pregunta];
                        $campos_pregunta['pregunta_anterior'] = $datos['pregunta'];
                        $campos_pregunta['encuesta_cve'] = $id_instrumento;
                        /*
                          pr('[CH][Encuesstas][edita_pregunta]campos_pregunta: ');
                          pr($campos_pregunta);
                         *
                         */
                        $guardar_cambios = $this->enc_mod->update_pregunta($id_pregunta, $campos_pregunta);

                        if ($guardar_cambios == true) {
                            $this->session->set_flashdata('success', 'La pregunta ha sido modificada correctamente'); // devuelve mensaje flash
                            $datos['pregunta'][0]['tipo_pregunta_cve'] = $tipo_pregunta;
                            $datos['pregunta'][0]['obligada'] = $no_obligatoria;
                            $datos['pregunta'][0]['is_bono'] = $is_bono;
                        }
                    } else {
                        // pr('[CH][Encuesstas][edita_pregunta]error en la validacion ');
                        // pr($this->form_validation->error_array());
                    }
                }

                $main_contet = $this->load->view('encuesta/edita_pregunta', $datos, true);
                $this->template->setMainContent($main_contet);
                $this->template->getTemplate();
            } else {
                $this->session->set_flashdata('warning', 'No puede editar el instrumento ya que tiene historial'); // devuelve mensaje flash
                redirect(site_url('encuestas'));
            }
        }
    }

    public function nueva_pregunta($id_instrumento = null) {
        if (isset($id_instrumento) && !empty($id_instrumento)) {

            $tiene_evaluaciones = $this->enc_mod->tiene_evaluaciones($id_instrumento);

            $datos = array();

            if (isset($tiene_evaluaciones[0]['tiene_evaluacion']) && $tiene_evaluaciones[0]['tiene_evaluacion'] == 0) {

                $datos = array('encuesta_cve' => $id_instrumento);

                $datos['tipo_pregunta'] = $this->enc_mod->get_tipo_pregunta();
                $secciones = $this->enc_mod->get_secciones();
                $datos['secciones'] = dropdown_options($secciones, 'seccion_cve', 'descripcion');


                $indicadores = $this->enc_mod->get_indicadores();
                $datos['indicadores'] = dropdown_options($indicadores, 'indicador_cve', 'descripcion');

                if ($this->input->post()) {

                    /*
                      validaciones
                     */
                    /*
                     * [seccion_cve] => 164
                     * [pregunta] => zckcvbxcn
                      [is_bono] => 1
                      [obligada] => 1
                      [no_obligatoria] => 1
                      [tipo_pregunta_radio] => 1
                      [btn_submit] => Guardar pregunta
                     */
                    /**/

                    $this->load->library('form_validation');

                    //
                    //$this->form_validation->set_data($campos_pregunta);

                    $validations = $this->config->item('nueva_pregunta');

                    //pr($validations);
                    //echo"estamos aqui";
                    $this->form_validation->set_rules($validations);

                    if ($this->form_validation->run() == TRUE) { //Se ejecuta la validación de datos

                        $campos_pregunta = $this->input->post(null, true);
                        //pr($campos_pregunta);
                        $this->config->load('general');
                        $respuestas = $this->config->item('ENCUESTAS_RESPUESTAS_PREGUNTA');

                        $seccion_id = $campos_pregunta['seccion_cve'];


                        $tipos_pregunta = array(
                            1 => array('id' => 1, 'descripcion' => 'si|no'),
                            2 => array('id' => 3, 'descripcion' => 'siempre|nunca'),
                            3 => array('id' => 5, 'descripcion' => 'respuesta abierta'),
                        );
                        /*
                          iinvestigaa -> valores por default para un arreglo (renviar datos de que no existe la variable solicitada dinamicamente)
                         */
                        $pregunta_radio = $tipos_pregunta[$campos_pregunta['tipo_pregunta']]['id'];
                        $no_obligatoria = isset($campos_pregunta['no_obligatoria']) ? $campos_pregunta['no_obligatoria'] : 0;
                        $tipo_pregunta = ($pregunta_radio + $no_obligatoria);
                        $campos_pregunta['tipo_pregunta_cve'] = $tipo_pregunta;
                        $pregunta['respuestas'] = $respuestas[$tipo_pregunta];

                        $pregunta['tipo_indicador_cve'] = $campos_pregunta['tipo_indicador_cve'];
                        $pregunta['tipo_pregunta']['tipo_pregunta_cve'] = $campos_pregunta['tipo_pregunta_cve'];
                        $pregunta['pregunta'] = $campos_pregunta['pregunta'];
                        $pregunta['pregunta_obligada'] = isset($campos_pregunta['obligada']) ? $campos_pregunta['obligada'] : 0;
                        $pregunta['pregunta_bono'] = isset($campos_pregunta['is_bono']) ? $campos_pregunta['is_bono'] : 0;
                        //pr($pregunta);
                        /**/
                        $nuevaPreguntaRes = $this->enc_mod->guarda_nueva_pregunta($pregunta, $id_instrumento, $seccion_id);

                        if (isset($nuevaPreguntaRes['success']) && $nuevaPreguntaRes['success'] == TRUE) {
                            $this->session->set_flashdata('success', 'La pregunta ha sido guardada correctamente'); // devuelve mensaje flash
                            $this->edita_pregunta($nuevaPreguntaRes['id_pregunta'], $id_instrumento, true);
                        } else {
                            // mensaje de error
                        }
                    }
                    //pr($_POST);
                } else {
                    $main_contet = $this->load->view('encuesta/nueva_pregunta', $datos, true);
                    $this->template->setMainContent($main_contet);
                    $this->template->getTemplate();
                }
            } else {
                $this->session->set_flashdata('warning', 'No puede editar el instrumento ya que tiene historial'); // devuelve mensaje flash
                redirect(site_url('encuestas'));
            }
        }
    }

    /* public function respuestas_pregunta_padre($pregunta_cve=null)
      {
      ///
      } */

    public function prev($id_instrumento = null) {
        if (isset($id_instrumento) && !empty($id_instrumento)) {
            # code...
            $datos['instrumento'] = $this->enc_mod->get_instrumento_detalle($id_instrumento);
            $datos['preguntas'] = $this->enc_mod->preguntas_instrumento($id_instrumento);
            $main_contet = $this->load->view('encuesta/prev', $datos, true);
            $this->template->setMainTitle('Información de encuesta');
            $this->template->setMainContent($main_contet);
            $this->template->getTemplate();
        }
    }

    public function copy($id_instrumento = null) {
        if ($this->input->is_ajax_request()) {
            if (isset($id_instrumento) && !empty($id_instrumento)) {

                $tiene_evaluaciones = $this->enc_mod->tiene_evaluaciones($id_instrumento);
                //pr($tiene_evaluaciones);

                $datos = array();

                $copiado = $this->enc_mod->duplica_instrumento($id_instrumento);

                if (isset($copiado['success']) && $copiado['success'] == TRUE) {
                    //$this->session->set_flashdata('success', 'El instrumento ha sido duplicado correctamente'); // devuelve mensaje flash
                    //redirect(site_url('encuestas/edit/'.$instrumento_id,'refresh'));
                    echo html_message("El instrumento ha sido duplicado correctamente", 'success');
                    echo "<script type='text/javascript'>
                        window.location.assign('" . site_url('encuestas/edit/' . $copiado['instrumento_id']) . "');
                        </script>

                        ";
                    exit();
                } else {
                    $this->session->set_flashdata('warning', 'Error desconocido, no es posible duplicar el instrumento, por favor notifiquelo al área correspondiente'); // devuelve mensaje flash
                    redirect(site_url('encuestas'));
                }
            }
        } else {
            redirect(site_url('encuestas'));
        }
    }

    public function edit($id_instrumento = null) {
        if (isset($id_instrumento) && !empty($id_instrumento)) {
            # code...
            $tiene_evaluaciones = $this->enc_mod->tiene_evaluaciones($id_instrumento);

            $datos = array();

            if (isset($tiene_evaluaciones[0]['tiene_evaluacion']) && $tiene_evaluaciones[0]['tiene_evaluacion'] == 0) {

                $datos['instrumento'] = $this->enc_mod->get_instrumento_detalle($id_instrumento);
                $datos['preguntas'] = $this->enc_mod->preguntas_instrumento($id_instrumento);
                $main_contet = $this->load->view('encuesta/prev_instrumento_edit', $datos, true);
                $this->template->setMainTitle('Editar encuesta');
                $this->template->setMainContent($main_contet);
                $this->template->getTemplate();
            } else {
                $this->session->set_flashdata('warning', 'No puede editar el instrumento ya que tiene historial'); // devuelve mensaje flash
                redirect(site_url('encuestas'));
            }
        }
    }

    public function get_encuestas_ajax($current_row = null) {
        if ($this->input->is_ajax_request()) { //Sólo se accede al método a través de una petición ajax
            if (!is_null($this->input->post())) { //Se verifica que se haya recibido información por método post
                //aqui va la nueva conexion a la base de datos del buscador
                //Se guarda lo que se busco asi como la matricula de quien realizo la busqueda
                $filtros = $this->input->post();
                $filtros['current_row'] = (isset($current_row) && !empty($current_row)) ? $current_row : 0;

                //pr($filtros);
                $resultado = $this->enc_mod->listado_instrumentos($filtros); //Datos del formulario se envían para generar la consulta segun los filtros
                $data = $filtros;
                $data_menu = $this->template->get_nav();//Obtine rutas de acceso o menus
                $data['secciones_acceso'] = $this->get_modulos_habilitados();
                $data['total_encuestas'] = $resultado['total'];
                $data['encuestas'] = $resultado['data'];
                $data['current_row'] = $filtros['current_row'];
                $data['per_page'] = $this->input->post('per_page');
                //pr($data);
                $this->listado_resultado($data, array('form_recurso' => '#form_listado_encuestas', 'elemento_resultado' => '#listado_resultado')); //Generar listado en caso de obtener datos
            }
        } else {

            redirect(site_url()); //Redirigir al inicio del sistema si se desea acceder al método mediante una petición normal, no ajax
        }
    }

    private function listado_resultado($data, $form) {
        $pagination = $this->template->pagination_data_encuestas($data); //Crear mensaje y links de paginación
        $links = "<div class='col-sm-5 dataTables_info' style='line-height: 50px;'>" . $pagination['total'] . "</div>
                    <div class='col-sm-7 text-right'>" . $pagination['links'] . "</div>";
        echo $links . $this->load->view('encuesta/listado_encuestas', $data, TRUE) . $links . '
                <script>
                $("ul.pagination li a").click(function(event){
                    data_ajax(this, "' . $form['form_recurso'] . '", "' . $form['elemento_resultado'] . '");
                    event.preventDefault();
                });
                </script>';
    }

    public function get_respuesta_esperada_ajax($res_val = null) {
        if ($this->input->is_ajax_request()) { //Sólo se accede al método a través de una petición ajax
            if (!is_null($this->input->post())) { //Se verifica que se haya recibido información por método post
                //aqui va la nueva conexion a la base de datos del buscador
                //Se guarda lo que se busco asi como la matricula de quien realizo la busqueda
                $campos = $this->input->post();

                $respuestas = $this->enc_mod->listado_respuestas_pregunta($campos['pregunta_padre']); //Datos del formulario se envían para generar la consulta segun los filtros
                $data['respuestas'] = dropdown_options($respuestas, 'reactivos_cve', 'texto');
                $data['res_val'] = (isset($res_val)) ? $res_val : '';
                echo $this->load->view('encuesta/respuesta_esperada', $data, TRUE);
            }
        } else {

            redirect(site_url()); //Redirigir al inicio del sistema si se desea acceder al método mediante una petición normal, no ajax
        }
    }

    public function error_tipo_pregunta($instrumento = null) {
        if (!empty($instrumento)) {

            $errores = array('is_error' => FALSE);
            foreach ($instrumento as $pregunta) {
                if (isset($pregunta['tipo_pregunta']['is_error'])) {
                    //echo $pregunta['tipo_pregunta']['desc_error']."<br>";
                    $errores['is_error'] = TRUE;
                    $errores['error'][] = $pregunta;
                }
            }

            return $errores;
        } else {
            redirect(site_url('encuestas'));
        }
    }

    public function verificar_respuesta_padre($instrumento = null, $instrumento_id = null, $no_pregunta_padre = null, $respuesta_esperada = null) {
        if (!empty($instrumento)) {
            $error = TRUE;

            foreach ($instrumento as $row) {
                if ($instrumento_id == md5($row['NOMBRE_INSTRUMENTO'])) {
                    if ($no_pregunta_padre == $row['NO_PREGUNTA']) {
                        if (!empty($row[$respuesta_esperada]) && strtoupper($row[$respuesta_esperada]) == 'SI') {
                            $error = FALSE;
                        }
                    }
                }
            }

            return $error;
        } else {
            redirect(site_url('encuestas'));
        }
    }

    public function validar_registros($row = null) {

        if (!empty($row)) {
            $this->load->library('form_validation');

            $data = json_decode($row, true);
            $this->form_validation->set_data($data);
            $validations = $this->config->item('pregunta_instrumento');

            $this->form_validation->set_rules($validations);

            if ($this->form_validation->run() !== FALSE) {
                $this->form_validation->reset_validation();
                return TRUE;
            } else {

                $errores = array(
                    'NOMBRE_INSTRUMENTO' => form_error('NOMBRE_INSTRUMENTO'),
                    'FOLIO_INSTRUMENTO' => form_error('FOLIO_INSTRUMENTO'),
                    'ROL_A_EVALUAR' => form_error('ROL_A_EVALUAR'),
                    'ROL_EVALUADOR' => form_error('ROL_EVALUADOR'),
                    'TUTORIZADO' => form_error('TUTORIZADO'),
                    'NOMBRE_SECCION' => form_error('NOMBRE_SECCION'),
                    'NOMBRE_INDICADOR' => form_error('NOMBRE_INDICADOR'),
                    'NO_PREGUNTA' => form_error('NO_PREGUNTA'),
                    //'PREGUNTA_PADRE' => form_error('PREGUNTA_PADRE'),
                    //'RESPUESTA_ESPERADA' => form_error('RESPUESTA_ESPERADA'),
                    'PREGUNTA_BONO' => form_error('PREGUNTA_BONO'),
                    'OBLIGADA' => form_error('OBLIGADA'),
                    'PREGUNTA' => form_error('PREGUNTA'),
                    'NO_APLICA' => form_error('NO_APLICA'),
                    'VALIDO_NO_APLICA' => form_error('VALIDO_NO_APLICA'),
                    'NO_ENVIO_MENSAJE' => form_error('NO_ENVIO_MENSAJE'),
                    'SI' => form_error('SI'),
                    'NO' => form_error('NO'),
                    'SIEMPRE' => form_error('SIEMPRE'),
                    'CASI_SIEMPRE' => form_error('CASI_SIEMPRE'),
                    'ALGUNAS_VECES' => form_error('ALGUNAS_VECES'),
                    'CASI_NUNCA' => form_error('CASI_NUNCA'),
                    'NUNCA' => form_error('NUNCA'),
                    'RESPUESTA_ABIERTA' => form_error('RESPUESTA_ABIERTA'),
                    'TIPO_INSTRUMENTO' => form_error('TIPO_INSTRUMENTO'),
                    'EVA_TIPO' => form_error('EVA_TIPO'),
                );

                $this->form_validation->reset_validation();

                return $errores;
            }
        } else {
            redirect(site_url('encuestas'));
        }
    }

    /*
     * Exporta detalles de encuesta, preguntas y opciones de respuesta a archivo XLS. Mismo formato que plantilla utilizada para importación de datos de encuesta
     * @param   $id_instrumento integer Identificador del instrumento a exportar
     * @return  Archivo xls
     */

    public function exportar_xls($id_instrumento = 0) {
        if ($id_instrumento === 0) {
            redirect(site_url('encuestas'));
        }
        $data = $this->enc_mod->exportar_xls_datos($id_instrumento); //Obtener datos
        ////Generación de cabeceras
        $archivo = "Exportar_instrumento_" . date("d-m-Y_H-i-s") . ".xls"; //Nombre de archivo
        header("Content-Type: application/vnd.ms-excel; charset=UTF-8;");
        header("Content-Encoding: UTF-8");
        header("Content-Disposition: attachment; filename=$archivo");
        header("Pragma: no-cache");
        header("Expires: 0");
        echo "\xEF\xBB\xBF"; // UTF-8 BOM. Necesaria para que respete acentos
        echo $this->load->view('encuesta/exportar_xls', $data, TRUE);
    }

    /*
     * Exporta detalles de encuesta, preguntas y opciones de respuesta a archivo PDF.
     * @param   $id_instrumento integer Identificador del instrumento a exportar
     * @return  Archivo pdf
     */

    public function exportar_pdf($id_instrumento = 0) {
        if ($id_instrumento === 0) {
            redirect(site_url('encuestas'));
        }
        $this->load->library('my_dompdf');

        $data = $this->enc_mod->exportar_xls_datos($id_instrumento); //Obtener datos

        $vista = $this->load->view('encuesta/exportar_pdf', $data, TRUE); //Obtener vista

        $this->my_dompdf->convert_html_to_pdf('Exportar_instrumento_' . date("d-m-Y_H-i-s"), $vista); //Exportar a PDF
    }

}
