<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Muestra listado de usuarios y su prefil a encuestar
 * @version   : 1.0.0
 * @autor     : Hilda Trejo
 */
class Encuestausuario extends MY_Controller {

    /**
     * * Carga de clases para el acceso a base de datos y para la creación de elementos del formulario
     * * @access    : public
     * * @modified  :
     */
    public function __construct() {
        parent::__construct();

        $this->load->database();
        $this->load->model('Encuestas_model', 'enc_mod');
        $this->load->model('Curso_model', 'cur_mod'); // modelo de cursos
        $this->load->library('form_validation'); //implemantación de la libreria form validation
        $this->load->library('form_complete'); // form complete
        $this->config->load('form_validation'); // abrir el archivo general de validaciones
        $this->config->load('general'); // instanciamos el archivo de constantes generales
        $this->load->model('Reporte_model', 'rep_mod'); // modelo de reporte
        $this->load->config('general');
    }

    public function instrumento_asignado() {
        if ($this->input->post()) {
            $id_instrumento = $this->input->post('idencuesta');
//            pr($this->input->post());
//if (isset($id_instrumento) && !empty($id_instrumento)) {
            # code...
            $datos['instrumento'] = $this->enc_mod->get_instrumento_detalle($id_instrumento);
            $datos['preguntas'] = $this->enc_mod->preguntas_instrumento($id_instrumento);
            $datos['curso'] = $this->cur_mod->listado_cursos(array('cur_id' => $this->input->post('idcurso', true)));
            $datos['boton'] = TRUE;
            $datos['encuesta_cve'] = $this->input->post('idencuesta', true);
            $datos['evaluado_user_cve'] = $this->input->post('iduevaluado', true);
            $datos['evaluador_user_cve'] = $this->input->post('iduevaluador', true);
            $datos['curso_cve'] = $this->input->post('idcurso', true);
            $datos['des_autoevaluacion_cve'] = $this->input->post('des_autoevaluacion_cve', true);
            $datos['grupo_cve'] = $this->input->post('idgrupo', true);
            if (!is_null($this->input->post('bloque', true))) {
                $datos['bloque'] = $this->input->post('bloque', true);
            }
            if (!is_null($this->input->post('grupos_ids_text', true))) {
                $datos['grupos_ids_text'] = $this->input->post('grupos_ids_text', true);
            }
//pr($datos);
//            $parametrosp = array(
//                'curso_cve' => 838,
//                'grupo_cve' => 11843,
//                'evaluado_user_cve' => 10147,
//                'evaluado_rol_id' => 32,
//                'evaluador_rol_id' => 5,
//                'evaluador_user_cve' => 36138,
//                'encuesta_cve' => 514,
//                'is_bono' => 1)
//            ;
//
//            $promedio = $this->enc_mod->get_promedio_encuesta_encuesta($parametrosp);
////            pr($promedio);

            $main_contet = $this->load->view('encuesta/prev_encur', $datos, true);
            $this->template->setMainContent($main_contet);
            $this->template->getTemplate();
        } else {
            redirect(site_url()); //Redirigir al inicio del sistema si se desea acceder al método mediante una petición normal, no ajax
        }
    }

