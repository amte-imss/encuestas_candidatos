<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase que gestiona el login
 * @version 	: 1.0.0
 * @autor 		: Jesús Díaz P. & Pablo José
 */
class Login extends MY_Controller {

    /**
     * * Carga de clases para el acceso a base de datos y para la creación de elementos del formulario
     * * @access 		: public
     * * @modified 	:
     */
    public function __construct() {
        parent::__construct();

        $this->load->database();
        $this->load->helper(array('form', 'captcha'));
        $this->load->library('form_complete');
        $this->load->library('form_validation');
        //$this->load->library('Bitacora');
        $this->load->model('Encuestas_model', 'enc_mod');
        $this->load->model('Login_model', 'lm');
        $this->config->load('general');
    }

    public function roles($id = NULL) {
        $roles = $this->enc_mod->get_roles_usercurso(array('user_id' => $id)); //Obtiene roles del usuario
        $array_modulos = $this->lm->get_modulos_sesion(array('roles' => $roles)); //Obtiene todos los accesos de los roles relacionados
        $modulos_acceso = transformar_modulos($array_modulos);
        pr($modulos_acceso);
        $this->session->set_userdata('modulos_acceso', $modulos_acceso);
        pr(permiso_acceso_modulo(En_modulos::EXPORTA_INSTRUMENTO_PDF));
    }

    private function transformar_modulos($modulos_rol) {
        if (!is_array($modulos_rol)) {//Si no es un array, retorna null
            return null; //
        }
        $array_result = array();
        foreach ($modulos_rol as $valores) {
            $array_result[$valores['modulo_cve']] = $valores;
        }
        return $array_result;
    }

    public function logeo($id = NULL, $curseid = NULL) {
//        pr($this->session->userdata());
        //     exit();
        $url_sied = $this->config->item('url_sied');
        if (is_numeric($id)) {
            $existe_session = sesion_iniciada();
//                pr('sses ' . $existe_session);
//                exit();
            if ($existe_session) {//Pregunta si existe alguna sección activa
                $sesion_valida = valida_sesion_activa($id);
                if ($sesion_valida) {
                    redirect('encuestas/index');
                } else {
                    //echo 'entra';
                    $this->session->sess_destroy();
                    redirect($url_sied);
                    //redirect('http://11.32.41.13/kio/sied');
                }
            } else {
                $usuario = $this->enc_mod->usuario_existe($id);
                if (isset($usuario)) {
                    $token = md5(uniqid(rand(), TRUE));
                    //******Modulos de acceso *****
                    $roles = $this->enc_mod->get_roles_usercurso(array('user_id' => $id)); //Obtiene roles del usuario
                    $is_admin_sied = $this->lm->get_is_user_admin_sied($id); //Obtiene todos los accesos de los roles relacionados
                    if ($is_admin_sied) {
                        $roles[] = 1; //Agrega el rol administrador, si es un administrador de sied
                    }

                    $array_modulos = $this->lm->get_modulos_sesion(array('roles' => $roles)); //Obtiene todos los accesos de los roles relacionados

                    $modulos_acceso = transformar_modulos($array_modulos);
//                    pr($modulos_acceso);
//                    exit();
                    //*****************************
                    $usuario_data['encuestas_die'] = array(
                        'id' => $usuario->id,
                        'nombre' => $usuario->nombre . ' ' . $usuario->apellidos,
                        'logueado' => TRUE,
                        'token' => $token,
                        'modulos_acceso' => $modulos_acceso['modulos'], //Carga los modulos de accesos
                        'secciones_acceso' => $modulos_acceso['secciones']//Carga las secciones de acceso del docente
                    );
                    //pr($usuario_data);
                    $this->session->set_userdata($usuario_data);
                    if (is_null($curseid)) {
                        //redirect('encuestas/index');
                        redirect('inicio/index');
                    } else {
                        redirect('encuestausuario/lista_encuesta_usuario?iduser=' . $id . '&idcurso=' . $curseid . '&token=550');
                    }
                } else {
                    $this->session->sess_destroy();
                    redirect($url_sied);
                    //redirect('http://11.32.41.13/kio/sied');
                }
            }
        } else {
            redirect($url_sied);
        }
    }

    private function checkbrute($matricula) {
        $ahora = time(); ///Tiempo actual

        $lapso_intentos = $this->config->item('tiempo_fuerza_bruta');
        $intentos_default_fuerza_bruta = $this->config->item('intentos_fuerza_bruta');
        $numero_intentos_usuario = $this->lm->set_checkbrute_usuario($matricula, $lapso_intentos);
//        $numero_intentos_usuario = 1;
        if ($numero_intentos_usuario > $intentos_default_fuerza_bruta) {
            return true;
        } else {
            return false;
        }
    }

    private function matricula_formato($matricula) {
        return hash('sha512', $matricula);
    }

    private function contrasenia_formato($matricula, $contrasenia) {
        return hash('sha512', $contrasenia . $matricula);
    }

    private function formulario($error = "") {
        $data['error'] = $error;
        $data['captcha'] = create_captcha($this->captcha_config());
        $this->session->set_userdata('captchaWord', $data['captcha']['word']);
        //echo $data['token'] = $this->session->userdata('token'); //Se envia token al formulario
        $form_login = $this->load->view('login/formulario', $data, TRUE);
        return $form_login;
    }

    private function token() {
        $token = md5(uniqid(rand(), TRUE));
        $this->session->set_userdata('token', $token);
        return;
    }

    public function cerrar_session($eduDist = null) {
        $this->session->sess_destroy();
        if (is_null($eduDist)) {
            $url_redirect = $this->redirecciona_sied();
        } else {
            $url_redirect = $this->redirecciona_moodle();
        }
        //session_destroy();
        //redirect('login');
        redirect($url_redirect);
        exit();
    }

    public function regresar_sied() {
        $this->redirecciona_sied();
    }

}