    public function guardar_encuesta_usuario() {
        if ($this->input->post()) {
            $id_instrumento = $this->input->post('idencuesta', true);
//        pr($this->input->post());
//        exit();
            $campos_evaluacion['encuesta_cve'] = $this->input->post('idencuesta', true);
            $campos_evaluacion['curso_cve'] = $this->input->post('idcurso', true);
            $campos_evaluacion['curso'] = $this->cur_mod->listado_cursos(array('cur_id' => $this->input->post('idcurso', true)));
            $campos_evaluacion['grupo_cve'] = $this->input->post('idgrupo', true);
            $campos_evaluacion['des_autoevaluacion_cve'] = $this->input->post('des_autoevaluacion_cve', true);

            $campos_evaluacion['evaluado_user_cve'] = $this->input->post('iduevaluado', true);
            $campos_evaluacion['evaluador_user_cve'] = $this->input->post('iduevaluador', true);
            $campos_evaluacion['is_bono'] = $this->input->post('is_bono', true);
            if (!is_null($this->input->post('bloque', true))) {
                $campos_evaluacion['bloque'] = $this->input->post('bloque', true);
            }
            if (!is_null($this->input->post('grupos_ids_text', true))) {
                $campos_evaluacion['grupos_ids_text'] = $this->input->post('grupos_ids_text', true);
            }

            //Buscar los roles con las reglas de evaluacion
            $reglas = $this->enc_mod->get_reglas_encuesta($this->input->post('idencuesta', true));
            //pr($reglas);
            $fecha = date('Y-m-d: H:s');
            $campos_evaluacion['evaluado_rol_id'] = $reglas[0]['rol_evaluado_cve'];
            $campos_evaluacion['evaluador_rol_id'] = $reglas[0]['rol_evaluador_cve'];
            $campos_evaluacion['respuesta_abierta'] = '0';
            $campos_evaluacion['fecha'] = $fecha;
            $campos_evaluacion['respuestas_abiertas'] = [];


            $reactivos = $this->input->post('p_r', true);
            $reactivos_preguntas_abiertas = $this->input->post('p_r_text', true);
            $reactivos_preguntas_abiertas_radio = $this->input->post('p_r_radio', true);

            if ($reactivos_preguntas_abiertas != null) {
                foreach ($reactivos_preguntas_abiertas as $key => $value) {
                    $reactivos[$key] = $value;
                }
            }
            if ($reactivos_preguntas_abiertas_radio != null) {
                foreach ($reactivos_preguntas_abiertas_radio as $key => $value) {
                    if (isset($reactivos_preguntas_abiertas_radio[$key])) { //si es radio
                        $reactivos[$key] = $reactivos_preguntas_abiertas_radio[$key];
                    }
                }
            }

            /*
              pr('[CH][Encuestausuario][guardar_encuesta_usuario]reactivos: ');
              pr($reactivos);

              pr($this->input->post());
             *
             */
            $encuesta_cve = $this->input->post('idencuesta', true);
            $busqueda = array('encuesta_cve' => $encuesta_cve);
            //pr($busqueda);

            if ($reactivos) { //Validar que la información se haya enviado por método POST para almacenado
                $reactivos_base = $this->enc_mod->get_preguntas_encuesta($busqueda); //Obtiene las preguntas asociadas a la encuesta
                $campos_evaluacion['reactivos_base'] = $reactivos_base['data'];
                $campos_evaluacion['errores_preguntas_abiertas'] = [];
                /*
                  pr('[CH][Encuestausuario][guardar_encuesta_usuario]$reactivos: ');
                  pr($reactivos);

                  pr('---Reactivos base:');
                  pr($reactivos_base);
                 *
                 */

                $tmp_array_id_preguntas = array();
                $preguntas_abiertas_validas = true;
                foreach ($reactivos_base['data'] as $key => $value) {
                    # code...
                    //$arrpreguntas[]=$value['preguntas_cve'];
                    if ($value["tipo_pregunta_cve"] != 6) {
                        $this->form_validation->set_rules('p_r[' . $value['preguntas_cve'] . ']', 'Pregunta', 'required', array('required' => 'Esta pregunta es requerida'));
                    } else {
                        if (!isset($reactivos_preguntas_abiertas_radio[$value['preguntas_cve']]) && isset($reactivos_preguntas_abiertas[$value['preguntas_cve']]) && trim($reactivos_preguntas_abiertas[$value['preguntas_cve']]) == "") {
                            //pr('falta');
                            $campos_evaluacion['errores_preguntas_abiertas'][$value['preguntas_cve']] = true;
                        } else if (!isset($reactivos_preguntas_abiertas_radio[$value['preguntas_cve']]) && !isset($reactivos_preguntas_abiertas[$value['preguntas_cve']])) {
                            $campos_evaluacion['errores_preguntas_abiertas'][$value['preguntas_cve']] = true;
                        }
                    }
                    $tmp_array_id_preguntas[$value['preguntas_cve']] = $value['orden']; //Relaciona la pregunta con el orden de la pregunta
                }

                foreach ($reactivos as $key => $value) {//Recorre las preguntas que ya fueron contestadas para quitar de la lista
                    if (!empty($value)) {
                        unset($tmp_array_id_preguntas[$key]); //Se elimina la pregunta contestada de la lista de encuestas por contestar
                    }
                }

                $separa_simbolo = '';
                $lista_preguntas_faltantes = '';
                foreach ($tmp_array_id_preguntas as $value) {//Recorre las preguntas no han sido contestadas para ser agregadas a la lista
                    $lista_preguntas_faltantes .= $separa_simbolo . $value; //Carga el orden de las preguntas
                    $separa_simbolo = ', ';
                }
                if (strlen($lista_preguntas_faltantes) > 0) {//Condición para saber si existen preguntas fltantes por responder
                    $campos_evaluacion['mensaje'] = 'Las siguientes preguntas son requeridas: ' . $lista_preguntas_faltantes;
                    $campos_evaluacion['tipo_msj'] = $this->config->item('alert_msg')['DANGER']['class']; //Selecciona el tipo de mensaje
                }

//        pr($this->session->userdata('datos_encuesta_usuario'));
                //pr($this->input->post());
                //Buscar los roles con las reglas de evaluacion
                $reglas = $this->enc_mod->get_reglas_encuesta($encuesta_cve);
                //var_dump($reglas[0]['rol_evaluado_cve']);

                $campos_evaluacion['reactivos'] = $reactivos;
                $campos_evaluacion['reactivos_abiertas'] = $reactivos_preguntas_abiertas;
                $campos_evaluacion['reactivos_abiertas_radio'] = $reactivos_preguntas_abiertas_radio;

                if ($this->form_validation->run() && $preguntas_abiertas_validas) { //Se ejecuta la validación de datos
                    $guardar_evaluacion = $this->enc_mod->guarda_reactivos_evaluacion($campos_evaluacion);
                    if ($guardar_evaluacion) {
                        $datos['tipo_msj'] = $this->config->item('alert_msg')['SUCCESS']['class']; //Selecciona el tipo de mensaje
                        $datos['mensaje'] = 'El registro de la evaluación ha sido guardado correctamente';
                        $datos['idusuario'] = $this->input->post('iduevaluador', true);
                        $datos['idcurso'] = $this->input->post('idcurso', true);
                        $main_contet = $this->load->view('encuesta/final', $datos, true);
                        $this->template->setMainContent($main_contet);
                        $this->template->getTemplate();
                    }
                } else {
                    //echo "entra2";
                    $campos_evaluacion['boton'] = TRUE;
                    $campos_evaluacion['instrumento'] = $this->enc_mod->get_instrumento_detalle($id_instrumento);
                    $campos_evaluacion['preguntas'] = $this->enc_mod->preguntas_instrumento($id_instrumento);
                    $campos_evaluacion['id_instrumento'] = $id_instrumento;
                    //$campos_evaluacion['mensaje']='Todos los campos son requeridos';
                    $main_contet = $this->load->view('encuesta/prev_encur', $campos_evaluacion, true);
                    $this->template->setMainContent($main_contet);
                    $this->template->getTemplate();
                }
            } else {
                //pr($id_instrumento);
                $campos_evaluacion['mensaje'] = 'Por favor responda la encuesta para guardar la evaluación';
                $campos_evaluacion['tipo_msj'] = $this->config->item('alert_msg')['WARNING']['class']; //Selecciona el tipo de mensaje
                $campos_evaluacion['boton'] = TRUE;
                $campos_evaluacion['instrumento'] = $this->enc_mod->get_instrumento_detalle($id_instrumento); //obtiene las posibles respuestas del instrumento
                $campos_evaluacion['preguntas'] = $this->enc_mod->preguntas_instrumento($id_instrumento); //Obtiene las preguntas del instrumento
                $campos_evaluacion['id_instrumento'] = $id_instrumento;
                $main_contet = $this->load->view('encuesta/prev_encur', $campos_evaluacion, true);
                $this->template->setMainContent($main_contet);
                $this->template->getTemplate();
                //redirect(site_url()); //Redirigir al inicio del sistema si se desea acceder al método mediante una petición normal, no ajax
            }
        } else {
            redirect(site_url()); //Redirigir al inicio del sistema si se desea acceder al método sin tener una encuesta asignada
        }
    }

    public function lista_encuesta_usuario() {
        if ($this->input->get() and $this->input->get()['idcurso'] and is_numeric($this->input->get()['idcurso'])) {//
            $data_get = $this->input->get(null, true);
            $idcurso = $data_get['idcurso'];

            $datos = array();

            $idusuario = $this->get_datos_sesion(SessionSIED::ID);
            $datos_curso = $this->cur_mod->get_detalle_curso($idcurso);

            $tutorizado = null;
            if (!empty($datos_curso)) {//Valida que exista el curso en la base de datos
                $tutorizado = $datos_curso[0]['tutorizado'];
                //roles por curso por usuario

                $rolescusercurso = $this->enc_mod->get_roles_usercurso(array('user_id' => $idusuario, 'cur_id' => $idcurso));

                //exit();
                foreach ($rolescusercurso as $key => $value) {

                    //checar reglas validas con encuestas asignadas al curso
                    $reglas_validas = $this->enc_mod->get_reglas_validas_cur(array('role_evaluador' => $value,
                        'tutorizado' => $datos_curso[0]['tutorizado'], 'cur_id' => $idcurso, 'ord_prioridad' => '1'));
                        //pr($reglas_validas);
                    foreach ($reglas_validas as $keyr => $valuer) {

                        $reglasgral[] = array('reglas_evaluacion_cve' => $valuer['reglas_evaluacion_cve'],
                            'rol_evaluado_cve' => $valuer['rol_evaluado_cve'],
                            'encuesta_cve' => $valuer['encuesta_cve'],
                            'eva_tipo' => $valuer['eva_tipo'],
                            'is_bono' => $valuer['is_bono'],
                            'rol_evaluador_cve' => $value,
                        );
                    }
                }
                if (isset($reglasgral)) {//recorre las reglas de evaluación que aplican para el rol, usuario y curso en cuestion
                    /**
                     * 1 por grupo
                     * 2 por bloque Aplica
                     * 3 por usuario
                     */
                    foreach ($reglasgral as $keyrg => $valuerg) {
                        switch (intval($valuerg['eva_tipo'])) {
                            case 1://Por grupo
                                $datos_usuario = $this->enc_mod->get_datos_usuarios(array('user_id' => $idusuario,
                                    'cur_id' => $idcurso, 'rol_evaluado_cve' => $valuerg['rol_evaluado_cve'], 'rol_evaluador_cve' => $valuerg['rol_evaluador_cve']));

//                                pr($datos_usuario);
                                if (isset($datos_usuario) || isset($datos_curso) || !empty($datos_usuario) || !empty($datos_curso)) {
                                    //pr($datos_usuario);
                                    foreach ($datos_usuario as $key => $value1) {

                                        //role evaluador
                                        $role_evaluador = $value1['cve_rol'];
                                        //pr($role_evaluador);
                                        //grupo del evaluador
                                        $gpo_evaluador = $value1['cve_grupo']; # code...
                                        //pr($gpo_evaluador);

                                        $datos_user_aeva[] = $this->enc_mod->listado_eval(array('gpo_evaluador' => $gpo_evaluador, 'role_evaluado' => $valuerg['rol_evaluado_cve'],
                                            'cur_id' => $idcurso, 'encuesta_cve' => $valuerg['encuesta_cve'],
                                            'evaluador_user_cve' => $idusuario,
                                            'role_evaluador' => $role_evaluador, 'eva_tipo' => $valuer['eva_tipo'])
                                        );
                                    }
                                }
                                break;
                            case 2://Por bloque
                                //echo "entra2";//por bloque   # code...
                                $datos_usuario_bloque = $this->enc_mod->get_datos_usuarios_bloque(array('user_id' => $idusuario,
                                    'cur_id' => $idcurso,
                                    'rol_evaluado_cve' => $valuerg['rol_evaluado_cve'],
                                    'rol_evaluador_cve' => $valuerg['rol_evaluador_cve'],
                                ));
                                if (isset($datos_usuario_bloque) || isset($datos_curso) || !empty($datos_usuario_bloque) || !empty($datos_curso)) {
                                    foreach ($datos_usuario_bloque as $key_ub => $usu_blo) {//genera index por rol y bloque de los usuarios que pertenecen a los bloques
                                        $dato_ub[$usu_blo['cve_rol']][$usu_blo['bloque']][] = $usu_blo;
                                    }
                                    foreach ($dato_ub as $keyb_r => $valueb_r) {//Recorre roles
                                        foreach ($valueb_r as $keyb_b => $valueb_b) {//Recorre bloques
                                            $role_evaluador = $keyb_r;
                                            $bloque_evaluador = $keyb_b; # code...


                                            $grupos_ids = NULL;
                                            foreach ($valueb_b as $key_data => $value_data) {//Genera cadenas de grupos que pertenecen a un grupo
                                                $grupos_ids .= $value_data['cve_grupo'] . ',';
                                            }

                                            //pr($grupos_ids);
                                            $datos_user_aeva[] = $this->enc_mod->listado_eval(array('bloque_evaluador' => $bloque_evaluador,
                                                'role_evaluado' => $valuerg['rol_evaluado_cve'],
                                                'cur_id' => $idcurso, 'encuesta_cve' => $valuerg['encuesta_cve'],
                                                'evaluador_user_cve' => $idusuario,
                                                'role_evaluador' => $role_evaluador, 'eva_tipo' => $valuer['eva_tipo'],
                                                'grupos' => trim($grupos_ids, ','))
                                            );
                                        }
                                    }
//                                    $this->session->set_userdata(array('datos_encuesta_usuario' => $datos_user_aeva));
                                }
                                break;
                            default://Por usuario
                                $datos_user_aeva[] = $this->enc_mod->listado_eval(array('role_evaluado' => $valuerg['rol_evaluado_cve'],
                                    'cur_id' => $idcurso, 'encuesta_cve' => $valuerg['encuesta_cve'],
                                    'evaluador_user_cve' => $idusuario, 'role_evaluador' => $valuerg['rol_evaluador_cve']));
                        }
                    }
                    if (isset($datos_user_aeva)) {
                        $datos['datos_user_aeva'] = $datos_user_aeva;
                    }
                }

                $datos['datos_curso'] = $datos_curso;
                $datos['iduevaluador'] = $idusuario;

                $datos_usuario_evaluador = $this->enc_mod->get_datos_usuarios_gral(array('user_id' => $idusuario));

                $nombreevaluador = $datos_usuario_evaluador[0]['nombres'] . ' ' . $datos_usuario_evaluador[0]['apellidos'];
                $datos['nombreevaluador'] = $nombreevaluador;


                /*                 * *********** Crear contador de contador de encuestas *********** */
                if (isset($datos['datos_user_aeva'])) {
                    // pr($datos['datos_user_aeva'] );
                    //$this->enc_mod->crear_contador_encuestas($idusuario, $idcurso, $datos['datos_user_aeva']);
                    $this->enc_mod->upsert_contador_encuestas($idusuario, $idcurso, $datos['datos_user_aeva']);
                //    pr($this->input->server('HTTP_USER_AGENT'));
                }
                /*                 * ***************************** ********************************* */
                $main_contet = $this->load->view('encuesta/lista_usuarios', $datos, true);
                $this->template->setMainContent($main_contet);
                $this->template->getTemplate();
            }
        }

        $sections = array(
            'config' => TRUE,
            'queries' => TRUE
        );
        // $this->output->set_profiler_sections($sections);
        // $this->output->enable_profiler(TRUE);
    }

//    public function lista_encuesta_usuario() {
//        if ($this->input->get()) {
//            $data_get = $this->input->get(null, true);
////                pr($data_get);
//            $idusuario = $this->get_datos_sesion(SessionSIED::ID);
////            $idusuario = $data_get['iduser'];
//            $idcurso = $data_get['idcurso'];
//            $sesion_valida = valida_sesion_activa($idusuario);
//            if ($sesion_valida) {
//                $this->session->unset_userdata('datos_encuesta_usuario'); //Eliminar la variable ya que puedequedara cargada con datos de otro curso
//
//                $datos = array();
//
//                $datos_curso = $this->cur_mod->listado_cursos(array('cur_id' => $idcurso));
//                $tutorizado = null;
//                if (!empty($datos_curso['data'])) {
//                    $tutorizado = $datos_curso['data'][0]['tutorizado'];
//                }
//                //roles por curso por usuario
//                $rolescusercurso = $this->enc_mod->get_roles_usercurso(array('user_id' => $idusuario, 'cur_id' => $idcurso));
//
//                //exit();
//                foreach ($rolescusercurso as $key => $value) {
//
//                    //checar reglas validas con encuestas asignadas al curso
//                    //pr($value);
//
//                    $reglas_validas = $this->enc_mod->get_reglas_validas_cur(array('role_evaluador' => $value,
//                        'tutorizado' => $datos_curso['data'][0]['tutorizado'], 'cur_id' => $idcurso, 'ord_prioridad' => '1'));
//
//                    //pr($reglas_validas);
//                    foreach ($reglas_validas as $keyr => $valuer) {
//
//                        $reglasgral[] = array('reglas_evaluacion_cve' => $valuer['reglas_evaluacion_cve'],
//                            'rol_evaluado_cve' => $valuer['rol_evaluado_cve'],
//                            'encuesta_cve' => $valuer['encuesta_cve'],
//                            'eva_tipo' => $valuer['eva_tipo'],
//                            'is_bono' => $valuer['is_bono'],
//                            'rol_evaluador_cve' => $value,
//                        );
//                    }
//                }
////                pr($reglas_validas);
////                pr($reglasgral);
//                if (isset($reglasgral)) {
//                    foreach ($reglasgral as $keyrg => $valuerg) {
//
//                        //pr($valuerg['encuesta_cve']);
//                        //echo $valuer['encuesta_cve'];
//
//
//                        if ($valuerg['eva_tipo'] == 1) {//Por grupo
//                            //echo "entra";
//                            //por grupo
//                            $datos_usuario = $this->enc_mod->get_datos_usuarios(array('user_id' => $idusuario,
//                                'cur_id' => $idcurso, 'rol_evaluado_cve' => $valuerg['rol_evaluado_cve'], 'rol_evaluador_cve' => $valuerg['rol_evaluador_cve']));
//
////                                pr($datos_usuario);
//                            if (isset($datos_usuario) || isset($datos_curso) || !empty($datos_usuario) || !empty($datos_curso)) {
//                                //pr($datos_usuario);
//                                foreach ($datos_usuario as $key => $value1) {
//
//                                    //role evaluador
//                                    $role_evaluador = $value1['cve_rol'];
//                                    //pr($role_evaluador);
//                                    //grupo del evaluador
//                                    $gpo_evaluador = $value1['cve_grupo']; # code...
//                                    //pr($gpo_evaluador);
//
//                                    $datos_user_aeva[] = $this->enc_mod->listado_eval(array('gpo_evaluador' => $gpo_evaluador, 'role_evaluado' => $valuerg['rol_evaluado_cve'],
//                                        'cur_id' => $idcurso, 'encuesta_cve' => $valuerg['encuesta_cve'],
//                                        'evaluador_user_cve' => $idusuario,
//                                        'role_evaluador' => $role_evaluador, 'eva_tipo' => $valuer['eva_tipo'])
//                                    );
//                                }
//                            }
//                        } elseif ($valuerg['eva_tipo'] == 2) {//Por bloque
//                            //echo "entra2";//por bloque   # code...
//                            $datos_usuario_bloque = $this->enc_mod->get_datos_usuarios_bloque(array('user_id' => $idusuario,
//                                'cur_id' => $idcurso,
//                                'rol_evaluado_cve' => $valuerg['rol_evaluado_cve'],
//                                'rol_evaluador_cve' => $valuerg['rol_evaluador_cve'],
//                            ));
//                            // pr('-----------------*****************------------------------');
////                            pr($datos_usuario_bloque);
//
//                            if (isset($datos_usuario_bloque) || isset($datos_curso) || !empty($datos_usuario_bloque) || !empty($datos_curso)) {
//                                foreach ($datos_usuario_bloque as $key_ub => $usu_blo) {//genera index por rol y bloque de los usuarios que pertenecen a los bloques
//                                    $dato_ub[$usu_blo['cve_rol']][$usu_blo['bloque']][] = $usu_blo;
//                                }
//                                //pr($dato_ub);
//                                foreach ($dato_ub as $keyb_r => $valueb_r) {//Recorre roles
//                                    foreach ($valueb_r as $keyb_b => $valueb_b) {//Recorre bloques
////                                        pr($valueb_b);
////                                        pr($dato_ub);
//                                        $role_evaluador = $keyb_r;
//                                        $bloque_evaluador = $keyb_b; # code...
//
//
//                                        $grupos_ids = NULL;
//                                        foreach ($valueb_b as $key_data => $value_data) {//Genera cadenas de grupos que pertenecen a un grupo
//                                            $grupos_ids .= $value_data['cve_grupo'] . ',';
//                                        }
//
//                                        //pr($grupos_ids);
//                                        $datos_user_aeva[] = $this->enc_mod->listado_eval(array('bloque_evaluador' => $bloque_evaluador,
//                                            'role_evaluado' => $valuerg['rol_evaluado_cve'],
//                                            'cur_id' => $idcurso, 'encuesta_cve' => $valuerg['encuesta_cve'],
//                                            'evaluador_user_cve' => $idusuario,
//                                            'role_evaluador' => $role_evaluador, 'eva_tipo' => $valuer['eva_tipo'],
//                                            'grupos' => trim($grupos_ids, ','))
//                                        );
//
//
//                                        //pr($datos_user_aeva);
//                                        /* if(!is_null($grupos_ids)){
//                                          $this->enc_mod->listado_eval_update_grupo(array('conditions'=>'encuesta_cve='.$valuer['encuesta_cve'].' AND
//                                          course_cve='.$idcurso.' AND evaluador_rol_id='.$value.' AND evaluado_rol_id='.$role_evaluador,
//                                          'fields'=>array('grupos_ids_text'=>trim($grupos_ids, ',')))); //Actualizar grupos
//                                          } */
//                                    }
//                                }
//                                $this->session->set_userdata(array('datos_encuesta_usuario' => $datos_user_aeva));
//                                //pr($this->session->userdata());
//                                /* foreach ($datos_usuario_bloque as $keyb => $valueb) {
//
//
//                                  $role_evaluador = $valueb['cve_rol'];
//                                  $bloque_evaluador = $valueb['bloque']; # code...
//
//
//                                  $datos_user_aeva[] = $this->enc_mod->listado_eval(array('bloque_evaluador' => $bloque_evaluador,
//                                  'role_evaluado' => $valuerg['rol_evaluado_cve'],
//                                  'cur_id' => $idcurso, 'encuesta_cve' => $valuer['encuesta_cve'],
//                                  'evaluador_user_cve' => $idusuario,
//                                  'role_evaluador' => $role_evaluador,'eva_tipo' => $valuer['eva_tipo']));
//
//                                  } */
//                            }
//                        } else {//Por usuario
//                            //echo "entra3";
//                            //echo $valuer['encuesta_cve'];   //por usuario
//                            //echo $value;
//                            $datos_user_aeva[] = $this->enc_mod->listado_eval(array('role_evaluado' => $valuerg['rol_evaluado_cve'],
//                                'cur_id' => $idcurso, 'encuesta_cve' => $valuerg['encuesta_cve'],
//                                'evaluador_user_cve' => $idusuario, 'role_evaluador' => $valuerg['rol_evaluador_cve']));
//                        }
//
//
//                        # code...
//                    }
//                    //pr($datos_user_aeva);
//                    if (isset($datos_user_aeva)) {
//                        $datos['datos_user_aeva'] = $datos_user_aeva;
//                    }
//                }
//
//                //pr($datos_user_aeva);
//                # code...
//                //}
//                //pr('--------------------------------------------------------------------');
//                //pr($datos_user_aeva);
//                //pr($datos['datos_user_aeva']);
//                $datos['datos_curso'] = $datos_curso;
//                //$datos['datos_usuario']=$datos_usuario;
//                //$datos['datos_user_aeva'];
//                //pr( $datos);
//                $datos['iduevaluador'] = $idusuario;
//
//
//
//
//                # code...
//            } else {//Muestra mensaje que no hay permisos
//                if (isset($data_get['token'])) {
//                    $datos['coment_general'] = 'El usuario actual no cuenta con permisos para ver el curso actual. '
//                            . '<br><br>Por favor verifique la ruta o inicie sesión nuevamente ';
//                } else {
////                    redirect('login/logeo/' . $idusuario . '/' . $idcurso);
//                }
//            }
//
//            $datos_usuario_evaluador = $this->enc_mod->get_datos_usuarios_gral(array('user_id' => $idusuario));
//
//
//
//            //$listado_autoeval = $this->enc_mod->get_usuariosasig_aevaluar(array('user_id' => $idusuario,'cur_id' => $idcurso,'tutorizado' =>$datos_curso['data'][0]['tutorizado']));
//            //$datos['listado_autoeval'] = $listado_autoeval;
//
//
//            $nombreevaluador = $datos_usuario_evaluador[0]['nombres'] . ' ' . $datos_usuario_evaluador[0]['apellidos'];
//            $datos['nombreevaluador'] = $nombreevaluador;
//
//            $main_contet = $this->load->view('encuesta/lista_usuarios', $datos, true);
//            $this->template->setMainContent($main_contet);
//            $this->template->getTemplate();
//        }
//
//        $sections = array(
//            'config' => TRUE,
//            'queries' => TRUE
//        );
//        $this->output->set_profiler_sections($sections);
//        $this->output->enable_profiler(TRUE);
//    }
}
